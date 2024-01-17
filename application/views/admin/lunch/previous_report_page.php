<!DOCTYPE html>
<html>

<head>
    <title>Employee Table</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table {
        margin-top: 20px;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
        padding: 8px;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #ffffff;
    }

    .table-hover>tbody>tr:hover>td,
    .table-hover>tbody>tr:hover>th {
        background-color: #eaeaea;
    }

    .table-bordered thead th {
        background-color: #f5f5f5;
        border-bottom: 2px solid #ddd;
        text-align: center;
    }

    .table-bordered thead th:first-child,
    .table-bordered tbody td:first-child {
        border-left: none;
    }

    .table-bordered thead th:last-child,
    .table-bordered tbody td:last-child {
        border-right: none;
    }

    .table-bordered tbody tr:last-child td {
        border-bottom: none;
    }

    td {
        margin: 0 !important;
        padding: 0 !important;
    }

    @media print {
        .btn {
            display: none;
        }
    }
    </style>
</head>

<body>
    <?php 
        if (empty($lunch_data)) {
            echo "<p style='text-align: center; color: red'>Record not found</p>";
            exit;
        }
    ?>
    <div class="container">
        <a onclick="window.print()" class="btn btn-primary" style="float: right;margin-top: 26px;">Print</a>

        <div class="export-button">
            <form style="float: right;margin-top: 27px;margin-right: 5px;"
                action="<?php echo base_url();?>admin/Lunch/paymentreport/1" method="post">
                <input type="hidden" name="status" value="<?php echo $status; ?>"></input>
                <input type="hidden" name="excel" value="1"></input>
                <button type="submit" class="btn btn-primary" style="border: 0; cursor:pointer;" alt="XLS Export">XLS
                    Export</button>
            </form>
        </div>


        <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px">
            <?php echo xin_company_info(1)->company_name; ?></div>
        <div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
        <div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;">
            <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
        <div style="font-size:12px; line-height:15px; text-align:center;">Monthly Lunch Payment Report of
            <?php $convertedDate1 = date('d-m-Y', strtotime($lunch_data[0]->from_date));
               $convertedDate2 = date('d-m-Y', strtotime($lunch_data[0]->end_date)); ?>
            <?= isset($lunch_data[0]->from_date) ? $convertedDate1 : ''; ?> to
            <?= isset($lunch_data[0]->end_date) ? $convertedDate2  : ''; ?> 
        </div>
    </div>

    <div class="container">
        <div class="box-body">
            <div class="box-datatable ">
            <table class="table table-bordered table-hover table-striped">
        <thead style="text-align: center;">
            <tr>
                <th style="text-align: center;">SL</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Previous Meal</th>
                <th style="text-align: center;">Previous Cost</th>
                <th style="text-align: center;">Previous Pay</th>
                <th style="text-align: center;">Previous Amount</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <?php  $totalamount=0; $previouspay=0; $totalprev_meal=0; $totalprev_cost=0; $totalprev_amt=0;
            foreach ($lunch_data as $key=>$employee):
                $lunch_package=lunch_package($employee->from_date);

                $pbm=($employee->prev_amount/$lunch_package->stuf_give_tk);

                $totalprev_meal+=$employee->prev_meal;
                $totalprev_cost+=$employee->prev_cost;
                $previouspay   +=$employee->prev_pay;  
                $totalprev_amt +=$employee->prev_amount;  

                $totalamount+=$employee->pay_amount;
                ?>

                <tr>
                    <td style="text-align: center;"><?php echo $key+1 ?></td>
                    <td>&nbsp;&nbsp;&nbsp;<?php echo $employee->first_name;?> <?php echo $employee->last_name; ?></td>
                    <td style="text-align: center;"><?php echo $employee->prev_meal;?></td>
                    <td style="text-align: center;"><?php echo $employee->prev_cost;?></td>
                    <td style="text-align: center;"><?php echo $employee->prev_pay;?></td>
                    <td style="text-align: center;"><?php echo $employee->prev_amount;?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
            <?php if($r==1){?>
            <tfoot style="text-align: center;font-weight: bold;">
                <tr>
                    <td colspan="2">Total</td>
                    <td colspan="1"><?= $totalprev_meal ?></td>
                    <td colspan="1"><?= $totalprev_cost ?></td>
                    <td colspan="1"><?= $previouspay ?></td>
                    <td colspan="1"><?= $totalprev_amt ?></td>
                </tr>
            </tfoot>
            <?php }else{ ?>
            <tfoot style="text-align: center;font-weight: bold;">
                <tr>
                    <td colspan="5">Total</td>
                    <td colspan="1"><?= $totalamount ?></td>
                </tr>
            </tfoot>
            <?php } ?>
    </table>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>