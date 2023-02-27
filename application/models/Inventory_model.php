<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class inventory_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	
	public function get_categories(){
	   $data[''] = '-- Select Category --';
	   $this->db->select('id, category_name');
	   $this->db->from('categories');
	   $query = $this->db->get();

	   foreach ($query->result_array() AS $rows) {
	      $data[$rows['id']] = $rows['category_name'];
	   }
	   return $data;
	} 

	public function get_units(){
	   $data[''] = '-- Select Unit --';
	   $this->db->select('id, unit_name');
	   $this->db->from('item_unit');
	   $query = $this->db->get();

	   foreach ($query->result_array() AS $rows) {
	      $data[$rows['id']] = $rows['unit_name'];
	   }
	   return $data;
} 

}
?>
 