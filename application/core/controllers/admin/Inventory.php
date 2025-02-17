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
		
	}

	
	//================= Requisition here =======================

	public function index($id = null){
		// dd('test');
		$session = $this->session->userdata('username');
		$data['title'] = 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store';
		if($session['role_id']== 1 || $session['role_id']== 2 || $session['role_id']== 4 ){
			$data['products'] 	= $this->Inventory_model->purchase_products($session['user_id'],$session['role_id']);
		}
		$data['user_role_id'] 	= $session['role_id'];
		if(!empty($session)){ 
			if($session['role_id'] == 3){
				$data['subview'] = $this->load->view("admin/inventory/index", $data, TRUE);
			}else{
				$data['subview'] = $this->load->view("admin/inventory/index1", $data, TRUE);
			}
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
	}


	public function create($id = null) {
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
			for ($i=0; $i<sizeof($_POST['cat_id']); $i++) {
				$form_data[] = array(
					'user_id' 		   => $session['user_id'],
					'cat_id'		   => $_POST['cat_id'][$i],
					'sub_cate_id'	   => $_POST['sub_cate_id'][$i],
					'product_id'	   => $_POST['product_id'][$i],
					'quantity'		   => $_POST['quantity'][$i],
					'note'		   => $_POST['note'][$i],
					'priority'		   => $_POST['priority'][$i],
					'requisition_date' => $_POST['requisition_date'],
					'status'		   => 1,
					'created_at'     => date("y-m-d"),
				);
			}  
			if($this->db->insert_batch('products_requisition_details', $form_data)){
				$this->session->set_flashdata('success', 'Successfully Insert Done');
			} else {
				$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
			} 
			return redirect('admin/inventory');
		}

		$data['title'] 		    =     'Inventory | '.$this->Xin_model->site_title();
		$data['breadcrumbs']    =     'Store Create Requisition';
		$data['products'] 		=     $this->Inventory_model->purchase_products($session['user_id'],$session['role_id']);
		$data['results'] 		=     $this->Inventory_model->product_list();
		$data['user_role_id'] 	=     $session['role_id'];
		$data['subview'] 	    =     $this->load->view("admin/inventory/create", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function requisition_edit($id)
	{
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|trim');
       	if ($this->form_validation->run() == true){
			$data = array(
				'quantity' => $_POST['quantity'],
			);
			$this->db->where('id', $id)->update('products_requisition_details', $data);
			$this->session->set_flashdata('success', 'Successfully Updated Done');
		}
		return true;
	}

	public function pending_list(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		if ($session['role_id'] == 4) {
			$status = array(1,5,6);
		} elseif($session['role_id'] == 2){
			$status = array(1,5,6);
		} elseif($session['role_id'] == 1){
			$status = array(1,5,6);
		} else{
			$status = array(1);
		}
		$data['products'] = $this->Inventory_model->product_requisition($session['user_id'],$session['role_id'], $status);

		$data['title'] 		 = 'Store Pending List | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store Pending List';
		$data['user_role_id'] 	= $session['role_id'];

		$data['subview'] 	 = $this->load->view("admin/inventory/pending_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function persial_approved($id){

		$session = $this->session->userdata('username');
		$status = 1;
		$approved_qty = $this->input->post('approved_qty');
		$permission = $this->input->post('p_permission');
		$r_id = $this->input->post('r_id');
		//  manage permission to user wise
		if ($session['role_id'] == 2) {
			if ($permission == '0') {
				$status = 2;
			} else {
				$status = 6;
			}
		} elseif ($session['role_id'] == 1) {
			$status = 2;
		} elseif ($session['role_id'] == 4) {
			$status = 5;
		} else {
			redirect('admin/');
		}


		$data = array(
			'approved_qty' => $approved_qty,
			'status' 	   => $status,
			'updated_by'   => $session['user_id'],
		);

		$approved = $this->db->where('id',$r_id)->update('products_requisition_details',$data);
		if ($approved) {
			$this->session->set_flashdata('success', 'Product Updated Successfully.');
		    redirect("admin/inventory/pending_list");
		}
		
	}

	public function aproved_list(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['products'] = $this->Inventory_model->product_requisition($session['user_id'],$session['role_id'],array(2));
		$data['title'] 		 = 'Store Aproved List | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store Aproved List';
		$data['user_role_id'] 	= $session['role_id'];
		$data['subview'] 	 = $this->load->view("admin/inventory/approved_list", $data, TRUE);

		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function delivery_list(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['products'] 		= $this->Inventory_model->product_requisition($session['user_id'],$session['role_id'],3);
		$data['title'] 		 = 'Store Handover List | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store Handover List';
		$data['user_role_id'] 	= $session['role_id'];

		$data['subview'] 	 = $this->load->view("admin/inventory/requisition_status_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function reject_list(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}

		$data['products'] 		= $this->Inventory_model->product_requisition($session['user_id'],$session['role_id'],4);

		$data['title'] 		 = 'Store Reject List | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store Reject List';
		$data['user_role_id'] 	= $session['role_id'];

		$data['subview'] 	 = $this->load->view("admin/inventory/reject_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}










	public function create_phone($id = null) {
		$data['session'] = $this->session->userdata('username');
		if(empty($data['session'])){ 
			redirect('admin/');
		}
		$data['title'] 		 = 'Mobile Bill Requisition | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Mobile Bill Requisition';
	
		
		$data['subview'] 	    =     $this->load->view("admin/inventory/create_phone", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	// reqisition change status requsition_edit_approved
	public function requsition_edit_approved($id){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title']       = 'Requsition| '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Requsition ';
	    $data['row'] 	 = $this->Inventory_model->requisition_details($id);
		// dd($data);
		if(!empty($data['results'])){
			$data['requisition_id'] = $data['results'][0]->id;
		}else{
			$data['requisition_id'] = '';
		}
		// dd($data);
		$data['subview'] 	 = $this->load->view("admin/inventory/edit_approve", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data);
	}
	

	public function daily_pkg(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$this->db->select('requisition_package.*, products.product_name, products_categories.category_name, products_sub_categories.sub_cate_name');
		$this->db->from('requisition_package');
		$this->db->join('products', 'requisition_package.product_id = products.id');
		$this->db->join('products_categories', 'requisition_package.cat_id = products_categories.id');
		$this->db->join('products_sub_categories', 'requisition_package.sub_cate_id = products_sub_categories.id');
		$data['productdata'] = $this->db->get()->result();
		$data['title'] 		 = 'Daily Package | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Daily Package ';
		$data['session'] =$session ;
		$data['results'] 		=     $this->Inventory_model->product_list();
		$data['subview'] 	 = $this->load->view("admin/inventory/daily_pkg", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}
public function add_daily_package()
{
	// Delete all data from the 'requisition_package' table
	$this->db->truncate('requisition_package');
	// Access the values from $_POST
	$productIds = $_POST['product_id'];
	$subCateIds = $_POST['sub_cate_id'];
	$catIds = $_POST['cat_id'];
	$quantities = $_POST['quantity'];
	$unit_name = $_POST['unit_name'];
	// Loop through the arrays to insert the data into the table
	for ($i = 0; $i < count($productIds); $i++) {
		$data = array(
			'product_id' => $productIds[$i],
			'sub_cate_id' => $subCateIds[$i],
			'cat_id' => $catIds[$i],
			'quantity' => $quantities[$i],
			'unit_name' => $unit_name[$i]
		);
		$this->db->insert('requisition_package', $data);
	}
	$this->db->query("ALTER TABLE requisition_package AUTO_INCREMENT = 1");
	$mas="success";
	return $mas;
}

	public function adddaily_req(){
		$this->db->select('requisition_package.*, products.product_name, products_categories.category_name, products_sub_categories.sub_cate_name');
		$this->db->from('requisition_package');
		$this->db->join('products', 'requisition_package.product_id = products.id');
		$this->db->join('products_categories', 'requisition_package.cat_id = products_categories.id');
		$this->db->join('products_sub_categories', 'requisition_package.sub_cate_id = products_sub_categories.id');
		$data= $this->db->get()->result();
		echo json_encode($data);
	}

	public function first_step_aproved_list(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] 		 = 'Store First Step Aproved | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store First Step Aproved';
		$data['user_role_id'] 	= $session['role_id'];
		$data['products'] 		= $this->Inventory_model->product_requisition($session['user_id'],$session['role_id'],2);
		$data['subview'] 	 = $this->load->view("admin/inventory/requisition_status_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}


	public function requsition_details($id)	{
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
	    if($session['role_id']==3){
			$user_id=$session['user_id'];
	    };
		$data['title'] 		 = 'Requsition Details | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Requsition Details';
		$data['results']	 = $this->Inventory_model->requisition_details($user_id=null,$id);
		if(!empty($data['results'])){
			$data['id'] 	 = $id;
		}
		$data['status'] = $this->db->select('status')->where('id',$id)->get('products_requisition_details')->row()->status;								
		$data['subview'] 	 = $this->load->view("admin/inventory/requsition_details", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function requsition_approved($id){
	// dd($id);
		$log_user=$_SESSION['username']['user_id'];
		$this->db->where('id',$id)->update('products_requisitions',['updated_by'=>$log_user]);
		$approved = $this->db->where('id',$id)->update('products_requisition_details',['status'=>2]);
		if($approved){
			$this->db->where('requisition_id',$id)->update('products_requisition_details',['status'=>2]);
				$this->session->set_flashdata('warning', ' Requsition Status Rejected .');
				redirect("admin/inventory/index","refresh");
		}
	}

	public function requsition_rejected($id){
		// dd($id);
		$log_user=$_SESSION['username']['user_id'];
		$this->db->where('id',$id)->update('products_requisition_details',['updated_by'=>$log_user]);
		$approved = $this->db->where('id',$id)->update('products_requisition_details',['status'=>4]);
		if($approved){
			$this->db->where('id',$id)->update('products_requisition_details',['status'=>4]);

			 $this->session->set_flashdata('warning', ' Requsition Status Rejected .');
		     redirect("admin/inventory/index","refresh");
		}
	}

	public function requsition_approvedd($id){
		// dd($id);
		$log_user=$_SESSION['username']['user_id'];
		$this->db->where('id',$id)->update('products_requisitions',['updated_by'=>$log_user]);
		$approved = $this->db->where('id',$id)->update('products_requisitions',['status'=>2]);
		if($approved){
			$this->db->where('id',$id)->update('products_requisition_details',['status'=>2]);

			 $this->session->set_flashdata('success', ' Requsition Status Approved .');
		     redirect("admin/inventory/index","refresh");
		}
	}


	



	public function hand_over($id=null){
		
		$pr1=$this->db->where('id',$id)->get('products_requisition_details')->result();
					
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

			$deliver=$this->db->where('id',$id)->update('products_requisition_details',['status'=>3]);
			if($deliver){
				$this->db->where('id',$id)->update('products_requisition_details',['status'=>3]);

				$this->session->set_flashdata('success', 'Handover Successfully.');
				redirect("admin/inventory/index","refresh");
			}
		
	}
	//================= Requisition end =======================


	//================= Product requsition purches code here =======================

	public function purchase($id = null){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$this->form_validation->set_rules('cat_id[]', 'select category', 'required|trim');
		$this->form_validation->set_rules('sub_cate_id[]', 'select category', 'required|trim');
		$this->form_validation->set_rules('product_id[]', 'item name', 'required|trim');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');
		if ($this->form_validation->run() == true){
			for ($i=0; $i<sizeof($_POST['cat_id']); $i++) {
				$form_data[] = array( 
					'user_id'	      => $session['user_id'],
					'product_id'	  => $_POST['product_id'][$i],
					'quantity'		  => $_POST['quantity'][$i],
					'approx_amount'	  => $_POST['approx_amount'][$i],
					'approx_t_amount' => $_POST['total_amount'][$i],
					'created_at'	  => date('Y-m-d'),
					// 'status' => [$i],
				);
			}
			if ($hid = $this->input->post('hidden_id')) {
				$this->db->where('id', $hid)->update_batch('products_purches_details', $form_data);
				$this->session->set_flashdata('success', 'Successfully Updated Done');
			} else {
				if($this->db->insert_batch('products_purches_details', $form_data)){
					$this->session->set_flashdata('success', 'Successfully Insert Done');
					echo "<script>location.replace('purchase')</script>";
				} else {
					$this->session->set_flashdata('warning', 'Sorry Something Wrong.');
				}
			}		
		}
		//Dropdown
		$data['title'] 			= 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Store';
		$data['products'] 		= $this->Inventory_model->purchase_products_requisition($session['user_id'],$session['role_id']);
		$data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
		$data['user_role_id'] 	= $session['role_id'];
		if ($id != null) {
			$data['row'] 		= $this->db->where('id',$id)->get("products")->row();
		}
		$data['subview'] 		= $this->load->view("admin/inventory/purchase", $data, TRUE);
								  $this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function purchase_full(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		//Dropdown
		$data['title'] 			= 'Store | Purchase List';
		$data['breadcrumbs']	= 'Purchase List';
		$data['products'] 		= $this->Inventory_model->purchase_products_requisition($session['user_id'],$session['role_id']);
		$data['subview'] 		= $this->load->view("admin/inventory/purchase_full", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data);
	}

	public function get_products(){
		$results =     $this->Inventory_model->product_list();
		$html = '<div class="form-group row">';
		$html .= '<label style="text-align: left;font-size: larger;" class="col-sm-12 col-form-label">Search Item</label>';
		$html .= '<div class="col-md-12">';
		$html .= '<select class="form-control" id="select_item_par" name="select_item" data-plugin="select_hrm"  required>';
		$html .= '<option><-- Search Item --> </option>';
		foreach ($results as $key => $row) {
			$html .= '<option value="'.$row->id.'">'.$row->category_name .' >> '. $row->sub_cate_name .' >> '. $row->product_name.'</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="form-group row">';
		$html .= '<label style="text-align: left;font-size: larger;" class="col-sm-12 col-form-label">Quantity</label>';
		$html .= '<div class="col-md-12">';
		$html .= '<input type="number" class="form-control" placeholder="Quantity" id="par_qty"onkeyup="calt()"  required>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="form-group row">';
		$html .= '<label style="text-align: left;font-size: larger;" class="col-sm-12 col-form-label">Price</label>';
		$html .= '<div class="col-md-12">';
		$html .= '<input type="number" class="form-control" placeholder="Price" id="par_price"onkeyup="calt()"  required>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class="form-group row">';
		$html .= '<label style="text-align: left;font-size: larger;" class="col-sm-12 col-form-label">Total Price</label>';
		$html .= '<div class="col-md-12">';
		$html .= '<input type="text" class="form-control" placeholder="Total Price" id="par_total_price" readonly>';
		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}
	public function add_purchase() {
		$session = $this->session->userdata('username');

        // Get the JSON data from the POST request
        $input_data = json_decode($this->input->raw_input_stream, true);

        // Check if data is retrieved successfully
        if (is_array($input_data)) {
            // Extract data
            $product_id = $input_data['product_id'];
            $quantity = $input_data['quantity'];
            $unit_price = $input_data['unit_price'];
            $total_price = $input_data['total_price'];
			
			$form_data= array( 
				'user_id'	      => $session['user_id'],
				'product_id'	  =>  $product_id,
				'quantity'		  =>  $quantity,
				'approx_amount'	  =>  $unit_price,
				'approx_t_amount' =>  $total_price,
			);
			if($this->db->insert('products_purches_details', $form_data)){
				$response = [
					'status' => 'success',
					'message' => 'Purchase added successfully',
				];
			}else{
				$response = [
					'status' => 'error',
					'message' => 'Failed to add purchase',
				];
			}
            echo json_encode($response);
        } else {
            // Handle error
            $response = [
                'status' => 'error',
                'message' => 'Invalid input data'
            ];
            echo json_encode($response);
        }
    }

	public function get_purchase_data(){
		$session = $this->session->userdata('username');
		$status = $this->input->post('status');
		$data= $this->Inventory_model->purchase_products_requisition_api(0,10000000,$status);

		$data = array(
			'row' => $data,
			'roll' => $session['role_id'],
		);
		echo json_encode($data);
	}

	public function purchase_create($id = null){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] 			= 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Store';
		$data['results'] 		= $this->Inventory_model->product_list();
		$data['categorys']		= $this->db->get("products_categories")->result();
		$data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
		$data['units'] 			= $this->db->get("product_unit")->result();
		$data['col'] 			= $id;
		$data['user_role_id'] 	= $session['role_id'];
		if ($id != null) {
			$data['row'] 		= $this->db->where('id',$id)->get("products")->row();
		}
		$data['subview'] 		= $this->load->view("admin/inventory/purchase_create", $data, TRUE);
								$this->load->view('admin/layout/layout_main', $data); //page load
    }


	public function purchase_panding_list(){
		$session = $this->session->userdata('username');

		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] 			= 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Purchase Pending';
		$data['categorys']		= $this->db->get("products_categories")->result();
		$data['products'] 		= $this->Inventory_model->purchase_products_status($session['user_id'],$session['role_id'],1);
		$data['results'] 		= $this->Inventory_model->product_list();
		$data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
		$data['company'] 		= $this->db->distinct()->select('company')->get("product_supplier")->result();
		$data['units'] 			= $this->db->get("product_unit")->result();
		$data['user_role_id'] 	= $session['role_id'];
		$data['subview'] 		= $this->load->view("admin/inventory/purchase_status", $data, TRUE);
								  $this->load->view('admin/layout/layout_main', $data); //page load
    }

	public function purchase_aproved_list(){
		$session = $this->session->userdata('username');
		//   dd($session);
		if(empty($session)){ 
			redirect('admin/');
		}
		//Dropdown
		$data['title'] 			= 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Purchase Aproved';
		$data['categorys']		= $this->db->get("products_categories")->result();
		$data['products'] 		= $this->Inventory_model->purchase_products_status($session['user_id'],$session['role_id'],2);
		// dd($data['products']);
		$data['results'] 		= $this->Inventory_model->product_list();
		$data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
		$data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
		$data['units'] 			= $this->db->get("product_unit")->result();
		$data['user_role_id'] 	= $session['role_id'];
		$data['subview'] 		= $this->load->view("admin/inventory/purchase_status", $data, TRUE);
								$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function purchase_order_received_list()
	{
		$session = $this->session->userdata('username');
		//   dd($session);
		if(empty($session)){ 
			redirect('admin/');
		}
		//Dropdown
		$data['title'] 			= 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Purchase Delivered';
		$data['categorys']		= $this->db->get("products_categories")->result();
		$data['products'] 		= $this->Inventory_model->purchase_products_status($session['user_id'],$session['role_id'],3);
		// dd($data['products']);
		$data['results'] 		= $this->Inventory_model->product_list();
		$data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
		$data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
		$data['units'] 			= $this->db->get("product_unit")->result();
		$data['user_role_id'] 	= $session['role_id'];
		$data['subview'] 		= $this->load->view("admin/inventory/purchase_status", $data, TRUE);
								$this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function purchase_reject_list()
	{
		$session = $this->session->userdata('username');
		//   dd($session);
		if(empty($session)){ 
			redirect('admin/');
		}
		//Dropdown
		$data['title'] 			= 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Purchase Reject';
		$data['categorys']		= $this->db->get("products_categories")->result();
		$data['products'] 		= $this->Inventory_model->purchase_products_status($session['user_id'],$session['role_id'],4);
		// dd($data['products']);
		$data['results'] 		= $this->Inventory_model->product_list();
		$data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
		$data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
		$data['units'] 			= $this->db->get("product_unit")->result();
		$data['user_role_id'] 	= $session['role_id'];
		$data['subview'] 		= $this->load->view("admin/inventory/purchase_status", $data, TRUE);
								$this->load->view('admin/layout/layout_main', $data); //page load
	}
	
	public function product_purchase_details($id)	{
	
		// dd($_SESSION);
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		
		$data['title'] 		 = 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store';
		if($session['role_id']!=3){
			$data['results']	 = $this->Inventory_model->product_purches_details($id);
			if(!empty($data['results'])){
				$data['id'] 	 = $data['results'][0]->id;
			}
		    $data['status'] = $this->db->select('status')
				->where('id',$id)->get('products_purches_details')
				->result()[0]
				->status;			
		}
		else{
			$data['results']	 = $this->Inventory_model->req_details_cat_wise($id);
		}
		$data['subview'] 	 = $this->load->view("admin/inventory/product_purches_details", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}

    //product purches rejected by specific user
	public function product_purchase_rejected($id){
		// dd($id);
		$log_user=$_SESSION['username']['user_id'];
		$this->db->where('id',$id)->update('products_purches_details',['updated_by'=>$log_user]);
		$approved = $this->db->where('id',$id)->update('products_purches_details',['status'=>4]);
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
		$data['title']       = 'Purchase | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Purchase';
	    $data['results'] 	 = $this->Inventory_model->product_requisition_details($id);
		 if(!empty($data['results'])){
		$data['id'] = $data['results'][0]->id;
		}else{
			$data['id']  	 = '';
		}
		$data['subview'] 	 = $this->load->view("admin/inventory/product_purches_edit_approve", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data);
	}
	//approved by prisal product purches edit
	public function product_persial_approved($id){
		$quantity=$this->input->post('ap_quantity');
		// dd($quantity);	
		$update = $this->db->where('id',$id)->update('products_purches_details',['status'=>2,'ap_quantity'=>$quantity]);
		if($update){
			$this->session->set_flashdata('success', 'Updated Successfully.');
			redirect("admin/inventory/purchase","refresh");
		}
	}

	public function product_purchase_recived($id){
	
        $results = $this->db->where('id',$id)->get('products_purches_details')->result();
        foreach ($results as $key => $row) {
        	$product = $this->db->where('id', $row->product_id)->get('products')->row();
        	$quantity = $product->quantity + $row->ap_quantity;	
        	$this->db->where('id', $row->product_id)->update('products', array('quantity' => $quantity));
        	$this->db->where('id', $row->id)->update('products_purches_details', array('status' => 3));
        }
		$deliver = $this->db->where('id',$id)->update('products_purches_details',['status'=>3]);
		if($deliver){
			 $this->session->set_flashdata('success', 'Delivered Successfully.');
			 redirect("admin/inventory/purchase","refresh");
		}
	}

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
			$supplier_data = array( 
					'name'		 => $_POST['name'],
					'company'	 => $_POST['company_name'],
					'phone'	     => $_POST['phone'],
					'address'	 => $_POST['address'],
				);				 
									
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
		$data['title'] 			= 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Store';
		// $data['path_url'] 		= 'inventory';
		$data['products']		= $this->db->get("product_supplier")->result();
		$data['col'] 			= $id;
		$data['user_role_id'] 	= $session['role_id'];
		
		$data['subview'] 		= $this->load->view("admin/inventory/supplier", $data, TRUE);
								  $this->load->view('admin/layout/layout_main', $data); //page load
	}

	public function supplier_detail($id){
		//search supplier details
		$data['result'] = $this->db->where('id', $id)->get('product_supplier')->row();
		$data['title'] 			= 'Supplier Details | '.$this->Xin_model->site_title();
		$data['breadcrumbs']	= 'Supplier Details';
		$data['results']         = $this->db->select('*')->get('product_supplier')->result();
		$data['subview'] 		= $this->load->view("admin/inventory/supplier_details", $data, TRUE);
								  $this->load->view('admin/layout/layout_main', $data);
	}

	public function get_supplier_ajax()
	{
		 $name_company= $_POST['companyName'];
		 $this->db->like('company', $name_company);
		$result = $this->db->get('product_supplier')->result_array();
		 $data[0]= 'Select Supplier Name';
		foreach ($result as $rows) {
			$data[$rows['id']] = $rows['name'];
		}
		header('Content-Type: application/x-json; charset=utf-8');
		echo (json_encode($data));
	}

	public function get_supplier_details_ajax($id)
	{   
		$this->db->where('id', $id);
		$result = $this->db->get('product_supplier')->row();
		header('Content-Type: application/x-json; charset=utf-8');
		echo (json_encode($result));
	}
	//==================== suplier part end ========================

	//====================== Requisition Report=============================

	public function report(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] 		 = 'Report | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Report';
		$data['subview'] 	 = $this->load->view("admin/inventory/report", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	
	}

      //requsition report status and excel file generator same function
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
	// dd($statusC);
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

    //====================== Requisition EndReport=============================//

    //====================== Low inventory and  Stack product report Report=============================

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


      //====================== End Low inventory and  Stack product report Report=============================
 

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
			    'order_level'   => $this->input->post('order_level'),
			    // 'p_type'   => $this->input->post('p_type'),
			    'short_details'   => $this->input->post('short_details')
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
		$data['title'] = 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store';
		// $data['path_url'] = 'inventory';
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
		$data['title'] = 'Unit | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Add Unit';
		// $data['path_url'] = 'inventory';

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
		$data['title'] = 'category | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Add category';
		// $data['path_url'] = 'inventory';

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
		$data['title'] = 'Sub Category | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Add Sub Category';
		// $data['path_url'] = 'inventory';

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
        $data[0] = 'Select Sub Category';
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
		$data[0] = 'Select Product';
        foreach ($result as $rows) {
            $data[$rows['id']] = $rows['product_name'];
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($data));
	}

	public function delete_requsiton_item($id,$rid){
		$delete = $this->db->where('id',$id)->delete('products_requisition_details');
		$this->db->where('id',$id)->delete('products_requisitions');
		$this->session->set_flashdata('warning', 'Requsiton deleted successfully.');
		redirect("admin/inventory/index");
	}


    public function delete_requsiton($id){
		$this->db->where('id',$id)->delete('products_requisition_details');
		$this->session->set_flashdata('warning', 'Requsiton deleted successfully.');
		redirect("admin/inventory/index");
    }
	public function delete_purches_item($id,$pid){
		$approved = $this->db->where('id',$id)->delete('products_purches_details');
		$this->session->set_flashdata('delete','Requsiton deleted successfully.');
		redirect("admin/inventory/purchase");
	}
	public function product_details($id){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = 'Product Details | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Product Details';
		$data['results'] = $this->Inventory_model->product_details($id);
		$data['subview'] = $this->load->view("admin/inventory/product_details", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
	}


	public function get_product_by_ajax($product_id)
	{
	   $this->db->select('
		   		p.id, 
		   		p.product_name, 
		   		p.quantity, 
		   		p.cat_id, 
		   		pc.category_name, 
		   		p.sub_cate_id, 
		   		psc.sub_cate_name,
		   		pu.unit_name
	   		');
	    $this->db->from('products as p');
	    $this->db->join('products_categories as pc', 'pc.id = p.cat_id');
	    $this->db->join('products_sub_categories as psc', 'psc.id = p.sub_cate_id');
	    $this->db->join('product_unit as pu', 'pu.id = p.unit_id');
	    $query = $this->db->where('p.id', $product_id)->get()->row();
        header('Content-Type: application/x-json; charset=utf-8');
        echo (json_encode($query));
        return true;
	}

	
	public function equipment_list(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['session']    = $session;
		$data['equipments'] = $this->Inventory_model->equipment_list($session);
		$this->load->view("admin/inventory/equipment_list", $data);
	}

	function requisition_list(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['session']    = $session;
		$data['products'] 	= $this->Inventory_model->requisition_list($session);

		$data['subview']    = $this->load->view("admin/inventory/requisition_list", $data);
	}


public function delete_category($id){
   $this->db->from('products_categories')->where('id',$id)->delete();
	redirect('admin/inventory/category');
}

public function delete_sub_category($id){
   $this->db->from('products_sub_categories')->where('id',$id)->delete();
	redirect('admin/inventory/sub_category');
}
public function product_purchase_delete($id){
   $this->db->from('products_sub_categories')->where('id',$id)->delete();
	redirect('admin/inventory/purchase');
}


public function low_product_list(){

	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$data['title'] = 'Low Quantity of Products | '.$this->Xin_model->site_title();
	$data['breadcrumbs'] = 'Low Quantity Product Details';
	$data['results'] = $this->db->select('product_name,quantity,order_level')->where('quantity < order_level')->get('products')->result();
	// dd($data['results']);
	$data['subview'] = $this->load->view("admin/inventory/low_product_list", $data, TRUE);
	$this->load->view('admin/layout/layout_main', $data); //page load

}


public function moves(){

	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$data['title'] = 'Device Movement | '.$this->Xin_model->site_title();
	$data['breadcrumbs'] = 'Device Movement';

	$data['subview'] = $this->load->view("admin/inventory/device_movement", $data, TRUE);
	$this->load->view('admin/layout/layout_main', $data); //page load

}

public function create_movement(){

	$data['session']= $this->session->userdata('username');
	if(empty($data['session'])){ 
		redirect('admin/');
	}

	$data['title'] = 'Create Movement | '.$this->Xin_model->site_title();
	$data['breadcrumbs'] = 'Create Movement';
	$data['users'] = $this->db->select('xin_employees.first_name,xin_employees.last_name,xin_employees.user_id')
						  ->from('xin_employees')
						  ->where_in('.xin_employees.status',[1,4,5])
						  ->get()->result();
	$data['get'] = $this->Inventory_model->movement_list();
	// dd($data['get']);
	$data['subview'] = $this->load->view("admin/inventory/create_movement", $data, TRUE);
	$this->load->view('admin/layout/layout_main', $data); //page load

}
public function move_create(){
	// dd($_POST);
	$data['device_id']  = $_POST['device_id'];
	$data['user_id']    = $_POST['user_id'];
	$data['purpose']    = $_POST['purpose'];
	$data['floor']      = $_POST['floor'];
	$data['remark']     = $_POST['remark'];
	


    if($_POST['role_id'] != 3){
    	$data['created_by'] = $_POST['user_id'];
	    $data['user_id']    = $_POST['emp_id'];
		$data['status']     = 2;
		$data['floor']      = $_POST['floor'];
		$data['start_time'] = date("Y-m-d H:i:s");
	}
	// $data['status']      = $_POST['role_id'] != 3 ? 2 : 1;
	$insert = $this->db->insert('move_list',$data);
	if($insert){
		if($_POST['role_id']!=3){
			$this->db->where('device_model',$_POST['device_id'])->update('product_accessories',['move_status'=>2]);
		}
		$this->session->set_flashdata('success', 'Successfully Insert Done');
	}else{
		$this->session->set_flashdata('error', 'Error to Insert');
	}

	redirect('admin/inventory/moves');
}


function requested_list(){
	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$data['session']    = $session;
	$data['requests']   = $this->Inventory_model->request_list();
	// dd($data);
	$data['subview']    = $this->load->view("admin/inventory/request_list", $data);
}

function active_list(){
	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$data['session']    = $session;
	$data['requests']   = $this->Inventory_model->active_list();
	// dd($data);
	$data['subview']    = $this->load->view("admin/inventory/active", $data);
}
function inactive_list(){
	$session = $this->session->userdata('username');
	if(empty($session)){ 
		redirect('admin/');
	}
	$data['session']    = $session;
	$data['requests']   = $this->Inventory_model->inactive_list();
	$data['subview']    = $this->load->view("admin/inventory/inactive", $data);
}
function request_edit(){
	$data['status']     = $_POST['status'];
	$data['floor']      = $_POST['floor'];
	$data['remark']     = $_POST['remark'];
	$data['start_time'] = date("Y-m-d H:i:s");
    $update = $this->db->where('id',$_POST['item_id'])->update('move_list',$data);
	if($update){
		echo "Approved";
	}else{
			echo "Something Error!!!";
	}
}


function free_device($id){

	$free_device = $this->db->select('user_id,device_id')->where('id',$id)->get('move_list')->row();

	$this->db->where('device_model',$free_device->device_id)->update('product_accessories', ['move_status' => 1]);
	$this->db->where('user_id',$free_device->user_id)->where('device_id',$free_device->device_id)->update('move_list', ['status' => 1,'close_time'=>date('Y-m-d H:i:s')]);
					 
	if($free_device){
			$this->session->set_flashdata('success', 'Device Successfully Free');
			redirect('admin/inventory/moves','refresh');
	}else{
		$this->session->set_flashdata('error', 'Error');
	}
	
}

public function mobile_bill(){
	$data['phone_number']  = $this->input->post('phone_number'); 
	$data['amount']  = $this->input->post('amount'); 
	$data['user_id'] = $this->input->post('user_id');
	// $data['crated_at'] =  date('Y-m-d');
	// dd($data);
	$insert = $this->db->insert('mobile_bill_requisition',$data);
	if($insert){
		$this->session->set_flashdata('success', 'Mobile Bill Successfully Added');
		redirect('admin/inventory/create_phone','refresh');
	}else{
		$this->session->set_flashdata('error', 'Error!!! Try Again');
		redirect('admin/inventory/create_phone','refresh');
	}
}
	public function mobile_delete($id){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$delete = $this->db->where('id',$id)->from('mobile_bill_requisition')->delete();
		if($delete){
			if($session['user_id']==3){
				$this->session->set_flashdata('delete', 'Successfully Delete');
				redirect('admin/inventory/create_phone','refresh');
			} else{
				$this->session->set_flashdata('delete', 'Successfully Delete');
				redirect('admin/inventory/index','refresh');
			}
		}else{
			if($session['user_id']==3){
				$this->session->set_flashdata('error', 'Error!!! Try Again');
				redirect('admin/inventory/create_phone','refresh');
			} else{
				$this->session->set_flashdata('error', 'Error!!! Try Again');
				redirect('admin/inventory/index','refresh');
			}
		}
	}

	public function requisition_equipment_list(){
			$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['session']    = $session;
		$this->db->select('product_unit.unit_name,products_requisition_details.*, xin_employees.first_name, xin_employees.last_name,products_categories.category_name,products.product_name');
		$this->db->from('products_requisition_details');
		$this->db->join('products_categories', 'products_categories.id = products_requisition_details.cat_id');
		$this->db->join('products', 'products.id = products_requisition_details.product_id');
		$this->db->join('product_unit', 'product_unit.id = products.unit_id');
		$this->db->join('xin_employees', 'products_requisition_details.user_id = xin_employees.user_id');
		$data['equipments'] = $this->db->get()->result();
		// dd($data);
		$this->load->view("admin/inventory/requisition_equipment_list", $data);
	}

	public function mobile_bill_requisition_list(){
			$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['session'] = $session;
		$this->db->select('mobile_bill_requisition.*, xin_employees.first_name, xin_employees.last_name');
		$this->db->from('mobile_bill_requisition');
		$this->db->join('xin_employees', 'mobile_bill_requisition.user_id = xin_employees.user_id');
		$data['mobiles'] = $this->db->get()->result();
						   $this->load->view("admin/inventory/mobile_bill_requisition_list", $data);
	}

	public function mobile_bill_edit_approved($id){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title']       = 'Mobile Bill Requisition| '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Mobile Bill Requisition ';
		$data['ids']=$id;
		$data['amount']	 = $this->db->select('id,amount')->where('id',$id)->get('mobile_bill_requisition')->row();
		$data['subview'] = $this->load->view("admin/inventory/mobile_bill_edit_approve", $data, TRUE);
							   $this->load->view('admin/layout/layout_main', $data);
	}
	public function mobile_bill_approved(){
		// dd($_POST);
		$update = $this->db->where('id',$_POST['h_id'])->update('mobile_bill_requisition',['approved_amount'=>$_POST['approved_amount'],'status'=>2]);
		if($update){
			$this->session->set_flashdata('success', 'Successfully Approved');
			redirect('admin/inventory/index','refresh');
		}
	}
	public function edit_mobile_bill_approved(){
		// dd($_POST);
		$update = $this->db->where('id',$_POST['h_id'])->update('mobile_bill_requisition',['amount'=>$_POST['amount']]);
		if($update){
			$this->session->set_flashdata('success', 'Successfully Approved');
			redirect('admin/inventory/index','refresh');
		}
	}
	public function edit_mobile_bill_rejected($id){
		// dd($_POST);
		$update = $this->db->where('id',$id)->update('mobile_bill_requisition',['status'=>3]);
		if($update){
			$this->session->set_flashdata('success', 'Successfully Rejected');
			redirect('admin/inventory/index','refresh');
		}
	}
	public function mobile_bill_hand_over($id){
		// dd($id);
		$update = $this->db->where('id',$id)->update('mobile_bill_requisition',['status'=>4]);
		if($update){
			$this->session->set_flashdata('success', 'Successfully Amount Deliver');
			redirect('admin/inventory/index','refresh');
		}
	}
	public function mobile_edit($id){
		// dd($_POST);
		$session = $this->session->userdata('username');
		$data['title'] = 'Edit Amount | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Edit Amount';
		$data['amount']  = $this->db->where('id',$id)->get('mobile_bill_requisition')->row();		
		$data['subview'] = $this->load->view("admin/inventory/mobile_edit", $data, TRUE);
						   $this->load->view('admin/layout/layout_main', $data);
	}

	
	public function edit_mobile_bill_edit(){
		$update  = $this->db->where('id',$_POST['h_id'])->update('mobile_bill_requisition',['amount'=>$_POST['amount']]);
		if($update){
			$this->session->set_flashdata('success', 'Successfully Update');
			redirect('admin/inventory/create_phone','refresh');
		}
	}

	public function products_delete($id){
		$delete = $this->db->where('id',$id)->delete('products');
		$this->db->where('id',$id)->delete('products_requisitions');
		$this->session->set_flashdata('warning', 'Requsiton deleted successfully.');
		redirect("admin/inventory/products");
	}

	public function mobile_bill_report($staus){
		$data['first_date']  = $this->input->post('first_date'); 
		$data['second_date'] = $this->input->post('second_date');
		$first_date = $this->input->post('first_date'); 
		$second_date = $this->input->post('second_date');
		$this->db->select('*')->where("created_at between '$first_date' and '$second_date'");
		if($status == 3	){
			$this->db->where('status',$status);
		}
		if($status == 1){
			$this->db->where('status',$status);
		}
		if($status == 2){
			$this->db->where('status',$status);
		}
		$this->db->get('mobile_bill_requisition')->result();

	}


}

?>