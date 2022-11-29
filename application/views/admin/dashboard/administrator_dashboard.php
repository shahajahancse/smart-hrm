<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box-widget widget-user-2"> 
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header">
    <h4 class="widget-user-username welcome-hrsale-user">Welcome back, <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>!</h4>
    <h5 class="widget-user-desc welcome-hrsale-user-text">Today is <?php echo date('l, j F Y');?></h5>
  </div>
</div>
<?php $company_license = $this->Xin_model->company_license_expiry();?>
<?php foreach($company_license as $clicense):?>
<div class="alert alert-warning alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
  License <?php echo $clicense->license_name;?> is going to expire soon. </div>
<?php endforeach;?>
<?php $company_license_exp = $this->Xin_model->company_license_expired();?>
<?php foreach($company_license_exp as $clicense_exp):?>
<div class="alert alert-warning alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
  License <?php echo $clicense_exp->license_name;?> is expired. </div>
<?php endforeach;?>
<?php if($theme[0]->statistics_cards=='4' || $theme[0]->statistics_cards=='8' || $theme[0]->statistics_cards=='12'){?>
<?php } ?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/employees');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-primary"><i class="fa fa-users"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Employees_model->get_total_employees();?> <?php echo $this->lang->line('xin_people');?></span> <span class="info-box-text"><span class="badge badge-info"> <?php echo $this->lang->line('xin_employees_active');?> <?php echo active_employees();?> </span><span class="ml-2"> <span class="badge bg-red"> <?php echo $this->lang->line('xin_employees_inactive');?> <?php echo inactive_employees();?> </span></span> </span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  <!-- /.col -->
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/roles');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-green"><i class="fa fa-lock"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_roles');?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_permission');?></span>
       </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  <!-- /.col -->
  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/timesheet/leave');?>"> 
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-purple"><i class="fa fa-calendar"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('left_leave');?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_performance_management');?></span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  <!-- /.col -->
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/settings');?>"> 
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-cog"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_configure_hr');?></span> <span class="info-box-text"><?php echo $this->lang->line('left_settings');?></span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  <!-- /.col --> 
</div>
<?php if($theme[0]->statistics_cards=='8' || $theme[0]->statistics_cards=='12'){?>
<div class="row <?php echo $get_animate;?>">
  <?php if($system[0]->module_files=='true'){?>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/files');?>"> 
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_e_details_document');?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_performance_management');?></span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  <?php } else {?>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/timesheet/holidays');?>"> 
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-yellow"><i class="fa fa-plane"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_view');?></span> <span class="info-box-text"><?php echo $this->lang->line('left_holidays');?></span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  
  <?php } ?>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/theme');?>"> 
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-table"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_theme_title');?></span> <span class="info-box-text"><?php echo $this->lang->line('left_settings');?></span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  <?php if($system[0]->module_projects_tasks=='true'){?>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/project');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Xin_model->get_all_projects();?> <?php echo $this->lang->line('xin_projects');?></span> <span class="info-box-text"><span class="badge bg-red"> <?php echo $this->lang->line('xin_in_progress');?> <?php echo $this->Project_model->inprogress_projects();?> </span></span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  
    <div class="col-xl-3 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/timesheet/tasks');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-aqua"><i class="fa fa-calendar-check-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Xin_model->get_all_tasks();?> <?php echo $this->lang->line('xin_tasks');?></span> <span class="info-box-text"><span class="badge bg-red"> <?php echo $this->lang->line('xin_in_progress');?> <?php echo inprogress_tasks();?> </span> </span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
    
  <?php } else {?>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/designation');?>"> 
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-green"><i class="fa fa-list"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('left_designation');?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_view');?></span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  
    <div class="col-xl-3 col-md-3 col-12 hr-mini-state">
    <a class="text-muted" href="<?php echo site_url('admin/timesheet/office_shift');?>"> 
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-yellow"><i class="fa fa-calendar-plus-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('left_office_shifts');?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_view');?></span> </div>
      <!-- /.info-box-content --> 
    </div></a>
    <!-- /.info-box --> 
  </div>
  <?php } ?>
