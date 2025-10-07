<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting_reports extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Meetings_model');
        $this->load->model('Meeting_room_model');
        $this->load->model('Employees_model');
         $this->load->model("Xin_model");
    }

    public function index() {
        $data['title'] = 'Meeting Reports';
        $data['breadcrumbs'] = 'Meeting Reports';
        $data['all_meeting_rooms'] = $this->Meeting_room_model->get_meeting_rooms();
        $data['all_employees'] = $this->Employees_model->get_employees();
        $data['subview'] = $this->load->view("admin/meeting/meeting_report", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function generate_report() {
        $room_id = $this->input->post('room_id');
        $employee_id = $this->input->post('employee_id');
        $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
        $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));

        $data['meetings'] = $this->Meetings_model->get_meetings_report($room_id, $employee_id, $start_date, $end_date);

        $this->load->view('admin/meeting/report_results', $data);
    }
}
?>
