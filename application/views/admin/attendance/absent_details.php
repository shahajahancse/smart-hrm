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

$absent_count  = 0;
$this->load->model('Job_card_model');

foreach ($all_employees as $key => $value) { 
	$emp_data = $this->Job_card_model->absent_report($first_date,$second_date, $value->user_id);
	$m_absent=0;
	foreach ($emp_data['emp_data'] as $key => $row) {
		if($row->attendance_status == 'HalfDay' && $row->status == 'HalfDay') {
			$att_status = 'Half Day Absent';
			$m_absent = $absent_count + 0.5;
		}else{
			$att_status = "Absent";
			$m_absent++;
		}
	}
	if ($m_absent == 0) {
		continue;
	}



	echo "<div style='min-height:700px; overflow:hidden;'>";
	$absent_count  = 0;
	$this->load->view('admin/head_bangla');


	echo "<span style='font-size:13px; font-weight:bold;'>";
	echo "Absent Card Report from  $first_date -TO- $second_date";
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

	// dd($emp_data);

	
	echo "<table class='table table-bordered table-sm   table-striped sal mt-2' style='text-align:center; font-size:13px; '> 
		  <th>Date</th>
		  <th>Attendance Status</th>
		  ";

		foreach ($emp_data['emp_data'] as $key => $row) {
			if($row->attendance_status == 'HalfDay' && $row->status == 'HalfDay') {
				$att_status = 'Half Day Absent';
				$absent_count = $absent_count + 0.5;
			}else{
				$att_status = "Absent";
				$absent_count++;
			}
				
				
			    echo "<tr>";
				echo "<td>&nbsp;";
				echo $row->attendance_date;
				echo "</td>";
				
				echo "<td style='text-transform:uppercase;'>&nbsp;";
				echo $att_status;
				echo "</td>";
			    echo "</tr>";
                echo "<tr align='center'>";

		}
	echo "<tr align='center'>";
                echo "<td>";
                echo "Total Absent";
                echo "</td>";	

                echo "<td>";
                echo $absent_count;
                echo "</td>";

    echo "</tr>";

	echo "</table>";
}
?>
</div>
</body>
</html>
