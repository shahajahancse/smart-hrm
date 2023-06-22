<?php

$data=$lunch[0]

?>
<style>
.panel {
    border-radius: 10px;
    margin-right: 63px;
}
</style>


<div class="container">
    <div class="row">
        <div class="col-md-6 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Lunch</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Total Meal:</strong> <?= $data->total_m ?><br>
                            <strong>Emp Meal:</strong> <?= $data->emp_m ?><br>
                            <strong>Guest Meal:</strong> <?= $data->guest_m ?><br>

                            <strong>Date:</strong> <?= $data->date ?><br>
                        </div>
                        <div class="col-sm-6">
                            <strong>Total Cost:</strong> <?= $data->total_cost ?><br>
                            <strong>Employee Cost:</strong> <?= $data->emp_cost ?><br>
                            <strong>Guest Cost:</strong> <?= $data->guest_cost ?><br>

                        </div>
                        <?php if($data->bigcomment){?>
                        <div class="col-sm-12">
                            <strong>Comment:</strong><br>
                            <section
                                style="width: 100%;border: 1px solid black;padding: 6px;border-radius: 7px;margin-top: 7px;">
                                <?= $data->bigcomment ?></section>
                        </div>
                        <?php } ?>

                    </div>

                </div>
            </div>
        </div>
        <?php

 $currentDate = date('Y-m-d');
if($data->date==$currentDate){

    ?>
        <a href="<?=  base_url('admin/lunch/today_lunch/'.$data->id)?>" class="btn btn-info">Edit</a>
        <?php } ?>
    </div>

</div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Lunch Details</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-border table-hover">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th width="150px">Date</th>
                                <th width="150px">Days</th>
                                <th width="250px">Employee Name</th>
                                <th width="150px" style="text-align: center;">Meal Quantity</th>
                                <th style="text-align: center;">Remarks</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lunch_details as $detail) { ?>
                            <tr>
                                <td><?= $detail->id ?></td>
                                <td><?= $detail->date ?></td>
                                <?php   $dateStr = $detail->date;
                                $date = strtotime($dateStr);
                                $dayName = date("l", $date); ?>
                                <td> <?= $dayName?></td>

                                <td><?= $detail->first_name ?> <?= $detail->last_name ?></td>
                                <td style="text-align: center;"><?= $detail->meal_amount ?></td>


                                <td><?= $detail->comment ?></td>
                               
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>