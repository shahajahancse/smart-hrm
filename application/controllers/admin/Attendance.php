<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MY_Controller {

	 public function __construct() {
        parent::__construct();
        $session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		//load the model
		$this->load->model("Timesheet_model");
		$this->load->model("Employees_model");
		$this->load->model("Xin_model");
		// $this->load->library('email');
		// $this->load->model("Department_model");
		// $this->load->model("Designation_model");
		// $this->load->model("Roles_model");
		// $this->load->model("Project_model");
		// $this->load->model("Location_model");
	}

	public function index()
    {
		$data['title'] = $this->lang->line('dashboard_attendance').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('dashboard_attendance');
		$data['path_url'] = 'attendance';
		// $data['all_office_shifts'] = $this->Location_model->all_office_locations();
		$data['subview'] = $this->load->view("admin/attendance/index", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
			  
    }

	public function attendance_process($process_date, $status)
    {
    	$employees = $this->get_employees($status);
    	foreach ($employees as $key => $row) {
    		$emp      = $row->user_id;
    		$shift_id = $row->shift_id;
	    	$shift_schedule = $this->get_shift_schedule($shift_id);

	    	$in_start_time  = $shift_schedule->in_start_time;
		    $late_start 	= $shift_schedule->late_start;
		    $out_time 		= $shift_schedule->out_time;
		    $out_start 		= $shift_schedule->out_start;
		    dd();
		    $start_time = date("Y-m-d H:i:s", strtotime($process_date.' '.$in_start_time));
		    $end_time   = date("Y-m-d H:i:s", strtotime($process_date.' '.$out_time));

	    	$in_time 	= $this->check_in_out_time($start_time, $end_time, 'ASC');
	    	$out_time 	= $this->check_in_out_time($start_time, $end_time, 'DESC');




    	}
    }

    	function check_in_out_time($start_time, $end_time, $order)
	{
		$this->db->select("date_time");
		$this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
		$this->db->order_by("date_time",$order);
		$this->db->limit("1");
		$query = $this->db->get('xin_att_machine')->row();
		return $query->date_time;
	}
	

    public function get_employees($status = null)
    {
    	$this->db->select('user_id, office_shift_id as shift_id');
    	if ($status != null) {
	    	$this->db->where('is_active',$status);
    	}
    	$this->db->where('company_id',1);
    	return $this->db->get('xin_employees')->result();
    }

    public function get_shift_schedule($shift_id = null)
    {
    	return $this->db->where('office_shift_id',$shift_id)->get('xin_office_shift')->row();
    }
	
}