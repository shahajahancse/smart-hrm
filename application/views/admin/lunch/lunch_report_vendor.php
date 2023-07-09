<?php $paySlipData=$lunch_data   ?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        padding: 20px;
    }

    .pay-slip-container {
        max-width: 400px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .pay-slip-header {
        text-align: center;
        margin-bottom: 8px;
    }

    .pay-slip-header h1 {
        color: #333;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        border: 2px solid black;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    td {
        color: #555;
    }
    </style>
</head>

<body>
    <div class="pay-slip-container">
        <div class="pay-slip-header">
            <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px">
                <?php echo xin_company_info(1)->company_name; ?></div>
            <div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
            <div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;">
                <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
            <div>Lunch Date:
                <?php  $convertedDate = date('d-m-Y', strtotime($paySlipData[0]->date)); ?>
                <?php echo $convertedDate; ?></div>
            <div style="font-size:12px; font-weight:bold; text-align:center;"></div>
            <div style="font-size:18px; font-weight:bold; text-align:center;">Vendor Voucher</div>

        </div>

        <?php
        // Assuming you are using PHP to generate the HTML


        // Iterate over the pay slip data and generate the HTML table
        foreach ($paySlipData as $item) {
            echo '<table>';
            echo '<tr><th>Total Meal</th><td>' . $item->total_m . '</td></tr>';
            echo '<tr><th>Employee Meal</th><td>' . $item->emp_m . '</td></tr>';
            echo '<tr><th>Guest Meal</th><td>' . $item->guest_m . '</td></tr>';
            echo '<tr><th>Employee Cost</th><td>' . $item->emp_cost . '</td></tr>';
            echo '<tr><th>Guest Cost</th><td>' . $item->guest_cost*2 . '</td></tr>';
            echo '<tr><th>Office Employee Cost</th><td>' . $item->emp_cost . '</td></tr>';
            echo '<tr><th>Total Cost</th><td>' .$item->total_cost*2 . '</td></tr>';
            echo '</table>';
        }
        ?>
        <?php if (!$paySlipData[0]->bigcomment=="") {?>
        <div style="padding:5px;">
            <span style="font-weight: bold;">Comment:</span>
            <p style="border: 2px solid black;padding: 5px;border-radius: 5px;margin: 0;">
                <?= $paySlipData[0]->bigcomment ?>
            </p>
        </div>
        <?php } ?>
    </div>
</body>

</html>