<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Leave extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
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
    public function index()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];                 
            $userid=$user_data->user_id;
            $this->db->select("*");
            $this->db->where("employee_id", $userid);
            $this->db->order_by("from_date", "desc");
            $data['leavedata'] = $this->db->get('xin_leave_applications')->result();        
            $data['leave_calel']=get_cal_leave($userid, 1);
            $data['leave_calsl']=get_cal_leave($userid, 2);
            $this->api_return([
                'status'    =>  true,
                'message'    =>  'successful',
                'data'       =>  $data,
            ], 200);
           
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unsuccessful',
                'data'     =>   [],
            ], 404);
        }
    }
    public function lunch_search()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $First_date = date('Y-m-d', strtotime($this->input->post('First_date')));
        $Last_date = date('Y-m-d', strtotime($this->input->post('Last_date')));
        $user_info = api_auth($authorization);
        $user_data=$user_info['user_info'];
        if ($user_info['status'] == true) {
            $data['Lunch_data_table'] = $this->db
                                ->select('*')
                                ->from('lunch_payment')
                                ->where('lunch_payment.emp_id', $user_data->user_id)
                                ->where('lunch_payment.end_date >=', $First_date)
                                ->where('lunch_payment.end_date<=', $Last_date)
                                ->order_by('lunch_payment.id', 'desc')
                                ->get()
                                ->result();
            $this->api_return([
                'status'    =>  true,
                'message'    =>  'successful',
                'data'       =>  $data,
            ], 200);
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unsuccessful',
                'data'     =>   [],
            ], 404);
        }
    }
}
