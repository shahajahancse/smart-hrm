<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Meetings extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Meetings_model');
        $this->load->model('Meeting_room_model');
        $this->load->model('Employees_model');
        $this->load->library('form_validation');
        $this->load->model("Xin_model");
       

    }

    public function index() {
        $data['title'] = 'Meetings';
        $data['breadcrumbs'] = 'Meetings';
        $data['all_meetings'] = $this->Meetings_model->get_meetings();
        $data['all_meeting_rooms'] = $this->Meeting_room_model->get_meeting_rooms();
        $data['all_employees'] = $this->Employees_model->get_employees();
        $data['subview'] = $this->load->view("admin/meeting/meetings", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function add_meeting() {
        if ($this->input->post('add_type') == 'meeting') {
            $this->form_validation->set_rules('room_id', 'Meeting Room', 'trim|required|xss_clean');
            $this->form_validation->set_rules('employee_id', 'Employee', 'trim|required|xss_clean');
            $this->form_validation->set_rules('meeting_title', 'Meeting Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required|xss_clean');
            $this->form_validation->set_rules('end_time', 'End Time', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('admin/meetings');
            } else {
                $start_time = new DateTime($this->input->post('start_time'));
                $end_time = new DateTime($this->input->post('end_time'));

                if ($start_time >= $end_time) {
                    $this->session->set_flashdata('error', 'End time must be after start time.');
                    redirect('admin/meetings');
                }

                if ($this->Meetings_model->check_overlapping_meetings($this->input->post('room_id'), $start_time->format('Y-m-d H:i:s'), $end_time->format('Y-m-d H:i:s'))) {
                    $this->session->set_flashdata('error', 'Meeting room is already booked for the selected time.');
                    redirect('admin/meetings');
                }

                $data = array(
                    'room_id' => $this->input->post('room_id'),
                    'employee_id' => $this->input->post('employee_id'),
                    'meeting_title' => $this->input->post('meeting_title'),
                    'start_time' => $start_time->format('Y-m-d H:i:s'),
                    'date' =>$this->input->post('date'),
                    'end_time' => $end_time->format('Y-m-d H:i:s'),
                );
                $result = $this->Meetings_model->add_meeting($data);
                if ($result) {
                    $attendees = $this->input->post('attendees');
                    if ($attendees) {
                        $attendee_data = [];
                        foreach ($attendees as $attendee) {
                            $attendee_data[] = [
                                'meeting_id' => $result,
                                'employee_id' => $attendee
                            ];
                        }
                        $this->Meetings_model->add_meeting_attendees($attendee_data);
                    }
                    $this->session->set_flashdata('success', 'Meeting booked successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                }
                redirect('admin/meetings');
            }
        } else {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('admin/dashboard');
        }
    }

    public function edit_meeting($id) {
        $data['title'] = 'Edit Meeting';
         $data['breadcrumbs'] = 'Meetings';
        $data['meeting'] = $this->Meetings_model->read_meeting_information($id);
        $data['attendees'] = $this->Meetings_model->get_meeting_attendees($id);
        $data['all_meeting_rooms'] = $this->Meeting_room_model->get_meeting_rooms();
        $data['all_employees'] = $this->Employees_model->get_employees();
        $data['subview'] = $this->load->view("admin/meeting/edit_meeting", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function update_meeting($id) {
        if ($this->input->post('edit_type') == 'meeting') {
            $this->form_validation->set_rules('room_id', 'Meeting Room', 'trim|required|xss_clean');
            $this->form_validation->set_rules('employee_id', 'Employee', 'trim|required|xss_clean');
            $this->form_validation->set_rules('meeting_title', 'Meeting Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required|xss_clean');
            $this->form_validation->set_rules('end_time', 'End Time', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('admin/meetings/edit_meeting/' . $id);
            } else {
                $start_time = new DateTime($this->input->post('start_time'));
                $end_time = new DateTime($this->input->post('end_time'));

                if ($start_time >= $end_time) {
                    $this->session->set_flashdata('error', 'End time must be after start time.');
                    redirect('admin/meetings/edit_meeting/' . $id);
                }

                if ($this->Meetings_model->check_overlapping_meetings($this->input->post('room_id'), $start_time->format('Y-m-d H:i:s'), $end_time->format('Y-m-d H:i:s'), $id)) {
                    $this->session->set_flashdata('error', 'Meeting room is already booked for the selected time.');
                    redirect('admin/meetings/edit_meeting/' . $id);
                }

                $data = array(
                    'room_id' => $this->input->post('room_id'),
                    'employee_id' => $this->input->post('employee_id'),
                    'meeting_title' => $this->input->post('meeting_title'),
                     'date' =>$this->input->post('date'),
                    'start_time' => $start_time->format('Y-m-d H:i:s'),
                    'end_time' => $end_time->format('Y-m-d H:i:s'),
                );
                $result = $this->Meetings_model->update_meeting_record($data, $id);
                if ($result == TRUE) {
                    $this->Meetings_model->delete_meeting_attendees($id);
                    $attendees = $this->input->post('attendees');
                    if ($attendees) {
                        $attendee_data = [];
                        foreach ($attendees as $attendee) {
                            $attendee_data[] = [
                                'meeting_id' => $id,
                                'employee_id' => $attendee
                            ];
                        }
                        $this->Meetings_model->add_meeting_attendees($attendee_data);
                    }
                    $this->session->set_flashdata('success', 'Meeting updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                }
                redirect('admin/meetings');
            }
        } else {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('admin/dashboard');
        }
    }

    public function delete_meeting($id) {
        $this->Meetings_model->delete_meeting_record($id);
        $this->session->set_flashdata('success', 'Meeting deleted successfully.');
        redirect('admin/meetings');
    }
}
?>