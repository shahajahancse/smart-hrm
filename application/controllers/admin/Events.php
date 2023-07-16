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

class Events extends MY_Controller
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
		  $this->load->model('Events_model');
		  $this->load->model('Meetings_model');
		  $this->load->model('Department_model');
		  $this->load->model('Attendance_model');
     }
	 
	public function index() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_events!='true'){
			redirect('admin/dashboard');
		}
		$this->db->select("*");
		$this->db->order_by("start_event_date", "desc");
		$data['allevent']= $this->db->get('xin_events')->result();
		$data['title'] = $this->lang->line('xin_hr_events').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_hr_events');
		$data['path_url'] = 'events';
		$data['get_all_companies'] = $this->Xin_model->get_companies();
	
		$data['all_employees'] = $this->Xin_model->all_employees();
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$data['subview'] = $this->load->view("admin/events/events_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}
	
	//events calendar
	public function calendar() {
	
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_events!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('xin_hr_events_calendar');
		$data['breadcrumbs'] = $this->lang->line('xin_hr_events_calendar');
		$data['all_events'] = $this->Events_model->get_events();
		$data['all_meetings'] = $this->Meetings_model->get_meetings();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['path_url'] = 'event_calendar';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		//if(in_array('100',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/events/calendar_events", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		//} else {
		//	redirect('admin/dashboard');
		//}
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
			$this->load->view("admin/events/get_employees", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	
	
	 // Validate and add info in database
	public function add_event() {
		
		/* Define return | here result is used to return user data and error for error message */
	
		$current_date = date('Y-m-d');
		$event_note = $this->input->post('event_note');
		
		$ct_date = strtotime($current_date);
		$qt_event_note = htmlspecialchars(addslashes($event_note), ENT_QUOTES);

		$startdate=date('Y-m-d H:i:s',strtotime($this->input->post('start_event_date').' '.$this->input->post('start_event_time')));
		$enddate=date('Y-m-d H:i:s',strtotime($this->input->post('end_event_date').' '.$this->input->post('end_event_time')));

// dd($startdate.' '.$enddate);
$dateTime1 = new DateTime($startdate);
$dateTime2 = new DateTime($enddate);

// Calculate the difference
$interval = $dateTime1->diff($dateTime2);

// Format the output
$days = $interval->format('%a');
$hours = $interval->format('%h');
$minutes = $interval->format('%i');

$output = "";

if ($days > 0) {
    $output .= $days . " day ";
}

if ($hours > 0) {
    $output .= $hours . ":" . $minutes . " h";
} else {
    $output .= $minutes . " min";
}




		$data = array(
		'company_id' => 1,
		'event_title' => $this->input->post('event_title'),
		'location' => $this->input->post('location'),
		'start_event_date' => $this->input->post('start_event_date'),
		'start_event_time' => $this->input->post('start_event_time'),
		'end_event_date' => $this->input->post('end_event_date'),
		'end_event_time' => $this->input->post('end_event_time'),
		'event_duration' => $output,
		'event_note' => $qt_event_note,
		'created_at' => date('Y-m-d')
		);
		$result = $this->Events_model->add($data);
		redirect('admin/events');
	}
	
	// Validate and add info in database
	public function edit_event() {
	
		if($this->input->post('edit_type')=='event') {
			
		$id = $this->uri->segment(4);		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		$event_date = $this->input->post('event_date');
		$current_date = date('Y-m-d');
		$event_note = $this->input->post('event_note');
		$ev_date = strtotime($event_date);
		$ct_date = strtotime($current_date);
		$qt_event_note = htmlspecialchars(addslashes($event_note), ENT_QUOTES);
			
		/* Server side PHP input validation */		
		if($this->input->post('event_title')==='') {
        	$Return['error'] = $this->lang->line('xin_error_event_title_field');
		} else if($this->input->post('event_date')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_date_field');
		} else if($ev_date < $ct_date) {
			$Return['error'] = $this->lang->line('xin_error_event_date_current_date');
		} else if($this->input->post('event_time')==='') {
			$Return['error'] = $this->lang->line('xin_error_event_time_field');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'event_title' => $this->input->post('event_title'),
		'event_date' => $this->input->post('event_date'),
		'event_time' => $this->input->post('event_time'),
		'event_note' => $qt_event_note
		);
		$result = $this->Events_model->update_record($data,$id);
				
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_hr_success_event_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	// get record of event
	public function read_event_record()
	{
		$data['title'] = $this->Xin_model->site_title();
		$event_id = $this->input->get('event_id');
		$result = $this->Events_model->read_event_information($event_id);
		
		$data = array(
				'event_id' => $result[0]->event_id,
				'employee_id' => $result[0]->employee_id,
				'company_id' => $result[0]->company_id,
				'event_title' => $result[0]->event_title,
				'event_date' => $result[0]->event_date,
				'event_time' => $result[0]->event_time,
				'event_note' => $result[0]->event_note,
				'all_employees' => $this->Xin_model->all_employees(),
				'get_all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/events/dialog_events', $data);
		} else {
			redirect('admin/');
		}
	}
		
	public function delete_event($id) {
		
			// Define return | here result is used to return user data and error for error message 
			$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
			
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			$result = $this->Events_model->delete_event_record($id);
			if(isset($id)) {
				$Return['result'] = $this->lang->line('xin_hr_success_event_deleted');
			} else {
				$Return['error'] = $this->lang->line('xin_error_msg');
			}
			redirect('admin/events');
		
	}


	public function company_policy(){

        $session = $this->session->userdata('username');
        if (empty($session)) {
            redirect('admin/');
        }

        
        $this->form_validation->set_rules('editor', 'Policy name', 'required|trim');
		$this->form_validation->set_rules('title', 'title name', 'required|trim');
      
        //Validate and input data
        if ($this->form_validation->run() == true){
			$use_id=$session['user_id'];
			$title=$this->input->post('title');
			
            $policy       = $this->input->post('editor');
        
                $data[] = array(
					
					'company_id' => 1,
                    'title' => $title, 
                    'description' => $policy,
					'added_by' => $use_id,
				   
				);
			

				
        
            $this->db->insert_batch('xin_company_policy', $data);
            $this->session->set_flashdata('success', 'Successfully insert done');
            return redirect('admin/events/company_policy');
        }


		// $data['employees'] = $this->Lunch_model->all_employees();
        $data['title'] = $this->lang->line('xin_employees') . ' | ' . $this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Policy Entry';
        $data['path_url'] = 'Company Policy';
        if (!empty($session)) {
            $data['subview'] = $this->load->view("admin/dashboard/company_policy", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }

    }

	// get record of event
	public function get_policy($id){
	 $result =$this->db->select('*')->where('policy_id',$id)->from('xin_company_policy');
	 $this->db->where('policy_id',$id);
	 $data= $this->db->get('products')->result_array();
	 
	 header('Content-Type: application/x-json; charset=utf-8');
	 echo (json_encode($data));
	
	

	}
	
	public function epm_event(){
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
			$this->db->where("start_event_date BETWEEN '$f1_date' AND '$f2_date'");
			$this->db->order_by("event_id", "desc");
			$data['allevent']   = $this->db->get('xin_events')->result();
			$data['tablebody'] = $this->load->view("admin/events/epm_event_table", $data, TRUE);
			echo $data['tablebody'] ;
		}else{
			$this->db->order_by("event_id", "desc");
			$data['allevent'] = $this->db->get('xin_events')->result();
			$data['shift']       = $this->db->where('office_shift_id',1)->get('xin_office_shift')->row();
			$data['session']     = $session;
			$data['title'] 		 = 'Events | '.$this->Xin_model->site_title();
			$data['breadcrumbs'] = 'Events';
			$data['tablebody'] 	 = $this->load->view("admin/events/epm_event_table", $data, TRUE);
			

			$data['subview'] 	 = $this->load->view("admin/events/epm_event", $data, TRUE);
								   $this->load->view('admin/layout/layout_main', $data); 
		}
	}
	 
	 
} 
?>