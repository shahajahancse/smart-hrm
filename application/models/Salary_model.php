<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }

    public function salary_process($process_month, $grid_emp_id)
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

            //=======PRESENT STATUS ======
            /*$late_count = $this->attendance_count_status($emp_id,1,$first_date,$end_date,"late_status");
            $extra_p = $this->attendance_count_status($emp_id,"Present",$first_date,$end_date,'attendance_status');
            $meeting = $this->attendance_count_status($emp_id,"Meeting",$first_date,$end_date,'attendance_status');*/
            $rows = $this->count_attendance_status_wise($emp_id,$first_date,$end_date);
            $leave = $this->leave_count_status($emp_id, $first_date,$end_date);

            $present = $rows->attend + $rows->HalfDay;
            $leaves = $leave->el + $leave->sl;
            $extra_attend = $rows->extra_p;
            // $extra_attend = ($rows->extra_p + $rows->meeting) - $rows->attend;
            $absent = $num_of_days - ($leaves + $rows->weekend + $rows->holiday + $present);
            // dd($rows);
            //=======PRESENT STATUS END======

            //======= salary calculation here ==========//
            $perday_salary = round($salary / $num_of_days);

            // absent deduction
            $absent_deduct = 0; 
            $absent_deduct = $perday_salary * $absent;

            // late deduction
            $late_deduct = 0;
            if ($rows->late_status > 2) {
                $late = floor($rows->late_status / 3);
                $late_deduct = $perday_salary / $late;
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
                'absent' => $absent,
                'holiday' => $rows->holiday,
                'weekend' => $rows->weekend ,
                'earn_leave' => ($leave->el != null) ? $leave->el:0,
                'sick_leave' => ($leave->sl != null) ? $leave->sl:0,

                'late_count' => $rows->late_status,
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
            // dd($data);

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
    // this method not used 06-04-2023
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
                SUM(CASE WHEN status = 'Present'  THEN 1 ELSE 0 END ) AS attend,
                SUM(CASE WHEN status = 'Absent'   THEN 1 ELSE 0 END ) AS absent,
                SUM(CASE WHEN status = 'Off Day'  THEN 1 ELSE 0 END ) AS weekend,
                SUM(CASE WHEN status = 'Holiday'  THEN 1 ELSE 0 END ) AS holiday,  
                SUM(CASE WHEN attendance_status = 'HalfDay'  THEN 0.5 ELSE 0 END ) AS HalfDay, 
                SUM(CASE WHEN attendance_status = 'Present' THEN 1 ELSE 0 END ) AS extra_p, 
                SUM(CASE WHEN late_status = '1' THEN 1 ELSE 0 END ) AS late_status, 
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

    // salary sheet excel report
    public function salary_sheet_excel($salary_month, $emp_id, $status = null)
    {
        $this->db->select('
            sp.payslip_id,
            sp.employee_id as emp_id,
            sp.department_id,
            sp.designation_id,
            em.employee_id,
            em.first_name,
            em.last_name,
            em.date_of_joining,
            xin_departments.department_name,
            xin_designations.designation_name,
            xin_employee_bankaccount.account_number,

            sp.salary_month,
            sp.basic_salary,
            sp.present,
            sp.extra_p,
            sp.absent,
            sp.holiday,
            sp.weekend,
            sp.earn_leave,
            sp.sick_leave,
            sp.late_count,
            sp.late_deduct,
            sp.absent_deduct,
            sp.other_payment as extra_pay,
            sp.modify_salary,
            sp.net_salary,
            sp.grand_net_salary,
        ');

        $this->db->from('xin_salary_payslips as sp');
        $this->db->from('xin_employees as  em');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_employee_bankaccount');

        /*if ($status != null && $status != 0 && $status != '') {
            $this->db->where("xin_attendance_time.status", $status);
        }*/

        $this->db->where("sp.salary_month", $salary_month);
        $this->db->where_in("sp.employee_id", $emp_id);

        $this->db->where('sp.employee_id = em.user_id');
        $this->db->where('sp.department_id = xin_departments.department_id');
        $this->db->where('sp.designation_id = xin_designations.designation_id');
        $this->db->where('sp.employee_id = xin_employee_bankaccount.employee_id');

        $this->db->group_by('sp.employee_id');
        $this->db->order_by('sp.basic_salary', "DESC");
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



















    public function get_employee_ajax_request($status)
    {
        $this->db->select('user_id as emp_id, first_name, last_name');
        if ($status == 1) {
            $this->db->where_in('status', array(1,4));
        } else {
            $this->db->where('status',$status);
        }
        // $this->db->where('status',$status);
        $this->db->where('company_id',1);
        $this->db->order_by('user_id', 'asc');
        return $result = $this->db->get('xin_employees')->result();
        // dd($result);
    }

}
?>