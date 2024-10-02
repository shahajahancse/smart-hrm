<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Timesheet_model extends CI_Model
	{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	// get office shifts
	public function get_office_shifts() {
	  return $this->db->get("xin_office_shift");
	}

	// get all tasks
	public function get_tasks() {
	  return $this->db->get("xin_tasks");
	}

	// get all project tasks
	public function get_project_tasks($id) {
		$sql = 'SELECT * FROM xin_tasks WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get all project variations
	public function get_project_variations($id) {
		$sql = 'SELECT * FROM xin_project_variations WHERE project_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// check if check-in available
	public function attendance_first_in_check($employee_id,$attendance_date) {

		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ? and attendance_date = ? limit 1';
		$binds = array($employee_id,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get user attendance
	public function attendance_time_check($employee_id) {

		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ?';
		$binds = array($employee_id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

	// check if check-in available
	public function attendance_first_in($employee_id,$attendance_date) {

		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ? and attendance_date = ?';
		$binds = array($employee_id,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}

	// check if check-out available
	public function attendance_first_out_check($employee_id,$attendance_date) {

		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ? and attendance_date = ? order by time_attendance_id desc limit 1';
		$binds = array($employee_id,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get leave types
	public function all_leave_types() {
	  $query = $this->db->get("xin_leave_type");
	  return $query->result();
	}
	// get company offshifts
	public function get_company_shifts($company_id) {

		$sql = 'SELECT * FROM xin_office_shift WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get company holidays
	public function get_company_holidays($company_id) {

		$sql = 'SELECT * FROM xin_holidays WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// filter company holidays
	public function filter_company_holidays($company_id) {

		$sql = 'SELECT * FROM xin_holidays WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// filter company|status holidays
	public function filter_company_publish_holidays($company_id,$is_publish) {

		$sql = 'SELECT * FROM xin_holidays WHERE company_id = ? and is_publish = ?';
		$binds = array($company_id,$is_publish);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// filter company|status holidays
	public function filter_notcompany_publish_holidays($is_publish) {

		$sql = 'SELECT * FROM xin_holidays WHERE is_publish = ?';
		$binds = array($is_publish);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get company leaves
	public function get_company_leaves($company_id) {

		$sql = 'SELECT * FROM xin_leave_applications WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get multi company leaves
	public function get_multi_company_leaves($company_ids) {

		$sql = 'SELECT * FROM xin_leave_applications where company_id IN ?';
		$binds = array($company_ids);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get company tasks
	public function get_company_tasks($company_id) {

		$sql = 'SELECT * FROM xin_tasks WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get employee tasks
	public function get_employee_tasks($id) {

		$sql = "SELECT * FROM `xin_tasks` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// check if check-out available
	public function attendance_first_out($employee_id,$attendance_date) {

		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ? and attendance_date = ? order by time_attendance_id desc limit 1';
		$binds = array($employee_id,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}

	// get total hours work > attendance
	public function total_hours_worked_attendance($id,$attendance_date) {

		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ? and attendance_date = ? and total_work != ""';
		$binds = array($id,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get total rest > attendance
	public function total_rest_attendance($id,$attendance_date) {

		$sql = 'SELECT * FROM xin_attendance_time WHERE employee_id = ? and attendance_date = ? and total_rest != ""';
		$binds = array($id,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// check if holiday available
	public function holiday_date_check($attendance_date) {

		$sql = 'SELECT * FROM xin_holidays WHERE (start_date between start_date and end_date) or (start_date = ? or end_date = ?) limit 1';
		$binds = array($attendance_date,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get all leaves
	public function get_leaves($id = null) {
		if ($id != null) {
			$this->db->where("employee_id", $id);
		}
		return $this->db->order_by("leave_id", "DESC")->get("xin_leave_applications");
	}

	public function get_emplist() {
		return $this->db->get("xin_employees");
	}
	public function get_emplistforemp() {
	$this->db->where_in('status', [1, 4, 5]);// Replace "column1, column2, column3" with the actual columns you need
	return $this->db->get("xin_employees");
	}
	// get company leaves
	public function filter_company_leaves($company_id) {

		$sql = 'SELECT * FROM xin_leave_applications WHERE company_id = ?';
		$binds = array($company_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get company|employees leaves
	public function filter_company_employees_leaves($company_id,$employee_id) {

		$sql = 'SELECT * FROM xin_leave_applications WHERE company_id = ? and employee_id = ?';
		$binds = array($company_id,$employee_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get company|employees leaves
	public function filter_company_employees_status_leaves($company_id,$employee_id,$status) {

		$sql = 'SELECT * FROM xin_leave_applications WHERE company_id = ? and employee_id = ? and status = ?';
		$binds = array($company_id,$employee_id,$status);
		$query = $this->db->query($sql, $binds);
		return $query;
	}
	// get company|employees leaves
	public function filter_company_only_status_leaves($company_id,$status) {

		$sql = 'SELECT * FROM xin_leave_applications WHERE company_id = ? and status = ?';
		$binds = array($company_id,$status);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get all employee leaves
	public function get_employee_leaves($id) {

		$sql = 'SELECT * FROM xin_leave_applications WHERE employee_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// check if holiday available
	public function holiday_date($attendance_date) {

		$sql = 'SELECT * FROM xin_holidays WHERE (start_date between start_date and end_date) or (start_date = ? or end_date = ?) limit 1';
		$binds = array($attendance_date,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}

	// get all holidays
	public function get_holidays() {
	  return $this->db->get("xin_holidays");
	}

	// get all holidays>calendar
	public function get_holidays_calendar() {

		$sql = 'SELECT * FROM xin_holidays WHERE is_publish = ?';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get all leaves>calendar
	public function get_leaves_request_calendar() {
	  return $query = $this->db->query("SELECT * from xin_leave_applications");
	}

	// check if leave available
	public function leave_date_check($emp_id,$attendance_date) {

		$sql = 'SELECT * from xin_leave_applications where (from_date between from_date and to_date) and employee_id = ? or from_date = ? and to_date = ? limit 1';
		$binds = array($emp_id,$attendance_date,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// check if leave available
	public function leave_date($emp_id,$attendance_date) {

		$sql = 'SELECT * from xin_leave_applications where (from_date between from_date and to_date) and employee_id = ? or from_date = ? and to_date = ? limit 1';
		$binds = array($emp_id,$attendance_date,$attendance_date);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}

	// get total number of leave > employee
	public function count_total_leaves($leave_type_id,$employee_id) {

		//$sql = 'SELECT * FROM xin_leave_applications WHERE employee_id = ? and leave_type_id = ? and status = ? and created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)';
		$sql = 'SELECT * FROM xin_leave_applications WHERE employee_id = ? and leave_type_id = ? and status = ?';
		$binds = array($employee_id,$leave_type_id,2);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}


	public function count_total_leaves_month($leave_type_id,$employee_id) {

		//$sql = 'SELECT * FROM xin_leave_applications WHERE employee_id = ? and leave_type_id = ? and status = ? and created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)';
		$sql = 'SELECT * FROM xin_leave_applications WHERE  employee_id = ? and leave_type_id = ? and status = ?';
		$binds = array($employee_id,$leave_type_id,2);
		$query = $this->db->query($sql, $binds);

		return $query->result();
	}


	// get payroll templates > NOT USED
	public function attendance_employee_with_date($emp_id,$attendance_date) {

		$sql = 'SELECT * FROM xin_attendance_time where attendance_date = ? and employee_id = ?';
		$binds = array($attendance_date,$emp_id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	 // get record of office shift > by id
	 public function read_office_shift_information($id) {

		$sql = 'SELECT * FROM xin_office_shift WHERE office_shift_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get record of leave > by id
	public function read_leave_information($id) {

		$sql = 'SELECT * FROM xin_leave_applications WHERE leave_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get leave type by id
	public function read_leave_type_information($id) {

		$sql = 'SELECT * FROM xin_leave_type WHERE leave_type_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// Function to add record in table
	public function add_employee_attendance($data){
		$this->db->insert('xin_attendance_time', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_leave_record($data){
		$this->db->insert('xin_leave_applications', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_task_record($data){
		$this->db->insert('xin_tasks', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_project_variations($data){
		$this->db->insert('xin_project_variations', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_office_shift_record($data){
		$this->db->insert('xin_office_shift', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to add record in table
	public function add_holiday_record($data){
		$this->db->insert('xin_holidays', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// get record of task by id
	 public function read_task_information($id) {

		$sql = 'SELECT * FROM xin_tasks WHERE task_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}
	// get record of variation by id
	 public function read_variation_information($id) {

		$sql = 'SELECT * FROM xin_project_variations WHERE variation_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get record of holiday by id
	 public function read_holiday_information($id) {

		$sql = 'SELECT * FROM xin_holidays WHERE holiday_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// get record of attendance by id
	 public function read_attendance_information($id) {

		$sql = 'SELECT * FROM xin_attendance_time WHERE time_attendance_id = ? limit 1';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return null;
		}
	}

	// Function to Delete selected record from table
	public function delete_attendance_record($id){
		$this->db->where('time_attendance_id', $id);
		$this->db->delete('xin_attendance_time');

	}

	// Function to Delete selected record from table
	public function delete_task_record($id){
		$this->db->where('task_id', $id);
		$this->db->delete('xin_tasks');

	}
	// Function to Delete selected record from table
	public function delete_variation_record($id){
		$this->db->where('variation_id', $id);
		$this->db->delete('xin_project_variations');

	}

	// Function to Delete selected record from table
	public function delete_holiday_record($id){
		$this->db->where('holiday_id', $id);
		$this->db->delete('xin_holidays');

	}

	// Function to Delete selected record from table
	public function delete_shift_record($id){
		$this->db->where('office_shift_id', $id);
		$this->db->delete('xin_office_shift');

	}

	// Function to Delete selected record from table
	public function delete_leave_record($id){
		$this->db->where('leave_id', $id);
		$this->db->delete('xin_leave_applications');

	}

	// Function to update record in table
	public function update_task_record($data, $id){
		$this->db->where('task_id', $id);
		if( $this->db->update('xin_tasks',$data)) {
			return true;
		} else {
			return false;
		}
	}
	// Function to update record in table
	public function update_project_variations($data, $id){
		$this->db->where('variation_id', $id);
		if( $this->db->update('xin_project_variations',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_leave_record($data, $id){
		$this->db->where('leave_id', $id);
		if( $this->db->update('xin_leave_applications',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_holiday_record($data, $id){
		$this->db->where('holiday_id', $id);
		if( $this->db->update('xin_holidays',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_attendance_record($data, $id){
		$this->db->where('time_attendance_id', $id);
		if( $this->db->update('xin_attendance_time',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_shift_record($data, $id){
		$this->db->where('office_shift_id', $id);
		if( $this->db->update('xin_office_shift',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_default_shift_record($data, $id){
		$this->db->where('office_shift_id', $id);
		if( $this->db->update('xin_office_shift',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function update_default_shift_zero($data){
		$this->db->where("office_shift_id!=''");
		if( $this->db->update('xin_office_shift',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// Function to update record in table
	public function assign_task_user($data, $id){
		$this->db->where('task_id', $id);
		if( $this->db->update('xin_tasks',$data)) {
			return true;
		} else {
			return false;
		}
	}

	// get comments
	public function get_comments($id) {

		$sql = 'SELECT * FROM xin_tasks_comments WHERE task_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// get comments
	public function get_attachments($id) {

		$sql = 'SELECT * FROM xin_tasks_attachment WHERE task_id = ?';
		$binds = array($id);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// Function to add record in table > add comment
	public function add_comment($data){
		$this->db->insert('xin_tasks_comments', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// Function to Delete selected record from table
	public function delete_comment_record($id){
		$this->db->where('comment_id', $id);
		$this->db->delete('xin_tasks_comments');

	}

	// Function to Delete selected record from table
	public function delete_attachment_record($id){
		$this->db->where('task_attachment_id', $id);
		$this->db->delete('xin_tasks_attachment');

	}

	// Function to add record in table > add attachment
	public function add_new_attachment($data){
		$this->db->insert('xin_tasks_attachment', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// check user attendance
	public function check_user_attendance() {
		$today_date = date('Y-m-d');
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_attendance_time where `employee_id` = ? and `attendance_date` = ? order by time_attendance_id desc limit 1';
		$binds = array($session['user_id'],$today_date);
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// check user attendance
	public function check_user_attendance_clockout() {
		$today_date = date('Y-m-d');
		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_attendance_time where `employee_id` = ? and `attendance_date` = ? and clock_out = ? order by time_attendance_id desc limit 1';
		$binds = array($session['user_id'],$today_date,'');
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	//  set clock in- attendance > user
	public function add_new_attendance($data){
		$this->db->insert('xin_attendance_time', $data);
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	// get last user attendance
	public function get_last_user_attendance() {

		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_attendance_time where `employee_id` = ? order by time_attendance_id desc limit 1';
		$binds = array($session['user_id']);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}

	// get last user attendance > check if loged in-
	public function attendance_time_checks($id) {

		$session = $this->session->userdata('username');
		$sql = 'SELECT * FROM xin_attendance_time where `employee_id` = ? and clock_out = ? order by time_attendance_id desc limit 1';
		$binds = array($id,'');
		$query = $this->db->query($sql, $binds);

		return $query;
	}

	// Function to update record in table > update attendace.
	public function update_attendance_clockedout($data,$id){
		//$this->db->where("time_attendance_id!=''");
		$this->db->where('time_attendance_id', $id);
		if( $this->db->update('xin_attendance_time',$data)) {
			return true;
		} else {
			return false;
		}
	}
	// get employees > active
	public function get_xin_employees() {

		$sql = 'SELECT * FROM xin_employees WHERE is_active = ? and user_role_id!=1';
		$binds = array(1);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}

	// get all employee leaves>department wise
	public function get_employee_leaves_department_wise($department_id) {

		$sql = 'SELECT * FROM xin_leave_applications WHERE department_id = ?';
		$binds = array($department_id);
		$query = $this->db->query($sql, $binds);
		return $query;
	}

	// get total number of leave > employee
	public function employee_count_total_leaves($leave_type_id,$employee_id) {

		//$sql = 'SELECT * FROM xin_leave_applications WHERE employee_id = ? and leave_type_id = ? and status = ? and created_at >= DATE_SUB(NOW(),INTERVAL 1 YEAR)';
		$sql = 'SELECT * FROM xin_leave_applications WHERE employee_id = ? and leave_type_id = ? and status = ? and current_year = ?';
		$binds = array($employee_id,$leave_type_id,2,date("Y"));
		$query = $this->db->query($sql, $binds);

		return $query->num_rows();
	}

	// get total number of leave > employee
	public function employee_show_last_leave($employee_id,$leave_id) {
		$sql = "SELECT * FROM xin_leave_applications WHERE leave_id != '".$leave_id."' and employee_id = ? order by leave_id desc limit 1";
		$binds = array($employee_id);
		$query = $this->db->query($sql, $binds);
		return $query->result();
	}
	public function get_leaves_with_info($id = null) {



		$session = $this->session->userdata('username');
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		

		$lead=0;
		if($session['role_id'] == 3) {
			if($user_info[0]->is_emp_lead==2){
				$lead=2;
			}
		}






		$this->db->select("la.*, e.first_name, e.last_name,e.lead_user_id, lt.type_name, d.department_name, des.designation_name");
		$this->db->from("xin_leave_applications as la");
		$this->db->join("xin_employees as e", "e.user_id = la.employee_id", 'left');
		$this->db->join("xin_leave_type as lt", "lt.leave_type_id = la.leave_type_id", 'left');
		$this->db->join("xin_departments as d", "d.department_id = e.department_id", 'left');
		$this->db->join("xin_designations as des", "des.designation_id = e.designation_id", 'left');
		if ($id != null) {
			$this->db->where("la.employee_id", $id);
		}

		if($lead==2){
			$this->db->where("e.lead_user_id", $session['user_id']);
		}
		$data = $this->db->order_by("la.leave_id", "DESC")->get();
		return $data->result();
	}
	public function get_leaves_with_info_with_pagi($offset, $limit, $status) {
		$this->db->select("la.*, e.first_name, e.last_name, lt.type_name, d.department_name, des.designation_name");
		$this->db->from("xin_leave_applications as la");
		$this->db->join("xin_employees as e", "e.user_id = la.employee_id", 'left');
		$this->db->join("xin_leave_type as lt", "lt.leave_type_id = la.leave_type_id", 'left');
		$this->db->join("xin_departments as d", "d.department_id = e.department_id", 'left');
		$this->db->join("xin_designations as des", "des.designation_id = e.designation_id", 'left');
		$this->db->limit($limit, $offset);
		$this->db->where("la.status", $status);
		$data = $this->db->order_by("la.leave_id", "DESC")->get();
		return $data->result();
	}
	public function get_leaves_with_info_with_date($start_date, $end_date, $status=null) {
		$this->db->select("la.*, e.first_name, e.last_name, lt.type_name, d.department_name, des.designation_name");
		$this->db->from("xin_leave_applications as la");
		$this->db->join("xin_employees as e", "e.user_id = la.employee_id", 'left');
		$this->db->join("xin_leave_type as lt", "lt.leave_type_id = la.leave_type_id", 'left');
		$this->db->join("xin_departments as d", "d.department_id = e.department_id", 'left');
		$this->db->join("xin_designations as des", "des.designation_id = e.designation_id", 'left');
		$this->db->where("la.from_date BETWEEN '$start_date' AND '$end_date'");
		if(!$status==null){
			$this->db->where("la.status", $status);
		}
		$data = $this->db->order_by("la.leave_id", "DESC")->get();
		return $data->result();
	}
	public function get_leaves_leave_id_with_info($id = null) {
		$this->db->select("la.*, e.first_name, e.last_name,e.basic_salary,la.status, lt.type_name, d.department_name, des.designation_name");
		$this->db->from("xin_leave_applications as la");
		$this->db->join("xin_employees as e", "e.user_id = la.employee_id", 'left');
		$this->db->join("xin_leave_type as lt", "lt.leave_type_id = la.leave_type_id", 'left');
		$this->db->join("xin_departments as d", "d.department_id = e.department_id", 'left');
		$this->db->join("xin_designations as des", "des.designation_id = e.designation_id", 'left');
		$this->db->where("la.leave_id", $id);
		$data = $this->db->order_by("la.leave_id", "DESC")->get();
		return $data->row();
	}

	public function get_today_present($late_status,$status,$date)
    {
        $this->db->select('
            xin_employees.user_id as emp_id,
            xin_employees.first_name,
            xin_employees.last_name,
            xin_employees.department_id,
            xin_employees.designation_id,
            xin_employees.date_of_joining,
            xin_departments.department_name,
            xin_designations.designation_name,
            xin_attendance_time.attendance_date,
            xin_attendance_time.clock_in,
            xin_attendance_time.clock_out,
            xin_attendance_time.lunch_in,
            xin_attendance_time.lunch_out,
            xin_attendance_time.status,
            xin_attendance_time.late_status,
            xin_attendance_time.comment,
        ');

        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_attendance_time');
		if ($late_status == 1) {
			$this->db->where("xin_attendance_time.late_status", $late_status);
		}
        $this->db->where("xin_attendance_time.attendance_date", $date);
        $this->db->where_in("xin_employees.status", [1,4,5]);

        $this->db->where_in("xin_attendance_time.status", $status);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.is_active = "1"');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');
        $this->db->order_by('xin_attendance_time.clock_in', "ASC");
        $data = $this->db->get()->result();
        if($data) {
            return $data;
        } else {
           $data=[];
        }
    }

	public function get_today_leave($date)
    {
        $this->db->select('
            xin_employees.user_id as emp_id,
            xin_employees.first_name,
            xin_employees.last_name,
            xin_employees.department_id,
            xin_employees.designation_id,
            xin_employees.date_of_joining,
            xin_departments.department_name,
            xin_designations.designation_name,
            xin_leave_applications.status
        ');
        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
		$this->db->from('xin_leave_applications');
        $this->db->where("xin_employees.is_active", 1);
        $this->db->where("xin_leave_applications.status" , 2);
		$this->db->where('from_date >=', $date);
        $this->db->where('to_date <=', $date);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_leave_applications.employee_id');
        $data = $this->db->get()->result();
        if($data) {
            return $data;
        } else {
           $data=[];
        }
    }
	public function upcomming_intrn_prob_promo($first_date, $second_date,$status){

		$this->db->select('xin_employees.first_name,xin_employees.last_name,xin_employees.notify_incre_prob,xin_departments.department_name,xin_designations.designation_name,xin_employees.status');
		$this->db->from('xin_employees');
		$this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
		$this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
		$this->db->where('xin_employees.status', $status);
		$this->db->where('xin_employees.notify_incre_prob BETWEEN "'.$first_date.'" AND "'.$second_date.'"');
		$this->db->order_by('xin_employees.basic_salary', 'asc');
		return $this->db->get()->result();

	}
	public function upcomming_intrn_prob_promoo($first_date, $second_date,$status){

		$this->db->select('xin_employees.first_name,xin_employees.last_name,xin_employees.notify_incre_prob,xin_departments.department_name,xin_designations.designation_name,xin_employees.status');
		$this->db->from('xin_employees');
		$this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
		$this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
		$this->db->where('xin_employees.status', $status);

		$this->db->order_by('xin_employees.basic_salary', 'asc');
		if(!empty($first_date) && !empty($second_date)) {
			$this->db->where('xin_employees.notify_incre_prob BETWEEN "'.$first_date.'" AND "'.$second_date.'"');
		}

		$this->db->order_by('xin_employees.basic_salary', 'asc');
		return $this->db->get()->result();

	}
	public function extra_present_approval($first_date, $second_date){
	$this->db->select("xin_attendance_time.*, xin_employees.first_name, xin_employees.last_name,");
	$this->db->from("xin_attendance_time");
	$this->db->join("xin_employees", "xin_employees.user_id = xin_attendance_time.employee_id");
	$this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'");
	$this->db->where("xin_attendance_time.status","Off Day");
	$this->db->where("xin_employees.is_active", 1);
	$this->db->where_in("xin_attendance_time.attendance_status", ["Present"]);
	$this->db->group_by("xin_attendance_time.employee_id");
	$query = $this->db->get()->result();
	return $query;
    }
}
?>
