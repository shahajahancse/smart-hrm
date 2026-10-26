<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_report_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Function to update record in table
    public function update_leave_details($data, $id){
        $this->db->where('leave_id', $id);
        if( $this->db->update('xin_leave_applications', $data)) {
            return true;
        } else {
            return false;
        }
    }
}
?>