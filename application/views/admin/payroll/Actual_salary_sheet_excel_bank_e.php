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
            <td colspan="7" style="text-align:center;">
                <div style="font-size:20px; font-weight:bold; text-align:center; margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
                <div style="font-size:12px; font-weight:bold; text-align:center; height:0px;"></div>
                <div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;"><?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
                <div>Salary Month: <?php echo $salary_month; ?></div>
                <div style="font-size:12px; font-weight:bold; text-align:center;"></div>
                <div style="font-size:12px; font-weight:bold; text-align:center;"></div>
            </td>
        </tr>        
        <tr>
            <th class="text-center">SL</th>
            <th class="text-center">Employee Name</th>
            <th class="text-center">Designation Name</th>
            <th class="text-center">Date Of Joining</th>
            <th class="text-center">Salary</th>
            <th class="text-center">Grand Net Salary</th>
            <th class="text-center">Bank Account</th>
        </tr>
        <?php
            $grand_total = $basic_salary = 0;
            foreach ($values as $key => $row) {
            $grand_total = $grand_total + $row->grand_net_salary + ($row->modify_salary) - $row->aba_deduct ;
            $basic_salary = $basic_salary + $row->basic_salary;
        ?>
        <tr>
            <td class="text-center"><?= ($key + 1) ?>.</td>
            <td class="text-center"><?= $row->first_name . ' ' . $row->last_name ?></td>
            <td class="text-center"><?= $row->designation_name ?></td>
            <td class="text-center"><?= $row->date_of_joining ?></td>
            <td class="text-center"><?= $row->basic_salary ?></td>
            <td class="text-center"><?= $row->grand_net_salary + ($row->modify_salary)  - $row->aba_deduct ?></td>
            <td class="text-center"><?= $row->account_number ?></td>
        </tr>
        <?php } ?>
        <tr>
            <th colspan="4" class="text-left">Total:</th>
            <th class="text-center"><?= $basic_salary ?></th>
            <th class="text-center"><?= $grand_total ?></th>
        </tr>
	</table>
	<br>
	<br>
	<br>
</body>
</html>