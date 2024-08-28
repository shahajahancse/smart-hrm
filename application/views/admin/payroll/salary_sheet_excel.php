<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<div style="position:absolute; right:0; margin-right: 25px;; margin-top: 25px; font-size: 20px;">
	<form action="<?php echo base_url();?>admin/payroll/salary_sheet_excel" method="post">
		<input type="hidden" name="salary_month" value="<?php echo $salary_month; ?>"></input>
		<input type="hidden" name="sql" value="<?php echo implode(",",$emp_id); ?>"></input>
		<input type="hidden" name="excel" value="1"></input>
		<input type="hidden" name="status" value="<?php echo $status; ?>"></input>
		<button type="submit" class="btn btn-primary" style="border: 0; cursor:pointer;" alt="XLS Export">XLS Export</button>
	</form>
</div>

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
			<th>Id</th>
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
			<th>ABA</th>
			<th>Earn leave</th>
			<th>Sick leave</th>
			<th>Late Day</th>
			<th>Late D.Day</th>
			<th>Late deduct</th>
			<th>Absent deduct</th>
			<th>BA Deduct</th>
			<th>Net Salary</th>
			<th>Extra Pay</th>
			<th>D.A Day</th>
			<th>D.A Salary</th>
			<th>Grand Net Salary</th>
		</tr>

		<?php $grand_total = $net_total = $modify_total = $etra_pay = $ab_deduct = $late_deduct = 0;
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
				<td class="text-center px-2"><?=$row->emp_id?></td>
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
				<td class="text-center px-2"><?=$row->ba_absent?></td>
				<td class="text-center px-2"><?=$row->earn_leave?></td>
				<td class="text-center px-2"><?=$row->sick_leave?></td>
				<td class="text-center px-2"><?=$row->late_count?></td>
				<td class="text-center px-2"><?=$row->d_day?></td>
				<td class="text-center px-2"><?=$row->late_deduct?></td>
				<td class="text-center px-2"><?=$row->absent_deduct?></td>
				<td class="text-center px-2"><?=$row->aba_deduct?></td>
				<td class="text-center px-2"><?=$row->net_salary?></td>
				<td class="text-center px-2"><?=$row->extra_pay?></td>
				<td class="text-center px-2"><?=$row->m_pay_day?></td>
				<td class="text-center px-2"><?=$row->modify_salary?></td>
				<td class="text-center px-2"><?=ceil($row->grand_net_salary + ($row->modify_salary)-$row->aba_deduct)?></td>
			</tr>
		<?php } ?>
		<tr>
			<th colspan="19" class="text-left px-2">Total : </th>
			<th class="text-center px-2"><?=$late_deduct?></th>
			<th class="text-center px-2"><?=$ab_deduct?></th>
			<th class="text-center px-2">-</th>
			<th class="text-center px-2"><?=$net_total?></th>
			<th class="text-center px-2"><?=$etra_pay?></th>
			<th class="text-center px-2">-</th>
			<th class="text-center px-2"><?=$modify_total?></th>
			<th class="text-center px-2"><?=ceil($grand_total)?></th>
		</tr>
		
	


	</table>
	<br>
	<br>
	<br>



            
<!-- jQuery 3 -->
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js"></script>

<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->