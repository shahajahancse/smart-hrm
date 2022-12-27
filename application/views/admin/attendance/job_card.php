<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Job Card</title>
<link rel="stylesheet" type="text/css" href="../../../../../css/SingleRow.css" />
</head>

<body>
<div align="center" style="height:100%; width:100%; overflow:hidden;" >

<?php
//print_r($values);

$present_count = 0;
$absent_count = 0;
$leave_count = 0;
$ot_count = 0;
$late_count = 0;
$wk_off_count = 0;
$day_off_count = 0;
$holiday_count = 0;


$this->load->model('job_card_model');

foreach ($all_employees as $key => $value) { 

	echo "<div style='min-height:1000px; overflow:hidden;'>";
	$present_count = 0;
	$absent_count = 0;
	$leave_count = 0;
	$ot_count = 0;
	$late_count = 0;
	$wk_off_count = 0;
	$day_off_count = 0;
	$holiday_count = 0;
	$perror_count = 0;
	$total_ot_hour = 0;

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

	
	echo "<table class='sal' border='1' bordercolor='#000000' cellspacing='0' cellpadding='0' style='text-align:center; font-size:13px; '> <th>Date</th><th>In Time</th><th>Out Time</th><th>Attn.Status</th><th>Overtime</th><th>Lunch Out Time</th><th>Lunch IN Time</th><th>Late</th><th>Before 5PM</th><th>Remarks</th>";

		foreach ($emp_data['emp_data'] as $key => $row) {

			if(in_array($row->shift_log_date,$emp_data['leave']))
			{
				$leave_type = $this->job_card_model->get_leave_type($row->shift_log_date,$value->emp_id);
				$att_status_count = "Leave";
				$att_status = $leave_type;
				$row->in_time = "00:00:00";
				$row->out_time = "00:00:00";
			}
			elseif(in_array($row->shift_log_date,$emp_data['holiday']))
			{
				$att_status = "Holiday";
				$att_status_count = "Holiday";
				$row->in_time = "00:00:00";
				$row->out_time = "00:00:00";
				$row->ot_hour ="";
			} 
			elseif(in_array($row->shift_log_date,$emp_data['dayoff']))
			{
				$att_status = "Day Off";
				$att_status_count = "Day Off";
				$row->in_time = "00:00:00";
				$row->out_time = "00:00:00";
				$row->ot_hour ="";
			}
			elseif($row->in_time !='00:00:00' and $row->out_time !='00:00:00')
			{
				$att_status = "P";
				$att_status_count = "P";
			}
			elseif($row->in_time !='00:00:00' or $row->out_time !='00:00:00')
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
				echo $shift_log_date;
				echo "</td>";
				
				echo "<td>&nbsp;";
				if($in_time == "00:00:00")
				{
					echo "&nbsp;";
				}
				else
				{
					echo $in_time;
				}
				echo "</td>";
						
				echo "<td>&nbsp;";
				if($out_time =="00:00:00")
				{
					echo "&nbsp;";
				}
				elseif($value->emp_id =='10007895' && $shift_log_date =='10-Jul-18')
				{
				   echo "&nbsp;";	
				}
				else
				{
					echo $out_time;
				}
				echo "</td>";
				
				echo "<td style='text-transform:uppercase;'>&nbsp;";
				echo $att_status;
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
				if($row->ot_hour == 0)
				{
					echo "&nbsp;";
				}
				else
				{
					echo $formated_ot_hour = $this->common_model->ot_minutes_to_fraction($row->ot_hour);
				}
				echo "</td>";
				
				$total_ot_hour = $total_ot_hour + $row->ot_hour;

				
				echo "<td>&nbsp;";
				echo $lunch_out;
				echo "</td>";
				
				echo "<td>&nbsp;";
				echo $lunch_in;
				echo "</td>";
				
				
				echo "<td>&nbsp;";
				// echo $formated_ot_hour = $this->common_model->ot_minutes_to_fraction($late_min);
				echo 0;
				echo "</td>";
				
				echo "<td>&nbsp;";
				echo 0;
				echo "</td>";
				
				echo "<td>&nbsp;";
				echo $remark;
				echo "</td>";
				
			echo "</tr>";
		}

	

	echo "</table>";
	
	echo "<br>";
	echo "<table border='0' style='font-size:13px;'>";
	echo "<tr align='center'>";
			
	echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
	echo "PRESENT";
	echo "</td>";
			
	echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
	echo "ABSENT";
	echo "</td>";
			
	echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
	echo "LEAVE";
	echo "</td>";
			
	echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
	echo "WORK OFF";
	echo "</td>";
	
	echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
	echo "DAY OFF";
	echo "</td>";
			
	echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
	echo "HOLIDAY";
	echo "</td>";
	
	echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
	echo "PRESENT ERROR";
	echo "</td>";
		
	echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
	echo "LATE COUNT";
	echo "</td>";
	
	echo "<td width='75' style='border-bottom:#000000 1px solid;'>";
	echo "OVERTIME";
	echo "</td>";
			
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
	echo $wk_off_count;
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

	
	echo "<td>";
	echo 0;
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
