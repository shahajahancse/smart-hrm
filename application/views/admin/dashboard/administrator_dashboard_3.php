<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>

<div class="box-widget widget-user-2"> 
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header">
    <h4 class="widget-user-username welcome-hrsale-user"><?php echo $this->lang->line('xin_title_wcb');?>, <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>!</h4>
    <h5 class="widget-user-desc welcome-hrsale-user-text"><?php echo $this->lang->line('xin_title_today_is');?> <?php echo date('l, j F Y');?></h5>
  </div>
</div>
<?php /*?><?php $company_license = $this->Xin_model->company_license_expiry();?>
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
<?php endforeach;?><?php */?>
<?php if($theme[0]->statistics_cards=='4' || $theme[0]->statistics_cards=='8' || $theme[0]->statistics_cards=='12'){?>
<div class="row">
<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-purple">
        <div class="card-body">
            <i class="fa fa-users hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-uppercase text-white font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('xin_people');?>"><?php echo $this->lang->line('xin_people');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><a class="text-white" href="<?php echo site_url('admin/employees');?>"><?php echo $this->Employees_model->get_total_employees();?></a></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><span class="badge badge-info"> <?php echo $this->lang->line('xin_employees_active');?> <?php echo active_employees();?> </span><span class="ml-2"> <span class="badge bg-red"> <?php echo $this->lang->line('xin_employees_inactive');?> <?php echo inactive_employees();?> </span></span></p>
            </div>
        </div>
    </div>
</div><!-- end col -->

<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-info">
        <div class="card-body">
            <i class="fa fa-lock hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-white text-uppercase font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('xin_roles');?>"><?php echo $this->lang->line('xin_permission');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><?php echo $this->lang->line('xin_roles');?></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><a class="text-white" href="<?php echo site_url('admin/roles');?>"><?php echo $this->lang->line('left_set_roles');?></a></p>
            </div>
        </div>
    </div>
</div><!-- end col -->
<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-pink">
        <div class="card-body">
            <i class="fa fa-calendar hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-white text-uppercase font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('left_leave');?>"><?php echo $this->lang->line('xin_hrsale_manage');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><?php echo $this->lang->line('left_leave');?></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><a class="text-white" href="<?php echo site_url('admin/timesheet/leave');?>"><?php echo $this->lang->line('xin_hr_view_applications');?></a></p>
            </div>
        </div>
    </div>
</div><!-- end col -->

    <div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-success">
        <div class="card-body">
            <i class="fa fa-cog hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-uppercase text-white font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('xin_configure_hr');?>"><?php echo $this->lang->line('xin_configure_hr');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><?php echo $this->lang->line('left_settings');?></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><a class="text-white" href="<?php echo site_url('admin/settings');?>"><?php echo $this->lang->line('header_configuration');?></a></p>
            </div>
        </div>
    </div>
</div><!-- end col -->
</div>
<?php } ?>
<?php if($theme[0]->statistics_cards=='8' || $theme[0]->statistics_cards=='12'){?>
<div class="row">
<?php if($system[0]->module_files=='true'){?>
<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-warning">
        <div class="card-body">
            <i class="fa fa-files-o hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-white text-uppercase font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('xin_e_details_document');?>"><?php echo $this->lang->line('xin_hrsale_manage');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><?php echo $this->lang->line('xin_e_details_document');?></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><a class="text-white" href="<?php echo site_url('admin/files');?>"><?php echo $this->lang->line('xin_hr_upload_documents');?></a></p>
            </div>
        </div>
    </div>
</div><!-- end col -->
<?php } else {?>
<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-warning">
        <div class="card-body">
            <i class="fa fa-plane hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-white text-uppercase font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('xin_hr_office_holidays');?>"><?php echo $this->lang->line('xin_hr_office_holidays');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><?php echo $this->lang->line('left_holidays');?></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><a class="text-white" href="<?php echo site_url('admin/timesheet/holidays');?>"><?php echo $this->lang->line('xin_view');?></a></p>
            </div>
        </div>
    </div>
</div><!-- end col -->
<?php } ?>
<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-danger">
        <div class="card-body">
            <i class="fa fa-table hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-white text-uppercase font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('xin_theme_title');?>"><?php echo $this->lang->line('xin_theme_title');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><?php echo $this->lang->line('left_settings');?></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><a class="text-white" href="<?php echo site_url('admin/theme');?>"><?php echo $this->lang->line('header_configuration');?></a></p>
            </div>
        </div>
    </div>
</div><!-- end col -->
<?php if($system[0]->module_projects_tasks=='true'){?>
<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-primary">
        <div class="card-body">
            <i class="fa fa-table hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-white text-uppercase font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('dashboard_projects');?>"><?php echo $this->lang->line('dashboard_projects');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><a class="text-white" href="<?php echo site_url('admin/project');?>"><?php echo $this->lang->line('project');?> <?php echo $this->Xin_model->get_all_projects();?></a></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><span class="badge bg-red"> <?php echo $this->lang->line('xin_in_progress');?> <?php echo $this->Project_model->inprogress_projects();?> </span> <span class="ml-2"> <span class="badge badge-info"> <?php echo $this->lang->line('xin_completed');?> <?php echo $this->Project_model->complete_projects();?> </span></span></p>
            </div>
        </div>
    </div>
</div><!-- end col -->
<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-inverse">
        <div class="card-body">
            <i class="fa fa-table hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-white text-uppercase font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('xin_tasks');?>"><?php echo $this->lang->line('xin_tasks');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><a class="text-white" href="<?php echo site_url('admin/timesheet/tasks');?>"><?php echo $this->Xin_model->get_all_tasks();?></a></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><span class="badge bg-red"> <?php echo $this->lang->line('xin_in_progress');?> <?php echo inprogress_tasks();?> </span> <span class="ml-2"> <span class="badge badge-info"> <?php echo $this->lang->line('xin_completed');?> <?php echo completed_tasks();?> </span></span></p>
            </div>
        </div>
    </div>
</div><!-- end col -->
<?php } else {?>
<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-primary">
        <div class="card-body">
            <i class="fa fa-table hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-white text-uppercase font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('xin_configure_hr');?>"><?php echo $this->lang->line('xin_configure_hr');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><?php echo $this->lang->line('xin_modules');?></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><a class="text-white" href="<?php echo site_url('admin/settings/modules');?>"><?php echo $this->lang->line('xin_setup_modules');?></a></p>
            </div>
        </div>
    </div>
</div><!-- end col -->
<div class="col-xl-3 col-md-3">
    <div class="card hrsale-box-three hrsale-dash-inverse">
        <div class="card-body">
            <i class="fa fa-table hrsale-dash-icon"></i>
            <div class="hrsale-box-three-content">
                <p class="m-0 text-white text-uppercase font-600 font-secondary text-overflow" title="<?php echo $this->lang->line('xin_configure_hr');?>"><?php echo $this->lang->line('xin_configure_hr');?></p>
                <h3 class="text-white"><span data-plugin="counterup"><?php echo $this->lang->line('left_office_shifts');?></span> <small><i class="mdi mdi-arrow-up text-white"></i></small></h3>
                <p class="text-white m-0"><a class="text-white" href="<?php echo site_url('admin/timesheet/office_shift');?>"><?php echo $this->lang->line('xin_view');?></a></p>
            </div>
        </div>
    </div>
</div><!-- end col -->
<?php } ?>
</div>
<?php } ?>
<div class="row">
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
<div class="row">
  <?php $exp_am = $this->Expense_model->get_total_expenses();?>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon info-box-icon-hrsale"><i class="fa fa-money text-red"></i></span>
      <div class="info-box-content info-box-content-hrsale"> <span class="info-box-text"><?php echo $this->lang->line('dashboard_total_expenses');?> <span class="pull-right text-green dashboard-text"><?php echo $this->Xin_model->currency_sign($exp_am[0]->exp_amount);?></span></span> <span class="info-box-number"><a class="text-muted" href="<?php echo site_url('admin/expense');?>"> <?php echo $this->lang->line('xin_view');?> <i class="fa fa-arrow-right"></i></a></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
  <?php $all_sal = total_salaries_paid();?>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon info-box-icon-hrsale"><i class="fa fa-dollar text-red"></i></span>
      <div class="info-box-content info-box-content-hrsale"> <span class="info-box-text"><?php echo $this->lang->line('dashboard_total_salaries');?> <span class="pull-right text-green dashboard-text"><?php echo $this->Xin_model->currency_sign($all_sal);?></span></span> <span class="info-box-number"><a class="text-muted" href="<?php echo site_url('admin/payroll/payment_history');?>"> <?php echo $this->lang->line('xin_view');?> <i class="fa fa-arrow-right"></i></a></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
</div>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
<?php $this->load->view('admin/calendar/calendar_hr');?>
<?php endif; ?>
