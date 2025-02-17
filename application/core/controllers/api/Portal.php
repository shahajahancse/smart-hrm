<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Portal extends REST_Controller {

   function __construct(){
      // Construct the parent class
      parent::__construct();
      $this->lang->load('auth');

      $this->load->model('Common_model');
      $this->load->model('Api_model');
   }

   public function service_request_post(){
      $this->form_validation->set_rules('service_id', 'service name', 'required|trim');
      $this->form_validation->set_rules('region_id', 'Region', 'trim');
      $this->form_validation->set_rules('problem_details', 'Problem details', 'required|trim');
      $this->form_validation->set_rules('name', 'Name', 'required|trim');
      $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
      $this->form_validation->set_rules('email', 'Email', 'trim');        
      $this->form_validation->set_rules('address', 'Address', 'required|trim');

      if ($this->form_validation->run() == true){
         $form_data = array(
            'service_id'        => $this->input->post('service_id'),
            'request_to'        => $this->input->post('request_to'),
            'serv_region_id'    => $this->input->post('region_id'),
            'serv_problem'      => $this->input->post('problem_details'),
            'name'              => $this->input->post('name'),
            'phone'             => $this->input->post('mobile'),
            'email'             => $this->input->post('email'),
            'address'           => $this->input->post('address'),
            'status'            => 2,
            'created'           => date('Y-m-d H:i:s')
            );

         // print_r($form_data); exit;

         if($this->Common_model->save('service_request', $form_data)){
            $this->response(array('status'=> 'true', 'result'  => 'Service request sent successfully.'), REST_Controller::HTTP_OK);            
         }else{
            $this->response(['status' => 'false', 'result' => 'Something is wrong.'], REST_Controller::HTTP_OK);
         }
      }else{
         $message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
         $this->response(['status' => 'false', 'result' => $message], REST_Controller::HTTP_OK);
      }
   }


   public function service_info_get(){
      $id = $this->get('id'); 

      $results = $this->Api_model->get_service_info($id);        
      $restarray[]=$results;

      if($results){
         $this->response(array('status'=> 'success', 'result'  => $restarray), REST_Controller::HTTP_OK); 
      }else{
         $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
      }
   }

   public function blood_group_search_get(){
      $division = $this->get('division');
      $district = $this->get('district');
      $upazila = $this->get('upazila');
      $blood_group = $this->get('blood_group');

      $results = $this->Api_model->search_blood_donate($blood_group, $division, $district, $upazila);

      if($results){
         $this->response(array('status'=> 'success', 'result'  => $results), REST_Controller::HTTP_OK); 
      }else{
         $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
      }
   }

}
