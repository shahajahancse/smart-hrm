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
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load the models
        $this->load->model("Inventory_model");
        $this->load->model("Xin_model");
        $this->load->helper('form');

<<<<<<< HEAD
    }
=======
	
	//================= Requisition here =======================

	public function index($id = null){
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

	public function index1(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = 'Store | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store';
		if($session['role_id']== 1 || $session['role_id']== 2 || $session['role_id']== 4 ){
			$data['products'] 	= $this->Inventory_model->purchase_products($session['user_id'],$session['role_id']);
		}
		if( $session['role_id'] == 3) {
			$data['products'] 	= $this->Inventory_model->purchase_products($session['user_id'],$session['role_id']);
		}
		$data['user_role_id'] 	= $session['role_id'];
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/inventory/index1", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/');
		}
	}
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070


    //================= Requisition here =======================
    // public function index($id = null){
    // 	// dd($id);
    // 	$session = $this->session->userdata('username');
    // 	if(empty($session)){
    // 		redirect('admin/');
    // 	}
    // 	$data['title'] = 'Store | '.$this->Xin_model->site_title();
    // 	$data['breadcrumbs'] = 'Store';
    // 	$data['session']     = $session;

    // 	// if( $session['role_id'] = 3){
    // 	// 	$data['products'] 	= $this->Inventory_model->requisition_list($session);
    // 	// 	$data['equipments'] 	= $this->Inventory_model->equipment_list($session['user_id']);
    // 	// 	$data['subview'] = $this->load->view("admin/inventory/index", $data, TRUE);
    // 	// }else{
    // 	// }
    // 	if($session['role_id'] ==3){
    // 		$data['subview'] = $this->load->view("admin/inventory/index", $data, TRUE);
    // 	}
    // 	$this->load->view('admin/layout/layout_main', $data); //page load
    // }

    public function index($id = null)
    {
        $session = $this->session->userdata('username');
        $data['title'] = 'Store | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Store';
        if($session['role_id']== 1 || $session['role_id']== 2 || $session['role_id']== 4) {
            $data['products'] 	= $this->Inventory_model->purchase_products($session['user_id'], $session['role_id']);
        }
        $data['user_role_id'] 	= $session['role_id'];
        if(!empty($session)) {
            if($session['role_id'] == 3) {
                $data['subview'] = $this->load->view("admin/inventory/index", $data, true);
            } else {
                $data['subview'] = $this->load->view("admin/inventory/index1", $data, true);
            }
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
    }

    public function index1()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $data['title'] = 'Store | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Store';
        if($session['role_id']== 1 || $session['role_id']== 2 || $session['role_id']== 4) {
            $data['products'] 	= $this->Inventory_model->purchase_products($session['user_id'], $session['role_id']);
            //    dd($data['products']);
        }
        if($session['role_id'] == 3) {
            // $data['results'] 	= $this->Inventory_model->requisition_details($session['user_id'],$id=null);
            // dd($data['results']);
            $data['products'] 	= $this->Inventory_model->purchase_products($session['user_id'], $session['role_id']);
            //   dd($data['products']);
        }
        $data['user_role_id'] 	= $session['role_id'];
        // dd($data);
        if(!empty($session)) {
            $data['subview'] = $this->load->view("admin/inventory/index1", $data, true);
            $this->load->view('admin/layout/layout_main', $data); //page load
        } else {
            redirect('admin/');
        }
    }


    public function create($id = null)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        //Validation
        $this->form_validation->set_rules('cat_id[]', 'select category', 'required|trim');
        $this->form_validation->set_rules('product_id[]', 'item name', 'required|trim');
        $this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');
<<<<<<< HEAD

        //Validate and input data
        if ($this->form_validation->run() == true) {
            for ($i=0; $i<sizeof($_POST['cat_id']); $i++) {
                $form_data[] = array(
                    'user_id' 		 => $session['user_id'],
                    'cat_id'		 => $_POST['cat_id'][$i],
                    'sub_cate_id'	 => $_POST['sub_cate_id'][$i],
                    'product_id'	 => $_POST['product_id'][$i],
                    'quantity'		 => $_POST['quantity'][$i],
                    'status'		 => 1,
                );
            }

            if($this->db->insert_batch('products_requisition_details', $form_data)) {
                $this->session->set_flashdata('success', 'Successfully Insert Done');
            } else {
                $this->session->set_flashdata('warning', 'Sorry Something Wrong.');
            }

            return redirect('admin/inventory');
        }
