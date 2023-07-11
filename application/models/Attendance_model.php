<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
    }

    public function attn_process($process_date, $emp_ids, $status = null)
    {

        $check_day = date("Y-m-d",strtotime("-1 day", strtotime($process_date)));
        $att_check = $this->db->where('attendance_date',$check_day)->get('xin_attendance_time');
        if($att_check->num_rows() < 1) {
            echo 'Please first process '. $check_day;
            exit; 
        } elseif (strtotime("+1 day", strtotime(date('Y-m-d'))) < strtotime($process_date)) {
            echo 'Sorry! advanced process not allowed, Please first process '. date('Y-m-d');
            exit; 
        }

        $off_day = $this->dayoff_check($process_date);
        $holiday_day = $this->holiday_check($process_date);
        $employees = $this->get_employees($emp_ids);

        foreach ($employees as $key => $row) {
            $oining_date = $row->date_of_joining;
            $emp_id      = $row->user_id;
            $shift_id = $row->shift_id;
            $in_time  = '';
            $out_time = '';
            $clock_in_out = 0;
            $late_status = 0;
            $lunch_late_status = 0;
            $early_out_status = 0;

            //IF ANY CONDITION IS FALSE THEN ID WILL NOT GO TO THE CORE PROCESS
            if($oining_date > $process_date) {
                $attn_delete = $this->attn_delete_for_eligibility_failed($emp_id, $process_date);
                continue;
            }
            
            $proxi_id   = $this->get_proxi($emp_id);
            if (strtotime('2023-04-29') >= strtotime($process_date)) {
                $shift_schedule = (object) array(
                    'office_shift_id' => 1,
                    'company_id' => 1,
                    'shift_name' => 'Morning Shift',
                    'default_shift' => 1,
                    'in_start_time' => '06:30:00',
                    'in_time' => '09:00:00',
                    'late_start' => '09:00:01',
                    'lunch_time' => '13:00:00',
                    'lunch_minute' => 30,
                    'out_start_time' => '12:00:00',
                    'ot_start_time' => '16:30:00',
                    'out_end_time' => '23:59:59',
                );
            } else {
                $shift_schedule  = $this->get_shift_schedule($emp_id, $process_date, $shift_id);
            }
            // dd($shift_schedule);

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
            $lunch_in        = date('Y-m-d H:i:s', strtotime($lunch_time. ' +'.$lunch_minute));
            $lunch_end       = date('Y-m-d H:i:s', strtotime($lunch_time. ' +50 minutes'));
            $lunch_late_time = date('Y-m-d H:i:s', strtotime($lunch_in. ' +5 minutes'));
            $early_out_time  = date("Y-m-d H:i:s", strtotime($process_date.' '.$ot_start_time));

            // get lunch in and out time and check lunch late status
            $lunch_out   = $this->check_in_out_time($proxi_id, $out_start_time, $lunch_in, 'ASC');
            $lunch_in    = $this->check_in_out_time($proxi_id, $lunch_time, $lunch_end, 'DESC');
            if (strtotime($lunch_in) > strtotime($lunch_late_time)) {
                $lunch_late_status = 1; 
            }

            // get in time
            $in_time    = $this->check_in_out_time($proxi_id, $start_time, $lunch_end, 'ASC');
            $movement_time = $this->check_movement_time($emp_id, $process_date, 'ASC');
            if ($movement_time->num_rows() > 0) {
                $move_out_time = $movement_time->row()->in_time;
                if (strtotime($move_out_time) < strtotime($late_start_time)) {
                    $in_time = $move_out_time; 
                }

                // lunch late check
                $move_in_time = $movement_time->row()->in_time;
                if ($move_in_time != '' && strtotime($move_in_time) > strtotime($process_date.' '.$lunch_time)) {
                    $lunch_late_status = 0; 
                }
            } 


            // get out time
            $out_time   = $this->check_in_out_time($proxi_id, $out_start_time, $end_time, 'DESC');
            $movement_time = $this->check_movement_time($emp_id, $process_date, 'DESC');
            if ($movement_time->num_rows() > 0) {
                $move_in_time = $movement_time->row()->out_time;
                if ($move_in_time != '' && strtotime($move_in_time) > strtotime($early_out_time)) {
                    $out_time = $move_in_time; 
                }

                 // lunch late check
                $move_in_time = $movement_time->row()->in_time;
                if ($move_in_time != '' && strtotime($move_in_time) > strtotime($process_date.' '.$lunch_time)) {
                    $lunch_late_status = 0; 
                }
            } 

            // check leave
            $leave = $this->leave_chech($process_date, $emp_id);
            // dd($leave);
            // check present status
            $status = '';
            $astatus = '';

            if ($leave['leave'] == true && $leave['Hleave'] == true) {
                $astatus = 'Hleave';
                $status = 'Hleave';

                // Half day calculation here 
                $half_morning = date("Y-m-d H:i:s", strtotime($process_date.' '.'11:59:59'));
                if (strtotime($in_time) < strtotime($half_morning) && $in_time != '') {
                    $astatus = 'HalfDay';
                }

                if (strtotime($out_time) > strtotime($lunch_time) && $out_time != '') {
                    $astatus = 'HalfDay';
                }
                // half day calculation end

            } else  if ($leave['leave'] == true) {
                $astatus = 'Leave';
                $status = 'Leave';
            } else {
                if ($holiday_day == true) {
                    if (($in_time != '' && strtotime($in_time)<strtotime($out_start_time)) && ($out_time !='' && strtotime($out_time)>strtotime($early_out_time))) {
                        $astatus = 'Present';
                        $status = 'Holiday';
                    } else {
                        $astatus = 'Holiday';
                        $status = 'Holiday';
                    }
                } else if ($off_day == true) {
                    if (($in_time != '' && strtotime($in_time)<strtotime($out_start_time)) && ($out_time !='' && strtotime($out_time)>=strtotime($early_out_time))) {
                        $astatus = 'Present';
                        $status = 'Off Day';
                    } else {
                        $astatus = 'Off Day';
                        $status = 'Off Day';
                    }
                } else  if ($in_time == '' && $out_time == '') {
                    $astatus = 'Absent';
                    $status = 'Absent';
                } else {
                    $astatus = 'Absent';
                    $status = 'Present';

                    // Half day calculation here 
                    if ($in_time != '' && $out_time != '') {
                        $half_morning = date("Y-m-d H:i:s", strtotime($process_date.' '.'11:59:59'));
                        if (strtotime($in_time) > strtotime($half_morning)) {
                            $astatus = 'HalfDay';
                            $status = 'HalfDay';
                        }
                        $half_evening = date('Y-m-d H:i:s', strtotime($early_out_time. ' -3 hours'));
                        if (strtotime($out_time) < strtotime($half_evening)) {
                            $astatus = 'HalfDay';
                            $status = 'HalfDay';
                        }
                    }
                    // half day calculation end
                }

            }
            // dd($leave);

            //// check present statu for meeting
            $this->db->where('employee_id',$emp_id)->where('date',$process_date)->where('astatus',1);
            $num_row = $this->db->get("xin_employee_move_register");
            $num_rows = $num_row->num_rows();

            if($num_rows != 0 && $num_rows != ''){
                $astatus = 'Meeting';
            }

            // get extra present of off day
            if (($off_day == true) && ($in_time != '' && strtotime($in_time)<strtotime($out_start_time)) && ($out_time !='' && strtotime($out_time)>=strtotime($early_out_time))) {
                $astatus = 'Present';
                $status = 'Off Day';
            }

            // scheck late and early out status
            if (strtotime($in_time) > strtotime($late_start_time)) {
                $late_status = 1; 
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
                'lunch_in'          => $lunch_in ? $lunch_in:'',
                'lunch_out'         => $lunch_out ? $lunch_out:'',
                'attendance_status' => $astatus,
                'status'            => $status,
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

            // checking before after absent of holiday or off day
            // dd($query->row());
            // $day = date('D', strtotime($process_date));
            if ($status == 'Absent') {
                $query = $this->db->where('employee_id',$emp_id)->where('attendance_date',$check_day)->get('xin_attendance_time');
                if($query->row() != null) {
                    if($query->row()->status == 'Holiday') {
                        $this->checking_absent_after_offday_holiday($emp_id, $check_day, array($check_day), 'Holiday');
                    } else if($query->row()->status == 'Off Day') {
                        $this->checking_absent_after_offday_holiday($emp_id, $check_day, array($check_day), 'Off Day');
                    }
                }
            }
        }
        return 'Successfully Process Done';
    }


    function checking_absent_after_offday_holiday($emp_id, $check_day, $where, $status) {
        $check_day = date("Y-m-d",strtotime("-1 day", strtotime($check_day)));
        $query = $this->db->where('employee_id',$emp_id)->where('attendance_date',$check_day)->get('xin_attendance_time');

        if($query->row()->status == $status) {
            array_push($where, $check_day);
            $this->checking_absent_after_offday_holiday($emp_id, $check_day, $where, $status);
        } else if ($query->row()->status == 'Absent') {            
            $this->db->where_in('attendance_date', $where);
            $this->db->where('employee_id', $emp_id);
            $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
        }
        return true;
    }

    function attn_delete_for_eligibility_failed($emp_id, $att_date){
        $this->db->where('employee_id',$emp_id);
        $this->db->where('attendance_date',$att_date); 
        $this->db->delete('xin_attendance_time'); 
        return true;     
    }


    function get_shift_schedule($emp_id, $process_date = null, $shift_id = null)
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

    function dayoff_check($process_date)
    {   
        if ($process_date == '2023-03-25' || $process_date == '2023-04-15') {
            $off_day = array('Friday','Saturday');
        } else if (($process_date < '2023-04-20' && $process_date > '2023-03-10') || $process_date == '2023-06-24' || $process_date == '2023-06-10')  {
            $off_day = array('Friday');
        } else {
            $off_day = array('Friday','Saturday');
        }
        // get day name
        $day = date("l", strtotime($process_date));

        if (in_array($day, $off_day)) {
            return true;
        } else {
            return false;
        }
    }

    function holiday_check($process_date)
    {
        $this->db->where("start_date <=", $process_date);
        $this->db->where("end_date >=", $process_date);
        $query = $this->db->get("xin_holidays");
        if($query->num_rows() > 0 ){
            return true;
        } else {
            return false;
        }
    }

    function leave_chech($process_date, $emp_id)
    {
        // dd($process_date .' = '. $emp_id);
        $this->db->where("from_date <=", $process_date);
        $this->db->where("to_date >=", $process_date);
        $this->db->where("employee_id", $emp_id);
        $this->db->where("status", 2);
        $query = $this->db->get("xin_leave_applications");
        // dd($query->result());
        if($query->num_rows() > 0 ){
            if ($query->row()->is_half_day == 1) {
                $leave = array(
                    'Hleave' => true,
                    'leave'  => true
                );
            }  else {
                $leave = array(
                    'Hleave' => false,
                    'leave'  => true
                );
            }
        } else {
            $leave = array(
                'Hleave' => false,
                'leave'  => false
            );
        }
        return $leave;
    }            

    function check_movement_time($emp_id, $process_date, $order)
    {
        $this->db->where('employee_id',$emp_id);
        $this->db->where('date',$process_date);
        $this->db->order_by("id",$order);
        return $this->db->get('xin_employee_move_register');
    }

    function get_employees($emp_ids, $status = null)
    {
        $this->db->select('user_id, office_shift_id as shift_id, date_of_joining');
        /*if ($status != null) {
            $this->db->where('status',$status);
        }*/
        $this->db->where('company_id',1);
        $this->db->where_in('user_id',$emp_ids);
        return $this->db->get('xin_employees')->result();
    }
    function leaves($emp_ids,$first_date,$second_date,$stutuss)
    {
        $this->db->select('*');
        $this->db->where_in('employee_id', $emp_ids);
        $this->db->where_in('status', $stutuss);
        $this->db->where('from_date >=',$first_date);
        $this->db->where('to_date <=', $second_date);
        return $this->db->get('xin_leave_applications')->result();
    }
    

    function get_proxi($emp_id)
    {
        $proxi = $this->db->select('proxi_id')->where('emp_id',$emp_id)->get('xin_proxi');

        if ($proxi->num_rows() < 1) {
            "Sorry! $emp_id  This Employee ID does not assign to Punch ID";
            // continue;
        } else {
            return $proxi->row()->proxi_id;
        }
    }








    public function get_emp_info($emp_ids = null)
    {
        $this->db->select('
                xin_employees.user_id, 
                xin_employees.employee_id, 
                xin_employees.office_shift_id as shift_id, 
                xin_employees.first_name, 
                xin_employees.last_name, 
                xin_employees.date_of_birth, 
                xin_employees.date_of_joining, 
                xin_employees.department_id,  
                xin_employees.designation_id,
                xin_employees.company_id,
                xin_departments.department_name,
                xin_designations.designation_name,
            ');

        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->where('xin_employees.company_id',1);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where_in('xin_employees.user_id',$emp_ids);
        return $this->db->get()->result();
        
    }

     








    public function get_employee($emp_ids = null)
    {
        $this->db->select('*');
        $this->db->from('xin_employees');
        $this->db->where_in('xin_employees.user_id', $emp_ids);
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
            xin_attendance_time.status,
            xin_attendance_time.late_status,
            xin_attendance_time.comment,
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
        if($status[0]!='all'){
        $this->db->where_in("xin_attendance_time.status", $status);
        }
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
    public function floor_movement($attendance_date, $emp_id)
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
            xin_employee_floor_move.*,
        
        ');

        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_employee_floor_move');
        $this->db->where("xin_employees.is_active", 1);
        $this->db->where("xin_employee_floor_move.date", $attendance_date);
        $this->db->where_in("xin_employee_floor_move.user_id", $emp_id);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_employee_floor_move.user_id');
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
    public function latecomment($attendance_date, $emp_id)
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
            xin_attendance_time.status,
            xin_attendance_time.late_status,
            xin_attendance_time.comment,
        ');

        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_employees.is_active", 1);
        $this->db->where("xin_attendance_time.attendance_date", $attendance_date);
        $this->db->where_in("xin_attendance_time.status", 'Absent');
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







    public function movment_status_report($f1_date, $f2_date,$statusC)
    {
    $this->db->select('
        xin_employee_move_register.employee_id,
        xin_employee_move_register.date,
        xin_employee_move_register.out_time,
        xin_employee_move_register.in_time,
        xin_employee_move_register.reason,
        xin_employee_move_register.request_amount,
        xin_employee_move_register.payable_amount,
        xin_employees.department_id,
        xin_employees.designation_id,
        xin_departments.department_name,
        xin_designations.designation_name,
        xin_employees.employee_id,
        xin_employees.first_name,
        xin_employees.last_name
    ');

    $this->db->from('xin_employees');
    $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id');
    $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id');
    $this->db->join('xin_employee_move_register', 'xin_employee_move_register.employee_id = xin_employees.user_id');
    $this->db->where('xin_employees.is_active', 1);
    $this->db->where("xin_employee_move_register.date BETWEEN '$f1_date' AND '$f2_date'");
    $this->db->where('xin_employee_move_register.status', $statusC);
    $query = $this->db->get();
    $data = $query->result();
   
 

    if ($query->num_rows() > 0) {
        return $data;
     
    } else {
        return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
    }
}




//movement_unpadid report

// public function movment_unpaid_report($f1_date,$f2_date)
// {
    

//     $this->db->select('
//         xin_employee_move_register.employee_id,
//         xin_employee_move_register.date,
//         xin_employee_move_register.out_time,
//         xin_employee_move_register.in_time,
//         xin_employee_move_register.reason,
//         xin_employee_move_register.request_amount,
//         xin_employee_move_register.payable_amount,
//         xin_employees.department_id,  
//         xin_employees.designation_id,
//         xin_departments.department_name,
//         xin_designations.designation_name,
//         xin_employees.employee_id,
//         xin_employees.first_name,
//         xin_employees.last_name,
//         xin_employees.last_name,
       
//     ');

//     $this->db->from('xin_employees');
//     $this->db->from('xin_designations');
//     $this->db->from('xin_departments');
//     $this->db->from('xin_employee_move_register');
//     $this->db->where("xin_employees.is_active", 1);
//     $this->db->where("xin_employee_move_register.date BETWEEN '$f1_date' AND '$f2_date'");
//     $this->db->where('xin_employee_move_register.employee_id = xin_employees.user_id');
//     $this->db->where('xin_employee_move_register.status',3);

//     $data = $this->db->get()->result();
//     dd($data);

//     if($data)
//     {
       
//         return $data;
//     }
//     else
//     {
//         return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
//     }
// }




















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
        $this->db->order_by('empm.id', 'DESC');
        return $result = $this->db->get()->result();
    }


    public function apply_for_ta_da($id,$amount,$details){

    $this->db->query("UPDATE  xin_employee_move_register 
                       SET     `request_amount`  = '$amount', 
                               `reason` = '$details',
                               `status`  = 1
                       WHERE   id        = '$id' 
                    ");
    return "ok";                
    }

    
    public function update_ta_da($id,$amount,$status){

        $this->db->query("UPDATE  xin_employee_move_register 
                           SET     `payable_amount`  = '$amount', 
                                   `status`  = '$status'
                           WHERE   id        = '$id' 
                        ");
        return "update";                
        }
    

    public function modify_for_ta_da($id){
        $this->db->select("request_amount,reason,status")
                 ->from('xin_employee_move_register')
                 ->where('id',$id);   
        return $result = $this->db->get()->result();        
    }
    public function view_ta_da($id){
        $this->db->select("request_amount,payable_amount")
                 ->from('xin_employee_move_register')
                 ->where('id',$id);   
        return $result = $this->db->get()->result();        
    }










    public function get_employee_ajax_request($status)
    {
        $this->db->select('user_id as emp_id, first_name, last_name');
        if ($status == 1) {
            $this->db->where_in('status', array(1,4));
        } else {
            $this->db->where('status',$status);
        }
        $this->db->where('company_id',1);
        $this->db->order_by('user_id', 'asc');
        return $result = $this->db->get('xin_employees')->result();
        // dd($result);
    }
    public function gettodaylog($date, $user_id) {
        $this->db->select('*');
        $this->db->from('xin_attendance_time');
        $this->db->where('employee_id', $user_id);
        $this->db->where('attendance_date', date('Y-m-d', strtotime($date)));
        $this->db->limit(1); // Limit the result to one row
        $data = $this->db->get()->row();
        return $data;
    }
    
 






}
?>