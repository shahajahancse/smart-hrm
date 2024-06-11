<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payslip</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 8px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .header h5 {
            margin: 0;
            color: #007bff;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .info-value {
            flex: 1;
            margin-left: 10px;
        }

        .status-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .status-table th,
        .status-table td {
            border: 1px solid #ddd;
            padding: 1px;
            text-align: center;
            font-weight: bold;
        }

        .status-table th {
            background-color: #f0f0f0;
            color: #007bff;
        }

        .pay-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .pay-table th,
        .pay-table td {
            border: 1px solid #ddd;
            padding: 1px;
            text-align: center;
            font-weight: bold;
        }

        .pay-table th {
            background-color: #f0f0f0;
            color: #007bff;
        }

        .net-pay {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h5>Payslip</h5>
            <span>Payment slip for the month of <?= $salary_month ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">EMP ID :</span>
            <span class="info-value"><?= $values[0]->employee_id ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">EMP Name :</span>
            <span class="info-value"><?= $values[0]->first_name ?> <?= $values[0]->last_name ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Desg :</span>
            <span class="info-value"><?= $values[0]->designation_name ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Ac No:</span>
            <span class="info-value"><?= $values[0]->account_number ?></span>
        </div>
        <div class="status">
            <p class="info-label">Working Status :</p>
            <table class="status-table">
                <thead>
                    <tr>
                        <th>Present Status</th>
                        <th>Day</th>
                        <th>Leave Status</th>
                        <th>Day</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Present</td>
                        <td><?= $values[0]->present ?></td>
                        <td class="info-label">Earn</td>
                        <td><?= $values[0]->earn_leave ?></td>
                    </tr>
                    <tr>
                        <td>Absent</td>
                        <td><?= $values[0]->absent ?></td>
                        <td class="info-label">Sick</td>
                        <td><?= $values[0]->sick_leave ?></td>
                    </tr>
                    <tr>
                        <td>Holiday</td>
                        <td><?= $values[0]->holiday ?></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td>Weekend</td>
                        <td><?= $values[0]->weekend ?></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td>Extra P</td>
                        <td><?= $values[0]->extra_p ?></td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="status">
            <p class="info-label">Pay Status :</p>
            <table class="pay-table">
                <thead>
                    <tr>
                        <th>Earnings</th>
                        <th>Amount</th>
                        <th>Deductions</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Basic</td>
                        <td><?= $values[0]->basic_salary ?></td>
                        <td class="info-label">Late</td>
                        <td><?= $values[0]->late_deduct ?></td>
                    </tr>
                    <tr>
                        <td>Modify Salary</td>
                        <td><?= $values[0]->modify_salary ?></td>
                        <td class="info-label">Absent</td>
                        <td><?= $values[0]->absent_deduct ?></td>
                    </tr>
                    <tr>
                        <td>Extra Pay</td>
                        <td><?= $values[0]->extra_pay ?></td>
                        <td class="info-label">Lunch</td>
                        <td><?= $values[0]->lunch_deduct ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="net-pay">
            Net Pay: <?= ($values[0]->grand_net_salary) + ($values[0]->modify_salary) ?>
        </div>
    </div>
</body>

</html>
