
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php
			$filename = "Salary_$salary_month.xls";
			header('Content-Type: application/vnd.ms-excel'); // Mime type
			header('Content-Disposition: attachment;filename="' . $filename . '"'); // Tell the browser the file name
			header('Cache-Control: max-age=0'); // No cache
		?>


  </head>
    <body id="record">
		<?php 
			$total_grand_net_salary=0;
			$total_basic_salary=0;
			$total_net_salary=0;
			$total_late_deduct=0;
			$total_absent_deduct=0;
			$total_aba_deduct=0;
			$total_adv_deduct=0;
			$total_lunch_deduct=0;
			$total_extra_pay=0;
			$total_modify_salary=0;
                   
		
		?>
		
                <div style='font-size:18px; font-weight:bold; text-align:center;margin-top:10px'><?=xin_company_info(1)->company_name ?></div>
                <div style='font-size:14px; font-weight:bold; text-align:center;margin-top:10px'><?=xin_company_info(1)->address_1 ?></div>
                <div style='font-size:12px;align-items: center;text-align: center;'>Salary Month :<?=$salary_month ?></div>
           <table id="myTable" border='1'>

                        <tr>
							<th class='bnb' style="width: 17px;">SL</th>
							<th  class='bnb' style="width: 67px;">Name</th>
							<th  class='bnb' style="width: 70px;">Degi  </th>
							<th  class='bnb' style='width: 70px;'>Join.d</th>
							<th  class='bnb' style="width: 60px;">Salary</th>
							<th style='width: 190px;'>Status</th>
							<th style='width: 55px;'>Leave</th>
							<th  style='width:55px;'>Late</th>
							<th style='width: 200px;'>Deduction</th>
							<th  class='bnb' style="width: 37px;">Net Salary</th>
							<th  class='bnb' style="width: 37px;">Extra Pay</th>
							<th  class='bnb' style="width: 28px;">D.A Day</th>
							<th  class='bnb' style="width: 42px;">D.A Salary</th>
							<th  class='bnb ' style="width: 60px;">Grand Net Salary</th>
							<th  class='bnb' style="width: 37px;">Account Number</th>
							<th  class='bnb' style="width: 37px;">Remark</th>
                        </tr>
                        <tr>
                            <th  class='bnt' colspan="5"></th>
                            <!-- <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th> -->
                            <th>
                                <table  border='1'>
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
                                <table  border='1'>
                                    <tr >
                                        <th class=''>E</th>
                                        <th class=''>S</th>
                                    </tr>
                                </table>
                            </th>
                            <th>
                               <table  border='1'>
                                    <tr>
                                        <th  class=''>Day</th>
                                        <th  class=''>D.Day</th>
                                    </tr>
                                </table>
                            </th>

                            <th>
                                <table  border='1'>
                                    <tr>
                                        <th  class=''>Late</th>
                                        <th  class=''>Abse</th>
                                        <th  class=''>BA</th>
                                        <th  class=''>Adv</th>
                                        <th  class=''>Lunch</th>

                                    </tr>
                                </table>
                            </th>
                            <th  class='bnt' colspan="7"></th>
                            <!-- <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th> -->
                        </tr>
                        <tbody>
							<?php
						// print the rows for all pages
						for ($i = 0; $i < count($values); $i++) {
								$total_grand_net_salary+=$values[$i]->grand_net_salary+$values[$i]->modify_salary-$values[$i]->aba_deduct;
								$total_basic_salary+=$values[$i]->basic_salary;
								$total_net_salary+=($values[$i]->net_salary)-($values[$i]->aba_deduct+$values[$i]->advanced_salary);
								$total_late_deduct+=$values[$i]->late_deduct;
								$total_absent_deduct+=$values[$i]->absent_deduct;
								$total_aba_deduct+=$values[$i]->aba_deduct;
								$total_adv_deduct+=$values[$i]->advanced_salary;
								$total_lunch_deduct+=$values[$i]->lunch_deduct;
								$total_extra_pay+=$values[$i]->extra_pay;
								$total_modify_salary +=$values[$i]->modify_salary;
							?>
							<tr>
								<td><?=$i+1?></td>
								<td><?=$values[$i]->first_name . " " . $values[$i]->last_name?></td>
								<td><?=$values[$i]->designation_name?></td>
								<td><?=$values[$i]->date_of_joining?></td>
								<td><?=$values[$i]->basic_salary?></td>
								<td>
									<table border='1'>
										<tr>
											<td class='colors1'><?=$values[$i]->present?></td>
											<td class='colors1'><?=$values[$i]->absent?></td>
											<td class='colors1'><?=$values[$i]->weekend?></td>
											<td class='colors1'><?=$values[$i]->holiday?></td>
											<td class='colors1'><?=$values[$i]->extra_p?></td>
											<td class='colors1'><?=$values[$i]->ba_absent?></td>
										</tr>
									</table>
								</td>
								<td>
									<table  border='1'>
										<tr>
											<td class='colors2'><?=$values[$i]->earn_leave?></td>
											<td class='colors2'><?=$values[$i]->sick_leave?></td>
										</tr>
									</table>
								</td>
								<td>
									<table  border='1'>
										<tr>
											<td  class='colors3'><?=$values[$i]->late_count?></td>
											<td  class='colors3'><?=$values[$i]->d_day?></td>
										</tr>
									</table>
								</td>

								<td>
									<table  border='1'>
										<tr>
											<td  class='cat4'><?=$values[$i]->late_deduct?></td>
											<td  class='cat4'><?=$values[$i]->absent_deduct?></td>
											<td  class='cat4'><?=$values[$i]->aba_deduct?></td>
											<td  class='cat4'><?=$values[$i]->advanced_salary?></td>
											<td  class='cat4'><?=$values[$i]->lunch_deduct?></td>
										</tr>
									</table>
								</td>
								<td><?=($values[$i]->net_salary)-($values[$i]->aba_deduct+$values[$i]->advanced_salary)?></td>
								<td><?=$values[$i]->extra_pay?></td>
								<td><?=$values[$i]->m_pay_day?></td>
								<td><?=$values[$i]->modify_salary?></td>
								<td class='colors4'><?=ceil($values[$i]->grand_net_salary + $values[$i]->modify_salary - $values[$i]->aba_deduct)?></td>
								<td><?=$values[$i]->account_number?></td>
								<td></td>
						</tr>

						<?php } ?>
                        <tfoot>
							<tr>
								<td colspan='4'>Total:</td>
								<td  colspan='1'><?=$total_basic_salary?></td>
								<td colspan='3'></td>
								<td colspan='1'>
									<table border='q'>
										<tr>
											<td class="col-md-2" colspan='1'><?=intval($total_late_deduct)?></td>
											<td class="col-md-2" colspan='1'><?=intval($total_absent_deduct)?></td>
											<td class="col-md-2" colspan='1'><?=intval($total_aba_deduct)?></td>
											<td class="col-md-2" colspan='1'><?=intval($total_adv_deduct)?></td>
											<td class="col-md-2" colspan='1'><?=intval($total_lunch_deduct)?></td>
										</tr>
									</table>
								</td>
								<td colspan='1'><?=$total_net_salary?></td>
								<td  colspan='1'><?=$total_extra_pay?></td>
								<td  colspan='1'></td>
								<td colspan='1'><?=$total_modify_salary?></td>
								<td colspan='1'><?=ceil($total_grand_net_salary)?></td>
							</tr>
						</tfoot> 
                    </table>

					<div class="ndive">
						<section style='width: 33%;'>Prepared By</section>
						<section style='width: 33%;'>Confirmed By</section>
						<section style='width: 33%;'>Aproved By(Managing Director)</section>
					</div>
    </body>
</html>
