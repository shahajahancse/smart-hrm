<!DOCTYPE >
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Yerly Leave</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<style>

</style>


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
	echo "Yerly Leave Report of ";
	echo date('Y', strtotime($date));
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
			echo "<tr>";
			echo "<td colspan='2'>";
			echo "<strong>Leave Start From  :</strong>";
		
			echo date("d-M-Y", strtotime($value->leave_effective));
			echo "</td>";
	echo "</table>";

	$year = date('Y', strtotime($date));

	$total_leave=cals_leave($value->user_id,$year);

	$this->load->model('Attendance_model');
	$first_date=$year."-01-01";
	$second_date=$year."-12-31";
	$status = 2;
	$leave_report=$this->Attendance_model->leavesm_singale($value->user_id, $first_date, $second_date,$status);
	// [leave_id] => 107
	// [company_id] => 1
	// [employee_id] => 10
	// [department_id] => 0
	// [leave_type_id] => 1
	// [leave_type] => el
	// [qty] => 1.0
	// [from_date] => 2023-05-28
	// [to_date] => 2023-05-28
	// [applied_on] => 2023-06-06 12:51:35
	// [reason] => Grandma Death Issues (adjust 21-03-2023)
	// [remarks] => 
	// [status] => 2
	// [is_half_day] => 1
	// [notify_leave] => 0
	// [leave_attachment] => 
	// [team_lead_approved] => 0
	// [team_lead_comment] => 
	// [created_at] => 2023-06-06 12:51:35
	// [current_year] => 2023
	?>
<style>
	.table th{
		padding: 3px;
	}
	.table td{
		padding: 3px;
	}
</style>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Sl</th>
				<th>Applied On</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Days</th>
				<th>Leave Type</th>
				<th>Reason</th>
			</tr>
		</thead>
		<tbody>
			<?php $tqty=0; $e=0; $s=0; foreach($leave_report as $key => $value){?>
				<tr>
							<td><?php echo $key+1; ?></td>
							<td><?php echo date('d-F-Y H:i A', strtotime($value->applied_on)); ?> - (<?=date('l', strtotime($value->applied_on)) ?>)</td>
							<td><?php echo date('d-F-Y', strtotime($value->from_date)); ?> -  (<?=date('l', strtotime($value->from_date)) ?>)</td>
							<td><?php echo date('d-F-Y', strtotime($value->to_date)); ?> -  (<?=date('l', strtotime($value->to_date)) ?>)</td>
							<td><?php $tqty= $tqty+$value->qty;  echo $value->qty; ?></td>
							<?php
							if ($value->leave_type_id==1) {
								$e=$e+$value->qty;
							}else{
								$s=$s+$value->qty;
							}

							
							?>
							<td><?php echo ($value->leave_type_id==1)? '<span>Earn Leave</span>' : '<span>Sick Leave</span>';?></td>
							<td><?php echo $value->reason; ?></td>
							<!-- 1=pending, 2=Approved, 3=Rejected, 4=First Level Approval, 5=team lead approved -->
							
						</tr>
			<?php } ?>
		</tbody>

	</table>
	
	<table class="table table-bordered" >
		<tr><th colspan="3" style="text-align: center;">Leave Record </th></tr>
		<tr>
			<th>Type Of Leave</th>
			<th>Earn Leave</th>
			<th>Sick Leave</th>
		</tr>
		<tr>
			<td>Total</td>
			<td><?=(empty($total_leave))? 0:$total_leave->el_total?></td>
			<td><?= (empty($total_leave))? 0:$total_leave->sl_total?></td>
		</tr>
		<tr>
			<td> Obtained Leave</td>
			<td><?=(empty($total_leave))? 0:$e?></td>
			<td><?= (empty($total_leave))? 0:$s?></td>
		</tr>
		<tr>
			<td>Balance</td>
			<?php if(!empty($total_leave) && $total_leave->el_balanace>0): ?>
				<td style="color: #0b24e7; font-weight: bold;" ><?= $total_leave->el_balanace?></td>
			<?php else: ?>
				<td style="color: #0b24e7; font-weight: bold;" >0</td>
			<?php endif; ?>
			<?php if(!empty($total_leave) && $total_leave->sl_balanace>0): ?>
				<td style="color: #0b24e7; font-weight: bold;" ><?= $total_leave->sl_balanace?></td>
			<?php else: ?>
				<td style="color: #0b24e7; font-weight: bold;" >0</td>
			<?php endif; ?>
		</tr>
	</table>
								

	<div class="pageb"></div>		
<style>
@media print {
	.pageb {page-break-after: always;}
}
</style>
<?php	
 
}
?>
</div>
</body>
</html>
