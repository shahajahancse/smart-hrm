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


public function get_product_reports_info($id=null,$status=null,$category=null){
    // dd($category);

    $this->db->select(' 
                        product_accessories.*,
                        product_accessory_categories.*,
                        product_accessory_categories.*,
                        product_accessories_model.model_name,
                        mobile_numbers.number,
                        xin_employees.first_name,
                        xin_employees.last_name,

                    ');
    $this->db->from('product_accessories');
    $this->db->join('product_accessories_model','product_accessories.device_model = product_accessories_model.id','left');
    $this->db->join('product_accessory_categories','product_accessories.cat_id    = product_accessory_categories.id','left');
    $this->db->join('mobile_numbers','product_accessories.number                  = mobile_numbers.id','left');    
    $this->db->join('xin_employees','product_accessories.user_id                  = xin_employees.user_id','left');

    if($id !=null){
        $this->db->where('product_accessories.id',$id);
        $data=$this->db->get()->row();
    } 
    else if($status !=null && $category!=null){
        $this->db->where('product_accessories.status',$status);
        $this->db->where('product_accessories.cat_id',$category);
        // $this->db->group_by('product_accessories.cat_id');
        $data=$this->db->get()->result();
         
    } 
    else {
        $data=$this->db->get()->result();
    }
   
    return $data;          
}



}