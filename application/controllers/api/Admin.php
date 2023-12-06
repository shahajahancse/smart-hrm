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
    /**
     * demo method
     *
     * @link [api/user/demo]
     * @method POST
     * @return Response|void
     */
  
    // public function add_leave()
    // {
    //     $authorization = $this->input->get_request_header('Authorization');
    //     $user_info = api_auth($authorization);
    //     dd($user_info);
    //     if ($user_info['status'] == true) {
    //         $user_data=$user_info['user_info'];
    //         $userid=$user_data->user_id;
    //         $d= $this->input->post();
    //         $start_date=$d['start_date'];
    //         $end_date=$d['end_date'];
    //         if (empty($d['leave_type']) || empty($d['start_date']) || empty($d['end_date']) || empty($d['reason'])) {
    //             $this->api_return([
    //                 'status'  =>   false,
    //                 'message'  =>   'Missing required fields',
    //                 'data'     =>   [],
    //             ], 404);
    //             exit();
    //         }
    //         $leave_date = $this->db->select('from_date,to_date')->where('employee_id',$userid)->get('xin_leave_applications')->result();
			
	// 		//check duplicate leave date 
	// 		foreach($leave_date as $date){
	// 			if($date->from_date == $start_date && $date->to_date == $end_date) {
    //                 $this->api_return([
    //                     'status'  =>   false,
    //                     'message'  =>   " Can't applied For This Date, Leave Already Have For This Date",
    //                     'data'     =>   [],
    //                 ], 404);
    //                 exit();
	// 			}
	// 		}
			
	// 		$datetime1 = new DateTime($this->input->post('start_date'));
	// 		$datetime2 = new DateTime($this->input->post('end_date'));
	// 		$interval = $datetime1->diff($datetime2);
	// 		$no_of_days = $interval->format('%a') + 1;

	// 		if($this->input->post('leave_half_day') == 1 && $no_of_days > 1 ) {
    //             $this->api_return([
    //                 'status'  =>   false,
    //                 'message'  =>   "Half Leave Can't applied  more than 1 day",
    //                 'data'     =>   [],
    //             ], 404);
    //             exit();
	// 		}

			
				
	// 		if($this->input->post('start_date')!=''){	
				
	// 			if($this->input->post('leave_half_day') == 1 && $no_of_days == 1 ) {
	// 				$no_of_days = 0.5;
	// 			} 
				
	// 			$total = get_cal_leave($userid, $this->input->post('leave_type'));
					
	// 			if($this->input->post('leave_half_day') != 1){
	// 				if($no_of_days > $total){
    //                     $this->api_return([
    //                         'status'  =>   false,
    //                         'message'  =>   "Half Leave Can't applied  more than 1 day",
    //                         'data'     =>   [],
    //                     ], 404);
    //                     exit();
	// 				}
	// 			} else {
	// 				if(0.5 >  $total){
    //                     $this->api_return([
    //                         'status'  =>   false,
    //                         'message'  =>   "Leave Can't applied  more than ".$total ."day",
    //                         'data'     =>   [],
    //                     ], 404);
    //                     exit();
	// 				}
	// 			}

	// 			if ($this->input->post('leave_type') == 2) {
	// 				$type_name = " Sick leave";
	// 			} else {
	// 				$type_name = " Earn leave";
	// 			}
				
	// 			if($total < 0.4){
	// 				$this->api_return([
    //                     'status'  =>   false,
    //                     'message'  =>   "Leave Can't applied For Leave ",
    //                     'data'     =>   [],
    //                 ], 404);
    //                 exit();
	// 			}
	// 		}

				

	// 		if($this->input->post('leave_half_day') != 1){
	// 			$leave_half_day_opt = 0;
	// 		} else {
	// 			$leave_half_day_opt = $this->input->post('leave_half_day');
	// 		}
			
    //         if ($_POST['attachment']) {
    //             // Get the base64 encoded image string
    //             $base64String = $_POST['attachment'];
    //             // dd($base64String);
    //             // Extract file type from base64 string
    //             preg_match('/^data:image\/(.*);base64,/', $base64String, $output_array);      
    //             // dd($output_array);
    //             $fileExtension = $output_array[1];
    //             // Remove data:image/...;base64, from the beginning of the string
    //             $base64String = preg_replace('/^data:image\/(.*);base64,/', '', $base64String);
    //             // Decode the base64 string
    //             $imageData = base64_decode($base64String);
    //             // Generate a unique filename for the image
    //             $filename = 'image_' . time() . '.' . $fileExtension;
    //             // Specify the path where you want to save the image
    //             $imagePath = FCPATH . 'uploads/leave/' . $filename;
    //             // Save the image to the specified path
    //             file_put_contents($imagePath, $imageData);
    //             $fileLocation = 'uploads/leave/' . $filename;
    //         } else {
    //             $fileLocation = '';
    //         }
            
			
	// 		$data = array(
	// 		'employee_id' => $userid,
	// 		'company_id' => 1,
	// 		'leave_type_id' => $this->input->post('leave_type'),
	// 		'leave_type' => ($this->input->post('leave_type') == 1)? 'el':'sl',
	// 		'from_date' => $this->input->post('start_date'),
	// 		'to_date' => $this->input->post('end_date'),
	// 		'applied_on' => date('Y-m-d h:i:s'),
	// 		'reason' => $this->input->post('reason'),
	// 		'qty' => $no_of_days,
	// 		'leave_attachment' => $fileLocation,
	// 		'status' => '1',
	// 		'notify_leave' => '1',
	// 		'is_half_day' => $leave_half_day_opt,
	// 		'created_at' => date('Y-m-d h:i:s'),
	// 		'current_year' => date('Y'),
	// 		);
	// 		$result = $this->Timesheet_model->add_leave_record($data);
    //         if ($result==true) {
    //             $this->api_return([
    //                 'status'    =>  true,
    //                 'message'    =>  'successful',
    //                 'data'       =>  [],
    //             ], 200);
    //         }else{
    //             $this->api_return([
    //                 'status'  =>   false,
    //                 'message'  =>   'Unsuccessful',
    //                 'data'     =>   [],
    //             ], 404);
    //         }
    //     } else {
    //         $this->api_return([
    //             'status' => false,
    //             'message' => 'Unauthorized User',
    //             'data' => [],
    //         ], 401);
    //     }
    // }
    public function leave_list()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
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
    }
    public function single_leave_status()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
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
    }
    public function single_leave_status_change()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
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
    }
}
