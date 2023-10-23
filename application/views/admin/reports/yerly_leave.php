<!DOCTYPE >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Yerly Leave</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
<div class="container" align="center">

<?php
// dd($all_employees);

$absent_count  = 0;
$this->load->model('Job_card_model');

foreach ($all_employees as $key => $value) { 

	echo "<div style='min-height:700px; overflow:hidden;'>";
	$absent_count  = 0;
	$this->load->view('admin/head_bangla');


	echo "<span style='font-size:13px; font-weight:bold;'>";
	echo "Yerly Leave Report";
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

	$leave_calel=get_cal_leave($value->user_id, 1);
    $leave_calsl=get_cal_leave($value->user_id, 2);
    $totaluseleave=$leave_calel+$leave_calsl;
	// dd($emp_data);

	
	echo "<table class='table table-bordered table-sm   table-striped sal mt-2' style='text-align:center; font-size:13px; '> 
		  <th>Date</th>
		  <th>Attendance Status</th>
		  ";

	echo "<tr align='center'>";
                echo "<td>";
                echo "Total Earn Leave";
                echo "</td>";	

                echo "<td>";
                echo 12-$leave_calel;
                echo "</td>";

    echo "</tr>";
	echo "<tr align='center'>";
                echo "<td>";
                echo "Total Sick Leave";
                echo "</td>";	

                echo "<td>";
                echo 4-$leave_calsl;
                echo "</td>";

    echo "</tr>";
	echo "<tr align='center'>";
                echo "<td>";
                echo "Total  Leave";
                echo "</td>";	

                echo "<td>";
                echo 16-$totaluseleave;
                echo "</td>";

    echo "</tr>";

	echo "</table>";
}
?>
</div>
</body>
</html>
