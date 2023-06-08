<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lunch_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function all_employees()
    {
        $query = $this->db->query("SELECT * FROM xin_employees WHERE status IN (1, 4)");

        return $query->result();
    }
    
    public function process($processmonth)
    {

        $paymonth = date('Y-m', strtotime($processmonth));
        $emp = $this->db->query("SELECT * FROM xin_employees WHERE status IN (1, 4)")->result();
    
        foreach ($emp as $key => $value) {
            $emp_id = $value->user_id;
    
            $query = $this->db->select('*')
                ->from('lunch_payment')
                ->where('emp_id', $emp_id)
                ->where('pay_month', $paymonth)
                ->get();
    
            if ($query->num_rows() > 0) {
                $row = $query->row();
                exit('already_exists');
            } else {
                list($year, $month) = explode("-", $paymonth);
    
                $second_date = date("$year-$month-12");
                $first_date = date('Y-m-13', strtotime('-1 month', strtotime($second_date)));
              
    
                $lunchdet = $this->get_proccess_data($emp_id, $first_date, $second_date);
                if (count($lunchdet) > 0) {
                    $prev_meal = 0;
    
                    foreach ($lunchdet as $key => $value) {
                        $prev_meal += $value->meal_amount;
                    }
                    $prev_cost = ($prev_meal * 45);
                  
                    $prevemonth = date('Y-m', strtotime('-1 month', strtotime($second_date)));
    
                    $q = $query = $this->db->query("SELECT * FROM `lunch_payment` WHERE `emp_id` = 2 AND `pay_month` = '$prevemonth' ")->result();
                    
                     if (count($q) > 0) {
                        if($q[0]->status==1){
                        $prev_pay = $q[0]->pay_amount;}else{$prev_pay = 0;}
                    } else {
                        $prev_pay = 0;
                    }
    
                    $prev_amount = $prev_pay - $prev_cost;
                    $ffmonth = date('Y-m-13', strtotime('+0 month', strtotime($second_date)));
                    $fsmonth = date('Y-m-12', strtotime('+1 month', strtotime($second_date)));
                
                    $holyday = count($this->holiday_check($ffmonth, $fsmonth));
                    $date1 = new DateTime($ffmonth);
                    $date2 = new DateTime($fsmonth);
                    $interval = $date1->diff($date2);
                    $totalDays = $interval->days;
                    
                    $pay_amount =  (($totalDays-($holyday+8))*45);
                    $pay_month = $paymonth;
                } else {
                    $prev_meal = 0;
                    $prev_cost = 0;
                    $prevemonth = date('Y-m', strtotime('-1 month', strtotime($second_date)));
    
                    $q = $query = $this->db->query("SELECT * FROM `lunch_payment` WHERE `emp_id` = 2 AND `pay_month` = '$prevemonth' ")->result();
                     
                    if (count($q) > 0) {
                        if($q[0]->status==1){
                        $prev_pay = $q[0]->pay_amount;}else{$prev_pay = 0;}
                    } else {
                        $prev_pay = 0;
                    }
                    $prev_amount = $prev_pay - $prev_cost;
                    $ffmonth = date('Y-m-13', strtotime('+0 month', strtotime($second_date)));
                    $fsmonth = date('Y-m-12', strtotime('+1 month', strtotime($second_date)));
                
                    $holyday = count($this->holiday_check($ffmonth, $fsmonth));
                    
                    $date1 = new DateTime($ffmonth);
                    $date2 = new DateTime($fsmonth);
                    $interval = $date1->diff($date2);
                    $totalDays = $interval->days;
                    
                    $pay_amount =  (($totalDays-($holyday+8))*45);

                    $pay_month = $paymonth;
                }
                
                $data = array(
                    'emp_id' => $emp_id,
                    'prev_meal' => $prev_meal,
                   
                    'prev_pay' => $prev_pay,
                    'prev_amount' => $prev_amount,
                    'pay_amount' => $pay_amount,
                    'pay_month' => $pay_month,
                    'prev_cost' => $prev_cost,
                );
                $this->db->insert('lunch_payment', $data);
            }
        }
        exit('success');
    }
    


    public function employees($id)
    {
        $query = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $id ");
        return $query->result();
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
        $this->db->where("xin_attendance_time.attendance_status", 'Present');
        $data = $this->db->get()->result();
    
        if ($data) {
            return $data;
        } else {
            return 0;
        }
    }  

    public function get_all_data($limit, $offset) {
        $this->db->limit($limit, $offset);
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