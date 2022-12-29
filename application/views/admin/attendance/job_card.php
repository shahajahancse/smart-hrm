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
$absent_count  = 0;
$leave_count   = 0;
$late_count    = 0;
$day_off_count = 0;
$holiday_count = 0;


$this->load->model('job_card_model');

foreach ($all_employees as $key => $value) { 

	echo "<div style='min-height:700px; overflow:hidden;'>";
	$present_count = 0;
	$absent_count  = 0;
	$leave_count   = 0;
	$late_count    = 0;
	$day_off_count = 0;
	$holiday_count = 0;
	$perror_count  = 0;

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

	$emp_data = $this->job_card_model->emp_job_card($first_date,$second_date, $value->user_id);
		// echo "<pre>";	print_r($emp_data); exit;

	
	echo "<table class='table table-bordered table-sm   table-striped sal mt-2' style='text-align:center; font-size:13px; '> 
		  <th>Date</th>
		  <th>In Time</th>
		  <th>Out Time</th>
		  <th>Lunch Out Time</th>
		  <th>Lunch In Time</th>
		  <th>Attendance Status</th>
		  <th>Remarks</th>
		  ";

		foreach ($emp_data['emp_data'] as $key => $row) {

			if(in_array($row->attendance_date,$emp_data['leave']))
			{
				$leave_type = $this->job_card_model->get_leave_type($row->attendance_date,$value->employee_id);
				$att_status_count = "Leave";
				$att_status = $leave_type;
				$row->clock_in = "";
				$row->clock_out = "";
			}
			elseif(in_array($row->attendance_date,$emp_data['holiday']))
			{
				$att_status = "Holiday";
				$att_status_count = "Holiday";
				$row->clock_in = "";
				$row->clock_out = "";
				
			} 
			elseif(in_array($row->attendance_date,$emp_data['dayoff']))
			{
				$att_status = "Day Off";
				$att_status_count = "Day Off";
				$row->clock_in = "";
				$row->clock_out = "";
				
			}
			elseif(($row->clock_in !='' && $row->clock_out !=''))
			{
				$att_status = "P";
				$att_status_count = "P";
			}
			elseif($row->clock_in !='' || $row->clock_out !='')
			{
				$att_status = "P(Error)";
				$att_status_count = "P(Error)";
			}
			else
			{
				$att_status = "A";
				$att_status_count = "A";
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
					echo date('H:i:s a',strtotime($row->clock_in));
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
				

				
				if($att_status == "P")
				{
					$present_count++;
				}
				elseif($att_status == "A")
				{
					$absent_count++;
				}
				elseif($att_status_count == "Leave")
				{
					$leave_count++;
				}
				elseif($att_status == "P(Error)")
				{
					$perror_count++;
				}
				elseif($att_status == "Work Off")
				{
					$wk_off_count++;
				}
				elseif($att_status == "Day Off")
				{
					$day_off_count++;
				}
				elseif($att_status == "Holiday")
				{
					$holiday_count++;
				}

				if($row->late_status == 1)
				{
					$remark = "Late";
					$late_count++;
				}
				else
				{
					$remark = "";
				}
				
				
				echo "<td>&nbsp;";
				echo $row->lunch_out==null || $row->lunch_out==''?"": date('h:i:s a',strtotime($row->lunch_out));
				echo "</td>";
				
				echo "<td>&nbsp;";
				echo $row->lunch_out==null || $row->lunch_out==''?"":  date('h:i:s a',strtotime($row->lunch_in));
				echo "</td>";

				echo "<td style='text-transform:uppercase;'>&nbsp;";
				echo $att_status;
				echo "</td>";
				
				echo "<td>&nbsp;";
				echo $remark;
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
}
?>

</div>
</body>
</html>
