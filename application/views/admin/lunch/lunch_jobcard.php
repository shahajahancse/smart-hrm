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

$active_meal = 0;
$inactive_meal  = 0;
$total_emp_cost  = 0;
$total_emp_cost   = 0;
$total_cost    = 0;
$this->load->model('lunch_model');

foreach ($all_employees as $key => $value) { 

	echo "<div style='min-height:700px; overflow:hidden;'>";
    $active_meal = 0;
    $inactive_meal  = 0;
    $total_emp_cost  = 0;
    $total_offic_cost   = 0;
    $total_cost    = 0;

	$this->load->view('admin/head_bangla');


	echo "<span style='font-size:13px; font-weight:bold;'>";
	echo "lunch Report from  $first_date -TO- $second_date";
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

	$emp_data = $this->lunch_model->get_data_date_wise($first_date,$second_date, $value->user_id);
	//  dd($emp_data['emp_data'] );

	
	echo "<table class='table table-bordered table-sm   table-striped sal mt-2' style='text-align:center; font-size:13px; '> 
		  <th>Date</th>
		  <th>Day</th>
		  <th>Quantity</th>
		  <th>Employee-Cost</th>
		  <th>Office-Cost</th>
		  <th>Total</th>
		  <th>Remarks</th>
		  ";

		foreach ($emp_data['emp_data'] as $key => $row) {
			echo "<tr>";
			
				echo "<td>&nbsp;";
				echo $row->date;
				echo "</td>";
						
				echo "<td>&nbsp;";
				if($row->date =="")
				{
					echo "&nbsp;";
				}
				else
				{
					echo date('l',strtotime($row->date));
				}
				echo "</td>";
				
				echo "<td>&nbsp;";
				echo $row->meal_amount;
				if($row->meal_amount>0){
                    $active_meal+=$row->meal_amount;
                }else{
                    $inactive_meal+=1;
                };
				echo "</td>";

				echo "<td>&nbsp;";
				echo $row->meal_amount*45;
                $total_emp_cost+=$row->meal_amount*45;
				echo "</td>";

				echo "<td>&nbsp;";
				echo $row->meal_amount*45;
                $total_offic_cost+=$row->meal_amount*45;
				echo "</td>";

				echo "<td>&nbsp;";
				echo $row->meal_amount*90;
                $total_cost+=$row->meal_amount*90;
				echo "</td>";

				echo "<td>&nbsp;";
				echo $row->comment;
				echo "</td>";
				
				
				
			echo "</tr>";
		}

	

	echo "</table>";
	
	echo "<br>";
	echo "<table class='table table-bordered table-sm' style='font-size:13px;'>";
	echo "<tr align='center'>";
			
	echo "<td>";
	echo "ACTIVE MEAL";
	echo "</td>";
			
	echo "<td>";
	echo "INACTIVE MEAL";
	echo "</td>";
			
	echo "<td>";
	echo "TOTAL EMPLOYEE COST ";
	echo "</td>";
			
	echo "<td>";
	echo "TOTAL OFFICE COST ";
	echo "</td>";
			
	
	echo "<td>";
	echo "TOTAL COST";
	echo "</td>";	
	echo "</tr>";
	
	echo "<tr align='center'>";
		
	echo "<td>";
	echo $active_meal;
	echo "</td>";

	echo "<td>";
	echo $inactive_meal;
	echo "</td>";
		
	echo "<td>";
	echo $total_emp_cost;
	echo "</td>";
	
	echo "<td>";
	echo $total_offic_cost;
	echo "</td>";
	
	echo "<td>";
	echo $total_cost;
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
