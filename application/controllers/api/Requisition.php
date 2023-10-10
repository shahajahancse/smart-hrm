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
