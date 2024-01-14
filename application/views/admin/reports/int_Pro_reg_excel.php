<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">

<?php
$filename = "excel_list.xls";
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
?>
<link rel="stylesheet"
    href="<?php echo base_url(); ?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<body style="background:white">
    <?php $this->load->view('admin/head_bangla');?>
    <h4 class="text-center">Report of <?= $data_type ?> Pending List From <?php echo $first_date; ?> To <?php echo $second_date; ?></h4>
    <table class="table table-striped table-bordered">
        <thead style="font-size:12px;" >
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Name</th>
                <th class="text-center">Designation</th>
                <th class="text-center">Department</th>
                <th class="text-center">Joining Date</th>
                <th class="text-center">End <?= $data_type_n ?> Date</th>
                <th class="text-center"><?= $data_type_n ?> Period</th>
                <th class="text-center">Next Increment</th>
                <th class="text-center">Increment</th>
                <?php if($session['role_id']==1){?>
                <th class="text-center">Gross Salary</th>
                <?php }?>
                <th class="text-center">Job Duration</th>
            </tr>
        </thead>
        <tbody style="font-size:12px;" >
            <?php if (!empty($emp_list)) {
            $i=1; foreach ($emp_list as $key => $value) {?>
                <tr class="text-center">
                    <td><?= $i++?></td>
                    <td><?= $value->first_name.' '.$value->last_name?></td>
                    <td><?= $value->department_name?></td>
                    <td><?= $value->designation_name?></td>
                    <td><?= $value->date_of_joining?></td>
                    <td><?php echo $value->last_incre_date ?></td>
                    <td>
                        <?php
                            $joiningDate = new DateTime($value->date_of_joining);
                            $nextIncreDate = new DateTime($value->last_incre_date);
                            
                            $diff = $joiningDate->diff($nextIncreDate);
                            
                            $years = $diff->y;
                            $months = $diff->m;
                            $days = $diff->d;
                        ?>
                        <?=($years)?$years.' Years ':''?><?=($months)?$months.' Months ':''?><?=($days)?$days.' Days ':''?>
                    </td>
                    <td><?=  $value->next_incre_date ?></td>
                    <td><?= $value->new_salary - $value->old_salary?></td>
                    <?php if($session['role_id']==1){?>
                    <td><?= $value->basic_salary?></td>
                    <?php } ?>
                    <?php 
                        $date2 = new DateTime();
                        $interval = date_diff($joiningDate, $date2);
                    ?>
                    <td><?= ($interval->y == 0 ? '':$interval->y.' years ').$interval->m.' months '.$interval->d.' days'?></td>
                </tr>
            <?php } }?>
        </tbody>
    </table>

    <br>
    <h4 class="text-center">Report of <?= $data_type ?> Complete List From <?php echo $first_date; ?> To <?php echo $second_date; ?></h4>
    <table class="table table-striped table-bordered">
        <thead style="font-size:12px;" >
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Name</th>
                <th class="text-center">Designation</th>
                <th class="text-center">Department</th>
                <th class="text-center">Joining Date</th>
                <th class="text-center">End <?= $data_type_n ?> Date</th>
                <th class="text-center"><?= $data_type_n ?> Period</th>
                <th class="text-center">Next Increment</th>
                <th class="text-center">Increment</th>
                <?php if($session['role_id']==1){?>
                <th class="text-center">Gross Salary</th>
                <?php }?>
                <th class="text-center">Job Duration</th>
            </tr>
        </thead>
        <tbody style="font-size:12px;" >
            <?php if (!empty($done_list)) {
                $i=1; foreach ($done_list as $key => $value) {?>
                <tr class="text-center">
                    <td><?= $i++?></td>
                    <td><?= $value->first_name.' '.$value->last_name?></td>
                    <td><?= $value->department_name?></td>
                    <td><?= $value->designation_name?></td>
                    <td><?= $value->date_of_joining?></td>
                    <td><?php echo $value->last_incre_date ?></td>
                    <td>
                        <?php
                            $joiningDate = new DateTime($value->date_of_joining);
                            $nextIncreDate = new DateTime($value->last_incre_date);
                            
                            $diff = $joiningDate->diff($nextIncreDate);
                            
                            $years = $diff->y;
                            $months = $diff->m;
                            $days = $diff->d;
                        ?>
                        <?=($years)?$years.' Years ':''?><?=($months)?$months.' Months ':''?><?=($days)?$days.' Days ':''?>
                    </td>
                    <td><?=  $value->next_incre_date ?></td>
                    <td><?= $value->new_salary - $value->old_salary?></td>
                    <?php if($session['role_id']==1){?>
                    <td><?= $value->basic_salary?></td>
                    <?php } ?>
                    <?php 
                        $date2 = new DateTime();
                        $interval = date_diff($joiningDate, $date2);
                    ?>
                    <td><?= ($interval->y == 0 ? '':$interval->y.' years ').$interval->m.' months '.$interval->d.' days'?></td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</body>

</html>