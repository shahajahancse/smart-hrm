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
    <span style="justify-content: center;display: flex;">Payment In  Report of <?= $first_date?> to
        <?= $second_date?></span>
    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Client Name</th>
                <th>Project Name</th>
                <th>Payment For</th>
                <th>Payment Type</th>
                <th>Date</th>
                <th>Payment Way</th>
                <th>Payment Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($data as $key => $row)  { ?>
                <tr>
                <td> <?= ($key + 1) ?> </td>
                <td><?= $row->client_name ?></td>
                <td><?= $row->project_name ?></td>
                <td><?= $row->payment_for == 1 ? 'Software' : 'Service'?></td>
                <td><?= getPaymentTypeLabel($row->payment_type) ?></td>
                <td><?= $row->date ?></td>
                <td><?= $row->payment_way?></td>
                <td><?= $row->pyment_amount?></td>
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
