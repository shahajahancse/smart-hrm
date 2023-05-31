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
	public function purchase_products_requisition($id,$role_id){

		if($role_id==1){
			$this->db->select('
					xin_employees.first_name,
					xin_employees.last_name, 
					product_supplier.name,
					product_supplier.company,
					products_purches.id,
					products_purches.user_id,
					products_purches.status,
					products_purches.created_at,
					products_purches.updated_by
				')
			->from('product_supplier')
			->from('products_purches')
			->from('xin_employees')
			->where("products_purches.user_id = xin_employees.user_id")
			->where("products_purches.supplier =product_supplier.id")
			->order_by('products_purches.id', 'desc');
		}

		if($role_id==4){
			$this->db->select("
					xin_employees.first_name,
					xin_employees.last_name, 
					product_supplier.name,
					product_supplier.company,
					products_purches.status,
					products_purches_requisitions.id,
				")
	        ->from('product_supplier')
	        ->from('products_purches')
	        ->from('products')
			->where("xin_employees.user_id = products_requisitions.user_id")
			//search by accordinig to requisition id 
			->group_by('products_requisitions.id')
			->order_by('products_requisitions.id', 'desc');
		}
		// dd($this->db->get()->result());
		return	$this->db->get()->result();
	} 



	public function purchase_products($id,$role_id){

		if($role_id==4){
			$this->db->select("
					products_categories.category_name,
				    products_categories.id as cat_id,
				    products_requisitions.user_id,
				    products_requisitions.status,
				    products_requisition_details.created_at,
				    requisitions.created_at,
				    products_requisitions.id
				")
			->from("products_categories")
			->from("products_requisitions")
			->from("products_requisition_details")
			->from("xin_employees")
			->where("products_categories.id = products_requisition_details.cat_id")	
			->where("products_requisitions.id = products_requisition_details.requisition_id")	
			->where("products_requisitions.user_id = $id")
			->group_by('products_requisition_details.cat_id');
		}

		if($role_id==1){
		   $this->db->select("
			   		xin_employees.first_name,
			   		xin_employees.last_name,
			   		products_requisitions.id,
			   		products_requisitions.created_at,
			   		products_requisitions.status,
			   		products_requisition_details.created_at,
			   		products_requisitions.user_id
			   	")
			->from("products_requisition_details")
			->from("products_requisitions")
			->from('xin_employees')
			->where("xin_employees.user_id = products_requisitions.user_id")
			//search by accordinig to requisition id 
			->group_by('products_requisitions.id')
			->order_by('products_requisitions.id', 'desc');
		}
		// dd($this->db->get()->result());
		return	$this->db->get()->result();
	} 

	
	public  function product_purches_details($id){
		// dd($id);
		$this->db->select('xin_employees.first_name,xin_employees.last_name, product_supplier.name,product_supplier.company,products_purches.status,products.product_name,
		products_purches_requisitions.quantity,products_purches_requisitions.ap_quantity,products_purches_requisitions.id ,products_purches_requisitions.amount,products_purches_requisitions.purches_id,products_purches_requisitions.created_at')
		->from('product_supplier')
		->from('products_purches')
		->from('products')
		->from('products_purches_requisitions')
		->from('xin_employees')
		->where("products_purches.user_id = xin_employees.user_id")
		->where("products_purches.supplier =product_supplier.id")
		->where("products_purches_requisitions.product_id = products.id")
		->where("products_purches_requisitions.purches_id=products_purches.id")
		->where("products_purches_requisitions.purches_id",$id)

		->order_by('products_purches_requisitions.purches_id', 'desc');
		
		
			
			return $this->db->get()->result();
	}

	//purches requisition details
	public  function product_requisition_details($id){
		// dd($id);
		$this->db->select('xin_employees.first_name,xin_employees.last_name, product_supplier.name,product_supplier.company,products_purches.status,products.product_name,
		products_purches_requisitions.quantity,products_purches_requisitions.ap_quantity,products_purches_requisitions.id ,products_purches_requisitions.amount,products_purches_requisitions.purches_id,products_purches_requisitions.created_at')
		->from('product_supplier')
		->from('products_purches')
		->from('products')
		->from('products_purches_requisitions')
		->from('xin_employees')
		->where("products_purches.user_id = xin_employees.user_id")
		->where("products_purches.supplier =product_supplier.id")
		->where("products_purches_requisitions.product_id = products.id")
		->where("products_purches_requisitions.purches_id=products_purches.id")
		->where("products_purches_requisitions.purches_id",$id)

		->order_by('products_purches_requisitions.purches_id', 'desc');
		
			return $this->db->get()->result();
	}
// requisition details for requisition id

	public  function requisition_details($id){
		// dd($id);
			$this->db->select(" 
			                    products_requisition_details.id,
								products_requisition_details.requisition_id,
								products_requisition_details.quantity,
								products_requisition_details.approved_qty,
								products_requisitions.status,
								products_requisitions.user_id,
								products_categories.category_name,
								products_sub_categories.sub_cate_name,
								products.product_name,
							")
			->from("products_categories")
			->from("products_sub_categories")
			->from("products")
			->from("products_requisitions")
			->from("products_requisition_details")
			->from("xin_employees")
			->where("products_categories.id     = products_requisition_details.cat_id")	
			->where("products_sub_categories.id = products_requisition_details.sub_cate_id")	
			->where("products.id 				= products_requisition_details.product_id")	
			->where("products_requisitions.id 			= products_requisition_details.requisition_id")	
			->where("xin_employees.user_id 		= products_requisitions.user_id")	
			//razib
			// ->where("requisitions.user_id 		= $id")
			->where("products_requisitions.id 		= $id")
			->group_by('products_requisition_details.id');
			return $this->db->get()->result();
	}
	public  function req_details_cat_wise($id){
		// dd($id);
			$this->db->select(" 
								products_categories.category_name,
								products_sub_categories.sub_cate_name,
								products.product_name,
								products_requisition_details.quantity,
								products_requisitions.user_id,
							")
			->from("products_categories")
			->from("products_sub_categories")
			->from("products")
			->from("products_requisitions")
			->from("products_requisition_details")
			->where("products_categories.id     = products_requisition_details.cat_id")	
			->where("products_sub_categories.id = products_requisition_details.sub_cate_id")	
			->where("products.id 				= products_requisition_details.product_id")	
			->where("products_requisitions.id 			= products_requisition_details.requisition_id")
			->where("products_requisition_details.cat_id = $id")
			->group_by('products_requisition_details.id');
			return $this->db->get()->result();
	}

}
?>
 