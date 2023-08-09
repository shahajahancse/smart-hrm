<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
<?php

	$filename = "Salary_$salary_month.xls";
	header('Content-Type: application/vnd.ms-excel'); // Mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); // Tell the browser the file name
	header('Cache-Control: max-age=0'); // No cache
?>

<table align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">
	<tr height="85px">
		<td colspan="15" style="text-align:center;">
			<div style="font-size:20px; font-weight:bold; text-align:center; margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
			<div style="font-size:12px; font-weight:bold; text-align:center; height:0px;"></div>
			<div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;"><?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
			<div>Salary Month: <?php echo $salary_month; ?></div>
			<div style="font-size:12px; font-weight:bold; text-align:center;"></div>
			<div style="font-size:12px; font-weight:bold; text-align:center;"></div>
		</td>
	</tr>

	<tr>
		<th class='bnb' style="width: 17px;">SL</th>
		<th class='bnb' style="width: 67px;">Name</th>
		<th class='bnb' style="width: 70px;">Degi</th>
		<th class='bnb' style="width: 70px;">Join.d</th>
		<th class='bnb' style="width: 60px;">Salary</th>
		<th style="width: 190px;">Status</th>
		<th style="width: 55px;">Leave</th>
		<th style="width:55px;">Late</th>
		<th style="width: 139px;">Deduction</th>
		<th class='bnb' style="width: 37px;">Net Salary</th>
		<th class='bnb' style="width: 37px;">Extra Pay</th>
		<th class='bnb' style="width: 28px;">D.A Day</th>
		<th class='bnb' style="width: 42px;">D.A Salary</th>
		<th class='bnb' style="width: 60px;">Grand Net Salary</th>
		<th class='bnb' style="width: 37px;">Account Number</th>
	</tr>
	<tr>
		<th class='bnt'></th>
		<th class='bnt'></th>
		<th class='bnt'></th>
		<th class='bnt'></th>
		<th class='bnt'></th>

		<th>
			<table>
				<tr>
					<th class=''>P</th>
					<th class=''>A</th>
					<th class=''>W</th>
					<th class=''>H</th>
					<th class=''><p style="width: 9px;">E.P</p></th>
					<th class=''><p style="width: 9px;">ABA</p></th>
				</tr>
			</table>
		</th>
		<th>
			<table>
				<tr>
					<th class=''>E</th>
					<th class=''>S</th>
				</tr>
			</table>
		</th>
		<th>
			<table>
				<tr>
					<th class=''>Day</th>
					<th class=''>D.Day</th>
				</tr>
			</table>
		</th>

		<th>
			<table>
				<tr>
					<th class=''>Late</th>
					<th class=''>Abse</th>
					<th class=''>BA</th>
				</tr>
			</table>
		</th>
		<th class='bnt'></th>
		<th class='bnt'></th>
		<th class='bnt'></th>
		<th class='bnt'></th>
		<th class='bnt'></th>
		<th class='bnt'></th>
	</tr>
	<?php
	$total_grand_net_salary = $total_basic_salary = $total_net_salary = $total_late_deduct = $total_absent_deduct = $total_extra_pay = $total_modify_salary = $grand_total_grand_net_salary = $grand_total_basic_salary = $grand_total_net_salary = $grand_total_late_deduct = $grand_total_absent_deduct = $grand_total_extra_pay = $grand_total_modify_salary = 0;
	foreach ($values as $key => $row) {
	?>
		<tr>
			<td><?= $key + 1 ?></td>
			<td><?= $row->first_name ?> <?=$row->last_name ?></td>
			<td><?= $row->designation_name ?></td>
			<td><?= $row->date_of_joining ?></td>
			<td><?= $row->basic_salary ?></td>
			<td>
				<table>
					<tr>
						<td class='colors1'><?= $row->present ?></td>
						<td class='colors1'><?= $row->absent ?></td>
						<td class='colors1'><?= $row->weekend ?></td>
						<td class='colors1'><?= $row->holiday ?></td>
						<td class='colors1'><?= $row->extra_p ?></td>
						<td class='colors1'><?= $row->ba_absent ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table>
					<tr>
						<td class='colors2'><?= $row->earn_leave ?></td>
						<td class='colors2'><?= $row->sick_leave ?></td>
					</tr>
				</table>
			</td>
			<td>
				<table>
					<tr>
						<td class='colors3'><?= $row->late_count ?></td>
						<td class='colors3'><?= $row->d_day ?></td>
					</tr>
				</table>
			</td>

			<td>
				<table>
					<tr>
						<td class='cat4'><?= $row->late_deduct ?></td>
						<td class='cat4'><?= $row->absent_deduct ?></td>
						<td class='cat4'><?= $row->aba_deduct ?></td>
					</tr>
				</table>
			</td>
			<td><?= $row->net_salary ?></td>
			<td><?= $row->extra_pay ?></td>
			<td><?= $row->m_pay_day ?></td>
			<td><?= $row->modify_salary ?></td>

			<td class='colors4'><?= $row->grand_net_salary + $row->modify_salary ?></td>
			<?php

			//total
			$total_grand_net_salary += $row->grand_net_salary + $row->modify_salary;
			$total_basic_salary += $row->basic_salary;
			$total_net_salary += $row->net_salary;
			$total_late_deduct += $row->late_deduct;
			$total_absent_deduct += $row->absent_deduct;
			$total_extra_pay += $row->extra_pay;
			$total_modify_salary += $row->modify_salary;
			?>
			<td><?= $row->account_number ?></td>

		</tr>
	<?php }		?>


	<tr>
		<td colspan='4'>Total:</td>
		<td colspan='1'><?= $total_basic_salary ?></td>
		<td colspan='3'></td>
		<td colspan='1'>
			<table>
				<tr>
					<td style="width: 37%;font-weight: bold;font-size: 12px;" colspan='1'><?= $total_late_deduct ?></td>
					<td style="width: 37%;font-weight: bold;font-size: 12px;" colspan='1'><?= $total_absent_deduct ?></td>
					<td style="width: 37%;font-weight: bold;font-size: 12px;" colspan='1'></td>
				</tr>
			</table>
		</td>
		<td colspan='1'><?= $total_net_salary ?></td>
		<td colspan='1'><?= $total_extra_pay ?></td>
		<td colspan='1'></td>
		<td colspan='1'><?= $total_modify_salary ?></td>

		<td class='colors4' colspan='1'><?= $total_grand_net_salary ?></td>
		<td colspan='1'></td>
	</tr>


	<tr><tr><tr></tr></tr></tr>
	<tr height="85px">
		<td colspan="5" style="text-align:center; font-size:16px; font-weight:bold; ">
			<div>Prepared By</div>
		</td>
		<td colspan="5" style="text-align:center; font-size:16px; font-weight:bold;">
			<div>Confirmed By</div>
		</td>
		<td colspan="5" style="text-align:center; font-size:16px; font-weight:bold;">
			<div>Aproved By(Managing Director)</div>


		</td>
	</tr>
	</table>
	<br>
	<br>
	<br>

	</body>

	</html>