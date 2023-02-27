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

class Inventory extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the models
		$this->load->model("Inventory_model");
		$this->load->model("Xin_model");
		$this->load->library('Pdf');
		$this->load->helper('string');
	}

	public function index()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		/*$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();*/
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';
		$role_resources_ids = $this->Xin_model->user_role_resource();

		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/inventory/index", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}

	}

	public function products()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

      //Validation
      $this->form_validation->set_rules('cat_id', 'select category', 'required|trim');
      $this->form_validation->set_rules('sub_cate_id', 'select sub category', 'required|trim');
      $this->form_validation->set_rules('unit_id', 'select unit', 'required|trim');
      $this->form_validation->set_rules('item_name', 'item name', 'required|trim');

		//Validate and input data
		if ($this->form_validation->run() == true){
			$form_data = array(
			    'cat_id'        => $this->input->post('cat_id'),
			    'sub_cate_id'   => $this->input->post('sub_cate_id'),
			    'unit_id'       => $this->input->post('unit_id'),
			    'product_name'  => $this->input->post('product_name'),
			    'quantity'      => $this->input->post('quantity'),
			    'order_level'   => $this->input->post('order_level')
			);           

			// print_r($form_data); exit;
			if($this->Inventory_model->save('products', $form_data)){
		        $response = ['status' => 'success', 'message' => "Successfully Insert Done"];
		        echo json_encode( $response );
				exit;
			} else {
				$response = ['status' => 'error', 'message' => "Sorry Something Wrong."];
		        echo json_encode( $response );
		        exit;
			}
		}



        //Dropdown
		$data['title'] = 'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';
	    $data['categories'] = $this->Inventory_model->get_categories();
	    $data['units'] = $this->Inventory_model->get_units();
		$data['results'] = $this->db->order_by('id','DESC')->get("products")->result();

		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/inventory/products", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}

	}


	public function unit()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		/*$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();*/
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';
		$role_resources_ids = $this->Xin_model->user_role_resource();

		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/inventory/unit", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}

	}

	public function category()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		/*$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();*/
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';
		$role_resources_ids = $this->Xin_model->user_role_resource();

		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/inventory/category", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}

	}

	public function sub_category()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		/*$data['all_departments'] = $this->Department_model->all_departments();
		$data['all_designations'] = $this->Designation_model->all_designations();
		$data['all_user_roles'] = $this->Roles_model->all_user_roles();
		$data['all_office_shifts'] = $this->Employees_model->all_office_shifts();
		$data['get_all_companies'] = $this->Xin_model->get_companies();
		$data['all_leave_types'] = $this->Timesheet_model->all_leave_types();*/
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';
		$role_resources_ids = $this->Xin_model->user_role_resource();

		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/inventory/sub_category", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}

	}




	
}
?>