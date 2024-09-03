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


    public function get_product_reports_info($id=null, $status=null, $category=null){
        $this->db->select(' 
                    ap.id as a_id,
                    ap.cat_id,
                    ap.device_model,
                    ap.device_name_id,
                    ap.description,
                    ap.status,
                    ap.remark,
                    ap.number,
                    pac.cat_name,
                    pac.cat_short_name,
                    pam.model_name,
                    pam.image,
                    mobile_numbers.number,
                    xin_employees.first_name,
                    xin_employees.last_name
        ');
        $this->db->from('product_accessories as ap');
        $this->db->join('product_accessories_model as pam',  'ap.device_model = pam.id', 'left');
        $this->db->join('product_accessory_categories as pac', 'ap.cat_id = pac.id', 'left');
        $this->db->join('mobile_numbers', 'ap.number = mobile_numbers.id', 'left');    
        $this->db->join('employee_using_device', 'ap.id = employee_using_device.device_id', 'left');    
         $this->db->join('xin_employees', 'employee_using_device.user_id = xin_employees.user_id', 'left');

        if($id !=null){
            $this->db->where('ap.id',$id);
             return $this->db->get()->row();
        } 

        if($category != null){
            $this->db->where('ap.cat_id',$category);
        } 

        if($status != null){
            // dd($status);
            $this->db->where('ap.status',$status);
        } 

        $this->db->order_by('ap.status',"ASC");
        $this->db->group_by('ap.id');

        return $this->db->get()->result();         
    }



    public function get_user_reports_info($user_id){
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


        if($user_id != null){
            $this->db->where('product_accessories.user_id', $user_id);
        }

        // $this->db->group_by('product_accessories.user_id');

        $data = $this->db->get()->result();
        return $data;          
    }

}