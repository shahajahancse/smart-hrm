<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Client_attendance extends API_Controller
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
    
    public function index()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];                 
            $userid=$user_data->user_id;
            $data['client_attendance']=$this->db->select("ca.*,xe.first_name,xe.last_name")
                                        ->from("client_attendance ca")
                                        ->join('xin_employees xe', 'ca.emp_id = xe.user_id')
                                        ->where("ca.emp_id", $userid)
                                        ->get()
                                        ->result();
            $this->api_return([
                'status'    =>  true,
                'message'    =>  'successful',
                'data'       =>  $data,
            ], 200);
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unsuccessful',
                'data'     =>   [],
            ], 404);
        }
    }
    public function add()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {
            $user_data=$user_info['user_info'];                 
            $userid=$user_data->user_id;

            $emp_id = $userid;
            $client_name = $this->input->post('client_name');
            $type = $this->input->post('type');
            $representative_name = $this->input->post('representative_name');
            $mobile = $this->input->post('mobile');
            $email = $this->input->post('email');
            $designation = $this->input->post('designation');
            $division = $this->input->post('division');
            $district = $this->input->post('district');
            $upazila = $this->input->post('upazila');
            $address = $this->input->post('address');
            $location_latitude = $this->input->post('location_latitude');
            $location_longitude = $this->input->post('location_longitude');
            $remarks = $this->input->post('remarks');
            $date = date('Y-m-d');
            
            if ($_POST['live_image']) {
                $base64String = $_POST['live_image'];
                preg_match('/^data:image\/(.*);base64,/', $base64String, $output_array);      
                $fileExtension = $output_array[1];
                $base64String = preg_replace('/^data:image\/(.*);base64,/', '', $base64String);
                $imageData = base64_decode($base64String);
                $filename = 'live_image_' . time() . '.' . $fileExtension;
                $imagePath = FCPATH . 'uploads/live_image/' . $filename;
                if (!is_dir(FCPATH . 'uploads/live_image/')) {
                    mkdir(FCPATH . 'uploads/live_image/', 0777, true);
                }
                file_put_contents($imagePath, $imageData);
                $live_image = 'uploads/live_image/' . $filename;
            } else {
                $live_image = '';
            }
            $data = array(
                'emp_id' => $emp_id,
                'client_name' => $client_name,
                'type' => $type,
                'representative_name' => $representative_name,
                'mobile' => $mobile,
                'email' => $email,
                'designation' => $designation,
                'division' => $division,
                'district' => $district,
                'upazila' => $upazila,
                'address' => $address,
                'location_latitude' => $location_latitude,
                'location_longitude' => $location_longitude,
                'live_image' => $live_image,
                'remarks' => $remarks,
                'date' => $date,
            );
            $insert=$this->db->insert('client_attendance', $data);
            if ($insert) {
                $this->api_return([
                    'status'    =>  true,
                    'message'    =>  'successful',
                    'data'       =>  $data,
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
   
}
