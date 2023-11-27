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

<h4 class="text-center">Report of Using Device</h4>
<table class="table table-striped table-bordered table-responsive">
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Designation</th>
            <th class="text-center">Using Device</th>
        </tr>
    </thead>

    <tbody style="font-size:12px;" >
        <?php  foreach ($emp_list as $key => $value) {?>
            <?php 
                $this->db->select('pam.model_name,pac.cat_name,pac.cat_short_name,pa.device_name_id');
                $this->db->from('product_accessories as pa');
                $this->db->join('product_accessory_categories as pac','pa.cat_id = pac.id','left');	
                $this->db->join('product_accessories_model as pam','pa.device_model = pam.id','left');
                $this->db->where_in('pa.user_id',$value->user_id);
                $query = $this->db->get()->result();
                // dd($query);
            ?>
        <tr>
            <td><?= $key+1?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->designation_name?></td>
            <td>
                <?php $i=1; foreach ($query as $key => $value) {?>
                    <?= $i++.'. '.$value->model_name.' '.$value->cat_name.' '.$value->cat_short_name.'-'.$value->device_name_id.'<br>'?>
               <?php }?>
            </td>
        </tr>
        <?php }?>
    </tbody>
</table>

</body>
