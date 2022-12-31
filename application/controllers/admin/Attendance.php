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
		$this->load->model('Attendance_model');
		$this->load->model("Xin_model");
		$this->load->model("job_card_model");


		// $this->load->model("Timesheet_model");
		// $this->load->model("Employees_model");
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

	// public function attendance_process($process_date, $status)
	public function attendance_process()
    {
    	// dd($sql);
    	$process_date = $this->input->post('process_date');
    	$status = $this->input->post('status');
    	$sql = $this->input->post('sql');
    	$emp_id = explode(',', trim($sql));

    	$process_date = date("Y-m-d", strtotime($process_date));
		$this->Attendance_model->attn_process($process_date, $status, $emp_id);
		$this->db->trans_complete();
			
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			echo "Process failed";
		}
		else
		{
			echo "Process completed sucessfully";
		}

    }

    // status wise daily report
    public function daily_report()
    {  
		$report_date = $this->input->post('attendance_date');
    	$attendance_date = date("Y-m-d", strtotime($report_date));
		$status = $this->input->post('status');
		$late_status = $this->input->post('late_status');
		$sql = $this->input->post('sql');
    	$emp_id = explode(',', trim($sql));
		$data['status']= $status;
		$data['late_status']= $late_status;
    	$data["values"] = $this->Attendance_model->daily_report($attendance_date, $emp_id, $status,$late_status);
        $data["attendance_date"] = $attendance_date;
		// dd($data);
		
        if(is_string($data["values"]))
        {
            echo $data["values"];
        }
        else
        {	
			// dd($data["values"]);
            $this->load->view('admin/attendance/daily_report',$data);
        }
    }


	public function lunch_report()
    {  
		$report_date = $this->input->post('attendance_date');
    	$attendance_date = date("Y-m-d", strtotime($report_date));
		$status = $this->input->post('status');
		$late_status = $this->input->post('late_status');
		$sql = $this->input->post('sql');
    	$emp_id = explode(',', trim($sql));
		$data['status']= $status;
		// dd($late_status." ".$status);
    	$data["values"] = $this->Attendance_model->lunch_report($attendance_date, $emp_id,$status,$late_status);
        $data["attendance_date"] = $attendance_date;
		
        if(is_string($data["values"]))
        {
            echo $data["values"];
        }
        else
        {	
            $this->load->view('admin/attendance/lunch/lunch_in_out',$data);
        }
    }

	
	// Early Out Report
	public function early_out_report() {
		$report_date = $this->input->post('attendance_date');
    	$attendance_date = date("Y-m-d", strtotime($report_date));
		$status = $this->input->post('status');
		$sql = $this->input->post('sql');
    	$emp_id = explode(',', trim($sql));
		$data['status']= $status;
    	$data["values"] = $this->Attendance_model->early_out_report($attendance_date, $emp_id, $status);
        $data["attendance_date"] = $attendance_date;
		
        if(is_string($data["values"]))
        {
            echo $data["values"];
        }
        else
        {	
            $this->load->view('admin/attendance/early_out/early_out',$data);
		}
		 
   }



	// job_card > timesheet
	// Job Card Report
	public function job_card() {
	 	$first_date = $this->input->post('first_date');
	 	$second_date = $this->input->post('second_date');
    	$sql = $this->input->post('sql');
    	$emp_id = explode(',', trim($sql));

		$data['first_date'] = $first_date;
		$data['second_date'] = $second_date;
		$data['company_info'] = $this->Xin_model->get_company_info(1);
		$data['all_employees'] = $this->Attendance_model->get_employee_infos($emp_id);
		// dd($data['all_employees']);

	 	echo $this->load->view("admin/attendance/job_card", $data, TRUE);
		  
    }


    public function get_employee_ajax_request()
    {
    	$status = $this->input->get('status');
    	$data["employees"] = $this->Attendance_model->get_employee_ajax_request($status);
        echo json_encode($data);
    }
}