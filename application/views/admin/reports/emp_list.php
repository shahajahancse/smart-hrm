<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php  $this->load->view('admin/head_bangla'); ?>

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
            <th class="text-center">Address</th>

            <?php if($session['role_id'] ==1){?>
            <th class="text-center">Gross Salary</th>
            <?php }?>
            <th class="text-center">Joining Date</th>
            <th class="text-center">Job Duration</th>
            <th class="text-center">Last Increment Date</th>
            <th class="text-center">Next Increment Date</th>
            <th class="text-center">PC Password</th>
            <th class="text-center">Using Device</th>
        </tr>
    </thead>
    <tbody style="font-size:12px;" >
        <?php  foreach ($emp_list as $key => $value) {?>
        <tr>
            <td><?= $key+1?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->department_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= $value->lead_first_name.' '.$value->lead_last_name?></td>
            <td><?= $value->email?></td>
            <td><?= $value->contact_no?></td>
            <td><?= $value->address?></td>
            <?php 
                $this->db->select('pam.model_name,pac.cat_name,pac.cat_short_name,pa.device_name_id');
                $this->db->from('product_accessories as pa');
                $this->db->join('product_accessory_categories as pac','pa.cat_id = pac.id','left');	
                $this->db->join('product_accessories_model as pam','pa.device_model = pam.id','left');
                $this->db->where_in('pa.user_id',$value->user_id);
                $query = $this->db->get()->result();
                // dd($query);
            ?>

            <?php if($session['role_id'] ==1){?>
            <td><?= $value->basic_salary?></td>
            <?php }?>
            <td><?= $value->date_of_joining?></td>
            <?php 
              

                $date1 = new DateTime($value->date_of_joining); // replace with your start date
                $date2 = new DateTime(); // replace with your end date, or use new DateTime('2023-11-26') for the current date

                $interval = date_diff($date1, $date2);
            ?>
            <td><?= ($interval->y == 0 ? '':$interval->y.' years ').$interval->m.' months '.$interval->d.' days'?></td>
            <td><?= date('Y-m-d',strtotime('-1 year'.$value->next_incre_date))?></td>
            <td><?= $value->next_incre_date?></td>
            <td><?= $value->user_password?></td>
            <td>
                <table>
                    <?php $i=1; foreach ($query as $key => $value) {?>
                        <tr>                
                            <td style="white-space:nowrap;font-size:12px;"><?= $i++.'. '.$value->model_name.' '.$value->cat_name.' '.$value->cat_short_name.'-'.$value->device_name_id.'<br>'?></td>
                        </tr>
                    <?php }?>
                </table>

            </td>
        </tr>
        <?php }?>
    </tbody>
</table>

</body>
