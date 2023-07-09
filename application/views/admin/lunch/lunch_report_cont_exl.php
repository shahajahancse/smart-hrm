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


$filename = "Lunch_$first_date+to+$second_date.xls";
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
?>


    <table width="1000" align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="2"
        style="font-size:12px; width:750px;">
        <tr width="1000" align="center" style="height:115px;">
            <td colspan="9" style="text-align:center;">
                <div style="font-size:25px; font-weight:bold; text-align:center;margin-top:3px;">
                    <?php echo xin_company_info(1)->company_name; ?></div>
                <div style="font-size:20px; font-weight:bold; text-align:center;">
                    <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
                <?php $convert_f1=date('d-m-Y', strtotime($first_date));
                    $convert_f2=date('d-m-Y', strtotime($second_date));
            
            ?>
                <div style="font-size:18px;  text-align:center; margin-bottom:3px">Lunch Report </div>
                <div style="font-size:18px; font-weight:bold; text-align:center; margin-bottom:3px">
                    <?php echo $statusText; ?> Date : <?php echo $convert_f1; ?> To <?php echo  $convert_f2; ?></div>

            </td>
        </tr>
        <tr style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px;">
            <th style="background-color: #4CAF50;color: white;">Sl</th>
            <th style="background-color: #4CAF50;color: white;">Date</th>
            <th style="background-color: #4CAF50;color: white;">Days</th>
            <th style="background-color: #d5b2b2; color: black;">Emp M</th>
            <th style="background-color: #d5b2b2; color: black;">Guest M</th>
            <th style="background-color: #d5b2b2; color: black;">Total M</th>
            <th style="background-color: #d5b2b2; color: black;">Emp Cost</th>
            <th style="background-color: #d5b2b2; color: black;">Guest Cost</th>
            <th style="background-color: #d5b2b2; color: black;">Total Cost</th>

        </tr>
        <?php if (!empty($lunch_data)): ?>
        <?php    
                               $total_emp_meal = 0;
                               $total_guest_meal = 0;
                               $total_meal = 0;
                               $total_empoloyee_cost = 0;
                               $total_guest_cost = 0;
                               $total_cost = 0;
                        ?>

        <?php $i = 1; foreach ($lunch_data as $item): ?>
        <tbody>
            <tr>

                <td><?php echo $i++; ?></td>
                <?php $convertedDate2 = date('d-m-Y', strtotime($item->date));  ?>
                <td><?php echo $convertedDate2 ; ?></td>
                <?php  
                                            $dateStr = $item->date;
                                            $date = strtotime($dateStr);
                                            $dayName = date("l", $date);

                                            $total_emp_meal += $item->emp_m;
                                            $total_guest_meal += $item->guest_m;
                                            $total_meal += $item->total_m;
                                            $total_empoloyee_cost += $item->emp_cost;
                                            $total_guest_cost += $item->guest_cost;
                                            $total_cost += $item->total_cost;


                                
                                    ?>
                <td><?=   $dayName ?> </td>
                <td><?php echo $item->emp_m; ?></td>
                <td><?php echo $item->guest_m; ?></td>
                <td><?php echo $item->total_m; ?></td>
                <td><?php echo $item->emp_cost; ?></td>
                <td><?php echo $item->guest_cost; ?></td>
                <td><?php echo $item->total_cost; ?></td>
            </tr>
            <?php endforeach; ?>


        </tbody>

        <tfoot style="text-align: center;font-weight: bold;">
            <tr>
                <td colspan="3">Total</td>
                <td><?=  $total_emp_meal ?></td>
                <td><?=  $total_guest_meal ?></td>
                <td><?=  $total_meal  ?></td>
                <td><?=  $total_empoloyee_cost?></td>
                <td><?=   $total_guest_cost  ?></td>
                <td><?=  $total_cost ?></td>
            </tr>
        </tfoot>


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