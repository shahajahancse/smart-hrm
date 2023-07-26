<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
    <?php
    	$filename = "Lunch_Report.xls";
    	header('Content-Type: application/vnd.ms-excel'); // Mime type
    	header('Content-Disposition: attachment;filename="'.$filename.'"'); // Tell the browser the file name
    	header('Cache-Control: max-age=0'); // No cache
    ?>



    <?php 
        if (empty($lunch_data)) {
            echo "<p style='text-align: center; color: red'>Record not found</p>";
            exit;
        }

        $date = new DateTime($lunch_data[0]->end_date);
        $date->add(new DateInterval('P1M'));
        $newDate = $date->format('Y-m-d');

    ?>

    <body>

        <div class="container">
            <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px">
                <?php echo xin_company_info(1)->company_name; ?></div>
            <div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
            <div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;">
                <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
            <div style="font-size:16px; line-height:15px;  text-align:center;">Monthly Lunch Payment
                Report of <?php  $convertedDate1 = date('d-m-Y', strtotime($lunch_data[0]->end_date ));
                 $convertedDate2 = date('d-m-Y', strtotime($newDate)); ?>
                <?= isset($lunch_data[0]->end_date) ?  $convertedDate1 : ''; ?> to
                <?= isset($newDate) ? $convertedDate2: ''; ?> </div>
        </div>
        <table class="table table-bordered table-hover table-striped">
            <thead style="text-align: center;">
                <tr>
                    <th style="color: blue;">SL</th>
                    <th style="color: blue;">Name</th>
                    <th style="color: blue;">Current M. Lunch day</th>
                    <th style="color: blue;">Stock Lunch Balance</th>
                    <th style="color: blue;">Balance Days</th>
                    <th style="color: blue;">Collection Day</th>
                    <th style="color: blue;">Collection Amount</th>
                    <th style="color: blue;">Status</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                <?php  $totalamount=0; $previouspay=0; $total_cl_ml=0;
                foreach ($lunch_data as $key=>$employee):  
                    $pbm = ($employee->prev_amount/45);

                    $total_cl_ml += ($employee->collection_amount/45);
                    $totalamount += $employee->collection_amount;
                    $previouspay+=$employee->prev_pay;
                    ?>

                <tr>
                    <td style="text-align:center"><?php echo $key+1 ?></td>
                    <td><?php echo $employee->first_name;?> <?php echo $employee->last_name; ?></td>
                    <td style="text-align:center"><?php echo $employee->probable_meal;?></td>
                    <td style="text-align:center"><?php echo $pbm;?></td>
                    <td style="text-align:center"><?php echo $employee->probable_meal-$pbm;?></td>
                    <td style="text-align:center"><?php echo $employee->pay_amount/45;?></td>
                    <td style="text-align:center"><?php echo $employee->pay_amount;?></td>
                    <td style="color: <?php echo $employee->status == 1 ? 'blue' : 'red'; ?> text-align:center">
                        <?php echo $employee->status == 1 ? 'Paid' : 'Unpaid'; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot style="text-align: center;font-weight: bold;">
                <tr>
                    <td style="text-align: center; margin-right: 5px;" colspan="5">Total</td>
                    <td colspan="1"><?= $total_cl_ml ?></td>
                    <td colspan="1"><?= $totalamount ?></td>
                </tr>
            </tfoot>
        </table>
    </body>




</body>

</html>