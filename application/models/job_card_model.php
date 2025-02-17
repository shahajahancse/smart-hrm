<?php
class Job_card_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function emp_job_card($grid_firstdate, $grid_seconddate, $emp_id)
	{
		$data = array();
		$grid_firstdate = date("Y-m-d", strtotime($grid_firstdate)); 
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

		$joining_check = $this->get_join_date($emp_id, $grid_firstdate, $grid_seconddate);
		if( $joining_check != false)
		{
			$start_date = $joining_check;
		}
		else
		{
			$start_date = $grid_firstdate;
		}
			
		$resign_check  = $this->get_resign_date($emp_id, $grid_firstdate, $grid_seconddate);
		if($resign_check != false)
		{
			$end_date = $resign_check;
		}
		else
		{
			$end_date = $grid_seconddate;
		}
			
		$left_check  = $this->get_left_date($emp_id, $grid_firstdate, $grid_seconddate);
		if($left_check != false)
		{
			$end_date = $left_check;
		}
		else
		{
			$end_date = $grid_seconddate;
		}
			

		$data['dayoff'] = $this->check_dayoff($start_date, $end_date, $emp_id);
		// $data['holiday'] = $this->check_holiday($start_date, $end_date, $emp_id);

		$data['leave'] = $this->leave_per_emp($start_date, $end_date, $emp_id);
		// echo "<pre>"; print_r($data['leave']); exit();
		
			
		$this->db->select('
				xin_attendance_time.clock_in , 
				xin_attendance_time.clock_out, 
				xin_attendance_time.lunch_in, 
				xin_attendance_time.lunch_out, 
				xin_attendance_time.attendance_date, 
				xin_attendance_time.attendance_status,
				xin_attendance_time.status,
				xin_attendance_time.comment,
				xin_attendance_time.late_status,
				xin_attendance_time.late_time,

			');
		$this->db->from('xin_attendance_time');
		$this->db->where('xin_attendance_time.employee_id', $emp_id);
		$this->db->where("xin_attendance_time.attendance_date >=", $start_date);
		$this->db->where("xin_attendance_time.attendance_date <=", $end_date);
		$this->db->order_by("xin_attendance_time.attendance_date");				
		$query = $this->db->get()->result();

		$data['emp_data'] = $query;
		// dd($data);

		return $data;
	}


	function absent_report($grid_firstdate, $grid_seconddate, $emp_id){
		$data = array();
		$grid_firstdate = date("Y-m-d", strtotime($grid_firstdate)); 
		$grid_seconddate = date("Y-m-d", strtotime($grid_seconddate));

		$joining_check = $this->get_join_date($emp_id, $grid_firstdate, $grid_seconddate);
		if( $joining_check != false)
		{
			$start_date = $joining_check;
		}
		else
		{
			$start_date = $grid_firstdate;
		}
			
		$resign_check  = $this->get_resign_date($emp_id, $grid_firstdate, $grid_seconddate);
		if($resign_check != false)
		{
			$end_date = $resign_check;
		}
		else
		{
			$end_date = $grid_seconddate;
		}
			
		$left_check  = $this->get_left_date($emp_id, $grid_firstdate, $grid_seconddate);
		if($left_check != false)
		{
			$end_date = $left_check;
		}
		else
		{
			$end_date = $grid_seconddate;
		}
			
			
		$this->db->select('
			clock_in , 
			clock_out, 
			lunch_in, 
			lunch_out, 
			attendance_date, 
			attendance_status,
			status,
			late_status, 
		');
		$this->db->from('xin_attendance_time');
		$this->db->where('employee_id', $emp_id);
		$this->db->where("attendance_date >=", $start_date);
		$this->db->where("attendance_date <=", $end_date);
		$this->db->where_in("status", ["Absent","HalfDay"]);
		$this->db->order_by("attendance_date");				
		$query = $this->db->get()->result();
		$data['emp_data'] = $query;
		return $data;
	}

	function get_meeting_remark($attendance_date,$user_id){
		$this->db->where('employee_id', $user_id);
		$this->db->where('date', $attendance_date);
		$query = $this->db->get('xin_employee_move_register')->row();
		if(!empty($query)){
			return 'Reason: '.$query->reason.' <br> Location: '.$query->place_adress.' <br> Project/Client name: '.$query->project_name.' <br> Contact person: '.$query->contact_person;
		}else{
			return 'N/A';
		}
	}

	function get_join_date($emp_id, $sStartDate, $sEndDate)
	{
		$this->db->select('date_of_joining');
		$this->db->where("date_of_joining BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("user_id = '$emp_id'");
		$query = $this->db->get("xin_employees");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $date_of_joining = $row->date_of_joining;
		}
		else
		{
			return false;
		}
	}

	function get_resign_date($emp_id, $sStartDate, $sEndDate)
	{
		$this->db->select('resign_date');
		$this->db->where("resign_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("xin_employee_resign");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $resign_date = $row->resign_date;
		}
		else
		{
			return false;
		}
	}

	function get_left_date($emp_id, $sStartDate, $sEndDate)
	{
		$this->db->select('left_date');
		$this->db->where("left_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("xin_employee_left");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $resign_date = $row->left_date;
		}
		else
		{
			return false;
		}
	}

	function check_dayoff($sStartDate, $sEndDate, $emp_id)
	{	
		$days = GetDayDate($sStartDate, $sEndDate);
		$off_day = array('Friday','Saturday');
		$dayoff = array();

		foreach ($days as $row)
		{
			if ($row->date == '2023-03-25' || $row->date == '2023-04-15') {
	            $off_day = array('Friday','Saturday');
	        } else if ($row->date < '2023-04-20' && $row->date > '2023-03-10') {
	            $off_day = array('Friday');
	        }
			if (in_array($row->day, $off_day)) {
				$dayoff[] = $row->date;
			}
		}
		return $dayoff;
	}

	function check_holiday($sStartDate, $sEndDate, $emp_id)
	{
		$this->db->select("start_date");
		$this->db->where("start_date BETWEEN '$sStartDate' AND '$sEndDate'");
		// $this->db->where("user_id = '$emp_id'");
		$query = $this->db->get("xin_holidays");
		$holiday = array();
		foreach ($query->result() as $row)
		{
			$holiday[] = $row->start_date;
		}
		return $holiday;
	}

	









	// old

	function leave_per_emp($sStartDate, $sEndDate, $emp_id){
 		$this->db->select("*");		
 		$this->db->where("((from_date <= '$sStartDate' AND to_date >='$sEndDate') OR (from_date <= '$sStartDate' AND to_date >= '$sStartDate') OR (from_date >= '$sStartDate' AND to_date <= '$sEndDate') OR (from_date <= '$sEndDate' AND to_date >= '$sEndDate')) AND (employee_id = '$emp_id')");
		$query = $this->db->get("xin_leave_applications");
		$leave = array();

		foreach ($query->result() as $row){
			$diff=$row->qty;
			$start_date = $row->from_date;
			for($i=0; $i<$diff; $i++){
				if($sEndDate >= $start_date && $sStartDate <= $start_date)		$leave[] = $start_date;	
					$start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
		    }
		}
		return $leave;
	}


	function holiday_calculation($sStartDate, $sEndDate, $emp_id)
	{
		$this->db->select("holy_off_date as start_date");
		$this->db->where("holy_off_date BETWEEN '$sStartDate' AND '$sEndDate'");
		$this->db->where("emp_id = '$emp_id'");
		$query = $this->db->get("pr_holiday");
		$holiday = array();
		foreach ($query->result() as $row)
		{
			$holiday[] = $row->start_date;
		}
		return $holiday;
	}

	function emp_shift_check($emp_id, $att_date)
	{
		$this->db->select("shift_id, shift_duty");
		$this->db->from("xin_attendance_time");
		$this->db->where("emp_id", $emp_id);
		$this->db->where("attendance_date", $att_date);
		$query = $this->db->get();

		if($query->num_rows() > 0 )
		{
			/*foreach($query->result() as $row)
			{
				$shift_duty = $row->shift_duty;
			}*/

			$shift_duty = $query->row()->shift_duty;

			$this->db->select("sh_type");
			$this->db->from("pr_emp_shift_schedule");
			$this->db->where("shift_id", $shift_duty);
			$query1 = $this->db->get();
			$row = $query1->row();
			return $row->sh_type;
		}
		else
		{
			$this->db->select("pr_emp_shift_schedule.sh_type");
			$this->db->from("pr_emp_shift_schedule");
			$this->db->from("pr_emp_shift");
			$this->db->from("pr_emp_com_info");
			$this->db->where("pr_emp_com_info.emp_id", $emp_id);
			$this->db->where("pr_emp_shift.shift_id = pr_emp_com_info.emp_shift");
			$this->db->where("pr_emp_shift.shift_duty = pr_emp_shift_schedule.shift_id");
			$query = $this->db->get();
			$row = $query->row();
			return $row->sh_type;
		}
	}

	function schedule_check($emp_shift)
	{
		$this->db->where("sh_type", $emp_shift);
		$query = $this->db->get("pr_emp_shift_schedule");
		return $query->result_array();
	}

   function get_leave_type($attendance_date,$emp_id)
   {
   		$this->db->select('leave_type');
		$this->db->where('employee_id', $emp_id);
		//$this->db->where('start_date', $shift_log_date);
		$this->db->where("from_date <=", $attendance_date);
		$this->db->where("to_date >=", $attendance_date);
		$query = $this->db->get('xin_leave_applications');
		return $query->row()->leave_type; 
   }


	function get_short_leave_timing($emp_id,$date)
	{
		$data = array();
		$this->db->select('pr_gate_pass.short_leave_out_time,pr_gate_pass.short_leave_in_time');
		$this->db->where('emp_id',$emp_id);
		$this->db->where('entry_date',$date);
		$query = $this->db->get('pr_gate_pass');
		//echo $this->db->last_query();
		$num_rows = $query->num_rows();

		if($num_rows < 1)
		{
			return "False";
		}

		$query = $query->row();
		$data['short_leave_out_time'] 	= $query->short_leave_out_time;
		$data['short_leave_in_time'] 	= $query->short_leave_in_time;
		return $data;
	}


	function time_am_pm_format($out_time)
	{
		$hour   = substr($out_time,0,2);
		$minute = substr($out_time,3,2);
		$second = substr($out_time,6,2);
		return $time_format = date("h:i:s A", mktime($hour, $minute, $second, 0, 0, 0));
	}

	function get_formated_out_time_2hours_ot($emp_id, $out_time, $emp_shift, $deduction_hour)
	{
		//echo $out_time;
		if($out_time =='00:00:00')
		{
			return $out_time ='';
		}

		$schedule 				= $this->schedule_check($emp_shift);
		$out_start				= $schedule[0]["out_start"];
		$ot_start				= $schedule[0]["ot_start"];
		$one_hour_ot_out_time	= $schedule[0]["one_hour_ot_out_time"];
		$two_hour_ot_out_time	= $schedule[0]["two_hour_ot_out_time"];
		$three_hour_ot_out_time	= "20:00:00";

		if($out_start <= $out_time)
		{
			if($ot_start > $out_time)
			{
				return $out_time = $this->time_am_pm_format($out_time);
			}
			elseif($one_hour_ot_out_time > $out_time )
			{
				if($out_time < '17:30:00')
				{
					return $out_time = $this->time_am_pm_format($out_time);
				}
				return $out_time = $this->time_am_pm_format($out_time);
			}
			elseif($two_hour_ot_out_time > $out_time)
			{
				if($out_time < '17:30:00')
				{
					return $out_time = $this->time_am_pm_format($out_time);
				}
				elseif($out_time < '19:00:00'){
					return $out_time = $this->time_am_pm_format($out_time);
				}
				return $out_time = $this->get_buyer_in_time($two_hour_ot_out_time ,$out_time);
			}
			else
			{
				if($out_time < '17:30:00')
				{
					return $out_time = $this->time_am_pm_format($out_time);
				}
				return $out_time = $this->get_buyer_in_time($two_hour_ot_out_time ,$out_time);
			}
		}
		elseif ($out_start >= $out_time AND $deduction_hour > 0) {
			return $out_time = $this->time_am_pm_format($out_time);
		}
		 else
		{
		return $out_time = $this->get_buyer_in_time($two_hour_ot_out_time ,$out_time);
		}
	}


	function get_hour_min_sec($time)
	{
		$data = array();
		$data['hour']   = substr($time,0,2);
		$data['minute'] = substr($time,3,2);
		$data['second'] = substr($time,6,2);
		return $data;
	}

	function create_buyer_minute($minute)
	{
		$min_1st_digit = substr($minute,0,1);
		$min_2nd_digit = substr($minute,1,1);
		$buyer_minute  = $min_1st_digit + $min_2nd_digit;
		$rand_min = rand(1,2);
		$buyer_minute = $rand_min;
		return $buyer_minute;
	}



}