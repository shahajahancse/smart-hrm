<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Movement extends API_Controller
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
            $userid = $user_info['user_info']->user_id;
            $data['user_data'] = $user_info['user_info'];
            
            $data['resonedata'] = $this->db->order_by('id', 'desc')->get('xin_employee_move_reason')->result();
            $empinfo = $this->db->select('floor_status')->where('user_id', $userid)->get('xin_employees')->row();
            $data['Meet_with'] = $this->db->select('user_id, first_name, last_name')
                ->where('floor_status !=', $empinfo->floor_status)
                ->where_in('user_role_id', [2, 3, 4, 5])
                ->where_in('status', [1, 4, 5, 6])
                ->get('xin_employees')
                ->result();
            $tableay = [];
            $todaylog = $this->Attendance_model->today_floor_movement($userid);
            $todaylog = $todaylog[0];
            $out_time_array = json_decode($todaylog->out_time);
            $in_time_array = json_decode($todaylog->in_time);
            $location_array = json_decode($todaylog->location);
            $reason_array = json_decode($todaylog->reason);
            $meet_with = json_decode($todaylog->meet_with);
            $totalSpendingTime = [
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0
            ];
            foreach ($out_time_array as $i => $out_time) {
                $tableay[$i] = [
                    'date' => date('Y-m-d'),
                    'out_time' => $out_time,
                    'in_time' => isset($in_time_array[$i]) ? $in_time_array[$i] : '',
                    'location' => $location_array[$i],
                    'reason' => $reason_array[$i],
                    'meet_with' => $meet_with[$i]
                ];
                if (isset($in_time_array[$i])) {
                    $outDateTime = new DateTime($out_time);
                    $inDateTime = new DateTime($in_time_array[$i]);
                    $timeDiff = $outDateTime->diff($inDateTime);
                    $totalSpendingTime['hours'] += $timeDiff->h;
                    $totalSpendingTime['minutes'] += $timeDiff->i;
                    $totalSpendingTime['seconds'] += $timeDiff->s;
                }
            }
            $data['tabledata'] = $tableay;
            $data['total_move'] = count($tableay);
            // Adjust total spending time if necessary
            $totalSpendingTime['minutes'] += floor($totalSpendingTime['seconds'] / 60);
            $totalSpendingTime['seconds'] %= 60;
            $totalSpendingTime['hours'] += floor($totalSpendingTime['minutes'] / 60);
            $totalSpendingTime['minutes'] %= 60;
            $data['totaltime'] = $totalSpendingTime['hours'] . ':' . $totalSpendingTime['minutes'];
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'data' => $data,
            ], 200);
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function check_in_floor()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($this->input->post('reason') == '' || $this->input->post('meet_with') == '') {
                // dd('hello');
                $this->api_return([
                    'status' => false,
                    'message' => 'Data is required',
                ], 404);
                exit();
            }

            $user_data=$user_info['user_info'];                 
            $user_id=$user_data->user_id;
            $this->db->select('floor_status');
            $this->db->where('user_id', $user_id);
            $empinfo=$this->db->get('xin_employees')->row();
            if($empinfo->floor_status==5){
                $input_location=3;
            }else{
                $input_location=5;
            }
            $current_date=date('Y-m-d');
            $this->db->select("*");
            $this->db->where("user_id", $user_id);
            $this->db->where("date", $current_date);
            $this->db->limit("1");
            $user_movement = $this->db->get('xin_employee_floor_move')->result();
            // dd($user_movement);
            if(count($user_movement)>0) {
                $selectedOption = $this->input->post('reason');
                $reason=$selectedOption;
                $input_reason=$reason;
                $input_meet_with=$this->input->post('meet_with');
                $currentDateTime = date('g:i A');
                $movementid=$user_movement[0]->id;
                $out_time_array=json_decode($user_movement[0]->out_time);
                $location_array=json_decode($user_movement[0]->location);
                $reason_array=json_decode($user_movement[0]->reason);
                $meet_with_array=json_decode($user_movement[0]->meet_with);
                //    dd($meet_with_array);
                array_push($out_time_array, $currentDateTime);
                array_push($location_array, $input_location);
                array_push($reason_array, $input_reason);
                array_push($meet_with_array, $input_meet_with);
        
        
        
                $out_time=json_encode($out_time_array);
                $location=json_encode($location_array);
                $reason=json_encode($reason_array);
                $meet_with=json_encode($meet_with_array);
                $data = array(
                    'out_time' => $out_time,
                    'location' => $location,
                    'reason' => $reason,
                    'meet_with' => $meet_with,
                    'inout' => 1,
                );
                $this->db->where('id', $movementid);
                if($this->db->update('xin_employee_floor_move', $data)) {
                    $this->api_return([
                        'status' => true,
                        'message' => 'successful',
                    ], 200);
                } else {
                    $this->api_return([
                        'status' => false,
                        'message' => 'Unable to Insert',
                    ], 404);
                };
        
            } else {
              
        
                    $selectedOption = $this->input->post('reason');
                    $reason=$selectedOption;
                    $input_reason=$reason;
                    $meet_with=$this->input->post('meet_with');
        
                    $out_time_array=[];
                    $in_time_array=[];
                    $location_array=[];
                    $reason_array=[];
                    $meetwith_array=[];
                    $currentDateTime = date('g:i A');
                    array_push($out_time_array, $currentDateTime);
                    array_push($location_array, $input_location);
                    array_push($reason_array, $input_reason);
                    array_push($meetwith_array, $meet_with);
               
        
                    $out_time=json_encode($out_time_array);
                    $mettwithh=json_encode($meetwith_array);
        
                    $in_time=json_encode($in_time_array);
                    $location=json_encode($location_array);
                    $reason=json_encode($reason_array);
        
                    $data = array(
                        'user_id' => $user_id,
                        'out_time' => $out_time,
                        'in_time' => $in_time,
                        'location' => $location,
                        'reason' => $reason,
                        'meet_with' => $mettwithh,
                        'date' => $current_date,
                    );
                    if($this->db->insert('xin_employee_floor_move', $data)) {
                        $this->api_return([
                            'status' => true,
                            'message' => 'successful',
                        ], 200);
                    } else {
                        $this->api_return([
                            'status' => false,
                            'message' => 'Unable to Insert',
                        ], 404);
                    };
        
                }
        }else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
            ], 401);
        }
    }
    public function check_out_floor()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];                 
            $user_id=$user_data->user_id;
            $current_date=date('Y-m-d');
       
            $this->db->select("*");
            $this->db->where("user_id", $user_id);
            $this->db->where("date", $current_date);
            $this->db->limit("1");
            $user_movement = $this->db->get('xin_employee_floor_move')->result();
    
            $in_time_array=json_decode($user_movement[0]->in_time);
            $currentDateTime = date('g:i A'); 
            array_push($in_time_array,$currentDateTime);
            $in_time=json_encode($in_time_array);
            $movementid=$user_movement[0]->id;
            $data = array(
                'in_time' => $in_time,
                'inout' => 0,
            );
             $this->db->where('id', $movementid);
            $this->db->update('xin_employee_floor_move', $data);
            $this->api_return([
                'status' => true,
                'message' => 'successful',
            ], 200);
        }else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
            ], 401);
        }
    }
    public function floor_table_search(){
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];                 
            $user_id=$user_data->user_id;
            $date=$this->input->post('date');
            $tableay = [];
            $todaylog = $this->Attendance_model->today_floor_movement($user_id,$date);
            $todaylog = $todaylog[0];
            $out_time_array = json_decode($todaylog->out_time);
            $in_time_array = json_decode($todaylog->in_time);
            $location_array = json_decode($todaylog->location);
            $reason_array = json_decode($todaylog->reason);
            $meet_with = json_decode($todaylog->meet_with);
            foreach ($out_time_array as $i => $out_time) {
                $tableay[$i] = [
                    'date' => date('Y-m-d'),
                    'out_time' => $out_time,
                    'in_time' => isset($in_time_array[$i]) ? $in_time_array[$i] : '',
                    'location' => $location_array[$i],
                    'reason' => $reason_array[$i],
                    'meet_with' => $meet_with[$i]
                ];
            }
            $data['tabledata'] = $tableay;
            $this->api_return([
                'status' => true,
                'message' => 'successful',
                'data' => $data,
            ], 200);
        }else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
                'data'     =>   [],
            ], 401);
        }
    }
}
