<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php  $this->load->view('admin/head_bangla'); ?>

<h4 class="text-center">Report of Employee Internship List</h4>
<table class="table table-striped table-bordered">
    <thead style="font-size:12px;" >
        <tr>
              <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Designation</th>
            <th class="text-center">Department</th>
            <th class="text-center">Probation Preiod</th>
            <th class="text-center">Gross Salary</th>
            <th class="text-center">Increment Amount</th>
            <th class="text-center">Comments</th>
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
            <td><?= '-'?></td>
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
