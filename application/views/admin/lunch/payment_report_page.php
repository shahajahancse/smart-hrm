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
    </style>
</head>
<body>

        <div class="container">
                <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
				<div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
				<div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;"> <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
				<div style="font-size:16px; line-height:15px; font-weight:bold; text-align:center;" >Monthly Lunch Payment Report of <?= isset($lunch_data[0]->from_date) ? $lunch_data[0]->from_date : ''; ?> to <?= isset($lunch_data[0]->end_date) ? $lunch_data[0]->end_date : ''; ?> </div>
        </div>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Previous Meal</th>
                    <th>Previous Cost</th>
                    <th>Previous Pay</th>
                    <th>Previous Amount</th>
                    <th>P.Meal</th>
                    <th>Pay Amount</th>
                    <th>From Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lunch_data as $employee): ?>
                <tr>
                    <td><?php echo $employee->first_name;?> <?php echo $employee->last_name; ?></td>
                    <td><?php echo $employee->prev_meal;?></td>
                    <td><?php echo $employee->prev_cost;?></td>
                    <td><?php echo $employee->prev_pay;?></td>
                    <td><?php echo $employee->prev_amount;?></td>
                    <td><?php echo $employee->pay_amount/45;?></td>
                    <td><?php echo $employee->pay_amount-$employee->prev_amount; ?></td>
                    <td><?php echo $employee->from_date; ?></td>
                    <td><?php echo $employee->end_date; ?></td>
                    <td style="color: <?php echo $employee->status == 1 ? 'blue' : 'red'; ?>">
                        <?php echo $employee->status == 1 ? 'Paid' : 'Unpaid'; ?>
                    </td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
