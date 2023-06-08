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
		$this->load->helper('form');
		// $this->load->library('Pdf');
		// $this->load->helper('string');
	}
	
	//================= Requisition here =======================
	public function index($id = null)
	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

        //Validation
        $this->form_validation->set_rules('cat_id[]', 'select category', 'required|trim');
        $this->form_validation->set_rules('product_id[]', 'item name', 'required|trim');
        $this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');

		//Validate and input data
		if ($this->form_validation->run() == true){
			$hid = $this->input->post('hidden_id');
			if($hid == null && empty($hid)) {
				$ids = $this->Inventory_model->save('products_requisitions', ['user_id'=>$session['user_id']]);
				$last_id = $this->db->insert_id();
			} else {
				$last_id = $hid;
			}

			for ($i=0; $i<sizeof($_POST['cat_id']); $i++) {
				$form_data[] = array(
					'cat_id'		 => $_POST['cat_id'][$i],
					'sub_cate_id'	 => $_POST['sub_cate_id'][$i],
					'product_id'	 => $_POST['product_id'][$i],
					'quantity'		 => $_POST['quantity'][$i],
					'requisition_id' => $last_id,
				);
			}  
			
			if ($hid != null && !empty($hid)) {
				$this->db->where('id', $hid)->update_batch('products_requisition_details', $form_data);
				$this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->db->insert_batch('products_requisition_details', $form_data)){
					$this->session->set_flashdata('success', 'Successfully Insert Done');
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}	
			return redirect('admin/inventory');
		}


		$data['title'] = $this->lang->line('xin_employees').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] = 'inventory';
		//Dropdown
		$data['categorys']		= $this->db->get("products_categories")->result();
		$data['products'] 		= $this->Inventory_model->purchase_products($session['user_id'],$session['role_id']);
		// dd($data['products']);
		$data['results'] 		= $this->Inventory_model->product_list();
		$data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
		$data['units'] 			= $this->db->get("product_unit")->result();
		$data['col'] 			= $id;
		$data['user_role_id'] 	= $session['role_id'];

		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/inventory/index", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
	}

	public function requsition_details($id)	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] 		 = 'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] 	 = 'inventory';
		if($session['role_id']==1){
			$data['results']	 = $this->Inventory_model->requisition_details($id);
			if(!empty($data['results'])){
				$data['requisition_id'] 	 = $data['results'][0]->requisition_id;
			}
		    $data['status'] = $this->db->select('status')->where('id',$id)->get('products_requisitions')->row()->status;
									
	    } else {
			  $data['results']	 = $this->Inventory_model->req_details_cat_wise($id);
									
	    }
		$data['subview'] 	 = $this->load->view("admin/inventory/requsition_details", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function requsition_rejected($id){
		// dd($id);
		$log_user=$_SESSION['username']['user_id'];
		$this->db->where('id',$id)->update('products_requisitions',['updated_by'=>$log_user]);
		$approved = $this->db->where('id',$id)->update('products_requisitions',['status'=>4]);
		if($approved){
			 $this->session->set_flashdata('warning', ' Requsition Status Rejected .');
		     redirect("admin/inventory/index","refresh");
		}
	}

	public function requsition_edit_approved($id){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title']       = 'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url']    = 'inventory';
	    $data['results'] 	 = $this->Inventory_model->requisition_details($id);
		if(!empty($data['results'])){
			$data['requisition_id'] 	 = $data['results'][0]->requisition_id;
		}else{
			$data['requisition_id'] 	 = '';
		}
		
		$data['subview'] 	 = $this->load->view("admin/inventory/edit_approve", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data);
	}
	
	public function persial_approved($id){
		
		$session = $this->session->userdata('username');
		$all_detail=$this->db->where('requisition_id',$id)->get('products_requisition_details')->result();
		foreach($all_detail as $key=>$value){
			$d1[]= $this->db->where('id',$all_detail[$key]->product_id)->get('products')->row();
			
		}
		
		$quantity=$this->input->post('qunatity[]');
		$r_did=$this->input->post('r_id[]');
		// dd($d1);
		// dd($d1[1]->quantity);
		foreach($d1 as $k=>$v){
			if($session['role_id']==1){
					if($d1[$k]->quantity >= $quantity[$k]) {
						
						foreach($quantity as $key=>$value){
							$log_user=$_SESSION['username']['user_id'];
							$this->db->where('id',$id)->update('products_requisitions',['updated_by'=>$log_user]);
							$this->db->where('id',$r_did[$key])->update('products_requisition_details',['approved_qty'=>$value]); }

					} else{
						// dd($d1[$k]->product_name);
						$variable = $d1[$k]->product_name;
						$variable1= $d1[$k]->quantity;
						$this->session->set_flashdata('flash_data', $variable);
						$this->session->set_flashdata('flash_data1', $variable1);

						$this->session->set_flashdata('warning', 'Approved  Quantity is Biger ');
						redirect("admin/inventory/requsition_details/$id","refresh");
					}
			}else{

				foreach($quantity as $key=>$value){

				     $this->db->where('id',$r_did[$key])->update('products_requisition_details',['quantity'=>$value]); 
				 }
					$this->session->set_flashdata('success', 'Product Updated Successfully.');
				    redirect("admin/inventory/index","refresh");
			}

		}
			if($session['role_id'] == 1){
			$approved = $this->db->where('id',$id)->update('products_requisitions',['status'=>2]);
				if($approved){
							$this->session->set_flashdata('success', 'Updated Successfully.');
							redirect("admin/inventory/index","refresh");
						}
				}
			
	}

	public function hand_over($id=null){
		
					$pr1=$this->db->where('requisition_id',$id)->get('products_requisition_details')->result();
					
					$mergedArray = [];
			foreach ($pr1 as $item) {
				$productId = $item->product_id;
				if (isset($mergedArray[$productId])) {
					$mergedArray[$productId]->approved_qty += $item->approved_qty;
				} else {
					$mergedArray[$productId] = $item;
				}
			}

			$mergedArray = array_values($mergedArray);
			
			
			$p1=$this->db->get('products')->result();

			$result = array();
			foreach ($p1 as $item1) {
				foreach ($pr1 as $item2) {
					if ($item1->id == $item2->product_id) {
						$mergedItem = (object)array_merge((array)$item1, (array)$item2);
						$mergedItem->total_quantity = $item1->quantity - $item2->approved_qty;
						$result[] = $mergedItem;
						break;
					}
				}
			}

			foreach ($result as $row) {
				
				$data = array(
					'id' => $row->product_id,
				'quantity' => $row->total_quantity,
				); 
				$this->db->where('id',$row->product_id)->update('products', $data);
			}		

			$deliver=$this->db->where('id',$id)->update('products_requisitions',['status'=>3]);
			if($deliver){
				$this->session->set_flashdata('success', 'Handover Successfully.');
				redirect("admin/inventory/index","refresh");
			}
		
	}


	//================= Requisition end =======================


	//=============== suplier ========================
	public function supplier($id = null){

		$session = $this->session->userdata('username');
		//  dd($session);
		if(empty($session)){ 
			redirect('admin/');
		}

		$this->form_validation->set_rules('name', 'Sapplier name', 'required|trim');
		$this->form_validation->set_rules('company_name', 'company', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim');
		$this->form_validation->set_rules('address', 'address', 'required|trim');

		if ($this->form_validation->run() == true){
				$supplier_data=[ 
						'name'		 => $_POST['name'],
						'company'	 => $_POST['company_name'],
						'phone'	 => $_POST['phone'],
						'address'		 => $_POST['address'],
					  ];				 
									
			if ($hid = $this->input->post('hid')) {
				$this->db->where('id', $hid)->update('product_supplier', $supplier_data);
				$this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->Inventory_model->save('product_supplier', $supplier_data)){
					$this->session->set_flashdata('success', 'Successfully Insert Done');
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}
	    }
						

        //Dropdown
		$data['title'] 			= 'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Inventory';
		$data['path_url'] 		= 'inventory';
	    $data['products']		= $this->db->get("product_supplier")->result();
	    $data['col'] 			= $id;
	    $data['user_role_id'] 	= $session['role_id'];
		
		$data['subview'] 		= $this->load->view("admin/inventory/supplier", $data, TRUE);
								  $this->load->view('admin/layout/layout_main', $data); //page load
}

	public function supplier_detail($id){
		//search supplier details
		$this->db->where('id', $id);
		$data['result'] = $this->db->get('product_supplier')->row();
		dd($data['result']);

		$data['title'] 			= 'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Inventory';
		$data['path_url'] 		= 'inventory';
	 
		// dd($data['products']);
		$data['subview'] 		= $this->load->view("admin/inventory/supplier_details", $data, TRUE);
								  $this->load->view('admin/layout/layout_main', $data);

}

	public function get_supplier_ajax()
	{
		 $name_company= $_POST['companyName'];
		 $this->db->like('company', $name_company);
        $result = $this->db->get('product_supplier')->result();
		header('Content-Type: application/x-json; charset=utf-8');
		echo (json_encode($result));
	}

	public function get_supplier_details_ajax($id)
	{   
		$this->db->where('id', $id);
		$result = $this->db->get('product_supplier')->row();
		header('Content-Type: application/x-json; charset=utf-8');
		echo (json_encode($result));
	}

	//==================== suplier part end ========================




//================= Product requsition purches code here =======================

public function purchase($id = null)
{
	$session = $this->session->userdata('username');
	//   dd($session);
	if(empty($session)){ 
		redirect('admin/');
	}
	 

	//   //Validation
	  $this->form_validation->set_rules('spl_name', 'Sapplier name', 'required|trim');
	  $this->form_validation->set_rules('cmp_name', 'select category', 'required|trim');
	  $this->form_validation->set_rules('cat_id[]', 'select category', 'required|trim');
	  $this->form_validation->set_rules('sub_cate_id[]', 'select category', 'required|trim');
	  $this->form_validation->set_rules('product_id[]', 'item name', 'required|trim');
	  $this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');

	//   //Validate and input data
	if ($this->form_validation->run() == true){
		$supplier_id=$_POST['spl_name'];
		$company=$_POST['cmp_name'];
		$ids=$this->Inventory_model->save('products_purches', ['user_id'=>$session['user_id'],'	supplier'=>$supplier_id]);
		$last_id=$this->db->insert_id();
		
		for ($i=0; $i<sizeof($_POST['cat_id']); $i++) {
			$form_data[] = array( 
				'product_id'	 => $_POST['product_id'][$i],
				'quantity'		 => $_POST['quantity'][$i],
				'purches_id' => $last_id,
			);}
			//   dd($form_data);
			if ($hid = $this->input->post('hidden_id')) {
				$this->db->where('id', $hid)->update_batch('products_requisition_details', $form_data);
				$this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->db->insert_batch('products_purches_details', $form_data)){
					$this->session->set_flashdata('success', 'Successfully Insert Done');
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}		
		
		
		return redirect('admin/inventory/purchase');
	}

	//Dropdown
	$data['title'] 			= 'Inventory | '.$this->Xin_model->site_title();
	$data['breadcrumbs']	= 'Inventory';
	$data['path_url'] 		= 'inventory';
	$data['categorys']		= $this->db->get("products_categories")->result();
	$data['products'] 		= $this->Inventory_model->purchase_products_requisition($session['user_id'],$session['role_id']);

	// dd($data['products']);
	$data['results'] 		= $this->Inventory_model->product_list();
	$data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
	$data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
	$data['units'] 			= $this->db->get("product_unit")->result();
	$data['col'] 			= $id;
	$data['user_role_id'] 	= $session['role_id'];
	if ($id != null) {
		$data['row'] 		= $this->db->where('id',$id)->get("products")->row();
	}
	$data['subview'] 		= $this->load->view("admin/inventory/purchase", $data, TRUE);
							  $this->load->view('admin/layout/layout_main', $data); //page load
}
	
	public function product_purchase_details($id)	{
		//  dd($id);
		// dd($_SESSION);
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] 		 = 'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url'] 	 = 'inventory';
		if($session['role_id']==1){
		$data['results']	 = $this->Inventory_model->product_purches_details($id);
		// dd($data['results']);
		
		 if(!empty($data['results'])){
			$data['purches_id'] 	 = $data['results'][0]->purches_id;
			// dd($data['requisition_id']);
		 }
		//  $data['requisition_id'] 	 = $data['results'][0]->requisition_id;
	          $data['status']      = $this->db->select('status')->where('id',$id)->get('products_purches')->row()->status;												    // dd($data['results']);
	          $data['status']      = $this->db->select('status')->where('id',$id)->get('products_purches')->row()->status;												    // dd($data['results']);
										
		}
		else{
			 $data['results']	 = $this->Inventory_model->req_details_cat_wise($id);
		}
		
	    // $data['user_id'] 	 = $id;
		$data['subview'] 	 = $this->load->view("admin/inventory/product_purches_details", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}


    //product purches rejected by specific user
	public function product_purchase_rejected($id){
		// dd($id);
		$log_user=$_SESSION['username']['user_id'];
		$this->db->where('id',$id)->update('products_purches',['updated_by'=>$log_user]);
		$approved = $this->db->where('id',$id)->update('products_purches',['status'=>4]);
		if($approved){
			$this->session->set_flashdata('warning', ' Requsition Status Rejected .');
		 redirect("admin/inventory/purchase","refresh");
		}
	}


	//product purches edit form load here
	
	public function product_purchase_edit_approved($id){
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title']       = 'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Inventory';
		$data['path_url']    = 'inventory';
	    $data['results'] 	 = $this->Inventory_model->product_requisition_details($id);
		// dd($data['results']);
	    // $data['user_id'] 	 = $id;
		// dd($data['results']);
		 

		 if(!empty($data['results'])){
			$data['purches_id'] 	 = $data['results'][0]->purches_id;
		}else{
			$data['purches_id']  	 = '';
		}
	
		 
		$data['subview'] 	 = $this->load->view("admin/inventory/product_purches_edit_approve", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data);
	}

	//approved by prisal product purches edit
	public function product_persial_approved($id){
		
	    $session = $this->session->userdata('username');
		$all_detail=$this->db->where('purches_id',$id)->get('products_purches_details')->result();
		// dd($all_detail);
		foreach($all_detail as $key=>$value){
			$d1[]= $this->db->where('id',$all_detail[$key]->product_id)->get('products')->row();
			
		}
		
		$quantity=$this->input->post('qunatity[]');
		$r_did=$this->input->post('r_id[]');
		
		foreach($d1 as $k=>$v){
			
				 foreach($quantity as $key=>$value){
					$log_user=$_SESSION['username']['user_id'];
					if($session['role_id']==1){
					$this->db->where('id',$id)->update('products_purches',['updated_by'=>$log_user]);
                    $this->db->where('id',$r_did[$key])->update('products_purches_details',['ap_quantity'=>$value]);}else{
						$this->db->where('id',$r_did[$key])->update('products_purches_details',['quantity'=>$value]);
					} }
			 }
			 if($session['role_id']==1){ $approved = $this->db->where('id',$id)->update('products_purches',['status'=>2]);
				if($approved){
					$this->session->set_flashdata('success', 'Updated Successfully.');
					redirect("admin/inventory/purchase","refresh");
		        }
			}
		  else{
					$this->session->set_flashdata('success', ' product Updated Successfully.');
				    redirect("admin/inventory/purchase","refresh");
				 }
	
	}


	public function product_purchase_delivered($id){
    

			$this->db->select('p.product_name, p.quantity as  qty, pr.*');
			$this->db->from('products_purches_details pr');
			$this->db->from('products p');
			$this->db->where('p.id = pr.product_id');
			$this->db->where('purches_id', $id);
			$array = $this->db->get()->result();
		
	 
			 foreach ($array as $row) {
				 $ff = $row->qty + $row->ap_quantity;
				 $data = array(
					 'id' => $row->product_id,
					'product_name' => $row->product_name,
					'quantity' => $row->qty + $row->ap_quantity,
				 ); 
				 
				 $deliver = $this->db->where('id',$row->product_id)->update('products', $data);
			 }
		
	 

			 $deliver=$this->db->where('id',$id)->update('products_purches',['status'=>3]);
			 if($deliver){
				 $this->session->set_flashdata('success', 'Delivered Successfully.');
				 redirect("admin/inventory/purchase","refresh");
			 }
	 
 
}


 

	// ================ default ====================
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
		$data[0]= 'Select Product';
        foreach ($result as $rows) {
            $data[$rows['id']] = $rows['product_name'];
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($data));
	}

	public function delete_requsiton_item($id,$rid){
		
		$approved = $this->db->where('id',$id)->delete('products_requisition_details');
		if($approved){
			$this->session->set_flashdata('warning', 'Requsiton deleted successfully.');
		 redirect("admin/inventory/requsition_edit_approved/".$rid);
		  
		}
	}
	public function delete_purches_item($id,$pid){
		
		$approved = $this->db->where('id',$id)->delete('products_purches_details');
		if($approved){
			$this->session->set_flashdata('warning', 'Requsiton deleted successfully.');
		 redirect("admin/inventory/product_purchase_edit_approved/".$pid);
		}
	}


	


}
?>