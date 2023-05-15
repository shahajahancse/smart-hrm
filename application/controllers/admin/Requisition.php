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

class Requisition extends MY_Controller {

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
		$this->load->model("Department_model");
		$this->load->model("Designation_model");
		// $this->load->model("Roles_model");
		// $this->load->model("Project_model");
		// $this->load->model("Location_model");
	}


	public function index()
	{
		# code...
		$data['title'] = 'requisition | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'requisition';
		$data['path_url'] = 'requisition';
		// $data['all_office_shifts'] = $this->Location_model->all_office_locations();
		// dd($data);
		$data['subview'] = $this->load->view("admin/requisition/index", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data);
	}





	

	
    public function create_requsition()
    {	$session = $this->session->userdata('username');
            
		
     	if (!empty($_POST)) {
	
			$comData = array(
	            'employee_id' => $this->input->post('emp_id'),
	            'date' 		  => $this->input->post('date'),
				'amount'      => $this->input->post('amount'),
	            'astatus'     => $session['role_id']==3?1:2,
	            'discription'	  => $this->input->post('description'),
	        );

	        if ($this->input->post('id') != null) {
	        	$comData = array(
		            
		            'discription'	  => $this->input->post('description'),
					'astatus'     => $session['role_id']==3?1:2,
		        );

		        $this->db->where('id', $this->input->post('id'))->update('xin_employee_requisition',$comData);
	        } else {
		        $this->db->insert('xin_employee_requisition',$comData);
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

	public function get_employee_ajax_request()
    {
    	$status = $this->input->get('status');
    	$data["employees"] = $this->Attendance_model->get_employee_ajax_request($status);
        echo json_encode($data);
    }
}