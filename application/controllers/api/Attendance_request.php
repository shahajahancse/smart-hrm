<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Attendance_request extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api_helper');
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
            $from_date=date('Y-m-d 00:00:00',strtotime($this->input->post('from_date')));//$$this->input->post('from_date');
            $to_date=date('Y-m-d 23:59:59',strtotime($this->input->post('to_date')));//$this->input->post('to_date');
            $userid=$user_data->user_id;
            $data['attendance_request']=$this->db->select("ca.*,xe.first_name,xe.last_name")
                                        ->from("attendance_request ca")
                                        ->join('xin_employees xe', 'ca.emp_id = xe.user_id')
                                        ->where("ca.emp_id", $userid)
                                        ->where("ca.time BETWEEN '$from_date' AND '$to_date'")
                                        ->order_by('ca.id', 'desc')
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
                'message'  =>   'Unauthorized User',
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
            $this->load->library('form_validation');
            $this->form_validation->set_rules('type', 'Type', 'trim|required');
            $this->form_validation->set_rules('division', 'Division', 'trim|required');
            $this->form_validation->set_rules('district', 'District', 'trim|required');
            $this->form_validation->set_rules('upazila', 'Upazila', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('location_latitude', 'Location Latitude', 'trim|required');
            $this->form_validation->set_rules('location_longitude', 'Location Longitude', 'trim|required');
            $this->form_validation->set_rules('remarks', 'Remarks', 'trim|required');
            $this->form_validation->set_rules('live_image', 'Live Image', 'required');
            if ($this->form_validation->run() == true) {
                $emp_id = $userid;
                $type = $this->input->post('type');
                $division = $this->input->post('division');
                $district = $this->input->post('district');
                $upazila = $this->input->post('upazila');
                $address = $this->input->post('address');
                $location_latitude = $this->input->post('location_latitude');
                $location_longitude = $this->input->post('location_longitude');
                $remarks = $this->input->post('remarks');
                $time = date('Y-m-d H:i:s');
                if ($_POST['live_image']) {
                    $base64String = $_POST['live_image'];
                    preg_match('/^data:image\/(.*);base64,/', $base64String, $output_array);      
                    if(isset($output_array[1])){
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
                    }else{
                        $this->api_return([
                            'status'  =>   false,
                            'message'  =>   'Image Problem Found',
                            'data'     =>   [],
                        ], 404);
                    }
                } else {
                    $this->api_return([
                        'status'  =>   false,
                        'message'  =>   'Image not found',
                        'data'     =>   [],
                    ], 404);
                }
                $data = array(
                    'emp_id' => $emp_id,
                    'type' => $type,
                    'division' => $division,
                    'district' => $district,
                    'upazila' => $upazila,
                    'address' => $address,
                    'location_latitude' => $location_latitude,
                    'location_longitude' => $location_longitude,
                    'live_image' => $live_image,
                    'remarks' => $remarks,
                    'time' => $time,
                );
                $insert=$this->db->insert('attendance_request', $data);
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
                    'message'  =>   validation_errors(),
                    'data'     =>   [],
                ], 404);
            }
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
                'data'     =>   [],
            ], 404);
        }
    }
    public function get_division()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {

            $emp_divisions=$this->db->select('*')->from('emp_divisions')->get()->result();
            $data['emp_divisions']=$emp_divisions;


            $this->api_return([
                'status'    =>  true,
                'message'    =>  'successful',
                'data'       =>  $data,
            ], 200);
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
                'data'     =>   [],
            ], 404);
        }
    }
    public function get_district()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {

            $emp_districts=$this->db->select('*')
                            ->from('emp_districts')
                            ->where('div_id', $this->input->post('division_id'))
                            ->get()->result();
            $data['emp_districts']=$emp_districts;






            $this->api_return([
                'status'    =>  true,
                'message'    =>  'successful',
                'data'       =>  $data,
            ], 200);

        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
                'data'     =>   [],
            ], 404);
        }
    }
    public function get_upazila()
    {
        $authorization = $this->input->get_request_header('Authorization');
        $user_info = api_auth($authorization);
        if ($user_info['status'] == true) {

            $emp_upazilas=$this->db->select('*')
            ->from('emp_upazilas')
            ->where('dis_id', $this->input->post('district_id'))
            ->where('div_id', $this->input->post('division_id'))
            ->get()->result();

            $data['emp_upazilas']=$emp_upazilas;
            $this->api_return([
                'status'    =>  true,
                'message'    =>  'successful',
                'data'       =>  $data,
            ], 200);
        } else {
            $this->api_return([
                'status'  =>   false,
                'message'  =>   'Unauthorized User',
                'data'     =>   [],
            ], 404);
        }
    }
   
}
