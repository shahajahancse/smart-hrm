<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_requisition extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Vehicle_requisition_model');
        $this->load->model('Vehicle_model');
        $this->load->model("Xin_model"); // for common functions like employees
  
    }

    public function index() {
    
        $data['requisitions'] = $this->Vehicle_requisition_model->get_all();
        $data['subview'] = $this->load->view('admin/vehicle_requisition/list', $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data);
    }

    public function create() {
        $data['breadcrumbs'] = 'Vehicles';

        $data['title'] = 'Request Vehicle';
        $data['subview'] = $this->load->view('admin/vehicle_requisition/create', $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data);
    }

    public function store() {
        $post = $this->input->post();
        $data = [
            'from_date' => $post['from_date'],
            'to_date' => $post['to_date'],
            'vehicle_id' => $post['vehicle_id'],
            'req_person' => $post['req_person'],
            'purpose' => $post['purpose'],
            'organisation' => $post['organisation'],
            'location' => $post['location'],
            'description' => $post['description']
        ];
        $this->Vehicle_requisition_model->insert($data);
        redirect('admin/vehicle_requisition');
    }

    public function approve($id) {
        $this->Vehicle_requisition_model->update($id, ['status' => 'Approved']);
        redirect('admin/vehicle_requisition');
    }

    public function reject($id) {
        $this->Vehicle_requisition_model->update($id, ['status' => 'Rejected']);
        redirect('admin/vehicle_requisition');
    }

    public function get_free_vehicles() {
        $from_date = $this->input->get('from_date');
        $to_date = $this->input->get('to_date');
        $vehicles = $this->Vehicle_requisition_model->get_free_vehicles($from_date, $to_date);
        echo json_encode($vehicles);
    }
}
