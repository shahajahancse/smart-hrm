<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Leave extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model("Timesheet_model");
        $this->load->model("Xin_model");
        $this->load->model("Department_model");
        $this->load->library('upload');
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
            $data['leave_type']=array(
                'Earn_leave'=>1,
                'Sick_leave'=>2,
            );

            $this->api_return([
                'status'    =>  true,
                'message'    =>  'successful',
                'data'       =>  $data,
            ], 200);

        } else {
            $this->api_return([
                'status'   =>   false,
                'message'  =>   'Unsuccessful',
                'data'     =>   [],
            ], 404);
        }
    }
    public function add_leave()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;
            $d= $this->input->post();
            $start_date=$d['start_date'];
            $end_date=$d['end_date'];
            if (empty($d['leave_type']) || empty($d['start_date']) || empty($d['end_date']) || empty($d['reason'])) {
                $this->api_return([
                    'status'  =>   false,
                    'message'  =>   'Missing required fields',
                    'data'     =>   [],
                ], 404);
                exit();
            }
            $leave_date = $this->db->select('from_date,to_date')->where('employee_id', $userid)->get('xin_leave_applications')->result();

            //check duplicate leave date
            foreach($leave_date as $date) {
                if($date->from_date == $start_date && $date->to_date == $end_date) {
                    $this->api_return([
                        'status'  =>   false,
                        'message'  =>   " Can't applied For This Date, Leave Already Have For This Date",
                        'data'     =>   [],
                    ], 404);
                    exit();
                }
            }

            $datetime1 = new DateTime($this->input->post('start_date'));
            $datetime2 = new DateTime($this->input->post('end_date'));
            $interval = $datetime1->diff($datetime2);
            $no_of_days = $interval->format('%a') + 1;

            if($this->input->post('leave_half_day') == 1 && $no_of_days > 1) {
                $this->api_return([
                    'status'  =>   false,
                    'message'  =>   "Half Leave Can't applied  more than 1 day",
                    'data'     =>   [],
                ], 404);
                exit();
            }



            if($this->input->post('start_date')!='') {

                if($this->input->post('leave_half_day') == 1 && $no_of_days == 1) {
                    $no_of_days = 0.5;
                }

                $total = get_cal_leave($userid, $this->input->post('leave_type'));

                if($this->input->post('leave_half_day') != 1) {
                    if($no_of_days > $total) {
                        $this->api_return([
                            'status'  =>   false,
                            'message'  =>   "Half Leave Can't applied  more than 1 day",
                            'data'     =>   [],
                        ], 404);
                        exit();
                    }
                } else {
                    if(0.5 >  $total) {
                        $this->api_return([
                            'status'  =>   false,
                            'message'  =>   "Leave Can't applied  more than ".$total ."day",
                            'data'     =>   [],
                        ], 404);
                        exit();
                    }
                }

                if ($this->input->post('leave_type') == 2) {
                    $type_name = " Sick leave";
                } else {
                    $type_name = " Earn leave";
                }

                if($total < 0.4) {
                    $this->api_return([
                        'status'  =>   false,
                        'message'  =>   "Leave Can't applied For Leave ",
                        'data'     =>   [],
                    ], 404);
                    exit();
                }
            }



            if($this->input->post('leave_half_day') != 1) {
                $leave_half_day_opt = 0;
            } else {
                $leave_half_day_opt = $this->input->post('leave_half_day');
            }

            if($_FILES['attachment']['tmp_name']!='') {

                $config['upload_path'] = './uploads/leave/'; // Modify this path as needed
                $config['allowed_types'] = 'gif|jpg|png|pdf'; // Add more allowed file types as needed
                $config['encrypt_name'] = true; // Generate a unique encrypted filename
                $config['max_size'] = 10048; // Set maximum file size in kilobytes (2MB in this case)
                $this->upload->initialize($config);
                $this->upload->do_upload('attachment');
                $fileData = $this->upload->data();
                $fileLocation ='uploads/leave/'.$fileData['file_name'];
            } else {
                $fileLocation = '';
            }

            $data = array(
            'employee_id' => $userid,
            'company_id' => 1,
            'leave_type_id' => $this->input->post('leave_type'),
            'leave_type' => ($this->input->post('leave_type') == 1) ? 'el' : 'sl',
            'from_date' => $this->input->post('start_date'),
            'to_date' => $this->input->post('end_date'),
            'applied_on' => date('Y-m-d h:i:s'),
            'reason' => $this->input->post('reason'),
            'qty' => $no_of_days,
            'leave_attachment' => $fileLocation,
            'status' => '1',
            'notify_leave' => '1',
            'is_half_day' => $leave_half_day_opt,
            'created_at' => date('Y-m-d h:i:s'),
            'current_year' => date('Y'),
            );
            $result = $this->Timesheet_model->add_leave_record($data);
            if ($result==true) {
                $this->api_return([
                    'status'    =>  true,
                    'message'    =>  'successful',
                    'data'       =>  [],
                ], 200);
            } else {
                $this->api_return([
                    'status'  =>   false,
                    'message'  =>   'Unsuccessful',
                    'data'     =>   [],
                ], 404);
            }
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unsuccessful',
                'data'     =>   [],
            ], 404);
        }
    }
    public function leave_details()
    {
        $leave_id = $this->input->get('leave_id');
        $result = $this->Timesheet_model->read_leave_information($leave_id);
        if(is_null($result)) {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unsuccessful',
                'data'     =>   [],
            ], 404);
            exit();
        }
        $edata = array(
            'notify_leave' => 0,
        );
        $this->Timesheet_model->update_leave_record($edata, $leave_id);

        $type = $this->Timesheet_model->read_leave_type_information($result[0]->leave_type_id);
        if(!is_null($type)) {
            $type_name = $type[0]->type_name;
        } else {
            $type_name = '--';
        }
        // get employee
        $user = $this->Xin_model->read_user_info($result[0]->employee_id);
        if(!is_null($user)) {
            $full_name = $user[0]->first_name. ' '.$user[0]->last_name;
            $u_role_id = $user[0]->user_role_id;
            $department = $this->Department_model->read_department_information($user[0]->department_id);
            if(!is_null($department)) {
                $department_name = $department[0]->department_name;
            } else {
                $department_name = '--';
            }
        } else {
            $full_name = '--';
            $u_role_id = '--';
            $department_name = '--';
        }

        $data = array(
            'title' => $this->lang->line('xin_leave_detail').' | '.$this->Xin_model->site_title(),
            'type' => $type_name,
            'role_id' => $u_role_id,
            'full_name' => $full_name,
            'department_name' => $department_name,
            'leave_id' => $result[0]->leave_id,
            'employee_id' => $result[0]->employee_id,
            'day' => $result[0]->qty,
            'company_id' => $result[0]->company_id,
            'leave_type_id' => $result[0]->leave_type_id,
            'from_date' => $result[0]->from_date,
            'to_date' => $result[0]->to_date,
            'applied_on' => $result[0]->applied_on,
            'reason' => $result[0]->reason,
            'remarks' => $result[0]->remarks,
            'status' => $result[0]->status,
            'leave_attachment' => $result[0]->leave_attachment,
            'is_half_day' => $result[0]->is_half_day,
            'created_at' => $result[0]->created_at,
            'all_leave_types' => $this->Timesheet_model->all_leave_types(),
        );
        $this->api_return([
            'status'    =>  true,
            'message'    =>  'Data Not found',
            'data'       =>  $data,
        ], 200);
    }
    public function leave_delete()
    {
        $leave_id = $this->input->get('leave_id');
        $result = $this->Timesheet_model->read_leave_information($leave_id);
        if ($result[0]->status==1) {
          $this->db->where('leave_id',$leave_id)->from('xin_leave_applications')->delete();
          $this->api_return([
            'status'    =>  true,
            'message'    =>  'Leave  Delete Successful',
        ], 200);
        }else{
            $this->api_return([
                'status'    =>  true,
                'message'    =>  'Leave  Delete not allowed',
            ], 200);
        }
       
    }
}