</div>
<?php } ?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('xin_employee_department_txt');?></h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <div class="col-md-7">
            <div class="overflow-scrolls" style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    <?php $c_color = array('#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC','#00A5A8','#FF4558','#16D39A','#8A2BE2','#D2691E','#6495ED','#DC143C','#006400','#556B2F','#9932CC');?>
                    <?php $j=0;foreach($this->Department_model->all_departments() as $department) { ?>
                    <?php
						$condition = "department_id =" . "'" . $department->department_id . "'";
						$this->db->select('*');
						$this->db->from('xin_employees');
						$this->db->where($condition);
						$query = $this->db->get();
						// check if department available
						if ($query->num_rows() > 0) {
					?>
                    <tr>
                      <td><div style="width:4px;border:5px solid <?php echo $c_color[$j];?>;"></div></td>
                      <td><?php echo htmlspecialchars_decode($department->department_name);?> (<?php echo $query->num_rows();?>)</td>
                    </tr>
                    <?php $j++; } ?>
                    <?php  } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <canvas id="employee_department" height="200" width="" style="display: block;  height: 200px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('xin_employee_designation_txt');?></h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <div class="col-md-7">
            <div class="overflow-scrolls" style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    <?php $c_color2 = array('#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED','#9932CC','#556B2F','#16D39A','#DC143C','#D2691E','#8A2BE2','#FF976A','#FF4558','#00A5A8','#6495ED');?>
                    <?php $k=0;foreach($this->Designation_model->all_designations() as $designation) { ?>
                    <?php
						$condition1 = "designation_id =" . "'" . $designation->designation_id . "'";
						$this->db->select('*');
						$this->db->from('xin_employees');
						$this->db->where($condition1);
						$query1 = $this->db->get();
						// check if department available
						if ($query1->num_rows() > 0) {
					?>
                    <tr>
                      <td><div style="width:4px;border:5px solid <?php echo $c_color2[$k];?>;"></div></td>
                      <td><?php echo htmlspecialchars_decode($designation->designation_name);?> (<?php echo $query1->num_rows();?>)</td>
                    </tr>
                    <?php $k++; } ?>
                    <?php  } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <canvas id="employee_designation" height="200" width="" style="display: block; height: 200px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if($system[0]->module_inquiry=='true'){?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-4 col-12">
    <div class="box box-body hr-mini-state hrsalle-mini-stat">
      <a class="text-card-muted" href="<?php echo site_url('admin/tickets');?>"><div class="flexbox"> <span class="fa fa-ticket text-primary font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo total_tickets();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_hr_total_tickets');?></div></a>
    </div>
  </div>
  <div class="col-md-4 col-12">
    <div class="box box-body hr-mini-state hrsalle-mini-stat">
      <a class="text-card-muted" href="<?php echo site_url('admin/tickets');?>"><div class="flexbox"> <span class="fa fa-server text-danger font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo total_open_tickets();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_hr_total_open_tickets');?></div></a>
    </div>
  </div>
  <div class="col-md-4 col-12">
    <div class="box box-body hr-mini-state hrsalle-mini-stat">
      <a class="text-card-muted" href="<?php echo site_url('admin/tickets');?>"><div class="flexbox"> <span class="ion ion-thumbsup text-success font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo total_closed_tickets();?></span> </div>
      <div class="text-right"><?php echo $this->lang->line('xin_hr_total_closed_tickets');?></div></a>
    </div>
  </div>
