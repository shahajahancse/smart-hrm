<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php  $this->load->view('admin/head_bangla'); ?>
<div style="float: right;margin-top:30px">
    <form style="float: right;"  action="<?php echo base_url('admin/reports/show_report/'); ?>" method="post">
    <input type="hidden" name="first_date" value="<?php echo $first_date; ?>">
    <input type="hidden" name="second_date" value="<?php echo $second_date; ?>">
    <input type="hidden" name="status" value="<?php echo $status; ?>">
    <input type="hidden" name="sql" value="<?php echo $sql; ?>">
    <input type="hidden" name="elc" value="<?php echo $elc=1; ?>">
    <button class="btn btn-sm btn-info" style="margin-right:15px" type="submit" id="excel">Excel</button>
    </form>
</div>
<h4 class="text-center">Report of Employee List</h4>
<table class="table  table-bordered table-responsive">
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Designation</th>
            <th class="text-center">Department</th>
            <th class="text-center">Team Leader</th>
            <th class="text-center">Email</th>
            <th class="text-center">Phone</th>
            <th class="text-center">Gross Salary</th>
            <th class="text-center">Joining Date</th>
            <th class="text-center">Job Duration</th>
            <th class="text-center">Last Increment Date</th>
            <th class="text-center">Next Increment Date</th>
            <th class="text-center">PC Password</th>
            <th class="text-center">Note File</th>
            <th class="text-center">Status</th>
            <th class="text-center">Remark</th>
        </tr>
    </thead>
    <tbody style="font-size:12px;">
        <?php  foreach ($emp_list as $key => $value) {?>
        <tr>
            <td><?= $key+1?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->department_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= $value->lead_first_name.' '.$value->lead_last_name?></td>
            <td><?= $value->email?></td>
            <td><?= $value->contact_no?></td>
            <?php 
                // $this->db->select('pam.model_name,pac.cat_name,pac.cat_short_name,pa.device_name_id');
                // $this->db->from('product_accessories as pa');
                // $this->db->join('product_accessory_categories as pac','pa.cat_id = pac.id','left');	
                // $this->db->join('product_accessories_model as pam','pa.device_model = pam.id','left');
                // $this->db->where_in('pa.user_id',$value->user_id);
                // $query = $this->db->get()->result();
            ?>
            <td><?= $value->basic_salary?></td>
            <td><?= $value->date_of_joining?></td>
            <?php 
                $date1 = new DateTime($value->date_of_joining);
                $date2 = new DateTime();
                $interval = date_diff($date1, $date2);
            ?>
            <td><?= ($interval->y == 0 ? '':$interval->y.' years ').$interval->m.' months '.$interval->d.' days'?></td>
            <td><?= date('Y-m-d',strtotime('-1 year'.$value->next_incre_date))?></td>
            <td><?= $value->next_incre_date?></td>
            <td><?= $value->user_password?></td>
            <td><?php if($value->note_file ==null){
                echo 'No File';
            }else{?>
                <a href="<?=  base_url('uploads/profile/').$value->note_file?>" target="_blank">View</a>
                <a href="<?=  base_url('uploads/profile/').$value->note_file?>" download="<?=  base_url('uploads/profile/').$value->note_file?>">Download</a>
            <?php }?>
            </td>
            <?php if ($value->status == 1) {
                $status = 'Regular';
            } else if ($value->status == 2) {
                $status = 'Left';
            } else if ($value->status == 3) {
                $status = 'Resign';
            } else if ($value->status == 4) {
                $status = 'Intern';
            } else {
                $status = 'Probation';
            }
            
            ?>
            <td><?= $status ?></td>
            <td><?= $value->remark?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
</body>