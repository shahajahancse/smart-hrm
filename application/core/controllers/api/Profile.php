<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Profile extends REST_Controller {

    function __construct(){
        parent::__construct();
        $this->lang->load('auth');
        $this->load->model('Api_model');
        $this->load->model('Common_model');
        
        $this->load->model('my_profile/My_profile_model');
        $this->load->model('events/Event_model');
        $this->load->model('training/Training_model');
    }

    public function user_training_get(){
        $id = $this->get('id');
        $results = $this->Api_model->get_my_training($id);

        // $results_arr[] = $results;

        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function upcomming_training_get(){
        $id=$this->get('id');
        $results = $this->Api_model->upcomming_training($id);

        // $results_arr[] = $results;

        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function training_details_get(){
        $training_id = $this->get('training_id');
        $results= $this->Api_model->get_training_info($training_id);

         $results_arr[] = $results;

        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results_arr), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    function training_status_post() {

        $scout_id       = $this->post('scout_id');
        $training_id    = $this->post('training_id');
        $status         = $this->post('status');
        if($status==1){
            $status_data='Interested';
        }
        if($status==2){
            $status_data='Not Interested';
        }
        
        $form_data = array(
            'status'       => $status_data,
        );

        $form_data2 = array(
            'scout_id'      => $scout_id,
            'training_id'   => $training_id,
            'status'        => $status_data
        );

        if(empty($this->Api_model->get_training_member($training_id, $scout_id))){

            if($this->Common_model->save('training_to_scouts', $form_data2)){
                $this->response(['status' => 'true', 'result' => 'Information update successfully'], REST_Controller::HTTP_OK); 
            }else{
                $this->response(['status' => 'false', 'result' => 'Information update unsuccessfully'], REST_Controller::HTTP_OK);
            }
        }else{
            if($this->Common_model->edit('training_to_scouts', $scout_id, $training_id, $form_data)){
                $this->response(['status' => 'true', 'result' => 'Information update successfully'], REST_Controller::HTTP_OK);
            }else{
                $this->response(['status' => 'false', 'result' => 'Information update unsuccessfully'], REST_Controller::HTTP_OK);
            }
        }
    }

    public function user_events_get(){
        $id = $this->get('id');
        $results = $this->Api_model->get_my_events($id);

        // $results_arr[] = $results;

        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function upcomming_events_get(){
        $id=$this->get('id');
        $results = $this->Api_model->upcomming_event($id);

        // $results_arr[] = $results;

        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function events_details_get(){
        $event_id = $this->get('event_id');
        $results= $this->Api_model->get_events_info($event_id);

         $results_arr[] = $results;

        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results_arr), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    function events_status_post() {

        $scout_id = $this->post('scout_id');
        $event_id = $this->post('event_id');
        $status   = $this->post('status');

        if($status==1){
            $status_data='Interested';
        }
        if($status==2){
            $status_data='Not Interested';
        }
        
        $form_data = array(
            'status'       => $status_data,
        );

        $form_data2 = array(
            'scout_id'     => $scout_id,
            'event_id'     => $event_id,
            'status'       => $status_data
        );

        if(empty($this->Api_model->get_scout_member($event_id, $scout_id))){

            if($this->Common_model->save('event_to_scouts', $form_data2)){
                $this->response(['status' => 'true', 'result' => 'Information update successfully'], REST_Controller::HTTP_OK); 
            }else{
                $this->response(['status' => 'false', 'result' => 'Information update unsuccessfully'], REST_Controller::HTTP_OK);
            }
        }else{
            if($this->Event_model->edit('event_to_scouts', $scout_id, $event_id, $form_data)){
                $this->response(['status' => 'true', 'result' => 'Information update successfully'], REST_Controller::HTTP_OK);
            }else{
                $this->response(['status' => 'false', 'result' => 'Information update unsuccessfully'], REST_Controller::HTTP_OK);
            }
        }
    }


    public function online_application_post(){
        $this->form_validation->set_rules('user_id', 'session user id', 'required|trim');
        $this->form_validation->set_rules('first_name', 'full name', 'required|trim');
        // $this->form_validation->set_rules('day', 'day', 'required|trim');
        // $this->form_validation->set_rules('month', 'month', 'required|trim');
        // $this->form_validation->set_rules('year', 'year', 'required|trim');
        // $dob = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day');
        $dob = $this->input->post('dob');
        // echo 'success';
        // print_r($this->input->post());
        if ($this->form_validation->run() == true){
            $form_data = array(
                'is_request'        => '1',
                'first_name'        => $this->input->post('first_name'),
                'full_name_bn'      => $this->input->post('full_name_bn'),
                'father_name'       => $this->input->post('father_name'),
                'father_name_bn'    => $this->input->post('father_name_bn'),
                'mother_name'       => $this->input->post('mother_name'),
                'mother_name_bn'    => $this->input->post('mother_name_bn'),
                'dob'               => date_db_format($dob),
                'gender'            => $this->input->post('gender'),
                'blood_group'       => $this->input->post('blood_group'),
                'phone'             => $this->input->post('phone'),            
                'email'             => $this->input->post('email'),
                'religion_id'       => $this->input->post('religion_id'),

                'pre_village_house' => $this->input->post('pre_village_house'),
                'pre_village_house_bn' => $this->input->post('pre_village_house_bn'),
                'pre_road_block'    => $this->input->post('pre_road_block'),
                'pre_road_block_bn' => $this->input->post('pre_road_block_bn'),
                'pre_division_id'   => $this->input->post('pre_division_id'),
                'pre_district_id'   => $this->input->post('pre_district_id'),
                'pre_upa_tha_id'    => $this->input->post('pre_upa_tha_id'),
                'pre_post_office'   => $this->input->post('pre_post_office'),                                
                
                'is_interested'     => $this->input->post('is_interested'),
                'sc_cub'            => $this->input->post('sc_cub'),
                'sc_scout'          => $this->input->post('sc_scout'),
                'sc_rover'          => $this->input->post('sc_rover'),
                'curr_institute_id' => $this->input->post('curr_institute_id'),
                'curr_class'        => $this->input->post('curr_class'),
                'curr_role_no'      => $this->input->post('curr_role_no'),
                'curr_org'          => $this->input->post('curr_org'),
                'curr_desig'        => $this->input->post('curr_desig'),
                'join_date'         => date_db_format($this->input->post('join_date')),
                'member_id'         => $this->input->post('member_id'),
                'sc_section_id'     => $this->input->post('sc_section_id'),
                'sc_badge_id'       => $this->input->post('sc_badge_id'),
                'sc_role_id'        => $this->input->post('sc_role_id'),             
                'sc_region_id'      => $this->input->post('sc_region_id'),
                'sc_district_id'    => $this->input->post('sc_district_id'),
                'sc_upa_tha_id'     => $this->input->post('sc_upa_tha_id'),
                'sc_group_id'       => $this->input->post('sc_group_id'),
                'sc_unit_id'        => $this->input->post('sc_unit_id')     
                );

                // echo '<pre>';
                // print_r($this->input->post('user_id'));
                // print_r($form_data); exit;

            if($this->Common_model->edit('users', $this->input->post('user_id'), 'id', $form_data)){
                $this->response(array('status'=> 'true', 'result'  => 'Online scouts application submit successfully.'), REST_Controller::HTTP_OK);            
            }else{
                $this->response(['status' => 'false', 'result' => 'Something is wrong.'], REST_Controller::HTTP_OK);
            }
        }else{
            $message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->response(['status' => 'false', 'result' => $message], REST_Controller::HTTP_OK);
        }
    }


    public function scout_request_application_basic_post(){
        $this->form_validation->set_rules('user_id', 'session user id', 'required|trim');
        $this->form_validation->set_rules('first_name', 'full name', 'required|trim');
        // $this->form_validation->set_rules('day', 'day', 'required|trim');
        // $this->form_validation->set_rules('month', 'month', 'required|trim');
        // $this->form_validation->set_rules('year', 'year', 'required|trim');
        // $dob = $this->input->post('year').'-'.$this->input->post('month').'-'.$this->input->post('day');
        $dob = $this->input->post('dob');
        // echo 'success';
        // print_r($this->input->post());
        if ($this->form_validation->run() == true){
            $form_data = array(
                'first_name'        => $this->input->post('first_name'),
                'full_name_bn'      => $this->input->post('full_name_bn'),
                'father_name'       => $this->input->post('father_name'),
                'father_name_bn'    => $this->input->post('father_name_bn'),
                'mother_name'       => $this->input->post('mother_name'),
                'mother_name_bn'    => $this->input->post('mother_name_bn'),
                'dob'               => date_db_format($dob),
                'gender'            => $this->input->post('gender'),
                'blood_group'       => $this->input->post('blood_group'),
                'phone'             => $this->input->post('phone'),            
                'email'             => $this->input->post('email'),
                'religion_id'       => $this->input->post('religion_id'),

                'pre_village_house' => $this->input->post('pre_village_house'),
                'pre_village_house_bn' => $this->input->post('pre_village_house_bn'),
                'pre_road_block'    => $this->input->post('pre_road_block'),
                'pre_road_block_bn' => $this->input->post('pre_road_block_bn'),
                'pre_division_id'   => $this->input->post('pre_division_id'),
                'pre_district_id'   => $this->input->post('pre_district_id'),
                'pre_upa_tha_id'    => $this->input->post('pre_upa_tha_id'),
                'pre_post_office'   => $this->input->post('pre_post_office'), 

                'per_village_house' => $this->input->post('per_village_house'),
                'per_road_block'    => $this->input->post('per_road_block'),
                'per_division_id'   => $this->input->post('per_division_id'),
                'per_district_id'   => $this->input->post('per_district_id'),
                'per_upa_tha_id'    => $this->input->post('per_upa_tha_id'),
                'per_post_office'   => $this->input->post('per_post_office')
                );


                // echo '<pre>';
                // print_r($this->input->post('user_id'));
                // print_r($form_data); exit;

            if($this->Common_model->edit('users', $this->input->post('user_id'), 'id', $form_data)){
                $this->response(array('status'=> 'true', 'result'  => 'Basic information save successfully.'), REST_Controller::HTTP_OK);            
            }else{
                $this->response(['status' => 'false', 'result' => 'Something is wrong.'], REST_Controller::HTTP_OK);
            }
        }else{
            $message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->response(['status' => 'false', 'result' => $message], REST_Controller::HTTP_OK);
        }
    }

    public function scout_request_application_scout_info_post(){
        $this->form_validation->set_rules('user_id', 'session user id', 'required|trim');

        // echo 'success';
        // print_r($this->input->post()); 'sc_badge_id' => $this->input->post('sc_badge_id') 
        if ($this->form_validation->run() == true){
            $form_data = array(
                'is_request' => '1',
                'curr_institute_id' => $this->input->post('curr_institute_id'),
                'curr_class'        => $this->input->post('curr_class'),
                'curr_role_no'      => $this->input->post('curr_role_no'),
                'join_date'         => $this->input->post('join_date'),
                'member_id'         => $this->input->post('member_id'),
                'sc_cub'            => $this->input->post('sc_cub'),
                'sc_scout'          => $this->input->post('sc_scout'),
                'sc_rover'          => $this->input->post('sc_rover'),
                'sc_req_section_id' => $this->input->post('sc_req_section_id'),
                'sc_section_id'     => $this->input->post('sc_section_id'),
                'sc_badge_id'       => $this->input->post('sc_badge_id'),
                'sc_role_id'        => $this->input->post('sc_role_id'),             
                'sc_region_id'      => $this->input->post('sc_region_id'),
                'sc_district_id'    => $this->input->post('sc_district_id'),
                'sc_upa_tha_id'     => $this->input->post('sc_upa_tha_id'),
                'sc_group_id'       => $this->input->post('sc_group_id'),
                'sc_unit_id'        => $this->input->post('sc_unit_id')
                );

                // echo '<pre>';
                // print_r($this->input->post('user_id'));
                // print_r($form_data); exit;

            if($this->Common_model->edit('users', $this->input->post('user_id'), 'id', $form_data)){
                $this->response(array('status'=> 'true', 'result'  => 'Scout info request sent successfully.'), REST_Controller::HTTP_OK);            
            }else{
                $this->response(['status' => 'false', 'result' => 'Something is wrong.'], REST_Controller::HTTP_OK);
            }
        }else{
            $message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->response(['status' => 'false', 'result' => $message], REST_Controller::HTTP_OK);
        }
    }

    public function award_list_get(){
        $id = $this->get('scout_id');
        $results = $this->Api_model->get_my_award($id);

        // $results_arr[] = $results;

        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function blood_donate_update_post(){
        $this->form_validation->set_rules('user_id', 'session user id', 'required|trim');

        if ($this->form_validation->run() == true){
            $form_data = array(
                'last_donate_date'         => $this->input->post('last_donate_date'),                
                'blood_donate_interested'  => $this->input->post('blood_donate_interested')
                );

                // echo '<pre>';
                // print_r($this->input->post('user_id'));
                // print_r($form_data); exit;

            if($this->Common_model->edit('users', $this->input->post('user_id'), 'id', $form_data)){
                $this->response(array('status'=> 'true', 'result'  => 'Blood donate information update successfully.'), REST_Controller::HTTP_OK);            
            }else{
                $this->response(['status' => 'false', 'result' => 'Something is wrong.'], REST_Controller::HTTP_OK);
            }
        }else{
            $message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->response(['status' => 'false', 'result' => $message], REST_Controller::HTTP_OK);
        }
    }
}
