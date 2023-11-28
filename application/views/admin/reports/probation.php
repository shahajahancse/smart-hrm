<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php  $this->load->view('admin/head_bangla'); ?>
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
<h4 class="text-center">Report of Employee Probation Period List From <?php echo $first_date; ?> To <?php echo $second_date; ?></h4>
<table class="table table-striped table-bordered">
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Designation</th>
            <th class="text-center">Department</th>
            <th class="text-center">Joining Date</th>
            <th class="text-center">Probation Start</th>
            <th class="text-center">Probation End </th>
            <th class="text-center">Probation Period</th>
            <?php if($session['role_id']==1){?>
            <th class="text-center">Gross Salary</th>
            <?php }?>
            <th class="text-center">Increment Amount</th>
            <th class="text-center">Duration</th>
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
            <td>
                <?php 
                $probationStart = $value->date_of_joining;
                $this->db->where('emp_id', $value->user_id);
                $this->db->where('status', 4);
                $this->db->order_by('id', 'desc');
                $this->db->limit(1);
                $query = $this->db->get('xin_employee_incre_prob');
                if ($query->num_rows() > 0) {
                    $probationStart = $query->row()->effective_date;
                }
                ?>  
                <?= $probationStart?>
            </td>
            <td><?= $value->next_incre_date?></td>
            <td>
                <?php
                $joiningDate = new DateTime($probationStart);
                $nextIncreDate = new DateTime($value->next_incre_date);
                
                $diff = $joiningDate->diff($nextIncreDate);
                
                $years = $diff->y;
                $months = $diff->m;
                $days = $diff->d;?>
               <?=($years)?$years.' Years ':''?><?=($months)?$months.' Months ':''?><?=($days)?$days.' Days ':''?>      
            </td>
            <?php if($session['role_id']==1){?>
            <td><?= $value->basic_salary?></td>
            <?php }?>
            <td><?= $value->new_salary - $value->old_salary?></td>
            <?php 
                $date1 = new DateTime($value->date_of_joining);
                $date2 = new DateTime();
                $interval = date_diff($date1, $date2);
            ?>
            <td><?= ($interval->y == 0 ? '':$interval->y.' years ').$interval->m.' months '.$interval->d.' days'?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
</body>