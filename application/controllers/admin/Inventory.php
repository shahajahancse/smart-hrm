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
		// $this->load->library('Pdf');
		// $this->load->helper('string');
	}

	public function index()
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();

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

	public function purchase($id = null)
	{

		$session = $this->session->userdata('username');
		// dd($session);
		if(empty($session)){ 
			redirect('admin/');
		}
		if(isset($_POST['btn'])){

			for ($i=0; $i<sizeof($_POST['cat_id']); $i++) {
			$requisition_data=[ 
								'cat_id' => $_POST['cat_id'][$i],
								'sub_cate_id'=>$_POST['sub_cate_id'][$i],
								'product_id'=>$_POST['product_id'][$i],
								'quantity'=>$_POST['quantity'][$i],
								'requisition_id'=>$_POST['user_id'],
					];
			// dd($requisition_data);	
			if ($hid = $this->input->post('hidden_id')) {
				$this->db->where('id', $hid)->update('purchase_requisitions', $requisition_data);
		        $this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->Inventory_model->save('purchase_requisitions', $requisition_data)){
			        $this->session->set_flashdata('success', 'Successfully Insert Done');
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}
		}
		redirect('admin/inventory/purchase');
			
		}				

        //Dropdown
		$data['title'] = 'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';
	    $data['categorys'] = $this->db->get("products_categories")->result();
	    $data['products'] = $this->Inventory_model->purchase_products($session['user_id'],$session['role_id']);
	    $data['results'] = $this->Inventory_model->product_list();
	    $data['sub_categorys'] = $this->db->get("products_sub_categories")->result();
	    $data['units'] = $this->db->get("product_unit")->result();
	    $data['col'] = $id;
	    $data['user_role_id'] = $session['role_id'];
		if ($id != null) {
			$data['row'] = $this->db->where('id',$id)->get("products")->row();
		}


		$data['subview'] = $this->load->view("admin/inventory/purchase", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function products($id = null)
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

      //Validation
      $this->form_validation->set_rules('cat_id', 'select category', 'required|trim');
      $this->form_validation->set_rules('sub_cate_id', 'select sub category', 'required|trim');
      $this->form_validation->set_rules('unit_id', 'select unit', 'required|trim');
      $this->form_validation->set_rules('product_name', 'item name', 'required|trim');

		//Validate and input data
		if ($this->form_validation->run() == true){
			$form_data = array(
			    'cat_id'        => $this->input->post('cat_id'),
			    'sub_cate_id'   => $this->input->post('sub_cate_id'),
			    'product_name'  => $this->input->post('product_name'),
			    'unit_id'       => $this->input->post('unit_id'),
			    'quantity'      => $this->input->post('quantity'),
			    'order_level'   => $this->input->post('order_level')
			);           

			if ($hid = $this->input->post('hidden_id')) {
				$this->db->where('id', $hid)->update('products', $form_data);
		        $this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->Inventory_model->save('products', $form_data)){
			        $this->session->set_flashdata('success', 'Successfully Insert Done');
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}
			redirect('admin/inventory/products');
		}

        //Dropdown
		$data['title'] = 'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';
	    $data['results'] = $this->Inventory_model->product_list();
	    $data['categorys'] = $this->db->get("products_categories")->result();
	    $data['sub_categorys'] = $this->db->get("products_sub_categories")->result();
	    $data['units'] = $this->db->get("product_unit")->result();
	    $data['col'] = $id;
		if ($id != null) {
			$data['row'] = $this->db->where('id',$id)->get("products")->row();
		}

		$data['subview'] = $this->load->view("admin/inventory/products", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}


	public function unit($id = null)
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';

		//Validate and input data
      	$this->form_validation->set_rules('unit_name', 'Unit name', 'required|trim');
      	$this->form_validation->set_rules('status', 'Status Feild', 'required|trim');
		if ($this->form_validation->run() == true){
			$form_data = array(
			    'unit_name'        => $this->input->post('unit_name'),
			    'description'   => $this->input->post('description'),
			    'status'       => $this->input->post('status'),
			);           

			if ($hid = $this->input->post('hidden_id')) {
				$this->db->where('id', $hid)->update('product_unit', $form_data);
		        $this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->Inventory_model->save('product_unit', $form_data)){
			        $this->session->set_flashdata('success', 'Successfully Insert Done');
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}
			redirect('admin/inventory/unit');
		}

		if ($id != null) {
			$data['row'] = $this->db->where('id',$id)->get("product_unit")->row();
		}
		$data['results'] = $this->db->order_by('id','DESC')->get("product_unit")->result();
		$data['subview'] = $this->load->view("admin/inventory/unit", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function category($id = null)
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';

		//Validate and input data
      	$this->form_validation->set_rules('category_name', 'Category name', 'required|trim');
      	$this->form_validation->set_rules('status', 'Status Feild', 'required|trim');
		if ($this->form_validation->run() == true){
			$form_data = array(
			    'category_name'  => $this->input->post('category_name'),
			    'description'    => $this->input->post('description'),
			    'status'         => $this->input->post('status'),
			);           

			if ($hid = $this->input->post('hidden_id')) {
				$this->db->where('id', $hid)->update('products_categories', $form_data);
		        $this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->Inventory_model->save('products_categories', $form_data)){
			        $this->session->set_flashdata('success', 'Successfully Insert Done');
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}
			redirect('admin/inventory/category');
		}

		if ($id != null) {
			$data['row'] = $this->db->where('id',$id)->get("products_categories")->row();
		}
		$data['results'] = $this->db->order_by('id','DESC')->get("products_categories")->result();
		$data['subview'] = $this->load->view("admin/inventory/category", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function sub_category($id = null)
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';

		//Validate and input data
      	$this->form_validation->set_rules('cate_id', 'category name', 'required|trim');
      	$this->form_validation->set_rules('sub_cate_name', 'sub category name', 'required|trim');
      	$this->form_validation->set_rules('status', 'Status Feild', 'required|trim');
		if ($this->form_validation->run() == true){
			$form_data = array(
			    'cate_id'  		 => $this->input->post('cate_id'),
			    'sub_cate_name'  => $this->input->post('sub_cate_name'),
			    'status'         => $this->input->post('status'),
			);           

			if ($hid = $this->input->post('hidden_id')) {
				$this->db->where('id', $hid)->update('products_sub_categories', $form_data);
		        $this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->Inventory_model->save('products_sub_categories', $form_data)){
			        $this->session->set_flashdata('success', 'Successfully Insert Done');
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}
			redirect('admin/inventory/sub_category');
		}

		if ($id != null) {
			$data['row'] = $this->db->where('id',$id)->get("products_sub_categories")->row();
		}
		// dd($data['row']);
		$data['categorys'] = $this->db->order_by('id','DESC')->get("products_categories")->result();
		$data['results'] = $this->Inventory_model->sub_category_list(); 
		$data['subview'] = $this->load->view("admin/inventory/sub_category", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function get_sub_category_ajax($cate_id)
	{
        $this->db->where('cate_id',$cate_id);
        $result = $this->db->get('products_sub_categories')->result_array();
        foreach ($result as $rows) {
            $data[$rows['id']] = $rows['sub_cate_name'];
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($data));
	}
	public function get_product_ajax($sub_cate_id)
	{
        $this->db->where('sub_cate_id',$sub_cate_id);
        $result = $this->db->get('products')->result_array();
        foreach ($result as $rows) {
            $data[$rows['id']] = $rows['product_name'];
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($data));
	}

}
?>