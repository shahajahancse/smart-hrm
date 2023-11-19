<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php $this->load->view('admin/head_bangla'); ?>

<h4 class="text-center">Report of Employees Leave List</h4>
<table class="table table-striped table-bordered table-responsive">
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Designation</th>
            <th class="text-center">Department</th>
            <th class="text-center">Applied On</th>
            <th class="text-center">Reason</th>
            <th class="text-center">Status</th>
            <th class="text-center">Details</th>
        </tr>
    </thead>
    <tbody style="font-size:12px;" >
        <?php  foreach ($app_list as $key => $value) {?>
        <tr>
            <td><?= $key+1?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->department_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= $value->applied_on?></td>
            <td><?= $value->reason?></td>
            <td><?= $value->status == 1 ? 'Pending' :($value->status == 2 ? 'Approved' : ($value->status == 3 ? 'Reject': 'First Step Approved') )?></td>
            <td><a href="<?php echo base_url('admin/timesheet/leave_details/id/').$value->leave_id?>" >Details</a></td>
        </tr>
        <?php }?>
    </tbody>
</table>

</body>
