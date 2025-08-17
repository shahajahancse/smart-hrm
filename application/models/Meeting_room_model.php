<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting_room_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all meeting rooms
    public function get_meeting_rooms() {
        return $this->db->get("meeting_rooms");
    }

    // add new meeting room
    public function add_meeting_room($data) {
        $this->db->insert('meeting_rooms', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // get meeting room by id
    public function read_meeting_room_information($id) {
        $condition = "room_id =" . "'" . $id . "'";
        $this->db->select('*');
        $this->db->from('meeting_rooms');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    // update meeting room
    public function update_meeting_room_record($data, $id) {
        $this->db->where('room_id', $id);
        if ($this->db->update('meeting_rooms', $data)) {
            return true;
        } else {
            return false;
        }
    }

    // delete meeting room
    public function delete_meeting_room_record($id) {
        $this->db->where('room_id', $id);
        $this->db->delete('meeting_rooms');
    }
}
?>