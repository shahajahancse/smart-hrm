<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php  $this->load->view('admin/head_bangla'); ?>

<h4 class="text-center">Employees Meeting Report</h4>
<h6 class="text-center">Report on : <?php echo $status == 1 ? $first_date :($status==2 ? $first_date.' to '.$second_date : $first_date.' to '.$second_date )?></h6>
<table class="table table-striped table-bordered">
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Designation</th>
            <th class="text-center">Date</th>
            <th class="text-center">Meeting Place</th>
            <th class="text-center">Purpose</th>
            <th class="text-center">Meeting Time Duration(Out time & In Time)</th>
        </tr>
    </thead>
    <tbody style="font-size:12px;" >
        <?php $i=1; foreach ($values as $key => $value) {?>
        <tr>
            <td><?= $i++?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= date(' d M Y',strtotime($value->date))?></td>
            <td><?= $value->address?></td>
            <td><?= $value->title?></td>
            <?php $time1 = new DateTime($value->out_time);
                  $time2 = new DateTime($value->in_time);
                  $interval = $time1->diff($time2);
                  $hours = $interval->h;
                  $minutes = $interval->i;
                  $seconds = $interval->s;
            ?>
            <td><?= "In Time = ".date('h:i:s A',strtotime($value->in_time)).' and Out Time '.date('h:i:s A',strtotime($value->out_time)) . ' Duration ='.$hours.' Hr '.$minutes.' Min '.$seconds .' Sec'?></td>
        </tr>
        <?php }?>
    </tbody>
</table>

</body>
