<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lunch_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }

    public function all_employees()
	{
	  $query = $this->db->query("SELECT * from xin_employees where user_role_id!=1");
  	  return $query->result();
	}


    public function daily_report($attendance_date)
    {   

        $this->db->select('
        xin_attendance_time.employee_id,
            xin_attendance_time.attendance_date,
        ');

        $this->db->from('xin_attendance_time');
        $this->db->where("xin_attendance_time.attendance_date", $attendance_date);
        $data = $this->db->get()->result();
    
        if($data)
        {
            return $data;
        }
        else
        {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }
}
?>