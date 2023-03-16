<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class inventory_model extends CI_Model
	{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


	public function product_list(){
	   $this->db->select('p.id, p.product_name, p.quantity, pc.category_name, psc.sub_cate_name, pu.unit_name');
	   $this->db->from('products as p');
	   $this->db->join('products_categories as pc', 'pc.id = p.cat_id');
	   $this->db->join('products_sub_categories as psc', 'psc.id = p.sub_cate_id');
	   $this->db->join('product_unit as pu', 'pu.id = p.unit_id');
	   $query = $this->db->order_by('p.id','DESC')->get()->result();
	   return $query;
	} 

	public function sub_category_list(){

	   $this->db->select('psc.*, pc.category_name');
	   $this->db->from('products_sub_categories as psc');
	   $this->db->join('products_categories as pc', 'pc.id = psc.cate_id');
	   $query = $this->db->order_by('id','DESC')->get()->result();
	   return $query;
	} 

	public function save($table, $data){
	   return $this->db->insert($table, $data);
	} 
	public function purchase_products($id,$role_id){
	       $this->db->select("products_categories.category_name,
									products_sub_categories.sub_cate_name,
									products.product_name,
									purchase_requisitions.quantity,
									purchase_requisitions.status,
									purchase_requisitions.id,
									purchase_requisitions.requisition_id,
									xin_employees.first_name,
									xin_employees.last_name
						 		")
									->from("products_categories")
									->from("products_sub_categories")
									->from("products")
									->from("purchase_requisitions")
									->from('xin_employees')
									->where("xin_employees.user_id = purchase_requisitions.requisition_id")
									->where("products_categories.id = purchase_requisitions.cat_id")
									->where("products_sub_categories.id= purchase_requisitions.sub_cate_id")
									->where("products.id = purchase_requisitions.product_id");
		if($role_id==4){
			$this->db->where('purchase_requisitions.requisition_id',$id);
		}
		return	$this->db->get()->result();
	} 

}
?>
 