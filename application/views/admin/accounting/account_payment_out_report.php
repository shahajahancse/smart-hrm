<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Table</title>
    <style>
        table{
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            text-align: left;
        }

        th, td {
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php $this->load->view('admin/head_bangla')?>
    <span style="justify-content: center;display: flex;">Expense Report of <?= $first_date?> to
        <?= $second_date?></span>
    <table>
        <thead>
        <!-- [0] => stdClass Object
                (
                    [id] => 1
                    [purposes] => 1
                    [amount] => 3425234
                    [date] => 2023-09-10
                    [Expense_Type] => 3
                    [Payment_Way] => Bkash
                    [note] => hgahfgh
                    [title] => Salary
                    [expense_type] => 3
                ) -->
            <tr>
                <th>SL</th>
                <th>Purposes</th>
                <th>Expense_Type</th>
                <th>Amount</th>
                <th>Payment Way</th>
                <th>Date</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($data as $key => $row)  { ?>
                <tr>
                <td> <?= ($key + 1) ?> </td>
                <td><?= $row->title ?></td>
                <td><?= getPaymentTypeLabel($row->Expense_Type) ?></td>
                <td><?= $row->amount ?></td>
                <td><?= $row->Payment_Way?></td>
                <td><?= $row->date?></td>
                <td><?= $row->note?></td>
                </tr>
            <?php } ?>
           <?php
            function getPaymentTypeLabel($paymentType) {
                $labels = [
                    1 => 'Installment',
                    2 => 'Weekly',
                    3 => 'Monthly',
                    4 => 'Yearly'
                ];
                return isset($labels[$paymentType]) ? $labels[$paymentType] : 'Unknown';
            }
            ?>
        </tbody>
    </table>
</body>
</html>
