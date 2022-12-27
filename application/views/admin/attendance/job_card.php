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

// $count = count($values);
$this->load->model('job_card_model');

// for($i = 0; $i<$count;$i++)
// {
foreach ($values as $key => $value) { 

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

	$this->load->view('head_english');
	echo "<span style='font-size:13px; font-weight:bold;'>";
	echo "Job Card Report from  $grid_firstdate -TO- $grid_seconddate";
	echo "</span>";
	echo "<br /><br />";
	
	echo "<table border='0' style='font-size:13px;' width='480'>";
	echo "<tr>";
	echo "<td width='70'>";
	echo "<strong>Emp ID:</strong>";
	echo "</td>";
	echo "<td width='200'>";
	echo $value->emp_id;
	echo "</td>";
	
	echo "<td width='55'>";
	echo "<strong>Name :</strong>";
	echo "</td>";
	echo "<td width='150'>";
	echo $value->emp_full_name;
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td >";
	echo "<strong>Proxi NO. :</strong>";
	echo "</td>";
	echo "<td >";
	echo $value->proxi_id;
	echo "</td>";
	
	echo "<td style:width:20px'>";
	echo "<strong>Section :</strong>";
	echo "</td>";
	echo "<td width='30px'>";
	echo $value->sec_name;
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "<strong>Line :</strong>";
	echo "</td>";
	echo "<td>";
	echo $value->line_name;
	echo "</td>";
	echo "<td>";
	echo "<strong>Desig :</strong>";
	echo "</td>";
	echo "<td>";
	echo $value->desig_name;
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "<strong>DOJ :</strong>";
	echo "</td>";
	echo "<td>";
	echo date("d-M-Y", strtotime($value->emp_join_date));
	echo "</td>";
	
	echo "<td >";
	echo "<strong>Dept :</strong>";
	echo "</td>";
	echo "<td >";
	echo $value->dept_name;
	echo "</td>";
	echo "</tr>";
	echo "<table>";
	
	// $count1 = count($values[$emp_id]["shift_log_date"]);
	$emp_data = $this->job_card_model->emp_job_card($grid_firstdate,$grid_seconddate, $value->emp_id,$value->desig_id);
		// echo "<pre>";	print_r($emp_data); exit;

	
	echo "<table class='sal' border='1' bordercolor='#000000' cellspacing='0' cellpadding='0' style='text-align:center; font-size:13px; '> <th>Date</th><th>In Time</th><th>Out Time</th><th>Attn.Status</th><th>Overtime</th><th>Lunch Out Time</th><th>Lunch IN Time</th><th>Late</th><th>Before 5PM</th><th>Remarks</th>";

		foreach ($emp_data['emp_data'] as $key => $row) {

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
				echo $formated_ot_hour = $this->common_model->ot_minutes_to_fraction($late_min);
				echo "</td>";
				
				echo "<td>&nbsp;";
				echo $formated_ot_hour = $this->common_model->ot_minutes_to_fraction($deduction_hour);
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
	echo $formated_ot_hour = $this->common_model->ot_minutes_to_fraction($total_ot_hour);
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
