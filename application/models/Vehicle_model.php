<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_model extends CI_Model {

    public function get_all_vehicles() {
        return $this->db->get('vehicle')->result();
    }

    public function insert_vehicle($data) {
        return $this->db->insert('vehicle', $data);
    }

    public function get_vehicle_by_id($id) {
        return $this->db->get_where('vehicle', array('id' => $id))->row();
    }

    public function update_vehicle($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('vehicle', $data);
    }

    public function delete_vehicle($id) {
        $this->db->where('id', $id);
        return $this->db->delete('vehicle');
    }
}
