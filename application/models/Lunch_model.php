<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lunch_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }

    public function get_lunch_info($status,$date)
    {

        $this->db->select('
                    u.user_id as emp_id, 
                    u.first_name, 
                    u.status, 
                    u.last_name, 
                    at.status as p_stutus
                ');
            $this->db->from('xin_employees as u');
            $this->db->join('xin_attendance_time as at', 'u.user_id = at.employee_id', 'left');
            $this->db->where('at.attendance_date', $date);
            $this->db->where('u.active_lunch', 1)->group_by('u.user_id');
            $data = $this->db->order_by('at.status', 'DESC')->get()->result();

        if ($status == true) {
            foreach ($data as $key => $row) {
                $this->db->select('lunch_id, meal_amount, comment');
                $this->db->from('lunch_details')->where('date', $date)->where('emp_id', $row->emp_id);
                $data2 = $this->db->group_by('emp_id')->order_by('p_stutus', 'DESC')->get()->row();
                @$data[$key]->meal_amount = $data2->meal_amount;
                @$data[$key]->comment = $data2->comment;
                @$data[$key]->lunch_id = $data2->lunch_id;
            }
        }
        foreach ($data as $k => $r) {
            if ($r->status == 2 || $r->status == 3) {
                
                $this->db->select('effective_date');
                $this->db->from('xin_employee_left_resign');
                $this->db->where('emp_id', $r->emp_id);
                $resign_data = $this->db->get()->row();
                // If the employee has resigned and effective date is before $date, remove from array
                if ($resign_data && $resign_data->effective_date < $date) {
                    // dd($resign_data);
                    unset($data[$k]);
                }
            }
        }
        
        return $data;
    }
    public function all_employees($date)
    {
        $query = $this->db->query("SELECT * FROM xin_employees");
        return $query->result();
    }

    public function process($firstDate, $secondDate, $probable_date)
    {

        $query = $this->all_employees($firstDate);

        foreach($query as $row){
            $emp_id = $row->user_id;
            $doj = $row->date_of_joining;

            $last_working_data=$this->db->where('emp_id', $emp_id)->order_by('effective_date', 'DESC')->limit(1)->get('xin_employee_left_resign')->row();
//dd($last_working_data->effective_date.' < '.$firstDate);
            if (!empty($last_working_data)) {
                $last_working_date=$last_working_data->effective_date;
                if ($last_working_date < $firstDate) {
                  continue;
                }
            }
           // dd('here');
            $this->db->select('meal_amount,date');
            $this->db->where('date >=', $firstDate);
            $this->db->where('date <=', $secondDate);
            $this->db->where('emp_id', $emp_id);
            $result = $this->db->get('lunch_details')->result();
            //dd($result);
           
            
            $prev_meal=0;
            $prev_cost=0;
            $lunch_package=0;
            $datar=[];
            foreach($result as  $lu){
                $lunch_package= lunch_package($lu->date);                
                $prev_meal+=$lu->meal_amount; 
                $prev_cost+=$lu->meal_amount*$lunch_package->stuf_give_tk;
            }


            $prev_pay=0;
            $this->db->where('emp_id', $row->user_id);
            $this->db->where('end_date', date('Y-m-d', strtotime($firstDate . ' -1 day')));
            
            $preepay= $this->db->get('lunch_payment')->result();
            //dd($preepay);
           

            if (count($preepay)>0 && $preepay[0]->status==1){
                $prev_pay+=$preepay[0]->pay_amount;
            };

            $prev_amount=$prev_pay-$prev_cost;
            
            
            if ($row->active_lunch==1 && empty($last_working_data)) {
                //dd('here');
                $probable_meal = $this->chackprobalemeal($secondDate, $probable_date, $emp_id, $doj);
                $lunch_package_latest= lunch_package(date('Y-m-d', strtotime($secondDate . ' +1 day')));
                $pay_amount=$probable_meal*$lunch_package_latest->stuf_give_tk;
                $collection_amount=$pay_amount-$prev_amount;
                $status = 0;
            }else{
                //dd('here_not');
                $probable_meal=0;
                if ($prev_amount==0) {
                    continue;
                }elseif($prev_amount>0){
                    $pay_amount=$prev_amount*(-1);
                    $collection_amount=$prev_amount*(-1);
                    $status = 0;
                    
                }else{
                    $pay_amount=$prev_amount;
                    $collection_amount=$prev_amount;
                    $status = 0;
                }
            }
            $from_date=$firstDate;
            $end_date=$secondDate;
            $data = array(
                'emp_id' => $emp_id,
                'prev_meal' => $prev_meal,
                'prev_cost' => $prev_cost,
                'prev_pay' => $prev_pay,
                'prev_amount' => $prev_amount,
                'pay_amount' => $pay_amount,
                'probable_meal' => $probable_meal,
                'collection_amount' => $collection_amount,
                'from_date' => $from_date,
                'end_date' => $end_date,
                'next_date' => $probable_date,
                'status' => $status
            );
            // if($emp_id==58){
            //     dd($data);
            // }

            $this->db->where('from_date', $firstDate);
            $this->db->where('end_date', $secondDate);
            $this->db->where('emp_id', $row->user_id);
            $rc = $this->db->get('lunch_payment');

            if ($rc->num_rows() > 0) {
                $r = $rc->row();
                $data['status'] = $r->status;
                $data['pay_amount'] = $r->pay_amount;
                $data['collection_amount'] = $r->collection_amount;

                $this->db->where('id', $r->id);
                $this->db->update('lunch_payment', $data);
            } else {
                $this->db->insert('lunch_payment', $data);
            }

        }

    }

    public function chackprobalemeal($first_date, $second_date, $emp_id = null, $doj = null) {
        // First 3 days not meal provide to New joining man power 
        if ($first_date <= $doj) {
           $first_date = date("Y-m-d", strtotime("+ 3 day", strtotime($doj)));
        } 

        $date1 = new DateTime($first_date);
        $date2 = new DateTime($second_date);
        $interval = $date1->diff($date2);
        $count = ($interval->days);
        //dd($count);
        $total_day = 1;

        $off_day = array('Friday','Saturday');
        for ($i=0; $i < $count; $i++) { 

            $process_date = date("Y-m-d", strtotime("+{$i} day", strtotime($first_date)));
            $day = date("l", strtotime($process_date));

            if (in_array($day, $off_day)) {
                $total_day = $total_day + 1;
            }else{
                $this->db->where("start_date <=", $process_date);
                $this->db->where("end_date >=", $process_date);
                $query = $this->db->get("xin_holidays")->num_rows();
                if ($query > 0) { 
                    $total_day = $total_day + 1;
                }
            }
        }

        return $count - $total_day;
    }
    
    public function employees($id)
    {
        $query = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $id ");
        return $query->result();
    }

    public function paymentreport($status =null)
    {
        $last_prement= $this->db->query("SELECT * FROM `lunch_payment` ORDER BY id DESC LIMIT 1")->row();
        $this->db->select('xin_employees.first_name, xin_employees.last_name, lunch_payment.*');
        $this->db->join('xin_employees', 'lunch_payment.emp_id = xin_employees.user_id');
        $this->db->where('lunch_payment.end_date', $last_prement->end_date);
        $this->db->where('xin_employees.active_lunch', 1);
        if ($status == 0 || $status == 1) {
            $this->db->where('lunch_payment.status', $status);
        }
        $result = $this->db->get('lunch_payment')->result();
        // dd($last_prement->end_date);
        return $result;
    }
    public function prever_report($date)
    {
        $this->db->select('xin_employees.first_name, xin_employees.last_name, lunch_payment.*');
        $this->db->join('xin_employees', 'lunch_payment.emp_id = xin_employees.user_id');
        $this->db->where('lunch_payment.end_date', $date);
        $result = $this->db->get('lunch_payment')->result();
        return $result;
    }
    
    public function getpay($id)
    {
        $query = $this->db->query("SELECT * FROM lunch_payment WHERE user_id = $id ");
        return $query->result();
    }
    
    public function add_lunch_details($lastId, $empid, $m_amount, $p_status, $comment, $guest_m, $guest_comment, $date)
    {
        foreach ($empid as $i => $eid) {
            $data = array(
                'lunch_id' => $lastId,
                'emp_id' => $eid,
                'meal_amount' => $m_amount[$i],
                'p_stutus' => $p_status[$i],
                'comment' => $comment[$i],
                'date' => $date,
            );
            $this->db->insert('lunch_details', $data);
        }
        
        $data = array(
            'lunch_id' => $lastId,
            'emp_id' => 1,
            'meal_amount' => $guest_m,
            'p_stutus' => 'guest',
            'comment' => $guest_comment,
            'date' => $date,
        );
        $this->db->insert('lunch_details', $data);
    }
    
    public function add_lunch_update($luncid, $empid, $m_amount, $p_status, $comment, $guest_m, $guest_comment, $date)
    {
        foreach ($empid as $i => $eid) {
            $data = array(
                'meal_amount' => $m_amount[$i],
                'comment' => $comment[$i],
            );
            $this->db->where('lunch_id', $luncid);
            $this->db->where('emp_id', $eid);
            $this->db->update('lunch_details', $data);
        }
    
        $data = array(
            'meal_amount' => $guest_m,
            'comment' => $guest_comment,
        );
        $this->db->where('lunch_id', $luncid);
        $this->db->where('emp_id', 1);
        $this->db->update('lunch_details', $data);
    }
    
    public function daily_report($attendance_date)
    {
        $this->db->select('xin_attendance_time.employee_id, xin_attendance_time.attendance_date');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_attendance_time.attendance_date", $attendance_date);
        $this->db->where("xin_attendance_time.status", 'Present');
        $data = $this->db->get()->result();
    
        if ($data) {
            return $data;
        } else {
            return 0;
        }
    }  

    public function get_all_data() {
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get('lunch');
        return $query->result();
    }
    

  
    public function get_lunch_data($first_date,$second_date) {
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $result = $this->db->get('lunch')->result();
        return $result;
    }

    public function get_lunch_details($first_date, $second_date, $emp_ids) {
            $this->db->select('lunch_details.id,lunch_details.emp_id, lunch_details.lunch_id, lunch_details.meal_amount, lunch_details.p_stutus, lunch_details.comment, lunch_details.date, xin_employees.first_name, xin_employees.last_name');
            $this->db->from('lunch_details');
            $this->db->join('xin_employees', 'xin_employees.user_id = lunch_details.emp_id');
            $this->db->where_in('lunch_details.emp_id', $emp_ids);
            $this->db->where('date >=', $first_date);
            $this->db->where('date <=', $second_date);
            return $this->db->get()->result();
    }

    public function get_lunch_details_active($first_date, $second_date, $emp_ids) {
            $this->db->select('lunch_details.id,lunch_details.emp_id, lunch_details.lunch_id, lunch_details.meal_amount, lunch_details.p_stutus, lunch_details.comment, lunch_details.date, xin_employees.first_name, xin_employees.last_name');
            $this->db->from('lunch_details');
            $this->db->join('xin_employees', 'xin_employees.user_id = lunch_details.emp_id');
            $this->db->where_in('lunch_details.emp_id', $emp_ids);
            $this->db->where('date >=', $first_date);
            $this->db->where('date <=', $second_date);
            $this->db->where('meal_amount >=', 1);
            return $this->db->get()->result();
    }

    public function get_lunch_details_inactive($first_date, $second_date, $emp_ids) {
            $this->db->select('lunch_details.id,lunch_details.emp_id, lunch_details.lunch_id, lunch_details.meal_amount, lunch_details.p_stutus, lunch_details.comment, lunch_details.date, xin_employees.first_name, xin_employees.last_name');
            $this->db->from('lunch_details');
            $this->db->join('xin_employees', 'xin_employees.user_id = lunch_details.emp_id');
            $this->db->where_in('lunch_details.emp_id', $emp_ids);
            $this->db->where('date >=', $first_date);
            $this->db->where('date <=', $second_date);
            $this->db->where('meal_amount<=', 0);
            return $this->db->get()->result();
    }

    public function get_meal($emp_id,$date) {
            $this->db->select('lunch_details.id,lunch_details.emp_id, lunch_details.lunch_id, lunch_details.meal_amount, lunch_details.p_stutus, lunch_details.comment, lunch_details.date');
            $this->db->from('lunch_details');
            $this->db->where('lunch_details.emp_id', $emp_id);
            $this->db->where('date ', $date);
            return $this->db->get()->result();
    }

    public function get_proccess_data($emp_id,$first_date, $second_date) {
            $this->db->select('lunch_details.id,lunch_details.emp_id, lunch_details.lunch_id, lunch_details.meal_amount, lunch_details.p_stutus, lunch_details.comment, lunch_details.date');
            $this->db->from('lunch_details');
            $this->db->where('lunch_details.emp_id', $emp_id);
            $this->db->where('date >=', $first_date);
            $this->db->where('date <=', $second_date);
            return $this->db->get()->result();
    }
    
    public  function holiday_check($first_date,$second_date)
    {
            $this->db->where("start_date <=", $first_date);
            $this->db->where("end_date >=", $second_date);
            $query = $this->db->get("xin_holidays");
            if($query->num_rows() > 0 ){
                return true;
            } else {
                return false;
            }
    } 
    public function chack_meal($first_date,$second_date){
        $this->db->select('*');
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $data = $this->db->get('lunch_vendor_meal')->result();
        if (count($data) > 0) {
            $total_m=0;
            $total_am=0;
            
            foreach($data as $m){
                $lunch_package=lunch_package($m->date);

                $total_m+=$m->meal_qty;
                $total_am+=$m->meal_qty*$lunch_package->permeal;
            }
            $data['total_m']=$total_m;
            $data['total_am']=$total_am;

            return $data;
          
        }else{
            $data['total_m']=0;
            $data['total_am']=0;
            return $data ;
        }
    } 
    public function chack_meal_employee($first_date,$second_date){
        $this->db->select('*');
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $data = $this->db->get('lunch')->result();
        if (count($data) > 0) {
            $total_m = 0;
            $total_emp_m = 0;
            $total_emp_cost = 0;
            $total_ge_m = 0;
            $total_ge_cost = 0;
            $total_cost = 0;
        
            foreach ($data as $m) {
                $total_m += $m->total_m;
                $total_emp_m += $m->emp_m;
                $total_emp_cost += $m->emp_cost;
                $total_ge_m += $m->guest_m;
                $total_ge_cost += $m->guest_cost;
                $total_cost += $m->total_cost;
            }
        
            $result = [
                'total_m' => $total_m,
                'total_emp_m' => $total_emp_m,
                'total_emp_cost' => $total_emp_cost,
                'total_ge_m' => $total_ge_m,
                'total_ge_cost' => $total_ge_cost,
                'total_cost' => $total_cost,
                'first_date' => $first_date,
                'second_date' => $second_date
            ];
        } else {
            $result = [
                'total_m' => 0,
                'total_emp_m' => 0,
                'total_emp_cost' => 0,
                'total_ge_m' => 0,
                'total_ge_cost' => 0,
                'total_cost' => 0,
                'first_date' => $first_date,
                'second_date' => $second_date
            ];
        }
        return $result;
        
    } 

    public function chack_meal_data($first_date, $second_date) {
        $this->db->select('*');
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->order_by('date', 'desc');
        $data = $this->db->get('lunch_vendor_meal')->result();
        return $data;
    }
    
    
    public function vendor_status_report($first_date,$second_date){
        $this->db->select('*');
        $this->db->where('date >=', $first_date);
        $this->db->where('date <=', $second_date);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('lunch_payment_vendor');
        $data = $query->result();
         
        if ($query->num_rows() > 0) {
         return $data;
     
     } else {
         return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
     }
       
    }
    public function get_data_date_wise($grid_firstdate, $grid_seconddate, $emp_id){
        $data = array();
		$grid_firstdate = date("Y-m-d", strtotime($grid_firstdate)); 
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));
			

		$this->db->select('*');
		$this->db->from('lunch_details');
		$this->db->where('emp_id', $emp_id);
		$this->db->where("date >=", $grid_firstdate);
		$this->db->where("date <=", $grid_seconddate);
		$this->db->order_by("date");				
		$query = $this->db->get()->result();

		$data['emp_data'] = $query;
		// dd($data);

		return $data;
       
    }
    public function get_data_date_wise_geust($grid_firstdate, $grid_seconddate){
        $data = array();
		$grid_firstdate = date("Y-m-d", strtotime($grid_firstdate)); 
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));
			
		$this->db->select('*');
		$this->db->from('lunch');
		$this->db->where("date >=", $grid_firstdate);
		$this->db->where("date <=", $grid_seconddate);
		$this->db->where("guest_m >", 0);
		$this->db->order_by("date");				
		$query = $this->db->get()->result();
		$data['emp_data'] = $query;
		// dd($data);
		return $data;
       
    }
    public function save($table, $data){
        return $this->db->insert($table, $data);
     }

    public function pay_vend_ajax_request($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('lunch_payment_vendor');
        $data = $query->result();
     
        if ($query->num_rows() > 0) {
            return $data;
         
        } else {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }


    public function get_payment_status($emp_id,$date){
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $this->db->where('emp_id', $emp_id);
        $query = $this->db->get('lunch_payment');

        if ($query->num_rows() > 0) {

            $end_date = $query->row()->end_date;

            $date3 = date('Y-m-d', strtotime('-3 days', strtotime($date))); 
            $paymentreport=0;
            if ($date3>=$end_date) {
                if($query->row()->status==0){
                    $paymentreport=0;
                }else{
                    $paymentreport=1;
                }
            }else{
                $paymentreport=1;
            }
        }else{
            $paymentreport=0;
        }
       return $paymentreport;

    }
}
?>