<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Payroll extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->library('upload');
        $this->load->model('Salary_model');

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
            $lastmonthsalarys  = $this->Salary_model->getpassedmonthsalary($userid);
            // dd($userid);
            $total_salary=0;
            $deduction=0;
            $ModifySalary=0;
            $PaySalary=0;
            $monthName='';
            if(count($lastmonthsalarys)>0) {
                $lastmonthsalaryy =$lastmonthsalarys[0];
                $lastmont=$lastmonthsalarys[0]->salary_month;
                $date_object = DateTime::createFromFormat('Y-m', $lastmont);
                $monthName = $date_object->format('M-Y');
                $total_salary=$lastmonthsalaryy->basic_salary;
                $deduction=$lastmonthsalaryy->late_deduct+$lastmonthsalaryy->absent_deduct;
                $ModifySalary=$lastmonthsalaryy->modify_salary;
                $grand_salary=$lastmonthsalaryy->grand_net_salary;
            }
            $data['monthName']=$monthName;
            $data['total_salary']=$total_salary;
            $data['deduction']=$deduction;
            $data['ModifySalary']=$ModifySalary;
            $data['PaySalary']=$PaySalary;
            $data['Salary_table'] = $this->Salary_model->getall_salary_with_idap($userid);
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
    
}
