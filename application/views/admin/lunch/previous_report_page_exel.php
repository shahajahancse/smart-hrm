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
            <a onclick="window.print()" class="btn btn-primary" style="float: right;margin-top: 26px;">Pritn</a>


            <div class="export-button">
                <form style="float: right;margin-top: 27px;margin-right: 5px;" action="<?php echo base_url();?>admin/Lunch/paymentreport" method="post">
                    <input type="hidden" name="status" value="<?php echo $status; ?>"></input>
                    <input type="hidden" name="excel" value="1"></input>
                    <button type="submit" class="btn btn-primary" style="border: 0; cursor:pointer;" alt="XLS Export">XLS Export</button>
                </form>
            </div>

            
                <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
				<div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
				<div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;"> <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
				<div style="font-size:16px; line-height:15px; font-weight:bold; text-align:center;" >Monthly Lunch Payment Report of <?= isset($lunch_data[0]->from_date) ? $lunch_data[0]->from_date : ''; ?> to <?= isset($lunch_data[0]->end_date) ? $lunch_data[0]->end_date : ''; ?> </div>
        </div>
        <table class="table table-bordered table-hover table-striped">
            <thead style="text-align: center;">
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Previous Meal</th>
                    <th>Previous Cost</th>
                    <th>Previous Pay</th>
                    <th>Previous Amount</th>
                </tr>
            </thead>
            <tbody  style="text-align: center;">

            <?php  $totalamount=0;$previouspay=0; foreach ($lunch_data as $key=>$employee): ?>
                    <?php 
                    $pbm=($employee->prev_amount/45);
                    $totalamount+=$employee->pay_amount;
                    $previouspay+=$employee->prev_pay;
                    ?>
                <tr>    
                    <td><?php echo $key+1 ?></td>
                    <td><?php echo $employee->first_name;?> <?php echo $employee->last_name; ?></td>
                    <td><?php echo $employee->prev_meal;?></td>
                    <td><?php echo $employee->prev_cost;?></td>
                    <td><?php echo $employee->prev_pay;?></td>
                    <td><?php echo $employee->prev_amount;?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <?php if($r==1){?>

                <tfoot style="text-align: center;font-weight: bold;">
                <tr>
                    <td colspan="4">Total</td>
                    <td colspan="1"><?= $previouspay ?></td>
                </tr>
                </tfoot>




                <?php }else{ ?>
                <tfoot style="text-align: center;font-weight: bold;">
                <tr>
                    <td colspan="6">Total</td>
                    <td colspan="1"><?= $totalamount ?></td>
                </tr>
                </tfoot>
                <?php } ?>
        </table>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
