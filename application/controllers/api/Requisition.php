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
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo 'JSON Decode Error: ' . json_last_error_msg();
            }

            if ($data !== null) {
                // Build and execute your SQL query
                foreach ($data->raw_data as $row) {
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

    public function edit($id){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
            $user_info = (array) $user_info['user_info'];
            $data['requisition']= $this->db->select('products_requisition_details.id as req_id,products_categories.id as category_id,products.id as product_id,products_categories.category_name,products.product_name,products_requisition_details.quantity')
                                       ->from('products_requisition_details')
                                       ->join('products_categories', 'products_categories.id = products_requisition_details.cat_id','LEFT')
                                       ->join('products', 'products.id = products_requisition_details.product_id','LEFT')
                                       ->where('user_id',$user_info['user_id'])->get()->row();
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

    public function update(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        $user_info = (array) $user_info['user_info'];

        if ($user_info['status'] == true) {
            $raw_data = $this->input->raw_input_stream;

            $data = json_decode($raw_data);
            // dd($data);
            if ($data !== null) {
                $insert_data = $this->db->where('id',$data->req_id)->update('products_requisition_details', ['quantity' => $data->quantity]);
                if ($insert_data) {
                    $this->api_return([
                    'status' => true,
                    'message' => 'Successfully update',
                    ], 200);
                }else {
                    $this->api_return([
                    'status' => false,
                    'message' => 'Failed to update data',
                    ], 200);
                }
            }else {
                $this->api_return([
                'status' => false,
                'message' => 'Invalid JSON data',
                ], 400);
            }
        }else {
            $this->api_return([
            'status' => false,
            'message' => 'Unauthorized User',
            ], 401);
        }
    }

    public function delete($id){

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        $user_info = (array) $user_info['user_info'];
        if($user_info['status']==TRUE){
            $delete = $this->db->where('id',$id)->delete('products_requisition_details');
            if($delete ){
                $this->api_return([
                    'status' => true,
                    'message' => 'Delete Successful'
                ], 200);
            }else{
                $this->api_return([
                    'status' => true,
                    'message' => 'Error'
                 ], 200);
            }
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }

		
	}

    public function check_user(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
            $user_info = $user_info['user_info'];
            $check = $this->db->select('use_number,number')
                              ->where('number !=','')
                              ->where('user_id',$user_info->user_id)
                              ->get('product_accessories')
                              ->row();
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'user_number' => $check,
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
            $data = $this->db->select('*')->where('user_id',$user_info->user_id)->get('mobile_bill_requisition')->result(); 
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'mobile_bill_req_list' => $data,
            ], 200);
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
    } 

    public function get_number(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
            $user_info = $user_info['user_info'];
            $get_user_number = $this->db->select('mobile_numbers.number')
                        ->from('mobile_numbers')
                        ->join('product_accessories','product_accessories.number = mobile_numbers.id')
                        ->where('product_accessories.user_id',$user_info->user_id)
                        ->get()->row();
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'user_number' => $get_user_number,
            ], 200);
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
    }  

    public function add_mobile_bill(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        // dd($user_info);
        if($user_info['status']==TRUE){
            $raw_data = $this->input->raw_input_stream;
            $data = json_decode($raw_data);
            // dd($data);
            if($data !=null){
                $insert = array(
                            'phone_number'  => $data[0]->phone_number,
                            'amount'        => $data[0]->amount, 
                            'user_id'       => $user_info['user_info']->user_id,
                            'created_at'     =>  date('Y-m-d')
                        );
                $this->db->insert('mobile_bill_requisition',$insert);
                $this->api_return([
                'status' => true,
                'message' => 'successful',
            ], 200);
            }else{
                $this->api_return([
                'status' => true,
                'message' => 'error',
            ], 200);
            }
     
            
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
    }  

    public function edit_bill($id){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if($user_info['status']==TRUE){
            $user_info = (array) $user_info['user_info'];
            $data['mobile_bill']= $this->db->where('id',$id)->get('mobile_bill_requisition')->row();
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

    public function update_bill(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        $user_info = (array) $user_info['user_info'];
        if ($user_info['status'] == true) {
            $raw_data = $this->input->raw_input_stream;
            $data = json_decode($raw_data);
            // dd($data);
            if ($data !== null) {
               $update  = $this->db->where('id',$data[0]->h_id)->update('mobile_bill_requisition',['amount'=>$data[0]->amount]);
                if ($update) {
                    $this->api_return([
                    'status' => true,
                    'message' => 'Successfully update',
                    ], 200);
                }else {
                    $this->api_return([
                    'status' => false,
                    'message' => 'Failed to update data',
                    ], 200);
                }
            }else {
                $this->api_return([
                'status' => false,
                'message' => 'Invalid JSON data',
                ], 400);
            }
        }else {
            $this->api_return([
            'status' => false,
            'message' => 'Unauthorized User',
            ], 401);
        }
    }

    public function delete_number($id){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        $user_info = (array) $user_info['user_info'];
        if($user_info['status']==TRUE){
            $delete = $this->db->where('id',$id)->delete('mobile_bill_requisition');
            if($delete ){
                $this->api_return([
                    'status' => true,
                    'message' => 'Delete Successful'
                ], 200);
            }else{
                $this->api_return([
                    'status' => true,
                    'message' => 'Error'
                ], 200);
            }
        }else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
    }
}
