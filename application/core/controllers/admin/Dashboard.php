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

class Dashboard extends MY_Controller {

	public function __construct()
     {
          parent::__construct();
          //load the models
          $this->load->model('Login_model');
		  $this->load->model('Designation_model');
		  $this->load->model('Department_model');
		  $this->load->model('Employees_model');
		  $this->load->model('Xin_model');
		  $this->load->model('Exin_model');
		  $this->load->model('Expense_model');
		  $this->load->model('Timesheet_model');
		  $this->load->model('Travel_model');
		  $this->load->model('Training_model');
		  $this->load->model('Project_model');
		  $this->load->model('Job_post_model');
		  $this->load->model('Goal_tracking_model');
		  $this->load->model('Events_model');
		  $this->load->model('Meetings_model');
		  $this->load->model('Announcement_model');
		   $this->load->model('Clients_model');
		   $this->load->model("Recruitment_model");
		   $this->load->model("Salary_model");
		   $this->load->helper('date');
		   $this->load->model("Lunch_model");
		   $this->load->model('Attendance_model');
		   $this->load->model('Reports_model');
			$d=$this->db->get('xin_system_setting')->row();
			if($d->project_proccess_date<=date('Y-m-d')){
				$this->save_service();

			};
     }

	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	// public function save_service(){
	// 	$d=$this->db->get('xin_system_setting')->row();
	// 	if($d->project_proccess_date>=date('Y-m-d')){
	// 		$this->db->where('active_status',1);
	// 		$this->db->where('active_status',1);
	// 		$data=$this->db->get('xin_project_service')->result();

