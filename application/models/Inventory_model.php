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
	$query = $this->db->order_by('p.cat_id','ASC')->get()->result();
	return $query;
} 

public function product_details($id, $from_date = null, $to_date = null){
	$this->db->select('
		p.id, 
		p.product_name, 
		pp.id as purchase_id,
		pp.quantity, 
		pp.ap_quantity, 
		pp.status as purchase_status,
		SUBSTR(pp.created_at, 1, 10) as created_at,
	');
	$this->db->from('products as p');
	$this->db->join('products_purches_details as pp', 'pp.product_id = p.id');
	$this->db->where('p.id',  $id);
	$this->db->group_by('pp.id');
	$purchase_query = $this->db->order_by('pp.id','DESC')->get()->result();

	$this->db->select('
		p.id, 
		p.product_name, 
		pr.id as requsition_id,
		pr.quantity, 
		pr.approved_qty as ap_quantity, 
		pr.status as requisition_status,
		SUBSTR(pr.created_at, 1, 10) as created_at,
	');
	$this->db->from('products as p');
	$this->db->join('products_requisition_details as pr', 'pr.product_id = p.id');
	$this->db->where('p.id',  $id);
	$this->db->group_by('pr.id');
	$requisition_query = $this->db->order_by('pr.id','DESC')->get()->result();
	$query = array_merge($requisition_query,$purchase_query);
	usort($query, function ($one, $two) {
		if ($one->created_at === $two->created_at) {
			return 0;
		}
		return $one->created_at > $two->created_at ? - 1 : 1;
	});
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

public function requisition_list($session){
	$this->db->select("
		p.product_name, 
		pc.category_name, 

		prd.id,
		prd.quantity,
		prd.approved_qty,
		prd.status,
		prd.created_at,
	");
	$this->db->from("products_requisition_details as prd");
	$this->db->from("products as p");
	$this->db->from("products_categories as pc");
	$this->db->from("products_requisitions as pr");

	$this->db->where("p.id = prd.product_id");
	$this->db->where("pc.id = prd.cat_id");	
	$this->db->where("pr.id = prd.requisition_id");	

	if( $session['role_id'] == 3) {
		$this->db->where("pr.user_id", $session['user_id']);
	}
	$this->db->order_by('prd.created_at', 'desc');
	return	$this->db->get()->result();
} 



	// ************* purchase part ********************
public function purchase_products_requisition($id,$role_id){
	$this->db->select('
		p.id,
		p.user_id,
		p.supplier,
		p.status,
		p.created_at,
		p.updated_by,
		emp.first_name,
		emp.last_name, 
		ps.name,
		ps.company,
	')
	->from('products_purches as p')
	->join('xin_employees as emp', 'emp.user_id = p.user_id', 'left')
	->join('product_supplier as ps', 'ps.id = p.supplier', 'left')
	->order_by('p.id', 'desc');
	return	$this->db->get()->result();
} 


	// ************* purchase part end ********************

public function purchase_products_status($id,$role_id,$status){
	if($role_id==1 || $role_id==2 ||4 ){
		$this->db->select('
			xin_employees.first_name,
			xin_employees.last_name, 
			products_purches.id,
			products_purches.user_id,
			products_purches.status,
			products_purches.created_at,
			products_purches.updated_by
		')
		->from('products_purches')
		->from('xin_employees')
		->where("products_purches.user_id = xin_employees.user_id")
		->where("products_purches.status =$status")
		->order_by('products_purches.id', 'desc');
		}
	return	$this->db->get()->result();
} 

     //requisition show role id
	public function purchase_products($id,$role_id){
		if($role_id==3){
			$this->db->select("
					xin_employees.first_name,
						xin_employees.last_name,
					products_categories.category_name,
				    products_categories.id as cat_id,
				    products_requisitions.user_id,
				    products_requisitions.status,
				    products_requisition_details.created_at,
				    products_requisitions.created_at,
				    products_requisitions.id
				")
			->from("products_categories")
			->from("products_requisitions")
			->from("products_requisition_details")
			->from("xin_employees")
			->where("xin_employees.user_id = products_requisitions.user_id")
			->where("products_categories.id = products_requisition_details.cat_id")	
			->where("products_requisitions.id = products_requisition_details.requisition_id")	
			->where("products_requisitions.user_id = $id")
			->order_by('products_requisitions.id', 'desc');
			
		}

		if($role_id==1 || $role_id==4){
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
		//  dd($this->db->get()->result());
		return	$this->db->get()->result();
	} 
	public function purchase_products_pending($id,$role_id,$status){
		
		if($role_id==3){
			
			$this->db->select("
						xin_employees.first_name,
						xin_employees.last_name,
					products_categories.category_name,
				    products_categories.id as cat_id,
				    products_requisitions.user_id,
				    products_requisitions.status,
				    products_requisition_details.created_at,
				    products_requisitions.created_at,
				    products_requisitions.id
				")
			->from("products_categories")
			->from("products_requisitions")
			->from("products_requisition_details")
			->from("xin_employees")
			->where("xin_employees.user_id = products_requisitions.user_id")
			->where("products_categories.id = products_requisition_details.cat_id")	
			->where("products_requisitions.id = products_requisition_details.requisition_id")	
			->where("products_requisitions.user_id = $id")
			->where("products_requisitions.status = $status")
			->order_by('products_requisitions.id', 'desc');
			
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
			->where("products_requisitions.status = $status")

			//search by accordinig to requisition id 
			->group_by('products_requisitions.id')
			->order_by('products_requisitions.id', 'desc');
		}
		//  dd($this->db->get()->result());
		return	$this->db->get()->result();
	} 

	
	public  function product_purches_details($id){
	
		$this->db->select('
		            xin_employees.first_name,
		            xin_employees.last_name,
				
					products_purches.status,
					products.product_name,
					products_purches_details.quantity,
					products_purches_details.ap_quantity,
					products_purches_details.id,
					products_purches_details.amount,
					products_purches_details.purches_id,
					products_purches_details.created_at
				')

		// ->from('product_supplier')
		->from('products_purches')
		->from('products')
		->from('products_purches_details')
		->from('xin_employees')
		->where("products_purches.user_id = xin_employees.user_id")
		->where("products_purches_details.product_id = products.id")
		->where("products_purches_details.purches_id=products_purches.id")
		->where("products_purches_details.purches_id",$id)

		->order_by('products_purches_details.purches_id', 'desc');
		
		
			
			return $this->db->get()->result();
	}

	//purches requisition details
public  function product_requisition_details($id){
	$this->db->select('
		xin_employees.first_name,
		xin_employees.last_name,
		products_purches.status,
		products.product_name,
		products_purches_details.quantity,
		products_purches_details.ap_quantity,
		products_purches_details.id,
		products_purches_details.amount,
		products_purches_details.purches_id,
		products_purches_details.created_at
	')
	->from('products_purches')
	->from('products')
	->from('products_purches_details')
	->from('xin_employees')
	->where("products_purches.user_id = xin_employees.user_id")
	->where("products_purches_details.product_id = products.id")
	->where("products_purches_details.purches_id=products_purches.id")
	->where("products_purches_details.purches_id",$id)
	->order_by('products_purches_details.purches_id', 'desc');
	return $this->db->get()->result();
}

public  function requisition_details($user_id=null,$id=null){
	$this->db->select(" 
		xin_employees.first_name,
		xin_employees.last_name,
		products_requisition_details.id,
		products_requisition_details.requisition_id,
		products_requisition_details.quantity,
		products_requisition_details.approved_qty,
		products_requisitions.status,
		products_requisitions.user_id,
		products_requisitions.created_at,
		products_categories.category_name,
		products_sub_categories.sub_cate_name,
		products.product_name,
		products.quantity as p_qty,
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
	->where("products_requisitions.id 	= products_requisition_details.requisition_id")	
	->where("xin_employees.user_id 		= products_requisitions.user_id");
	if($user_id!=null){
		$this->db->where("products_requisitions.user_id  = $user_id");
	}
	if($id!=null){
	$this->db->where("products_requisition_details.requisition_id  = $id");
	}
	$this->db->group_by('products_requisition_details.id');
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
			
public function requsition_status_report($f1_date, $f2_date,$statusC){
	$f2_date = date('Y-m-d 23:59:59', strtotime($f2_date));
	$this->db->select(" 
		products_requisition_details.id,
		products_requisitions.created_at,
		products_requisition_details.requisition_id,
		products_requisition_details.quantity,
		products_requisition_details.approved_qty,
		products_requisitions.status,
		products_requisitions.user_id,
		products_categories.category_name,
		products_sub_categories.sub_cate_name,
		products.product_name,
		xin_departments.department_name,
		xin_designations.designation_name,
		xin_employees.first_name,
		xin_employees.last_name
	")
	->from("products_categories")
	->from("products_sub_categories")
	->from("products")
	->from("products_requisitions")
	->from("products_requisition_details")
	->from("xin_employees")
	->from("xin_departments")
	->from("xin_designations")
	->where("xin_designations.designation_id = xin_employees.designation_id")
	->where("xin_departments.department_id = xin_employees.department_id")
	->where("products_categories.id     = products_requisition_details.cat_id")	
	->where("products_sub_categories.id = products_requisition_details.sub_cate_id")	
	->where("products.id 				= products_requisition_details.product_id")	
	->where("products_requisitions.id 			= products_requisition_details.requisition_id")	
	->where("xin_employees.user_id 		= products_requisitions.user_id")
	->where("products_requisitions.created_at BETWEEN '$f1_date' AND '$f2_date'")
	->where("products_requisitions.status 		= $statusC")
	->group_by('products_requisition_details.id');
	$query= $this->db->get();
	$data = $query->result();
	if ($query->num_rows() > 0) {
	return $data;
	
	} else {
		return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
	}
}
	
public function perches_status_report($f1_date, $f2_date,$statusC) {
	$f2_date = date('Y-m-d 23:59:59', strtotime($f2_date));
	$this->db->select(" 
		products_purches_details.id,
		products_purches.created_at,
		products_purches_details.purches_id,
		products_purches_details.quantity,
		products_purches_details.ap_quantity,
		products_purches.status,
		products_purches.user_id,
		products_categories.category_name,
		products_sub_categories.sub_cate_name,
		products.product_name,
		xin_departments.department_name,
		xin_designations.designation_name,
		xin_employees.first_name,
		xin_employees.last_name
	")	
	->from("products_categories")
	->from("products_sub_categories")
	->from("products")
	->from("products_purches")
	->from("products_purches_details")
	->from("xin_employees")
	->from("xin_departments")
	->from("xin_designations")
	->where("xin_designations.designation_id = xin_employees.designation_id")
	->where("xin_departments.department_id = xin_employees.department_id")
	->where("products_categories.id     = products.cat_id")	
	->where("products_sub_categories.id = products.sub_cate_id")	
	->where("products.id 				= products_purches_details.product_id")	
	->where("products_purches.id 			= products_purches_details.purches_id")	
	->where("xin_employees.user_id 		= products_purches.user_id")
	->where("products_purches.created_at BETWEEN '$f1_date' AND '$f2_date'")
	->where("products_purches.status 		= $statusC")
	
	->group_by('products_purches_details.id');
	$query= $this->db->get();
	$data = $query->result();
		
	if ($query->num_rows() > 0) {
	return $data;
	
	} else {
		return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
	}
}

public function low_inv_allProduct_status_report($statusC = null) {
	$this->db->select("
		products.id,
		products.product_name,
		products.quantity,
		products.order_level,
		product_unit.unit_name,
		products_categories.category_name,
		products_sub_categories.sub_cate_name
	")
	->from("products")
	->join("products_categories", "products_categories.id = products.cat_id")
	->join("products_sub_categories", "products_sub_categories.id = products.sub_cate_id")
	->join("product_unit", "product_unit.id = products.unit_id");
	if ($statusC == null) {
		$this->db->where("products.quantity < products.order_level");
	}
	$this->db->order_by('products_categories.category_name');
	$query = $this->db->get();
	$data = $query->result();

	if ($query->num_rows() > 0) {
		return $data;
	} else {
		return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
	}
}


// function user_uses_list(){
// 		$this->db->select('xin_employees.user_id,
// 						xin_employees.employee_id,
// 						xin_employees.first_name,
// 						xin_employees.last_name,
// 						xin_employees.date_of_birth,
// 						xin_departments.department_name,
// 						xin_designations.designation_name,
// 						device_uses_list.id,
// 						device_uses_list.tag,
// 						device_uses_list.desk_no,
// 						device_uses_list.details,
// 						products_categories.category_name,
						
// 						');
// 		$this->db->from('xin_employees');
// 		$this->db->from('xin_departments');
// 		$this->db->from('xin_designations');
// 		$this->db->from('device_uses_list');
// 		$this->db->from('products_categories');
// 		$this->db->where('xin_employees.user_id = device_uses_list.emp_id');
// 		$this->db->where('xin_employees.department_id  = xin_departments.department_id');
// 		$this->db->where('xin_employees.designation_id = xin_designations.designation_id');
// 		$this->db->where('products_categories.id = device_uses_list.cat_id');
// 	$data = $this->db->get();
// 	if ($data->num_rows() > 0) {   
// 			dd($data->result());
// 	}
// }

public function equipment_list($id){
	$this->db->select('
		product_accessories.id AS a_id,
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
		MAX(product_accessories_model.model_name) AS model_name,
		MAX(mobile_numbers.number) AS mobile_number,
		MAX(xin_employees.first_name) AS first_name,
		MAX(xin_employees.last_name) AS last_name,
		product_accessories_working.provide_date
		
	');
	$this->db->from('product_accessories');
	$this->db->join('product_accessories_model', 'product_accessories.device_model = product_accessories_model.id', 'left');
	$this->db->join('product_accessory_categories', 'product_accessories.cat_id = product_accessory_categories.id', 'left');
	$this->db->join('mobile_numbers', 'product_accessories.number = mobile_numbers.id', 'left');
	$this->db->join('product_accessories_working', 'product_accessories.user_id = product_accessories_working.user_id', 'left');
	$this->db->join('xin_employees', 'product_accessories_working.provide_by = xin_employees.user_id', 'left');
	$this->db->group_by('product_accessories.id');

	$data = $this->db->get()->result();

    return $data;          
}



}

	
?>
 