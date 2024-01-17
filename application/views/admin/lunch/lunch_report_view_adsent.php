<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 30px;
    }

    .panel {
        border-radius: 10px;
        margin-right: 30px;
        background-color: #ffffff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .panel-heading {
        background-color: #c2c8ce;
        padding: 6px;
        border-radius: 10px 10px 0 0;
    }

    .panel-title {
        color: #333333;
        font-size: 24px;
        font-weight: bold;
        margin-top: 0;
    }

    .panel-body {
        padding: 20px;
    }

    .panel-body strong {
        color: #333333;
        font-weight: bold;
    }

    .comment-section {
        width: 100%;
        border: 1px solid #333333;
        padding: 10px;
        border-radius: 7px;
        margin-top: 10px;
        background-color: #f8f9fa;
    }

    table {
        width: 100%;
    }

    table th {
        background-color: #f8f9fa;
        color: #333333;
        font-weight: bold;
        text-align: left;
    }

    table td {
        vertical-align: middle;
    }
    </style>
</head>

<body>
    <?php if (count($lunch_data) == 0) : ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-danger text-center" role="alert">
                    <strong>There are no data</strong>
                </div>
            </div>
        </div>
    </div>
    <?php else : ?>
    <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px">
        <?php echo xin_company_info(1)->company_name; ?></div>
    <div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
    <div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;">
        <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
    <div style="font-size:15px; font-weight:bold; text-align:center;">Daily Inactive Lunch Report</div>
    <div style="font-size:17px; line-height:15px;  text-align:center;">Lunch Date:
        <?php   $dateStr = $lunch_data[0]->date;
                  $date = strtotime($dateStr);
                 $dayName = date("l", $date);
                 $convertedDate = date('d-m-Y', strtotime($dateStr));
                
               
           ?>
        <?php echo  $convertedDate ." (" .$dayName .")" ; ?></div>



    </div>
    <?php $data=$lunch_data[0]  ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">

                    <div class="">
                        <table class="table table-border table-hover">
                            <thead>
                                <tr>
                                    <th width="50px">S.N</th>
                                    <!-- <th width="150px">Date</th>
                                <th width="150px">Days</th> -->
                                    <th width="250px">Employee Name</th>
                                    <th width="150px" style="text-align: center;">Quantity</th>
                                    <th width="150px" style="text-align: center;">Employee-Cost</th>

                                    <th width="150px" style="text-align: center;">Office-Cost</th>

                                    <th style="text-align: center;">Remarks</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $numKey=0; ?>
                                <?php foreach ($lunch_details_inactive as $key => $detail) { 
                                    $lunch_package=lunch_package($detail->date);
                                    
                                    ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <?php $numKey=$key+1; ?>
                                    <td><?= $detail->first_name ?> <?= $detail->last_name ?></td>
                                    <td style="text-align: center;"><?= $detail->meal_amount ?></td>
                                    <td style="text-align: center;"><?= $detail->meal_amount*$package->stuf_give_tk ?></td>
                                    <td style="text-align: center;"><?= $detail->meal_amount*$package->office_give_tk ?></td>
                                    <!-- <td><?= $detail->comment ?></td> -->
                                    <td style="text-align: center;" title="<?php echo $detail->comment; ?>">
                                        <?php echo implode(' ', array_slice(explode(' ', $detail->comment ), 0, 4)); ?>
                                    </td>
                                </tr>

                                <?php } if($data->guest_m >0){ ?>
                                <tr style="color:blue;">
                                    <td><?= $numKey+1 ?></td>
                                    <td><?= " Guest Meals"?></td>
                                    <td style="text-align: center;"><?= $data->guest_m*0?></td>
                                    <td style="text-align: center;"><?=$data->guest_m*0   ?></td>
                                    <td style="text-align: center;"><?= $data->guest_m*90*0  ?></td>
                                    <td style="text-align: center;" title="<?php echo $detail->comment; ?>">
                                        <?php echo implode(' ', array_slice(explode(' ', $detail->comment ), 0, 4)); ?>
                                    </td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td colspan="2" style="text-align: center;"><strong>Total</strong></td>
                                    <td style="text-align: center;">
                                        <strong><?= $data->emp_m*0 + $data->guest_m*0  ?></strong></td>
                                    <td style="text-align: center;"><strong><?= $data->emp_cost*0 ?></strong></td>
                                    <td style="text-align: center;"><strong><?= $data->total_cost*0 ?></strong></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>


                        <table class="table table-border table-hover">
                            <tr>
                                <th style="text-align:center">Total Meals</th>
                                <th style="text-align:center">Employee Meals</th>
                                <th style="text-align:center">Guest Meals</th>
                                <th style="text-align:center">Total Employee Cost</th>
                                <th style="text-align:center">Total Office Cost</th>
                                <th style="text-align:center">Toatal Cost</th>
                            </tr>
                            <tr>
                                <td style="text-align:center"><?php echo $data->emp_m*0 + $data->guest_m*0; ?></td>
                                <td style="text-align:center"><?php echo $data->emp_m*0 ?></td>
                                <td style="text-align:center"><?php echo $data->guest_m*0; ?></td>
                                <td style="text-align:center"><?php echo $data->emp_cost*0 ?></td>
                                <td style="text-align:center"><?php echo  $data->total_cost*0  ?></td>
                                <td style="text-align:center"><?php echo $data->emp_cost*0  + $data->total_cost*0 ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>

</html>