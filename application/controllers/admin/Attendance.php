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
		$this->load->model("Job_card_model");
		$this->load->model("Timesheet_model");

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
		$this->Attendance_model->attn_process($process_date, $emp_id, $status);
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

	// manual entry system
	public function manual_attendance()
	{
     	if (!empty($_POST)) {

            $date = $this->input->post('date');
            $in_time = $this->input->post('in_time');
            $out_time = $this->input->post('out_time');
            $reason = $this->input->post('reason');
            $status = $this->input->post('status');
            $sql = $this->input->post('sql');
	    	$emp_id = explode(',', trim($sql));

			$in_time = $in_time ? $date .' '. $in_time:'';
			$out_time = $out_time ? $date .' '. $out_time:'';

			// dd($in_time .' = '. $out_time);
			foreach ($emp_id as $key => $row) {
				$proxi_id = $this->db->where('emp_id', $row)->get('xin_proxi')->row()->proxi_id;

				// insert in time
				if ($in_time != '') {
					$this->db->where("proxi_id", $proxi_id);
					$this->db->where("date_time", $in_time);
					$query1 = $this->db->get("xin_att_machine");
					$num_rows1 = $query1->num_rows();

					if($num_rows1 == 0 ){
						$data = array(
								'proxi_id' 	=> $proxi_id,
								'date_time'	=> $in_time,
								'device_id' => 0,
							);
						$this->db->insert("xin_att_machine" , $data);
					}
				}

				// insert out time
				if ($out_time != '') {
					$this->db->where("proxi_id", $proxi_id);
					$this->db->where("date_time", $out_time);
					$query1 = $this->db->get("xin_att_machine");
					$num_rows1 = $query1->num_rows();

					if($num_rows1 == 0 ){
						$data = array(
								'proxi_id' 	=> $proxi_id,
								'date_time'	=> $out_time,
								'device_id' => 0,
							);
						$this->db->insert("xin_att_machine" , $data);
					}
				}

				// movement register insert
				if ($status != '' && $status == 1) {
					$this->db->where("employee_id", $row)->where("date", $date)->where("astatus", 1);
					$query = $this->db->get("xin_employee_move_register");
					$num_rows = $query->num_rows();

					if($num_rows == 0 ){
						$comData = array(
				            'employee_id' => $row,
				            'date' 		  => $date,
				            'out_time'    => $out_time,
				            'in_time'     => $in_time,
				            'astatus' 	  => 1,
				            'reason'	  => $reason,
				        );
						$this->db->insert("xin_employee_move_register" , $comData);

					} else {
						if ($out_time != '' && $in_time != '' && $reason != '') {
							$comData = array(
					            'out_time'    => $out_time,
					            'in_time'     => $in_time,
					            'reason'	  => $reason,
					        );
						} else if ($in_time != '' && $out_time != '') {
							$comData = array(
					            'out_time'    => $out_time,
					            'in_time'     => $in_time,
					        );
						}else if ($in_time != '' && $reason != '') {
							$comData = array(
					            'in_time'     => $in_time,
					            'reason'	  => $reason,
					        );
						} else if ($out_time != '' && $reason != '') {
							$comData = array(
					            'out_time'    => $out_time,
					            'reason'	  => $reason,
					        );
						} else if ($in_time != '') {
							$comData = array(
					            'in_time'     => $in_time,
					        );
						}  else if ($out_time != '') {
							$comData = array(
					            'out_time'    => $out_time,
					        );
						}
						$this->db->where('id', $query->row()->id)->update('xin_employee_move_register',$comData);
					}
				}
			}
			// attendance process
	        $this->Attendance_model->attn_process($date, $emp_id);

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				echo "failed";
				exit;
			}
			else
			{
		        echo "Successfully Insert Done";
				exit;
			}
		}
	}

	public function manually(){
		$this->load->view('admin/attendance/manually');
	}

	// movement register > attendance
	public function move_register($id = null) {

		if($id != null){
		    $data = $this->db->where('id',$id)->get('xin_employee_move_register')->result();
			echo json_encode( $data );
			exit;	   
		}
		
		$session = $this->session->userdata('username');
		// dd($session);
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] = 'move leave'.' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Movement leave';
		$data['path_url'] = 'attendance';

		$id = $session['user_id'];
		$array = array(1,2,3,4,5,6,7,8);
		if (in_array($id,$array)) {
			$data['results'] = $this->Attendance_model->get_movement_register();
		} else {
			$data['results'] = $this->Attendance_model->get_movement_register($session['user_id']);
		}


		$data['subview'] = $this->load->view("admin/attendance/move_register", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load

    }

    public function create_move_register()
    {
			
     	if (!empty($_POST)) {
			$out_time = $_POST['out_time'] ? $_POST['date'] .' '. $_POST['out_time']:'';
			$in_time = $_POST['in_time'] ? $_POST['date'] .' '. $_POST['in_time']:'';

			$comData = array(
	            'employee_id' => $this->input->post('user_id'),
	            'date' 		  => $this->input->post('date'),
	            'out_time'    => $out_time,
	            'in_time'     => $in_time,
	            'reason'	  => $this->input->post('reason'),
	        );

	        if ($this->input->post('id') != null) {
	        	$comData = array(
		            'out_time'    => $out_time,
		            'in_time'     => $in_time,
		            'reason'	  => $this->input->post('reason'),
		        );

		        $this->db->where('id', $this->input->post('id'))->update('xin_employee_move_register',$comData);
	        } else {
		        $this->db->insert('xin_employee_move_register',$comData);
	        }

			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
		        $response = ['status' => 'success', 'message' => "failed"];
				echo json_encode( $response );
				exit;
			}
			else
			{
				if ($this->input->post('id') != null) {
			        $response = ['status' => 'success', 'message' => "Successfully Update Done"];
				} else {
			        $response = ['status' => 'success', 'message' => "Successfully Insert Done"];
				}
		        echo json_encode( $response );
				exit;
			}
		}
    }
	 
	public function delete_move_register($id)
	{
		$this->db->where('id', $id);
        $this->db->delete('xin_employee_move_register');
	    redirect(base_url('admin/attendance/move_register'));
	}




	// report section here
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
            $this->load->view('admin/attendance/early_out',$data);
		}
		 
   }

    public function movement_report() {
		$report_date = $this->input->post('attendance_date');
		$attendance_date = date("Y-m-d", strtotime($report_date));
		$status = $this->input->post('status');
		$sql = $this->input->post('sql');
		$emp_id = explode(',', trim($sql));
		$data['status']= $status;
		$data["values"] = $this->Attendance_model->movement_report($attendance_date, $emp_id);
		$data["attendance_date"] = $attendance_date;
		
		if(is_string($data["values"]))
		{
			echo $data["values"];
		}
		else
		{	
			$this->load->view('admin/attendance/movement_report',$data);
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