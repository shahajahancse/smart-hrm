<!DOCTYPE html>
<html>

<head>
    <title>Employee Lunch Collection</title>
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

    table thead tr th {
        font-size: 12px;
        color: blue;
        padding: 3px !important;
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

        $date = new DateTime($lunch_data[0]->end_date);
        $date->add(new DateInterval('P1M'));
        $newDate = $date->format('Y-m-d');
    ?>

    <div class="container">
        <a onclick="window.print()" class="btn btn-primary" style="float: right;margin-top: 26px;">Print</a>
        <?php if(isset($status)): ?>
        <div class="export-button">
            <form style="float: right;margin-top: 27px;margin-right: 5px;"
                action="<?php echo base_url();?>admin/Lunch/paymentreport" method="post">
                <input type="hidden" name="status" value="<?php echo $status; ?>"></input>
                <input type="hidden" name="excel" value="1"></input>
                <button type="submit" class="btn btn-primary" style="border: 0; cursor:pointer;" alt="XLS Export">XLS
                    Export</button>
            </form>
        </div>
        <?php endif; ?>


        <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px">
            <?php echo xin_company_info(1)->company_name; ?></div>
        <div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
        <div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;">
            <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>

        <div style="font-size:13px; line-height:15px; text-align:center;">Monthly Lunch Payment Report
            of <?php $convertedDate1 = date('d-m-Y', strtotime($lunch_data[0]->end_date));

               $convertedDate2 = date('d-m-Y', strtotime($lunch_data[0]->next_date)); ?>

            <?= isset($lunch_data[0]->end_date) ? $convertedDate1 : ''; ?> to

            <?= isset($convertedDate2) ? $convertedDate2: ''; ?>

        </div>
    </div>
    <div class="table-responsive" style="margin-top: 0px; padding:10px;">
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
                <?php  

            
            $totalamount=$previouspay=$total_cl_ml=$total_probable_meal=$total_stock=$totalbalacemeal=0;
                foreach ($lunch_data as $key=>$employee): 
                    // dd($employee); 
                    $lunch_package=lunch_package($employee->from_date);
                    $pbm = ($employee->prev_amount/$lunch_package->stuf_give_tk);
                    $total_cl_ml += ($employee->pay_amount/$lunch_package->stuf_give_tk);
                    $previouspay+=$employee->prev_pay;
                    
                    $total_probable_meal += $employee->probable_meal;
                    $totalamount += $employee->collection_amount;
                    $total_stock += $employee->prev_amount/$lunch_package->stuf_give_tk;
                    $totalbalacemeal += $employee->probable_meal-$pbm;

                    ?>

                <tr>
                    <td style="text-align:center"><?php echo $key+1 ?></td>
                    <td><?php echo $employee->first_name;?> <?php echo $employee->last_name; ?></td>
                    <td style="text-align:center"><?php echo $employee->probable_meal;?></td>
                    <td style="text-align:center"><?php echo number_format($pbm, 2);?></td>
                    <td style="text-align:center"><?php echo number_format($employee->probable_meal - $pbm, 2);?></td>
                    <td style="text-align:center">
                        <?php echo number_format($employee->pay_amount / $lunch_package->stuf_give_tk, 2);?></td>
                    <td style="text-align:center"><?php echo number_format($employee->collection_amount, 2);?></td>
                    <td style="color: <?php echo $employee->status == 1 ? 'blue' : 'red'; ?> text-align:center">
                        <?php echo $employee->status == 1 ? 'Paid' : 'Unpaid'; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot style="text-align: center;font-weight: bold;">
                <tr>
                    <td style="text-align: center; margin-right: 5px;" colspan="2">Total</td>
                    <td colspan="1"><?= $total_probable_meal ?></td>
                    <td colspan="1"><?= $total_stock ?></td>
                    <td colspan="1"><?= $totalbalacemeal ?></td>
                    <td colspan="1"><?= $total_cl_ml ?></td>
                    <td colspan="1"><?= $totalamount ?></td>
                </tr>
            </tfoot>
        </table>
    </div>


    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>