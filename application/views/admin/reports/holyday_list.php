<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php  $this->load->view('admin/head_bangla'); ?>

<h4 class="text-center">Report of Holyday List</h4>
<div class="container">
    <table class="table  table-bordered table-responsive">
        <thead>
            <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Name</th>
                <th class="text-center">Start Date </th>
                <th class="text-center">End Date</th>
                <th class="text-center">Total day</th>
                <th class="text-center">Details</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($holyday_list as $kay=>$data){ 
                ?>
            <tr>
                <td class="text-center"><?= $kay+1 ?></td>
                <td class="text-center"><?= $data->event_name ?></td>
                <td class="text-center"><?= date('d-M-Y' , strtotime($data->start_date))?></td>
                <td class="text-center"><?= date('d-M-Y' , strtotime($data->end_date))?></td>
                <td class="text-center"><?=  (int)date_diff(date_create($data->start_date), date_create($data->end_date))->format('%d') + 1?></td>
                <td class="text-center"><?= $data->description ?></td>
                <td class="text-center"><?= (date('Y-m-d', strtotime($data->end_date)) > date('Y-m-d'))? '<span class="pending"><i class="fa fa-dot-circle-o" style="color:red"></i> Pending</span>': '<span class="complet"><i class="fa fa-dot-circle-o" style="color:green"></i> Complete</span>' ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>