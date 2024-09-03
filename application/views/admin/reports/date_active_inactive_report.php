<?php

$active_emp_list=$this->db->select('
			xin_employees.user_id,
			xin_employees.first_name,
			xin_employees.last_name,
			xin_departments.department_name,
			xin_designations.designation_name,
			(SELECT lead_employees.first_name FROM xin_employees AS lead_employees WHERE lead_employees.user_id = xin_employees.lead_user_id) AS lead_first_name,
			(SELECT lead_employees.last_name FROM xin_employees AS lead_employees WHERE lead_employees.user_id = xin_employees.lead_user_id) AS lead_last_name,
			xin_employees.email,
			xin_employees.contact_no,
			xin_employees.address,
			xin_employees.password,
			xin_employees.note_file,
			xin_employees.remark,
            xin_employees.user_password,
			xin_employees.basic_salary,
			xin_employees.status,
			xin_employee_incre_prob.old_salary,
			xin_employee_incre_prob.new_salary,
			xin_employee_incre_prob.effective_date as last_incre_date,
			xin_employees.notify_incre_prob as next_incre_date,
			xin_employees.date_of_joining,
			DATEDIFF(NOW(), xin_employees.date_of_joining) AS duration,
		')
            ->from('xin_employees')
            ->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id', 'left')
            ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id', 'left')
            ->join('xin_employee_incre_prob', 'xin_employees.user_id = xin_employee_incre_prob.emp_id', 'left')
            ->where_in('xin_employees.status', array(1,4,5))
            ->get()->result();


            $left_employee=[];
                $this->db->select('emp_id');
                $this->db->from('xin_employee_left_resign');
                $this->db->where('effective_date >=', $first_date);
                $this->db->where('effective_date <=', $second_date);
                $this->db->group_by('emp_id');
                $left_employee_array = $this->db->get()->result_array();
                $left_employee=array_column($left_employee_array, 'emp_id');
            
$in_active_emp_list=$this->db->select('
			xin_employees.user_id,
			xin_employees.first_name,
			xin_employees.last_name,
			xin_departments.department_name,
			xin_designations.designation_name,
			(SELECT lead_employees.first_name FROM xin_employees AS lead_employees WHERE lead_employees.user_id = xin_employees.lead_user_id) AS lead_first_name,
			(SELECT lead_employees.last_name FROM xin_employees AS lead_employees WHERE lead_employees.user_id = xin_employees.lead_user_id) AS lead_last_name,
			xin_employees.email,
			xin_employees.contact_no,
			xin_employees.address,
			xin_employees.password,
			xin_employees.note_file,
			xin_employees.remark,
            xin_employees.user_password,
			xin_employees.basic_salary,
			xin_employees.status,
			xin_employee_incre_prob.old_salary,
			xin_employee_incre_prob.new_salary,
			xin_employee_incre_prob.effective_date as last_incre_date,
			xin_employees.notify_incre_prob as next_incre_date,
			xin_employees.date_of_joining,
			DATEDIFF(NOW(), xin_employees.date_of_joining) AS duration,
		')
            ->from('xin_employees')
            ->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id', 'left')
            ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id', 'left')
            ->join('xin_employee_incre_prob', 'xin_employees.user_id = xin_employee_incre_prob.emp_id', 'left')
            ->where_in('xin_employees.status', array(2,3))
            ->where_in('xin_employees.user_id', $left_employee)
            ->get()->result();


?>





<style>
    .hilight_style {
    text-align-last: center;
    font-size: 22px;
}
</style>




<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php  $this->load->view('admin/head_bangla'); ?>

<h4 class="text-center">Report of Active and Inactive List</h4>
<div class="container">
<table class="table  table-bordered table-responsive">
    <tbody style="font-size:12px;">
        <tr><td colspan="17" class="hilight_style"> Active Employee List</td></tr>
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
        <?php  foreach ($active_emp_list as $key => $value) {?>
        <tr>
            <td><?= $key+1?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->department_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= $value->lead_first_name.' '.$value->lead_last_name?></td>
            <td><?= $value->email?></td>
            <td><?= $value->contact_no?></td>
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
        <tr><td colspan="17" class="hilight_style"> Inactive Employee List</td></tr>
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
        <?php  foreach ($in_active_emp_list as $key => $value) {?>
        <tr>
            <td><?= $key+1?></td>
            <td><?= $value->first_name.' '.$value->last_name?></td>
            <td><?= $value->department_name?></td>
            <td><?= $value->designation_name?></td>
            <td><?= $value->lead_first_name.' '.$value->lead_last_name?></td>
            <td><?= $value->email?></td>
            <td><?= $value->contact_no?></td>
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
</div>
</body>