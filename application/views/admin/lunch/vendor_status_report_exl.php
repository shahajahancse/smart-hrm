<!-- <?php
$statusText = "";
if ($statusC == 1) {
    $statusText = "Pending";
} elseif ($statusC == 2) {
    $statusText = "Approved";
} elseif ($statusC == 3) {
    $statusText = "Handover";
} elseif ($statusC == 4) {
    $statusText = "Rejected";
}
?> -->


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:1000px;">

    <head>
        <style>
        th,
        td {
            text-align: center;
        }
        </style>
    </head>


    <?php


$filename = "Vendor_$first_date+to+$second_date.xls";
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
?>


    <table width="1000" align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="2"
        style="font-size:12px; width:750px;">
        <tr width="1000" align="center" style="height:100px;">
            <td colspan="13" style="text-align:center;">
                <div style="font-size:30px; font-weight:bold; text-align:center;margin-top:3px;">
                    <?php echo xin_company_info(1)->company_name; ?></div>
                <div style="font-size:20px; font-weight:bold; text-align:center;">
                    <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
                <?php $convert_f1=date('d-m-Y', strtotime($first_date));
                    $convert_f2=date('d-m-Y', strtotime($second_date));
            
            ?>
                <div style="font-size:18px; font-weight:bold; text-align:center; margin-bottom:3px">
                    <?php echo $statusText; ?> Report : <?php echo $convert_f1; ?> To <?php echo  $convert_f2; ?></div>

            </td>
        </tr>
        <tr style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px;">
            <th style="background-color: #4CAF50;color: white;">Sl</th>
            <th style="background-color: #4CAF50;color: white;">Date</th>
            <th style="background-color: #4CAF50;color: white;">Days</th>
            <th style="background-color: #d5b2b2; color: black;">From Date</th>
            <th style="background-color: #d5b2b2; color: black;">To Date</th>
            <th style="background-color: #d5b2b2; color: black;">Total Meal</th>
            <th style="background-color: #d5b2b2; color: black;">Amount</th>
            <th style="background-color: #d5b2b2; color: black;">P.Due</th>
            <th style="background-color: #d5b2b2; color: black;">Net.Amount</th>
            <th style="background-color: #d5b2b2; color: black;">Paid Amount</th>
            <th style="background-color: #d5b2b2; color: black;">Due</th>

            <th style="background-color: #d5b2b2; color: black;">Remarks</th>
            <th style="background-color: #d5b2b2; color: black;">Status</th>

        </tr>
        <?php if (!empty($values)): ?>
        <?php    
                                $total_meal=0;
                                $t_amount=0;
                                $t_pay_amount=0;
                                $t_net_amount=0;
                                $t_paid_amount=0;
                                $st_pv=0;
                        ?>

        <?php $i = 1; foreach ($values as $row): ?>
        <tbody>
            <tr>
                <?php if($i==1){
                                                    $st_pv=$row->previous_due;
                                        } ?>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row->date ?></td>
                <?php   $dateStr = $row->date;
                                            $date = strtotime($dateStr);
                                            $dayName = date("l", $date); 
                                            $convert_date1=date('d-m-Y', strtotime($row->from_date));
                                            $convert_date2=date('d-m-Y', strtotime($row->to_date));
                                    ?>
                <td><?php echo $dayName ?></td>
                <td><?php echo $convert_date1 ?></td>
                <td><?php echo  $convert_date2 ?></td>
                <?php 
                                     
                                        $total_meal=$total_meal+$row->total_meal;
                                        $t_amount=$t_amount+$row->pay_amount;
                                        $t_net_amount=$t_net_amount+$row->net_payment;
                                        $t_paid_amount=$t_paid_amount+$row->paid_amount;

                                 ?>
                <td><?php echo $row->total_meal ?></td>
                <td><?php echo $row->pay_amount ?></td>
                <td> <?php echo $row->previous_due ?> </td>
                <td><?php echo $row->net_payment ?></td>
                <td><?php echo $row->paid_amount ?> </td>
                <td><?php echo $row->due ?></td>
                <td><?php echo $row->Remarks ?></td>
                <td><?= $row->status != 1 ? 'unpaid' : 'paid' ?></td>
            </tr>
            <?php endforeach; ?>
            <tr></tr>
            <tr></tr>
            <tr>
                <td colspan="3" style="text-align:center; font-weight: bold">Total Meals</td>
                <td colspan="2" style="text-align:center; font-weight: bold">Total Amount</td>
                <td colspan="2" style="text-align:center; font-weight: bold">Paid Amount</td>
                <td colspan="2" style="text-align:center; font-weight: bold">Due</td>
                <td colspan="2" style="text-align:center;font-weight: bold">Previous Due</td>
                <td colspan="2" style="text-align:center; font-weight: bold">Total Due</td>

            </tr>

            <tr>

                <td colspan="3" style="text-align: center;"><strong><?= $total_meal ?></strong></td>
                <td colspan="2" style="text-align: center;"><strong><?=  $t_amount?></strong></td>
                <td colspan="2" style="text-align: center;"><strong><?= $t_paid_amount ?></strong></td>
                <td colspan="2" style="text-align: center;"><strong><?= $t_amount- $t_paid_amount ?></strong></td>
                <td colspan="2" style="text-align: center;"><strong><?=  $st_pv ?></strong></td>
                <?php $_due=$t_amount- $t_paid_amount ?>
                <td colspan="2" style="text-align: center;"><strong><?= $_due +$st_pv ?></strong></td>

            </tr>
        </tbody>

        <?php else: ?>
        <tbody>
            <tr>
                <td colspan="9">No data found.</td>
            </tr>
        </tbody>
        <?php endif; ?>
        </tbody>


        <!-- e2 -->



    </table>

</body>

</html>