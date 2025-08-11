<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['form', 'url', 'html']);
        $this->load->database();
        $this->load->model("Vehicle_model");
        $this->load->model("Xin_model"); // for common functions like employees

        if(!$this->session->userdata('username')) {
            redirect('admin/');
        }
    }

    public function index() {
        $data['title'] = 'Vehicles | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Vehicles';
        $data['all_employees'] = $this->Xin_model->all_employees();
        $data['vehicles'] = $this->Vehicle_model->get_all_vehicles();
        $data['path_url'] = 'vehicles';
        $data['subview'] = $this->load->view("admin/vehicle/vehicle_list", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data);
    }

    public function add() {
        $this->form_validation->set_rules('name', 'Vehicle Name', 'required');
        $this->form_validation->set_rules('model', 'Model', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Vehicles | '.$this->Xin_model->site_title();
            $data['breadcrumbs'] = 'Vehicles Add';
            $data['all_employees'] = $this->Xin_model->all_employees();
            $data['vehicles'] = $this->Vehicle_model->get_all_vehicles();
            $data['path_url'] = 'vehicles';
            $data['subview'] = $this->load->view("admin/vehicle/add_form", $data, TRUE);
            $this->load->view('admin/layout/layout_main', $data);
        }else {
            
        $data = [
            'name' => $this->input->post('name'),
            'model' => $this->input->post('model'),
            'tax_paid' => $this->input->post('tax_paid'),
            'tax_paid_date' => $this->input->post('tax_paid_date'),
            'end_date' => $this->input->post('end_date'),
            'fitness_description' => $this->input->post('fitness_description'),
            'image' => $this->upload_image(), // file upload helper
            'driver_id' => $this->input->post('driver_id')
        ];

        $result = $this->Vehicle_model->insert_vehicle($data);
        if ($result) {
            $this->session->set_flashdata('success', 'Vehicle added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to add vehicle.');
        }
        redirect('admin/vehicle');
        }

    }

    public function edit($id) {
        $data['title'] = 'Vehicles Edit | '.$this->Xin_model->site_title();
        $data['breadcrumbs'] = 'Vehicles Edit';
        $data['all_employees'] = $this->Xin_model->all_employees();
        $data['vehicle'] = $this->Vehicle_model->get_vehicle_by_id($id);
        $data['path_url'] = 'vehicles';
        $data['subview'] =  $this->load->view('admin/vehicle/edit', $data , TRUE);
        $this->load->view('admin/layout/layout_main', $data);
    }

    public function update($id) {
        $data = [
            'name' => $this->input->post('name'),
            'model' => $this->input->post('model'),
            'tax_paid' => $this->input->post('tax_paid'),
            'tax_paid_date' => $this->input->post('tax_paid_date'),
            'end_date' => $this->input->post('end_date'),
            'fitness_description' => $this->input->post('fitness_description'),
            'driver_id' => $this->input->post('driver_id')
        ];

        if ($_FILES['image']['name']) {
            $data['image'] = $this->upload_image();
        }

        $this->Vehicle_model->update_vehicle($id, $data);
        $this->session->set_flashdata('success', 'Vehicle updated.');
        redirect('admin/vehicle');
    }

    public function delete($id) {
        $this->Vehicle_model->delete_vehicle($id);
        $this->session->set_flashdata('success', 'Vehicle deleted.');
        redirect('admin/vehicle');
    }

    private function upload_image() {
        $config['upload_path'] = './uploads/vehicles/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name'] = TRUE;


        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image')) {
            return $this->upload->data('file_name');
        }
        return null;
    }
}
