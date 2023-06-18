<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lunch_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }

    public function get_lunch_info($status)
    {
        if ($status == true) {
            $this->db->select('
                    u.first_name, 
                    u.last_name, 
                    ld.lunch_id, 
                    ld.emp_id, 
                    ld.meal_amount, 
                    ld.p_stutus, 
                    ld.comment
                ');
            $this->db->from('xin_employees as u')->from('lunch_details as ld');
            $this->db->where('u.user_id = ld.emp_id')->where('ld.date', date('Y-m-d'))->group_by('ld.emp_id');
            return $this->db->order_by('ld.p_stutus', 'ASC')->get()->result();
        } else {
            $this->db->select('
                    u.user_id as emp_id, 
                    u.first_name, 
                    u.last_name, 
                    at.status as p_stutus
                ');
            $this->db->from('xin_employees as u');
            $this->db->join('xin_attendance_time as at', 'u.user_id = at.employee_id', 'left');
            $this->db->where_in('u.status', array(1,4,5))->where('at.attendance_date', date('Y-m-d'))->group_by('u.user_id');
            return $this->db->order_by('at.status', 'DESC')->get()->result();
        }
    }

    public function all_employees()
    {
        $query = $this->db->query("SELECT * FROM xin_employees WHERE status IN (1, 4)");

        return $query->result();
    }

    public function process($firstDate,$secondDate)
    {

      $query = $this->db->query("SELECT * FROM xin_employees WHERE status IN (1, 4)")->result();
      foreach($query as $row){

        $this->db->where('date >=', $firstDate);
        $this->db->where('date <=', $secondDate);
        $this->db->where('emp_id', $row->user_id);
        $result = $this->db->get('lunch_details')->result();
        $emp_id=$row->user_id;

        $prev_meal=0;
        foreach($result as $data){
            $prev_meal+=$data->meal_amount;
        };
        $prev_cost=$prev_meal*45;
        $prev_pay=0;

        $this->db->where('emp_id', $row->user_id);
        $this->db->where('end_date', $firstDate);
        $preepay= $this->db->get('lunch_payment')->result();
        if (count($preepay)>0){
            if($preepay[0]->status==1){

                $prev_pay+=$preepay[0]->pay_amount;
            };
        };

        $prev_amount=$prev_pay-$prev_cost;
        
        $pay_amount=990;
        $from_date=$firstDate;
        $end_date=$secondDate;
        $status=0;

         $data = array(
            'emp_id' => $emp_id,
            'prev_meal' => $prev_meal,
            'prev_cost' => $prev_cost,
            'prev_pay' => $prev_pay,
            'prev_amount' => $prev_amount,
            'pay_amount' => $pay_amount,
            'from_date' => $from_date,
            'end_date' => $end_date,
            'status' => $status
        );
        $this->db->insert('lunch_payment', $data);
      }
    }
    
    public function employees($id)
    {
        $query = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $id ");
        return $query->result();
    }
    public function paymentreport($status)
    {

        $last_prement= $this->db->query("SELECT * FROM `lunch_payment` ORDER BY id DESC LIMIT 1")->row();
        

       
        $this->db->select('xin_employees.first_name, xin_employees.last_name, lunch_payment.*');
        $this->db->join('xin_employees', 'lunch_payment.emp_id = xin_employees.user_id');
        $this->db->where('lunch_payment.end_date', $last_prement->end_date);
        if ($status == 0 || $status == 1) {
            $this->db->where('lunch_payment.status', $status);
        }
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
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('lunch');
        return $query->result();
    }
    

    public function get_total_rows() {
        return $this->db->count_all('lunch');
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
}
?>