

<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<?php 
    $filename = "Increment_List.xls";
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache
?>
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">

<h2 class="text-center"><?php echo xin_company_info(1)->company_name; ?></h2>
<h3 class="text-center"> <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></h3>

<h3 class="text-center">Report of Increment</h3><br>
<table class="table table-striped table-bordered" border='1'>
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Designation</th>
            <th class="text-center">Department</th>
            <th class="text-center">Joining Date</th>
            <th class="text-center">Probation Preiod</th>
            <th class="text-center">Increment</th>
            <th class="text-center">Position Change</th>
            <th class="text-center">Next Increment</th>
            <th class="text-center">Job Duration</th>
        </tr>
    </thead>
    <tbody style="font-size:12px;" >
        <?php $i=1; foreach ($emp_list as $key => $value) {?>
        <tr>
            <td><?= $i++?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->department_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= $value->date_of_joining?></td>
            <td class="text-center"><?= '-'?></td>
            <?php  $inc_ammount = $this->db->select('old_salary,new_salary')->where('emp_id',$value->user_id)->get('xin_employee_incre_prob')->row();?>
            <td class="text-center"><?= !empty($inc_ammount) ? ($inc_ammount->new_salary - $inc_ammount->old_salary) : '-'?></td>
            <td class="text-center"><?= '-'?></td>
            <td><?= $value->next_incre_date?></td>
            <?php 
                $years = floor($value->duration / 365); 
                $remainingDays = $value->duration % 365;
                $months = floor($remainingDays / 30); 
                $remainingDays = $remainingDays % 30;
            ?>
            <td><?= ($years == 0 ? '': $years.' years ').$months.' months '. $remainingDays.' days'?></td>
        </tr>
        <?php }?>
    </tbody>
</table>

</body>
