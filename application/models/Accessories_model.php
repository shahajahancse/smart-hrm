<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accessories_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }


public function add_category($table, $data){
    return $this->db->insert($table, $data);
}

public function add_device($table, $data){
    return $this->db->insert($table, $data);
}

public function get_cat_model_info($id=null){
    $this->db->select('product_accessory_categories.*,product_accessories_model.*');
    $this->db->from('product_accessory_categories');
    $this->db->from('product_accessories_model');
    $this->db->where('product_accessory_categories.id = product_accessories_model.cat_id');
    if($id !=null){
        $this->db->where('product_accessories_model.id =', $id);
        $data=$this->db->get()->row();
    } else {
        $data=$this->db->get()->result();
    }
    return $data;          
            //  dd($data);
}


}