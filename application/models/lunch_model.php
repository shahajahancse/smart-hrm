<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lunch_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }
    
    public function all_employees()
    {
        $query = $this->db->query("SELECT * FROM xin_employees WHERE user_role_id != 1");
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
            $this->db->select('lunch_details.id, lunch_details.lunch_id, lunch_details.meal_amount, lunch_details.p_stutus, lunch_details.comment, lunch_details.date, xin_employees.first_name, xin_employees.last_name');
            $this->db->from('lunch_details');
            $this->db->join('xin_employees', 'xin_employees.user_id = lunch_details.emp_id');
            $this->db->where_in('lunch_details.emp_id', $emp_ids);
            $this->db->where('date >=', $first_date);
            $this->db->where('date <=', $second_date);
            return $this->db->get()->result();
        }
        
}
?>