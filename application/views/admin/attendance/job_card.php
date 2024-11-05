<!DOCTYPE >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Job Card</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
<div class="container" align="center">

<?php
// dd($all_employees);

$present_count = 0;
$extrap_count  = 0;
$absent_count  = 0;
$leave_count   = 0;
$late_count    = 0;
$day_off_count = 0;
$holiday_count = 0;
$perror_count  = 0;


$this->load->model('Job_card_model');

foreach ($all_employees as $key => $value) { 

	echo "<div style='min-height:700px; overflow:hidden;'>";
	$present_count = 0;
	$extrap_count  = 0;
	$absent_count  = 0;
	$leave_count   = 0;
	$late_count    = 0;
	$day_off_count = 0;
	$holiday_count = 0;
	$perror_count  = 0;
	$att_status_check = false;

	$this->load->view('admin/head_bangla');


	echo "<span style='font-size:13px; font-weight:bold;'>";
	echo "Job Card Report from  $first_date -TO- $second_date";
	echo "</span>";
	echo "<br /><br />";
	
	echo "<table border='0' style='font-size:13px;' width='480'>";
		echo "<tr>";
		echo "<td width='70'>";
		echo "<strong>Emp ID:</strong>";
		echo "</td>";
		echo "<td width='200'>";
		echo $value->employee_id;
		echo "</td>";
		
		echo "<td width='55'>";
		echo "<strong>Name :</strong>";
		echo "</td>";
		echo "<td width='150'>";
		echo $value->first_name ." ". $value->last_name;
		echo "</td>";
		echo "</tr>";
		

		echo "<tr>";
		echo "<td>";
		echo "<strong>Dept :</strong>";
		echo "</td>";
		echo "<td>";
		echo $value->department_name;
		echo "</td>";
		echo "<td>";
		echo "<strong>Desig :</strong>";
		echo "</td>";
		echo "<td>";
		echo $value->designation_name;
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>";
		echo "<strong>DOJ :</strong>";
		echo "</td>";
		echo "<td>";
		echo date("d-M-Y", strtotime($value->date_of_joining));
		echo "</td>";
		
		echo "<td >";
		echo "<strong>DOB :</strong>";
		echo "</td>";
		echo "<td >";
		echo date("d-M-Y", strtotime($value->date_of_birth));
		echo "</td>";
		echo "</tr>";
	echo "<table>";

	$emp_data = $this->Job_card_model->emp_job_card($first_date,$second_date, $value->user_id);
	// dd($emp_data);

	
	echo "<table class='table table-bordered table-sm   table-striped sal mt-2' style='text-align:center; font-size:13px; '> 
		  <th>Date</th>
		  <th>In Time</th>
		  <th>Out Time</th>
		  <th>Lunch Out Time</th>
		  <th>Lunch In Time</th>
		  <th>Attendance Status</th>
		  <th>Remarks</th>
		  <th>Comment</th>
		  ";

		foreach ($emp_data['emp_data'] as $key => $row) {
			$meeting_comment =$this->Job_card_model->get_meeting_remark($row->attendance_date,$value->user_id);

			// if(in_array($row->attendance_date,$emp_data['leave']))
			if($row->status == 'Leave')
			{
				$leave_type = $this->Job_card_model->get_leave_type($row->attendance_date,$value->user_id);
				$att_status = $leave_type;
				$leave_count++;
				// $row->clock_in = "";
				// $row->clock_out = "";
			}
			elseif($row->status == 'Hleave')
			{
				$leave_type = $this->Job_card_model->get_leave_type($row->attendance_date,$value->user_id);
				$att_status = $leave_type;
				$leave_count = $leave_count + 0.5;

				if ($row->attendance_status == 'HalfDay' && $row->status == 'Hleave') {
					$att_status = $leave_type .'  + HalfDay';
					$present_count = $present_count + 0.5;
				}
			}
			elseif($row->status == 'Holiday')
			// elseif(in_array($row->attendance_date,$emp_data['holiday']))
			{
				$att_status = "Holiday";
				$holiday_count++;
				if ($row->attendance_status == 'Present' && $row->status == 'Holiday') {
					$extrap_count = $extrap_count + 1;
					$att_status = '(Holiday + P)';
				} else {
					$row->clock_in = "";
					$row->clock_out = "";
				}
				
			} 
			// elseif(in_array($row->attendance_date,$emp_data['dayoff']))
			elseif($row->status == 'Off Day')
			{
				$att_status = "Day Off";
				$day_off_count++;
				if ($row->attendance_status == 'Present' && $row->status == 'Off Day') {
					$extrap_count = $extrap_count + 1;
					$att_status = '(Off Day + P)';
				} else {
					$row->clock_in = "";
					$row->clock_out = "";
				}
				
			} 
			else if ($row->attendance_status == 'HalfDay' && $row->status == 'HalfDay') {
				$present_count = $present_count + 0.5;
				$att_status = 'HalfDay';
				$absent_count = $absent_count + 0.5;
			}
			elseif(($row->clock_in !='' && $row->clock_out !=''))
			{
				$att_status = "P";
				$present_count++;
				if ($row->attendance_status == 'Meeting') {
					$att_status = 'P';
				}
			}
			elseif($row->clock_in !='' || $row->clock_out !='')
			{
				if($row->clock_in != '' &&  $row->clock_out == '') {
					$att_status = 'HalfDay';
                }elseif($row->clock_in == '' &&  $row->clock_out != '') {
                    $att_status ='Absent';
                }else{
					$att_status = 'There is an error';
				}

			}
			else
			{
				$att_status = "A";
				$absent_count++;
			}
			echo "<tr>";
				echo "<td>&nbsp;";
				echo $row->attendance_date;
				echo "</td>";
				
				echo "<td>&nbsp;";
				if($row->clock_in == "")
				{
					echo "&nbsp;";
				}
				else
				{
					echo date('h:i:s a',strtotime($row->clock_in));
				}
				echo "</td>";
						
				echo "<td>&nbsp;";
				if($row->clock_out =="")
				{
					echo "&nbsp;";
				}
				else
				{
					echo date('h:i:s a',strtotime($row->clock_out));
				}
				echo "</td>";
				if($row->late_status == 1)
				{
					$remark = "Late (" . $row->late_time. "m)";
					$late_count++;
				}
				else
				{
					$remark = "";
				}
				echo "<td>&nbsp;";
				echo $row->lunch_out!=null? date('h:i:s a',strtotime($row->lunch_out)):'';
				echo "</td>";
				
				echo "<td>&nbsp;";
				echo $row->lunch_in!=null?  date('h:i:s a',strtotime($row->lunch_in)):'';
				echo "</td>";
				echo "<td style='text-transform:uppercase;'>&nbsp;";
				echo $att_status;
				echo "</td>";
				echo "<td>&nbsp;";
				echo $remark;
				echo "</td>";
				echo "<td>&nbsp;";
				echo $row->comment;
				echo "&nbsp";
				echo isset($meeting_comment) ? $meeting_comment : '';
				$meeting_comment='';
				echo "</td>";
			echo "</tr>";
		}
	echo "</table>";
	echo "<br>";
	echo "<table class='table table-bordered table-sm' style='font-size:13px;'>";
	echo "<tr align='center'>";
			
	echo "<td>";
	echo "PRESENT";
	echo "</td>";
			
	echo "<td>";
	echo "EXTRA PRESENT";
	echo "</td>";
			
	echo "<td>";
	echo "ABSENT";
	echo "</td>";
			
	echo "<td>";
	echo "LEAVE";
	echo "</td>";
			
	
	echo "<td>";
	echo "DAY OFF";
	echo "</td>";
			
	echo "<td>";
	echo "HOLIDAY";
	echo "</td>";
	
	echo "<td>";
	echo "PRESENT ERROR";
	echo "</td>";
		
	echo "<td>";
	echo "LATE COUNT";
	echo "</td>";
	
	// echo "<td>";
	// echo "OVERTIME";
	// echo "</td>";
			
	echo "</tr>";
			
	echo "<tr align='center'>";
		
	echo "<td>";
	echo $present_count;
	echo "</td>";

	echo "<td>";
	echo $extrap_count;
	echo "</td>";
		
	echo "<td>";
	echo $absent_count;
	echo "</td>";
	
	echo "<td>";
	echo $leave_count;
	echo "</td>";
	
	echo "<td>";
	echo $day_off_count;
	echo "</td>";

	echo "<td>";
	echo $holiday_count;
	echo "</td>";
	
	echo "<td>";
	echo $perror_count;
	echo "</td>";
	
	echo "<td>";
	echo $late_count;
	echo "</td>";

	
	echo "</tr>";
	echo "</table>";
	echo "<br /><br />";
	
	echo "</div>";
	echo "<br>";
	echo "<div style='page-break-after: always;'></div>";

}
?>

</div>
</body>
</html>
