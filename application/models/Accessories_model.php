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
    // dd("Ko");
    // dd($status);
    $this->db->select(' 
                product_accessories.id as a_id,
                product_accessories.cat_id,
                product_accessories.device_model,
                product_accessories.device_name_id,
                product_accessories.description,
                product_accessories.status,
                product_accessories.remark,
                product_accessories.use_number,
                product_accessories.number,
                product_accessories.image,
                product_accessories.user_id,
                product_accessory_categories.cat_name,
                product_accessory_categories.cat_short_name,
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
        // dd($data);
    } 
    else if($status !=null && $category!=null){
        // dd($status.' '.$categorys);
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

public function get_user_reports_info($id){
    // dd("Ko");
    // dd($id);
    $this->db->select(' 
                product_accessories.id as a_id,
                product_accessories.cat_id,
                product_accessories.device_model,
                product_accessories.device_name_id,
                product_accessories.description,
                product_accessories.status,
                product_accessories.remark,
                product_accessories.use_number,
                product_accessories.number,
                product_accessories.image,
                product_accessories.user_id,
                product_accessory_categories.cat_name,
                product_accessory_categories.cat_short_name,
                product_accessories_model.model_name,
                mobile_numbers.number,
                xin_employees.first_name,
                xin_employees.last_name,
                xin_departments.department_name,
                xin_designations.designation_name,
    ');
    $this->db->from('product_accessories');
    $this->db->join('product_accessories_model','product_accessories.device_model = product_accessories_model.id','left');
    $this->db->join('product_accessory_categories','product_accessories.cat_id    = product_accessory_categories.id','left');
    $this->db->join('mobile_numbers','product_accessories.number                  = mobile_numbers.id','left');    
    $this->db->join('xin_employees','product_accessories.user_id                  = xin_employees.user_id','left');
    $this->db->join('xin_departments','xin_departments.department_id              = xin_employees.department_id','left');
    $this->db->join('xin_designations','xin_designations.designation_id           = xin_employees.designation_id','left');
    if($id !=null){
        $this->db->where('product_accessories.user_id',$id);
        $data=$this->db->get()->result();
    } 
    else {
        // $this->db->group_by('product_accessories.id');
        $data=$this->db->get()->result();
    }
    return $data;          
}

}