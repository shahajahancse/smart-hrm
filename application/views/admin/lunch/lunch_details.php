<?php

$data=$lunch[0]

?>
<style>
.panel {
    border-radius: 10px;
    margin-right: 63px;
}
</style>

<!-- 
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

</div> -->


<?php
$this->load->view('admin/head_bangla');
          $dateStr = $data->date;
                                $date = strtotime($dateStr);
                                $dayName = date("l", $date); 
                                $convertedDate = date('d-m-Y', strtotime($dateStr));

?>
<h5 style='font-size:13px; font-weight:bold; text-align:center'>
    Lunch Details <?php echo   $convertedDate;   ?> ( <?php echo  $dayName;   ?>)
</h5>
<br>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">
                    <h3 class="panel-title">Lunch Details</h3>
                </div> -->
                <div class="panel-body">
                    <table class="table table-border table-hover">
                        <thead>
                            <tr>
                                <th>S.N</th>
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
                            <?php foreach ($lunch_details as $key => $detail) { 
                                $lunch_package=lunch_package($detail->date);

                                
                                ?>
                            <tr>
                                <td><?= $key+1 ?></td>
                                <?php $numKey=$key+1; ?>
                                <td><?= $detail->first_name ?> <?= $detail->last_name ?></td>
                                <td style="text-align: center;"><?= $detail->meal_amount ?></td>
                                <td style="text-align: center;"><?= $detail->meal_amount*$lunch_package->stuf_give_tk ?></td>
                                <td style="text-align: center;"><?= $detail->meal_amount*$lunch_package->office_give_tk ?></td>
                                <!-- <td><?= $detail->comment ?></td> -->
                                <td style="text-align: center;" title="<?php echo $detail->comment; ?>">
                                    <?php echo implode(' ', array_slice(explode(' ', $detail->comment ), 0, 4)); ?></td>
                            </tr>

                            <?php } if($data->guest_m >0){ ?>
                            <tr style="color:blue;">
                                <td><?= $numKey+1 ?></td>
                                <td><?= " Guest Meals"?></td>
                                <td style="text-align: center;"><?= $data->guest_m ?></td>
                                <td style="text-align: center;"><?=$data->guest_m*0   ?></td>
                               <? $lunch_package=lunch_package($detail->date); ?>

                                <td style="text-align: center;"><?= $data->guest_m*$lunch_package->permeal   ?></td>
                                <td style="text-align: center;" title="<?php echo $detail->comment; ?>">
                                    <?php echo implode(' ', array_slice(explode(' ', $detail->comment ), 0, 4)); ?></td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="2" style="text-align: center;"><strong>Total</strong></td>
                                <td style="text-align: center;"><strong><?= $data->emp_m + $data->guest_m  ?></strong>
                                </td>
                                <td style="text-align: center;"><strong><?= $data->emp_cost ?></strong></td>
                                <td style="text-align: center;"><strong><?= $data->total_cost ?></strong></td>
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
                            <td style="text-align:center"><?php echo $data->emp_m + $data->guest_m; ?></td>
                            <td style="text-align:center"><?php echo $data->emp_m ?></td>
                            <td style="text-align:center"><?php echo $data->guest_m; ?></td>
                            <td style="text-align:center"><?php echo $data->emp_cost ?></td>
                            <td style="text-align:center"><?php echo  $data->total_cost  ?></td>
                            <td style="text-align:center"><?php echo $data->emp_cost  + $data->total_cost ?></td>
                        </tr>
                    </table>



                </div>
            </div>
        </div>
    </div>
</div>