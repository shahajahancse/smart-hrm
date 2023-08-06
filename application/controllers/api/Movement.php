<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Attendance extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model("Salary_model");
        $this->load->model("Attendance_model");

    }
    /**
     * demo method
     *
     * @link [api/user/demo]
     * @method POST
     * @return Response|void
     */
    public function test()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            echo json_encode($user_info);
            exit();




        } else {
            echo json_encode($user_info);
            exit();
        }
    }
    public function floor_movement_get()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];                 
            $userid=$user_data->user_id;
            $data['user_data']=$user_data;
            $this->db->select('floor_status');
            $this->db->where('user_id', $userid);
            $data['empinfo']=$this->db->get('xin_employees')->row();
            $data['accept_floor']=
            $this->db->select('user_id, first_name,last_name');
            $this->db->where('floor_status !=', $data['empinfo']->floor_status);
            $this->db->where_in('user_role_id', array(2,3,4,5))->where_in('status', array(1,4,5,6));
            $data['emp_floor']=$this->db->get('xin_employees')->result();
           
            $this->api_return([
                'status'    =>  true,
                'message'    =>  'successful',
                'data'       =>  $data,
            ], 200);
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
                'data'     =>   [],
            ], 401);
        }
    }
}
