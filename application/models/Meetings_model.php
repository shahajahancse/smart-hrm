<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Meetings_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all meetings
    public function get_meetings() {
        $this->db->select("meetings.*, meeting_rooms.name as room_name, xin_employees.first_name, xin_employees.last_name, GROUP_CONCAT(att.first_name SEPARATOR ', ') as attendees");
        $this->db->from('meetings');
        $this->db->join('meeting_rooms', 'meetings.room_id = meeting_rooms.room_id');
        $this->db->join('xin_employees', 'meetings.employee_id = xin_employees.user_id');
        $this->db->join('meeting_attendees as ma', 'meetings.meeting_id = ma.meeting_id', 'left');
        $this->db->join('xin_employees as att', 'ma.employee_id = att.user_id', 'left');
        $this->db->group_by('meetings.meeting_id');
        return $this->db->get();
    }

    // add new meeting
    public function add_meeting($data) {
        $this->db->insert('meetings', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function add_meeting_attendees($data) {
        $this->db->insert_batch('meeting_attendees', $data);
    }

    // check for overlapping meetings
    public function check_overlapping_meetings($room_id, $start_time, $end_time, $meeting_id = null) {
        $this->db->where('room_id', $room_id);
        $this->db->where('start_time <', $end_time);
        $this->db->where('end_time >', $start_time);
        if ($meeting_id) {
            $this->db->where('meeting_id !=', $meeting_id);
        }
        $query = $this->db->get('meetings');
        return $query->num_rows() > 0;
    }

    // get meeting by id
    public function read_meeting_information($id) {
        $condition = "meeting_id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('meetings');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    // update meeting
    public function update_meeting_record($data, $id) {
        $this->db->where('meeting_id', $id);
        if ($this->db->update('meetings', $data)) {
            return true;
        } else {
            return false;
        }
    }

    // delete meeting
    public function delete_meeting_record($id) {
        $this->db->where('meeting_id', $id);
        $this->db->delete('meetings');
    }

    public function get_meeting_attendees($id) {
        $this->db->select('employee_id');
        $this->db->from('meeting_attendees');
        $this->db->where('meeting_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_meeting_attendees($id) {
        $this->db->where('meeting_id', $id);
        $this->db->delete('meeting_attendees');
    }

    public function get_meetings_report($room_id, $employee_id, $start_date, $end_date) {
        $this->db->select("meetings.*, meeting_rooms.name as room_name, xin_employees.first_name, xin_employees.last_name, GROUP_CONCAT(att.first_name SEPARATOR ', ') as attendees");
        $this->db->from('meetings');
        $this->db->join('meeting_rooms', 'meetings.room_id = meeting_rooms.room_id');
        $this->db->join('xin_employees', 'meetings.employee_id = xin_employees.user_id');
        $this->db->join('meeting_attendees as ma', 'meetings.meeting_id = ma.meeting_id', 'left');
        $this->db->join('xin_employees as att', 'ma.employee_id = att.user_id', 'left');

        if ($room_id) {
            $this->db->where('meetings.room_id', $room_id);
        }
        if ($employee_id) {
            $this->db->where('meetings.employee_id', $employee_id);
        }
        if ($start_date) {
            $this->db->where('meetings.start_time >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('meetings.end_time <=', $end_date);
        }

        $this->db->group_by('meetings.meeting_id');
        return $this->db->get()->result();
    }
}
?>