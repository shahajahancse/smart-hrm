<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php  $this->load->view('admin/head_bangla'); ?>

<h4 class="text-center">Report of Client List</h4>
<table class="table table-striped table-bordered">
    <thead style="font-size:12px;" >
        <tr>
        <!-- Government
 Private
 Service Charge
 Website -->
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Type</th>
            <th class="text-center">Service Charge</th>
            <th class="text-center">Website</th>
           
        </tr>
    </thead>
    <tbody style="font-size:12px;" >
        <?php $i=1; foreach ($client_list as $key => $value) {?>
        <tr>
            <td><?= $i++?></td>
            <td><?= $value->name?></td>
            <td><?= ($value->type==1)?'Government':'Private' ?></td>

            <?php
            $get_service=$this->db->where('client_id',$value->client_id)->get('xin_project_service')->result();
           $amount=0;
            if($get_service){
                foreach ($get_service as $v) {
                    $amount+=$v->amount; 
                }
            }
            ?>
            <td><?= $amount ?></td>

            <td><?= $value->website_url?></td>
        </tr>
        <?php }?>
    </tbody>
</table>

</body>
