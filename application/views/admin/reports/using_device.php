<link rel="stylesheet"
    href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<body style="background:white">
    <?php  $this->load->view('admin/head_bangla'); ?>
    <div style="float: right;margin-top:30px">
        <!-- <button class="btn btn-sm btn-primary" id="btn_print" onclick="window.print()">Print</button>    -->
        <form style="float: right;" action="<?php echo base_url('admin/reports/show_report/'); ?>" method="post">
            <input type="hidden" name="first_date" value="<?php echo $first_date; ?>">
            <input type="hidden" name="second_date" value="<?php echo $second_date; ?>">
            <input type="hidden" name="status" value="<?php echo $status; ?>">
            <input type="hidden" name="sql" value="<?php echo $sql; ?>">
            <input type="hidden" name="elc" value="<?php echo $elc=1; ?>">
            <button class="btn btn-sm btn-info" style="margin-right:15px" type="submit" id="excel">Excel</button>
        </form>
    </div>

    <h4 class="text-center">Report of Using Device</h4>
    <div class="container">


    <?php  foreach ($emp_list as $key => $value) {?>
    <table class="table table-striped table-bordered table-responsive">
        <thead style="font-size:12px;">
            <tr>
                <th colspan="4" style="background: #8fcef3;color: black;font-weight: bolder;"><?= $value->first_name.' '.$value->last_name?></th>
            </tr>
            <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Device Name</th>
                <th class="text-center">Category</th>
                <th class="text-center">Sort name </th>
            </tr>
        </thead>

        <tbody style="font-size:12px;">
            <?php 
                 $this->db->select('
                 employee_using_device.*, 
                 xin_employees.first_name,
                 xin_employees.last_name,
                 product_accessories.id as product_id,
                 product_accessories.device_name_id,
                 product_accessories_model.model_name,
                 product_accessory_categories.cat_name,
                 product_accessory_categories.cat_short_name
                 
                 ');
         
                 $this->db->from('employee_using_device');
                 $this->db->join('xin_employees', 'xin_employees.user_id = employee_using_device.user_id', 'left');
                 $this->db->join('product_accessories', 'product_accessories.id = employee_using_device.device_id', 'left');
                 $this->db->join('product_accessories_model', 'product_accessories_model.id = product_accessories.device_model', 'left');
                 $this->db->join('product_accessory_categories', 'product_accessory_categories.id = product_accessories.cat_id', 'left');
                 $this->db->where('employee_using_device.user_id', $value->user_id);
                 $query = $this->db->get()->result();
            ?>





            <?php

            if (count($query) == 0) {
                echo '<tr><td colspan="4" class="text-center">No Data Found</td></tr>';
            }else{
            foreach ($query as $k => $v) {?>
                <tr>
                    <td><?= $k+1?></td>
                    <td> MHl-<?= $v->cat_short_name ?>-<?= $v->device_name_id ?></td>
                    <td> <?= $v->cat_name ?></td>
                    <td> <?= $v->cat_short_name ?></td>
                </tr>
            <?php }  }?>
          
        </tbody>
    </table>
    <?php }?>
    </div>
</body>