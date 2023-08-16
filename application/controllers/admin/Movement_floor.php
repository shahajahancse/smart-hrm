
<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Movement_floor extends MY_Controller {

	 public function __construct() {
        parent::__construct();
        $session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		//load the model
		// $this->load->model("Project_model");
		// $this->load->model("Location_model");
	}

	public function outformsub()
    {
    $session = $this->session->userdata('username');
    $user_id = $session['user_id'];
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
        if ($selectedOption === 'other') {
            $reasondata = $this->input->post('otherInput');
            $data = array(
                'title' => $reasondata
            );

            $this->db->insert('xin_employee_move_reason', $data);
            $insert_id = $this->db->insert_id();
            $reason=$insert_id;
        }

            $this->db->select('floor_status');
            $this->db->where('user_id', $user_id);
            $empinfo=$this->db->get('xin_employees')->row();

            if($empinfo->floor_status==5) {
                $input_location=3;
            } else {
                $input_location=5;
            }
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
            echo "success";
        } else {
            echo "unable to insert";
        };

    } else {
      

            $selectedOption = $this->input->post('reason');
            $reason=$selectedOption;
            if ($selectedOption === 'other') {
                $reasondata = $this->input->post('otherInput');
                $data = array(
                    'title' => $reasondata
                );

                $this->db->insert('xin_employee_move_reason', $data);
                $insert_id = $this->db->insert_id();
                $reason=$insert_id;
            }

            $input_location=$this->input->post('area');
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
            $user_id=$session['user_id'];

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
                echo "success";
            } else {
                echo "unable to insert";
            };

        }


    
}

	public function informsub()
    {
        $session = $this->session->userdata('username');
		$user_id = $session['user_id'];
        $current_date=date('Y-m-d');
       
        $this->db->select("*");
        $this->db->where("user_id", $user_id);
        $this->db->where("date", $current_date);
        $this->db->limit("1");
        $user_movement = $this->db->get('xin_employee_floor_move')->result();

        $in_time_array=json_decode($user_movement[0]->in_time);
        $currentDateTime = date('H:i:s'); 
        array_push($in_time_array,$currentDateTime);
        $in_time=json_encode($in_time_array);
        $movementid=$user_movement[0]->id;
        $data = array(
            'in_time' => $in_time,
            'inout' => 0,
        );
         $this->db->where('id', $movementid);
            $this->db->update('xin_employee_floor_move', $data);
            redirect('admin/attendance/employee_movement');

        }
        
			  
    }

	
