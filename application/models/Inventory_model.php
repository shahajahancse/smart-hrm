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
		$query = $this->db->order_by('p.id','ASC')->get()->result();
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
		if($from_date != '' && $to_date !=''){
			$this->db->where('pp.created_at between "' . $from_date . '" AND "' . $to_date . '"');
		}
		$this->db->group_by('pp.id');
		$purchase_query = $this->db->order_by('pp.id','DESC')->get()->result();

		$this->db->select('
			p.id, 
			p.product_name, 
			pr.id as requsition_id,
			pr.note,
			pr.quantity, 
			pr.user_id, 
			pr.updated_by, 
			pr.approved_qty as ap_quantity, 
			pr.status as requisition_status,
			SUBSTR(pr.created_at, 1, 10) as created_at,
		');
		$this->db->from('products as p');
		$this->db->join('products_requisition_details as pr', 'pr.product_id = p.id');
		$this->db->where('p.id',  $id);
		if($from_date != '' && $to_date !=''){
			$this->db->where('pr.created_at between "' . $from_date . '" AND "' . $to_date . '"');
		}
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
			prd.id as prd_id,
			prd.quantity,
			prd.approved_qty,
			prd.status,
			prd.created_at,
			prd.note,
		");
		$this->db->from("products_requisition_details as prd");
		$this->db->from("products as p");
		$this->db->from("products_categories as pc");
		$this->db->where("p.id = prd.product_id");
		$this->db->where("pc.id = prd.cat_id");	
		if( $session['role_id'] == 3) {
			$this->db->where("prd.user_id", $session['user_id']);
		}
		return	$this->db->get()->result();
	} 



	// ************* purchase part ********************
	public function purchase_products_requisition($id,$role_id){
		$this->db->select('
			p.id,
			p.user_id,
			p.status,
			p.created_at,
			p.updated_by,
			emp.first_name,
			emp.last_name
		')->from('products_purches_details as p')
		->join('xin_employees as emp', 'emp.user_id = p.user_id', 'left');
		$this->db->order_by('p.id', 'desc');
		if($role_id == 4){
			$this->db->where('p.user_id',$id);
			return	$this->db->get()->result();
		}
		if($role_id == 1 || $role_id == 2) {
			return	$this->db->get()->result();
		}
	} 
	public function purchase_products_requisition_api($offset, $limit ,$status){
		
		$this->db->select('
			p.id,
			p.product_id,
			p.quantity,
			p.ap_quantity,
			p.user_id,
			p.status,
			p.created_at,
			p.updated_by,
			emp.first_name,
			emp.last_name,
			products.product_name
		')->from('products_purches_details as p')
		->join('xin_employees as emp', 'emp.user_id = p.user_id', 'left')
		->join('products', 'p.product_id = products.id', 'left');
		$this->db->order_by('p.id', 'desc');
		$this->db->limit($limit, $offset);
			$this->db->where('p.status',$status);
			return	$this->db->get()->result();
	} 


	// ************* purchase part end ********************

	public function purchase_products_status($id,$role_id,$status){
		// dd($status);
		// if($role_id==1 || $role_id==2 || $role_id==4  ){
			$this->db->select('
				xin_employees.first_name,
				xin_employees.last_name, 
				products_purches_details.id,
				products_purches_details.user_id,
				products_purches_details.status,
				products_purches_details.created_at,
				products_purches_details.updated_by
			')
			->from('products_purches_details')
			->from('xin_employees')
			->where("products_purches_details.user_id = xin_employees.user_id")
			->where("products_purches_details.status =$status")
			->order_by('products_purches_details.id', 'desc');
			// }
		return	$this->db->get()->result();
	} 

	public function purchase_products($id,$role_id){
		$this->db->select("
			xin_employees.first_name,
			xin_employees.last_name,
			products.product_name,
			products_categories.category_name,
			products_sub_categories.sub_cate_name,
			products_requisition_details.*,
		")
		->from("products_requisition_details")
		->join('products', 'products_requisition_details.product_id = products.id', 'left')
		->join('products_categories', 'products_requisition_details.cat_id = products_categories.id', 'left')
		->join('products_sub_categories', 'products_requisition_details.sub_cate_id = products_sub_categories.id', 'left')
		->join('xin_employees', 'products_requisition_details.user_id = xin_employees.user_id', 'left')
		->group_by('products_requisition_details.id')
		->order_by('products_requisition_details.id', 'desc');

		return	$this->db->get()->result();
	} 
	public function product_requisition($id,$role_id,$status = array()){
		$this->db->select("
			xin_employees.first_name,
			xin_employees.last_name,
			products.product_name,
			products_requisition_details.*
		")
		->from("products_requisition_details")
		->join('xin_employees','products_requisition_details.user_id = xin_employees.user_id','left')
		->join('products','products_requisition_details.product_id = products.id','left')
		->where_in('products_requisition_details.status',$status)
		->group_by('products_requisition_details.id')
		->order_by('products_requisition_details.id', 'desc');
		return	$this->db->get()->result();
	} 
	public function product_requisition_api($offset, $limit, $status){
		$this->db->select("
			xin_employees.first_name,
			xin_employees.last_name,
			products.product_name,
			products_requisition_details.*
		")
		->from("products_requisition_details")
		->join('xin_employees','products_requisition_details.user_id = xin_employees.user_id','left')
		->join('products','products_requisition_details.product_id = products.id','left')
		->where('products_requisition_details.status',$status)
		->group_by('products_requisition_details.id')
		->order_by('products_requisition_details.id', 'desc');
		$this->db->limit($limit, $offset);
		return	$this->db->get()->result();
	} 

	
	public  function product_purches_details($id){
		$this->db->select('
			xin_employees.first_name,
			xin_employees.last_name,
			products.product_name,
			products_purches_details.quantity,
			products_purches_details.ap_quantity,
			products_purches_details.id,
			products_purches_details.amount,
			products_purches_details.created_at
		')
		->from('products')
		->from('products_purches_details')
		->from('xin_employees')
		->where("products_purches_details.user_id = xin_employees.user_id")
		->where("products_purches_details.product_id = products.id")
		->where("products_purches_details.id",$id)
		->order_by('products_purches_details.id', 'desc');
		return $this->db->get()->result();
	}

	//purches requisition details
	public  function product_requisition_details($id){
		$this->db->select('
			xin_employees.first_name,
			xin_employees.last_name,
			products_purches_details.status,
			products.product_name,
			products_purches_details.quantity,
			products_purches_details.ap_quantity,
			products_purches_details.id,
			products_purches_details.amount,
			products_purches_details.approx_t_amount,
			products_purches_details.approx_amount,
			products_purches_details.created_at
		')
		->from('products')
		->from('products_purches_details')
		->from('xin_employees')
		->where("products_purches_details.user_id = xin_employees.user_id")
		->where("products_purches_details.product_id = products.id")
		->where("products_purches_details.id",$id)
		->order_by('products_purches_details.id', 'desc');
		return $this->db->get()->result();
	}

	public  function requisition_details($id=null){
		return $this->db->select(" 
			xin_employees.first_name,
			xin_employees.last_name,
			products_requisition_details.id,
			products_requisition_details.user_id,
			products_requisition_details.quantity,
			products_requisition_details.approved_qty,
			products_requisition_details.note,
			products_categories.category_name,
			products_sub_categories.sub_cate_name,
			products.product_name,
			products.quantity as p_qty,
			products.permission as p_permission,
		")
		->from("products_categories")
		->from("products_sub_categories")
		->from("products")
		->from("products_requisition_details")
		->from("xin_employees")
		->where("products_categories.id     = products_requisition_details.cat_id")	
		->where("products_sub_categories.id = products_requisition_details.sub_cate_id")	
		->where("products.id 				= products_requisition_details.product_id")	
		->where("xin_employees.user_id 		= products_requisition_details.user_id")
		->where("products_requisition_details.id",$id)
		->group_by('products_requisition_details.id')->get()->row();
	}

	public  function req_details_cat_wise($id){
		// dd($id);
		$this->db->select(" 
			products_categories.category_name,
			products_sub_categories.sub_cate_name,
			products.product_name,
			products_requisition_details.quantity,
			products_requisition_details.approved_qty,
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
		->where("products_requisition_details.cat_id = $id")
		->group_by('products_requisition_details.id');
		// dd($id);
		return $this->db->get()->result();
	}
	
	public  function req_purchase_details($id){
		// dd($id);
		$this->db->select(" 
			product_unit.unit_name,
			products.product_name,
			products_purches_details.quantity,
			products_purches_details.ap_quantity,
		")
		->from("products")	
		->join("products_purches_details","products.id = products_purches_details.product_id")	
		->join("product_unit","product_unit.id = products.unit_id")	
		->where("products_purches_details.id = $id");
		return $this->db->get()->row();
	}
				
	public function requsition_status_report($f1_date=null, $f2_date=null,$statusC= null){
		// $f1_date = date('Y-m-d', strtotime($f1_date));
		// $f2_date = date('Y-m-d', strtotime($f2_date));
		$this->db->select(" 
			products_requisition_details.id,
			products_requisition_details.status,
			products_requisition_details.quantity,
			products_requisition_details.approved_qty,
			products_requisition_details.user_id,
			products_requisition_details.created_at,
			products_requisition_details.note,
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
		->from("products_requisition_details")
		->from("xin_employees")
		->from("xin_departments")
		->from("xin_designations")
		->where("xin_designations.designation_id = xin_employees.designation_id")
		->where("xin_departments.department_id   = xin_employees.department_id")
		->where("xin_employees.user_id   = products_requisition_details.user_id")
		->where("products_categories.id          = products_requisition_details.cat_id")	
		->where("products_sub_categories.id 	 = products_requisition_details.sub_cate_id")	
		->where("products.id 					 = products_requisition_details.product_id")	
		->where("products.id 					 = products_requisition_details.product_id");

		if ($statusC != null) {
			$this->db->where("products_requisition_details.status",$statusC);
		}	

		// dd($statusC);

		if($f1_date !='' &&  $f2_date == ''){
			$f1_date = date('Y-m-d', strtotime($f1_date));
			$this->db->where("products_requisition_details.created_at BETWEEN '$f1_date' AND '$f1_date'");
		}else if($f1_date !='' &&  $f2_date != ''){
			$f1_date = date('Y-m-d', strtotime($f1_date));
			$f2_date = date('Y-m-d', strtotime($f2_date));
			$this->db->where("products_requisition_details.created_at BETWEEN '$f1_date' AND '$f2_date'");
		}
		$this->db->group_by('products_requisition_details.id');
		$query= $this->db->get();
		if ($query->num_rows() > 0) {
			$data = $query->result();
			return $data;
		} else {
			return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
		}
	}
	
	public function perches_status_report($f1_date, $f2_date,$statusC) {
		
		$this->db->select(" 
			products_purches_details.quantity,
			products_purches_details.ap_quantity,
			products_purches_details.created_at,
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
		->from("products_purches_details")
		->from("xin_employees")
		->from("xin_departments")
		->from("xin_designations")
		->where("xin_designations.designation_id = xin_employees.designation_id")
		->where("xin_departments.department_id = xin_employees.department_id")
		->where("products_categories.id     = products.cat_id")	
		->where("products_sub_categories.id = products.sub_cate_id")	
		->where("products.id 				= products_purches_details.product_id")	
		->where("xin_employees.user_id 		= products_purches_details.user_id")
		->where("products_purches_details.status 		= $statusC");
		if($f1_date !='' &&  $f2_date == ''){
			$f1_date = date('Y-m-d', strtotime($f1_date));
			$this->db->where("products_purches_details.created_at BETWEEN '$f1_date' AND '$f1_date'");
		}else if($f1_date !='' &&  $f2_date != ''){
			$f1_date = date('Y-m-d', strtotime($f1_date));
			$f2_date = date('Y-m-d', strtotime($f2_date));
			$this->db->where("products_purches_details.created_at BETWEEN '$f1_date' AND '$f2_date'");
		}
	
		$this->db->group_by('products_purches_details.id');
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

	public function equipment_list($session = null){
		$this->db->select('
			pa.id AS a_id,
			pa.cat_id,
			pa.device_model,
			pa.device_name_id,
			pa.description,
			pa.status,
			pa.remark,
			pa.use_number,
			pa.number,
			pa.image,
			pa.user_id,
			paw.provide_date,
			MAX(e.first_name) AS first_name,
			MAX(e.last_name) AS last_name,

			pac.cat_name,
			pac.cat_short_name,
			MAX(pam.model_name) AS model_name,
			MAX(mobile_numbers.number) AS mobile_number,
			paw.provide_date
		');
		$this->db->from('product_accessories as pa');
		$this->db->join('product_accessories_working as paw', 'pa.user_id = paw.user_id', 'left');
		$this->db->join('xin_employees as e', 'paw.user_id = e.user_id', 'left');
		$this->db->join('product_accessories_model as pam', 'pa.device_model = pam.id', 'left');
		$this->db->join('product_accessory_categories as pac', 'pa.cat_id = pac.id', 'left');
		$this->db->join('mobile_numbers', 'pa.number = mobile_numbers.id', 'left');
		if ($session['role_id'] == 3 && $session != null) {
			$this->db->where('paw.user_id', $session['user_id']);
		}
		$this->db->group_by('pa.id');
		$data = $this->db->get()->result();
		return $data;          
	}

	public function movement_list(){
		$this->db->select('
			pa.id AS a_id,
			pa.device_name_id,
			pa.device_model,
			pac.cat_name,
			pac.cat_short_name,
			pac.id as cat_id,
			MAX(pam.model_name) AS model_name,
		');
		$this->db->from('product_accessories as pa');
		$this->db->join('product_accessories_model as pam', 'pa.device_model = pam.id', 'left');
		$this->db->join('product_accessory_categories as pac', 'pa.cat_id = pac.id', 'left');
		$this->db->where('pa.status',5);
		$this->db->where('pa.move_status',1);
		$this->db->group_by('pa.id');
		$data = $this->db->get()->result();
		return $data;          
	}

	public function request_list(){
		$this->db->select("
			product_accessories_model.model_name, 
			product_accessory_categories.cat_name, 
			product_accessory_categories.cat_short_name, 
			product_accessories.device_name_id, 
			xin_employees.first_name, 
			xin_employees.last_name,
			move_list.*, 
		");
		$this->db->from("move_list");
		$this->db->join("product_accessories_model", "move_list.device_id = product_accessories_model.id",'left');
		$this->db->join("xin_employees", "move_list.user_id = xin_employees.user_id",'left');
		$this->db->join("product_accessories", "move_list.device_id = product_accessories.id",'left'); // Join the product_accessories table
		$this->db->join("product_accessory_categories", "product_accessory_categories.id = product_accessories.cat_id"); // Join the product_accessories table
		$this->db->where("move_list.status", 2);
		return $this->db->get()->result();
	} 

	public function active_list(){
		$this->db->select('product_accessories_model.model_name,
					product_accessories.device_name_id,
					product_accessory_categories.cat_name,
					product_accessory_categories.cat_short_name,
					xin_employees.first_name,
					xin_employees.last_name,
					move_list.*
		')
		->from('move_list')
		->join("product_accessories", "move_list.device_id = product_accessories.device_model")
		->join("xin_employees", "xin_employees.user_id = move_list.user_id")
		->join("product_accessories_model", "product_accessories.device_model = product_accessories_model.id")
		->join("product_accessory_categories", "product_accessory_categories.id = product_accessories.cat_id")
		->where('product_accessories.status',5)
		->where('product_accessories.move_status',2)
		->where('move_list.status',2);
		// dd($this->db->get()->result());
		return $this->db->get()->result();
	} 

	public function inactive_list(){
		$this->db->select("
			product_accessories_model.model_name, 
			product_accessory_categories.cat_name, 
			product_accessory_categories.cat_short_name, 
			product_accessories.device_name_id,
			product_accessories.status,
			product_accessories.move_status,
			product_accessories.id,
		");
		$this->db->from("product_accessories");
		$this->db->join("product_accessories_model", "product_accessories.device_model = product_accessories_model.id");	
		$this->db->join("product_accessory_categories", "product_accessory_categories.id = product_accessories.cat_id"); // Join the product_accessories table
		$this->db->where("product_accessories.status",5);
		return $this->db->get()->result();
	} 

}
?>
