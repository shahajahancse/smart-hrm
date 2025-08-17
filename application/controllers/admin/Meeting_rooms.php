<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting_rooms extends MY_Controller 
{

    public function __construct() {
        parent::__construct();
        $this->load->model("Xin_model");
        $this->load->model('Meeting_room_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Meeting Rooms';
        $data['breadcrumbs'] = 'Meeting Rooms';
        $data['all_meeting_rooms'] = $this->Meeting_room_model->get_meeting_rooms();
        $data['subview'] = $this->load->view("admin/meeting/meeting_rooms", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load

    }

    public function add_meeting_room() {
        if ($this->input->post('add_type') == 'meeting_room') {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('capacity', 'Capacity', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('admin/meeting_rooms');
            } else {
                $data = array(
                    'name' => $this->input->post('name'),
                    'capacity' => $this->input->post('capacity'),
                    'description' => $this->input->post('description'),
                );
                $result = $this->Meeting_room_model->add_meeting_room($data);
                if ($result == TRUE) {
                    $this->session->set_flashdata('success', 'Meeting room added successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                }
                redirect('admin/meeting_rooms');
            }
        } else {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('admin/dashboard');
        }
    }

    public function edit_meeting_room($id) {
        $data['title'] = 'Edit Meeting Room';
        $data['breadcrumbs'] = 'Meeting Rooms';

        $data['meeting_room'] = $this->Meeting_room_model->read_meeting_room_information($id);
        $data['subview'] = $this->load->view("admin/meeting/edit_meeting_room", $data, TRUE);
        $this->load->view('admin/layout/layout_main', $data); //page load
    }

    public function update_meeting_room($id) {
        if ($this->input->post('edit_type') == 'meeting_room') {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('capacity', 'Capacity', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', validation_errors());
                redirect('admin/meeting_rooms/edit_meeting_room/' . $id);
            } else {
                $data = array(
                    'name' => $this->input->post('name'),
                    'capacity' => $this->input->post('capacity'),
                    'description' => $this->input->post('description'),
                );
                $result = $this->Meeting_room_model->update_meeting_room_record($data, $id);
                if ($result == TRUE) {
                    $this->session->set_flashdata('success', 'Meeting room updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong. Please try again.');
                }
                redirect('admin/meeting_rooms');
            }
        } else {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect('admin/dashboard');
        }
    }

    public function delete_meeting_room($id) {
        $this->Meeting_room_model->delete_meeting_room_record($id);
        $this->session->set_flashdata('success', 'Meeting room deleted successfully.');
        redirect('admin/meeting_rooms');
    }
}
?>