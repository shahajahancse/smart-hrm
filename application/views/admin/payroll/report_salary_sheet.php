<?php 
//dd($values)
// [payslip_id] => 1293
//             [emp_id] => 39
//             [department_id] => 6
//             [designation_id] => 25
//             [employee_id] => MHL08C87129603
//             [first_name] => Md. Mafizur
//             [last_name] => Rahman
//             [date_of_joining] => 2017-08-12
//             [department_name] => Technical Team
//             [designation_name] => Sr. Software Engineer
//             [account_number] => 5991010000776
//             [salary_month] => 2024-07
//             [basic_salary] => 75000.00
//             [m_pay_day] => 1.00
//             [present] => 18.00
//             [extra_p] => 0.00
//             [ba_absent] => 0
//             [aba_deduct] => 0.00
//             [absent] => 0.00
//             [holiday] => 5.00
//             [weekend] => 8.00
//             [earn_leave] => 0.00
//             [sick_leave] => 0.00
//             [late_count] => 3
//             [late_deduct] => 2419.35
//             [d_day] => 1.00
//             [absent_deduct] => 0.00
//             [advanced_salary] => 0
//             [lunch_deduct] => 550
//             [extra_pay] => 0
//             [modify_salary] => 2419.00
//             [net_salary] => 72030.65
//             [grand_net_salary] => 72030.65
?>

<link rel="stylesheet"
    href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<body style="background:white ">
    <?php  $this->load->view('admin/head_bangla'); ?>
    <style>
    .ekline {
        white-space: nowrap;
        float: left;
        margin: 2px;
        left: auto;
        text-align: -webkit-left;
    }
    </style>

    <h4 class="text-center">Report of salary Sheet month of <?php echo $salary_month ?></h4>
    <button style="float: right;" class="btn btn-primary" onclick="exportTableToExcel('myTable', 'data')">Export Table to Excel</button>

    <div class="container" >
        <table class="table  table-bordered table-responsive" id="myTable">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Degi</th>
                    <th class="text-center">Join.d</th>
                    <th class="text-center">Salary</th>
                    <th class="text-center">Grand Net Salary</th>
                    <th class="text-center">Account Number</th>
                    <th class="text-center">Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($values as $kay=>$data){ 
                ?>
                <tr>
                    <td class="text-center"><?= $kay+1 ?></td>
                    <td class="text-center"><?= $data->first_name.' '.$data->last_name ?></td>
                    <td class="text-center"><?= $data->designation_name ?></td>
                    <td class="text-center"><span style="white-space: nowrap;"><?= date('d-M-Y' , strtotime($data->date_of_joining))?></span></td>
                    <td class="text-center"><?= $data->basic_salary ?></td>
                    <td class="text-center">
                        <?= ceil($data->grand_net_salary + ($data->modify_salary) - $data->aba_deduct) ?></td>
                    <td class="text-center"><?= $data->account_number ?></td>
                    <td class="text-center ">
                        <div style="display: flex;flex-direction: column;float: left;">
                            <?php
                                $late_deduct=ceil($data->late_deduct-$data->modify_salary);
                                if($late_deduct > 10){
                                    echo '<span class="ekline"> Late Deduct '.$late_deduct .' </span> ';
                                }
                                if($data->absent_deduct > 10){
                                    echo '<span class="ekline">'.$data->absent.' day Absent Deduct '.ceil($data->absent_deduct) .'</span> ';
                                }
                                if($data->lunch_deduct > 10){
                                    echo '<span class="ekline"> Lunch Deduct '.ceil($data->lunch_deduct) .'</span> ';
                                }
                                if($data->aba_deduct > 10){
                                    echo '<span class="ekline">Before after absent Deduct '.ceil($data->aba_deduct) .'</span> ';
                                }
                                if($data->extra_pay > 10){
                                    echo '<span class="ekline">'. $data->extra_p. ' day Extra Pay '.ceil($data->extra_pay) .'</span> ';
                                }
                                ?>
                        </div>
                    </td>
                    <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        function exportTableToExcel(tableID, filename = ''){
            let downloadLink;
            const dataType = 'application/vnd.ms-excel';
            const tableSelect = document.getElementById(tableID);
            const tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            
            // Specify file name
            filename = filename ? filename + '.xls' : 'excel_data.xls';
            
            // Create download link element
            downloadLink = document.createElement("a");
            
            document.body.appendChild(downloadLink);
            
            if(navigator.msSaveOrOpenBlob){
                const blob = new Blob(['\ufeff', tableHTML], { type: dataType });
                navigator.msSaveOrOpenBlob( blob, filename);
            } else {
                // Create a link to the file
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            
                // Setting the file name
                downloadLink.download = filename;
                
                //triggering the function
                downloadLink.click();
            }
        }
    </script>
</body>