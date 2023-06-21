

<?php $date = new DateTime($lunch_data[0]->end_date);
$date->add(new DateInterval('P1M'));
$newDate = $date->format('Y-m-d');

?>
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
        .table{
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

        .table-hover > tbody > tr:hover > td,
        .table-hover > tbody > tr:hover > th {
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
        td{
            margin: 0!important;
            padding: 0!important;
        }
        @media print {
            .btn{
                display: none;
            }
        
      }
    </style>
</head>
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
				<div style="font-size:16px; line-height:15px; font-weight:bold; text-align:center;" >Monthly Lunch Payment Report of <?= isset($lunch_data[0]->end_date) ? $lunch_data[0]->end_date : ''; ?> to <?= isset($newDate) ? $newDate: ''; ?> </div>
        </div>
        <table class="table table-bordered table-hover table-striped">
            <thead style="text-align: center;">
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Current M. Lunch day</th>
                    <th>Stock Lunch Balance</th>
                    <th>Balance Days</th>
                    <th>Collection Day</th>
                    <th>Collection Amount</th>
                    <th>Status</th>
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
                    <td><?php echo $employee->probable_meal;?></td>
                    <td><?php echo $pbm;?></td>
                    <td><?php echo $employee->probable_meal-$pbm;?></td>
                    <td><?php echo $employee->pay_amount/45;?></td>
                    <td><?php echo $employee->pay_amount;?></td>
                    <td style="color: <?php echo $employee->status == 1 ? 'blue' : 'red'; ?>">
                        <?php echo $employee->status == 1 ? 'Paid' : 'Unpaid'; ?>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
            <?php if($r==1){?>

                <tfoot style="text-align: center;font-weight: bold;">
                <tr>
                    <td colspan="6">Total</td>
                    <td colspan="1"><?= $totalamount ?></td>
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