	// 	};
	// }
	public function save_service() {
		$query = $this->db->query("
			SELECT ps.*
			FROM xin_system_setting ss
			JOIN xin_project_service ps ON ps.start_date <= CURDATE()
			WHERE ss.project_proccess_date <= CURDATE() AND ps.active_status = 1
		");

		$data = $query->result();
		if(count($data)>0) {
			foreach($data as $d) {
                if($d->service_type==2){
					$project_id = $d->project_id;
					$client_id = $d->client_id;
					$amount = $d->amount;
					$payment_date = $d->next_payment_date;
					$notify_date = $d->next_notify_date;
					$service_id=$d->id;
					$add_data = array(
						'service_id' => $service_id,
						'project_id' => $project_id,
						'client_id' => $client_id,
						'amount' => $amount,
						'payment_date' => $payment_date,
						'nitify_date' => $notify_date
					);
					if ($this->db->insert('xin_project_service_payment', $add_data)) {
						$update_data = array(
							'next_payment_date' => date('Y-m-d', strtotime('+1 month', strtotime($payment_date))),
							'next_notify_date' => date('Y-m-d', strtotime('+1 month', strtotime($notify_date)))
						);
						$this->db->where('id', $service_id);
						if($this->db->update('xin_project_service', $update_data)){
							$update_settings = array(
								'project_proccess_date' => date('Y-m-d', strtotime('+1 month')),
							);
							$this->db->where('setting_id', 1);
							$this->db->update('xin_system_setting', $update_settings);
						};
					}
				};
            }
		}
	}
	public function index()
	{
		$session = $this->session->userdata('username');
		// dd($session);
		if(empty($session) && !is_array($session)){
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);

		if($system[0]->module_projects_tasks=='true'){
			// get user > added by
			$user = $this->Xin_model->read_user_info($session['user_id']);
			// get designation
			$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
			if(!is_null($designation)){
				$des_emp = $designation[0]->designation_name;
			} else {
				$des_emp = '--';
			}

			// get designation
			$department = $this->Department_model->read_department_information($user[0]->department_id);
			if(!is_null($department)){
				$dep_emp = $department[0]->department_name;
			} else {
				$dep_emp = '--';
			}

			$data = array(
				'title' => $this->lang->line('dashboard_title').' | '.$this->Xin_model->site_title(),
				'path_url' => 'dashboard',
				'first_name' => $user[0]->first_name,
				'last_name' => $user[0]->last_name,
				'employee_id' => $user[0]->employee_id,
				'username' => $user[0]->username,
				'email' => $user[0]->email,
				'designation_name' => $des_emp,
				'department_name' => $dep_emp,
				'date_of_birth' => $user[0]->date_of_birth,
				'date_of_joining' => $user[0]->date_of_joining,
				'contact_no' => $user[0]->contact_no,
				'last_four_employees' => $this->Xin_model->last_four_employees(),
				'get_last_payment_history' => $this->Xin_model->get_last_payment_history(),
				'all_holidays' => $this->Timesheet_model->get_holidays_calendar(),
				'all_leaves_request_calendar' => $this->Timesheet_model->get_leaves_request_calendar(),
				'all_upcoming_birthday' => $this->Xin_model->employees_upcoming_birthday(),
				'all_travel_request' => $this->Travel_model->get_travel(),
				'all_training' => $this->Training_model->get_training(),
				'all_projects' => $this->Project_model->get_projects(),
				'all_tasks' => $this->Timesheet_model->get_tasks(),
				'all_goals' => $this->Goal_tracking_model->get_goal_tracking(),
				'all_events' => $this->Events_model->get_events(),
				'all_meetings' => $this->Meetings_model->get_meetings(),
				'all_jobsx' => $this->Job_post_model->five_latest_jobs(),
				'all_jobs' => $this->Recruitment_model->get_all_jobs_last_desc()
			);
			// dd($data);
			$data['subview'] = $this->load->view('admin/dashboard/index', $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			// get user > added by
			$user = $this->Xin_model->read_user_info($session['user_id']);
			// get designation
			$designation = $this->Designation_model->read_designation_information($user[0]->designation_id);
			// get designation
			$department = $this->Department_model->read_department_information($user[0]->department_id);
			$data = array(
				'title' => $this->Xin_model->site_title(),
				'path_url' => 'dashboard',
				'first_name' => $user[0]->first_name,
				'last_name' => $user[0]->last_name,
				'employee_id' => $user[0]->employee_id,
				'username' => $user[0]->username,
				'email' => $user[0]->email,
				'designation_name' => $designation[0]->designation_name,
				'department_name' => $department[0]->department_name,
				'date_of_birth' => $user[0]->date_of_birth,
				'date_of_joining' => $user[0]->date_of_joining,
				'contact_no' => $user[0]->contact_no,
				'last_four_employees' => $this->Xin_model->last_four_employees(),
				'get_last_payment_history' => $this->Xin_model->get_last_payment_history(),
				'all_holidays' => $this->Timesheet_model->get_holidays_calendar(),
				'all_leaves_request_calendar' => $this->Timesheet_model->get_leaves_request_calendar(),
				'all_upcoming_birthday' => $this->Xin_model->employees_upcoming_birthday(),
				'all_travel_request' => $this->Travel_model->get_travel(),
				'all_training' => $this->Training_model->get_training(),
				'all_projects' => $this->Project_model->get_projects(),
				'all_tasks' => $this->Timesheet_model->get_tasks(),
				'all_goals' => $this->Goal_tracking_model->get_goal_tracking(),
				'all_events' => $this->Events_model->get_events(),
				'all_meetings' => $this->Meetings_model->get_meetings(),
				'all_jobsx' => $this->Job_post_model->all_jobs(),
				'all_jobs' => $this->Recruitment_model->get_all_jobs_last_desc()
			);
			// dd($data);
			$data['subview'] = $this->load->view('admin/dashboard/index', $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		}
	}

	public function chart(){
		$this->load->view('admin/dashboard/chart');
	}
	public function get_count(){
		$date=$this->input->post('date');
		$present=$this->Timesheet_model->get_today_present(0,['Present','HalfDay'],$date);
		$absent=$this->Timesheet_model->get_today_present(0,'Absent',$date);
		$late=$this->Timesheet_model->get_today_present(1,['Present','HalfDay'],$date);
		$leave=$this->Timesheet_model->get_today_leave($date);
		if ($leave==null) {
			$leave=[];
		}
		if ($late==null) {
			$late=[];
		}
		if ($absent==null) {
			$absent=[];
		}
		if ($present==null) {
			$present=[];
		}
		$data['absent']=$absent;
		$data['present']=$present;
		$data['late']=$late;
		$data['all_employees'] = array_merge($leave, $absent, $present);
		 echo json_encode($data);
	}
	public function daily_report()
    {
        $report_date = $this->input->post('attendance_date');
        $attendance_date = date("Y-m-d", strtotime($report_date));
        $status = $this->input->post('status');
        $late_status = $this->input->post('late_status');
        $data['status']= $status;
        if ($status == 'Present') {
            $status = array('Present', 'HalfDay');
        } else {
            $status = array($status);
        }
        $data["values"] = $this->Attendance_model->daily_report($attendance_date, $emp_id = null, $status,$late_status);
		// dd($data["values"]);
        $data["attendance_date"] = $attendance_date;

        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            // dd($data["values"]);
            $this->load->view('admin/attendance/daily_report', $data);
        }
    }
	public function get_monthly_count(){
		$date=$this->input->post('date');
		$first_date=date('Y-m-01', strtotime($date));
		$last_date=date('Y-m-t', strtotime($date));
		$leave=$this->Timesheet_model->get_leaves_with_info_with_date($first_date,$last_date);
		if ($leave==null) {
			$leave=[];
		}
		$extra_present=$this->Timesheet_model->extra_present_approval($first_date,$last_date);
		if ($extra_present==null) {
			$extra_present=[];
		}
		$late=$this->Attendance_model->get_total_late_monthly($first_date,$last_date);
		if ($late==null) {
			$late=[];
		}
		$meeting=$this->Attendance_model->get_total_meeting_monthly($first_date,$last_date);

		if ($meeting==null) {
			$meeting=[];
		}
		$data['leave']=$leave;
		$data['late']=$late;
		$data['meeting']=$meeting;
		$data['extra_present']=$extra_present;
		echo json_encode($data);
	}
	public function get_payroll_count(){
		$first_date=$this->input->post('date1');
		$second_date=$this->input->post('date2');
		$emp_id=[];
		 $emp=  $this->db->where('is_active', 1)->get('xin_employees')->result();
		 foreach($emp as $l){
			 if (!in_array($l->user_id, $emp_id)) {
				 $emp_id[] = $l->user_id;
			 }
		 }
		 $this->load->model('Reports_model');
		 $this->load->model('Lunch_model');
		$data['mobile_bill']=$this->Reports_model->show_mobile_bill_report($first_date,$second_date,$status=null,$emp_id);
		$statusC = 'all';
        $data["ta_da"] = $this->Attendance_model->movment_status_report($first_date, $second_date, $statusC);
		$data['lunch_paid']=$this->Lunch_model->paymentreport(1);
		$data['lunch_unpaid']=$this->Lunch_model->paymentreport(0);
		echo json_encode($data);
	}
	public function get_requisition_count(){
		$first_date=$this->input->post('date1');
		$second_date=$this->input->post('date2');
		 $a = $this->db->select('
		 COUNT(id) as all_requisition,
		 SUM(case when status = 1 then 1 else 0 end) as pending,
		 SUM(case when status = 2 then 1 else 0 end) as approved,
		 SUM(case when status = 3 then 1 else 0 end) as handover,
		 ')
		->where('requisition_date BETWEEN "'. $first_date . '" AND "'. $second_date .'"')
		->get('products_requisition_details')
		->row();
		$data['all_requisition'] = $a->all_requisition;
		$data['pending'] = $a->pending;
		$data['approved'] = $a->approved;
		$data['handover'] = $a->handover;
		echo json_encode($data);
	}
	public function get_purchase_count(){
		$first_date=$this->input->post('date1');
		$second_date=$this->input->post('date2');
		 $a = $this->db->select('
		 COUNT(id) as all_purchase,
		 SUM(case when status = 1 then 1 else 0 end) as pending,
		 SUM(case when status = 2 then 1 else 0 end) as approved,
		 SUM(case when status = 3 then 1 else 0 end) as received,
		 ')
		 ->where("created_at BETWEEN '$first_date' AND '$second_date'")
		 ->get('products_purches_details')
		->row();
		$data['all_purchase'] = $a->all_purchase;
		$data['pending'] = ($a->pending!=null)?$a->pending:0;
		$data['approved'] = ($a->approved !=null)?$a->approved:0;
		$data['received'] = ($a->received !=null)?$a->received:0;
		echo json_encode($data);
	}
	public function get_leave_monthly()
	{

		 $prossecc_date= $this->input->post('first_date');
		 $first_date = date('Y-m-01',strtotime($prossecc_date));
		 $second_date = date('Y-m-t',strtotime($prossecc_date));

		 $data['first_date'] = $first_date;
		 $data['second_date'] = $second_date;
		 $employee_id=[];
		 $leave=  $this->Attendance_model->leavesm($emp_id = null, $first_date, $second_date);
		 //dd($leave);

		 foreach($leave as $l){
			 if (!in_array($l->employee_id, $employee_id)) {
				 $employee_id[] = $l->employee_id;
			 }
		 }
		 $data['employee_id']=$employee_id;
		   echo $this->load->view("admin/reports/leave_report", $data, true);
	}
	public function get_extra_present_monthly()
	{
		 $prossecc_date= $this->input->post('first_date');
		 $first_date = date('Y-m-01',strtotime($prossecc_date));
		 $second_date = date('Y-m-t',strtotime($prossecc_date));
		 $this->db->select('
		 xin_employees.user_id as emp_id,
		 xin_employees.employee_id,
		 xin_employees.first_name,
		 xin_employees.last_name,
		 xin_employees.department_id,
		 xin_employees.designation_id,
		 xin_employees.date_of_joining,
		 xin_departments.department_name,
		 xin_designations.designation_name,
		 xin_attendance_time.attendance_date,
		 xin_attendance_time.clock_in,
		 xin_attendance_time.clock_out,
		 xin_attendance_time.attendance_status,
		 xin_attendance_time.status,
		 xin_attendance_time.late_status,
		 xin_attendance_time.comment,
	   ');

		 $this->db->from('xin_employees');
		 $this->db->from('xin_departments');
		 $this->db->from('xin_designations');
		 $this->db->from('xin_attendance_time');


		 $this->db->where("xin_employees.is_active", 1);
		 $this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'" );

		 $this->db->where('xin_employees.department_id = xin_departments.department_id');
		 $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
		 $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');

		 $this->db->where_in("xin_attendance_time.attendance_status", 'Present');
		 $this->db->where_in("xin_attendance_time.status", 'Off Day');


		 $this->db->order_by('xin_attendance_time.clock_in', "ASC");
		 $this->db->group_by('xin_attendance_time.employee_id');


		 $data["values"] = $this->db->get()->result();
		 $data['first_date'] = $first_date;
		 $data['second_date'] = $second_date;
		 $this->load->view('admin/attendance/extra_present', $data);

	}
	public function get_late_monthly()
	{
		 $prossecc_date= $this->input->post('first_date');
		 $first_date = date('Y-m-01',strtotime($prossecc_date));
		 $second_date = date('Y-m-t',strtotime($prossecc_date));
		 $type = 1;
		 $data['first_date'] = $first_date;
		 $data['second_date'] = $second_date;

		 $emp_id=[];
		 $leave=  $this->db->where('is_active', 1)->get('xin_employees')->result();
		 foreach($leave as $l){
			 if (!in_array($l->user_id, $emp_id)) {
				 $emp_id[] = $l->user_id;
			 }
		 }
		 $data['late_id'] = $emp_id;
		 $data['type'] = $type;
		 echo $this->load->view("admin/attendance/late_details", $data, true);


	}

	public function get_movment_monthly()
	{
		 $prossecc_date= $this->input->post('first_date');
		 $f1_date = date('Y-m-01',strtotime($prossecc_date));
		 $f2_date = date('Y-m-t',strtotime($prossecc_date));
		 $statusC = 'all';
        $data["values"] = $this->Attendance_model->movment_status_report($f1_date, $f2_date, $statusC);
        $data['statusC']= $statusC;
        $data['first_date'] = $f1_date;
        $data['second_date'] = $f2_date;
        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            echo $this->load->view("admin/attendance/movment_status_report", $data, true);
        }


	}

	public function get_mobile_bill(){
		$first_date = $this->input->post('first_date');
		$second_date = $this->input->post('second_date');

		$emp_id=[];
		$leave=  $this->db->where('is_active', 1)->get('xin_employees')->result();
		foreach($leave as $l){
			if (!in_array($l->user_id, $emp_id)) {
				$emp_id[] = $l->user_id;
			}
		}
        $data['first_date']  = $first_date;
        $data['second_date'] = $second_date;
        $data['status'] 	 = 'All';
		$data['reports']     = $this->Reports_model->show_mobile_bill_report($first_date,$second_date,$status=null,$emp_id);
		$this->load->view('admin/reports/show_mobile_bill_report',$data);
	}
	public function get_ta_da(){
		$first_date = $this->input->post('first_date');
		$second_date = $this->input->post('second_date');

		$emp_id=[];
		$emp=  $this->db->where('is_active', 1)->get('xin_employees')->result();
		foreach($emp as $l){
			if (!in_array($l->user_id, $emp_id)) {
				$emp_id[] = $l->user_id;
			}
		}



        $f1_date = date("Y-m-d", strtotime($first_date));
        $f2_date = date("Y-m-d", strtotime($second_date));
        $statusC = 'all';

        $data["values"] = $this->Attendance_model->movment_status_report($f1_date, $f2_date, $statusC);

        $data['statusC']= $statusC;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;
        if(is_string($data["values"])) {
            echo $data["values"];
        } else {
            echo $this->load->view("admin/attendance/movment_status_report", $data, true);
        }
	}
	public function get_lunch_paid(){
		$status = 1;
        $data['status'] = $status;
        $data['lunch_data'] = $this->Lunch_model->paymentreport($status);
        $data['r'] = 'Payment';
        $this->load->view('admin/lunch/payment_report_page', $data);
	}
	public function get_lunch_unpaid(){
		$status = 0;
        $data['status'] = $status;
        $data['lunch_data'] = $this->Lunch_model->paymentreport($status);
        $data['r'] = 'Payment';
        $this->load->view('admin/lunch/payment_report_page', $data);
	}





	// get opened and closed tickets for chart
	public function employee_working_status()
	{
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('absent'=>'', 'working'=>'');

		$current_month = date('Y-m-d');

		$query = $this->Xin_model->all_employees_status();
		$total = $query->num_rows();

		$working = $this->Xin_model->current_month_day_attendance($current_month);

		// get actual data
		$employee_w = $working / $total * 100;
		// absent
		$abs = $total - $working;
		$employee_ab = $abs / $total * 100;
		$Return['absent'] = $employee_ab;
		$Return['absent_label'] = 'Absent';
		// working
		$Return['working_label'] = 'Working';
		$Return['working'] = $employee_w;
		$this->output($Return);
		exit;
	}

	// get department > employee > chart
	public function employee_department()
	{
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();
		$c_color = array('#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC');
		$someArray = array();
		$j=0;
		foreach($this->Department_model->all_departments() as $department) {

			$condition = "department_id =" . "'" . $department->department_id . "'";
			$this->db->select('*');
			$this->db->from('xin_employees');
			$this->db->where($condition);
			$this->db->group_by('location_id');
			$query = $this->db->get();
			$checke  = $query->result();
			// check if department available
			if ($query->num_rows() > 0) {
				$row = $query->num_rows();
				$d_rows [] = $row;
				$c_name[] = htmlspecialchars_decode($department->department_name);

				$someArray[] = array(
				  'label'   => htmlspecialchars_decode($department->department_name),
				  'value' => $row,
				  'bgcolor' => $c_color[$j]
				  );
				  $j++;
			}
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	// get designation > employee > chart
	public function employee_designation()
	{
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();
		$c_color = array('#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED');
		$someArray = array();
		$j=0;
		foreach($this->Designation_model->all_designations() as $designation) {

			$condition = "designation_id =" . "'" . $designation->designation_id . "'";
			$this->db->select('*');
			$this->db->from('xin_employees');
			$this->db->where($condition);
			$this->db->group_by('location_id');
			$query = $this->db->get();
			$checke  = $query->result();
			// check if department available
			if ($query->num_rows() > 0) {
				$row = $query->num_rows();
				$d_rows [] = $row;
				$c_name[] = htmlspecialchars_decode($designation->designation_name);
				$someArray[] = array(
				  'label'   => htmlspecialchars_decode($designation->designation_name),
				  'value' => $row,
				  'bgcolor' => $c_color[$j]
				  );
				  $j++;
			}
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $row;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	// get location > employee > chart
	public function employee_location()
	{
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('chart_data'=>'', 'c_name'=>'', 'd_rows'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();
		$c_color = array('#00A5A8','#626E82','#FF7D4D','#FF4558','#16D39A','#6495ED','#DC143C','#006400','#556B2F','#9932CC');
		$someArray = array();
		$j=0;
		foreach($this->Xin_model->all_locations() as $location) {

			$condition = "company_id =" . "'" . $location->company_id . "'";
			$this->db->select('*');
			$this->db->from('xin_employees');
			$this->db->where($condition);
			$query = $this->db->get();
			$checke  = $query->result();
			// check if department available
			if ($query->num_rows() > 0) {
				$row = $query->num_rows();
				$d_rows [] = $row;
				$c_name[] = htmlspecialchars_decode($location->location_name);

				$someArray[] = array(
				  'label'   => htmlspecialchars_decode($location->location_name),
				  'value' => $row,
				  'bgcolor' => $c_color[$j]
				  );
				  $j++;
			}
		}
		$Return['c_name'] = $c_name;
		$Return['d_rows'] = $d_rows;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	// get total employees head count
	public function employees_head_count()
	{
		/* Define return | here result is used to return user data and error for error message */
		$date = date('Y');
  	     $query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-01%'");
		$row1 = $query->num_rows();
		$Return['january'] = $row1;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-02%'");
		$row2 = $query->num_rows();
		$Return['february'] = $row2;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-03%'");
		$row3 = $query->num_rows();
		$Return['march'] = $row3;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-04%'");
		$row4 = $query->num_rows();
		$Return['april'] = $row4;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-05%'");
		$row5 = $query->num_rows();
		$Return['may'] = $row5;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-06%'");
		$row6 = $query->num_rows();
		$Return['june'] = $row6;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-07%'");
		$row7 = $query->num_rows();
		$Return['july'] = $row7;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-08%'");
		$row8 = $query->num_rows();
		$Return['august'] = $row8;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-09%'");
		$row9 = $query->num_rows();
		$Return['september'] = $row9;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-10%'");
		$row10 = $query->num_rows();
		$Return['october'] = $row10;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-11%'");
		$row11 = $query->num_rows();
		$Return['november'] = $row11;

		$query = $this->db->query("SELECT * from xin_employees WHERE created_at like '%".$date."-12%'");
		$row12 = $query->num_rows();
		$Return['december'] = $row12;

		$Return['current_year'] = date('Y');
		$this->output($Return);
		exit;
	}
	// get department wise salary
	public function payroll_department_wise()
	{
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('chart_data'=>'', 'c_name'=>'', 'c_am'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();
		$c_color = array('#3e70c9','#f59345','#f44236','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC');
		$someArray = array();
		$j=0;
		foreach($this->Xin_model->all_departments_chart() as $department) {
		$department_pay = $this->Xin_model->get_department_make_payment($department->department_id);
		$c_name[] = htmlspecialchars_decode($department->department_name);
		$c_am[] = $department_pay[0]->paidAmount;
		$someArray[] = array(
		  'label'   => htmlspecialchars_decode($department->department_name),
		  'value' => $department_pay[0]->paidAmount,
		  'bgcolor' => $c_color[$j]
		  );
		  $j++;
		}
		$Return['c_name'] = $c_name;
		$Return['c_am'] = $c_am;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	// get designation wise salary
	public function payroll_designation_wise()
	{
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('chart_data'=>'', 'c_name'=>'', 'c_am'=>'','c_color'=>'');
		$c_name = array();
		$c_am = array();
		$c_color = array('#1AAF5D','#F2C500','#F45B00','#8E0000','#0E948C','#6495ED','#DC143C','#006400','#556B2F','#9932CC');
		$someArray = array();
		$j=0;
		foreach($this->Xin_model->all_designations_chart() as $designation) {
		$result = $this->Xin_model->get_designation_make_payment($designation->designation_id);
		$c_name[] = htmlspecialchars_decode($designation->designation_name);
		$c_am[] = $result[0]->paidAmount;
		$someArray[] = array(
		  'label'   => htmlspecialchars_decode($designation->designation_name),
		  'value' => $result[0]->paidAmount,
		  'bgcolor' => $c_color[$j]
		  );
		  $j++;
		}
		$Return['c_name'] = $c_name;
		$Return['c_am'] = $c_am;
		$Return['chart_data'] = $someArray;
		$this->output($Return);
		exit;
	}

	// set new language
	public function set_language($language = "") {

        $language = ($language != "") ? $language : "english";
        $this->session->set_userdata('site_lang', $language);
        redirect($_SERVER['HTTP_REFERER']);

    }


	public function payslip(){

		$excel = $this->input->post('excel');
    	$salary_month = date("Y-m", strtotime($this->input->post('salary_month')));
		$status = $this->input->post('status');
		$emp_id = $this->input->post('sql');

    	$data["values"] = $this->Salary_model->salary_sheet_excel($bank=2,$salary_month, $emp_id);
		// dd($salary_month);
		$data['status']= $status;
        $data["salary_month"] = $salary_month;
        $data["emp_id"] = $emp_id;
		if(is_string($data["values"]))
        {
            echo $data["values"];
        }
        else  {
        	if ($excel == 1) {
	            $this->load->view('admin/payroll/salary_excel_sheet',$data);
        	} else {
	            $this->load->view('admin/dashboard/payslip',$data);
        	}
        }
	}
}
