


<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<style>
    @media print{
        #excel{
            display:none ;
        }
    }
</style>
<body style="background:white">

<?php  $this->load->view('admin/head_bangla'); $elc=1; ?>


<div style="float: right;margin-top:30px">
    <!-- <button class="btn btn-sm btn-primary" id="btn_print" onclick="window.print()">Print</button>    -->
    <form style="float: right;"  action="<?php echo base_url('admin/reports/show_report/'); ?>" method="post">
    <input type="hidden" name="first_date" value="<?php echo $first_date; ?>">
    <input type="hidden" name="second_date" value="<?php echo $second_date; ?>">
    <input type="hidden" name="status" value="<?php echo $status; ?>">
    <input type="hidden" name="sql" value="<?php echo $sql; ?>">
    <input type="hidden" name="elc" value="<?php echo $elc=1; ?>">
    <button class="btn btn-sm btn-info" style="margin-right:15px" type="submit" id="excel">Excel</button>
    </form>
</div>

<h4 class="text-center">Report of Increment</h4>
<table class="table table-striped table-bordered">
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Designation</th>
            <th class="text-center">Department</th>
            <th class="text-center">Joining Date</th>
            <th class="text-center">Probation Preiod</th>
            <th class="text-center">Last Increment Date</th>

            <th class="text-center">Increment</th>
            <th class="text-center">Position Change</th>
            <th class="text-center">Next Increment</th>
            <th class="text-center">Job Duration</th>
        </tr>
    </thead>
    <tbody style="font-size:12px;" >
        <?php $i=1; foreach ($emp_list as $key => $value) {
         
            ?>
        <tr>
            <td><?= $i++?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->department_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= $value->date_of_joining?></td>
            <td><?= '-'?></td>
            <td><?= $value->last_incre_date?></td>
            <?php  $inc_ammount = $this->db->select('old_salary,new_salary')->where('emp_id',$value->user_id)->get('xin_employee_incre_prob')->row();?>
            <td><?= !empty($inc_ammount) ? ($inc_ammount->new_salary - $inc_ammount->old_salary) : '-'?></td>
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
