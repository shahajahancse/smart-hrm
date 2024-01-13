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

	$year = date('Y', strtotime($date));

	$total_leave=cals_leave($value->user_id,$year);
	 ?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Type</th>
				<th>Earn Leave</th>
				<th>Sick Leave</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>Total Leave</td>
				<td><?=empty($total_leave)? 0: $total_leave->el_total ?></td>
				<td><?=empty($total_leave)? 0: $total_leave->sl_total ?></td>
			</tr>
			<tr>
				<td>Total Used Leave</td>
				<td><?=empty($total_leave)? 0: $total_leave->el_total-$total_leave->el_balanace ?></td>
				<td><?=empty($total_leave)? 0: $total_leave->sl_total -$total_leave->sl_balanace ?></td>
			</tr>
			<tr>
				<td>Total Balance Leave</td>
				<td><?=empty($total_leave)? 0:$total_leave->el_balanace ?></td>
				<td><?=empty($total_leave)? 0:$total_leave->sl_balanace ?></td>
			</tr>
		</tbody>

	</table>


<?php	
}
?>
</div>
</body>
</html>
