<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
	<?php

		$filename = "Leave_$salary_month.xls";
		header('Content-Type: application/vnd.ms-excel'); // Mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); // Tell the browser the file name
		header('Cache-Control: max-age=0'); // No cache
	?>


<table align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">
	<tr height="85px">
		<td colspan="9" style="text-align:center;">
			<div style="font-size:20px; font-weight:bold; text-align:center; margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
			<div style="font-size:12px; font-weight:bold; text-align:center; height:0px;"></div>
			<div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;"><?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
			<div>Salary Month: <?php echo $salary_month; ?></div>
			<div style="font-size:12px; font-weight:bold; text-align:center;"></div>
			<div style="font-size:12px; font-weight:bold; text-align:center;"></div>
		</td>
	</tr>

	<tr>
	        <td>Sl. No.</td>
			<td>Employee Name</td>
			<td>From</td>
			<td>to</td>
			<td>Type</td>
			<td>Qty</td>
			<td>Reason</td>
			<td>Total Leave Balance</td>
			<td>Status</td>
		</tr>
			

		<?php  $total_el_leave=0;
			$total_si_leave=0;
			$total_day=0;
			$totalemp=[];

			foreach($xin_employees as $key=>$row){
				if(!in_array($row->employee_id,$totalemp)){
					array_push($totalemp,$row->employee_id);
				};

                $user_info = $this->Xin_model->read_employee_info($row->employee_id); ?>

				<tr>
					<td><?php echo $key+1;?></td>
					<td><?php echo $user_info[0]->first_name.' '.$user_info[0]->last_name?></td>
					<?php
					$toDateString = $row->from_date;
					$dayName = date('l', strtotime($toDateString)); 
					?>
					<td><?php echo $row->from_date. ' ('.$dayName. ')'?></td>
					
					<?php
					$toDateString = $row->to_date;
					$dayName = date('l', strtotime($toDateString));
					?>
					
					<td><?php echo $row->to_date . ' ('.$dayName.')'?></td>
					<?php
					if ($row->leave_type=='el') {
						$total_el_leave +=$row->qty;

						echo "<td class='text' >Earn Leave</td>";
					}else{
						$total_si_leave +=$row->qty;

						echo "<td class='text' >Sick Leave</td>";
					}
					?>

					<td><?php

					$total_day += $row->qty;

					echo $row->qty?>
					</td>
					<td>
							<?= $row->reason?>

					</td>
					
					<td>
						<?php 
							$data = leave_cal($row->employee_id);
							// dd($data);
							echo "Earn Leave = ".$data['leaves'][0]['qty'] . ", Sick Leave = ".$data['leaves'][1]['qty'];
						?>
					</td>
					<?php if ($row->status==1) {
						echo "<td class='text text-info' >Pending</td>";
					}elseif ($row->status==2) {
						echo "<td class='text text-success' >Approved</td>";
					}elseif ($row->status==3) {
						echo "<td class='text text-danger' >Rejected</td>";
					} ?>

            	</tr>
        <?php } ?>

	</table>

		  <table class="table">
			<thead>
				<tr>
					<th>Total Employee</th>
					<th>Total leave</th>
					<th>Total Earn Leave</th>
					<th>Total Sick Leave</th>
					
				</tr>
			</thead>
				<tr>
				   <td><?=count($totalemp)?></td>
				   <td><?=$total_day?></td>
				   <td><?=$total_el_leave?></td>
				   <td><?=$total_si_leave?></td>
				  
					
				</tr>
		  </table>

	<br>
	<br>
	<br>
</body>
</html>