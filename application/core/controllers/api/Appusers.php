<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include 'classes/SMSClient.php';

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

class Appusers extends REST_Controller {
    var $smsUser;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->lang->load('auth');

        $this->load->model('my_profile/My_profile_model');
		$this->load->model('Common_model');

        $this->smsUser = new SMSClient('1587652994', '^Rl:_w=[', 'http://www.sms4bd.net');
        $this->load->helper('string');
    }

    public function user_details_get(){
        $id = $this->get('id');
        $results = $this->My_profile_model->get_info($id);

        $results_arr[] = $results;

        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results_arr), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }
	
	public function institute_get()
	{
		$terms=$this->input->get('term');
		$curdt=$this->My_profile_model->get_institute($terms);
		$this->response($curdt, REST_Controller::HTTP_OK); 
	}
    
	public function scoutlist_get()
	{
		$terms=$this->input->get('term');
		$terms='a';
		$curdt=$this->My_profile_model->get_scoutlist($terms);
		$this->response($curdt, REST_Controller::HTTP_OK); 
	}
	
    public function blood_group_search_get(){
        $division = $this->get('division');
        $district = $this->get('district');
        $upazila = $this->get('upazila');
        $blood_group = $this->get('blood_group');

        $results = $this->Common_model->search_blood_donate($division, $district, $upazila, $blood_group);

        $results_arr[] = $results;

        if($results){
           $this->response(array('status'=> 'success', 'result'  => $results_arr), REST_Controller::HTTP_OK); 
        }else{
            $this->response(['status' => 'false', 'result' => 'No data found'], REST_Controller::HTTP_OK);
        }
    }

    public function login_post(){
        if (empty($this->input->post('identity'))) {   
            $this->response(array('status' => 'false', 'result'  =>'Required Username or Email or Scout ID'));
        }
        
        if (empty($this->input->post('password'))) { 
            $this->response(array('status' => 'false', 'result'  =>'Required Password'));
        }

        // login_apps
        if ($user=$this->ion_auth->login_apps($this->input->post('identity'), $this->input->post('password'), 1)){
            
            // print_r($user); exit;
            // Get User Groups
            $users_groups = $this->ion_auth->get_users_groups($user->id)->result();
            $groups_array = array();
            foreach ($users_groups as $group){
                // $groups_array[$group->id] = $group->description;
                $groups_array['group_id'] = $group->id;
            }

            // echo $groups_array; exit;
            // print_r($result); exit;
            // $result = array('login_info' => $user, 'group_info' => $groups_array);            

            $user = (array) $user;
            $user['group_id'] = $groups_array['group_id'];
            $user['is_request'] = $user['is_request'];
            $result = $user;

            $this->response(array('status'=> 'true', 'result'  => $result), REST_Controller::HTTP_OK);
        }else{
            $this->response(['status' => 'false', 'result' => 'Your login credential is wrong.'], REST_Controller::HTTP_OK);
        }
        // $this->set_response($message, REST_Controller::HTTP_CREATED);
    }

   
    public function change_password_post(){
      $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
      $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
      $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

      // $user = $this->ion_auth->user()->row();
      // print_r($this->input->post()); exit;
      $message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      if ($this->form_validation->run() == true){
         $identity = $this->input->post('identity');

         $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

         if ($change){
            //if the password was successfully changed
            // $this->session->set_flashdata('success', $this->ion_auth->messages());
            $this->response(array('status'=> 'true', 'result'  => 'Password change successfully.'), REST_Controller::HTTP_OK);
            // $this->logout();
         } else {
            // $this->session->set_flashdata('success', $this->ion_auth->errors());        
            $this->response(['status' => 'false', 'result' => 'Your old password is wrong.'], REST_Controller::HTTP_OK);
        }

      }else {
        // $this->session->set_flashdata('success', $this->ion_auth->errors());
        $message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->response(['status' => 'false', 'result' => $message], REST_Controller::HTTP_OK);
        // redirect('my_profile');
     }
      // display the form
      // set the flash data error message if there is one

      // $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
      
   }

	
	public function receive_profile_img_post()
	{
		 if (!empty($this->input->post('image'))) { 
			$profile_id=$this->input->post('image_name');
			$dt=array('profile_img'=>$profile_id.'.jpg');
			
			$realpath=$this->img_path = realpath(APPPATH . '../profile_img/');

			//echo $realpath.$dt['profile_img'];exit;
            $ifp = fopen($realpath.'/'.$dt['profile_img'], "wb" ); 
			fwrite( $ifp, base64_decode($this->input->post('image')) ); 
			fclose( $ifp ); 
			
			$this->Common_model->edit('users', $profile_id, 'id', $dt);
			
			$this->response(array('status'=> 'true', 'result'  => 'yes'), REST_Controller::HTTP_OK);
        }
		else
			$this->response(array('status'=> 'true', 'result'  => 'no'), REST_Controller::HTTP_OK);
	}
	
    public function registration_post(){
        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('full_name', 'full name', 'required');
        if($identity_column!=='email'){
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required|is_unique['.$tables['users'].'.'.$identity_column.']', array(
                'required'      => 'Email or username field is required.',
                'is_unique'     => 'This email or username already exists! Try another.'));
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'valid_email');
        }else{
            $this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }

        $this->form_validation->set_rules('dob', 'date of birth', 'trim');
        $this->form_validation->set_rules('gender', 'gender', 'trim');
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
        
        //$this->form_validation->set_message('rule', 'Error Message');

        if ($this->form_validation->run() == true){
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name'    => $this->input->post('full_name'),
                'dob'           => $this->input->post('dob'),
                'gender'        => $this->input->post('gender'),
                'phone'         => $this->input->post('phone')
                );
        }
        
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data)){
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            $this->response(array('status'=> 'true', 'result'  => 'Registration successfully.'), REST_Controller::HTTP_OK);
            // redirect("login");
        }else{
            // display the create user form
            // set the flash data error message if there is one
            $message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            // print_r($this->data['district']); exit;

            $this->response(['status' => 'false', 'result' => $message], REST_Controller::HTTP_OK);
        }
    }

    public function forgot_password_post(){

        if($this->config->item('identity', 'ion_auth') != 'email'){
           $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        }else{
           $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }

        $message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        if ($this->form_validation->run() == true){
            // $identity_column = $this->config->item('identity','ion_auth');
            $identity=$this->input->post('identity');
            $where="username='$identity' OR scout_id='$identity'";
            $userinfo = $this->ion_auth->where($where)->users()->row();
            

            if(!empty($userinfo->phone)){
                
                $phone ='+88'.$userinfo->phone;
                $code  = random_string('numeric', 6);
                $message='Your Verify Code: '.$code .' (Bangladesh Scouts)';

                $response = $this->smsUser->SendSMS("softheaven", $phone, $message, date('Y-m-d H:i:s'), SMSType::UCS2);
                $result = $response->StatusMessage;  

                if($result = 'Accepted'){
                        $newdata = array(
                           'forget_id'  => $userinfo->id,
                           'verify_code' => $code 
                        );
                        $form_data = array(
                           'verify_code' => $code 
                        );

                        $this->session->set_userdata($newdata);
                        $this->Common_model->edit('users', $userinfo->id, 'id', $form_data);
                        
                        $this->response(array('status'=> 'true', 'identity'  => $identity, 'verifycode' => $code, 'result'  => 'SMS send successfully.'), REST_Controller::HTTP_OK);
                }else{
                    $this->response(array('status'=> 'false', 'result'  => 'Sorry: SMS Not Send.'), REST_Controller::HTTP_OK);
                }

            }else{
                if($this->config->item('identity', 'ion_auth') != 'email'){
                    $this->response(array('status'=> 'false', 'result'  => 'forgot_password_identity_not_found.'), REST_Controller::HTTP_OK);
                }else{
                   $this->response(array('status'=> 'false', 'result'  => 'forgot_password_email_not_found.'), REST_Controller::HTTP_OK);
                }
            }
        }else {
            // $this->session->set_flashdata('success', $this->ion_auth->errors());
            $message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->response(['status' => 'false', 'result' => $message], REST_Controller::HTTP_OK);
            // redirect('my_profile');
         }
    }

    public function verifycode_to_change_password_post(){
        $this->form_validation->set_rules('identity', 'Identity', 'trim|required');
        $this->form_validation->set_rules('verify_code', 'Varify Code', 'trim|required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');
        
        $message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        if ($this->form_validation->run() == true){

            $identity=$this->input->post('identity');
            $where="username='$identity' OR scout_id='$identity'";
            $userinfo = $this->ion_auth->where($where)->users()->row();
            if(!empty($userinfo)){
                $forget_id      = $userinfo->id;
                $verify_code    = $this->session->userdata('verify_code');

                if($userinfo->verify_code==$this->input->post('verify_code')){
                    if($this->input->post('new')==$this->input->post('new_confirm')){
                        $change = $this->ion_auth->forget_change_password($forget_id, $this->input->post('new'));

                        if ($change){
                            
                            $this->response(array('status'=> 'true', 'result'  => 'Password change successfully.'), REST_Controller::HTTP_OK);
                        } else {
                            $this->response(array('status'=> 'false', 'result'  => $this->ion_auth->errors()), REST_Controller::HTTP_OK);
                        }
                    }else{
                        $this->response(array('status'=> 'false', 'result'  => 'Confirm password no match.'), REST_Controller::HTTP_OK);
                    }
                }else{
                    $this->response(array('status'=> 'false', 'result'  => 'Verification code no match.'), REST_Controller::HTTP_OK);
                }
            }else{
                $this->response(array('status'=> 'false', 'result'  => 'Your identity not found.'), REST_Controller::HTTP_OK);
            }
        
            
        }else {
            // $this->session->set_flashdata('success', $this->ion_auth->errors());
            $message = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->response(['status' => 'false', 'result' => $message], REST_Controller::HTTP_OK);
            // redirect('my_profile');
         }
    }

}
