<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	// get payslip list> reports
	public function get_payslip_list($cid,$eid,$re_date) {
	  if($eid=='' || $eid==0){
		
		$sql = 'SELECT * from xin_salary_payslips where salary_month = ? and company_id = ?';
		$binds = array($re_date,$cid);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	  } else {
	 	 
		$sql = 'SELECT * from xin_salary_payslips where employee_id = ? and salary_month = ? and company_id = ?';
		$binds = array($eid,$re_date,$cid);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	  }
	}
	// get training list> reports
	public function get_training_list($cid,$sdate,$edate) {
		
		$sql = 'SELECT * from `xin_training` where company_id = ? and start_date >= ? and finish_date <= ?';
		$binds = array($cid,$sdate,$edate);
		$query = $this->db->query($sql, $binds);
		
		return $query;
	}
	// get leave list> reports
	public function get_leave_application_list() {
		
		$sql = 'SELECT * from `xin_leave_applications` group by employee_id';
		$query = $this->db->query($sql);
		return $query;
	}
	// get filter leave list> reports
	public function get_leave_application_filter_list($sd,$ed,$user_id,$company_id) {
		
		$sql = 'SELECT * from `xin_leave_applications` where company_id = ? and employee_id = ? and from_date >= ? and to_date <= ? group by employee_id';
		$binds = array($company_id,$user_id,$sd,$ed);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get pending leave list> reports
	public function get_pending_leave_application_list($employee_id) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,1);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get approved leave list> reports
	public function get_approved_leave_application_list($employee_id) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,2);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get upcoming leave list> reports
	public function get_upcoming_leave_application_list($employee_id) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,4);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get rejected leave list> reports
	public function get_rejected_leave_application_list($employee_id) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,3);
		$query = $this->db->query($sql, $binds);
		return $query->num_rows();
	}
	// get only pending leave list> reports
	public function get_pending_leave_list($employee_id,$status) {
		
		$sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
		$binds = array($employee_id,$status);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get project list> reports
	public function get_project_list($projId,$projStatus) {
		
		if($projId==0 && $projStatus=='all') {
			return $query = $this->db->query("SELECT * FROM `xin_projects`");
		} else if($projId==0 && $projStatus!='all') {
			$sql = 'SELECT * from `xin_projects` where status = ?';
			$binds = array($projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($projId!=0 && $projStatus=='all') {
			$sql = 'SELECT * from `xin_projects` where project_id = ?';
			$binds = array($projId);
			$query = $this->db->query($sql, $binds);
			return $query;
		} else if($projId!=0 && $projStatus!='all') {
			$sql = 'SELECT * from `xin_projects` where project_id = ? and status = ?';
			$binds = array($projId,$projStatus);
			$query = $this->db->query($sql, $binds);
			return $query;
		}
	}
	// get employee projects
	public function get_employee_projectsx($id) {
	
		$sql = "SELECT * FROM `xin_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	
	// get task list> reports
	public function get_task_list($taskId,$taskStatus) {
		
		  if($taskId==0 && $taskStatus==4) {
			  return $query = $this->db->query("SELECT * FROM xin_tasks");
		  } else if($taskId==0 && $taskStatus!=4) {
			  $sql = 'SELECT * from xin_tasks where task_status = ?';
			  $binds = array($taskStatus);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($taskId!=0 && $taskStatus==4) {
			  $sql = 'SELECT * from xin_tasks where task_id = ?';
			  $binds = array($taskId);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($taskId!=0 && $taskStatus!=4) {
		  	  $sql = 'SELECT * from xin_tasks where task_id = ? and task_status = ?';
			  $binds = array($taskId,$taskStatus);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  }
	}
	
	// get roles list> reports
	public function get_roles_employees($role_id) {
		  if($role_id==0) {
			  return $query = $this->db->query("SELECT * FROM xin_employees");
		  } else {
			  $sql = 'SELECT * from xin_employees where user_role_id = ?';
			  $binds = array($role_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  }
	}
	
	// get employees list> reports
	public function get_employees_reports($company_id,$department_id,$designation_id) {
		  if($company_id==0 && $department_id==0 && $designation_id==0) {
		 	 return $query = $this->db->query("SELECT * FROM xin_employees");
		  } else if($company_id!=0 && $department_id==0 && $designation_id==0) {
		 	  $sql = 'SELECT * from xin_employees where company_id = ?';
			  $binds = array($company_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($company_id!=0 && $department_id!=0 && $designation_id==0) {
		 	  $sql = 'SELECT * from xin_employees where company_id = ? and department_id = ?';
			  $binds = array($company_id,$department_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else if($company_id!=0 && $department_id!=0 && $designation_id!=0) {
		 	  $sql = 'SELECT * from xin_employees where company_id = ? and department_id = ? and designation_id = ?';
			  $binds = array($company_id,$department_id,$designation_id);
			  $query = $this->db->query($sql, $binds);
			  return $query;
		  } else {
			  return $query = $this->db->query("SELECT * FROM xin_employees");
		  }
	}

	public function get_empolyees($status){
		$this->db->select('user_id as emp_id, first_name, last_name');
        if ($status == 1) {
            $this->db->where_in('status', $status);
        } else if ($status == 4){
            $this->db->where('status', $status);
        } else if($status == 5){
            $this->db->where_in('status', $status);
        } else if($status == 2 || $status == 3 || $status == 18){
            $this->db->where_in('status', [1,4,5]);
        }else {
            $this->db->where_in('status', $status);
        }
        $this->db->where('company_id', 1);
        $this->db->order_by('user_id', 'asc');
        return $result = $this->db->get('xin_employees')->result();
	}

	public function show_report($emp_ids,$status,$first_date=null,$second_date=null){
		// dd($status);
		$this->db->select('
			xin_employees.user_id,
			xin_employees.first_name,
			xin_employees.last_name,
			xin_departments.department_name,
			xin_designations.designation_name,
			(SELECT lead_employees.first_name FROM xin_employees AS lead_employees WHERE lead_employees.user_id = xin_employees.lead_user_id) AS lead_first_name,
			(SELECT lead_employees.last_name FROM xin_employees AS lead_employees WHERE lead_employees.user_id = xin_employees.lead_user_id) AS lead_last_name,
			xin_employees.email,
			xin_employees.contact_no,
			xin_employees.address,
			xin_employees.password,
            xin_employees.user_password,
			xin_employees.basic_salary,
			xin_employee_incre_prob.effective_date as last_incre_date,
			xin_employees.notify_incre_prob as next_incre_date,
			xin_employees.date_of_joining,
			DATEDIFF(NOW(), xin_employees.date_of_joining) AS duration,
		')
		->from('xin_employees')		
		->join('xin_departments','xin_employees.department_id = xin_departments.department_id','left')		
		->join('xin_designations','xin_employees.designation_id = xin_designations.designation_id','left')		
		->join('xin_employee_incre_prob','xin_employees.user_id = xin_employee_incre_prob.id','left')	
		->where_in('xin_employees.user_id',$emp_ids);

		if($status == 1){
			$this->db->where_in('xin_employees.status',[1,4,5]);	
			if($first_date != null && $second_date !=null){
				$this->db->where('xin_employees.date_of_joining between "' . $first_date . '" AND "' . $second_date . '"');
			}
			$this->db->order_by('xin_employees.date_of_joining','ASC');
		}

		if(($first_date != null && $second_date !=null) && $status == 2){
			$this->db->where('xin_employees.notify_incre_prob between "' . $first_date . '" AND "' . $second_date . '"');
			$this->db->order_by('xin_employees.notify_incre_prob','ASC');
		}


		if( $status == 3){
			$this->db->where('xin_employees.status',4);
			if($first_date != null && $second_date !=null){
				$this->db->where('xin_employees.date_of_joining between "' . $first_date . '" AND "' . $second_date . '"');
			}
			$this->db->order_by('xin_employees.date_of_joining','ASC');
		}

		if($status == 4){
			$this->db->where('xin_employees.status',5);
			if($first_date != null && $second_date !=null){
				$this->db->where('xin_employees.date_of_joining between "' . $first_date . '" AND "' . $second_date . '"');
			}
			$this->db->order_by('xin_employees.date_of_joining','ASC');
		}

		$data = $this->db->order_by('xin_employees.date_of_joining','ASC')->get()->result();
		// dd($data);
	    return $data;
	}


	public function late_report($emp_id,$key,$attendance_date,$second_date){
        $this->db->select('
            xin_employees.user_id as emp_id,
            xin_employees.employee_id,
            xin_employees.first_name,
            xin_employees.last_name,
            xin_employees.department_id,
            xin_employees.designation_id,
            xin_employees.date_of_joining,
            xin_departments.department_name,
            xin_designations.designation_name,
            xin_attendance_time.attendance_date as ad,
            xin_attendance_time.clock_in,
            xin_attendance_time.clock_out,
            xin_attendance_time.attendance_status,
            xin_attendance_time.status,
            xin_attendance_time.late_status
        ');

        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_attendance_time.late_status", 1);
        $this->db->where("xin_employees.is_active", 1);
		if($key==1){
			$this->db->where("xin_attendance_time.attendance_date", $attendance_date);
		}else if($key==2){
			$second_date = date('Y-m-d', strtotime("+6 days", strtotime($attendance_date)));
			$this->db->where("xin_attendance_time.attendance_date between '$attendance_date' and '$second_date'");
		}else{
			$this->db->where("xin_attendance_time.attendance_date between '$attendance_date' and '$second_date'");
		}
        $this->db->where_in("xin_attendance_time.employee_id", $emp_id);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');
        $this->db->order_by('xin_attendance_time.clock_in', "ASC");
        $data = $this->db->get()->result();
        if($data=='') {
			return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        } else {
            return $data; 
        }
    }

	public function show_meeting_report($emp_id,$key,$attendance_date,$second_date){
		// dd( $second_date);
		$this->db->select('empm.id, mr.title, 
							em.first_name, 
							em.last_name, 
							empm.employee_id AS emp_id, 
							empm.date, 
							empm.out_time, 
							empm.in_time, 
							empm.status,
							mp.address,
							desig.designation_name
						');
		$this->db->from('xin_employee_move_register as empm');
		$this->db->join('xin_employees as em', 'em.user_id = empm.employee_id');
		$this->db->join('xin_designations as desig', 'em.designation_id = desig.designation_id');
		$this->db->join('xin_employee_move_reason as mr', 'empm.reason = mr.id');
		$this->db->join('xin_employee_move_place as mp', 'empm.place_adress = mp.place_id');
		$this->db->where_in('empm.employee_id', $emp_id);
		if($key == 1){
			$this->db->where("empm.date between'$attendance_date' AND'$second_date'");
		}else if($key == 2){
			$this->db->where("empm.date between'$attendance_date' AND'$second_date'");
		}else{
			$this->db->where("empm.date between'$attendance_date' AND'$second_date'");
		}
		$this->db->order_by('empm.id', 'DESC');

		return $this->db->get()->result();
		// $d = $this->db->get()->result();
		// dd($this->db->last_query());
    }

   	public function get_product_reports_info($first_date=null,$second_date=null,$status,$emp_id){
		// dd($status);
        $this->db->select(' 
                    ap.id as a_id,
                    ap.cat_id,
                    ap.device_model,
                    ap.device_name_id,
                    ap.description,
                    ap.status,
                    ap.remark,
                    ap.number,
                    ap.user_id,
                    pac.cat_name,
                    pac.cat_short_name,
                    pam.model_name,
                    pam.image,
                    mobile_numbers.number,
                    xin_employees.first_name,
                    xin_employees.last_name,
        ');
        $this->db->from('product_accessories as ap');
        $this->db->join('product_accessories_model as pam',  'ap.device_model = pam.id', 'left');
        $this->db->join('product_accessory_categories as pac', 'ap.cat_id = pac.id', 'left');
        $this->db->join('mobile_numbers', 'ap.number = mobile_numbers.id', 'left');    
        $this->db->join('xin_employees', 'ap.user_id = xin_employees.user_id', 'left');
		if($status == 'all'){
			$this->db->where_in('ap.status',[1,2,3,4,5]);
		}else if($status == 'using'){
            $this->db->where_in('ap.user_id',$emp_id);
        	$this->db->order_by('ap.user_id',"ASC");
        }else if($status == 'store'){
            $this->db->where('ap.status',2);
        	$this->db->order_by('ap.id',"ASC");
        }else if($status == 'damage'){
            $this->db->where('ap.status',4);
        	$this->db->order_by('ap.id',"ASC");
        }else{
			$this->db->where('ap.cat_id',$status);
        	$this->db->order_by('ap.id',"ASC");
		}
		 
        $this->db->order_by('ap.status',"ASC");
        $this->db->group_by('ap.id');
        return $this->db->get()->result();  
    }
   	public function show_move_report($first_date=null,$second_date=null,$status,$emp_id){
		$this->db->select(' 
			xin_employees.first_name,
			xin_employees.last_name,
			move_list.*,
			product_accessories_model.model_name,
			product_accessory_categories.cat_name,
			product_accessory_categories.cat_short_name,
			product_accessories.device_name_id,
			xin_departments.department_name,
			xin_designations.designation_name,
        ');
        $this->db->from('move_list');
        $this->db->join('xin_employees', 'xin_employees.user_id = move_list.user_id', 'left');
        $this->db->join('product_accessories_model',  'product_accessories_model.id = move_list.device_id', 'left');
        $this->db->join('product_accessory_categories', 'product_accessories_model.cat_id = product_accessory_categories.id', 'left');
        $this->db->join('product_accessories', 'product_accessories.device_model = move_list.device_id', 'left');
        $this->db->join('xin_departments','xin_departments.department_id = xin_employees.department_id');
        $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
		$this->db->where_in('product_accessories.status',5);
        if($status == 'daily'){
			$this->db->where('move_list.created_at',$first_date);
		}	
		if($status == 'weekly'){
			$second_date = date('Y-m-d',strtotime('+6 days'.$first_date));
        	$this->db->where('move_list.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
        }
		if($status == 'monthly'){
			$this->db->where('move_list.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
        }
        $this->db->order_by('move_list.created_at',"ASC");
        return $this->db->get()->result();  
    }

	   	public function show_mobile_bill_report($first_date=null,$second_date=null,$status,$emp_id){
		$this->db->select(' 
			xin_employees.first_name,
			xin_employees.last_name,
			xin_departments.department_name,
			xin_designations.designation_name,
			mobile_bill_requisition.*
        ');
        $this->db->from('xin_employees');
        $this->db->join('xin_departments','xin_departments.department_id = xin_employees.department_id');
        $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
        $this->db->join('mobile_bill_requisition', 'mobile_bill_requisition.user_id = xin_employees.user_id');
		$this->db->where_in('xin_employees.status',[1,4,5]);
		if($status == 1){
			$this->db->where('mobile_bill_requisition.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
			$this->db->where('mobile_bill_requisition.status',1);
		}	
		if($status == 2){
			$this->db->where('mobile_bill_requisition.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
			$this->db->where('mobile_bill_requisition.status',2);
		}
		if($status == 3){
			$this->db->where('mobile_bill_requisition.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
			$this->db->where('mobile_bill_requisition.status',3);
		}
        return $this->db->get()->result();  
    }
	
	public function get_movement_reports_info($date){
        $this->db->select(' 
                    ap.id as a_id,
                    ap.cat_id,
                    ap.device_model,
                    ap.device_name_id,
                    ap.description,
                    ap.status,
                    ap.remark,
                    ap.number,
                    ap.user_id,
                    pac.cat_name,
                    pac.cat_short_name,
                    pam.model_name,
                    pam.image,
                    mobile_numbers.number,
                    xin_employees.first_name,
                    xin_employees.last_name,
        ');
        $this->db->from('product_accessories as ap');
        $this->db->join('product_accessories_model as pam',  'ap.device_model = pam.id', 'left');
        $this->db->join('product_accessory_categories as pac', 'ap.cat_id = pac.id', 'left');
        $this->db->join('mobile_numbers', 'ap.number = mobile_numbers.id', 'left');    
        $this->db->join('xin_employees', 'ap.user_id = xin_employees.user_id', 'left');
        $this->db->order_by('ap.status',"ASC");
        $this->db->group_by('ap.id');
        return $this->db->get()->result();  
    }

	public function leave_application($first_date=null,$second_date=null,$emp_id=null){
		$this->db->select('xin_employees.first_name,xin_departments.department_name,xin_designations.designation_name,xin_employees.last_name,xin_leave_applications.*');
		$this->db->from('xin_leave_applications');
		$this->db->join('xin_employees','xin_employees.user_id = xin_leave_applications.employee_id','left');
		$this->db->join('xin_departments','xin_departments.department_id = xin_employees.department_id','left');
		$this->db->join('xin_designations','xin_designations.designation_id = xin_employees.designation_id','left');
		if($emp_id !=null){
			$this->db->where_in('xin_leave_applications.employee_id',$emp_id);
		}
		if($first_date !='' && $second_date !=''){
			$this->db->where('xin_leave_applications.applied_on between "' . $first_date . '" AND "' . $second_date . '"');
		}
		$query = $this->db->order_by('xin_leave_applications.applied_on','ASC')->get()->result();
		// dd($query);
		return $query;
	}
}
?>