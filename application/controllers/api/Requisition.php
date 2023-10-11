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
             $this->db->select('
                p.cat_id, 
                p.sub_cate_id, 
		   		p.id as product_id, 
		   		pc.category_name, 
		   		psc.sub_cate_name,
		   		p.product_name, 
		   		p.quantity, 
		   		pu.unit_name
	   		');
            $this->db->from('products as p');
            $this->db->join('products_categories as pc', 'pc.id = p.cat_id');
            $this->db->join('products_sub_categories as psc', 'psc.id = p.sub_cate_id');
            $this->db->join('product_unit as pu', 'pu.id = p.unit_id');
            $this->db->order_by('p.id','ASC');
            $data = $this->db->get()->result();
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
                p.cat_id, 
                p.sub_cate_id, 
		   		p.id as product_id, 
		   		pc.category_name, 
		   		psc.sub_cate_name,
		   		p.product_name, 
		   		p.quantity, 
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

public function create_requisition() {
    $authorization = $this->input->get_request_header('Authorization');
    $user_info = api_auth($authorization);
    $user_info = (array) $user_info['user_info'];
    
    if ($user_info['status'] == TRUE) {
        $raw_data = $this->input->raw_input_stream;
        $data = json_decode($raw_data);

        // Check if the JSON data could be successfully decoded
        if ($data !== null) {
            // Build and execute your SQL query
            foreach ($data as $row) {
                $insert_data = array(
                    'cat_id' => $row->cat_id,
                    'sub_cate_id' => $row->sub_cate_id,
                    'product_id' => $row->product_id,
                    'quantity' => $row->quantity,
                    'user_id' => $user_info['user_id'],
                    'requisition_date'=>date('Y-m-d'),
                    'created_at'=>date('Y-m-d'),
                );
                $this->db->insert('products_requisition_details', $insert_data);
            }
            if ($insert_data > 0) {
                $this->api_return([
                    'status' => true,
                    'message' => 'Successfully inserted data',
                ], 200);
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Failed to insert data',
                ], 200);
            }
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Invalid JSON data',
            ], 400); // Return a 400 Bad Request status for invalid JSON
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



    public function delete_requsiton_item($id){

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){

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

		$delete = $this->db->where('id',$id)->delete('products_requisition_details');
		$this->db->where('id',$id)->delete('products_requisitions');
		$this->session->set_flashdata('warning', 'Requsiton deleted successfully.');
		redirect("admin/inventory/index");
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
