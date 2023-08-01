<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Lunch extends API_Controller
{
    public function __construct() {
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
            



        }else{
            echo json_encode($user_info);
            exit();
        }
    }
    public function index()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        $user_data=$user_info['user_info'];
        $data['user_data']=$user_data;
        if ($user_info['status'] == true) {
        $result = $this->db->order_by('id', 'desc')->get('lunch_payment', 1)->row();
        $data['first_date']=$result->end_date;
        $data['second_date']=$result->next_date;
        $data['lunch_data'] = $this->db
        ->select('lunch_payment.*, xin_employees.first_name, xin_employees.last_name, xin_designations.designation_name')
        ->from('lunch_payment')
        ->join('xin_employees', 'lunch_payment.emp_id = xin_employees.user_id')
        ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id')
        ->where('lunch_payment.end_date', $result->end_date)
        ->where('lunch_payment.emp_id', $user_data->user_id)
        ->order_by('lunch_payment.id', 'desc')
        ->get()
        ->result();
        $data['Lunch_data_table'] = $this->db
        ->select('lunch_payment.*, xin_employees.first_name, xin_employees.last_name, xin_designations.designation_name')
        ->from('lunch_payment')
        ->join('xin_employees', 'lunch_payment.emp_id = xin_employees.user_id')
        ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id')
        ->where('lunch_payment.emp_id', $user_data->user_id)
        ->order_by('lunch_payment.id', 'desc')
        ->get()
        ->result();
        $data1=$data['lunch_data'][0];
        $current_month_lonch = $this->Lunch_model->get_data_date_wise($data1->end_date,$data1->next_date, $data1->emp_id);
        $taken_lunch=0;
        foreach ($current_month_lonch['emp_data'] as $r) {
            $taken_lunch+=$r->meal_amount;
        }
        $total_lunch=$data1->pay_amount/45;
        $total_payment=$data1->pay_amount;
        $saved_lunch= $total_lunch-$taken_lunch;

        $data['total_lunch']=$total_lunch;
        $data['total_payment']=$total_payment;
        $data['saved_lunch']=$saved_lunch;
        $data['taken_lunch']=$taken_lunch;


            $this->api_return([
                'success' => true,
                'message' => 'successful',
                'status' => 200,
                'data' => $data,
            ], 200);

        }else{
            $this->api_return([
                'success' => false,
                'message' => 'Unsuccessful',
                'status' => 404,
                'data' =>[],
            ], 404);
        }
    }
}