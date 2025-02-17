<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function attn_process($process_date, $emp_ids, $status = null){
        $check_day = date("Y-m-d", strtotime("-1 day", strtotime($process_date)));
        $att_check = $this->db->where('attendance_date', $check_day)->get('xin_attendance_time');
        if($att_check->num_rows() < 1) {
            return 'Successfully Process Done';
        } elseif (strtotime("+1 day", strtotime(date('Y-m-d'))) < strtotime($process_date)) {
            return 'Sorry! advanced process not allowed, Please first process '. date('Y-m-d');
        }
        // if (strtotime(date('Y-m-d', strtotime('-50 days',$process_date))) >= strtotime($process_date)) {
        //     echo 'Sorry! Before 2024-02-29 process not allowed';
        //     exit;
        // }

        if (date('2024-03-23') == $process_date ||
        date('2024-08-10') == $process_date  ||
        date('2024-08-31') == $process_date ||
        date('2024-08-24') == $process_date ||
        date('2024-09-14') == $process_date ||
        date('2024-09-21') == $process_date
        ) {
            $off_day = false;
            $holiday_day = false;
        }elseif(date('2024-05-04') == $process_date ) {
            $off_day = false;
            $holiday_day = false;
        }elseif(date('2024-05-18') == $process_date ) {
            $off_day = false;
            $holiday_day = false;
        }else{
            $off_day = $this->dayoff_check($process_date);
            $holiday_day = $this->holiday_check($process_date);
        }
        // lumch auto off in holiday & weekend
        $lunch_id = null;
        // if ($off_day == true || $holiday_day == true) {
        //     //$lunch_id = $this->lunch_auto_off($process_date);
        // }
        // lumch auto off


        $employees = $this->get_employees($emp_ids, $status=null);
        foreach ($employees as $key => $row) {
            $oining_date = $row->date_of_joining;
            $emp_id      = $row->user_id;

            // hard code mashud rana
            if (date('2024-04-19') == $process_date || date('2024-04-20') == $process_date) {
                if ($emp_id == 67 && date('2024-04-19') == $process_date) {
                    $off_day = false;
                    $holiday_day = false;
                }elseif ($emp_id == 67 && date('2024-04-20') == $process_date) {
                    $off_day = false;
                    $holiday_day = false;
                }else{
                    $off_day = $this->dayoff_check($process_date);
                    $holiday_day = $this->holiday_check($process_date);
                }
            }

            if (date('2024-07-22') == $process_date || date('2024-07-23') == $process_date || date('2024-07-24') == $process_date) {
                if ($emp_id == 82 || $emp_id == 30 || $emp_id == 77) {
                    $off_day = false;
                    $holiday_day = false;
                }
            }
            // hard code


            $shift_id = $row->shift_id;
            $in_time  = '';
            $out_time = '';
            $clock_in_out = 0;
            $late_status = 0;
            $late_time = 0;
            $production = 0;
            $ot = 0;
            $lunch_late_status = 0;
            $early_out_status = 0;

            //IF ANY CONDITION IS FALSE THEN ID WILL NOT GO TO THE CORE PROCESS
            if($oining_date > $process_date) {
                $attn_delete = $this->attn_delete_for_eligibility_failed($emp_id, $process_date);
                continue;
            }

            // lumch auto off in holiday & weekend
            // if (($off_day == true || $holiday_day == true) && $lunch_id != null) {
            //     $lst = ($off_day == true) ? 'Off Day' : 'Holiday';
            //     $lunch_id = $this->lunch_auto_off_details($lunch_id, $emp_id, $lst, $process_date);
            // }
            // lumch auto off
            $shift_schedule  = $this->get_shift_schedule($emp_id, $process_date, $shift_id);

            $proxi_id   = $this->get_proxi($emp_id);
            if (strtotime('2024-04-31') <= strtotime($process_date)) {
                $shift_schedule = (object) array(
                    'office_shift_id' => 1,
                    'company_id' => 1,
                    'shift_name' => 'Morning Shift',
                    'default_shift' => 1,
                    'in_start_time' => '06:30:00',
                    'in_time' => '09:30:00',
                    'late_start' => '09:40:01',
                    'lunch_time' => '13:10:00',
                    'lunch_minute' => 60,
                    'out_start_time' => '13:00:00',
                    'ot_start_time' => '18:30:00',
                    'out_end_time' => '23:59:59',
                );
            }elseif(strtotime('2024-07-29') <= strtotime($process_date)) {
                $shift_schedule = (object) array(
                    'office_shift_id' => 1,
                    'company_id' => 1,
                    'shift_name' => 'Morning Shift',
                    'default_shift' => 1,
                    'in_start_time' => '06:30:00',
                    'in_time' => '09:00:00',
                    'late_start' => '09:10:01',
                    'lunch_time' => '13:10:00',
                    'lunch_minute' => 60,
                    'out_start_time' => '13:00:00',
                    'ot_start_time' => '18:00:00',
                    'out_end_time' => '23:59:59',
                );
            }elseif (strtotime('2024-04-15') <= strtotime($process_date)) {
                $shift_schedule = (object) array(
                    'office_shift_id' => 1,
                    'company_id' => 1,
                    'shift_name' => 'Morning Shift',
                    'default_shift' => 1,
                    'in_start_time' => '06:30:00',
                    'in_time' => '09:30:00',
                    'late_start' => '09:40:01',
                    'lunch_time' => '13:10:00',
                    'lunch_minute' => 60,
                    'out_start_time' => '13:00:00',
                    'ot_start_time' => '18:30:00',
                    'out_end_time' => '23:59:59',
                );
            }elseif (strtotime('2024-03-12') <= strtotime($process_date)) {
                $shift_schedule = (object) array(
                    'office_shift_id' => 1,
                    'company_id' => 1,
                    'shift_name' => 'Morning Shift',
                    'default_shift' => 1,
                    'in_start_time' => '06:30:00',
                    'in_time' => '09:00:00',
                    'late_start' => '09:10:01',
                    'lunch_time' => '13:10:00',
                    'lunch_minute' => 20,
                    'out_start_time' => '13:00:00',
                    'ot_start_time' => '17:00:00',
                    'out_end_time' => '23:59:59',
                );
            }else {
                $shift_schedule  = $this->get_shift_schedule($emp_id, $process_date, $shift_id);
            }
            // dd($shift_schedule);

            $in_start_time   = $shift_schedule->in_start_time;
            $late_start_time = $shift_schedule->late_start;
            $out_end_time    = $shift_schedule->out_end_time;
            $out_start_time  = $shift_schedule->out_start_time;
            $lunch_time      = $shift_schedule->lunch_time;
            $lunch_minute    = $shift_schedule->lunch_minute;
            $ot_start_time   = $shift_schedule->ot_start_time;

            $start_time      = date("Y-m-d H:i:s", strtotime($process_date.' '.$in_start_time));
            $actual_in_time  = date("Y-m-d H:i:s", strtotime($process_date.' '.$shift_schedule->in_time));
            $end_time        = date("Y-m-d H:i:s", strtotime($process_date.' '.$out_end_time));
            $out_start_time  = date("Y-m-d H:i:s", strtotime($process_date.' '.$out_start_time));
            $late_start_time = date("Y-m-d H:i:s", strtotime($process_date.' '.$late_start_time));

            $lunch_time      = date("Y-m-d H:i:s", strtotime($process_date.' '.$lunch_time));
            $lunch_end       = date('Y-m-d H:i:s', strtotime($lunch_time. ' +'.$lunch_minute. ' minutes'));
            $lunch_late_time = date('Y-m-d H:i:s', strtotime($lunch_end. ' +5 minutes'));
            $early_out_time  = date("Y-m-d H:i:s", strtotime($process_date.' '.$ot_start_time));

            // get lunch in and out time and check lunch late status
            $half_evening = date('Y-m-d H:i:s', strtotime($early_out_time. ' -3 hours'));
            $lunch_out   = $this->check_in_out_time($proxi_id, $lunch_time, $lunch_end, 'ASC');
            if ($lunch_out) {
                $oott= date('Y-m-d H:i:s', strtotime($lunch_out. ' +1 minutes'));
            }else {
                $oott= date('Y-m-d H:i:s', strtotime($lunch_time. ' +1 minutes'));
            }
            $lunch_in    = $this->check_in_out_time($proxi_id, $oott, $half_evening, 'DESC');
            if (strtotime($lunch_in) > strtotime($lunch_late_time)) {
                $lunch_late_status = 1;
            }

            // get in time
            $in_time    = $this->check_in_out_time($proxi_id, $start_time, $half_evening, 'ASC');


            $movement_time = $this->check_movement_time($emp_id, $process_date, 'ASC');
            //dd($movement_time->row());
            if ($movement_time->num_rows() > 0) {
                $move_out_time = $movement_time->row()->in_time;
                //dd($move_out_time);
                if (!empty($move_out_time)  && strtotime($move_out_time) > strtotime($in_time)) {

                    $in_time = $move_out_time;
                }

                // lunch late check
                $move_in_time = $movement_time->row()->in_time;
                if ($move_in_time != '' && strtotime($move_in_time) > strtotime($process_date.' '.$lunch_time)) {
                    $lunch_late_status = 0;
                }
            }

            //dd($in_time);

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
            //dd($leave);
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

            } elseif ($leave['leave'] == true) {
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
                } elseif ($off_day == true) {
                    if (($in_time != '' && strtotime($in_time)<strtotime($out_start_time)) && ($out_time !='' && strtotime($out_time)>=strtotime($early_out_time))) {
                        $astatus = 'Present';
                        $status = 'Off Day';
                    } else {
                        $astatus = 'Off Day';
                        $status = 'Off Day';
                    }
                }elseif ($in_time == '' && $out_time == '') {
                    $astatus = 'Absent';
                    $status = 'Absent';
                }elseif($in_time != '' && $out_time == '') {
                    $astatus = 'HalfDay';
                    $status = 'HalfDay';
                }elseif($in_time == '' && $out_time != '') {
                    $astatus = 'Absent';
                    $status = 'Absent';
                }else{
                    $astatus = 'Absent';
                    $status = 'Present';
                    // Half day calculation here
                    if ($in_time != '' && $out_time != '') {
                        $half_morning = date("Y-m-d H:i:s", strtotime($process_date.' '.'11:59:59'));
                        if (strtotime($in_time) > strtotime($half_morning)) {
                            $astatus = 'HalfDay';
                            $status = 'HalfDay';
                            $late_status= 0;

                        }
                        if (strtotime($out_time) < strtotime($half_evening)) {
                            $astatus = 'HalfDay';
                            $status = 'HalfDay';
                            $late_status= 0;

                        }
                    }
                    // half day calculation end
                }
            }

           // dd($astatus);
            // dd($leave);

            // get extra present of off day
            $extra_p_day = date('Y-m-d H:i:s', strtotime($early_out_time. ' -1 hours'));
            if ($off_day == true || $holiday_day == true) {
                if (($in_time != '' && strtotime($in_time)<strtotime($out_start_time)) && ($out_time !='' && strtotime($out_time)>=strtotime($extra_p_day))) {
                    $astatus = 'Present';
                    $status = 'Off Day';
                    $late_status= 0;
                    // hard code this line
                    if (in_array($emp_id, array(46, 82))) {
                        $astatus = 'Off Day';
                    }
                }
            }

            //// check present statu for meeting
            $this->db->where('employee_id', $emp_id)->where('date', $process_date)->where('astatus', 1);
            $num_row = $this->db->get("xin_employee_move_register");
            $num_rows = $num_row->num_rows();


            // if($num_rows != 0 && $num_rows != '') {
            //     $astatus = 'Meeting';
            // }


            // get extra present of off day
            if (($off_day == true) && ($in_time != '' && strtotime($in_time)<strtotime($out_start_time)) && ($out_time !='' && strtotime($out_time)>=strtotime($early_out_time))) {
                $astatus = 'Present';
                $status = 'Off Day';
            }

            // check late & calculation late minute
            if (strtotime($in_time) > strtotime($late_start_time) && strtotime($in_time) < strtotime($lunch_time)) {
                $late_status = 1;
                $late_time = round((strtotime($in_time) - strtotime($actual_in_time)) / 60);
            }

            // if($astatus=='Meeting'){
            //     $late_status = 0;
            //     $late_time =0;
            // }


            // total calculation production time & over time (ot)
            if (($astatus == 'Present' || $status == 'Present') && $out_time != null && $in_time != null) {
                $production = round((strtotime($out_time) - strtotime($in_time)) / 60) - $lunch_minute;
                $actual_p_time = round((strtotime($early_out_time) - strtotime($actual_in_time)) / 60) - $lunch_minute;

                if($production > $actual_p_time) {
                    $ot = $production - $actual_p_time;
                }
            } elseif (($astatus == 'HalfDay' || $status == 'HalfDay') && $out_time != null && $in_time != null) {
                if (strtotime($in_time) < strtotime($lunch_time)) {
                    $production = round((strtotime($out_time) - strtotime($in_time)) / 60) -  $lunch_minute;
                } else {
                    $production = round((strtotime($out_time) - strtotime($in_time)) / 60);
                }
            }
            // end production time & over time

            // early out status
            if (strtotime($out_time) < strtotime($early_out_time) && strtotime($out_time) != null) {
                $early_out_status = 1;
            }
            // dd($out_time .' '. $early_out_time .' '. $early_out_status);
            // if ($status == 'Off Day') {
            //     $late_status = 0;
            // }


            $data = array(
                'employee_id'       => $emp_id,
                'office_shift_id'   => 1,
                'attendance_date'   => $process_date,
                'clock_in'          => $in_time,
                'clock_out'         => $out_time,
                'production'        => $production,
                'ot'                => $ot,
                'late_time'         => $late_time,
                'lunch_in'          => $lunch_in ? $lunch_in : '',
                'lunch_out'         => $lunch_out ? $lunch_out : '',
                'attendance_status' => $astatus,
                'status'            => $status,
                'late_status'       => $late_status,
                'lunch_late_status' => $lunch_late_status,
                'early_out_status'  => $early_out_status,
            );


            // $left_resign=$this->db->where('emp_id', $emp_id)->get('xin_employee_left_resign')->row();
            // if (!empty($left_resign)) {
            //     $left_date=$left_resign->effective_date;
            // }


            $query = $this->db->where('employee_id', $emp_id)->where('attendance_date', $process_date)->get('xin_attendance_time');
            if($query->num_rows() > 0) {

                // if (isset($left_date)) {
                //     if ($left_date >= $process_date) {
                        $this->db->where('attendance_date', $process_date);
                        $this->db->where('employee_id', $emp_id);
                        $this->db->update('xin_attendance_time', $data);
                    // }else{
                    //     $this->db->where('attendance_date', $process_date);
                    //     $this->db->where('employee_id', $emp_id);
                    //     $this->db->delete('xin_attendance_time');
                    // }
                // }else{
                //     $this->db->where('attendance_date', $process_date);
                //     $this->db->where('employee_id', $emp_id);
                //     $this->db->update('xin_attendance_time', $data);
                // }
            } else {
                // if (isset($left_date)) {
                //     if ($left_date >= $process_date) {
                //         $this->db->insert('xin_attendance_time', $data);
                //     }
                // }else{
                    $this->db->insert('xin_attendance_time', $data);
               // }
            }

            // checking before after absent of holiday or off day
            // dd($query->row());
            // $day = date('D', strtotime($process_date));
            if ($status == 'Absent') {
                $this->checking_absent_after_offday_holiday($emp_id, $check_day);
            } elseif ($status == 'Leave') {
                $this->checking_absent_after_offday_holiday($emp_id, $check_day);
            } elseif ($astatus == 'Holiday') {

                $this->checking_absent_after_offday_holiday($emp_id, $check_day);
                $this->checking_absent_after_before_holiday($emp_id, $check_day);
            }
            if ($status == 'Off Day') {
                $this->checking_absent_after_before_offday_holiday($emp_id, $check_day);
            }

            $this->leave_cal_all($emp_id,$process_date);
        }
        return 'Successfully Process Done';
    }

    public function checking_absent_after_before_holiday($emp_id, $check_day)
    {

        $q = $this->db->where('employee_id', $emp_id)->where('attendance_date', $check_day)->get('xin_attendance_time')->row();
        if($q->status == 'Absent') {
            $cd = date("Y-m-d", strtotime("+2 day", strtotime($check_day)));
            $this->db->where('employee_id', $emp_id)->where('attendance_date', $cd);
            $qs = $this->db->where('employee_id', $emp_id)->get('xin_attendance_time')->row();
            if ($qs->status == 'Absent') {
                $dd = date("Y-m-d", strtotime("+1 day", strtotime($check_day)));
                $this->db->where('attendance_date', $dd);
                $this->db->where('employee_id', $emp_id);
                $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
            }
        } elseif ($q->status == 'Leave' && $q->attendance_status == 'Leave') {
            $cd = date("Y-m-d", strtotime("+2 day", strtotime($check_day)));
            $this->db->where('employee_id', $emp_id)->where('attendance_date', $cd);
            $qs = $this->db->where('employee_id', $emp_id)->get('xin_attendance_time')->row();

            if ($qs->status == 'Leave' && $qs->attendance_status == 'Leave') {
                $dd = date("Y-m-d", strtotime("+1 day", strtotime($check_day)));
                $this->db->where('attendance_date', $dd);
                $this->db->where('employee_id', $emp_id);
                $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
            }


        } elseif($q->attendance_status == 'HalfDay') {
            $cd = date("Y-m-d", strtotime("+2 day", strtotime($check_day)));
            $this->db->where('employee_id', $emp_id)->where('attendance_date', $cd);
            $qs = $this->db->where('employee_id', $emp_id)->get('xin_attendance_time')->row();

            if ($qs->attendance_status == 'HalfDay') {
                $dd = date("Y-m-d", strtotime("+1 day", strtotime($check_day)));
                $this->db->where('attendance_date', $dd);
                $this->db->where('employee_id', $emp_id);
                $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
            }

        }
        return true;
}


    public function checking_absent_after_offday_holiday($emp_id, $check_day)
    {
		$prev_st = $this->check_off_day_prev($check_day, 'xin_holioff_days');

		if ($prev_st['status'] == true) {
            $query = $this->db->where('employee_id', $emp_id)->where('attendance_date', $prev_st['date'])->get('xin_attendance_time')->row();
            if($query->status == 'Absent') {
                $date1 = new DateTime($check_day);
                $date2 = new DateTime($query->attendance_date);
                $interval = $date1->diff($date2)->days - 1;
                $qqs = $this->db->where('employee_id', $emp_id)->where('attendance_date', $check_day)->get('xin_attendance_time')->row();

                if ($qqs->status != 'Leave' && $qqs->attendance_status != 'Leave') {
                    $this->db->where('attendance_date', $check_day);
                    $this->db->where('employee_id', $emp_id);
                    $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
                }

                for ($i=0; $i < $interval; $i++) {
                    $check_day = date("Y-m-d", strtotime("-1 day", strtotime($check_day)));

                    if ($qqs->status != 'Leave' && $qqs->attendance_status != 'Leave') {
                        $this->db->where('attendance_date', $check_day);
                        $this->db->where('employee_id', $emp_id);
                        $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
                    }
                }
            }  elseif($query->attendance_status == 'HalfDay') {
                $date1 = new DateTime($check_day);
                $date2 = new DateTime($query->attendance_date);
                $interval = $date1->diff($date2)->days - 1;
                $qqs = $this->db->where('employee_id', $emp_id)->where('attendance_date', $check_day)->get('xin_attendance_time')->row();

                if ($qqs->status != 'Leave' && $qqs->attendance_status != 'Leave') {
                    $this->db->where('attendance_date', $check_day);
                    $this->db->where('employee_id', $emp_id);
                    $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
                }

                for ($i=0; $i < $interval; $i++) {
                    $check_day = date("Y-m-d", strtotime("-1 day", strtotime($check_day)));
                    if ($qqs->status != 'Leave' && $qqs->attendance_status != 'Leave') {
                        $this->db->where('attendance_date', $check_day);
                        $this->db->where('employee_id', $emp_id);
                        $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
                    }
                }
            }
        }
        return true;
    }

    public function checking_absent_after_before_offday_holiday($emp_id, $check_day)
    {
		$prev_st = $this->check_off_day_prev($check_day, 'xin_holioff_days');
		if ($prev_st['status'] == false) {
            $query = $this->db->where('employee_id', $emp_id)->where('attendance_date', $check_day)->get('xin_attendance_time')->row();
            if ($query->status != 'Present') {
                $check_day = date('Y-m-d', strtotime('+2 days'. $check_day));
                $query = $this->db->where('employee_id', $emp_id)->where('attendance_date', $check_day)->get('xin_attendance_time')->row();
                $check_day = date('Y-m-d', strtotime('-1 days'. $check_day));
               if (!empty($query)) {

                if ($query->status == 'Absent') {
                    $this->db->where('attendance_date', $check_day);
                    $this->db->where('employee_id', $emp_id);
                    $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
                } else if ($query->status == 'Leave') {
                    $this->db->where('attendance_date', $check_day);
                    $this->db->where('employee_id', $emp_id);
                    $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
                }  else if ($query->attendance_status == 'HalfDay') {
                    $this->db->where('attendance_date', $check_day);
                    $this->db->where('employee_id', $emp_id);
                    $this->db->update('xin_attendance_time', array('status' => 'Absent', 'attendance_status' => 'Absent'));
                }
               }
            }
        }
        return true;
    }

    function check_off_day_prev($date, $table) {
		$check = $this->db->where('start_date', $date)->get($table)->row();
		if(!empty($check)) {
			$date = date('Y-m-d', strtotime('-1 days'. $date));
			$check2 = $this->db->where('start_date', $date)->get($table)->row();
			if(empty($check2)) {
				return array('status' => true, 'date' => $date);
			} else {
				$date = date('Y-m-d', strtotime('-1 days'. $date));
				$check3 = $this->db->where('start_date', $date)->get($table)->row();
				if (empty($check3)) {
					return array('status' => true, 'date' => $date);
				} else {
					$date = date('Y-m-d', strtotime('-1 days'. $date));
					$check4 = $this->db->where('start_date', $date)->get($table)->row();
					if (empty($check4)) {
						return array('status' => true, 'date' => $date);
					} else {
						return array('status' => true, 'date' => $date);
					}
				}
			}
		} else {
			return array('status' => false, 'date' => $date);
		}
	}

    public function leave_process($leave_id) {
        $data= $this->db->where('leave_id', $leave_id)->get('xin_leave_applications')->row();
        $first_date = date('Y-m-d', strtotime($data->from_date));
        $last_date = date('Y-m-d', strtotime($data->to_date));
        $employee_id = $data->employee_id;
        $currentDate = $first_date;
        do {
            $this->attn_process($currentDate, [$employee_id]);
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        } while ($currentDate <= $last_date);
    }

    public function get_attn_data_from_machine($date){
        $devices = array(
            array("ip" => "192.168.30.14", "port" => 4370),
            array("ip" => "192.168.30.20", "port" => 4370)
        );
        $startTime = strtotime($date.' 00:00:00');
        $endTime = strtotime($date.' 23:59:59');
        $batchData = array(); // Array to store batch insert data
        // Prepare an array to store employee IDs associated with prox IDs
        foreach ($devices as $index => $device){
            $attendance = $this->retrieveAttendance($device["ip"], $device["port"], $startTime, $endTime);
            foreach ($attendance as $at) {
                $proxi_id = $at[1];
                $time = $at[3];
                $in_time = date('Y-m-d H:i:s', strtotime($time));
                $this->db->where("proxi_id", $proxi_id);
                $this->db->where("date_time", $in_time);
                $query1 = $this->db->get("xin_att_machine");
                $num_rows1 = $query1->num_rows();
                if($num_rows1 == 0) {
                    $batchData[] = array(
                        'proxi_id'  => $proxi_id,
                        'date_time' => $in_time,
                        'device_id' => $index,
                    );
                }
            }
        }
        if (!empty($batchData)) {
            $this->db->insert_batch("xin_att_machine", $batchData);
        }
    }
    /* function retrieveAttendance($ip, $port, $startTime, $endTime)
    {
        $zk = new ZKLibrary($ip, $port);
        $zk->connect();
        $zk->disableDevice();
        $attendance = $zk->getAttendance();
        $zk->enableDevice();
        $zk->disconnect();
        $filteredAttendance = array();
        foreach ($attendance as $at) {
            $dateTime = strtotime($at[3]);
            if ($dateTime >= $startTime && $dateTime <= $endTime) {
                $filteredAttendance[] = $at;
            }
        }
        return $filteredAttendance;
    } */

    // public function lunch_auto_off($date)
    // {
    //     $this->db->select("id");
    //     $this->db->where("date", $date);
    //     $query = $this->db->get('lunch');

    //     if($query->num_rows() > 0) {
    //         return $query->row()->id;
    //     } else {
    //         $data = array(
    //             'total_m'    => 0,
    //             'emp_m'      => 0,
    //             'guest_m'    => 0,
    //             'total_cost' => 0,
    //             'emp_cost'   => 0,
    //             'guest_cost' => 0,
    //             'bigcomment' => 'holiday / weekend off',
    //             'date'       => $date,
    //             'status'     => 0,
    //         );
    //         $this->db->insert('lunch', $data);
    //         return $this->db->insert_id();
    //     }
    // }

    // public function lunch_auto_off_details($lunch_id, $emp_id, $lst, $date)
    // {
    //     $form_data = array(
    //         'lunch_id'      => $lunch_id,
    //         'emp_id'        => $emp_id,
    //         'meal_amount'   => 0,
    //         'p_stutus'      => $lst,
    //         'comment'       => '.',
    //         'date'          => $date,
    //     );
    //     $this->db->where('lunch_id', $lunch_id);
    //     $this->db->where('emp_id', $emp_id);
    //     $this->db->get('lunch_details')->row();
    //     if($this->db->affected_rows() > 0) {
    //         $this->db->where('lunch_id', $lunch_id);
    //         $this->db->where('emp_id', $emp_id);
    //         $this->db->update('lunch_details', $form_data);
    //     }
    //     $this->db->insert('lunch_details', $form_data);
    //     return true;
    // }

    public function attn_delete_for_eligibility_failed($emp_id, $att_date)
    {
        $this->db->where('employee_id', $emp_id);
        $this->db->where('attendance_date', $att_date);
        $this->db->delete('xin_attendance_time');
        return true;
    }

    public function get_shift_schedule($emp_id, $process_date = null, $shift_id = null)
    {
        $this->db->select("office_shift_id");
        $this->db->where("employee_id", $emp_id);
        $this->db->where("attendance_date", $process_date);
        $query = $this->db->get('xin_attendance_time');

        if($query->num_rows() > 0) {
            $shift_id = $query->row()->office_shift_id;
        }

        return $this->db->where('office_shift_id', $shift_id)->get('xin_office_shift')->row();
    }

    public function check_in_out_time($proxi_id, $start_time, $end_time, $order)
    {


        $date_time = '';
        $this->db->select("date_time");
        $this->db->where("date_time BETWEEN '$start_time' and '$end_time'");
        $this->db->where("proxi_id", $proxi_id);
        $this->db->order_by("date_time", $order);
        $this->db->limit("1");
        $query = $this->db->get('xin_att_machine');

        if($query->num_rows() > 0) {
            $date_time = $query->row()->date_time;
        }
        return $date_time;
    }

    public function dayoff_check($process_date)
    {
        if ($process_date == '2023-03-25' || $process_date == '2023-04-15') {
            $off_day = array('Friday','Saturday');
        } elseif (($process_date < '2023-04-20' && $process_date > '2023-03-10') || $process_date == '2023-06-24' || $process_date == '2023-06-10') {
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

    public function holiday_check($process_date)
    {
        $this->db->where("start_date <=", $process_date);
        $this->db->where("end_date >=", $process_date);
        $query = $this->db->get("xin_holidays");
        if($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function leave_chech($process_date, $emp_id)
    {
        // dd($process_date .' = '. $emp_id);
        $this->db->where("from_date <=", $process_date);
        $this->db->where("to_date >=", $process_date);
        $this->db->where("employee_id", $emp_id);
        $this->db->where("status", 2);
        $query = $this->db->get("xin_leave_applications");
         //dd($query->result());
        if($query->num_rows() > 0) {
            if ($query->row()->is_half_day == 1) {
                $leave = array(
                    'Hleave' => true,
                    'leave'  => true
                );
            } else {
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

    public function check_movement_time($emp_id, $process_date, $order)
    {
        $this->db->where('employee_id', $emp_id);
        $this->db->where('date', $process_date);
        $this->db->order_by("id", $order);
        return $this->db->get('xin_employee_move_register');
    }

    public function get_employees($emp_ids, $status = null)
    {
        if(empty($emp_ids)){
            return array();
        };

        $this->db->select('user_id, office_shift_id as shift_id, date_of_joining');
        /*if ($status != null) {
            $this->db->where('status',$status);
        }*/
        $this->db->where('company_id', 1);
        $this->db->where_in('user_id', $emp_ids);
        return $this->db->get('xin_employees')->result();
    }
    public function leaves($emp_ids, $first_date, $second_date, $stutuss)
    {
        $this->db->select('*');
        $this->db->where_in('employee_id', $emp_ids);
        $this->db->where_in('status', $stutuss);
        $this->db->where('from_date >=', $first_date);
        $this->db->where('to_date <=', $second_date);
        $this->db->order_by('employee_id', 'ASC');
        return $this->db->get('xin_leave_applications')->result();
    }
    public function leavesm($emp_ids =null, $first_date, $second_date)
    {
        $this->db->select('*');
        if ( $emp_ids != null) {
            $this->db->where_in('employee_id', $emp_ids);
        }
        $this->db->where('from_date >=', $first_date);
        $this->db->where('to_date <=', $second_date);
        $this->db->order_by('employee_id', 'ASC');
        $this->db->group_by('employee_id');
        return $this->db->get('xin_leave_applications')->result();
    }
    public function leavesm_singale($emp_ids, $first_date, $second_date, $status=null)
    {
        $this->db->select('*');
        $this->db->where('employee_id', $emp_ids);
        $this->db->where('from_date >=', $first_date);
        $this->db->where('to_date <=', $second_date);
        if ($status != null) {
            $this->db->where('status', $status);
        }
        return $this->db->get('xin_leave_applications')->result();
    }


    public function get_proxi($emp_id)
    {
        $proxi = $this->db->select('proxi_id')->where('emp_id', $emp_id)->get('xin_proxi');

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
                xin_employees.notify_incre_prob,
                xin_employees.marital_status,
                xin_employees.employee_id,
                xin_employees.leave_effective,
                xin_employees.office_shift_id as shift_id,
                xin_employees.first_name,
                xin_employees.salary,
                xin_employees.last_name,
                xin_employees.date_of_birth,
                xin_employees.date_of_joining,
                xin_employees.department_id,
                xin_employees.designation_id,
                xin_employees.company_id,
                xin_employees.profile_picture,
                xin_departments.department_name,
                xin_designations.designation_name,
            ');

        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->where('xin_employees.company_id', 1);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where_in('xin_employees.user_id', $emp_ids);
        return $this->db->get()->result();

    }










    public function get_employee($emp_ids = null)
    {
        $this->db->select('*');
        $this->db->from('xin_employees');
        $this->db->where_in('xin_employees.user_id', $emp_ids);
        return $this->db->get()->result();

    }

    public function daily_report($attendance_date, $emp_id=null, $status = null, $late_status=null)
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
        if($status[0]!='all') {
            $this->db->where_in("xin_attendance_time.status", $status);
        }

        if (!empty($emp_id)) {
            $this->db->where_in("xin_attendance_time.employee_id", $emp_id);
        }
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');
        $this->db->order_by('xin_attendance_time.clock_in', "ASC");
        $data = $this->db->get()->result();

        if($data) {
            return $data;
        } else {
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

        if($data) {
            return $data;
        } else {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }
    public function today_floor_movement($emp_id,$date=null)
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
        if($date!=null) {
            $this->db->where("xin_employee_floor_move.date", $date);
        }else{
            $this->db->where("xin_employee_floor_move.date", date('Y-m-d'));
        }
        $this->db->where("xin_employee_floor_move.user_id", $emp_id);
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_employee_floor_move.user_id');
        $data = $this->db->get()->result();

        return $data;

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

        if($data) {
            return $data;
        } else {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }
    public function get_total_present($value, $first_date, $second_date)
    {
        $this->db->select('SUM(CASE WHEN xin_attendance_time.status = "Present" THEN 1 WHEN xin_attendance_time.status = "HalfDay" THEN 0.5 ELSE 0 END) as total_present');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'");
        $this->db->where("xin_attendance_time.status", 'Present');
        $this->db->where("xin_attendance_time.employee_id", $value);
        $result = $this->db->get()->row();

        if (empty($result)) {
            return 0;
        }

        $data = $result;
        if (isset($data->total_present)) {
            return $data->total_present;
        } else {
            return 0;
        }
    }
    public function get_total_absent($value, $first_date, $second_date)
    {
        $this->db->select('SUM(CASE WHEN xin_attendance_time.status = "Absent" THEN 1 ELSE 0 END) as total_absent');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'");
        $this->db->where("xin_attendance_time.status", 'Absent');
        $this->db->where("xin_attendance_time.employee_id", $value);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $row = $result->row();
            return $row->total_absent;
        } else {
            return 0;
        }
    }

    public function get_total_late($value, $first_date, $second_date)
    {
        $this->db->select('xin_attendance_time.attendance_date');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'");
        $this->db->where("xin_attendance_time.late_status", 1);
        $this->db->where("xin_attendance_time.employee_id", $value);
        return count($this->db->get()->result());
    }
    public function get_total_late_monthly($first_date, $second_date)
    {
        $this->db->select('xin_attendance_time.*, xin_employees.first_name, xin_employees.last_name');
        $this->db->from('xin_attendance_time');
        $this->db->join('xin_employees', 'xin_employees.user_id = xin_attendance_time.employee_id');
        $this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'");
        $this->db->where("xin_attendance_time.late_status", 1);
        return $this->db->get()->result();
    }

	public function leave_cal_all($id,$date)
	{
		$user_info = $this->db->where('user_id', $id)
        ->get('xin_employees')->result();
		foreach ($user_info as $key => $row) {
            if ($row->is_leave_on == 0 ) {
                    $data = array(
                        'emp_id' => $row->user_id,
                        'el_total' => 0,
                        'sl_total' => 0,
                        'el_balanace' => 0,
                        'sl_balanace' => 0,
                        'year' => date('Y', strtotime($date)),
                    );
                }else{
                    $d1 = new DateTime(date('Y-12-31', strtotime($date)));
                    $d2 = new DateTime($row->leave_effective);
                    $d2->modify('-1 day');
                    if ($d1 < $d2) {
                        //dd('hi');
                        $data = array(
                            'emp_id' => $row->user_id,
                            'el_total' => 0,
                            'sl_total' => 0,
                            'el_balanace' => 0,
                            'sl_balanace' => 0,
                            'year' => date('Y', strtotime($date)),
                        );
                    } else{
                        $Months = $d2->diff($d1);
                        $month = $Months->m;
                        if ($Months->y > 0) {
                            $month = 12;
                        }

                        $qty = round(($month / 3), 2);
                        $numberString = (string) $qty;
                        $parts = explode('.', $numberString);
                        $integerPart = $parts[0];
                        if (isset($parts[1])) {
                            $decimalPart = $parts[1];
                        } else {
                            $decimalPart = 0;
                        }

                        if ($decimalPart > 50) {
                            $integerPart += 0.5;
                        }
                        $leave_en = $this->check_leave_balance($row->user_id, date('Y', strtotime($date)));
                        $data = array(
                            'emp_id' => $row->user_id,
                            'el_total' => $month,
                            'sl_total' => $integerPart,
                            'el_balanace' => ($month-$leave_en->el),
                            'sl_balanace' => ($integerPart-$leave_en->sl),
                            'year' => date('Y', strtotime($date)),
                        );
                    }
                }
            $pre=$this->db->where('emp_id', $row->user_id)->where('year', date('Y', strtotime($date)))->get('leave_balanace');
            if($pre->num_rows()==0){
                $this->db->insert('leave_balanace', $data);
            }else{
                $this->db->where('emp_id', $row->user_id)->where('year', date('Y', strtotime($date)))->update('leave_balanace', $data);
            }
		}
	}
    public function check_leave_balance($value, $year) {
        $this->db->select('COALESCE(SUM(CASE WHEN leave_type_id = 1 THEN qty ELSE 0 END), 0) as el, COALESCE(SUM(CASE WHEN leave_type_id = 2 THEN qty ELSE 0 END), 0) as sl', false);
        $this->db->from('xin_leave_applications');
        $this->db->where('employee_id', $value);
        $this->db->where('current_year', $year);
        $this->db->where('status', 2);
        return $this->db->get()->row();
    }

    public function get_total_overtime($value, $first_date, $second_date)
    {
        $this->db->select('xin_attendance_time.attendance_date');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'");
        $this->db->where("xin_attendance_time.status", 'Present');
        $this->db->where("xin_attendance_time.ot >= 30");
        $this->db->where("xin_attendance_time.employee_id", $value);
        return count($this->db->get()->result());
    }
    public function get_total_leave($value, $first_date, $second_date)
    {
        $this->db->select('xin_leave_applications.*');
        $this->db->from('xin_leave_applications');
        $this->db->where("xin_leave_applications.from_date BETWEEN '$first_date' AND '$second_date'");
        $this->db->where("xin_leave_applications.status", 2);
        $this->db->where("xin_leave_applications.employee_id", $value);
        $data=$this->db->get()->result();
        $total = 0;
        foreach($data as $dat) {
            $total += $dat->qty;
        }
        return $total;
    }



    public function lunch_report($attendance_date, $emp_id, $status=null, $late_status=null)
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
            xin_attendance_time.status,
            xin_attendance_time.lunch_in,
            xin_attendance_time.lunch_out,
            xin_attendance_time.lunch_late_status,
        ');


        $this->db->from('xin_employees');
        $this->db->from('xin_departments');
        $this->db->from('xin_designations');
        $this->db->from('xin_attendance_time');
        $this->db->where("xin_employees.is_active", 1);
        if($late_status=='1') {
            $this->db->where("xin_attendance_time.lunch_late_status", 1 );
        }
        $this->db->where("xin_attendance_time.attendance_date", $attendance_date);

        $this->db->where_in("xin_attendance_time.employee_id", $emp_id);
        $this->db->where("xin_attendance_time.status", "Present");
        $this->db->where('xin_employees.department_id = xin_departments.department_id');
        $this->db->where('xin_employees.designation_id = xin_designations.designation_id');
        $this->db->where('xin_employees.user_id = xin_attendance_time.employee_id');
        $data = $this->db->get()->result();
        if($data) {
            return $data;
        } else {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }



    public function early_out_report($attendance_date, $emp_id, $status)
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

        if($data) {
            return $data;
        } else {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }


    public function movement_report($attendance_date, $emp_id)
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

        if($data) {
            return $data;
        } else {
            return "<h4 style='color:red; text-align:center'>Requested list is empty</h4>";
        }
    }







    public function movment_status_report($f1_date, $f2_date, $statusC)
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
        if ($statusC!="all") {
            $this->db->where('xin_employee_move_register.status', $statusC);
        }
        $query = $this->db->get();
        $data = $query->result();



        if ($query->num_rows() > 0) {
            return $data;

        } else {
            return [];
        }
    }

  public function get_movement_register($id = null)
  {
      $this->db->select('
          empm.id, mr.title AS title, em.first_name, em.last_name, empm.employee_id AS emp_id, empm.date, empm.out_time, empm.in_time, empm.status
      ');

      $this->db->from('xin_employee_move_register as empm');

      if ($id != null) {
          $this->db->where('empm.employee_id', $id);
      }

      $this->db->join('xin_employees as em', 'em.user_id = empm.employee_id');
      $this->db->join('xin_employee_move_reason as mr', 'empm.reason = mr.id');

      $this->db->order_by('empm.id', 'DESC');

      return $this->db->get()->result();
  }



    public function apply_for_ta_da($id, $amount, $details)
    {

        $this->db->query("UPDATE  xin_employee_move_register
                       SET     `request_amount`  = '$amount',
                               `reason` = '$details',
                               `status`  = 1
                       WHERE   id        = '$id'
                    ");
        return "ok";
    }
    public function late_id($first_date, $second_date, $emp_id)
    {
        $this->db->select('xin_attendance_time.employee_id');
        $this->db->from('xin_attendance_time');
        $this->db->where('xin_attendance_time.attendance_date >=', $first_date);
        $this->db->where('xin_attendance_time.attendance_date <=', $second_date);
        $this->db->where('xin_attendance_time.late_status', 1);
        $this->db->where_in('xin_attendance_time.employee_id', $emp_id);
        $this->db->group_by('xin_attendance_time.employee_id');
        $subquery = $this->db->get_compiled_select();
        $this->db->select('employee_id');
        $this->db->from("($subquery) as subquery");
        $data = $this->db->get()->result();
        $lateid = array();
        foreach ($data as $row) {
            $lateid[] = $row->employee_id;
        }
       return $lateid;
    }

    public function update_ta_da($id, $amount, $status)
    {

        $this->db->query("UPDATE  xin_employee_move_register
                           SET     `payable_amount`  = '$amount',
                                   `status`  = '$status'
                           WHERE   id        = '$id'
                        ");
        return "update";
    }


    public function modify_for_ta_da($id)
    {
        $this->db->select("request_amount,reason,status")
                ->from('xin_employee_move_register')
                ->where('id', $id);
        return $result = $this->db->get()->result();
    }
    public function view_ta_da($id)
    {
        $this->db->select('emr.*, emd.*, e.first_name, e.last_name')
                ->from('xin_employee_move_register as emr')
                ->join('xin_employee_move_details as emd', 'emr.id = emd.move_id')
                ->join('xin_employees as e', 'emr.employee_id = e.user_id')
                ->where('emr.id', $id);

        $query = $this->db->get();
        return $query->result();
    }
    public function get_employee_ajax_request($status, $salary_month=null)
    {
        $left_employee=[];
        if ($salary_month != null) {
            $first_date=date('Y-m-01', strtotime($salary_month));
            $second_date=date('Y-m-t', strtotime($salary_month . ' +1 month'));
            $this->db->select('emp_id');
            $this->db->from('xin_employee_left_resign');
            $this->db->where('effective_date >=', $first_date);
            $this->db->where('effective_date <=', $second_date);
            $this->db->group_by('emp_id');
            $left_employee_array = $this->db->get()->result_array();
            $left_employee=array_column($left_employee_array, 'emp_id');
            //dd($left_employee);
        }
        $this->db->select('user_id as emp_id, first_name, last_name');
        if ($status == 1) {
            $this->db->where_in('status', array(1,4,5));
        } else if ($status == 2){
            $this->db->where_in('status', array(2,3));
            $this->db->where_in('user_id', $left_employee);
        }
        // $this->db->where('company_id', 1);
        $this->db->order_by('user_id', 'asc');
        return $result = $this->db->get('xin_employees')->result();
        // dd($result);
    }
    public function gettodaylog($date, $user_id)
    {
        $this->db->select('*');
        $this->db->from('xin_attendance_time');
        $this->db->where('employee_id', $user_id);
        $this->db->where('attendance_date', date('Y-m-d', strtotime($date)));
        $this->db->limit(1); // Limit the result to one row
        $data = $this->db->get()->row();
        return $data;
    }
    public function get_move_place()
    {
        $query = $this->db->order_by('place_id', 'DESC')->get('xin_employee_move_place');
        return $query->result();
    }
    public function add_move_place($data)
    {
        $this->db->insert('xin_employee_move_place', $data);
    }
    public function update_move_place($place_id, $data)
    {
        $this->db->where('place_id', $place_id);
        $this->db->update('xin_employee_move_place', $data);
    }
    public function delete_move_place($place_id)
    {
        $this->db->where('place_id', $place_id);
        $this->db->delete('xin_employee_move_place');
    }
    public function red_alert_check($id){
        // $this->db->where('leave_id', $id);
        // $data=$this->db->get('xin_leave_applications')->row();
        // $from_date=

    }
    public function get_total_meeting_monthly($first_date,$last_date){
        $this->db->select('xin_employee_move_register.*, xin_employees.first_name, xin_employees.last_name');
        $this->db->from('xin_employee_move_register');
        $this->db->join('xin_employees', 'xin_employees.user_id = xin_employee_move_register.employee_id');
        $this->db->where('date BETWEEN "'.$first_date.'" AND "'.$last_date.'"');
        return $this->db->get()->result();


    }
}
