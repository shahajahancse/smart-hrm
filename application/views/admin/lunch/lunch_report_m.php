<?php
    $month_year = $first_date;
    $date = strtotime(date("Y-m-d"));
    $imonth_year = explode('-', $month_year);
    // dd($imonth_year);
    $day = date('d', $date);
    $month = date($imonth_year[1], $date);

    $nummonth = date($imonth_year[1], $date);
    $year = date($imonth_year[0], $date);

    // Total days in month
    $daysInMonth = cal_days_in_month(0, $month, $year);

    $monthName = date('F', mktime(0, 0, 0, $month, 1));
    exit();
   
?>

<!DOCTYPE html>
<html>

<head>
    <title>Monthly Lunch Report</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .container {

        padding: 20px;

    }

    .totals-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding: 5px;
        border: 1px solid #908c96;
        border-radius: 11px;
    }

    .pf {}

    .totals-container .col {
        flex-basis: 45%;
        font-size: 18px;
        line-height: 25px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        padding: 0;
        margin: 0;
        border: 1px solid #ddd;
        /* Add border to the table */
    }

    th,
    td {
        text-align: left;
        border-bottom: 1px solid #ddd;
        padding: 8px;
        /* Add padding to cells */
        margin: 0;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        /* Apply hover effect to rows */
        background-color: #d1d8df;
    }
    </style>
</head>

<body>
    <div class="container">
        <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px">
            <?php echo xin_company_info(1)->company_name; ?>
        </div>
        <div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
        <div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;">
            <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
        <div style="font-size:16px; line-height:15px; font-weight:bold; text-align:center;">Monthly Lunch Report of
            <?= $monthName?> </div>
    </div>
    <h2>Lunch Details</h2>
    <table>
        <thead>
            <tr class="tdb">
                <th class="mastering">Name</th>
                <?php for ($i = 1; $i <= $daysInMonth; $i++) : ?>
                <?php $i = str_pad($i, 2, 0, STR_PAD_LEFT); ?>
                <?php
                        $tdate = $year . '-' . $month . '-' . $i;
                        // Convert the date string into a Unix timestamp.
                        $unixTimestamp = strtotime($tdate);
                        // Get the day of the week.
                        $dayOfWeek = date('D', $unixTimestamp);
                        ?>
                <th><strong><?= '<div>' . $i . ' </div>'; ?></strong></th>
                <?php endfor; ?>
                <th>Total Meal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emp_id as $empid) {
                        $emp = $this->Lunch_model->employees($empid);
                    ?>
            <tr>
                <td><?= $emp[0]->first_name ?> <?= $emp[0]->last_name ?></td>
                <?php
                            $totalmeal = 0;
                            for ($i = 1; $i <= $daysInMonth; $i++) {
                                $ddate = $year . '-' . $nummonth . '-' . $i;
                                $getmeal =  $this->Lunch_model->get_meal($emp[0]->user_id, $ddate);
                            ?>
                <td>
                    <?php
                                    if (count($getmeal) > 0) {
                                        $totalmeal += $getmeal[0]->meal_amount;
                                        echo ($getmeal[0]->meal_amount);
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                </td>
                <?php } ?>
                <td><?= $totalmeal ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
            // Assuming you have the 'lunch_data' and 'lunch_details' variables available
            $lunchData = $lunch_data;

            // Initialize merged totals
            $mergedTotals = array(
                'total_m' => 0,
                'emp_m' => 0,
                'guest_m' => 0,
                'total_cost' => 0,
                'emp_cost' => 0,
                'guest_cost' => 0
            );

            // Extract month name and calculate merged totals
            foreach ($lunchData as $data) {
                $date = date_create($data->date);
                $monthName = date_format($date, 'F');

                $mergedTotals['total_m'] += $data->total_m;
                $mergedTotals['emp_m'] += $data->emp_m;
                $mergedTotals['guest_m'] += $data->guest_m;
                $mergedTotals['total_cost'] += $data->total_cost;
                $mergedTotals['emp_cost'] += $data->emp_cost;
                $mergedTotals['guest_cost'] += $data->guest_cost;

                $lunchDataByMonth[$monthName][] = $data;
            }
        ?>

    <div class="totals-container">
        <div class="col">
            <strong>Employee Meals:</strong> <?= $mergedTotals['emp_m'] ?><br>
            <strong>Guest Meal:</strong> <?= $mergedTotals['guest_m'] ?><br>
            <strong>Total Meals:</strong> <?= $mergedTotals['total_m'] ?><br>
        </div>
        <div class="col">
            <strong>Employee Cost:</strong><?= $mergedTotals['emp_cost'] ?><br>
            <strong>Guest Cost:</strong><?= $mergedTotals['guest_cost'] ?><br>
            <strong>Total Cost:</strong> <?= $mergedTotals['total_cost'] ?><br>
        </div>
    </div>

    <script>
    // Add any JavaScript code you need here
    </script>
    </div>
</body>

</html>