</div>
<?php } ?>
<?php
$current_month = date('Y-m-d');
$working = $this->Xin_model->current_month_day_attendance($current_month);
$query = $this->Xin_model->all_employees_status();
$total = $query->num_rows();
// absent
$abs = $total - $working;
?>
<?php $this->load->view('admin/calendar/calendar_hr');?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-3">
    <div class="row">
      <?php $exp_am = $this->Expense_model->get_total_expenses();?>
      <div class="col-md-12 col-12 hr-mini-state">
        <div class="box box-body hrsalle-mini-stat">
          <a class="text-card-muted" href="<?php echo site_url('admin/expense');?>"><div class="flexbox"> <span class="fa fa-money text-red font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo $this->Xin_model->currency_sign($exp_am[0]->exp_amount);?></span> </div>
          <div class="text-right"><?php echo $this->lang->line('dashboard_total_expenses');?></div></a>
        </div>
      </div>
      <?php $all_sal = total_salaries_paid();?>
      <div class="col-md-12 col-12 hr-mini-state">
        <div class="box box-body hrsalle-mini-stat">
          <a class="text-card-muted" href="<?php echo site_url('admin/payroll/payment_history');?>"><div class="flexbox"> <span class="fa fa-dollar text-primary font-size-50"></span> <span class="font-size-40 font-weight-400"><?php echo $this->Xin_model->currency_sign($all_sal);?></span> </div>
          <div class="text-right"><?php echo $this->lang->line('dashboard_total_salaries');?></div></a>
        </div>
      </div>
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="mt-0 header-title"><?php echo $this->lang->line('dashboard_new');?> <?php echo $this->lang->line('dashboard_employees');?></h4>
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="">
            <ul class="products-list product-list-in-box">
              <?php foreach($last_four_employees as $employee) {?>
              <?php 
                    if($employee->profile_picture!='' && $employee->profile_picture!='no file') {
                        $de_file = base_url().'uploads/profile/'.$employee->profile_picture;
                    } else { 
                        if($employee->gender=='Male') {  
                        $de_file = base_url().'uploads/profile/default_male.jpg'; 
                        } else {  
                        $de_file = base_url().'uploads/profile/default_female.jpg';
                        }
                    }
                    $fname = $employee->first_name.' '.$employee->last_name;
					// get designation
					$designation = $this->Designation_model->read_designation_information($employee->designation_id);
					if(!is_null($designation)){
						$designation_name = $designation[0]->designation_name;
					} else {
						$designation_name = '--';	
					}
					$department_designation = $designation_name;
                    ?>
              <li class="item">
                <div class="product-img"> <img src="<?php echo $de_file;?>" alt="<?php echo $fname;?>" class="rounded-circle-img"> </div>
                <div class="product-info"> <a href="<?php echo site_url();?>admin/employees/detail/<?php echo $employee->user_id;?>" class="product-title"><?php echo $fname;?></a> <span class="product-description"> <?php echo $department_designation;?> </span> </div>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-3 col-md-3 col-sm-3">
    <div class="row">
      <div class="col-xs-11 col-md-12 col-sm-12">
        <div class="box">
          <div class="box-body">
            <h4 class="mt-0 header-title"><?php echo $this->lang->line('xin_hr_attendance_status_today');?></h4>
            <div class="row text-center m-t-20">
              <div class="col-xs-6 col-md-6  col-sm-6">
                <h5 class=""><?php echo $abs;?></h5>
                <p class="text-muted"><?php echo $this->lang->line('xin_absent');?></p>
              </div>
              <div class="col-xs-6 col-md-6 col-sm-6">
                <h5 class=""><?php echo $working;?></h5>
                <p class="text-muted"><?php echo $this->lang->line('xin_emp_working');?></p>
              </div>
            </div>
            <?php
			$emp_abs = $abs / $total * 100;
			$emp_work = $working / $total * 100;
			?>
            <div class="row text-center m-t-20">
              <div class="col-xs-3 col-md-6 col-sm-6">
                <input type="text" class="knob" value="<?php echo $emp_abs;?>" data-width="90" data-height="90" data-fgColor="#f56954" readonly="readonly">
                <div class="knob-label"><?php echo $this->lang->line('xin_absent');?></div>
              </div>
              <div class="col-xs-3 col-md-6 col-sm-6">
                <input type="text" class="knob" value="<?php echo $emp_work;?>" data-width="90" data-height="90" data-fgColor="#3c8dbc" readonly="readonly">
                <div class="knob-label"><?php echo $this->lang->line('xin_emp_working');?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-12 col-sm-12">
        <div class="box">
          <div class="box-body">
            <h4 class="mt-0 header-title"><?php echo $this->lang->line('dashboard_total_employees');?></h4>
            <h3 class="display-4 blue-grey darken-1 text-center"><?php echo $total;?></h3>
            <div class="row text-center m-t-20">
              <div class="col-xs-6 col-md-6 col-sm-6">
                <h5 class=""><?php echo $this->Xin_model->male_employees();?>%</h5>
                <p class="text-success"><i class="fa fa-male"></i> <?php echo $this->lang->line('xin_gender_male');?></p>
              </div>
              <div class="col-xs-6 col-md-6 col-sm-6">
                <h5 class=""><?php echo $this->Xin_model->female_employees();?>%</h5>
                <p class="text-info"><i class="fa fa-female"></i> <?php echo $this->lang->line('xin_gender_female');?></p>
              </div>
            </div>
            <div class="row text-center  m-t-20">
              <div class="col-xs-6 col-md-6 col-sm-6">
                <h5 class=""><?php echo $this->lang->line('xin_employees_active');?></h5>
                <p class="text-success"><?php echo active_employees();?></p>
              </div>
              <div class="col-xs-6 col-md-6 col-sm-6">
                <h5 class=""><?php echo $this->lang->line('xin_employees_inactive');?></h5>
                <p class="text-danger"><?php echo inactive_employees();?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-6 col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h4 class="mt-0 header-title"><?php echo $this->lang->line('left_payment_history');?></h4>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin table-striped">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_employee_name');?></th>
                <th><?php echo $this->lang->line('xin_paid_amount');?></th>
                <th><?php echo $this->lang->line('xin_payment_month');?></th>
                <th><?php echo $this->lang->line('xin_view');?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($get_last_payment_history as $last_payments):?>
              <?php $user = $this->Xin_model->read_user_info($last_payments->employee_id);?>
              <?php if(!is_null($user)){?>
              <?php $full_name = $user[0]->first_name.' '.$user[0]->last_name;?>
              <?php
            $month_payment = date("F, Y", strtotime($last_payments->salary_month));
            
			if($last_payments->wages_type == 1){
				$bs = $last_payments->basic_salary;
			} else {
				$bs = $last_payments->daily_wages;
			}
			$total_earning = $bs + $last_payments->total_allowances + $last_payments->total_overtime + $last_payments->total_other_payments + $last_payments->total_commissions;
			$total_deduction = $last_payments->total_loan + $last_payments->total_statutory_deductions;
			$total_net_salary = $total_earning - $total_deduction;
			$p_amount = $this->Xin_model->currency_sign($total_net_salary);
            ?>
              <tr>
                <td><a target="_blank" href="<?php echo site_url().'admin/employees/detail/'.$last_payments->employee_id;?>/"><?php echo $full_name;?></a></td>
                <td><?php echo $p_amount;?></td>
                <td><?php echo $month_payment;?></td>
                <td><a target="_blank" href="<?php echo site_url().'admin/payroll/payslip/id/'.$last_payments->payslip_id;?>/"><?php echo $this->lang->line('xin_payslip');?></a></td>
              </tr>
              <?php } ?>
              <?php endforeach;?>
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive --> 
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix"> <a href="<?php echo site_url('admin/payroll/payment_history');?>" target="_blank" class="btn btn-sm btn-default btn-flat pull-right"><?php echo $this->lang->line('xin_all_payslips');?></a> </div>
      <!-- /.box-footer --> 
    </div>
  </div>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon info-box-icon-hrsale"><i class="fa fa-university text-green"></i></span>
      <div class="info-box-content info-box-content-hrsale"> <span class="info-box-text"><?php echo $this->lang->line('xin_acc_account_balances');?> <span class="pull-right text-green dashboard-text"><?php echo $this->Xin_model->currency_sign(total_account_balances());?></span></span> <span class="info-box-number"><a class="text-muted" href="<?php echo site_url('admin/accounting/bank_cash');?>"> <?php echo $this->lang->line('xin_view');?> <i class="fa fa-arrow-right"></i></a></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
</div>
