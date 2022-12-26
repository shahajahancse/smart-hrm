<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }

    public function attn_process($process_date, $status)
    {
        $attn_file = $this->db->where('upload_date', $process_date)->get('xin_att_file_upload')->num_rows();
        if ($attn_file == 0) {
            echo 'Please upload attendance file to process';
            exit;
        }

        $employees = $this->get_employees($status);
        foreach ($employees as $key => $row) {
            $emp_id      = $row->user_id;
            $shift_id = $row->shift_id;
            $in_time  = '';
            $out_time = '';
            $clock_in_out = 0;
            $late_status = 0;
            $lunch_late_status = 0;
            $early_out_status = 0;

            $shift_schedule  = $this->get_shift_schedule($emp_id, $process_date, $shift_id);
            $in_start_time   = $shift_schedule->in_start_time;
            $out_end_time    = $shift_schedule->out_end_time;
            $out_start_time  = $shift_schedule->out_start_time;
            $late_start_time = $shift_schedule->late_start;
            $lunch_time      = $shift_schedule->lunch_time;
            $lunch_minute    = $shift_schedule->lunch_minute;
            $ot_start_time   = $shift_schedule->ot_start_time;

            $start_time      = date("Y-m-d H:i:s", strtotime($process_date.' '.$in_start_time));
            $end_time        = date("Y-m-d H:i:s", strtotime($process_date.' '.$out_end_time));
            $out_start_time  = date("Y-m-d H:i:s", strtotime($process_date.' '.$out_start_time));
            $late_start_time = date("Y-m-d H:i:s", strtotime($process_date.' '.$late_start_time));

            $lunch_time      = date("Y-m-d H:i:s", strtotime($process_date.' '.$lunch_time));
            $lunch_start     = date('Y-m-d H:i:s', strtotime($lunch_time. ' -30 minutes'));
            $lunch_in        = date('Y-m-d H:i:s', strtotime($lunch_time. ' +'.$lunch_minute));
            $lunch_end       = date('Y-m-d H:i:s', strtotime($lunch_time. ' +30 minutes'));
            $lunch_late_time = date('Y-m-d H:i:s', strtotime($lunch_in. ' +5 minutes'));
            $early_out_time  = date("Y-m-d H:i:s", strtotime($process_date.' '.$ot_start_time));


            $proxi_id   = $this->get_proxi($emp_id);
            $in_time    = $this->check_in_out_time($proxi_id, $start_time, $end_time, 'ASC');
            $out_time   = $this->check_in_out_time($proxi_id, $out_start_time, $end_time, 'DESC');

            $lunch_out   = $this->check_in_out_time($proxi_id, $lunch_start, $lunch_in, 'ASC');
            $lunch_in    = $this->check_in_out_time($proxi_id, $lunch_time, $lunch_end, 'DESC');

            // check present status
            if ($in_time == '' && $out_time == '') {
                $status = 'Absent';
            } else {
                $status = 'Present';
            }

            if (strtotime($in_time) > strtotime($late_start_time)) {
                $late_status = 1; 
            }

            if (strtotime($lunch_in) > strtotime($lunch_late_time)) {
                $lunch_late_status = 1; 
            }

            if (strtotime($out_time) < strtotime($early_out_time) && strtotime($out_time) != null) {
                $early_out_status = 1; 
            }

            // dd($out_time .' '. $early_out_time .' '. $early_out_status);



            $data = array(
                'employee_id'       => $emp_id,
                'office_shift_id'   => 1,
                'attendance_date'   => $process_date,
                'clock_in'          => $in_time,
                'clock_out'         => $out_time,
                'lunch_in'          => $lunch_in,
                'lunch_out'         => $lunch_out,
                'attendance_status' => $status,
                'late_status'       => $late_status,
                'lunch_late_status' => $lunch_late_status,
                'early_out_status'  => $early_out_status,
            );

            $query = $this->db->where('employee_id',$emp_id)->where('attendance_date',$process_date)->get('xin_attendance_time');
            if($query->num_rows() > 0 ){
                $this->db->where('attendance_date', $process_date);
                $this->db->where('employee_id', $emp_id);
                $this->db->update('xin_attendance_time', $data);
            } else {
                $this->db->insert('xin_attendance_time', $data);
            }
        }
        return 'Successfully Insert Done';
    }


    function check_in_out_time($proxi_id, $start_time, $end_time, $order)
    {
        $date_time = '';
        $this->db->select("date_time");
        $this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
        $this->db->where("proxi_id", $proxi_id);
        $this->db->order_by("date_time",$order);
        $this->db->limit("1");
        $query = $this->db->get('xin_att_machine');

        if($query->num_rows() > 0 ){
            $date_time = $query->row()->date_time;
        } 
        return $date_time;
    }

    public function get_employees($status = null)
    {
        $this->db->select('user_id, office_shift_id as shift_id');
        if ($status != null) {
            $this->db->where('status',$status);
        }
        $this->db->where('company_id',1);
        // $this->db->where('user_id',34);
        return $this->db->get('xin_employees')->result();
    }

    public function get_shift_schedule($emp_id, $process_date = null, $shift_id = null)
    {
        $this->db->select("office_shift_id");
        $this->db->where("employee_id", $emp_id);
        $this->db->where("attendance_date", $process_date);
        $query = $this->db->get('xin_attendance_time');

        if($query->num_rows() > 0 ){
            $shift_id = $query->row()->office_shift_id;
        } 

        return $this->db->where('office_shift_id',$shift_id)->get('xin_office_shift')->row();
    }

    public function get_proxi($emp_id)
    {
        $this->db->select('proxi_id');
        $this->db->where('emp_id',$emp_id);
        return $this->db->get('xin_proxi')->row()->proxi_id;
    }


    public function daily_report($attendance_date, $status,$late_status=null)
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
        $this->db->where("xin_attendance_time.attendance_status", $status);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');
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
        $this->db->where('status',$status);
        $this->db->where('company_id',1);
        $this->db->order_by('user_id', 'asc');
        return $result = $this->db->get('xin_employees')->result();
        // dd($result);
    }
 

}
?>