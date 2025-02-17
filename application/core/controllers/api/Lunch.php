<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Lunch extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model("Lunch_model");

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
            $result = $this->db->order_by('id', 'desc')->get('lunch_payment', 1)->row();
         
            $lunch_data = $this->db
                                ->select('lunch_payment.*')
                                ->from('lunch_payment')
                                ->where('lunch_payment.end_date', $result->end_date)
                                ->where('lunch_payment.emp_id', $user_data->user_id)
                                ->order_by('lunch_payment.id', 'desc')
                                ->get()
                                ->result();
            $data['Lunch_data_table'] = $this->db
                                ->select('*')
                                ->from('lunch_payment')
                                ->where('lunch_payment.emp_id', $user_data->user_id)
                                ->order_by('lunch_payment.id', 'desc')
                                ->get()
                                ->result();
            $data1=$lunch_data[0];
            $first_date = date('Y-m-d', strtotime($data1->end_date . ' +1 day'));
            $second_date = date('Y-m-d', strtotime($data1->next_date . ' +1 day'));
            $data['first_date']=$first_date;
            $data['second_date']=$second_date;

         

            $current_month_lonch = $this->Lunch_model->get_data_date_wise($first_date, $second_date,$data1->emp_id);
            $taken_lunch=0;
            foreach ($current_month_lonch['emp_data'] as $r) {
                $taken_lunch+=$r->meal_amount;
              
            }

            $total_lunch    =   $data1->probable_meal;
            $total_payment  =   $data1->pay_amount;
            $saved_lunch    =   $total_lunch-$taken_lunch;
            $data['total_lunch']    =   $total_lunch;
            $data['total_payment']  =   $total_payment;
            $data['saved_lunch']    =   $saved_lunch;
            $data['taken_lunch' ]   =   $taken_lunch;
            $this->api_return([
                'status'    =>  true,
                'message'    =>  'successful',
                'data'       =>  $data,
            ], 200);
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
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
