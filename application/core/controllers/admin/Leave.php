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

class Leave extends MY_Controller
{
	
	public function __construct()
   {
      parent::__construct();
      //load the login model
      $this->load->model('Company_model');
		$this->load->model('Xin_model');
		$this->load->model('Timesheet_model');
   }

   /*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}

	
	//leave calendar
	public function calendar() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_hr_leave_calendar');
		$data['breadcrumbs'] = $this->lang->line('xin_hr_leave_calendar');
		$data['path_url'] = 'calendar_leave';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('102',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/leave/leave_calendar", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
	}
	
	// attandance view code here
	public function emp_leave(){
      $session = $this->session->userdata('username');
		//  dd($session['user_id']);
		if(empty($session)){ 
			redirect('admin/');
		}

		$session = $this->session->userdata( 'username' );
		$userid  = $session[ 'user_id' ];
		$firstdate = $this->input->post('firstdate');
		$seconddate = $this->input->post('seconddate');

		$this->db->select("*");
		$this->db->where("employee_id", $userid);
		if ($firstdate!=null && $seconddate!=null){
				$f1_date=date('Y-m-d',strtotime($firstdate));
				$f2_date=date('Y-m-d',strtotime($seconddate));
				$this->db->where("from_date BETWEEN '$f1_date' AND '$f2_date'");
				$this->db->order_by("from_date", "desc");
			$data['alldata'] = $this->db->get('xin_leave_applications')->result();
			$data['tablebody'] 		= $this->load->view("admin/leave/emp_leave_table", $data, TRUE);
			echo $data['tablebody'] ;
		}else{
			$this->db->order_by("from_date", "desc");
			$data['alldata'] = $this->db->get('xin_leave_applications')->result();
			// dd($data['alldata'] );
			$data['session'] 			= $session;
			$data['title'] 			= 'Leave | '.$this->Xin_model->site_title();
			$data['breadcrumbs']	= 'Leave | Employee Leave';
			$data['tablebody'] 		= $this->load->view("admin/leave/emp_leave_table", $data, TRUE);

			$data['subview'] 		= $this->load->view("admin/leave/emp_leave", $data, TRUE);
									$this->load->view('admin/layout/layout_main', $data); 
	    }
   }


   public function leave_delete($id)
   {
		$this->db->where('leave_id', $id);
		$this->db->delete('xin_leave_applications');
		$this->session->set_flashdata('success', 'Successfully Delete Done');
		redirect('admin/leave/emp_leave');
   }
	
   public function emp_holyday(){
		$session = $this->session->userdata('username');
		//  dd($session['user_id']);
		if(empty($session)){ 
			redirect('admin/');
		}
		$session = $this->session->userdata( 'username' );
		$userid  = $session[ 'user_id' ];
		$firstdate = $this->input->post('firstdate');
		$seconddate = $this->input->post('seconddate');

		$this->db->select("*");
		if ($firstdate!=null && $seconddate!=null){
			$f1_date=date('Y-m-d',strtotime($firstdate));
			$f2_date=date('Y-m-d',strtotime($seconddate));
			$this->db->where("start_date BETWEEN '$f1_date' AND '$f2_date'");
			$this->db->order_by("holiday_id", "desc");
			$data['allevent']   = $this->db->get('xin_holidays')->result();
			$data['tablebody'] = $this->load->view("admin/leave/emp_holyday_table", $data, TRUE);
			echo $data['tablebody'] ;
		}else{
			$this->db->order_by("holiday_id", "desc");
			$data['allevent'] = $this->db->get('xin_holidays')->result();
			$data['session']     = $session;
			$data['title'] 		 = 'Holyday | '.$this->Xin_model->site_title();
			$data['breadcrumbs'] = 'Holyday';
			$data['tablebody'] 	 = $this->load->view("admin/leave/emp_holyday_table", $data, TRUE);
			

			$data['subview'] 	 = $this->load->view("admin/leave/emp_holyday", $data, TRUE);
								   $this->load->view('admin/layout/layout_main', $data); 
		}
	}
} 
?>