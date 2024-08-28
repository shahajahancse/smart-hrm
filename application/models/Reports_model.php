<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("Timesheet_model");
        $this->load->model("Attendance_model");
        $this->load->model("Inventory_model");
        $this->load->model("Reports_model");
        $this->load->model("Lunch_model");
        $this->load->model("Xin_model");
        $this->load->model("Job_card_model");
        $this->load->library('upload');

    }

    // get payslip list> reports
    public function get_payslip_list($cid, $eid, $re_date)
    {
        if ($eid == '' || $eid == 0) {

            $sql = 'SELECT * from xin_salary_payslips where salary_month = ? and company_id = ?';
            $binds = array($re_date, $cid);
            $query = $this->db->query($sql, $binds);

            return $query;
        } else {

            $sql = 'SELECT * from xin_salary_payslips where employee_id = ? and salary_month = ? and company_id = ?';
            $binds = array($eid, $re_date, $cid);
            $query = $this->db->query($sql, $binds);

            return $query;
        }
    }
    // get training list> reports
    public function get_training_list($cid, $sdate, $edate)
    {

        $sql = 'SELECT * from `xin_training` where company_id = ? and start_date >= ? and finish_date <= ?';
        $binds = array($cid, $sdate, $edate);
        $query = $this->db->query($sql, $binds);

        return $query;
    }
    // get leave list> reports
    public function get_leave_application_list()
    {

        $sql = 'SELECT * from `xin_leave_applications` group by employee_id';
        $query = $this->db->query($sql);
        return $query;
    }
    // get filter leave list> reports
    public function get_leave_application_filter_list($sd, $ed, $user_id, $company_id)
    {

        $sql = 'SELECT * from `xin_leave_applications` where company_id = ? and employee_id = ? and from_date >= ? and to_date <= ? group by employee_id';
        $binds = array($company_id, $user_id, $sd, $ed);
        $query = $this->db->query($sql, $binds);
        return $query;
    }

    // get pending leave list> reports
    public function get_pending_leave_application_list($employee_id)
    {

        $sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
        $binds = array($employee_id, 1);
        $query = $this->db->query($sql, $binds);
        return $query->num_rows();
    }
    // get approved leave list> reports
    public function get_approved_leave_application_list($employee_id)
    {

        $sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
        $binds = array($employee_id, 2);
        $query = $this->db->query($sql, $binds);
        return $query->num_rows();
    }
    // get upcoming leave list> reports
    public function get_upcoming_leave_application_list($employee_id)
    {

        $sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
        $binds = array($employee_id, 4);
        $query = $this->db->query($sql, $binds);
        return $query->num_rows();
    }
    // get rejected leave list> reports
    public function get_rejected_leave_application_list($employee_id)
    {

        $sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
        $binds = array($employee_id, 3);
        $query = $this->db->query($sql, $binds);
        return $query->num_rows();
    }
    // get only pending leave list> reports
    public function get_pending_leave_list($employee_id, $status)
    {

        $sql = 'SELECT * from `xin_leave_applications` where employee_id = ? and status = ?';
        $binds = array($employee_id, $status);
        $query = $this->db->query($sql, $binds);
        return $query;
    }
    // get project list> reports
    public function get_project_list($projId, $projStatus)
    {

        if ($projId == 0 && $projStatus == 'all') {
            return $query = $this->db->query("SELECT * FROM `xin_projects`");
        } else if ($projId == 0 && $projStatus != 'all') {
            $sql = 'SELECT * from `xin_projects` where status = ?';
            $binds = array($projStatus);
            $query = $this->db->query($sql, $binds);
            return $query;
        } else if ($projId != 0 && $projStatus == 'all') {
            $sql = 'SELECT * from `xin_projects` where project_id = ?';
            $binds = array($projId);
            $query = $this->db->query($sql, $binds);
            return $query;
        } else if ($projId != 0 && $projStatus != 'all') {
            $sql = 'SELECT * from `xin_projects` where project_id = ? and status = ?';
            $binds = array($projId, $projStatus);
            $query = $this->db->query($sql, $binds);
            return $query;
        }
    }
    // get employee projects
    public function get_employee_projectsx($id)
    {

        $sql = "SELECT * FROM `xin_projects` where assigned_to like '%$id,%' or assigned_to like '%,$id%' or assigned_to = '$id'";
        $binds = array($id);
        $query = $this->db->query($sql, $binds);
        return $query;
    }

    // get task list> reports
    public function get_task_list($taskId, $taskStatus)
    {

        if ($taskId == 0 && $taskStatus == 4) {
            return $query = $this->db->query("SELECT * FROM xin_tasks");
        } else if ($taskId == 0 && $taskStatus != 4) {
            $sql = 'SELECT * from xin_tasks where task_status = ?';
            $binds = array($taskStatus);
            $query = $this->db->query($sql, $binds);
            return $query;
        } else if ($taskId != 0 && $taskStatus == 4) {
            $sql = 'SELECT * from xin_tasks where task_id = ?';
            $binds = array($taskId);
            $query = $this->db->query($sql, $binds);
            return $query;
        } else if ($taskId != 0 && $taskStatus != 4) {
            $sql = 'SELECT * from xin_tasks where task_id = ? and task_status = ?';
            $binds = array($taskId, $taskStatus);
            $query = $this->db->query($sql, $binds);
            return $query;
        }
    }

    // get roles list> reports
    public function get_roles_employees($role_id)
    {
        if ($role_id == 0) {
            return $query = $this->db->query("SELECT * FROM xin_employees");
        } else {
            $sql = 'SELECT * from xin_employees where user_role_id = ?';
            $binds = array($role_id);
            $query = $this->db->query($sql, $binds);
            return $query;
        }
    }

    // get employees list> reports
    public function get_employees_reports($company_id, $department_id, $designation_id)
    {
        if ($company_id == 0 && $department_id == 0 && $designation_id == 0) {
            return $query = $this->db->query("SELECT * FROM xin_employees");
        } else if ($company_id != 0 && $department_id == 0 && $designation_id == 0) {
            $sql = 'SELECT * from xin_employees where company_id = ?';
            $binds = array($company_id);
            $query = $this->db->query($sql, $binds);
            return $query;
        } else if ($company_id != 0 && $department_id != 0 && $designation_id == 0) {
            $sql = 'SELECT * from xin_employees where company_id = ? and department_id = ?';
            $binds = array($company_id, $department_id);
            $query = $this->db->query($sql, $binds);
            return $query;
        } else if ($company_id != 0 && $department_id != 0 && $designation_id != 0) {
            $sql = 'SELECT * from xin_employees where company_id = ? and department_id = ? and designation_id = ?';
            $binds = array($company_id, $department_id, $designation_id);
            $query = $this->db->query($sql, $binds);
            return $query;
        } else {
            return $query = $this->db->query("SELECT * FROM xin_employees");
        }
    }

    public function get_empolyees($status)
    {
        $this->db->select('user_id as emp_id, first_name, last_name');
        if ($status == 1) {
            $this->db->where_in('status', $status);
        } else if ($status == 4) {
            $this->db->where('status', $status);
        } else if ($status == 5) {
            $this->db->where_in('status', $status);
        } else if ($status == 2 || $status == 3 || $status == 18) {
            $this->db->where_in('status', [1, 4, 5]);
        } else {
            $this->db->where_in('status', $status);
        }
        $this->db->where('company_id', 1);
        $this->db->order_by('user_id', 'asc');
        return $result = $this->db->get('xin_employees')->result();
    }

    public function all_done_report($emp_ids = null, $first_date = null, $second_date = null)
    {
        $this->db->select('
			xin_employees.user_id,
			xin_employees.first_name,
			xin_employees.last_name,
			xin_employees.email,
			xin_employees.contact_no,
			xin_employees.address,
			xin_employees.note_file,
			xin_employees.remark,
            xin_employees.user_password,
			xin_employees.basic_salary,
			xin_employees.notify_incre_prob as next_incre_date,
			xin_employees.date_of_joining,
			xin_employees.status,

			xin_departments.department_name,
			xin_designations.designation_name,

			xin_employee_incre_prob.status as instatus,
			xin_employee_incre_prob.old_salary,
			xin_employee_incre_prob.new_salary,
			xin_employee_incre_prob.effective_date as last_incre_date,
		')
            ->from('xin_employees')
            ->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id', 'left')
            ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id', 'left')
            ->join('xin_employee_incre_prob', 'xin_employees.user_id = xin_employee_incre_prob.emp_id', 'left');

        if (!empty($emp_ids)) {
            $this->db->where_in('xin_employees.user_id', $emp_ids);
        }
        $this->db->where_in('xin_employees.status', array(1, 4, 5));
        $this->db->where('xin_employee_incre_prob.effective_date between "' . $first_date . '" AND "' . $second_date . '"');
        $this->db->order_by('xin_employee_incre_prob.effective_date', 'DESC');
        $this->db->group_by('xin_employees.user_id');
        $data = $this->db->get()->result();
        return $data;
    }

    public function all_pending_report($emp_ids = null, $first_date = null, $second_date = null)
    {

        $this->db->select('
			xin_employees.user_id,
			xin_employees.first_name,
			xin_employees.last_name,
			xin_employees.email,
			xin_employees.contact_no,
			xin_employees.address,
			xin_employees.note_file,
			xin_employees.remark,
            xin_employees.user_password,
			xin_employees.basic_salary,
			xin_employees.notify_incre_prob as next_incre_date,
			xin_employees.date_of_joining,
			xin_employees.status,

			xin_departments.department_name,
			xin_designations.designation_name,

			xin_employee_incre_prob.old_salary,
			xin_employee_incre_prob.new_salary,
			xin_employee_incre_prob.effective_date as last_incre_date,
		')
            ->from('xin_employees')
            ->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id', 'left')
            ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id', 'left')
            ->join('xin_employee_incre_prob', 'xin_employees.user_id = xin_employee_incre_prob.emp_id', 'left');

        if (!empty($emp_ids)) {
            $this->db->where_in('xin_employees.user_id', $emp_ids);
        }
        $this->db->where_in('xin_employees.status', array(1, 4, 5));
        $this->db->where('xin_employees.notify_incre_prob between "' . $first_date . '" AND "' . $second_date . '"');
        $this->db->order_by('xin_employee_incre_prob.effective_date', 'DESC');
        $this->db->group_by('xin_employees.user_id');
        $data = $this->db->get()->result();
        return $data;
    }

    public function done_inc_pro_prb_report($emp_ids = null, $status = null, $first_date = null, $second_date = null)
    {

        $this->db->select('
			xin_employees.user_id,
			xin_employees.first_name,
			xin_employees.last_name,
			xin_employees.email,
			xin_employees.contact_no,
			xin_employees.address,
			xin_employees.note_file,
			xin_employees.remark,
            xin_employees.user_password,
			xin_employees.basic_salary,
			xin_employees.notify_incre_prob as next_incre_date,
			xin_employees.date_of_joining,
			xin_employees.status,

			xin_departments.department_name,
			xin_designations.designation_name,

			xin_employee_incre_prob.old_salary,
			xin_employee_incre_prob.new_salary,
			xin_employee_incre_prob.effective_date as last_incre_date,
		')
            ->from('xin_employees')
            ->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id', 'left')
            ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id', 'left')
            ->join('xin_employee_incre_prob', 'xin_employees.user_id = xin_employee_incre_prob.emp_id', 'left');

        $this->db->where_in('xin_employees.user_id', $emp_ids);
        $this->db->where('xin_employee_incre_prob.status', $status);
        $this->db->where('xin_employee_incre_prob.effective_date between "' . $first_date . '" AND "' . $second_date . '"');

        $this->db->order_by('xin_employee_incre_prob.effective_date', 'DESC');
        $this->db->group_by('xin_employees.user_id');
        $data = $this->db->get()->result();
        return $data;
    }

    public function pending_inc_pro_prb_report($emp_ids = null, $status = null, $first_date = null, $second_date = null)
    {

        $this->db->select('
			xin_employees.user_id,
			xin_employees.first_name,
			xin_employees.last_name,
			xin_employees.email,
			xin_employees.contact_no,
			xin_employees.address,
			xin_employees.note_file,
			xin_employees.remark,
            xin_employees.user_password,
			xin_employees.basic_salary,
			xin_employees.notify_incre_prob as next_incre_date,
			xin_employees.date_of_joining,
			xin_employees.status,

			xin_departments.department_name,
			xin_designations.designation_name,

			xin_employee_incre_prob.old_salary,
			xin_employee_incre_prob.new_salary,
			xin_employee_incre_prob.effective_date as last_incre_date,
		')
            ->from('xin_employees')
            ->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id', 'left')
            ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id', 'left')
            ->join('xin_employee_incre_prob', 'xin_employees.user_id = xin_employee_incre_prob.emp_id', 'left');

        $this->db->where_in('xin_employees.user_id', $emp_ids);
        $this->db->where('xin_employees.status', $status);
        $this->db->where('xin_employees.notify_incre_prob between "' . $first_date . '" AND "' . $second_date . '"');

        $this->db->order_by('xin_employee_incre_prob.effective_date', 'DESC');
        $this->db->group_by('xin_employees.user_id');
        $data = $this->db->get()->result();
        return $data;
    }

    public function show_report($emp_ids = null, $status = null, $first_date = null, $second_date = null)
    {

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
			xin_employees.note_file,
			xin_employees.remark,
            xin_employees.user_password,
			xin_employees.basic_salary,
			xin_employees.status,
			xin_employee_incre_prob.old_salary,
			xin_employee_incre_prob.new_salary,
			xin_employee_incre_prob.effective_date as last_incre_date,
			xin_employees.notify_incre_prob as next_incre_date,
			xin_employees.date_of_joining,
			DATEDIFF(NOW(), xin_employees.date_of_joining) AS duration,
		')
            ->from('xin_employees')
            ->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id', 'left')
            ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id', 'left')
            ->join('xin_employee_incre_prob', 'xin_employees.user_id = xin_employee_incre_prob.emp_id', 'left');

        if ($emp_ids != null) {
            $this->db->where_in('xin_employees.user_id', $emp_ids);
        }

        if ($status == 1) {
            //$this->db->where_in('xin_employees.status', [1, 4, 5]);
            if ($first_date != null && $second_date != null) {
                $this->db->where('xin_employees.date_of_joining between "' . $first_date . '" AND "' . $second_date . '"');
            }
            $this->db->order_by('xin_employees.date_of_joining', 'ASC');
        }

        if (($first_date != null && $second_date != null) && $status == 2) {

            $this->db->where('xin_employees.notify_incre_prob between "' . $first_date . '" AND "' . $second_date . '"');
        }

        if ($status == 3) {
            $this->db->where('xin_employees.status', 4);
            if ($first_date != null && $second_date != null) {
                $this->db->where('xin_employees.notify_incre_prob between "' . $first_date . '" AND "' . $second_date . '"');
            }
        }

        if ($status == 4) {
            $this->db->where('xin_employees.status', 5);
            if ($first_date != null && $second_date != null) {
                $this->db->where('xin_employees.notify_incre_prob between "' . $first_date . '" AND "' . $second_date . '"');
            }
        }

        $this->db->group_by('xin_employees.user_id');
        $this->db->order_by('xin_employee_incre_prob.effective_date', 'DESC');
        $data = $this->db->get()->result();
        return $data;
    }

    public function late_report($emp_id, $key, $attendance_date, $second_date)
    {
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
        if ($key == 1) {
            $this->db->where("xin_attendance_time.attendance_date", $attendance_date);
        } else if ($key == 2) {
            $second_date = date('Y-m-d', strtotime("+6 days", strtotime($attendance_date)));
            $this->db->where("xin_attendance_time.attendance_date between '$attendance_date' and '$second_date'");
        } else {
            $this->db->where("xin_attendance_time.attendance_date between '$attendance_date' and '$second_date'");
        }
        $this->db->where_in("xin_attendance_time.employee_id", $emp_id);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');
        $this->db->order_by('xin_attendance_time.clock_in', "ASC");
        $data = $this->db->get()->result();
        if ($data == '') {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        } else {
            return $data;
        }
    }

    public function show_meeting_report($emp_id, $key, $attendance_date, $second_date)
    {
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
        if ($key == 1) {
            $this->db->where("empm.date between'$attendance_date' AND'$second_date'");
        } else if ($key == 2) {
            $this->db->where("empm.date between'$attendance_date' AND'$second_date'");
        } else {
            $this->db->where("empm.date between'$attendance_date' AND'$second_date'");
        }
        $this->db->order_by('empm.id', 'DESC');

        return $this->db->get()->result();
        // $d = $this->db->get()->result();
        // dd($this->db->last_query());
    }

    public function get_product_reports_info($first_date = null, $second_date = null, $status = 'all', $emp_id = null)
    {
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
        $this->db->join('product_accessories_model as pam', 'ap.device_model = pam.id', 'left');
        $this->db->join('product_accessory_categories as pac', 'ap.cat_id = pac.id', 'left');
        $this->db->join('mobile_numbers', 'ap.number = mobile_numbers.id', 'left');
        $this->db->join('xin_employees', 'ap.user_id = xin_employees.user_id', 'left');
        if ($status == 'all') {
            $this->db->where_in('ap.status', [1, 2, 3, 4, 5]);
        } else if ($status == 'using') {
            $this->db->where_in('ap.user_id', $emp_id);
            $this->db->order_by('ap.user_id', "ASC");
        } else if ($status == 'store') {
            $this->db->where('ap.status', 2);
            $this->db->order_by('ap.id', "ASC");
        } else if ($status == 'damage') {
            $this->db->where('ap.status', 4);
            $this->db->order_by('ap.id', "ASC");
        } else {
            $this->db->where('ap.cat_id', $status);
            $this->db->order_by('ap.id', "ASC");
        }

        $this->db->order_by('ap.status', "ASC");
        $this->db->group_by('ap.id');
        return $this->db->get()->result();
    }

    public function device_report(){
        $data['desktop'] =$this->db->select('xin_emp_desktop.*, xin_employees.user_id,xin_employees.first_name, xin_employees.last_name')
                                   ->from('xin_employees')
                                   ->join('xin_emp_desktop','xin_emp_desktop.user_id = xin_employees.user_id')
                                   ->group_by('xin_emp_desktop.id')
                                   ->order_by('xin_emp_desktop.pc_no')
                                   ->get()->result();
        $data['laptop'] =$this->db->select('xin_emp_laptop.*, xin_employees.user_id,xin_employees.first_name, xin_employees.last_name')
                 ->from('xin_employees')
                 ->join('xin_emp_laptop','xin_emp_laptop.user_id = xin_employees.user_id')
                 ->group_by('xin_emp_laptop.id')
                 ->order_by('xin_emp_laptop.laptop_no')
                 ->get()->result();         
        return $data;
    }
    public function show_store_report(){
        $data['desktop'] =$this->db->select('xin_emp_desktop.*, xin_employees.user_id,xin_employees.first_name, xin_employees.last_name')
                 ->from('xin_emp_desktop,xin_employees')
                 ->where('xin_emp_desktop.status',2)
                 ->group_by('xin_emp_desktop.id')
                 ->order_by('xin_emp_desktop.pc_no')
                 ->get()->result();   
        $data['laptop'] =$this->db->select('xin_emp_laptop.*, xin_employees.user_id,xin_employees.first_name, xin_employees.last_name')
            ->from('xin_emp_laptop,xin_employees')
            ->where('xin_emp_laptop.status',2)
            ->group_by('xin_emp_laptop.id')
            ->order_by('xin_emp_laptop.laptop_no')
            ->get()->result();           
        // dd($data);               
        return $data;
    }
    public function show_damage_report(){
        $data['laptop'] =$this->db->select('xin_emp_laptop.*, xin_employees.user_id,xin_employees.first_name, xin_employees.last_name')
                 ->from('xin_emp_laptop,xin_employees')
                 ->where('xin_emp_laptop.status',3)
                 ->group_by('xin_emp_laptop.id')
                 ->get()->result();   
        // dd($data);               
        return $data;
    }
    public function show_move_report($first_date = null, $second_date = null, $status = null, $emp_id = null)
    {
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
        $this->db->join('product_accessories_model', 'product_accessories_model.id = move_list.device_id', 'left');
        $this->db->join('product_accessory_categories', 'product_accessories_model.cat_id = product_accessory_categories.id', 'left');
        $this->db->join('product_accessories', 'product_accessories.device_model = move_list.device_id', 'left');
        $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
        $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
        $this->db->where_in('product_accessories.status', 5);

        if ($status == 'daily') {
            $this->db->where('move_list.created_at', $first_date);
        }
        if ($status == 'weekly') {
            $second_date = date('Y-m-d', strtotime('+6 days' . $first_date));
            $this->db->where('move_list.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
        }
        if ($status == 'monthly') {
            $this->db->where('move_list.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
        }

        $this->db->order_by('move_list.created_at', "ASC");
        return $this->db->get()->result();
    }

    public function show_mobile_bill_report($first_date = null, $second_date = null, $status, $emp_id)
    {
        $this->db->select('
			xin_employees.first_name,
			xin_employees.last_name,
			xin_departments.department_name,
			xin_designations.designation_name,
			mobile_bill_requisition.*
        ');
        $this->db->from('xin_employees');
        $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
        $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
        $this->db->join('mobile_bill_requisition', 'mobile_bill_requisition.user_id = xin_employees.user_id');
        $this->db->where_in('xin_employees.status', [1, 4, 5]);
        if ($status == 1) {
            $this->db->where('mobile_bill_requisition.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
            $this->db->where('mobile_bill_requisition.status', 1);
        }
        if ($status == 2) {
            $this->db->where('mobile_bill_requisition.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
            $this->db->where('mobile_bill_requisition.status', 2);
        }
        if ($status == 3) {
            $this->db->where('mobile_bill_requisition.created_at between  "' . $first_date . '" AND "' . $second_date . '"');
            $this->db->where('mobile_bill_requisition.status', 3);
        }
        return $this->db->get()->result();
    }

    public function get_movement_reports_info($date)
    {
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
        $this->db->join('product_accessories_model as pam', 'ap.device_model = pam.id', 'left');
        $this->db->join('product_accessory_categories as pac', 'ap.cat_id = pac.id', 'left');
        $this->db->join('mobile_numbers', 'ap.number = mobile_numbers.id', 'left');
        $this->db->join('xin_employees', 'ap.user_id = xin_employees.user_id', 'left');
        $this->db->order_by('ap.status', "ASC");
        $this->db->group_by('ap.id');
        return $this->db->get()->result();
    }
    public function get_product_reports_info_2($status = 'all')
    {
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
        $this->db->join('product_accessories_model as pam', 'ap.device_model = pam.id', 'left');
        $this->db->join('product_accessory_categories as pac', 'ap.cat_id = pac.id', 'left');
        $this->db->join('mobile_numbers', 'ap.number = mobile_numbers.id', 'left');
        $this->db->join('xin_employees', 'ap.user_id = xin_employees.user_id', 'left');

        if ($status == 'all') {
            $this->db->where_in('ap.status', [1, 2, 3, 4, 5]);
        } else if ($status == 'working') {
            $this->db->where('ap.status', 1);
        } else if ($status == 'store') {
            $this->db->where('ap.status', 2);
        }  else if ($status == 'servicing') {
            $this->db->where('ap.status', 3);
        }  else if ($status == 'damage') {
            $this->db->where('ap.status', 4);
        } else {
            $this->db->where('ap.cat_id', 5);
            $this->db->order_by('ap.id', "ASC");
        }

        $this->db->order_by('ap.status', "ASC");
        $this->db->group_by('ap.id');
        return $this->db->get()->result();
    }
    public function leave_application($first_date = null, $second_date = null, $emp_id = null)
    {
        $this->db->select('xin_employees.first_name,xin_departments.department_name,xin_designations.designation_name,xin_employees.last_name,xin_leave_applications.*');
        $this->db->from('xin_leave_applications');
        $this->db->join('xin_employees', 'xin_employees.user_id = xin_leave_applications.employee_id', 'left');
        $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id', 'left');
        $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
        if ($emp_id != null) {
            $this->db->where_in('xin_leave_applications.employee_id', $emp_id);
        }
        if ($first_date != '' && $second_date != '') {
            $this->db->where('xin_leave_applications.applied_on between "' . $first_date . '" AND "' . $second_date . '"');
        }
        $query = $this->db->order_by('xin_leave_applications.applied_on', 'ASC')->get()->result();
        // dd($query);
        return $query;
    }
    public function get_job_card($emp_id, $first_date, $second_date)
    {

        $this->db->select('
				xin_employees.user_id,
				xin_employees.first_name,
				xin_employees.last_name,
				xin_departments.department_name,
				xin_designations.designation_name,
			');
        $this->db->from('xin_employees');
        $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
        $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
        $this->db->where('xin_employees.user_id', $emp_id);
        $info = $this->db->get()->row();
        $emp_data = $this->Job_card_model->emp_job_card($first_date, $second_date, $emp_id);
        $attendance_data = [];
        $leave_count = 0;
        $present_count = 0;
        $holiday_count = 0;
        $extrap_count = 0;
        $att_status = '';
        $day_off_count = 0;
        $late_count = 0;
        $perror_count = 0;
        $early_count = 0;
        $absent_count = 0;
        foreach ($emp_data['emp_data'] as $key => $row) {

            if ($row->status == 'Leave') {
                $leave_type = $this->Job_card_model->get_leave_type($row->attendance_date, $emp_id);
                $att_status = $leave_type;
                $leave_count++;
            } elseif ($row->status == 'Hleave') {
                $leave_type = $this->Job_card_model->get_leave_type($row->attendance_date, $emp_id);
                $att_status = $leave_type;
                $leave_count = $leave_count + 0.5;

                if ($row->attendance_status == 'HalfDay' && $row->status == 'Hleave') {
                    $att_status = $leave_type . '  + HalfDay';
                    $present_count = $present_count + 0.5;
                }
            } elseif ($row->status == 'Holiday') {
                $att_status = "Holiday";
                $holiday_count++;
                if ($row->attendance_status == 'Present' && $row->status == 'Holiday') {
                    $extrap_count = $extrap_count + 1;
                    $att_status = '(Holiday + P)';
                } else {
                    $row->clock_in = "";
                    $row->clock_out = "";
                }

            } elseif ($row->status == 'Off Day') {
                $att_status = "Day Off";
                $day_off_count++;
                if ($row->attendance_status == 'Present' && $row->status == 'Off Day') {
                    $extrap_count = $extrap_count + 1;
                    $att_status = '(Off Day + P)';
                } else {
                    $row->clock_in = "";
                    $row->clock_out = "";
                }

            } else if ($row->attendance_status == 'HalfDay' && $row->status == 'HalfDay') {
                $present_count = $present_count + 0.5;
                $att_status = 'HalfDay';
                $absent_count = $absent_count + 0.5;
            } elseif (($row->clock_in != '' && $row->clock_out != '')) {
                $att_status = "P";
                $present_count++;
                if ($row->attendance_status == 'Meeting') {
                    $att_status = 'Meeting';
                }
            } elseif ($row->clock_in != '' || $row->clock_out != '') {
                $att_status = "P(Error)";
                $perror_count++;
            } else {
                $att_status = "A";
                $absent_count++;
            }
            $part_data = [];

            $part_data['attendance_date'] = $row->attendance_date;

            if ($row->clock_in == "") {
                $part_data['clock_in'] = " ";
            } else {
                $part_data['clock_in'] = date('h:i:s a', strtotime($row->clock_in));
            }
            if ($row->clock_out == "") {
                $part_data['clock_out'] = "&nbsp;";
            } else {
                $part_data['clock_out'] = date('h:i:s a', strtotime($row->clock_out));
            }

            if ($row->late_status == 1) {
                $late_count++;
                $part_data['late'] = 'late';
            } else {
                $part_data['late'] = '';
            }

            $part_data['lunch_in'] = $row->lunch_out != null ? date('h:i:s a', strtotime($row->lunch_out)) : '';

            $part_data['lunch_out'] = $row->lunch_in != null ? date('h:i:s a', strtotime($row->lunch_in)) : '';

            $part_data['att_status'] = $att_status;
            $attendance_data[$key] = $part_data;

        }
        $all_data['info'] = $info;
        $all_data['attendance_data'] = $attendance_data;
        $all_data['leave_count'] = $leave_count;
        $all_data['present_count'] = $present_count;
        $all_data['holiday_count'] = $holiday_count;
        $all_data['extrap_count'] = $extrap_count;
        return $all_data;
    }
    public function get_extra_present($first_date, $second_date)
    {
        $this->db->select('xin_attendance_time.* , xin_employees.first_name, xin_employees.last_name');
        $this->db->from('xin_attendance_time');
        $this->db->join('xin_employees', 'xin_employees.user_id = xin_attendance_time.employee_id');
        $this->db->where('xin_attendance_time.attendance_date >=', $first_date);
        $this->db->where('xin_attendance_time.attendance_date <=', $second_date);
        $this->db->where('xin_attendance_time.attendance_status', 'Present');
        $this->db->where('xin_attendance_time.status', 'Off Day');
        // $this->db->group_by('xin_attendance_time.employee_id');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_leave_report($emp_id, $first_date, $second_date, $status)
    {

        $this->db->select('xin_leave_applications.*, xin_employees.first_name, xin_employees.last_name');
        $this->db->from('xin_leave_applications');
        $this->db->join('xin_employees', 'xin_employees.user_id = xin_leave_applications.employee_id');
        $this->db->where('xin_leave_applications.from_date >=', $first_date);
        $this->db->where('xin_leave_applications.to_date <=', $second_date);
        $this->db->where('xin_leave_applications.status', $status);
        $this->db->where_in('xin_leave_applications.employee_id', $emp_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_attendence_report($emp_id, $first_date, $second_date, $status)
    {

        $this->db->select('xin_attendance_time.*, xin_employees.first_name, xin_employees.last_name');
        $this->db->from('xin_attendance_time');
        $this->db->join('xin_employees', 'xin_employees.user_id = xin_attendance_time.employee_id');
        $this->db->where("xin_attendance_time.attendance_date between '$first_date' and '$second_date'");

        if ($status == 'Present') {
            $this->db->where('xin_attendance_time.status', 'Present');
        } elseif ($status == 'Absent') {
            $this->db->where('xin_attendance_time.status', 'Absent');
        } elseif ($status == 'Late') {
            $this->db->where('xin_attendance_time.status', 'Present');
            $this->db->where('xin_attendance_time.late_status', 1);
        } elseif ($status == 'Early Out') {
            $this->db->where('xin_attendance_time.status', 'Present');
            $this->db->where('xin_attendance_time.early_out_status', 1);
        }

        $this->db->where_in('xin_attendance_time.employee_id', $emp_id);
        $query = $this->db->get();
        return $query->result();
    }
    //wrong
    public function get_requisition_report($first_date, $second_date, $status)
    {
        $this->db->select("
        xin_employees.first_name,
        xin_employees.last_name,
        products.product_name,
        products_requisition_details.*
    ")
            ->from("products_requisition_details")
            ->join('xin_employees', 'products_requisition_details.user_id = xin_employees.user_id', 'left')
            ->join('products', 'products_requisition_details.product_id = products.id', 'left')
            ->where_in('products_requisition_details.status', $status)
            ->where("products_requisition_details.created_at between '$first_date' and '$second_date'")
            ->group_by('products_requisition_details.id')
            ->order_by('products_requisition_details.id', 'desc');
        return $this->db->get()->result();

    }
    public function get_store_in_report($first_date, $second_date, $status=null)
    {
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
        $this->db->where("p.created_at between '$first_date' and '$second_date'");
        if ($status != null) {
            $this->db->where('p.status', $status);
        }else{     
            $this->db->where('p.status', 3);
        }
        return $this->db->get()->result();
    }
    public function get_store_out_report($first_date, $second_date)
    {
        $this->db->select("
        xin_employees.first_name,
        xin_employees.last_name,
        products.product_name,
        products_requisition_details.*
    ")
            ->from("products_requisition_details")
            ->join('xin_employees', 'products_requisition_details.user_id = xin_employees.user_id', 'left')
            ->join('products', 'products_requisition_details.product_id = products.id', 'left')
            ->where_in('products_requisition_details.status', 3)
            ->where("products_requisition_details.created_at between '$first_date' and '$second_date'")
            ->group_by('products_requisition_details.id')
            ->order_by('products_requisition_details.id', 'desc');
        return $this->db->get()->result();

    }
    public function leave_report_monthly_all_employee($date)
    {
        $employee_id = [];
        $first_date = date('Y-m-01', strtotime($date));
        $second_date = date('Y-m-t', strtotime($date));

        $this->db->select('xin_leave_applications.employee_id');
        $this->db->from('xin_leave_applications');
        $this->db->where('xin_leave_applications.from_date between "' . $first_date . '" AND "' . $second_date . '"');
        $query = $this->db->order_by('xin_leave_applications.applied_on', 'ASC')->get()->result();
        foreach ($query as $key => $value) {
            if (!in_array($value->employee_id, $employee_id)) {
                $employee_id[] = $value->employee_id;
            }
        }
        $data = [];

        foreach ($employee_id as $key => $value) {
            $data[$key] = new stdClass(); // Initialize $data[$key] with an empty object
            $this->db->select('
			   xin_employees.user_id as employee_id,
			   xin_employees.first_name,
			   xin_employees.last_name,
			   xin_employees.department_id,
			   xin_employees.designation_id,
			   xin_employees.date_of_joining,
			   xin_departments.department_name,
			   xin_designations.designation_name,
		   ');
            $this->db->from('xin_employees');
            $this->db->from('xin_departments');
            $this->db->from('xin_designations');
            $this->db->where("xin_employees.user_id", $value);
            $this->db->where('xin_employees.department_id = xin_departments.department_id');
            $this->db->where('xin_employees.designation_id = xin_designations.designation_id');

            $r = $this->db->get()->row();
            $l = [];
            $year = date('Y', strtotime($first_date));
            $leave_data_balance = cals_leave($value, $year);
            if (empty($leave_data_balance)) {
                $l['leave_totalel'] = 0;
                $l['leave_totalsl'] = 0;
                $l['leave_calel'] = 0;
                $l['leave_calel_percent'] = 0;
                $l['leave_calsl'] = 0;
                $l['leave_calls_percent'] = 0;
                $l['leave_calls_percent'] = 0;
            } else {
                $l['leave_totalel'] = floatval($leave_data_balance->el_total);
                $l['leave_totalsl'] = floatval($leave_data_balance->sl_total);
                $l['leave_calel'] = floatval($leave_data_balance->el_balanace);
                if (floatval($leave_data_balance->el_total) != 0) {
                    $l['leave_calel_percent'] = (floatval($leave_data_balance->el_total) - floatval($leave_data_balance->el_balanace)) * 100 / floatval($leave_data_balance->el_total);
                } else {
                    $l['leave_calel_percent'] = 0;
                }
                $l['leave_calsl'] = floatval($leave_data_balance->sl_balanace);
                $l['leave_calls_percent'] = 0;
                if (floatval($leave_data_balance->sl_total) != 0) {
                    $l['leave_calls_percent'] = (floatval($leave_data_balance->sl_total) - floatval($leave_data_balance->sl_balanace)) * 100 / floatval($leave_data_balance->sl_total);
                }
            }
            $data[$key]->employee_data = $r; // Access object property directly
            $data[$key]->employee_data->leave_data = $l; // Access object property directly
        }
        return $data;
    }
    public function leave_report_monthly_single_employee($employee_id, $date)
    {
        $data = [];
        $first_date = date('Y-m-01', strtotime($date));
        $second_date = date('Y-m-t', strtotime($date));
        $this->db->select('xin_leave_applications.*');
        $this->db->from('xin_leave_applications');
        $this->db->where('xin_leave_applications.from_date between "' . $first_date . '" AND "' . $second_date . '"');
        $this->db->where('xin_leave_applications.employee_id', $employee_id);
        $leave_data = $this->db->order_by('xin_leave_applications.applied_on', 'ASC')->get()->result();
        $this->db->select('
			   xin_employees.first_name,
			   xin_employees.last_name,
			   xin_employees.department_id,
			   xin_employees.designation_id,
			   xin_employees.date_of_joining,
			   xin_departments.department_name,
			   xin_designations.designation_name,
		   ');
        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->where("xin_employees.user_id", $employee_id);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $r = $this->db->get()->row();
        $l = [];
        $year = date('Y', strtotime($first_date));
        $leave_data_balance = cals_leave($employee_id, $year);
        if (empty($leave_data_balance)) {
            $l['leave_totalel'] = 0;
            $l['leave_totalsl'] = 0;
            $l['leave_calel'] = 0;
            $l['leave_calel_percent'] = 0;
            $l['leave_calsl'] = 0;
            $l['leave_calls_percent'] = 0;
            $l['leave_calls_percent'] = 0;
        } else {
            $l['leave_totalel'] = floatval($leave_data_balance->el_total);
            $l['leave_totalsl'] = floatval($leave_data_balance->sl_total);
            $l['leave_calel'] = floatval($leave_data_balance->el_balanace);
            if (floatval($leave_data_balance->el_total) != 0) {
                $l['leave_calel_percent'] = (floatval($leave_data_balance->el_total) - floatval($leave_data_balance->el_balanace)) * 100 / floatval($leave_data_balance->el_total);
            } else {
                $l['leave_calel_percent'] = 0;
            }
            $l['leave_calsl'] = floatval($leave_data_balance->sl_balanace);
            $l['leave_calls_percent'] = 0;
            if (floatval($leave_data_balance->sl_total) != 0) {
                $l['leave_calls_percent'] = (floatval($leave_data_balance->sl_total) - floatval($leave_data_balance->sl_balanace)) * 100 / floatval($leave_data_balance->sl_total);
            }
        }
        $data['employee_data'] = $r;
        $data['leave_details'] = $l;
        $data['leave_data'] = $leave_data;
        return $data;
    }
    public function leave_report_yearly_all_employee($date)
    {
        $employee_id = [];
        $first_date = date('Y-m-01', strtotime($date));
        $second_date = date('Y-12-t', strtotime($date));

        $this->db->select('xin_leave_applications.employee_id');
        $this->db->from('xin_leave_applications');
        $this->db->where('xin_leave_applications.from_date between "' . $first_date . '" AND "' . $second_date . '"');
        $query = $this->db->order_by('xin_leave_applications.applied_on', 'ASC')->get()->result();
        foreach ($query as $key => $value) {
            if (!in_array($value->employee_id, $employee_id)) {
                $employee_id[] = $value->employee_id;
            }
        }
        $data = [];

        foreach ($employee_id as $key => $value) {
            $data[$key] = new stdClass(); // Initialize $data[$key] with an empty object
            $this->db->select('
			   xin_employees.user_id as employee_id,
			   xin_employees.first_name,
			   xin_employees.last_name,
			   xin_employees.department_id,
			   xin_employees.designation_id,
			   xin_employees.date_of_joining,
			   xin_departments.department_name,
			   xin_designations.designation_name,
		   ');
            $this->db->from('xin_employees');
            $this->db->from('xin_departments');
            $this->db->from('xin_designations');
            $this->db->where("xin_employees.user_id", $value);
            $this->db->where('xin_employees.department_id = xin_departments.department_id');
            $this->db->where('xin_employees.designation_id = xin_designations.designation_id');

            $r = $this->db->get()->row();
            $l = [];
            $year = date('Y', strtotime($first_date));
            $leave_data_balance = cals_leave($value, $year);
            if (empty($leave_data_balance)) {
                $l['leave_totalel'] = 0;
                $l['leave_totalsl'] = 0;
                $l['leave_calel'] = 0;
                $l['leave_calel_percent'] = 0;
                $l['leave_calsl'] = 0;
                $l['leave_calls_percent'] = 0;
                $l['leave_calls_percent'] = 0;
            } else {
                $l['leave_totalel'] = floatval($leave_data_balance->el_total);
                $l['leave_totalsl'] = floatval($leave_data_balance->sl_total);
                $l['leave_calel'] = floatval($leave_data_balance->el_balanace);
                if (floatval($leave_data_balance->el_total) != 0) {
                    $l['leave_calel_percent'] = (floatval($leave_data_balance->el_total) - floatval($leave_data_balance->el_balanace)) * 100 / floatval($leave_data_balance->el_total);
                } else {
                    $l['leave_calel_percent'] = 0;
                }
                $l['leave_calsl'] = floatval($leave_data_balance->sl_balanace);
                $l['leave_calls_percent'] = 0;
                if (floatval($leave_data_balance->sl_total) != 0) {
                    $l['leave_calls_percent'] = (floatval($leave_data_balance->sl_total) - floatval($leave_data_balance->sl_balanace)) * 100 / floatval($leave_data_balance->sl_total);
                }
            }
            $data[$key]->employee_data = $r; // Access object property directly
            $data[$key]->employee_data->leave_data = $l; // Access object property directly
        }
        return $data;
    }
    public function leave_report_yearly_single_employee($employee_id, $date)
    {
        $data = [];
        $first_date = date('Y-m-01', strtotime($date));
        $second_date = date('Y-12-t', strtotime($date));
        $this->db->select('xin_leave_applications.*');
        $this->db->from('xin_leave_applications');
        $this->db->where('xin_leave_applications.from_date between "' . $first_date . '" AND "' . $second_date . '"');
        $this->db->where('xin_leave_applications.employee_id', $employee_id);
        $leave_data = $this->db->order_by('xin_leave_applications.applied_on', 'ASC')->get()->result();
        $this->db->select('
			   xin_employees.first_name,
			   xin_employees.last_name,
			   xin_employees.department_id,
			   xin_employees.designation_id,
			   xin_employees.date_of_joining,
			   xin_departments.department_name,
			   xin_designations.designation_name,
		   ');
        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->where("xin_employees.user_id", $employee_id);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $r = $this->db->get()->row();
        $l = [];
        $year = date('Y', strtotime($first_date));
        $leave_data_balance = cals_leave($employee_id, $year);
        if (empty($leave_data_balance)) {
            $l['leave_totalel'] = 0;
            $l['leave_totalsl'] = 0;
            $l['leave_calel'] = 0;
            $l['leave_calel_percent'] = 0;
            $l['leave_calsl'] = 0;
            $l['leave_calls_percent'] = 0;
            $l['leave_calls_percent'] = 0;
        } else {
            $l['leave_totalel'] = floatval($leave_data_balance->el_total);
            $l['leave_totalsl'] = floatval($leave_data_balance->sl_total);
            $l['leave_calel'] = floatval($leave_data_balance->el_balanace);
            if (floatval($leave_data_balance->el_total) != 0) {
                $l['leave_calel_percent'] = (floatval($leave_data_balance->el_total) - floatval($leave_data_balance->el_balanace)) * 100 / floatval($leave_data_balance->el_total);
            } else {
                $l['leave_calel_percent'] = 0;
            }
            $l['leave_calsl'] = floatval($leave_data_balance->sl_balanace);
            $l['leave_calls_percent'] = 0;
            if (floatval($leave_data_balance->sl_total) != 0) {
                $l['leave_calls_percent'] = (floatval($leave_data_balance->sl_total) - floatval($leave_data_balance->sl_balanace)) * 100 / floatval($leave_data_balance->sl_total);
            }
        }
        $data['employee_data'] = $r;
        $data['leave_details'] = $l;
        $data['leave_data'] = $leave_data;
        return $data;
    }

}
