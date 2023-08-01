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
    public function index()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        $user_data=$user_info['user_info'];                 
        if ($user_info['status'] == true) {
            $userid=$user_data->user_id;
            $data['user_data']=$user_data;
            $datep        = date( "Y-m-d");
            $date        = date( "Y-m-01");
            $data['present_stutas']  = $this->Salary_model->count_attendance_status_wise($userid, $date , $datep);
            $data['leave_stutas']  = $this->Salary_model->leave_count_status($userid, $date , $datep, 2);  
            $data["today_attendance"]    = $this->Attendance_model->gettodaylog(date("Y-m-d"), $userid);
            $this->db->select("*");
            $this->db->where("employee_id", $userid);
            $this->db->order_by("time_attendance_id", "desc");
            $data['all_attendance'] = $this->db->get('xin_attendance_time')->result();
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
    public function attendance_search()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $First_date = date('Y-m-d', strtotime($this->input->post('First_date')));
        $Last_date = date('Y-m-d', strtotime($this->input->post('Last_date')));
        $user_info = api_auth($authorization);
        $user_data=$user_info['user_info'];
        $userid=$user_data->user_id;

        if ($user_info['status'] == true) {
            $this->db->select("*");
            $this->db->where("employee_id", $userid);
            $this->db->where("attendance_date BETWEEN '$First_date' AND '$Last_date'");
            $this->db->order_by("time_attendance_id", "desc");
            $data['search_attendance'] = $this->db->get('xin_attendance_time')->result();
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