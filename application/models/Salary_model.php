<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }

    public function salary_process($process_month, $grid_emp_id, $status=null)
    {
        
        set_time_limit(0);
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);

        $num_of_days = date("t", strtotime($process_month));
        $first_date  = date("Y-m-d", strtotime($process_month));
        $end_date    = date("Y-m", strtotime($process_month)).'-'.$num_of_days;

        $get_employee = $this->get_employee_info($grid_emp_id);

        foreach ($get_employee as $key => $row) {
            $emp_id          = $row->user_id;
            $doj             = $row->date_of_joining;
            $department_id   = $row->department_id;
            $designation_id  = $row->designation_id;
            $salary          = $row->salary;
            

            //=======PRESENT STATUS======
            $join_left_resign = 0;
            $salary_month = trim(substr($end_date,0,7));
            $join_month = trim(substr($doj,0,7));
            $resign_check   = $this->resign_check($emp_id, $first_date, $end_date);
            $left_check     = $this->left_check($emp_id, $first_date, $end_date);

            if($resign_check != false and $salary_month == $join_month)
            {
                $resign_after_absent = $this->get_days($resign_check['resign_date'],$end_date);
                $doj_before_absent = $this->get_days($first_date, $doj);

                $before_after_absent = ($resign_after_absent-1)+($doj_before_absent-1);
                $join_left_resign = $num_of_days - $before_after_absent;
            }
            elseif($left_check != false and $salary_month == $join_month)
            {
                $total_days = $left_check['left_day'];
                $doj_before_absent = $this->get_days($first_date, $doj);
                $resign_after_absent = $this->get_days($left_check['left_date'],$end_date);

                $before_after_absent = ($doj_before_absent-1)+($resign_after_absent-1);
                $join_left_resign = $num_of_days - $before_after_absent;
            }
            elseif($resign_check != false)
            {
                $total_days = $resign_check['resign_day'];
                $resign_after_absent = $this->get_days($resign_check['resign_date'],$end_date);

                $before_after_absent = $resign_after_absent-1;
                $join_left_resign = $num_of_days - $before_after_absent;
            }
            elseif($left_check != false)
            {
                $total_days = $left_check['left_day'];
                $resign_after_absent = $this->get_days($left_check['left_date'],$end_date);

                $before_after_absent = $resign_after_absent-1;
                $join_left_resign = $num_of_days - $before_after_absent;
            }
            elseif($salary_month == $join_month)
            {
                $search_date = $doj;
                $doj_before_absent = $this->get_days($first_date, $doj);

                $before_after_absent = $doj_before_absent -1;
                $join_left_resign = $num_of_days - $before_after_absent;
                $total_days = $num_of_days;
            }
            else
            {
                $search_date = $first_date;
                $before_after_absent = 0;
                $total_days = $num_of_days;
            }

            $late_count = $this->attendance_count_status($emp_id,1,$first_date,$end_date,"late_status");
            $extra_p = $this->attendance_count_status($emp_id,"Present",$first_date,$end_date,'attendance_status');
            $meeting = $this->attendance_count_status($emp_id,"Meeting",$first_date,$end_date,'attendance_status');
            $rows = $this->count_attendance_status_wise($emp_id,$first_date,$end_date);
            $leave = $this->leave_count_status($emp_id, $first_date,$end_date);

            $extra_attend = ($extra_p + $meeting) - $rows->attend;
            $present = $num_of_days - ($leave->el + $leave->sl + $rows->weekend + $rows->holiday + $rows->absent);

            //=======PRESENT STATUS======

            //======= salary calculation here ==========//
            $perday_salary = round($salary / $num_of_days);

            // absent deduction
            $absent_deduct = 0; 
            $absent_deduct = $perday_salary * $rows->absent;

            // late deduction
            $late_deduct = 0;
            if ($late_count > 2) {
                $late_deduct = $perday_salary;
            }

            // extra pay salary 
            $extra_pay = 0;
            $extra_pay = $perday_salary * $extra_attend;


            // pay salary 
            $pay_salary = $salary - ($late_deduct + $absent_deduct);


            $data = array(
                'employee_id' => $emp_id,
                'department_id' => $department_id,
                'designation_id' => $designation_id,
                'company_id' => 1,
                'location_id' => 1,
                'salary_month' => $salary_month,
                'basic_salary' => $salary,

                'present' => $present,
                'extra_p' => $extra_attend,
                'absent' => $rows->absent,
                'holiday' => $rows->holiday,
                'weekend' => $rows->weekend ,
                'earn_leave' => ($leave->el != null) ? $leave->el:0,
                'sick_leave' => ($leave->sl != null) ? $leave->sl:0,

                'late_count' => $late_count,
                'late_deduct' => $late_deduct,
                'absent_deduct' => $absent_deduct,
                'modify_salary' => 0,
                'other_payment' => $extra_pay,
                'net_salary' => $pay_salary,
                'grand_net_salary' => ($pay_salary + $extra_pay),

                'wages_type' => 1,
                'is_half_monthly_payroll' => 0,
                'total_commissions' => 0,
                'total_statutory_deductions' => 0,
                'total_allowances' => 0,
                'total_loan' => 0,
                'total_overtime' => 0,
                'is_payment' => '1',
                'status' => '0',
                'payslip_type' => 'full_monthly',
                'payslip_key' =>  random_string('alnum', 40),
                'year_to_date' => date('d-m-Y'),
                'created_at' => date('d-m-Y h:i:s')
            );

            $query = $this->db->where('salary_month',$salary_month)->where('employee_id',$emp_id)->get('xin_salary_payslips');
            if ($query->num_rows() > 0) {
                $data['modify_salary'] = $query->row()->modify_salary;
                
                $this->db->where('payslip_id', $query->row()->payslip_id);
                $this->db->update('xin_salary_payslips',$data);
            } else {
                $this->db->insert('xin_salary_payslips', $data);
            }
        }
        return 'Successfully Insert Done';
    }


    function leave_count_status($emp_id,$start_date,$end_date)
    {

        $this->db->select("
                SUM(CASE WHEN leave_type = 'el' THEN qty ELSE 0 END ) AS el,
                SUM(CASE WHEN leave_type = 'sl' THEN qty ELSE 0 END ) AS sl
            ");
        $this->db->where("employee_id",$emp_id);
        $this->db->where("from_date >=", $start_date);
        $this->db->where("to_date <=", $end_date);
        $query = $this->db->get('xin_leave_applications');
        return $query->row();
    }

    function attendance_count_status($emp_id,$present_status,$FS_on_date,$FS_off_date, $fields)
    {
        $this->db->select('employee_id');
        $this->db->where('employee_id',$emp_id);
        $this->db->where($fields, $present_status);
        $this->db->where("attendance_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
        $query = $this->db->get('xin_attendance_time');
        // dd($query);
        return $query->num_rows();
    }

    function count_attendance_status_wise($emp_id,$FS_on_date,$FS_off_date)
    {

        $this->db->select("
                SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END ) AS attend,
                SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END ) AS absent,
                SUM(CASE WHEN status = 'Off Day' THEN 1 ELSE 0 END ) AS weekend,
                SUM(CASE WHEN status = 'Holiday' THEN 1 ELSE 0 END ) AS holiday, 
            ");

        $this->db->where('employee_id',$emp_id);
        $this->db->where("attendance_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
        $query = $this->db->get('xin_attendance_time');
        // dd($query);
        return $query->row();
    }

    function get_days($from, $to)
    {
        $first_date = strtotime($from);
        $second_date = strtotime($to);
        $offset = $second_date - $first_date;
        $total_days = floor($offset/60/60/24);
        return $total_days + 1;
    }

    function resign_check($emp_id, $FS_on_date, $FS_off_date)
    {
        $this->db->select('resign_date');
        $this->db->where('emp_id', $emp_id);
        $this->db->where("resign_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
        $query = $this->db->get('xin_employee_resign');
        if($query->num_rows() == 0)
        {
            return false;
        }
        else
        {
            $data = array();
            $data['resign_date'] = $query->row()->resign_date;
            $data['resign_day'] = substr($data['resign_date'], 8,2);
            return $data;
        }
    }

    function left_check($emp_id, $FS_on_date, $FS_off_date)
    {
        $this->db->select('left_date');
        $this->db->where('emp_id', $emp_id);
        $this->db->where("left_date BETWEEN '$FS_on_date' AND '$FS_off_date'");
        $query = $this->db->get('xin_employee_left');
        if($query->num_rows() == 0)
        {
            return false;
        }
        else
        {
            $data = array();
            $data['left_date'] = $query->row()->left_date;
            $data['left_day'] = substr($data['left_date'], 8,2);
            return $data;
        }
    }

    public function get_employee_info($emp_ids = null)
    {
        $this->db->select('
                xin_employees.user_id, 
                xin_employees.employee_id, 
                xin_employees.first_name, 
                xin_employees.last_name, 
                xin_employees.date_of_joining, 
                xin_employees.department_id,  
                xin_employees.designation_id,
                xin_employees.basic_salary as salary,
            ');

        $this->db->from('xin_employees');
        $this->db->where('xin_employees.company_id',1);
        $this->db->where_in('xin_employees.user_id',$emp_ids);
        // $this->db->where('xin_employees.user_id',37);
        return $this->db->get()->result();
    }












    public function daily_report($attendance_date, $emp_id, $status = null, $late_status=null)
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
            xin_attendance_time.attendance_date,
            xin_attendance_time.clock_in,
            xin_attendance_time.clock_out,
            xin_attendance_time.attendance_status,
            xin_attendance_time.late_status,
        ');

        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_attendance_time');

        if ($late_status != null && $late_status != 0 && $late_status != '') {
            $this->db->where("xin_attendance_time.late_status", 1);
        }

        $this->db->where("xin_employees.is_active", 1);
        $this->db->where("xin_attendance_time.attendance_date", $attendance_date);
        $this->db->where("xin_attendance_time.status", $status);
        $this->db->where_in("xin_attendance_time.employee_id", $emp_id);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');
        $this->db->order_by('xin_attendance_time.clock_in', "ASC");
        $data = $this->db->get()->result();
    
        if($data)
        {
            return $data;
        }
        else
        {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }



    public function lunch_report($attendance_date,$emp_id,$status=null,$late_status=null)
    {
        // dd($late_status);

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
            xin_attendance_time.attendance_date,
            xin_attendance_time.attendance_status,
            xin_attendance_time.lunch_in,
            xin_attendance_time.lunch_out,
            xin_attendance_time.lunch_late_status,
        ');


        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_employees.is_active", 1);
        if ($late_status != null && $late_status != 0 && $late_status != '') {
            $this->db->where("xin_attendance_time.lunch_late_status", 1);
        }
        $this->db->where("xin_attendance_time.attendance_date", $attendance_date);
  
        $this->db->where_in("xin_attendance_time.employee_id", $emp_id);
        $this->db->where("xin_attendance_time.attendance_status", "Present");
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');
        $data = $this->db->get()->result();
        // dd($data);
  
        if($data)
        {
            return $data;
        }
        else
        {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }


   
    public function early_out_report($attendance_date,$emp_id,$status)
    {
        
        // dd($out_time);
        // $out_time= $this->db->select('ot_start_time')->from('xin_office_shift')->get()->result();
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
            xin_attendance_time.attendance_date,
            xin_attendance_time.attendance_status,
            xin_attendance_time.clock_in,
            xin_attendance_time.clock_out,
            xin_attendance_time.early_out_status,
        ');

       

        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_employees.is_active", 1);
        $this->db->where("xin_attendance_time.attendance_date", $attendance_date);
        $this->db->where_in("xin_attendance_time.employee_id", $emp_id);
        $this->db->where_in("xin_attendance_time.early_out_status", 1);
        $this->db->where("xin_attendance_time.attendance_status", "Present");
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');


        $data = $this->db->get()->result();
        // dd($data);
  
        if($data)
        {
            return $data;
        }
        else
        {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }

    public function  movement_report($attendance_date,$emp_id)
    {
        

        $this->db->select('
            xin_employee_move_register.employee_id,
            xin_employee_move_register.date,
            xin_employee_move_register.out_time,
            xin_employee_move_register.in_time,
            xin_employee_move_register.reason,
            xin_employees.employee_id,
            xin_employees.first_name,
            xin_employees.last_name,
           
        ');

        $this->db->from('xin_employees');
        $this->db->from('xin_employee_move_register');
        $this->db->where_in("xin_employee_move_register.employee_id", $emp_id);
        $this->db->where("xin_employee_move_register.date", $attendance_date);
        $this->db->where("xin_employees.is_active", 1);
        $this->db->where('xin_employee_move_register.employee_id = xin_employees.user_id');
        $data = $this->db->get()->result();
        // dd($data);
  
        if($data)
        {
            return $data;
        }
        else
        {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }

    public function get_movement_register($id = null)
    {
        $this->db->select('
                empm.id, em.first_name, em.last_name, empm.employee_id as emp_id, empm.date, empm.out_time, empm.in_time, empm.reason, empm.status
            ');

        $this->db->from('xin_employee_move_register as empm');
        $this->db->from('xin_employees as em');

        if ($id != null) {
            $this->db->where('empm.employee_id',$id);
        }

        $this->db->where('em.user_id = empm.employee_id');
        $this->db->order_by('user_id', 'DESC');
        return $result = $this->db->get()->result();
    }













    public function get_employee_ajax_request($status)
    {
        $this->db->select('user_id as emp_id, first_name, last_name');
        $this->db->where('status',$status);
        $this->db->where('company_id',1);
        $this->db->order_by('user_id', 'asc');
        return $result = $this->db->get('xin_employees')->result();
        // dd($result);
    }

}
?>