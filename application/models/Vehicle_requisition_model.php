<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_requisition_model extends CI_Model {

    public function insert($data) {
        return $this->db->insert('vehicle_requisitions', $data);
    }

    public function get_all() {
        return $this->db->get('vehicle_requisitions')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('vehicle_requisitions', ['id' => $id])->row();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('vehicle_requisitions', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('vehicle_requisitions');
    }

    public function get_free_vehicles($from_date, $to_date) {
        $sql = "
        SELECT * FROM vehicle WHERE id NOT IN (
            SELECT vehicle_id FROM vehicle_requisitions 
            WHERE (from_date <= ? AND to_date >= ?) 
               OR (from_date <= ? AND to_date >= ?)
               OR (from_date >= ? AND to_date <= ?)
        )";
        return $this->db->query($sql, [
            $from_date, $from_date,
            $to_date, $to_date,
            $from_date, $to_date
        ])->result();
    }
}
