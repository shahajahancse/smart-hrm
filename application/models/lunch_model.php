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
    public function add_lunch_details($lastId,$empid,$m_amount,$p_status,$comment,$guest_m,$guest_comment,$date)
	{



        foreach($empid as $i=>$eid){
       
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

    public function add_lunch_update($luncid,$empid,$m_amount,$p_status,$comment,$guest_m,$guest_comment,$date)
	{
        foreach($empid as $i=>$eid){
       
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