=======
		//Validate and input data
		if ($this->form_validation->run() == true){
			for ($i=0; $i<sizeof($_POST['cat_id']); $i++) {
				$form_data[] = array(
					'user_id' 		 => $session['user_id'],
					'cat_id'		 => $_POST['cat_id'][$i],
					'sub_cate_id'	 => $_POST['sub_cate_id'][$i],
					'product_id'	 => $_POST['product_id'][$i],
					'quantity'		 => $_POST['quantity'][$i],
					'status'		 => 1,
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
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070

        $data['title'] 		    =     'Inventory | '.$this->Xin_model->site_title();
        $data['breadcrumbs']    =     'Store Create Requisition';
        // $data['path_url'] 	    =     'inventory';
        $data['products'] 		=     $this->Inventory_model->purchase_products($session['user_id'], $session['role_id']);
        $data['results'] 		=     $this->Inventory_model->product_list();
        $data['user_role_id'] 	=     $session['role_id'];
        // dd($data['results']);
        $data['subview'] 	    =     $this->load->view("admin/inventory/create", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function requisition_edit($id)
    {
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|trim');
        if ($this->form_validation->run() == true) {
            $data = array(
                'quantity' => $_POST['quantity'],
            );
            $this->db->where('id', $id)->update('products_requisition_details', $data);
            $this->session->set_flashdata('success', 'Successfully Updated Done');
        }
        return true;
    }


<<<<<<< HEAD
    public function pending_list()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }


        $data['products'] 		= $this->Inventory_model->purchase_products_pending($session['user_id'], $session['role_id'], 1);
        $data['title'] 		 = 'Store Pending List | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Store Pending List';
        $data['user_role_id'] 	= $session['role_id'];

        $data['subview'] 	 = $this->load->view("admin/inventory/requisition_status_list", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }
    public function first_step_aproved_list()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }


        $data['products'] 		= $this->Inventory_model->purchase_products_pending($session['user_id'], $session['role_id'], 5);
        $data['title'] 		 = 'Store First Step Aproved | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Store First Step Aproved';
        $data['user_role_id'] 	= $session['role_id'];

        $data['subview'] 	 = $this->load->view("admin/inventory/requisition_status_list", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function aproved_list()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }


        $data['products'] 		= $this->Inventory_model->purchase_products_pending($session['user_id'], $session['role_id'], 2);
        $data['title'] 		 = 'Store Aproved List | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Store Aproved List';
        $data['user_role_id'] 	= $session['role_id'];
        $data['subview'] 	 = $this->load->view("admin/inventory/requisition_status_list", $data, true);
=======
	public function pending_list(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] 		 = 'Store Pending List | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store Pending List';
		$data['user_role_id'] 	= $session['role_id'];
		$data['products'] 		= $this->Inventory_model->product_requisition($session['user_id'],$session['role_id'],1);
		$data['subview'] 	 = $this->load->view("admin/inventory/requisition_status_list", $data, TRUE);
		$this->load->view('admin/layout/layout_main', $data); //page load
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

	public function aproved_list(){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['products'] 		= $this->Inventory_model->product_requisition($session['user_id'],$session['role_id'],2);
		$data['title'] 		 = 'Store Aproved List | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Store Aproved List';
		$data['user_role_id'] 	= $session['role_id'];
		$data['subview'] 	 = $this->load->view("admin/inventory/requisition_status_list", $data, TRUE);
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070

        $this->load->view('admin/layout/layout_main', $data); //page load
    }

<<<<<<< HEAD
    public function delivery_list()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }

        $data['products'] 		= $this->Inventory_model->purchase_products_pending($session['user_id'], $session['role_id'], 3);
        $data['title'] 		 = 'Store Handover List | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Store Handover List';
        $data['user_role_id'] 	= $session['role_id'];

        $data['subview'] 	 = $this->load->view("admin/inventory/requisition_status_list", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }
=======
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
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070

    public function reject_list()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }

<<<<<<< HEAD
        $data['products'] 		= $this->Inventory_model->purchase_products_pending($session['user_id'], $session['role_id'], 4);
=======
		$data['products'] 		= $this->Inventory_model->product_requisition($session['user_id'],$session['role_id'],4);
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070

        $data['title'] 		 = 'Store Reject List | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Store Reject List';
        $data['user_role_id'] 	= $session['role_id'];

        $data['subview'] 	 = $this->load->view("admin/inventory/requisition_status_list", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }



