<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'libraries/API_Controller.php';
class Requisition extends API_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model("Accessories_model");
		$this->load->model("Xin_model");
		$this->load->model("Inventory_model");
        $this->load->helper('form');
    }

    public function test(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == TRUE) {
            echo json_encode($user_info);
            exit();
        } else {
            echo json_encode($user_info);
            exit();
        }
    }

    public function index(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
            $user_info = $user_info['user_info'];
            $data['using_items'] = $this->db->select('COUNT(user_id) as using_items')->where('user_id',$user_info->user_id)->where('status',1)->get('product_accessories')->row()->using_items;
            $data['requisition_list'] = $this->db->select('COUNT(user_id) as total_requisition_request, COUNT(status) as total_requisition_pending')->where('user_id',$user_info->user_id)->get('products_requisition_details')->row();
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'data' => $data,
            ], 200);
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }

    }
    public function using_list(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
           $user_info =(array) $user_info['user_info'];
           $user_info['role_id'] = $user_info['user_role_id'];
           unset($user_info['user_role_id']);
           $data['equipments'] = $this->Inventory_model->equipment_list($user_info);
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'data' => $data,
            ], 200);
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }

    }

    public function requisition_request_list(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
            $user_info =(array) $user_info['user_info'];
            $user_info['role_id'] = $user_info['user_role_id'];
            unset($user_info['user_role_id']);
            $data['requisition_list'] 	= $this->Inventory_model->requisition_list($user_info);
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'data' => $data,
            ], 200);
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }

    }


//  requisition 
    
    public function all_list(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
            $data['results'] =  $this->Inventory_model->product_list();
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'data' => $data,
            ], 200);
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
    }

    public function get_item_by_id($id){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
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
            $data = $this->db->where('p.id', $id)->get()->row();
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'data' => $data,
            ], 200);
        }else{
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
        	   
    } 

    public function create_requisition(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        $user_info =(array) $user_info['user_info'];
        if($user_info['status']==TRUE){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('cat_id[]', 'select category', 'required|trim');
        $this->form_validation->set_rules('sub_cate_id[]', 'sub category', 'required|trim');
        $this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');
        $this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');
		//Validate and input data
		if ($this->form_validation->run() == true){
			for ($i=0; $i<sizeof($_POST['cat_id']); $i++) {
				$form_data[] = array(
					'user_id' 		   => $user_info['user_id'],
					'cat_id'		   => $_POST['cat_id'][$i],
					'sub_cate_id'	   => $_POST['sub_cate_id'][$i],
					'product_id'	   => $_POST['product_id'][$i],
					'quantity'		   => $_POST['quantity'][$i],
					'requisition_date' => date("Y-m-d"),
					'status'		   => 1,
					'created_at'     => date("y-m-d"),
				);
			}  
			if($this->db->insert_batch('products_requisition_details', $form_data)){
                $this->api_return([
                    'status' => true,
                    'message' => 'successfull',
                ], 200);
			} else {
                $this->api_return([
                    'status' => false,
                    'message' => 'error',
                ], 200);
			} 
		} else {
                $this->api_return([
                    'status' => false,
                    'message' => str_replace("\n", "",strip_tags(validation_errors())),
                ], 200);
			}            
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
        
    }

    // public function get_requisition_info_by_id($id){
    //     $authorization = $this->input->get_request_header('Authorization');
    //     $user_info = api_auth($authorization);
    //     if($user_info['status']==TRUE){

    //         $this->api_return([
    //             'status' => true,
    //             'message' => 'successful',
    //             'data' => $data,
    //         ], 200);
    //     }else {
    //         $this->api_return([
    //             'status' => false,
    //             'message' => 'Unauthorized User',
    //         ], 401);
    //     }

    // }





    // mobile bill requisition 
       // view list 
    public function view_moile_bill_req_list(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
            $user_info = $user_info['user_info'];
            // dd($user_info);
            $data['using_items'] = $this->db->select('COUNT(user_id) as using_items')->where('user_id',$user_info->user_id)->where('status',1)->get('product_accessories')->row()->using_items;
            $data = $this->db->select('*')->where('user_id',$user_info->user_id)->get('mobile_bill_requisition')->result(); 
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'data' => $data,
            ], 200);
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
    }  









}
