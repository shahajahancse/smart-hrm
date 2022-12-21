<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }

    public function attn_process($process_date, $status)
    {
        $employees = $this->get_employees($status);
        foreach ($employees as $key => $row) {
            $emp_id      = $row->user_id;
            $shift_id = $row->shift_id;
            $in_time  = '';
            $out_time = '';
            $clock_in_out = 0;
            $late_status = 0;

            $shift_schedule  = $this->get_shift_schedule($emp_id, $process_date, $shift_id);
            $in_start_time   = $shift_schedule->in_start_time;
            $out_end_time    = $shift_schedule->out_end_time;
            $out_start_time  = $shift_schedule->out_start_time;
            $late_start_time = $shift_schedule->late_start;
            $ot_start_time   = $shift_schedule->ot_start_time;

            $start_time      = date("Y-m-d H:i:s", strtotime($process_date.' '.$in_start_time));
            $end_time        = date("Y-m-d H:i:s", strtotime($process_date.' '.$out_end_time));
            $out_start_time  = date("Y-m-d H:i:s", strtotime($process_date.' '.$out_start_time));
            $late_start_time = date("Y-m-d H:i:s", strtotime($process_date.' '.$late_start_time));

            $proxi_id   = $this->get_proxi($emp_id);
            $in_time    = $this->check_in_out_time($proxi_id, $start_time, $end_time, 'ASC');
            $out_time   = $this->check_in_out_time($proxi_id, $out_start_time, $end_time, 'DESC');

            if ($in_time == '' && $out_time == '') {
                $status = 'Absent';
            } else {
                $status = 'Present';
            }

            if (strtotime($in_time) > strtotime($late_start_time)) {
                $late_status = 1; 
            }


            $data = array(
                'employee_id'       => $emp_id,
                'office_shift_id'   => 1,
                'attendance_date'   => $process_date,
                'clock_in'          => $in_time,
                'clock_out'         => $out_time,
                'attendance_status' => $status,
                'late_status'       => $late_status,
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
 

}
?>