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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller
{

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	public function __construct()
     {
          parent::__construct();
          //load the login model
          $this->load->model('Company_model');
		  $this->load->model('Xin_model');
		  $this->load->model('Exin_model');
		  $this->load->model('Department_model');
		  $this->load->model('Payroll_model');
		  $this->load->model('Reports_model');
		  $this->load->model('Timesheet_model');
		  $this->load->model('Training_model');
		  $this->load->model('Trainers_model');
		  $this->load->model("Project_model");
		  $this->load->model("Roles_model");
		  $this->load->model("Employees_model");
		  $this->load->model("Designation_model");
		  $this->load->model('Attendance_model');
		  $this->load->model('Accessories_model');
		  $this->load->model('Inventory_model');
     }
	 
	// payslip reports > employees and company
	public function payslip() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_payslip').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_payslip');
		$data['path_url'] = 'reports_payslip';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('111',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/payslip", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// projects report

	
	// tasks report
	public function tasks() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_tasks').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_tasks');
		$data['path_url'] = 'reports_task';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('115',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/tasks", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// roles/privileges report
	public function roles() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_report_user_roles_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_user_roles_report');
		$data['path_url'] = 'reports_roles';
		$data['all_companies'] = $this->Xin_model->get_companies();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('116',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/roles", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// employees report


	// get company > departments
	 public function get_departments() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/report_get_departments", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 } 
	 
	 // get departmens > designations
	 public function designation() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'department_id' => $id,
			'all_designations' => $this->Designation_model->all_designations(),
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/report_get_designations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	// reports > employee attendance
	public function employee_attendance() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_attendance_employee').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_attendance_employee');
		$data['path_url'] = 'reports_employee_attendance';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('112',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_attendance", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	public function employee_leave_report() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = 'leave report | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'leave report';
		$data['path_url'] = 'reports_employee_attendance';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
			$data['subview'] = $this->load->view("admin/reports/employee_leave_report", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data);
	}
	// reports > employee leave
	public function employee_leave() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_report_leave_report').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_leave_report');
		$data['path_url'] = 'reports_employee_leave';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('409',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_leave", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	public function absent_monthly() {
	
		$prossecc_date= $this->input->post('first_date');
		$first_date = date('Y-m-01',strtotime($prossecc_date));
		$second_date = date('Y-m-t',strtotime($prossecc_date));

        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        $data['company_info'] = $this->Xin_model->get_company_info(1);
        $data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);

        echo $this->load->view("admin/attendance/absent_details", $data, true);
	}
	public function yerly_leave() {
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);
		$data['date']=$this->input->post('first_date');
        echo $this->load->view("admin/reports/yerly_leave", $data, true);
	}
	public function yerly_leave_earn_list() {
        $sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
        $data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);
		$data['date']=$this->input->post('first_date');
        echo $this->load->view("admin/reports/yerly_leave_earn_list", $data, true);
	}
	public function getyarly_data() {
		$date = date('Y-m-01', strtotime($this->input->post('year').'-01-01'));
		
		$session = $this->session->userdata('username');
        $emp_id = [$session['user_id']];
        $data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);
		$data['date']=$date;
        echo $this->load->view("admin/reports/yerly_leave", $data, true);
	}
	public function leave_report()
   {
      
		$prossecc_date= $this->input->post('first_date');
		$first_date = date('Y-m-01',strtotime($prossecc_date));
		$second_date = date('Y-m-t',strtotime($prossecc_date));
        $sql = $this->input->post('sql');
        $data['sql']= $sql ;


        $emp_id = explode(',', trim($sql));
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
		$employee_id=[];
        $leave=  $this->Attendance_model->leavesm($emp_id, $first_date, $second_date);
		foreach($leave as $l){
			if (!in_array($l->employee_id, $employee_id)) {
				$employee_id[] = $l->employee_id;
			}
		}
		$data['employee_id']=$employee_id;
		
          echo $this->load->view("admin/reports/leave_report", $data, true);
            
   }
	
	// reports > employee training
	public function employee_training() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_reports_training').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_reports_training');
		$data['path_url'] = 'reports_employee_training';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('113',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/reports/employee_training", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// Validate and add info in database
	public function payslip_report() {
	
		if($this->input->post('type')=='payslip_report') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */		
		if($this->input->post('company_id')==='') {
			$Return['error'] = $this->lang->line('error_company_field');
		} else if($this->input->post('employee_id')==='') {
        	$Return['error'] = $this->lang->line('xin_error_employee_id');
		} else if($this->input->post('month_year')==='') {
			$Return['error'] = $this->lang->line('xin_hr_report_error_month_field');
		} 
				
		if($Return['error']!=''){
       		$this->output($Return);
		}
		$Return['result'] = $this->lang->line('xin_hr_request_submitted');
		$this->output($Return);
		}
	}
	
	public function role_employees_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/roles", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$roleId = $this->uri->segment(4);
		$employee = $this->Reports_model->get_roles_employees($roleId);
		
		$data = array();

        foreach($employee->result() as $r) {		  
		
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			// user full name 
			$full_name = $r->first_name.' '.$r->last_name;				
			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
			// user role
			$role = $this->Xin_model->read_user_role_info($r->user_role_id);
			if(!is_null($role)){
				$role_name = $role[0]->role_name;
			} else {
				$role_name = '--';	
			}
			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
			$department_name = $department[0]->department_name;
			} else {
			$department_name = '--';	
			}
			$department_designation = $designation_name.' ('.$department_name.')';
			
			$data[] = array(
				$r->employee_id,
				$full_name,
				$comp_name,
				$r->email,
				$role_name,
				$department_designation,
				$status
			);
      
	  }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $employee->num_rows(),
			 "recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 public function report_employees_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$company_id = $this->uri->segment(4);
		$department_id = $this->uri->segment(5);
		$designation_id = $this->uri->segment(6);
		$employee = $this->Reports_model->get_employees_reports($company_id,$department_id,$designation_id);
		
		$data = array();

        foreach($employee->result() as $r) {		  
		
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			
			// user full name 
			$full_name = $r->first_name.' '.$r->last_name;				
			// get status
			if($r->is_active==0): $status = $this->lang->line('xin_employees_inactive');
			elseif($r->is_active==1): $status = $this->lang->line('xin_employees_active'); endif;
			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
				$department_name = $department[0]->department_name;
			} else {
				$department_name = '--';	
			}
						
			$data[] = array(
				$r->employee_id,
				$full_name,
				$comp_name,
				$r->email,
				$department_name,
				$designation_name,
				$status
			);
      
	  }
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $employee->num_rows(),
			 "recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	
	public function task_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/tasks", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$taskId = $this->uri->segment(4);
		$taskStatus = $this->uri->segment(5);
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$tasks = $this->Reports_model->get_task_list($taskId,$taskStatus);
		} else {
			$tasks = $this->Timesheet_model->get_employee_tasks($session['user_id']);
		}		
		$data = array();

        foreach($tasks->result() as $r) {
			 			  
		// get start date
		$start_date = $this->Xin_model->set_date_format($r->start_date);
		// get end date
		$end_date = $this->Xin_model->set_date_format($r->end_date);
						
		//status
		if($r->task_status == 0) {
			$status = $this->lang->line('xin_not_started');
		} else if($r->task_status ==1){
			$status = $this->lang->line('xin_in_progress');
		} else if($r->task_status ==2){
			$status = $this->lang->line('xin_completed');
		} else {
			$status = $this->lang->line('xin_deffered');
		}
		
		//assigned user
		if($r->assigned_to == '') {
			$ol = $this->lang->line('xin_not_assigned');
		} else {
			$ol = '<ol class="nl">';
			foreach(explode(',',$r->assigned_to) as $desig_id) {
				$assigned_to = $this->Xin_model->read_user_info($desig_id);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 $ol .= '<li>'.$assigned_name.'</li>';
			 }
		}
		$ol .= '</ol>';
		}
		$project_summary = '<div class="text-semibold"><a href="'.site_url().'admin/timesheet/task_details/id/'.$r->task_id . '/">'.$r->task_name.'</a></div>';
		$data[] = array(
			$project_summary,$start_date,$end_date,$ol,$status,
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $tasks->num_rows(),
			 "recordsFiltered" => $tasks->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 
	public function project_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/projects", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$projId = $this->uri->segment(4);
		$projStatus = $this->uri->segment(5);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if($user_info[0]->user_role_id==1){
			$project = $this->Reports_model->get_project_list($projId,$projStatus);
		} else {
			$project = $this->Project_model->get_employee_projects($session['user_id']);
		}		
		$data = array();

        foreach($project->result() as $r) {
			 			  
		// get start date
		$start_date = $this->Xin_model->set_date_format($r->start_date);
		// get end date
		$end_date = $this->Xin_model->set_date_format($r->end_date);
		
		$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' '.$r->project_progress.'%</p>';
				
		//status
		if($r->status == 0) {
			$status = $this->lang->line('xin_not_started');
		} else if($r->status ==1){
			$status = $this->lang->line('xin_in_progress');
		} else if($r->status ==2){
			$status = $this->lang->line('xin_completed');
		} else {
			$status = $this->lang->line('xin_deffered');
		}
		
		// priority
		if($r->priority == 1) {
			$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_highest').'</span>';
		} else if($r->priority ==2){
			$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_high').'</span>';
		} else if($r->priority ==3){
			$priority = '<span class="tag tag-primary">'.$this->lang->line('xin_normal').'</span>';
		} else {
			$priority = '<span class="tag tag-success">'.$this->lang->line('xin_low').'</span>';
		}
		
		//assigned user
		if($r->assigned_to == '') {
			$ol = $this->lang->line('xin_not_assigned');
		} else {
			$ol = '';
			foreach(explode(',',$r->assigned_to) as $desig_id) {
				$assigned_to = $this->Xin_model->read_user_info($desig_id);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 $ol .= $assigned_name."<br>";
			 }
		}
		$ol .= '';
		}
		$new_time = $this->Xin_model->actual_hours_timelog($r->project_id);
		
		//echo $new_time;
		$project_summary = '<div class="text-semibold"><a href="'.site_url().'admin/project/detail/'.$r->project_id . '">'.$r->title.'</a></div>';
		$data[] = array(
			$project_summary,
			$priority,
			$start_date,
			$end_date,
			$status,
			$pbar,
			$ol,
			$r->budget_hours,
			$new_time,
			
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $project->num_rows(),
			 "recordsFiltered" => $project->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	
	public function training_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_training", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$start_date = $this->uri->segment(4);
		$end_date = $this->uri->segment(5);
		$uid = $this->uri->segment(6);
		$cid = $this->uri->segment(7);
		
		$training = $this->Reports_model->get_training_list($cid,$start_date,$end_date);
		
		$data = array();

        foreach($training->result() as $r) {
			
		 $aim = explode(',',$r->employee_id);
		 foreach($aim as $dIds) {
		 if($uid == $dIds) {
		
		// get training type
		$type = $this->Training_model->read_training_type_information($r->training_type_id);
		if(!is_null($type)){
			$itype = $type[0]->type;
		} else {
			$itype = '--';	
		}
		// get trainer
		$trainer = $this->Trainers_model->read_trainer_information($r->trainer_id);
		// trainer full name
		if(!is_null($trainer)){
			$trainer_name = $trainer[0]->first_name.' '.$trainer[0]->last_name;
		} else {
			$trainer_name = '--';	
		}
		// get start date
		$start_date = $this->Xin_model->set_date_format($r->start_date);
		// get end date
		$finish_date = $this->Xin_model->set_date_format($r->finish_date);
		// training date
		$training_date = $start_date.' '.$this->lang->line('dashboard_to').' '.$finish_date;
		// set currency
		$training_cost = $this->Xin_model->currency_sign($r->training_cost);
		/* get Employee info*/
		if($uid == '') {
			$ol = '--';
		} else {
			$user = $this->Exin_model->read_user_info($uid);
			$fname = $user[0]->first_name.' '.$user[0]->last_name;				
		}
		// status
		if($r->training_status==0): $status = $this->lang->line('xin_pending');
		elseif($r->training_status==1): $status = $this->lang->line('xin_started'); elseif($r->training_status==2): $status = $this->lang->line('xin_completed');
		else: $status = $this->lang->line('xin_terminated'); endif;
		
		// get company
		$company = $this->Xin_model->read_company_info($r->company_id);
		if(!is_null($company)){
		$comp_name = $company[0]->name;
		} else {
		  $comp_name = '--';	
		}
		
		$data[] = array(
			$comp_name,
			$fname,
			$itype,
			$trainer_name,
			$training_date,
			$training_cost,
			$status
		);
      }
		 } } // e- training
		
	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $training->num_rows(),
			 "recordsFiltered" => $training->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	
	// hourly_list > templates
	 public function payslip_report_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/payslip", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$cid = $this->uri->segment(4);
		$eid = $this->uri->segment(5);
		$re_date = $this->uri->segment(6);
		
		
		$payslip_re = $this->Reports_model->get_payslip_list($cid,$eid,$re_date);
		
		$data = array();

          foreach($payslip_re->result() as $r) {

			  // get addd by > template
			  $user = $this->Xin_model->read_user_info($r->employee_id);
			  // user full name
			  if(!is_null($user)){
			  	$full_name = $user[0]->first_name.' '.$user[0]->last_name;
				$emp_link = $user[0]->employee_id;//'<a target="_blank" href="'.site_url().'admin/employees/detail/'.$r->employee_id.'">'.$user[0]->employee_id.'</a>';
				
				// view
			 	//$functions = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-xs btn-outline-info waves-effect waves-light" data-toggle="modal" data-target=".detail_modal_data" data-employee_id="'. $r->employee_id . '" data-pay_id="'. $r->make_payment_id . '"><span class="fa fa-arrow-circle-right"></span></button></span>';		  
			  
			  		  
			  $month_payment = date("F, Y", strtotime($r->salary_month));

			  $p_amount = $this->Xin_model->currency_sign($r->net_salary);
	
			  // get date > created at > and format
			  $created_at = $this->Xin_model->set_date_format($r->created_at);
			   // get hourly rate
			  // payslip
		 	 //$payslip = '<a class="text-success" href="'.site_url().'admin/payroll/payslip/id/'.$r->payslip_id.'">'.$this->lang->line('xin_payroll_view_payslip').'</a>';
			 
			 $payslip = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view').'"><a href="'.site_url().'admin/payroll/payslip/id/'.$r->payslip_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-arrow-circle-right"></span></button></a></span><span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'"><a href="'.site_url().'admin/payroll/pdf_create/p/'.$r->payslip_id.'"><button type="button" class="btn icon-btn btn-xs btn-default waves-effect waves-light"><span class="fa fa-download"></span></button></a></span>';
			 
			  
				$p_method = '';
				/*$payment_method = $this->Xin_model->read_payment_method($r->payment_method);
				if(!is_null($payment_method)){
					$p_method = $payment_method[0]->method_name;
				} else {
					$p_method = '--';
				}*/
			$ifull_name = $full_name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_employees_id').': '.$emp_link.'<i></i></i></small>';
			  // payslip
		 	 $payslip = '<a class="text-success" href="'.site_url().'admin/payroll/payslip/id/'.$r->payslip_id.'">'.$this->lang->line('left_generate_payslip').'</a>';

               $data[] = array(
                    $ifull_name,
                    $p_amount,
                    $month_payment,
                    $created_at,
					$payslip
               );
          }
		  } // if employee available

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $payslip_re->num_rows(),
                 "recordsFiltered" => $payslip_re->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
	
	 // get company > employees
	 public function get_employees() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 // get company > employees
	 public function get_employees_att() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/get_employees_att", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	// daily attendance list > timesheet
    public function empdtwise_attendance_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_attendance", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$employee = $this->Xin_model->read_user_attendance_info();
		
		$data = array();

        foreach($employee->result() as $r) {
			$data[] = array('','','','','','','','');
		}

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $employee->num_rows(),
			 "recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // date wise attendance list > timesheet
    public function employee_date_wise_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_attendance", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$employee_id = $this->input->get("user_id");
		//$employee = $this->Xin_model->read_user_info($employee_id);
		
		$employee = $this->Xin_model->read_user_info($employee_id);
		
		$start_date = new DateTime( $this->input->get("start_date"));
		$end_date = new DateTime( $this->input->get("end_date") );
		$end_date = $end_date->modify( '+1 day' ); 
		
		$interval_re = new DateInterval('P1D');
		$date_range = new DatePeriod($start_date, $interval_re ,$end_date);
		$attendance_arr = array();
		
		$data = array();
		foreach($date_range as $date) {
		$attendance_date =  $date->format("Y-m-d");
       // foreach($employee->result() as $r) {
			 			  		
		// user full name
	//	$full_name = $r->first_name.' '.$r->last_name;	
		// get office shift for employee
		$get_day = strtotime($attendance_date);
		$day = date('l', $get_day);
		
		// office shift
		$office_shift = $this->Timesheet_model->read_office_shift_information($employee[0]->office_shift_id);
		
		// get clock in/clock out of each employee
		if($day == 'Monday') {
			if($office_shift[0]->monday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->monday_in_time;
				$out_time = $office_shift[0]->monday_out_time;
			}
		} else if($day == 'Tuesday') {
			if($office_shift[0]->tuesday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->tuesday_in_time;
				$out_time = $office_shift[0]->tuesday_out_time;
			}
		} else if($day == 'Wednesday') {
			if($office_shift[0]->wednesday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->wednesday_in_time;
				$out_time = $office_shift[0]->wednesday_out_time;
			}
		} else if($day == 'Thursday') {
			if($office_shift[0]->thursday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->thursday_in_time;
				$out_time = $office_shift[0]->thursday_out_time;
			}
		} else if($day == 'Friday') {
			if($office_shift[0]->friday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->friday_in_time;
				$out_time = $office_shift[0]->friday_out_time;
			}
		} else if($day == 'Saturday') {
			if($office_shift[0]->saturday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->saturday_in_time;
				$out_time = $office_shift[0]->saturday_out_time;
			}
		} else if($day == 'Sunday') {
			if($office_shift[0]->sunday_in_time==''){
				$in_time = '00:00:00';
				$out_time = '00:00:00';
			} else {
				$in_time = $office_shift[0]->sunday_in_time;
				$out_time = $office_shift[0]->sunday_out_time;
			}
		}
		// check if clock-in for date
		$attendance_status = '';
		$check = $this->Timesheet_model->attendance_first_in_check($employee[0]->user_id,$attendance_date);		
		if($check->num_rows() > 0){
			// check clock in time
			$attendance = $this->Timesheet_model->attendance_first_in($employee[0]->user_id,$attendance_date);
			// clock in
			$clock_in = new DateTime($attendance[0]->clock_in);
			$clock_in2 = $clock_in->format('h:i a');
			$clkInIp = $clock_in2.'<br><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_in_ip_address.'" data-uid="'.$employee[0]->user_id.'" data-att_type="clock_in" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkin_ip').'</button>';
			
			$office_time =  new DateTime($in_time.' '.$attendance_date);
			//time diff > total time late
			$office_time_new = strtotime($in_time.' '.$attendance_date);
			$clock_in_time_new = strtotime($attendance[0]->clock_in);
			if($clock_in_time_new <= $office_time_new) {
				$total_time_l = '00:00';
			} else {
				$interval_late = $clock_in->diff($office_time);
				$hours_l   = $interval_late->format('%h');
				$minutes_l = $interval_late->format('%i');			
				$total_time_l = $hours_l ."h ".$minutes_l."m";
			}
			
			// total hours work/ed
			$total_hrs = $this->Timesheet_model->total_hours_worked_attendance($employee[0]->user_id,$attendance_date);
			$hrs_old_int1 = 0;
			$Total = '';
			$Trest = '';
			$hrs_old_seconds = 0;
			$hrs_old_seconds_rs = 0;
			$total_time_rs = '';
			$hrs_old_int_res1 = 0;
			foreach ($total_hrs->result() as $hour_work){		
				// total work			
				$timee = $hour_work->total_work.':00';
				$str_time =$timee;
	
				$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
				
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				
				$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
				
				$hrs_old_int1 += $hrs_old_seconds;
				
				$Total = gmdate("H:i", $hrs_old_int1);	
			}
			if($Total=='') {
				$total_work = '00:00';
			} else {
				$total_work = $Total;
			}
			
			// total rest > 
			$total_rest = $this->Timesheet_model->total_rest_attendance($employee[0]->user_id,$attendance_date);
			foreach ($total_rest->result() as $rest){			
				// total rest
				$str_time_rs = $rest->total_rest.':00';
				//$str_time_rs =$timee_rs;
	
				$str_time_rs = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time_rs);
				
				sscanf($str_time_rs, "%d:%d:%d", $hours_rs, $minutes_rs, $seconds_rs);
				
				$hrs_old_seconds_rs = $hours_rs * 3600 + $minutes_rs * 60 + $seconds_rs;
				
				$hrs_old_int_res1 += $hrs_old_seconds_rs;
				
				$total_time_rs = gmdate("H:i", $hrs_old_int_res1);
			}
			
			// check attendance status
			$status = $attendance[0]->attendance_status;
			if($total_time_rs=='') {
				$Trest = '00:00';
			} else {
				$Trest = $total_time_rs;
			}
		
		} else {
			$clock_in2 = '-';
			$total_time_l = '00:00';
			$total_work = '00:00';
			$Trest = '00:00';
			$clkInIp = $clock_in2;
			// get holiday/leave or absent
			/* attendance status */
			// get holiday
			$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
			$holiday_arr = array();
			if($h_date_chck->num_rows() == 1){
				$h_date = $this->Timesheet_model->holiday_date($attendance_date);
				$begin = new DateTime( $h_date[0]->start_date );
				$end = new DateTime( $h_date[0]->end_date);
				$end = $end->modify( '+1 day' ); 
				
				$interval = new DateInterval('P1D');
				$daterange = new DatePeriod($begin, $interval ,$end);
				
				foreach($daterange as $date){
					$holiday_arr[] =  $date->format("Y-m-d");
				}
			} else {
				$holiday_arr[] = '99-99-99';
			}
			
			
			// get leave/employee
			$leave_date_chck = $this->Timesheet_model->leave_date_check($employee[0]->user_id,$attendance_date);
			$leave_arr = array();
			if($leave_date_chck->num_rows() == 1){
				$leave_date = $this->Timesheet_model->leave_date($employee[0]->user_id,$attendance_date);
				$begin1 = new DateTime( $leave_date[0]->from_date );
				$end1 = new DateTime( $leave_date[0]->to_date);
				$end1 = $end1->modify( '+1 day' ); 
				
				$interval1 = new DateInterval('P1D');
				$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
				
				foreach($daterange1 as $date1){
					$leave_arr[] =  $date1->format("Y-m-d");
				}	
			} else {
				$leave_arr[] = '99-99-99';
			}
				
			if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
				$status = $this->lang->line('xin_holiday');	
			} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
				$status = $this->lang->line('xin_holiday');	
			} else if(in_array($attendance_date,$holiday_arr)) { // holiday
				$status = $this->lang->line('xin_holiday');
			} else if(in_array($attendance_date,$leave_arr)) { // on leave
				$status = $this->lang->line('xin_on_leave');
			} 
			else {
				$status = $this->lang->line('xin_absent');
			}
		}
		// check if clock-out for date
		$check_out = $this->Timesheet_model->attendance_first_out_check($employee[0]->user_id,$attendance_date);		
		if($check_out->num_rows() == 1){
			/* early time */
			$early_time =  new DateTime($out_time.' '.$attendance_date);
			// check clock in time
			$first_out = $this->Timesheet_model->attendance_first_out($employee[0]->user_id,$attendance_date);
			// clock out
			$clock_out = new DateTime($first_out[0]->clock_out);
			
			if ($first_out[0]->clock_out!='') {
				$clock_out2 = $clock_out->format('h:i a');
				$clkOutIp = $clock_out2.'<br><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-ipaddress="'.$attendance[0]->clock_out_ip_address.'" data-uid="'.$employee[0]->user_id.'" data-att_type="clock_out" data-start_date="'.$attendance_date.'"><i class="ft-map-pin"></i> '.$this->lang->line('xin_attend_clkout_ip').'</button>';
				// early leaving
				$early_new_time = strtotime($out_time.' '.$attendance_date);
				$clock_out_time_new = strtotime($first_out[0]->clock_out);
			
				if($early_new_time <= $clock_out_time_new) {
					$total_time_e = '00:00';
				} else {			
					$interval_lateo = $clock_out->diff($early_time);
					$hours_e   = $interval_lateo->format('%h');
					$minutes_e = $interval_lateo->format('%i');			
					$total_time_e = $hours_e ."h ".$minutes_e."m";
				}
				
				/* over time */
				$over_time =  new DateTime($out_time.' '.$attendance_date);
				$overtime2 = $over_time->format('h:i a');
				// over time
				$over_time_new = strtotime($out_time.' '.$attendance_date);
				$clock_out_time_new1 = strtotime($first_out[0]->clock_out);
				
				if($clock_out_time_new1 <= $over_time_new) {
					$overtime2 = '00:00';
				} else {			
					$interval_lateov = $clock_out->diff($over_time);
					$hours_ov   = $interval_lateov->format('%h');
					$minutes_ov = $interval_lateov->format('%i');			
					$overtime2 = $hours_ov ."h ".$minutes_ov."m";
				}				
				
			} else {
				$clock_out2 =  '-';
				$total_time_e = '00:00';
				$overtime2 = '00:00';
				$clkOutIp = $clock_out2;
			}
					
		} else {
			$clock_out2 =  '-';
			$total_time_e = '00:00';
			$overtime2 = '00:00';
			$clkOutIp = $clock_out2;
		}		
		// user full name
			$full_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			// get company
			$company = $this->Xin_model->read_company_info($employee[0]->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}	
			// attendance date
			$tdate = $this->Xin_model->set_date_format($attendance_date);
			$data[] = array(
				$full_name,
				$comp_name,
				$status,
				$tdate,
				$clock_in2,
				$clock_out2,
				$total_work
			);
      }

	  $output = array(
		   "draw" => $draw,
			 //"recordsTotal" => count($date_range),
			 //"recordsFiltered" => count($date_range),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 public function employee_leave_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/reports/employee_leave", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$sd = $this->uri->segment(4);
		$ed = $this->uri->segment(5);
		$user_id = $this->uri->segment(6);
		$company_id = $this->uri->segment(7);
		if($user_id == '') {
			$employee = $this->Reports_model->get_leave_application_list();
		} else {
			$employee = $this->Reports_model->get_leave_application_filter_list($sd,$ed,$user_id,$company_id);
		}
		$data = array();

        foreach($employee->result() as $r) {		  
		
			// get company
			$company = $this->Xin_model->read_company_info($r->company_id);
			if(!is_null($company)){
				$comp_name = $company[0]->name;
			} else {
				$comp_name = '--';	
			}
			$employee = $this->Xin_model->read_user_info($r->employee_id);
			// user full name 
			if(!is_null($employee)){
				$full_name = $employee[0]->first_name.' '.$employee[0]->last_name;
			} else {
				$full_name = '--';
			}
			//approved leave
			$rapproved = $this->Reports_model->get_approved_leave_application_list($r->employee_id);
			$approved = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-leave_opt="Approved" data-employee_id="'. $r->employee_id . '">'.$rapproved.' '.$this->lang->line('xin_view').'</a>';
			// pending leave
			$rpending = $this->Reports_model->get_pending_leave_application_list($r->employee_id);
			$pending = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-leave_opt="Pending" data-employee_id="'. $r->employee_id . '">'.$rpending.' '.$this->lang->line('xin_view').'</a>';
			//upcoming leave
			$rupcoming = $this->Reports_model->get_upcoming_leave_application_list($r->employee_id);
			$upcoming = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-leave_opt="Upcoming" data-employee_id="'. $r->employee_id . '">'.$rupcoming.' '.$this->lang->line('xin_view').'</a>';
			//rejected leave
			$rrejected = $this->Reports_model->get_rejected_leave_application_list($r->employee_id);
			$rejected = '<a style="cursor:pointer" data-toggle="modal" data-target=".edit-modal-data" data-leave_opt="Rejected" data-employee_id="'. $r->employee_id . '">'.$rrejected.' '.$this->lang->line('xin_view').'</a>';			
			
			$data[] = array(
				$comp_name,
				$full_name,
				$approved,
				$pending,
				$upcoming,
				$rejected,
			);
      
	  }
	  $output = array(
		   "draw" => $draw,
			 //"recordsTotal" => $employee->num_rows(),
			 //"recordsFiltered" => $employee->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	  public function read_leave_details() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('employee_id');
		//$result = $this->Job_post_model->read_job_application_info($id);
		$data = 'A';
		if(!empty($session)){ 
			$this->load->view('admin/reports/dialog_leave_details', $data);
		} else {
			redirect('admin/');
		}
	}
	public function get_employeess(){

        $status = $this->input->get('status');
		
		// dd($status);
		$this->db->select('user_id as emp_id, first_name, last_name');
        if ($status == 0) {
			$this->db->where_in('status', [1,4,5]);
        } 
		if ($status == 1){
            $this->db->where('status', $status);
        } 
		if($status == 2){
            $this->db->where('status', $status);
        } 
		if($status == 3){
            $this->db->where('status',$status);
        }
		if($status == 4){
			$this->db->where_in('status',[1,2,3,4,5]);
		}
        $this->db->where('company_id', 1);
        $this->db->order_by('user_id', 'asc');
        $data["employees"] = $this->db->get('xin_employees')->result();
        echo json_encode($data);
    }
	public function get_employeess_v2(){
	
        $status = $this->input->get('status');
		$floor = $this->input->get('floor');
		$department = $this->input->get('department');
		$designation = $this->input->get('designation');
		$this->db->select('user_id as emp_id, first_name, last_name');
		//status
		if ($status == 0 && $status != 'All') {
			$this->db->where_in('status', [1,4,5]);
        }elseif($status == 1){
			$this->db->where_in('status',[2,3]);
		}elseif($status == 'All'){
			$this->db->where_in('status',[1,2,3,4,5]);
		}
		// status end 
		//floor
		if ($floor == 5) {
			$this->db->where('floor_status', 5);
		}elseif($floor == 3){
			$this->db->where('floor_status', 3);
		}
		// floor end
		//department
		if ($department != '') {
			$this->db->where('department_id', $department);
		}
		//department end
		//designation
		if ($designation != '') {
			$this->db->where('designation_id', $designation);
		}
		//designation end
        $this->db->where('company_id', 1);
        $this->db->order_by('user_id', 'asc');
        $data["employees"] = $this->db->get('xin_employees')->result();
        echo json_encode($data);
    }
	public function employees() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_report_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');

		$data['subview'] = $this->load->view("admin/reports/employees", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load

	}
	public function employee_increment(){
		$sql = $this->input->post('sql');
		$emp_id = explode(',', trim($sql))[0];
		$data['list'] =$this->db->where('emp_id', $emp_id)->get('xin_employee_incre_prob')->result();
		// dd($data['list']);
		$data['user_info'] =$this->Attendance_model->get_emp_info($emp_id);
		
		$this->load->view('admin/reports/employee_increment',$data);
	}



	public function employee_bonus(){

		// dd($this->input->post());
		$all_employee=$this->db->where_in('status',[1,4,5])->get('xin_employees')->result();

		$exist_employee=[];
		$no_intern_one_year=[];
		$joining_one_year=[];
		$no_year=[];
		$const_date=date('Y-m-d', $_POST['date']);
		$data['const_date'] = $const_date;

		$emni_pass_date=date('Y-m-d',strtotime('-18 month', strtotime($const_date)));
		$pass_date=date('Y-m-d',strtotime('-1 year', strtotime($const_date)));
		// dd($emni_pass_date);

		foreach ($all_employee as $key => $value) {
			$emp_id=$value->user_id;
			$joining_date=$value->date_of_joining;
			if ($joining_date <= $emni_pass_date) {
				$no_intern_one_year[] = $value->user_id;
			}else{
				$this->db->where('emp_id', $emp_id);
				$this->db->where('status', 1);
				$this->db->order_by('effective_date', 'desc');
				$this->db->limit(1);
				$last_date=$this->db->get('xin_employee_incre_prob')->row();

				if(!empty($last_date)){
					$this->db->where('emp_id', $emp_id);
					$this->db->where('status', 4);
					$this->db->order_by('effective_date', 'desc');
					$this->db->limit(1);
					$if_inter=$this->db->get('xin_employee_incre_prob')->row();
					if(!empty($if_inter)){
						$her_join_date=$if_inter->end_date;
					}else{
						$her_join_date=$value->date_of_joining;
					}
					if ($her_join_date <= $pass_date) {
						$no_intern_one_year[] = $value->user_id;
					}else{
						$exist_employee[]= $value;
					}
				}

				
			}
		}

		foreach ($exist_employee as $key => $value) {
				if ($value->date_of_joining <= $pass_date) {
					$joining_one_year[] = $value->user_id;
				}else{
					$no_year[] = $value->user_id;
				}
		}



		$data['no_intern_one_year'] = $no_intern_one_year;
		$data['joining_one_year'] = $joining_one_year;
		$data['no_year'] = $no_year;
		$this->load->view('admin/reports/employee_bonus',$data);
	}








	public function late_report() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_report_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');

		$data['subview'] = $this->load->view("admin/reports/late_report", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load

	}

	public function fetch_data(){
		$data['session'] = $this->session->userdata('username');
      $first_date = $this->input->post('first_date');
      $second_date = $this->input->post('second_date');
      $elc = $this->input->post('elc');

		$data['pending_list'] =$this->Reports_model->all_pending_report(null, $first_date, $second_date);
		$data['done_list'] =$this->Reports_model->all_done_report(null, $first_date, $second_date);
		// dd($data);
		$data['first_date'] = $first_date;
		$data['second_date'] = $second_date;
		$data['data_type'] = 'Intern, Probation & Increment';
		if ($elc == 1 && !empty($elc)) {
			$this->load->view('admin/reports/intern_json_excel', $data);
		} else {
			$this->load->view('admin/reports/intern_json', $data);
		}
   }

	public function show_report($elc=null){
		$data['session'] = $this->session->userdata('username');
		if(empty($data['session'])){ 
			redirect('admin/');
		}
      $elc = $this->input->post('elc');
      $sql = $this->input->post('sql');
      $status = $this->input->post('status');
      $done = $this->input->post('done');
      $first_date = $this->input->post('first_date');
      $second_date = $this->input->post('second_date');
      $emp_id = explode(',', trim($sql));
      if ($done == 1 && $done  != 'undefined' && $status != 7) {
      	if ($status == 1) {
      		$pstatus = 5;
      	} else if ($status == 2 || $status == 3) {
      		$pstatus = 1;
      	} else {
      		$pstatus = 4;
      	}
	      $data['emp_list'] =$this->Reports_model->pending_inc_pro_prb_report($emp_id, $pstatus, $first_date, $second_date);
	      $data['done_list'] =$this->Reports_model->done_inc_pro_prb_report($emp_id, $status, $first_date, $second_date);
      } else if ($done == 1 && $done  != 'undefined' && $status == 7 ) {
		   $data['pending_list'] =$this->Reports_model->all_pending_report($emp_id, $first_date, $second_date);
		   $data['done_list'] =$this->Reports_model->all_done_report($emp_id, $first_date, $second_date);
      } else {
	      $data['emp_list'] =$this->Reports_model->show_report($emp_id,$status,$first_date,$second_date);
      }

		$data['sql'] = $sql;
		$data['status'] = $status;
		$data['first_date'] = $first_date;
		$data['second_date'] = $second_date;

		if ($elc==1 && $done == 1 && $done  != 'undefined') {
			if($status == 1){
				$data['data_type'] = 'Probation to Regular';
				$data['data_type_n'] = 'Probation';
				$this->load->view('admin/reports/int_Pro_reg_excel', $data);
			} 
			if($status == 2){
				$data['data_type'] = 'Increment';
				$this->load->view('admin/reports/inc_pro_excel', $data);
			} 
			if($status == 3){
				$data['data_type'] = 'Promotion';
				$this->load->view('admin/reports/inc_pro_excel', $data);
			}
			if($status == 4){
				$data['data_type'] = 'Intern to Probation';
				$data['data_type_n'] = 'Intern';
				$this->load->view('admin/reports/int_Pro_reg_excel', $data);
			}
			if($status == 5){
				$data['data_type'] = 'Intern to Regular';
				$data['data_type_n'] = 'Intern';
				$this->load->view('admin/reports/int_Pro_reg_excel', $data);
			}
			if($status == 7){
				$data['data_type'] = 'Intern, Probation & Increment';
				$this->load->view('admin/reports/intern_excelipn', $data);
			}

		} else if ($done == 1 && $done  != 'undefined') {
			if($status == 1){
				$data['data_type'] = 'Probation to Regular';
				$data['data_type_n'] = 'Probation';
				$this->load->view('admin/reports/int_Pro_reg', $data);
			} 
			if($status == 2){
				$data['data_type'] = 'Increment';
				$this->load->view('admin/reports/inc_pro', $data);
			} 
			if($status == 3){
				$data['data_type'] = 'Promotion';
				$this->load->view('admin/reports/inc_pro', $data);
			}
			if($status == 4){
				$data['data_type'] = 'Intern to Probation';
				$data['data_type_n'] = 'Intern';
				$this->load->view('admin/reports/int_Pro_reg', $data);
			}
			if($status == 5){
				$data['data_type'] = 'Intern to Regular';
				$data['data_type_n'] = 'Intern';
				$this->load->view('admin/reports/int_Pro_reg', $data);
			}
			if($status == 7){
				$data['data_type'] = 'Intern, Probation & Increment';
				$this->load->view('admin/reports/intern', $data);
			}
			
		} else if($elc==1) {
			if($status == 1){
				$this->load->view('admin/reports/emp_list_excel', $data);
			} 
			if($status == 3){
				$this->load->view('admin/reports/intern_excel', $data);
			} 
			if($status == 4){
				$this->load->view('admin/reports/probation_excel', $data);
			}
			if($status == 2){
				$this->load->view('admin/reports/incre_excel', $data);
			}
			if($status == 5){
				$this->load->view('admin/reports/using_device_excel', $data);
			}

		} else  {
			if($status == 1){
				$this->load->view('admin/reports/emp_list', $data);
			} 
			if($status == 3){
				$this->load->view('admin/reports/intern', $data);
			} 
			if($status == 4){
				$this->load->view('admin/reports/probation', $data);
			}
			if($status == 2){
				$this->load->view('admin/reports/increment', $data);
			}
			if($status == 5){
				$this->load->view('admin/reports/using_device', $data);
			}
		}
   }
	public function employee_regular_report(){
		

    	$first_date = $this->input->post('first_date');
		$all_employee=$this->db->where_in('status',[1,4,5])->get('xin_employees')->result();

		$exist_employee=[];
		$no_intern_one_year=[];
		$joining_one_year=[];
		$no_year=[];
		$const_date=date('Y-m-d', strtotime($first_date));
		$emni_pass_date=date('Y-m-d',strtotime('-18 month', strtotime($const_date)));
		$pass_date=date('Y-m-d',strtotime('-1 year', strtotime($const_date)));
		// dd($emni_pass_date);

		// foreach ($all_employee as $key => $value) {
		// 	$emp_id=$value->user_id;
		// 	$joining_date=$value->date_of_joining;
		// 	if ($joining_date <= $emni_pass_date) {
		// 		$no_intern_one_year[] = $value->user_id;
		// 	}else{
		// 		$this->db->where('emp_id', $emp_id);
		// 		$this->db->where('status', 1);
		// 		$this->db->order_by('effective_date', 'desc');
		// 		$this->db->limit(1);
		// 		$last_date=$this->db->get('xin_employee_incre_prob')->row();

		// 		if (!empty($last_date) && $last_date->effective_date <= $pass_date) {
		// 			$no_intern_one_year[] = $value->user_id;
		// 		}else{
		// 			$exist_employee[]= $value;
		// 		}
				
		// 	}
		// }
		foreach ($all_employee as $key => $value) {
			$emp_id=$value->user_id;
			$joining_date=$value->date_of_joining;
			if ($joining_date <= $emni_pass_date) {
				$no_intern_one_year[] = $value->user_id;
			}else{
				$this->db->where('emp_id', $emp_id);
				$this->db->where('status', 1);
				$this->db->order_by('effective_date', 'desc');
				$this->db->limit(1);
				$last_date=$this->db->get('xin_employee_incre_prob')->row();

				if(!empty($last_date)){
					$this->db->where('emp_id', $emp_id);
					$this->db->where('status', 4);
					$this->db->order_by('effective_date', 'desc');
					$this->db->limit(1);
					$if_inter=$this->db->get('xin_employee_incre_prob')->row();
					if(!empty($if_inter)){
						$her_join_date=$if_inter->end_date;
					}else{
						$her_join_date=date('Y-m-d', strtotime($value->date_of_joining));
					}
					if ($her_join_date <= $pass_date) {
						$no_intern_one_year[] = $value->user_id;
					}else{
						$exist_employee[]= $value;
					}
				}else{
					$exist_employee[]= $value;
				}

				
			}
		}

		foreach ($exist_employee as $key => $value) {
				if ($value->date_of_joining <= $pass_date) {
					$joining_one_year[] = $value->user_id;
				}else{
					$no_year[] = $value->user_id;
				}
		}



		$data['no_intern_one_year'] = $no_intern_one_year;
		$data['joining_one_year'] = $joining_one_year;
		$data['no_year'] = $no_year;
		$this->load->view('admin/reports/employee_bonus',$data);
   }

	public function show_late_report(){
		// $report_date = ;
		// dd($_POST);
        $attendance_date =$this->input->post('attendance_date');
        $second_date = $this->input->post('second_date');
        $status = $this->input->post('status');
        $sql = $this->input->post('sql');
        $key = $this->input->post('key');
        $emp_id = explode(',', trim($sql));
        $data['attendance_date'] = $attendance_date;
        $data['second_date'] = $second_date;
		$data['status'] = $key;
		$data['values'] =$this->Reports_model->late_report($emp_id,$key,$attendance_date,$second_date);
		$this->load->view('admin/reports/show_late_report', $data);
    }
	public function show_meeting_report(){
		// dd($_POST);
        $attendance_date = date("Y-m-d", strtotime($this->input->post('a_date')));
        $status = $this->input->post('status');
        $sql = $this->input->post('sql');
        $key = $this->input->post('key');
        $emp_id = explode(',', trim($sql));
        $data['first_date'] = $attendance_date;
		$data['status'] = $key;
		if($key == 1){
			$second_date= date('Y-m-d',strtotime($attendance_date));
		}else if($key == 2){
			$second_date= date('Y-m-d',strtotime('+6 days'.$attendance_date));
		}else{
			$second_date= date('Y-m-d',strtotime('+30 days'.$attendance_date));        
		}
		$data['second_date']= $second_date;
		$data['values'] =$this->Reports_model->show_meeting_report($emp_id,$key,$attendance_date,$second_date);
		// dd($data);
		$this->load->view('admin/reports/meeting_report', $data);
    }
	public function inventory() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = "Inventory Report".' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = "Inventory Report";
		$data['subview'] = $this->load->view("admin/reports/inventory", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}
	public function show_inventory_report(){
		$sql = $this->input->post('sql');
        $status = $this->input->post('status');
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $emp_id = explode(',', trim($sql));
		$data['reports']     = $this->Reports_model->get_product_reports_info($first_date,$second_date,$status,$emp_id);
		$this->load->view('admin/reports/inventory_report',$data);
	}
	public function show_device_report(){
		$data  = $this->Reports_model->device_report();
		$this->load->view('admin/reports/device_report',$data);
	}
	public function show_device_report_laptop(){
		$data  = $this->Reports_model->device_report();
		$this->load->view('admin/reports/device_report_laptop',$data);
	}

	public function show_store_report(){
		$data     = $this->Reports_model->show_store_report();
		// dd($data);
		$this->load->view('admin/reports/show_store_report',$data);
	}
	public function show_move_report(){
		$sql 				 = $this->input->post('sql');
        $status 			 = $this->input->post('status');
        $first_date			 = $this->input->post('first_date');
        $second_date 		 = $this->input->post('second_date');
        $data['first_date']  = $first_date;
        $data['second_date'] = $second_date;
        $data['status'] 	 = $status;
        $emp_id 			 = explode(',', trim($sql));
		$data['reports']     = $this->Reports_model->show_move_report($first_date,$second_date,$status,$emp_id);
		$this->load->view('admin/reports/show_move_report',$data);
	}
	public function show_mobile_bill_report(){
		$sql 				 = $this->input->post('sql');
        $status 			 = $this->input->post('status');
        $first_date			 = $this->input->post('first_date');
        $second_date 		 = $this->input->post('second_date');
        $data['first_date']  = $first_date; 
        $data['second_date'] = $second_date;
        $data['status'] 	 = $status;
        $emp_id 			 = explode(',', trim($sql));
		$data['reports']     = $this->Reports_model->show_mobile_bill_report($first_date,$second_date,$status,$emp_id);
		$this->load->view('admin/reports/show_mobile_bill_report',$data);
	}
	public function issue_report(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title']       = "Issue Report".' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = "Issue Report";
		$data['subview']     = $this->load->view('admin/reports/issue_report',$data,true);
		$this->load->view('admin/layout/layout_main', $data);
	}
	public function issuee_report(){
		$sql = $this->input->post('sql');
        $status = $this->input->post('status');
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
        $emp_id = explode(',', trim($sql));
		$data['status'] = $status;
		if($status == 2){
			$second_date =  date('Y-m-d',strtotime('+6 days'.$second_date));
		}
		$data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
		$data['values'] = $this->db->select('xin_employees.user_id,xin_employees.first_name,xin_employees.last_name,employee_issue.comment,employee_issue.emp_id')
						->where('employee_issue.create_at >=',$first_date)->where('employee_issue.create_at <=',$second_date)
						->where_in('emp_id',$emp_id)
						->from('employee_issue')
						->join('xin_employees','xin_employees.user_id = employee_issue.emp_id')
						->get()->result();
		// dd($data);
		$this->load->view('admin/reports/issuees_report',$data);
	}
	public function lunch_report_all() {
		$session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }
        $this->db->distinct();
        $this->db->select('end_date,next_date');
        $this->db->from('lunch_payment');
        $this->db->order_by('id DESC'); // Replace with your actual table name
        $data['prever_report'] = $this->db->get()->result();
        $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Lunch Report';
        $data['path_url'] = 'lunch';
        if (!empty($session)) {
			$data['subview'] = $this->load->view("admin/reports/lunch_report", $data, true);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
	}
	public function accounts_report() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = "Accounts Report".' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = "Accounts Report";
		$data['subview'] = $this->load->view("admin/reports/accounts_report", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}
	public function client_list(){
		$data['client_list'] = $this->db->get('xin_clients')->result();
		$this->load->view('admin/reports/client_list', $data);
    }
	public function store_report(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = "Store In Out Report".' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = "Store In Out Report";
		$data['subview'] = $this->load->view("admin/reports/store_report", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); 
    }
	public function item_wise_report(){
		// dd($_POST);
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$id = $this->input->post('item_id');
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
		$data['first_date']=$first_date;
		$data['second_date']=$second_date;
		$data['results'] = $this->Inventory_model->product_details($id,$first_date,$second_date);
		$this->load->view("admin/reports/item_wise_report", $data);
    }
	public function inventory_status_report($exc=null){
		$first_date = $this->input->post('first_date');
		$second_date = $this->input->post('second_date');
		$statusC = $this->input->post('statusC');
		$data["values"] = $this->Inventory_model->requsition_status_report($first_date, $second_date, $statusC);
		//  dd($data["values"]);
		$data['statusC']= $statusC;
		$data['first_date'] = $first_date;
		$data['second_date'] = $second_date;
		if($exc == 1){
			$this->load->view("admin/inventory/inventory_req_status_report_excil", $data);
		}else{
			if(is_string($data["values"])){
				echo $data["values"];
			}
			else{	
				echo $this->load->view("admin/inventory/inventory_req_status_report", $data, TRUE);
			}
		}
	}
	public function perches_status_report($exc=null){            
		$first_date = $this->input->post('first_date');
		$second_date = $this->input->post('second_date');
		$f1_date = date("Y-m-d", strtotime($first_date));
		$f2_date = date("Y-m-d", strtotime($second_date));
		$statusC = $this->input->post('statusC');
		$data["values"] = $this->Inventory_model->perches_status_report($f1_date, $f2_date, $statusC);
		$data['statusC']= $statusC;
		$data['first_date'] = $first_date;
		$data['second_date'] = $second_date;
		if($exc == 1){
			$this->load->view("admin/inventory/perches_status_report_excel", $data);
		}else{
			if(is_string($data["values"])){
				echo $data["values"];
			}
			else{	
				echo $this->load->view("admin/inventory/perches_status_report", $data, TRUE);
			}
		}
	}
	public function low_inv_all_product_status_report($exc=null){
		$statusC=$this->input->post('statusC');
		if($statusC==7){
			$data['values'] = $this->Inventory_model->low_inv_allProduct_status_report();
			$data['statusC']= $statusC;
		if($exc == 1){
			$this->load->view("admin/inventory/low_in_status_report_excel", $data);
		}else{
			if(is_string($data["values"])){
				echo $data["values"];
			}
			else{	
				echo $this->load->view("admin/inventory/low_in_status_report", $data, TRUE);
			}
		}
		}else{
			$data['statusC']= $statusC;
			$data['values'] = $this->Inventory_model->low_inv_allProduct_status_report($statusC);
			// dd($data['values']);
			if($exc == 2){
				$this->load->view("admin/inventory/low_in_status_report_excel", $data);
			}else{
				if(is_string($data["values"])){
					echo $data["values"];
				}
				else{	
					echo $this->load->view("admin/inventory/low_in_status_report", $data, TRUE);
				}			
			}
		}	   
	}
	public function leave_application($exl=null){
		// dd($_POST);
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
        $exl = $this->input->post('exl');
        $sql = $this->input->post('sql');
        $status = $this->input->post('status');
		$data['status']= $status;
		$data['sql']= $sql;
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
		$data['first_date']= $first_date;
		$data['second_date']= $second_date;
        $emp_id = explode(',', trim($sql));
        $data['app_list'] =$this->Reports_model->leave_application($first_date,$second_date,$emp_id);
		if($exl==1){
			$this->load->view("admin/reports/leave_application_excel", $data);
		}else{
			$this->load->view("admin/reports/leave_application", $data);
		}
	}
	public function salary_review_report(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
        $sql = $this->input->post('sql');
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
		$data['first_date']= $first_date;
		$data['second_date']= $second_date;
        $emp_id = explode(',', trim($sql));
		$data['emp_id']= $emp_id;
	    $this->load->view("admin/reports/salary_review_report", $data);
		
	}
	public function date_active_inactive_report(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
        $sql = $this->input->post('sql');
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');
		$data['first_date']= $first_date;
		$data['second_date']= $second_date;
        $emp_id = explode(',', trim($sql));
		$data['emp_id']= $emp_id;
	    $this->load->view("admin/reports/date_active_inactive_report", $data);
		
	}
	public function get_designations(){
		$department_id = $this->input->post('department_id');
		$data = $this->Designation_model->ajax_is_designation_information($department_id);
		echo json_encode($data);
	}

	public function get_employee_summary(){
		$sql = $this->input->post('sql');
        $emp_id = explode(',', trim($sql));
		$data['all_employees'] = $this->Attendance_model->get_emp_info($emp_id);
		$this->load->view("admin/reports/employee_summary", $data);
	}
	public function holyday_list(){
		$first_date = $this->input->post('first_date');
		$year_first_day=date('Y-01-01', strtotime($first_date));
		$year_last_day=date('Y-12-t', strtotime($first_date));
		$this->db->select('*');
		$this->db->from('xin_holidays');
		$this->db->where('start_date >=', $year_first_day);
		$this->db->where('end_date <=', $year_last_day);
		$query = $this->db->get();
		$data['holyday_list'] = $query->result();

		$this->load->view("admin/reports/holyday_list", $data);
	}


	public function employees_letter() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['all_employees'] = $this->db->where_in('status', [1,4,5])->get('xin_employees')->result();
		$data['title'] = $this->lang->line('xin_hr_report_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_report_employees');
		$data['subview'] = $this->load->view("admin/reports/employees_letter", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}
	public function get_employee_inc_pro(){
		$employee_id = $this->input->post('id');
		$this->db->where('emp_id', $employee_id);
		$this->db->where('status', 2);
		$this->db->order_by('effective_date', 'desc');
		$increment = $this->db->get('xin_employee_incre_prob')->result();

		$this->db->where('emp_id', $employee_id);
		$this->db->where('status', 3);
		$this->db->order_by('effective_date', 'desc');
		$promotion = $this->db->get('xin_employee_incre_prob')->result();
		$data['increment'] = $increment;
		$data['promotion'] = $promotion;
		echo json_encode($data);
	}
	public function joining_letter($employee_id = null) {
		if ($employee_id == null) {
			echo "Please select employee";
		}else{
			$this->db->select('xin_employees.*, xin_designations.designation_name, xin_departments.department_name');
			$this->db->from('xin_employees');
			$this->db->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id');
			$this->db->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id');
			$this->db->where('user_id', $employee_id);
			$data['data'] = $this->db->get()->row();
			$this->load->view("admin/reports/joining_letter", $data);
		}
	}
	public function confirmation_letter($employee_id = null) {
		if ($employee_id == null) {
			echo "Please select employee";
		}else{
			$this->db->select('xin_employees.*, xin_designations.designation_name, xin_departments.department_name');
			$this->db->from('xin_employees');
			$this->db->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id');
			$this->db->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id');
			$this->db->where('user_id', $employee_id);
			$data['data'] = $this->db->get()->row();

			$this->db->select('xin_employee_incre_prob.*, xin_designations.designation_name, xin_departments.department_name');
			$this->db->from('xin_employee_incre_prob');
			$this->db->join('xin_designations', 'xin_employee_incre_prob.new_desig_id = xin_designations.designation_id');
			$this->db->join('xin_departments', 'xin_employee_incre_prob.new_dept_id = xin_departments.department_id');
			$this->db->where('xin_employee_incre_prob.emp_id', $employee_id);
			$this->db->where('xin_employee_incre_prob.status', 4);
			$increment = $this->db->get()->row();
			if ($increment == null) {
				echo "No data found";
				exit();
			}
			$data['increment'] = $increment;

			$this->load->view("admin/reports/confirmation_letter", $data);
		}
	}
	public function appointment_letter($employee_id = null) {
		if ($employee_id == null) {
			echo "Please select employee";
		}else{
			$this->db->select('xin_employees.*, xin_designations.designation_name, xin_departments.department_name');
			$this->db->from('xin_employees');
			$this->db->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id');
			$this->db->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id');
			$this->db->where('user_id', $employee_id);
			$data['data'] = $this->db->get()->row();
			$this->load->view("admin/reports/appointment_letter", $data);
		}
	}
	public function increment_letter($employee_id = null,$increment_id = null) {
		if ($employee_id == null) {
			echo "Please select employee";
		}else{
			$this->db->select('xin_employees.*, xin_designations.designation_name, xin_departments.department_name');
			$this->db->from('xin_employees');
			$this->db->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id');
			$this->db->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id');
			$this->db->where('user_id', $employee_id);
			$data['data'] = $this->db->get()->row();

			$this->db->where('id', $increment_id);
			$increment = $this->db->get('xin_employee_incre_prob')->row();
			$data['increment'] = $increment;
			$this->load->view("admin/reports/increment_letter", $data);
			
		}
	}
	public function promotion_letter($employee_id = null,$increment_id = null) {
		if ($employee_id == null) {
			echo "Please select employee";
		}else{
			$this->db->select('xin_employees.*, xin_designations.designation_name, xin_departments.department_name');
			$this->db->from('xin_employees');
			$this->db->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id');
			$this->db->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id');
			$this->db->where('user_id', $employee_id);
			$data['data'] = $this->db->get()->row();


			$this->db->select('xin_employee_incre_prob.*, xin_designations.designation_name, xin_departments.department_name');
			$this->db->from('xin_employee_incre_prob');
			$this->db->join('xin_designations', 'xin_employee_incre_prob.new_desig_id = xin_designations.designation_id');
			$this->db->join('xin_departments', 'xin_employee_incre_prob.new_dept_id = xin_departments.department_id');
			$this->db->where('id', $increment_id);
			$increment = $this->db->get()->row();
			$data['promotion'] = $increment;
			$this->load->view("admin/reports/promotion_letter", $data);
			
		}
	}
} 
?>