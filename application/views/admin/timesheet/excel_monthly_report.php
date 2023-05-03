


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
<?php
exit("hello");

	$filename = "Salary_$salary_month.xls";
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
?>


	<table align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">
		<tr height="85px">
			<td colspan="23" style="text-align:center;">
				<div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
				<div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
				<div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;"> <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
				<div>Salary Month : <?php echo $salary_month; ?></div>
				<div style="font-size:12px; font-weight:bold; text-align:center;"></div>
				<div style="font-size:12px; font-weight:bold; text-align:center;"></div>
			</td>
		</tr>

		<tr>
			<th>SL</th>
			<th>Emp ID</th>
			<td>Employee Name</td>
			<td>Department Name</td>
			<td>Designation Name</td>
			<th>Joining Date</th>
			<td>Bank Account</td>
			<th>Salary month</th>
			<th>Salary</th>
			<th>Present</th>
			<th>Extra Present</th>
			<th>Absent</th>
			<th>Holiday</th>
			<th>Weekend</th>
			<th>Earn leave</th>
			<th>Sick leave</th>
			<th>Late count</th>
			<th>Late deduct</th>
			<th>Absent deduct</th>
			<th>Extra P. Pay</th>
			<th>Modify salary</th>
			<th>Net salary</th>
			<th>Total net salary</th>
		</tr>

		<?php  $grand_total = $net_total = $modify_total = $etra_pay = $ab_deduct = $late_deduct = 0;
		foreach ($values as $key => $row) { 
			$grand_total =  $grand_total + $row->grand_net_salary + ($row->modify_salary);
			$net_total =    $net_total + $row->net_salary;
			$modify_total = $modify_total + ($row->modify_salary);
			$etra_pay =     $etra_pay + $row->extra_pay;
			$ab_deduct =    $ab_deduct + $row->absent_deduct;
			$late_deduct =  $late_deduct + $row->late_deduct;

			?>
			<tr>
				<td class="text-center px-2"><?= ($key + 1) ?>.</td>
				<td class="text-center px-2"><?=$row->employee_id?></td>			
				<td class="text-center px-2"><?=$row->first_name .' '. $row->last_name?></td>			
				<td class="text-center px-2"><?=$row->department_name?></td>			
				<td class="text-center px-2"><?=$row->designation_name?></td>
				<td class="text-center px-2"><?=$row->date_of_joining?></td>
				<td class="text-center px-2"><?=$row->account_number?></td>
				<td class="text-center px-2"><?=$row->salary_month?></td>
				<td class="text-center px-2"><?=$row->basic_salary?></td>
				<td class="text-center px-2"><?=$row->present?></td>
				<td class="text-center px-2"><?=$row->extra_p?></td>
				<td class="text-center px-2"><?=$row->absent?></td>
				<td class="text-center px-2"><?=$row->holiday?></td>
				<td class="text-center px-2"><?=$row->weekend?></td>
				<td class="text-center px-2"><?=$row->earn_leave?></td>
				<td class="text-center px-2"><?=$row->sick_leave?></td>
				<td class="text-center px-2"><?=$row->late_count?></td>
				<td class="text-center px-2"><?=$row->late_deduct?></td>
				<td class="text-center px-2"><?=$row->absent_deduct?></td>
				<td class="text-center px-2"><?=$row->extra_pay?></td>
				<td class="text-center px-2"><?=$row->modify_salary?></td>
				<td class="text-center px-2"><?=$row->net_salary?></td>
				<td class="text-center px-2"><?=$row->grand_net_salary + ($row->modify_salary)?></td>
			</tr>
		<?php } ?>
		<tr>
			<th colspan="17" class="text-left px-2">Total : </th>
			<th class="text-center px-2"><?=$late_deduct?></th>
			<th class="text-center px-2"><?=$ab_deduct?></th>
			<th class="text-center px-2"><?=$etra_pay?></th>
			<th class="text-center px-2"><?=$modify_total?></th>
			<th class="text-center px-2"><?=$net_total?></th>
			<th class="text-center px-2"><?=$grand_total?></th>
		</tr>
	</table>
	<br>
	<br>
	<br>

</body>
</html>