<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
<?php

	$filename = "Lunch_Report.xls";
	header('Content-Type: application/vnd.ms-excel'); // Mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); // Tell the browser the file name
	header('Cache-Control: max-age=0'); // No cache
?>

<body>

        <div class="container">
                <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
				<div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
				<div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;"> <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
				<div style="font-size:16px; line-height:15px; font-weight:bold; text-align:center;" >Monthly Lunch Payment Report of <?= isset($lunch_data[0]->from_date) ? $lunch_data[0]->from_date : ''; ?> to <?= isset($lunch_data[0]->end_date) ? $lunch_data[0]->end_date : ''; ?> </div>
        </div>
        <table class="table table-bordered table-hover table-striped">
            <thead style="text-align: center;">
                <tr>
                    <th  style="text-align: center;font-weight: bold;">SL</th>
                    <th  style="text-align: center;font-weight: bold;">Name</th>
                    <th  style="text-align: center;font-weight: bold;">Previous Meal</th>
                    <th  style="text-align: center;font-weight: bold;">Previous Cost</th>
                    <th  style="text-align: center;font-weight: bold;">Previous Pay</th>
                    <th  style="text-align: center;font-weight: bold;">Previous Amount</th>
                    <th  style="text-align: center;font-weight: bold;">P.Meal</th>
                    <th  style="text-align: center;font-weight: bold;">Pay Amount</th>
                    <th  style="text-align: center;font-weight: bold;">Status</th>
                </tr>
            </thead>
            <tbody  style="text-align: center;">

                <?php $totalamount=0;  foreach ($lunch_data as $key=>$employee): ?>
                    <?php $payamount=$employee->pay_amount-$employee->prev_amount;
                    $totalamount+=$payamount;
                     ?>
                <tr>
                    <td  style="text-align: center"><?php echo $key+1 ?></td>
                    <td style="text-align: center"><?php echo $employee->first_name;?> <?php echo $employee->last_name; ?></td>
                    <td style="text-align: center"><?php echo $employee->prev_meal;?></td>
                    <td style="text-align: center"><?php echo $employee->prev_cost;?></td>
                    <td style="text-align: center"><?php echo $employee->prev_pay;?></td>
                    <td style="text-align: center"><?php echo $employee->prev_amount;?></td>
                    <td style="text-align: center"><?php echo $employee->pay_amount/45;?></td>
                    <td style="text-align: center"><?php echo $payamount;?></td>
                    <td style="color: <?php echo $employee->status == 1 ? 'blue' : 'red'; ?>">
                        <?php echo $employee->status == 1 ? 'Paid' : 'Unpaid'; ?>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
            <tr></tr>
        
            <tfoot style="text-align: center;font-weight: bold;">
                <tr>
                    <td colspan="7"  style="text-align: center;font-weight: bold;">Total</td>
                    <td colspan="1"  style="text-align: center;font-weight: bold;"><?= $totalamount ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>




</body>

</html>