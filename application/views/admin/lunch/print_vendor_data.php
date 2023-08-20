<!doctype html>
<html lang="en">

<head>
    <title>Print Vendor Data</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 1px;
        /* reduced padding */
        text-align: left;
        border-bottom: 1px solid #ddd;
        border-right: 1px solid #ddd;
        /* added right border */
    }

    th:last-child,
    td:last-child {
        border-right: none;
        /* remove right border for last column */
    }

    th {
        background-color: #f2f2f2;
    }

    tfoot {
        font-weight: bold;
    }

    .total-row {
        background-color: #ddd;
    }

    .center {
        text-align: center;
    }

    .btn {
        float: right;
        background: #4099ff ;
        padding: 4px;
        cursor: pointer;
        color: #fff;
    }
    @media print {
        .btn {
            display: none; 
        }
      }

    </style>
</head>

<body>
    <a class="btn" onclick=window.print()>Print</a>
    <?php $this->load->view('admin/head_bangla'); ?>
    <div style="font-size:12px; text-align:center;">Vendor Lunch Data of <?=$from_date?> to <?=$to_date?></div>
    <br>

    <table>
        <thead>
            <tr>
                <th class="center">SL</th>
                <th class="center">Date</th>
                <th class="center">Day</th>
                <th class="center">Meal Qty</th>
                <th class="center">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_meal = 0;
            $total_amount = 0;
            foreach($data as $key => $d):
                $total_meal += $d->meal_qty;
                $total_amount += $d->amount;
            ?>
            <tr>
                <td class="center"><?= $key+1 ?></td>
                <td class="center"><?= $d->date ?></td>
                <td class="center"><?= date('D', strtotime($d->date)) ?></td>
                <td class="center"><?= $d->meal_qty ?></td>
                <td class="center"><?= $d->amount ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <th class="center" colspan="3">Total</th>
                <th class="center"> <?= $total_meal ?> </th>
                <th class="center"> <?= $total_amount ?> </th>
            </tr>
        </tfoot>
    </table>
</body>

</html>