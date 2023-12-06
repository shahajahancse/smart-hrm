<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Admin extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model("Timesheet_model");
        $this->load->model("Attendance_model");
		$this->load->library('upload');
    }

    // leave
    public function leave_list()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
        if($user_info['user_info']->user_role_id!=3){
            $offset = $this->input->get('offset');
            $limit = $this->input->get('limit');
            $result = $this->Timesheet_model->get_leaves_with_info_with_pagi($offset, $limit);
            if ($result) {
                $this->api_return([
                    'status'    =>  true,
                    'message'    =>  'successful',
                    'data'       =>  $result,
                ], 200);
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'data' => [],
                ], 401);
            }
        }else{
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
    }else{
        $this->api_return([
            'status' => false,
            'message' => 'Unauthorized User',
            'data' => [],
        ], 401);
    }
    }
    public function single_leave_status()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
        if($user_info['user_info']->user_role_id!=3){
            $id = $this->input->get('leave_id');
            $data['result'] = $this->Timesheet_model->get_leaves_leave_id_with_info($id);
            $data['leave_calel']=12-get_cal_leave($data['result']->employee_id, 1);
            $data['leave_calel_percent']=$data['leave_calel']*100/12;
            $data['leave_calsl']=4-get_cal_leave($data['result']->employee_id, 2);
            $data['leave_calsl_percent']=$data['leave_calsl']*100/4;
            if ($data) {
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
        }else{
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
        }else{
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function single_leave_status_change()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if($user_info['user_info']->user_role_id!=3){
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $total_days = $this->input->post('total_days');
                $status = $this->input->post('status');
                $remark = $this->input->post('remark');
                $leave_id = $this->input->post('leave_id');

                $hulfday=0;
                if($this->input->post('Half_Day')){
                    $hulfday=1;
                    $total_days=0.5;
                }
                $qt_remarks = htmlspecialchars(addslashes($remark), ENT_QUOTES);
                $stutuss=$this->input->post('status');
                if ($stutuss==4 ||$stutuss==3 ||$stutuss==2){
                    $notyfi_data=3;
                }else{
                    $notyfi_data=1;
                };
                $qnty= $total_days;

                $data = array(
                    'status' => $status,
                    'remarks' => $qt_remarks,
                    'notify_leave' => $notyfi_data,
                    'from_date' =>$from_date,
                    'to_date' => $to_date,
                    'qty' => $qnty,
                    'is_half_day' => $hulfday
                );
                $id=$this->input->post('leave_id');
                $result = $this->Timesheet_model->update_leave_record($data,$id);
                if($result == TRUE) {
                    if($data['qty'] > 0){
                        for ($i=0; $i < $data['qty']; $i++) { 
                            $process_date = date("Y-m-d",strtotime("+$i day", strtotime($data['from_date'])));
                            $this->Attendance_model->attn_process($process_date, array($_POST['emp_id']));
                        }
                    }
                $this->api_return([
                    'status'    =>  true,
                    'message'    =>  'successful',
                    'data'       =>  $data,
                ], 200);
            }else{
                $this->api_return([
                    'status' => false,
                    'message' => 'request failed',
                    'data' => [],
                ], 200);
            }
        }else{
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        };
        }else{
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    // levae end



}
