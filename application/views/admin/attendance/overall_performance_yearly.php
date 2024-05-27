<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Monthly Report</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .employee-info, .monthly-data {
            margin-bottom: 20px;
        }
        .summary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
<div style="text-align: center;">
<?php  $this->load->view('admin/head_bangla'); ?>
  <h4 class="box-title">Monthly Attendance and Performance Data of <?= $year ?></h4>
	  <br><br>
  </div>
<?php
foreach($data as $key => $employee){?>
    <div class="monthly-data">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="bg-info text-white">
                    <th colspan="7"><?= $employee["first_name"]?> <?= $employee["last_name"]?></th>
                </tr>
                <tr>
                    <th>Month</th>
                    <th>Total Days</th>
                    <th>Total Present</th>
                    <th>Total Absent</th>
                    <th>Total Late</th>
                    <th>Total Overtime (hours)</th>
                    <th>Total Leave</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employee["employee_data_month"] as $month_data) : ?>
                    <tr>
                        <td><?= $month_data["month"] ?></td>
                        <td><?= $month_data["total_day"] ?></td>
                        <td><?= $month_data["total_present"] ?></td>
                        <td><?= $month_data["total_absent"] ?></td>
                        <td><?= $month_data["total_late"] ?></td>
                        <td><?= $month_data["total_overtime"] ?></td>
                        <td><?= $month_data["total_leave"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
