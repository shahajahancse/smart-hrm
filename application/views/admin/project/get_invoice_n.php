<!DOCTYPE html>
<html>
<head>
    <title>Beautiful Invoice</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table {
            width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        td,
        caption {
            padding: 16px;
        }

        th {
            padding: 16px;
            background-color: lightblue;
            text-align: left;
        }
    </style>
</head>
<body>
<table>
    <caption><b>Invoice</b></caption>
    <tr>
        <th colspan="3">Invoice #<?php echo $invoice_data->id; ?></th>
        <th><?php echo date('d F Y', strtotime($invoice_data->date)); ?></th>
    </tr>
    <tr>
        <td colspan="2">
            <strong>Pay To:</strong> <br> Mysoftheaven LTD<br>
            Shapla House 363/H/2,<br>
            North Pirerbag, Raisa & Shikdhar Tower, Level-5, 3/8, Kamal Soroni Rd, Dhaka-1207.
        </td>
        <td colspan="2">
            <strong>Customer:</strong> <br>
            <?php echo $invoice_data->client_name; ?> <br>
            Dummy Apartments <br>
        </td>
    </tr>
    <tr>
        <th>Name/Description</th>
        <th>MRP</th>
        <th>Amount</th>
    </tr>
    <tr>
        <td><?php echo $invoice_data->title; ?></td>
        <td><?php echo $invoice_data->pyment_amount; ?></td>
        <td><?php echo $invoice_data->pyment_amount; ?></td>
    </tr>
    <tr>
        <th colspan="2">Grand Total:</th>
        <td>BDT <?php echo $invoice_data->pyment_amount?></td>
    </tr>
    <tr>
        <td colspan="4">
            <?php
            if($invoice_data->payment_for==1){ 
                $n='Software payment';
            }else {
                $n='Service payment';
            }
            echo "<strong>Payment Type:</strong> " . $n . "<br>";
            ?>
            <strong>Payment Way:</strong> <?php echo $invoice_data->payment_way; ?><br>
            <strong>Due:</strong> <?php echo $invoice_data->due; ?><br>
            <strong>Created At:</strong> <?php echo $invoice_data->create_at; ?><br>
        </td>
    </tr>
</table>
</body>
</html>
