<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php  $this->load->view('admin/head_bangla'); ?>

<h4 class="text-center">Employees Issues Report</h4>
<h6 class="text-center">Report on : <?php echo $status == 1 ? date('d M Y',strtotime($first_date)) :($status==2 ? date('d M Y',strtotime($first_date)) .' to '.date('d M Y',strtotime($second_date)) : date('d M Y',strtotime($first_date)).' to '.date('d M Y',strtotime($second_date)))?></h6>
<table class="table table-striped table-bordered">
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Issue</th>
        </tr>
    </thead>
    <tbody style="font-size:12px;" >
        <?php $i=1; foreach ($values as $key => $value) {?>
        <tr>
            <td class="text-center"><?= $i++?></td>
            <td class="text-center"><?= $value->first_name.' '.$value->last_name?></td>
            <td class="text-center"><?= $value->comment?></td>
        </tr>
        <?php }?>
    </tbody>
</table>

</body>