<<<<<<< HEAD
    public function requsition_details($id)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        if($session['role_id']==3) {
            $user_id=$session['user_id'];
        };
        $data['title'] 		 = 'Requsition Details | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Requsition Details';
        // $data['path_url'] 	 = 'inventory';

        $data['results']	 = $this->Inventory_model->requisition_details($user_id=null, $id);
        // dd($data['results']);
        if(!empty($data['results'])) {
            $data['requisition_id'] 	 = $id;
        }
        $data['status'] = $this->db->select('status')->where('id', $id)->get('products_requisitions')->row()->status;

        // dd($data);
        $data['subview'] 	 = $this->load->view("admin/inventory/requsition_details", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function requsition_approved($id)
    {
        // dd($id);
        $log_user=$_SESSION['username']['user_id'];
        $this->db->where('id', $id)->update('products_requisitions', ['updated_by'=>$log_user]);
        $approved = $this->db->where('id', $id)->update('products_requisition_details', ['status'=>2]);
        if($approved) {
            $this->db->where('requisition_id', $id)->update('products_requisition_details', ['status'=>2]);
=======
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
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070

            $this->session->set_flashdata('warning', ' Requsition Status Rejected .');
            redirect("admin/inventory/index", "refresh");
        }
    }

    public function requsition_rejected($id)
    {
        // dd($id);
        $log_user=$_SESSION['username']['user_id'];
        $this->db->where('id', $id)->update('products_requisition_details', ['updated_by'=>$log_user]);
        $approved = $this->db->where('id', $id)->update('products_requisition_details', ['status'=>4]);
        if($approved) {
            $this->db->where('id', $id)->update('products_requisition_details', ['status'=>4]);

            $this->session->set_flashdata('warning', ' Requsition Status Rejected .');
            redirect("admin/inventory/index", "refresh");
        }
    }

    public function requsition_approvedd($id)
    {
        // dd($id);
        $log_user=$_SESSION['username']['user_id'];
        $this->db->where('id', $id)->update('products_requisitions', ['updated_by'=>$log_user]);
        $approved = $this->db->where('id', $id)->update('products_requisitions', ['status'=>2]);
        if($approved) {
            $this->db->where('id', $id)->update('products_requisition_details', ['status'=>2]);

<<<<<<< HEAD
            $this->session->set_flashdata('success', ' Requsition Status Approved .');
            redirect("admin/inventory/index", "refresh");
        }
    }
=======
	// reqisition change status requsition_edit_approved
	public function requsition_edit_approved($id){
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title']       = 'Requsition| '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = 'Requsition ';
	    $data['results'] 	 = $this->Inventory_model->requisition_details($id);
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
	
	
	public function persial_approved($id){
		
		$session = $this->session->userdata('username');
		$all_detail=$this->db->where('id',$id)->get('products_requisition_details')->result();
		foreach($all_detail as $key=>$value){
			$d1[]= $this->db->where('id',$all_detail[$key]->product_id)->get('products')->row();
		}
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070

    // reqisition change status requsition_edit_approved
    public function requsition_edit_approved($id)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }

        if($session['role_id']==3) {
            ;
            $user_id=$session['user_id'];
        } else {
            $user_id=null;
        };

        $data['title']       = 'Requsition| '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Requsition ';
        $data['results'] 	 = $this->Inventory_model->requisition_details($user_id=null, $id);
        // dd($data);
        if(!empty($data['results'])) {
            $data['requisition_id'] = $data['results'][0]->id;
        } else {
            $data['requisition_id'] = '';
        }
        $data['subview'] 	 = $this->load->view("admin/inventory/edit_approve", $data, true);
        $this->load->view('admin/layout/layout_main', $data);
    }


    public function persial_approved($id)
    {

        $session = $this->session->userdata('username');
        $all_detail=$this->db->where('id', $id)->get('products_requisition_details')->result();
        foreach($all_detail as $key=>$value) {
            $d1[]= $this->db->where('id', $all_detail[$key]->product_id)->get('products')->row();
        }

        $quantity=$this->input->post('qunatity[]');
        $r_did=$this->input->post('r_id[]');
        foreach($d1 as $k=>$v) {
            if(isset($_POST['first_step'])) {
                $log_user=$_SESSION['username']['user_id'];
                $this->db->where('id', $id)->update('products_requisition_details', ['updated_by'=>$log_user,'status'=>5]);
                foreach($quantity as $key=>$value) {
                    $this->db->where('id', $r_did[$key])->update('products_requisition_details', ['approved_qty'=>$value,'status'=>5]);
                }
                $this->session->set_flashdata('success', 'Product Updated Successfully.');
                redirect("admin/inventory/index", "refresh");


            } elseif(isset($_POST['update'])) {
                $log_user=$_SESSION['username']['user_id'];
                foreach($quantity as $key=>$value) {
                    $this->db->where('id', $r_did[$key])->update('products_requisition_details', ['approved_qty'=>$value]);
                }
                $this->session->set_flashdata('success', 'Product Updated Successfully.');
                redirect("admin/inventory/index", "refresh");


            } else {
                if($session['role_id']==1) {
                    if($d1[$k]->quantity >= $quantity[$k]) {
                        foreach($quantity as $key=>$value) {
                            $log_user=$_SESSION['username']['user_id'];
                            $this->db->where('id', $id)->update('products_requisition_details', ['updated_by'=>$log_user]);
                            $this->db->where('id', $r_did[$key])->update('products_requisition_details', ['approved_qty'=>$value]);
                        }
                    } else {
                        // dd($d1[$k]->product_name);
                        $variable = $d1[$k]->product_name;
                        $variable1= $d1[$k]->quantity;
                        $this->session->set_flashdata('flash_data', $variable);
                        $this->session->set_flashdata('flash_data1', $variable1);
                        $this->session->set_flashdata('warning', 'Approved  Quantity is Biger ');
                        redirect("admin/inventory/requsition_details/$id", "refresh");
                    }
                } else {
                    foreach($quantity as $key=>$value) {
                        $this->db->where('id', $r_did[$key])->update('products_requisition_details', ['approved_qty'=>$value]);
                    }
                    $this->session->set_flashdata('success', 'Product Updated Successfully.');
                    redirect("admin/inventory/index", "refresh");
                }
            }

        }
        if($session['role_id'] == 1) {
            $approved = $this->db->where('id', $id)->update('products_requisition_details', ['status'=>2]);
            if($approved) {
                $this->db->where('id', $id)->update('products_requisition_details', ['status'=>2]);

                $this->session->set_flashdata('success', 'Updated Successfully.');
                redirect("admin/inventory/index", "refresh");
            }
        }

    }

    public function hand_over($id=null)
    {

        $pr1=$this->db->where('id', $id)->get('products_requisition_details')->result();

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
            $this->db->where('id', $row->product_id)->update('products', $data);
        }

        $deliver=$this->db->where('id', $id)->update('products_requisition_details', ['status'=>3]);
        if($deliver) {
            $this->db->where('id', $id)->update('products_requisition_details', ['status'=>3]);

            $this->session->set_flashdata('success', 'Handover Successfully.');
            redirect("admin/inventory/index", "refresh");
        }

    }
    //================= Requisition end =======================


    //================= Product requsition purches code here =======================

    public function purchase($id = null)
    {
        $session = $this->session->userdata('username');
        //   dd($session);
        if(empty($session)) {
            redirect('admin/');
        }


        //Validation
        // $this->form_validation->set_rules('spl_name', 'Sapplier name', 'required|trim');
        // $this->form_validation->set_rules('cmp_name', 'select category', 'required|trim');
        $this->form_validation->set_rules('cat_id[]', 'select category', 'required|trim');
        $this->form_validation->set_rules('sub_cate_id[]', 'select category', 'required|trim');
        $this->form_validation->set_rules('product_id[]', 'item name', 'required|trim');
        $this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');


        //   //Validate and input data
        if ($this->form_validation->run() == true) {
            // $supplier_id=$_POST['spl_name'];
            // $company=$_POST['cmp_name'];
            $ids=$this->Inventory_model->save('products_purches', ['user_id'=>$session['user_id']]);
            $last_id = $this->db->insert_id();

            for ($i=0; $i<sizeof($_POST['cat_id']); $i++) {
                $form_data[] = array(
                    'purches_id'	  => $last_id,
                    'product_id'	  => $_POST['product_id'][$i],
                    'quantity'		  => $_POST['quantity'][$i],
                    'approx_amount'	  => $_POST['approx_amount'][$i],
                    'approx_t_amount' => $_POST['total_amount'][$i],
                );
            }
            //   dd($form_data);

            if ($hid = $this->input->post('hidden_id')) {
                $this->db->where('id', $hid)->update_batch('products_purches_details', $form_data);
                $this->session->set_flashdata('success', 'Successfully Updated Done');
            } else {
                if($this->db->insert_batch('products_purches_details', $form_data)) {
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
        // $data['categorys']		= $this->db->get("products_categories")->result();
        $data['products'] 		= $this->Inventory_model->purchase_products_requisition($session['user_id'], $session['role_id']);

        // dd($data['products']);
        /*$data['results'] 		= $this->Inventory_model->product_list();
        $data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
        $data['company'] 		= $this->db->distinct()->select('company')->get("product_supplier")->result();
        $data['units'] 			= $this->db->get("product_unit")->result();
        $data['col'] 			= $id;*/
        $data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();

        $data['user_role_id'] 	= $session['role_id'];
        if ($id != null) {
            $data['row'] 		= $this->db->where('id', $id)->get("products")->row();
        }
        $data['subview'] 		= $this->load->view("admin/inventory/purchase", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function purchase_create($id = null)
    {
        $session = $this->session->userdata('username');
        //   dd($session);
        if(empty($session)) {
            redirect('admin/');
        }
        //Dropdown
        $data['title'] 			= 'Store | '.$this->Xin_model->site_title();
        $data['breadcrumbs']	= 'Store';

        // dd($data['products']);
        $data['results'] 		= $this->Inventory_model->product_list();
        $data['categorys']		= $this->db->get("products_categories")->result();
        $data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
        $data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
        $data['units'] 			= $this->db->get("product_unit")->result();
        $data['col'] 			= $id;
        $data['user_role_id'] 	= $session['role_id'];
        if ($id != null) {
            $data['row'] 		= $this->db->where('id', $id)->get("products")->row();
        }
        $data['subview'] 		= $this->load->view("admin/inventory/purchase_create", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    // function product_purchase_edit($id) {


    // }

    // function product_purchase_approved($id) {

    // }

    public function purchase_panding_list()
    {
        $session = $this->session->userdata('username');
        //   dd($session);
        if(empty($session)) {
            redirect('admin/');
        }
        //Dropdown
        $data['title'] 			= 'Store | '.$this->Xin_model->site_title();
        $data['breadcrumbs']	= 'purchase Pending';
        $data['categorys']		= $this->db->get("products_categories")->result();
        $data['products'] 		= $this->Inventory_model->purchase_products_status($session['user_id'], $session['role_id'], 1);

        // dd($data['products']);
        $data['results'] 		= $this->Inventory_model->product_list();
        $data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
        $data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
        $data['units'] 			= $this->db->get("product_unit")->result();
        $data['user_role_id'] 	= $session['role_id'];
        $data['subview'] 		= $this->load->view("admin/inventory/purchase_status", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function purchase_aproved_list()
    {
        $session = $this->session->userdata('username');
        //   dd($session);
        if(empty($session)) {
            redirect('admin/');
        }
        //Dropdown
        $data['title'] 			= 'Store | '.$this->Xin_model->site_title();
        $data['breadcrumbs']	= 'Purchase Aproved';
        $data['categorys']		= $this->db->get("products_categories")->result();
        $data['products'] 		= $this->Inventory_model->purchase_products_status($session['user_id'], $session['role_id'], 2);
        // dd($data['products']);
        $data['results'] 		= $this->Inventory_model->product_list();
        $data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
        $data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
        $data['units'] 			= $this->db->get("product_unit")->result();
        $data['user_role_id'] 	= $session['role_id'];
        $data['subview'] 		= $this->load->view("admin/inventory/purchase_status", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function purchase_order_received_list()
    {
        $session = $this->session->userdata('username');
        //   dd($session);
        if(empty($session)) {
            redirect('admin/');
        }
        //Dropdown
        $data['title'] 			= 'Store | '.$this->Xin_model->site_title();
        $data['breadcrumbs']	= 'Purchase Delivered';
        $data['categorys']		= $this->db->get("products_categories")->result();
        $data['products'] 		= $this->Inventory_model->purchase_products_status($session['user_id'], $session['role_id'], 3);
        // dd($data['products']);
        $data['results'] 		= $this->Inventory_model->product_list();
        $data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
        $data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
        $data['units'] 			= $this->db->get("product_unit")->result();
        $data['user_role_id'] 	= $session['role_id'];
        $data['subview'] 		= $this->load->view("admin/inventory/purchase_status", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function purchase_reject_list()
    {
        $session = $this->session->userdata('username');
        //   dd($session);
        if(empty($session)) {
            redirect('admin/');
        }
        //Dropdown
        $data['title'] 			= 'Store | '.$this->Xin_model->site_title();
        $data['breadcrumbs']	= 'Purchase Reject';
        $data['categorys']		= $this->db->get("products_categories")->result();
        $data['products'] 		= $this->Inventory_model->purchase_products_status($session['user_id'], $session['role_id'], 4);
        // dd($data['products']);
        $data['results'] 		= $this->Inventory_model->product_list();
        $data['sub_categorys']  = $this->db->get("products_sub_categories")->result();
        $data['company'] = $this->db->distinct()->select('company')->get("product_supplier")->result();
        $data['units'] 			= $this->db->get("product_unit")->result();
        $data['user_role_id'] 	= $session['role_id'];
        $data['subview'] 		= $this->load->view("admin/inventory/purchase_status", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function product_purchase_details($id)
    {

        // dd($_SESSION);
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }

        $data['title'] 		 = 'Store | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Store';
        // $data['path_url'] 	 = 'inventory';
        if($session['role_id']!=3) {
            $data['results']	 = $this->Inventory_model->product_purches_details($id);
            // dd($data['results']);
            if(!empty($data['results'])) {
                $data['purches_id'] 	 = $data['results'][0]->purches_id;
            }
            $data['status'] = $this->db->select('status')
                                 ->where('id', $id)->get('products_purches')
                                 ->result()[0]
                                 ->status;
        } else {
            $data['results']	 = $this->Inventory_model->req_details_cat_wise($id);
        }

        // $data['user_id'] 	 = $id;
        $data['subview'] 	 = $this->load->view("admin/inventory/product_purches_details", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    //product purches rejected by specific user
    public function product_purchase_rejected($id)
    {
        // dd($id);
        $log_user=$_SESSION['username']['user_id'];
        $this->db->where('id', $id)->update('products_purches', ['updated_by'=>$log_user]);
        $approved = $this->db->where('id', $id)->update('products_purches', ['status'=>4]);
        if($approved) {
            $this->session->set_flashdata('warning', ' Requsition Status Rejected .');
            redirect("admin/inventory/purchase", "refresh");
        }
    }


    //product purches edit form load here
    public function product_purchase_edit_approved($id)
    {

        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $data['title']       = 'Purchase | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Purchase';
        $data['results'] 	 = $this->Inventory_model->product_requisition_details($id);
        if(!empty($data['results'])) {
            $data['purches_id'] 	 = $data['results'][0]->purches_id;
        } else {
            $data['purches_id']  	 = '';
        }


        $data['subview'] 	 = $this->load->view("admin/inventory/product_purches_edit_approve", $data, true);
        $this->load->view('admin/layout/layout_main', $data);
    }

    //approved by prisal product purches edit
    public function product_persial_approved($id)
    {

        // dd($id);

        $session = $this->session->userdata('username');
        $all_detail=$this->db->where('purches_id', $id)->get('products_purches_details')->result();
        // dd($all_detail);
        foreach($all_detail as $key=>$value) {
            $d1[]= $this->db->where('id', $all_detail[$key]->product_id)->get('products')->row();

        }
        $quantity=$this->input->post('qunatity[]');
        $r_did=$this->input->post('r_id[]');

        foreach($d1 as $k=>$v) {

            foreach($quantity as $key=>$value) {
                $log_user=$_SESSION['username']['user_id'];
                if($session['role_id']!=3 &&  $this->input->post('update_a')==0) {
                    $this->db->where('id', $id)->update('products_purches', ['updated_by'=>$log_user]);
                    $this->db->where('id', $r_did[$key])->update('products_purches_details', ['ap_quantity'=>$value]);
                } else {
                    $this->db->where('id', $r_did[$key])->update('products_purches_details', ['quantity'=>$value]);
                }
            }
        }

        if($session['role_id']!=3 && $this->input->post('update_a')==0) {
            $approved = $this->db->where('id', $id)->update('products_purches', ['status'=>2]);
            if($approved) {
                $this->session->set_flashdata('success', 'Updated Successfully.');
                redirect("admin/inventory/purchase", "refresh");
            }
        } else {
            $this->session->set_flashdata('success', ' product Updated Successfully.');
            redirect("admin/inventory/purchase", "refresh");
        }

    }

    public function product_purchase_delivered($id)
    {
        $results = $this->db->where('purches_id', $id)->get('products_purches_details')->result();
        foreach ($results as $key => $row) {
            $product = $this->db->where('id', $row->product_id)->get('products')->row();
            $quantity = $product->quantity + $row->ap_quantity;
            $this->db->where('id', $row->product_id)->update('products', array('quantity' => $quantity));

            $this->db->where('id', $row->id)->update('products_purches_details', array('status' => 3));
        }

        $deliver = $this->db->where('id', $id)->update('products_purches', ['status'=>3]);
        if($deliver) {
            $this->session->set_flashdata('success', 'Delivered Successfully.');
            redirect("admin/inventory/purchase", "refresh");
        }

    }



    //=============== suplier ========================
    public function supplier($id = null)
    {

        $session = $this->session->userdata('username');
        //  dd($session);
        if(empty($session)) {
            redirect('admin/');
        }

        $this->form_validation->set_rules('name', 'Sapplier name', 'required|trim');
        $this->form_validation->set_rules('company_name', 'company', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('address', 'address', 'required|trim');

        if ($this->form_validation->run() == true) {
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
                if($this->Inventory_model->save('product_supplier', $supplier_data)) {
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

        $data['subview'] 		= $this->load->view("admin/inventory/supplier", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function supplier_detail($id)
    {
        //search supplier details

        $data['result'] = $this->db->where('id', $id)->get('product_supplier')->row();
        $data['title'] 			= 'Supplier Details | '.$this->Xin_model->site_title();
        $data['breadcrumbs']	= 'Supplier Details';
        // $data['path_url'] 		= 'inventory';

        // dd($data['products']);
        $data['subview'] 		= $this->load->view("admin/inventory/supplier_details", $data, true);
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
        echo(json_encode($data));
    }

    public function get_supplier_details_ajax($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->get('product_supplier')->row();
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($result));
    }
    //==================== suplier part end ========================




    //====================== Requisition Report=============================


<<<<<<< HEAD
    public function report()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }

        $data['title'] 		 = 'Report | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Report';
        // $data['path_url'] 	 = 'inventory';

        $data['subview'] 	 = $this->load->view("admin/inventory/report", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load

    }

    //requsition report status and excel file generator same function
    public function inventory_status_report($exc=null)
    {
        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');

        $f1_date = date("Y-m-d", strtotime($first_date));
        $f2_date = date("Y-m-d", strtotime($second_date));
        $statusC = $this->input->post('statusC');
        $data["values"] = $this->Inventory_model->requsition_status_report($f1_date, $f2_date, $statusC);
        //  dd($data["values"]);
        $data['statusC']= $statusC;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;

        if($exc == 1) {
            $this->load->view("admin/inventory/inventory_req_status_report_excil", $data);
        } else {
            if(is_string($data["values"])) {
                echo $data["values"];
            } else {
                echo $this->load->view("admin/inventory/inventory_req_status_report", $data, true);
            }


        }
=======
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
		if($exc == 1)
		{
			$this->load->view("admin/inventory/inventory_req_status_report_excil", $data);
		}else{
			if(is_string($data["values"]))
			{
				echo $data["values"];
			}
			else
			{	
				echo $this->load->view("admin/inventory/inventory_req_status_report", $data, TRUE);
			}
		}
  }
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070

    }


    public function perches_status_report($exc=null)
    {

        $first_date = $this->input->post('first_date');
        $second_date = $this->input->post('second_date');

        $f1_date = date("Y-m-d", strtotime($first_date));
        $f2_date = date("Y-m-d", strtotime($second_date));
        $statusC = $this->input->post('statusC');
        $data["values"] = $this->Inventory_model->perches_status_report($f1_date, $f2_date, $statusC);

        $data['statusC']= $statusC;
        $data['first_date'] = $first_date;
        $data['second_date'] = $second_date;



        if($exc == 1) {
            $this->load->view("admin/inventory/perches_status_report_excel", $data);
        } else {
            if(is_string($data["values"])) {
                echo $data["values"];
            } else {
                echo $this->load->view("admin/inventory/perches_status_report", $data, true);
            }


        }

    }

    //====================== Requisition EndReport=============================



    //====================== Low inventory and  Stack product report Report=============================

    public function low_inv_all_product_status_report($exc=null)
    {
        $statusC=$this->input->post('statusC');
        if($statusC==7) {
            $data['values'] = $this->Inventory_model->low_inv_allProduct_status_report();
            $data['statusC']= $statusC;

            if($exc == 1) {
                $this->load->view("admin/inventory/low_in_status_report_excel", $data);
            } else {

                if(is_string($data["values"])) {
                    echo $data["values"];
                } else {
                    echo $this->load->view("admin/inventory/low_in_status_report", $data, true);
                }
            }
        } else {
            $data['statusC']= $statusC;
            $data['values'] = $this->Inventory_model->low_inv_allProduct_status_report($statusC);
            // dd($data['values']);
            if($exc == 2) {
                $this->load->view("admin/inventory/low_in_status_report_excel", $data);
            } else {
                if(is_string($data["values"])) {
                    echo $data["values"];
                } else {
                    echo $this->load->view("admin/inventory/low_in_status_report", $data, true);
                }
            }
        }

    }


    //====================== End Low inventory and  Stack product report Report=============================

<<<<<<< HEAD

    // ================ default ====================
    public function products($id = null)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
=======
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
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070

        //Validation
        $this->form_validation->set_rules('cat_id', 'select category', 'required|trim');
        $this->form_validation->set_rules('sub_cate_id', 'select sub category', 'required|trim');
        $this->form_validation->set_rules('unit_id', 'select unit', 'required|trim');
        $this->form_validation->set_rules('product_name', 'item name', 'required|trim');

        //Validate and input data
        if ($this->form_validation->run() == true) {
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
                if($this->Inventory_model->save('products', $form_data)) {
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
            $data['row'] = $this->db->where('id', $id)->get("products")->row();
        }

        $data['subview'] = $this->load->view("admin/inventory/products", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function unit($id = null)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $data['title'] = 'Unit | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Add Unit';
        // $data['path_url'] = 'inventory';

        //Validate and input data
        $this->form_validation->set_rules('unit_name', 'Unit name', 'required|trim');
        $this->form_validation->set_rules('status', 'Status Feild', 'required|trim');
        if ($this->form_validation->run() == true) {
            $form_data = array(
                'unit_name'        => $this->input->post('unit_name'),
                'description'   => $this->input->post('description'),
                'status'       => $this->input->post('status'),
            );

            if ($hid = $this->input->post('hidden_id')) {
                $this->db->where('id', $hid)->update('product_unit', $form_data);
                $this->session->set_flashdata('success', 'Successfully Updated Done');
            } else {
                if($this->Inventory_model->save('product_unit', $form_data)) {
                    $this->session->set_flashdata('success', 'Successfully Insert Done');
                } else {
                    $this->session->set_flashdata('warning', 'Sorry Something Wrong.');
                }
            }
            redirect('admin/inventory/unit');
        }

        if ($id != null) {
            $data['row'] = $this->db->where('id', $id)->get("product_unit")->row();
        }
        $data['results'] = $this->db->order_by('id', 'DESC')->get("product_unit")->result();
        $data['subview'] = $this->load->view("admin/inventory/unit", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function category($id = null)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $data['title'] = 'category | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Add category';
        // $data['path_url'] = 'inventory';

        //Validate and input data
        $this->form_validation->set_rules('category_name', 'Category name', 'required|trim');
        $this->form_validation->set_rules('status', 'Status Feild', 'required|trim');
        if ($this->form_validation->run() == true) {
            $form_data = array(
                'category_name'  => $this->input->post('category_name'),
                'description'    => $this->input->post('description'),
                'status'         => $this->input->post('status'),
            );

            if ($hid = $this->input->post('hidden_id')) {
                $this->db->where('id', $hid)->update('products_categories', $form_data);
                $this->session->set_flashdata('success', 'Successfully Updated Done');
            } else {
                if($this->Inventory_model->save('products_categories', $form_data)) {
                    $this->session->set_flashdata('success', 'Successfully Insert Done');
                } else {
                    $this->session->set_flashdata('warning', 'Sorry Something Wrong.');
                }
            }
            redirect('admin/inventory/category');
        }

        if ($id != null) {
            $data['row'] = $this->db->where('id', $id)->get("products_categories")->row();
        }
        $data['results'] = $this->db->order_by('id', 'DESC')->get("products_categories")->result();
        $data['subview'] = $this->load->view("admin/inventory/category", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function sub_category($id = null)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $data['title'] = 'Sub Category | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Add Sub Category';
        // $data['path_url'] = 'inventory';

        //Validate and input data
        $this->form_validation->set_rules('cate_id', 'category name', 'required|trim');
        $this->form_validation->set_rules('sub_cate_name', 'sub category name', 'required|trim');
        $this->form_validation->set_rules('status', 'Status Feild', 'required|trim');
        if ($this->form_validation->run() == true) {
            $form_data = array(
                'cate_id'  		 => $this->input->post('cate_id'),
                'sub_cate_name'  => $this->input->post('sub_cate_name'),
                'status'         => $this->input->post('status'),
            );

            if ($hid = $this->input->post('hidden_id')) {

                $this->db->where('id', $hid)->update('products_sub_categories', $form_data);
                $this->session->set_flashdata('success', 'Successfully Updated Done');
            } else {
                if($this->Inventory_model->save('products_sub_categories', $form_data)) {
                    $this->session->set_flashdata('success', 'Successfully Insert Done');
                } else {
                    $this->session->set_flashdata('warning', 'Sorry Something Wrong.');
                }
            }
            redirect('admin/inventory/sub_category');
        }

        if ($id != null) {

            $data['row'] = $this->db->where('id', $id)->get("products_sub_categories")->row();

        }
        // dd($data['row']);
        $data['categorys'] = $this->db->order_by('id', 'DESC')->get("products_categories")->result();
        $data['results'] = $this->Inventory_model->sub_category_list();
        $data['subview'] = $this->load->view("admin/inventory/sub_category", $data, true);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function get_sub_category_ajax($cate_id)
    {
        $this->db->where('cate_id', $cate_id);
        $result = $this->db->get('products_sub_categories')->result_array();
        $data[0] = 'Select Sub Category';
        foreach ($result as $rows) {
            $data[$rows['id']] = $rows['sub_cate_name'];
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($data));
    }

    public function get_product_ajax($sub_cate_id)
    {
        $this->db->where('sub_cate_id', $sub_cate_id);
        $result = $this->db->get('products')->result_array();
        $data[0] = 'Select Product';
        foreach ($result as $rows) {
            $data[$rows['id']] = $rows['product_name'];
        }
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($data));
    }

<<<<<<< HEAD
    public function delete_requsiton_item($id, $rid)
    {

        $approved = $this->db->where('id', $id)->delete('products_requisition_details');
        if($approved) {
            $get=$this->db->get('products_requisition_details');
            if($get->num_rows() < 0) {
                $this->db->where('id', $id)->delete('products_requisitions');
                $this->session->set_flashdata('warning', 'Requsiton deleted successfully.');
            }
            redirect("admin/inventory/requsition_edit_approved/".$rid);

        }
    }

    public function delete_requsiton($id)
    {
        $this->db->where('id', $id)->delete('products_requisition_details');
        $this->session->set_flashdata('success', 'Requsiton deleted successfully.');
        redirect("admin/inventory/index");
=======
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
>>>>>>> a78ae8707ff642cd615eb4ae8f44088f89db2070
    }


    public function delete_purches_item($id, $pid)
    {
        $approved = $this->db->where('id', $id)->delete('products_purches_details');
        if($approved) {
            $this->session->set_flashdata('warning', 'Requsiton deleted successfully.');
            redirect("admin/inventory/product_purchase_edit_approved/".$pid);
        }
    }

    public function product_details($id)
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $data['title'] = 'Product Details | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Product Details';
        $data['results'] = $this->Inventory_model->product_details($id);
        // dd($data['results']);
        $data['subview'] = $this->load->view("admin/inventory/product_details", $data, true);
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
        echo(json_encode($query));
        return true;
    }


    public function equipment_list()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $data['session']    = $session;
        $data['equipments'] = $this->Inventory_model->equipment_list($session);
        $this->load->view("admin/inventory/equipment_list", $data);
    }

    public function requisition_list()
    {
        $session = $this->session->userdata('username');
        if(empty($session)) {
            redirect('admin/');
        }
        $data['session']    = $session;
        $data['products'] 	= $this->Inventory_model->requisition_list($session);
        $data['subview']    = $this->load->view("admin/inventory/requisition_list", $data);
    }

}