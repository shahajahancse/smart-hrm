<?php
$statusText = "";
if ($statusC == 1) {
    $statusText = "Processing";
} elseif ($statusC == 2) {
    $statusText = "Approved";
} elseif ($statusC == 3) {
    $statusText = "Rejected";
} elseif ($statusC == 4) {
    $statusText = "Paid";
}
?>


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
<head>
    <style>
        th,td{
            text-align: center;
        }
    </style>
</head>

  
<?php


$filename = "Salary_$first_date+to+$second_date.xls";
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
?>


<table width="900"width="900" align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">
<tr width="900" align="center" style="height:100px;">
    <td colspan="9" style="text-align:center;">
        <div style="font-size:30px; font-weight:bold; text-align:center;margin-top:3px;"><?php echo xin_company_info(1)->company_name; ?></div>
        <div style="font-size:20px; font-weight:bold; text-align:center;"><?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div> 
        <div style="font-size:18px; font-weight:bold; text-align:center; margin-bottom:3px"> <?php echo $statusText; ?> Report : <?php echo $first_date; ?> To  <?php echo $second_date; ?></div>

    </td>
</tr>
		<tr  style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px;">
            <th style="background-color: #4CAF50;color: white;">Sl. No.</th>
            <th style="background-color: #4CAF50;color: white;">Employee Name</th>
            <th style="background-color: #4CAF50;color: white;">Department</th>
            <th style="background-color: #d5b2b2; color: black;">Designation</th>
            <th style="background-color: #d5b2b2; color: black;">Request Amount</th>
            <th style="background-color: #d5b2b2; color: black;">Payable Amount</th>
            <th style="background-color: #d5b2b2; color: black;">Out Time</th>
            <th style="background-color: #d5b2b2; color: black;" >In Time</th>
            <th style="background-color: #d5b2b2; color: black;">Reason</th>
            
          </tr>
          <?php if (!empty($values)): ?>
                    <?php $i = 1; foreach ($values as $row): ?>
                        <tbody>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row->first_name . ' ' . $row->last_name ?></td>
                                <td><?php echo $row->department_name ?></td>
                                <td><?php echo $row->designation_name ?></td>
                                <td><?php echo $row->request_amount ?></td>
                                <td><?php echo $row->payable_amount ?></td>
                                <td><?php echo !empty($row->out_time) ? date('h:i:s a', strtotime($row->out_time)) : '' ?></td>
                                <td><?php echo !empty($row->in_time) ? date('h:i:s a', strtotime($row->in_time)) : '' ?></td>
                                <td><?php echo $row->reason ?></td>
                            </tr>
                        </tbody>
                    <?php endforeach; ?>
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