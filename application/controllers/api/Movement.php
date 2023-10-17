<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Movement extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->library('upload');
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
            if (isset($todaylog[0])) {
                $todaylog = $todaylog[0];
            
                $out_time_array = isset($todaylog->out_time) ? json_decode($todaylog->out_time) : null;
                $in_time_array = isset($todaylog->in_time) ? json_decode($todaylog->in_time) : null;
                $location_array = isset($todaylog->location) ? json_decode($todaylog->location) : null;
                $reason_array = isset($todaylog->reason) ? json_decode($todaylog->reason) : null;
                $meet_with = isset($todaylog->meet_with) ? json_decode($todaylog->meet_with) : null;
            }else{
                $out_time_array = [];
                $in_time_array = [];
                $location_array = [];
                $reason_array = [];
                $meet_with =[];
            }
            $totalSpendingTime = [
                'hours' => 0,
                'minutes' => 0,
                'seconds' => 0
            ];
            foreach ($out_time_array as $i => $out_time) {
                $meetwithname=$this->getnamewithid($meet_with[$i]);
                $reasonname=$this->getResonewithid($reason_array[$i]);
                $tableay[$i] = [
                    'date' => date('Y-m-d'),
                    'out_time' => $out_time,
                    'in_time' => isset($in_time_array[$i]) ? $in_time_array[$i] : '',
                    'location' => $location_array[$i],
                    'reason' => $reasonname,
                    'meet_with' => $meetwithname
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

            if($empinfo->floor_status==5) {
                $input_location=3;
            } else {
                $input_location=5;
            }
            $current_date=date('Y-m-d');
            $this->db->select("*");
            $this->db->where("user_id", $user_id);
            $this->db->where("date", $current_date);
            $this->db->limit("1");
            $user_movement = $this->db->get('xin_employee_floor_move')->result();
            if (isset($user_movement[0]->in_out) && $user_movement[0]->in_out != 0) {
                $this->api_return([
                    'status' => false,
                    'message' => 'Sorry, You are currently out of Your Desk',
                ], 404);
                return;
            }
            if(count($user_movement)>0) {
                $selectedOption = $this->input->post('reason');
                $reason=$selectedOption;
                $input_reason=$reason;
                $input_meet_with=$this->input->post('meet_with');
                $currentDateTime = date('H:i:s');
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
                $currentDateTime = date('H:i:s');
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
        } else {
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
            array_push($in_time_array, $currentDateTime);
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
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
            ], 401);
        }
    }
    public function floor_table_search()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $user_id=$user_data->user_id;
            $date=$this->input->post('date');
            $tableay = [];
            $todaylog = $this->Attendance_model->today_floor_movement($user_id, $date);
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
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
                'data'     =>   [],
            ], 401);
        }
    }
    public function outside_office_movement_get()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;
                $this->db->select("em.*, mr.title as reason, pl.address as place");
                $this->db->join("xin_employee_move_reason as mr", 'em.reason = mr.id', 'left');
                $this->db->join("xin_employee_move_place as pl", 'em.place_adress = pl.place_id', 'left');
                $this->db->where("employee_id", $userid);
                $this->db->where("location_status", 1);
                $this->db->order_by("id", "desc");
                $alldata= $this->db->get('xin_employee_move_register as em')->result();
                $totalRows = count($alldata);
                $in_out=0;
                if ($totalRows>0) {
                    $in_out=$alldata[0]->in_out;
                    $outtime=$alldata[0]->out_time;
                    $payable_amount=0;
                    foreach ($alldata as $d) {
                        $payable_amount+= $d->payable_amount;
                    }
                    $data['total_move']=$totalRows;
                    $data['in_out']=$in_out;
                    if($in_out!=0) {
                        $data['outtime']=$outtime;
                    }
                    $data['payable_amount']=$payable_amount;
                }else{
                    $data['Total_move']=0;
                    $data['in_out']=$in_out;
                    $data['payable_amount']=0;
                }  
                $f1_date=date("Y-m-d",strtotime('-1 month'));
                $f2_date=date('Y-m-d');
                $this->db->select("em.*, mr.title as reason, pl.address as place");
                $this->db->join("xin_employee_move_reason as mr", 'em.reason = mr.id', 'left');
                $this->db->join("xin_employee_move_place as pl", 'em.place_adress = pl.place_id', 'left');
                $this->db->where("date BETWEEN '$f1_date' AND '$f2_date'");
                $this->db->where("employee_id", $userid);
                $this->db->where("location_status", 1);
                $this->db->order_by("id", "desc");
                $data['Table_data'] = $this->db->get('xin_employee_move_register as em')->result();
                $data['resonedata'] = $this->db->order_by('id', 'desc')->get('xin_employee_move_reason')->result();
                $data['moveplace'] = $this->db->where('place_status', 1)->get('xin_employee_move_place')->result();
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
    public function outside_office_movement_search()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;
            $date=$this->input->post('date');
            $f1_date = date("Y-m-01", strtotime($date));
            $f2_date = date("Y-m-t", strtotime($date));
                $this->db->select("em.*, mr.title as reason, pl.address as place");
                $this->db->join("xin_employee_move_reason as mr", 'em.reason = mr.id', 'left');
                $this->db->join("xin_employee_move_place as pl", 'em.place_adress = pl.place_id', 'left');
                $this->db->where("date BETWEEN '$f1_date' AND '$f2_date'");
                $this->db->where("employee_id", $userid);
                $this->db->where("location_status", 1);
                $this->db->order_by("id", "desc");
                $data['Table_data'] = $this->db->get('xin_employee_move_register as em')->result();
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
    public function outside_office_movement_add()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($this->input->post('reason') == '' || $this->input->post('place_adress') == '') {
                $this->api_return([
                    'status' => false,
                    'message' => 'Data is required',
                ], 404);
                exit();
            }
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;

            $location_status=1;
            $this->db->select("*");
            $this->db->where("employee_id", $userid);
            $this->db->where("location_status", $location_status);
            $this->db->order_by("id", "desc");
            $this->db->limit(1); // Limit the result to 1 row
            $alldata = $this->db->get('xin_employee_move_register')->row();
            if (isset($alldata->in_out) && $alldata->in_out != 0) {
                $this->api_return([
                    'status' => false,
                    'message' => 'Sorry, You are currently out of office',
                ], 404);
                return;
            }
            
            if($location_status==2) {
                $osd_status=0;
            } else {
                $osd_status=1;
            }
            $reason=$this->input->post('reason');
            $data = array(
                'employee_id' => $userid,
                'date' => date('Y-m-d'),
                'out_time' => date('Y-m-d H:i:s'),
                'in_time' => date('Y-m-d H:i:s'),
                'duration' => '00:00:00',
                'request_amount' => 0,
                'payable_amount' => 0,
                'status' => 0,
                'astatus' => 1,
                'osd_status' => $osd_status,
                'reason' => $reason,
                'location_status' => $location_status ,
                'in_out' => 1,
                'place_adress' => $this->input->post('place_adress'),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            if($this->db->insert("xin_employee_move_register", $data)) {
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                ], 200);
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unsuccessful',
                ], 404);
            }
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    
    public function outside_office_movement_checkout()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;
            $location_status=1;
            $this->db->select("*");
            $this->db->where("employee_id", $userid);
            $this->db->where("location_status", $location_status);
            $this->db->order_by("id", "desc");
            $this->db->limit(1); // Limit the result to 1 row
            $alldata = $this->db->get('xin_employee_move_register')->row();
            $targetDate = new DateTime($alldata->out_time);
            // Get the current date and time
            $currentDate = new DateTime();
            // Calculate the time difference
            $timeDiff = $currentDate->diff($targetDate);
            $timeDifferenceFormatted=$timeDiff->format('%d day, %H:%i:%s');
            // dd($timeDifferenceFormatted);
            $data = array(
                'in_time' => date('Y-m-d H:i:s'),
                'duration' => $timeDifferenceFormatted,
                'in_out' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', $alldata->id);
            if($this->db->update('xin_employee_move_register', $data)) {
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                ], 200);
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unsuccessful',
                ], 404);
            }
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function outside_dhaka_movement_get()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;
                $this->db->select("em.*, mr.title as reason, pl.address as place");
                $this->db->join("xin_employee_move_reason as mr", 'em.reason = mr.id', 'left');
                $this->db->join("xin_employee_move_place as pl", 'em.place_adress = pl.place_id', 'left');
                $this->db->where("employee_id", $userid);
                $this->db->where("location_status", 2);
                $this->db->order_by("id", "desc");
                $alldata= $this->db->get('xin_employee_move_register as em')->result();
                $totalRows = count($alldata);
                $in_out=0;
                if ($totalRows>0) {
                    $in_out=$alldata[0]->in_out;
                    $outtime=$alldata[0]->out_time;
                    $payable_amount=0;
                    foreach ($alldata as $d) {
                        $payable_amount+= $d->payable_amount;
                    }
                    $data['total_move']=$totalRows;
                    $data['in_out']=$in_out;
                    if($in_out!=0) {
                        $data['outtime']=$outtime;
                    }
                    $data['payable_amount']=$payable_amount;
                }else{
                    $data['Total_move']=0;
                    $data['in_out']=$in_out;
                    $data['payable_amount']=0;
                }  
                $f1_date=date("Y-m-d",strtotime('-1 month'));
                $f2_date=date('Y-m-d');
                $this->db->select("em.*, mr.title as reason, pl.address as place");
                $this->db->join("xin_employee_move_reason as mr", 'em.reason = mr.id', 'left');
                $this->db->join("xin_employee_move_place as pl", 'em.place_adress = pl.place_id', 'left');
                $this->db->where("date BETWEEN '$f1_date' AND '$f2_date'");
                $this->db->where("employee_id", $userid);
                $this->db->where("location_status", 2);
                $this->db->order_by("id", "desc");
                $data['Table_data'] = $this->db->get('xin_employee_move_register as em')->result();
                $data['resonedata'] = $this->db->order_by('id', 'desc')->get('xin_employee_move_reason')->result();
                $data['moveplace'] = $this->db->where('place_status', 2)->get('xin_employee_move_place')->result();
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
    public function outside_dhaka_movement_search()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;
            $date=$this->input->post('date');
            $f1_date = date("Y-m-01", strtotime($date));
            $f2_date = date("Y-m-t", strtotime($date));
                $this->db->select("em.*, mr.title as reason, pl.address as place");
                $this->db->join("xin_employee_move_reason as mr", 'em.reason = mr.id', 'left');
                $this->db->join("xin_employee_move_place as pl", 'em.place_adress = pl.place_id', 'left');
                $this->db->where("date BETWEEN '$f1_date' AND '$f2_date'");
                $this->db->where("employee_id", $userid);
                $this->db->where("location_status", 2);
                $this->db->order_by("id", "desc");
                $data['Table_data'] = $this->db->get('xin_employee_move_register as em')->result();
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
    public function outside_dhaka_movement_add()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            if ($this->input->post('reason') == '' || $this->input->post('place_adress') == '') {
                $this->api_return([
                    'status' => false,
                    'message' => 'Data is required',
                ], 404);
                exit();
            }
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;

            $location_status=2;
            $this->db->select("*");
            $this->db->where("employee_id", $userid);
            $this->db->where("location_status", $location_status);
            $this->db->order_by("id", "desc");
            $this->db->limit(1); // Limit the result to 1 row
            $alldata = $this->db->get('xin_employee_move_register')->row();
            if (isset($alldata->in_out) && $alldata->in_out != 0) {
                $this->api_return([
                    'status' => false,
                    'message' => 'Sorry, You are currently out of office',
                ], 404);
                return;
            }
            
            if($location_status==2) {
                $osd_status=0;
            } else {
                $osd_status=1;
            }
            $reason=$this->input->post('reason');
            $data = array(
                'employee_id' => $userid,
                'date' => date('Y-m-d'),
                'out_time' => date('Y-m-d H:i:s'),
                'in_time' => date('Y-m-d H:i:s'),
                'duration' => '00:00:00',
                'request_amount' => 0,
                'payable_amount' => 0,
                'status' => 0,
                'astatus' => 1,
                'osd_status' => $osd_status,
                'reason' => $reason,
                'location_status' => $location_status ,
                'in_out' => 1,
                'place_adress' => $this->input->post('place_adress'),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            if($this->db->insert("xin_employee_move_register", $data)) {
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                ], 200);
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unsuccessful',
                ], 404);
            }
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
                'data' => [],
            ], 401);
        }
    }
    public function outside_dhaka_movement_checkout()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;
            $location_status=2;
            $this->db->select("*");
            $this->db->where("employee_id", $userid);
            $this->db->where("location_status", $location_status);
            $this->db->order_by("id", "desc");
            $this->db->limit(1); // Limit the result to 1 row
            $alldata = $this->db->get('xin_employee_move_register')->row();
            $targetDate = new DateTime($alldata->out_time);
            // Get the current date and time
            $currentDate = new DateTime();
            // Calculate the time difference
            $timeDiff = $currentDate->diff($targetDate);
            $timeDifferenceFormatted=$timeDiff->format('%d day, %H:%i:%s');
            $data = array(
                'in_time' => date('Y-m-d H:i:s'),
                'duration' => $timeDifferenceFormatted,
                'in_out' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', $alldata->id);
            if($this->db->update('xin_employee_move_register', $data)) {
                $this->api_return([
                    'status' => true,
                    'message' => 'successful',
                ], 200);
            } else {
                $this->api_return([
                    'status' => false,
                    'message' => 'Unsuccessful',
                ], 404);
            }
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
    }
    public function ta_da_form()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;
            $data['move_id']= $this->input->get('move_id');
            $move_id= $this->input->get('id');
            $this->db->select("*");
            $this->db->where("move_id", $data['move_id']);
            $movedata  = $this->db->get('xin_employee_move_details')->row();
            if($movedata != null || $movedata!='') {
                $data['move_id'] = $movedata->move_id;
                $going_way_place = json_decode($movedata->g_place);
                $going_way_transportation = json_decode($movedata->g_transportation);
                $going_way_costing = json_decode($movedata->g_costing);
                $coming_way_place = json_decode($movedata->c_place);
                $coming_way_transportation = json_decode($movedata->c_transportation);
                $coming_way_costing = json_decode($movedata->c_costing);
            }
                // Accessing the decoded values
            $data['going_way_place'] = isset($going_way_place) ? $going_way_place : null;
            $data['going_way_transportation'] = isset($going_way_transportation) ? $going_way_transportation : null;
            $data['going_way_costing'] = isset($going_way_costing) ? $going_way_costing : null;
            $data['coming_way_place'] = isset($coming_way_place) ? $coming_way_place : null;
            $data['coming_way_transportation'] = isset($coming_way_transportation) ? $coming_way_transportation : null;
            $data['coming_way_costing'] = isset($coming_way_costing) ? $coming_way_costing : null;
            $data['additional_cost'] = isset($movedata->additional_cost) ? $movedata->additional_cost : null;
            $data['costing_invoice'] = isset($movedata->costing_invoice) ? $movedata->costing_invoice : null;
            $data['remark'] = isset($movedata->remark) ? $movedata->remark : null;
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
    public function add_ta_da()
    {

        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];
            $userid=$user_data->user_id;
            if ($this->input->post('move_id') == '') {
                $this->api_return([
                    'status' => false,
                    'message' => 'Data is required',
                ], 404);
                exit();
            }
            $move_id = $this->input->post('move_id');
            $gonig_way_place =$this->input->post('going_way_place');
            $gonig_way_transport =$this->input->post('going_way_transport');
            $gonig_way_costing =$this->input->post('going_way_cost');
            $coming_way_place =$this->input->post('coming_way_place');
            $coming_way_transport =$this->input->post('coming_way_transport');
            $coming_way_costing =$this->input->post('coming_way_cost');
            $additional_cost = $this->input->post('additional_cost');
            $remark = $this->input->post('remark');
            $total_cost=0;
            $goingcosrarray=json_decode($this->input->post('going_way_cost'));
            $comingcostrarray=json_decode($this->input->post('coming_way_cost'));
            foreach ($goingcosrarray as  $value) {
                $total_cost+=$value;
            };
            foreach ($comingcostrarray as  $v) {
                $total_cost+=$v;
            };
            $total_cost+=$additional_cost;
            $data1 = array(
                'request_amount' => $total_cost, // Add the file location to the data array
                'status' => 1
            );
            $this->db->where('id', $move_id);
            $this->db->update('xin_employee_move_register', $data1);
            // File Upload Configuration
            $config['upload_path'] = './uploads/move_file/'; // Modify this path as needed
            $config['allowed_types'] = 'gif|jpg|png|pdf'; // Add more allowed file types as needed
            $config['encrypt_name'] = true; // Generate a unique encrypted filename
            $config['max_size'] = 10048; // Set maximum file size in kilobytes (2MB in this case)
            $this->upload->initialize($config);
            if ($this->upload->do_upload('additional_invoice')) {
                // File uploaded successfully
                $fileData = $this->upload->data();
                $fileLocation = base_url('uploads/move_file/') . $fileData['file_name'];
                $data = array(
                    'move_id' => $move_id,
                    'g_place' => $gonig_way_place,
                    'g_transportation' => $gonig_way_transport,
                    'g_costing' => $gonig_way_costing,
                    'c_place' => $coming_way_place,
                    'c_transportation' => $coming_way_transport,
                    'c_costing' => $coming_way_costing,
                    'additional_cost' => $additional_cost,
                    'remark' => $remark,
                    'costing_invoice' => $fileLocation // Add the file location to the data array
                );
            } else {
                // File upload failed or no file was uploaded
                $data = array(
                    'move_id' => $move_id,
                    'g_place' => $gonig_way_place,
                    'g_transportation' => $gonig_way_transport,
                    'g_costing' => $gonig_way_costing,
                    'c_place' => $coming_way_place,
                    'c_transportation' => $coming_way_transport,
                    'c_costing' => $coming_way_costing,
                    'additional_cost' => $additional_cost,
                    'remark' => $remark,
                );
            }
            // Update the database
            $this->db->select("*");
            $this->db->where("move_id", $move_id);
            $movedata  = $this->db->get('xin_employee_move_details')->result();
            if (count($movedata) != 0) {
                $this->db->where('move_id', $move_id);
                $this->db->update('xin_employee_move_details', $data);
            }else{
                    $this->db->insert('xin_employee_move_details', $data);
                }
            $this->api_return([
                'status' => true,
                'message' => 'successful',
            ], 200);
        } else {
            $this->api_return([
                'status' => false,
                'message' => 'Unauthorized User',
            ], 401);
        }
    }

    public function getnamewithid($id) {
        $this->db->select('first_name, last_name');
        $this->db->where('user_id', $id);
        $data = $this->db->get('xin_employees')->row();
        $fullname = $data->first_name . ' ' . $data->last_name;
        return $fullname;
    }

    public function getResonewithid($id) {
        $this->db->select('title');
        $this->db->where('id', $id);
        $data = $this->db->get('xin_employee_move_reason')->row();

        return $data->title;
    }

}

