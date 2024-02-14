<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php $this->load->view('admin/head_bangla'); ?>


<h4 class="text-center">Report of Employees salary review Pending</h4>
<table class="table table-striped table-bordered table-responsive">
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Department</th>
            <th class="text-center">Designation</th>
            <th class="text-center">Basic salary</th>
        </tr>
    </thead>
    <tbody style="font-size:12px;" >
        <?php
        $this->db->select('*');
        $this->db->from('xin_employees');
        $this->db->where('salary_review_is',1);
        $this->db->where_in('user_id',$emp_id);
        $this->db->where('salary_review_date between "'.date('Y-m-d', strtotime($first_date)).'" and "'.date('Y-m-d', strtotime($second_date)).'"');
        $review_list= $this->db->get()->result(); 
        foreach ($review_list as $key => $value) {?>
        <tr>
            <td><?= $key+1?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->department_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= $value->salary?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
<h4 class="text-center">Report of Employees salary review Complete</h4>
<table class="table table-striped table-bordered table-responsive">
    <thead style="font-size:12px;" >
        <tr>
            <th class="text-center">S.N</th>
            <th class="text-center">Name</th>
            <th class="text-center">Department</th>
            <th class="text-center">Designation</th>
            <th class="text-center">New salary</th>
        </tr>
    </thead>
    <tbody style="font-size:12px;" >
        <?php 
           $this->db->select('xin_employees.*,salary_review.*,xin_designations.designation_name,xin_departments.department_name');
           $this->db->from('xin_employees');
           $this->db->join('salary_review','xin_employees.user_id = salary_review.user_id');
           $this->db->join('xin_designations','xin_employees.designation_id = xin_designations.designation_id');
           $this->db->join('xin_departments','xin_employees.department_id = xin_departments.department_id');
           $this->db->where_in('xin_employees.user_id',$emp_id);
           $this->db->where('salary_review.update_at between "'.date('Y-m-d', strtotime($first_date)).'" and "'.date('Y-m-d', strtotime($second_date)).'"');
           $review_list= $this->db->get()->result(); 
        foreach ($review_list as $key => $value) {?>
        <tr>
            <td><?= $key+1?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->department_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= $value->salary?></td>
        </tr>
        <?php }?>
    </tbody>
</table>

</body>
