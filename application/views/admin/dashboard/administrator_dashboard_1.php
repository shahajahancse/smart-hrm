<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
?>
<?php $get_animate = $this->Xin_model->get_content_animate(); ?>

<div class="box-widget widget-user-2">
  <!-- Add the bg color to the header using any of the bg-* classes  -->
  <div class="widget-user-header">
    <h4 class="widget-user-username welcome-hrsale-user">
      <?php echo $this->lang->line('xin_title_wcb'); ?>,
      <?php echo $user[0]->first_name . ' ' . $user[0]->last_name; ?>!
    </h4>
    <h5 class="widget-user-desc welcome-hrsale-user-text">
      <?php echo $this->lang->line('xin_title_today_is'); ?>
      <?php echo date('l, j F Y'); ?>
    </h5>
  </div>
</div>

<?php /*?><?php if($this->session->flashdata('expire_official_document')):?>
 <?php $company_license = $this->Xin_model->company_license_expiry();?>
 <?php foreach($company_license as $clicense):?>
 <div class="alert alert-warning alert-dismissible">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
 <h4><i class="icon fa fa-warning"></i> <?php echo $this->lang->line('xin_title_alert');?></h4>
 <?php echo $this->lang->line('xin_title_license');?> <?php echo $clicense->license_name;?> <?php echo $this->lang->line('xin_title_is_going_to_expire_soon');?></div>
 <?php endforeach;?>
 
 <?php $company_license_exp = $this->Xin_model->company_license_expired();?>
 <?php foreach($company_license_exp as $clicense_exp):?>
 <div class="alert alert-warning alert-dismissible">
 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
 <h4><i class="icon fa fa-warning"></i> <?php echo $this->lang->line('xin_title_alert');?></h4>
 <?php echo $this->lang->line('xin_title_license');?> <?php echo $clicense_exp->license_name;?> <?php echo $this->lang->line('xin_title_is_expired');?> </div>
 <?php endforeach;?>
 <?php endif;?><?php */?>


<div class="row <?php echo $get_animate; ?>">
  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <a href="<?php echo site_url('admin/employees'); ?>">
        <div class="d-flex align-items-center">
          <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-secondary mr-3">
            <i class="fa fa-user"></i>
          </span>
          <div>
            <h5 class="mb-1"><b>
                <?php echo $this->Employees_model->get_total_employees(); ?> <small>
                <?php echo $this->lang->line('xin_people'); ?>
                </small>
              </b></h5>
            <small class="text-muted"><span class="badge badge-info">
                <?php echo $this->lang->line('xin_employees_active'); ?>
                <?php echo active_employees(); ?>
              </span><span class="ml-2"> <span class="badge bg-red">
                  <?php echo $this->lang->line('xin_employees_inactive'); ?>
                  <?php echo inactive_employees(); ?>
                </span></span></small>

          </div>
        </div>
      </a>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <a href="<?php echo site_url('admin/employees/increment_pro_list'); ?>">
        <div class="d-flex align-items-center">
          <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-success-4 mr-3">
            <i class="fa fa-lock"></i>
          </span>
          <div>
            <h5 class="mb-1"><b> <span style="color: #00c0ef !important">Increment</span>, <span style="color: #31ce36!important;">Probation</span>  
             <span style="color: #6861ce !important">Promotion</span></b> &nbsp;&nbsp;
              <small class="text-muted">
                <?php echo $this->lang->line('xin_performance_management'); ?>
              </small>
            </h5>
          </div>
        </div>
      </a>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <a href="<?php echo site_url('admin/timesheet/leave'); ?>">
        <div class="d-flex align-items-center">
          <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-danger-4 mr-3">
            <i class="fa fa-calendar"></i>
          </span>
          <div>
            <h5 class="mb-1"><b>
                <?php echo $this->lang->line('left_leave'); ?> <small>
                  <?php echo $this->lang->line('xin_performance_management'); ?>
                </small>
              </b></h5>
            <small class="text-muted">
              <?php echo $this->lang->line('xin_hr_view_applications'); ?>
            </small>
          </div>
        </div>
      </a>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="card p-3">
      <a href="<?php echo site_url('admin/settings'); ?>">
        <div class="d-flex align-items-center">
          <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-warning-4 mr-3">
            <i class="fa fa-cog"></i>
          </span>
          <div>
            <h5 class="mb-1"><b>
                <?php echo $this->lang->line('xin_configure_hr'); ?> <small>
                  <?php echo $this->lang->line('left_settings'); ?>
                </small>
              </b></h5>
            <small class="text-muted">
              <?php echo $this->lang->line('header_configuration'); ?>
            </small>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>

<?php
$current_month = date('Y-m-d');
$working = $this->Xin_model->current_month_day_attendance($current_month);
$total = $this->Employees_model->get_total_employees(); 
// absent
$abs = $total - $working;
?>
<?php
$emp_abs = $abs / $total * 100;
$emp_work = $working / $total * 100;
?>
<?php
$emp_abs = $abs / $total * 100;
$emp_work = $working / $total * 100;
?>
<div class="row row-card-no-pd mt--2 <?php echo $get_animate; ?>">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <h5><span>
                <?php echo $this->lang->line('xin_hrsale_absent_today'); ?>
              </span></h5>
            <p class="text-muted">
              <?php echo $this->lang->line('xin_absent'); ?>
            </p>
          </div>
          <h3 class="text-info fw-bold">
            <?php echo $abs; ?>
          </h3>
        </div>
        <div class="progress progress-sm">
          <div class="progress-bar progress-bar-info w-75" role="progressbar"
            aria-valuenow="<?php echo $this->Xin_model->set_percentage($emp_abs); ?>" aria-valuemin="8"
            aria-valuemax="100" style="width: <?php echo $this->Xin_model->set_percentage($emp_abs); ?>%"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <p class="text-muted mb-0">
            <?php echo $this->lang->line('xin_hrsale_absent_status'); ?>
          </p>
          <p class="text-muted mb-0">
            <?php echo $this->Xin_model->set_percentage($emp_abs); ?>%
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <h5><span>
                <?php echo $this->lang->line('xin_hrsale_present_today'); ?>
              </span></h5>
            <p class="text-muted">
              <?php echo $this->lang->line('xin_emp_working'); ?>
            </p>
          </div>
          <h3 class="text-info fw-bold">
            <?php echo $working; ?>
          </h3>
        </div>
        <div class="progress progress-sm">
          <div class="progress-bar progress-bar-info w-75" role="progressbar"
            aria-valuenow="<?php echo $this->Xin_model->set_percentage($emp_work); ?>" aria-valuemin="8"
            aria-valuemax="100" style="width: <?php echo $this->Xin_model->set_percentage($emp_work); ?>%"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <p class="text-muted mb-0">
            <?php echo $this->lang->line('xin_hrsale_present_status'); ?>
          </p>
          <p class="text-muted mb-0">
            <?php echo $this->Xin_model->set_percentage($emp_work); ?>%
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <h5><span>
                <?php echo $this->lang->line('dashboard_projects'); ?>
              </span></h5>
            <p class="text-muted">
              <?php echo $this->lang->line('xin_hrsale_project_status'); ?>
            </p>
          </div>
          <?php $completed_proj = $this->Project_model->complete_projects(); ?>
          <?php $proj = $this->Xin_model->get_all_projects();
          if ($proj < 1) {
            $proj_percnt = 0;
          } else {
            $proj_percnt = $completed_proj / $proj * 100;
          }
          ?>
          <h3 class="text-info fw-bold"><a class="text-card-mduted" href="<?php echo site_url('admin/project'); ?>">
              <?php echo $this->Xin_model->get_all_projects(); ?>
            </a></h3>
        </div>
        <div class="progress progress-sm">
          <div class="progress-bar progress-bar-info w-75" role="progressbar"
            aria-valuenow="<?php echo $this->Xin_model->set_percentage($proj_percnt); ?>" aria-valuemin="8"
            aria-valuemax="100" style="width: <?php echo $this->Xin_model->set_percentage($proj_percnt); ?>%"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <p class="text-muted mb-0">
            <?php echo $this->lang->line('xin_completed'); ?>
          </p>
          <p class="text-muted mb-0">
            <?php echo $this->Xin_model->set_percentage($proj_percnt); ?>%
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-6 col-md-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <h5><span>
                <?php echo $this->lang->line('xin_tasks'); ?>
              </span></h5>
            <p class="text-muted">
              <?php echo $this->lang->line('xin_hrsale_task_status'); ?>
            </p>
          </div>
          <?php $completed_tasks = completed_tasks(); ?>
          <?php $task_all = $this->Xin_model->get_all_tasks();
          if ($task_all < 1) {
            $task_percnt = 0;
          } else {
            $task_percnt = $completed_tasks / $task_all * 100;
          }
          ?>
          <h3 class="text-info fw-bold"><a class="text-card-mduted"
              href="<?php echo site_url('admin/timesheet/tasks'); ?>">
              <?php echo $this->Xin_model->get_all_tasks(); ?>
            </a></h3>
        </div>
        <div class="progress progress-sm">
          <div class="progress-bar progress-bar-info w-75" role="progressbar"
            aria-valuenow="<?php echo $this->Xin_model->set_percentage($task_percnt); ?>" aria-valuemin="8"
            aria-valuemax="100" style="width: <?php echo $this->Xin_model->set_percentage($task_percnt); ?>%"></div>
        </div>
        <div class="d-flex justify-content-between mt-2">
          <p class="text-muted mb-0">
            <?php echo $this->lang->line('xin_completed'); ?>
          </p>
          <p class="text-muted mb-0">
            <?php echo $this->Xin_model->set_percentage($task_percnt); ?>%
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row <?php echo $get_animate; ?>">
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">
          <?php echo $this->lang->line('xin_employee_department_txt'); ?>
        </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <div class="col-md-7">
            <div class="overflow-scrolls" style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    <?php $c_color = array('#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC'); ?>
                    <?php $j = 0;
                    foreach ($this->Department_model->all_departments() as $department) { ?>
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
                      <td>
                        <div style="width:4px;border:5px solid <?php echo $c_color[$j]; ?>;"></div>
                      </td>
                      <td>
                        <?php echo htmlspecialchars_decode($department->department_name); ?> (
                        <?php echo $query->num_rows(); ?>)
                      </td>
                    </tr>
                    <?php $j++;
                      } ?>
                    <?php } ?>
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
        <h3 class="box-title">
          <?php echo $this->lang->line('xin_employee_designation_txt'); ?>
        </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <div class="col-md-7">
            <div class="overflow-scrolls" style="overflow:auto; height:200px;">
              <div class="table-responsive">
                <table class="table mb-0 table-dashboard">
                  <tbody>
                    <?php $c_color2 = array('#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED'); ?>
                    <?php $k = 0;
                    foreach ($this->Designation_model->all_designations() as $designation) { ?>
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
                      <td>
                        <div style="width:4px;border:5px solid <?php echo $c_color2[$k]; ?>;"></div>
                      </td>
                      <td>
                        <?php echo htmlspecialchars_decode($designation->designation_name); ?> (
                        <?php echo $query1->num_rows(); ?>)
                      </td>
                    </tr>
                    <?php $k++;
                      } ?>
                    <?php } ?>
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
<div class="row mt--2 <?php echo $get_animate; ?>">
  <div class="col-md-12">
    <div class="card full-height">
      <div class="card-body">
        <div class="card-title">
          <?php echo $this->lang->line('xin_hrsale_paid_salaries_account_balances'); ?>
        </div>
        <?php $exp_am = $this->Expense_model->get_total_expenses(); ?>
        <?php $all_sal = total_salaries_paid(); ?>
        <div class="row py-3">
          <div class="col-md-3 d-flex flex-column justify-content-around">
            <h6 class="fw-bold text-uppercase text-success op-8">
              <?php echo $this->lang->line('dashboard_total_expenses'); ?>
            </h6>
            <h3 class="fw-bold">
              <?php echo $this->Xin_model->currency_sign($exp_am[0]->exp_amount); ?>
            </h3>
          </div>
          <div class="col-md-3 d-flex flex-column justify-content-around">
            <h6 class="fw-bold text-uppercase text-danger op-8">
              <?php echo $this->lang->line('dashboard_total_salaries'); ?>
            </h6>
            <h3 class="fw-bold">
              <?php echo $this->Xin_model->currency_sign($all_sal); ?>
            </h3>
          </div>
          <div class="col-md-3 d-flex flex-column justify-content-around">
            <h6 class="fw-bold text-uppercase text-info op-8">
              <?php echo $this->lang->line('xin_acc_account_balances'); ?>
            </h6>
            <h3 class="fw-bold">
              <?php echo $this->Xin_model->currency_sign(total_account_balances()); ?>
            </h3>
          </div>
          <div class="col-md-3 d-flex flex-column justify-content-around">
            <h6 class="fw-bold text-uppercase text-warning op-8">
              <?php echo $this->lang->line('xin_hrsale_travel_expenses'); ?>
            </h6>
            <h3 class="fw-bold">
              <?php echo $this->Xin_model->currency_sign(total_travel_expense()); ?>
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php if ($system[0]->module_inquiry == 'true') { ?>
<div class="row <?php echo $get_animate; ?>">
  <div class="col-md-4 col-12">
    <div class="box box-body hr-mini-state hrsalle-mini-stat">
      <a class="text-card-muted" href="<?php echo site_url('admin/tickets'); ?>">
        <div class="flexbox"> <span class="fa fa-ticket text-primary font-size-50"></span> <span
            class="font-size-40 font-weight-400">
            <?php echo total_tickets(); ?>
          </span> </div>
        <div class="text-right">
          <?php echo $this->lang->line('xin_hr_total_tickets'); ?>
        </div>
      </a>
    </div>
  </div>
  <div class="col-md-4 col-12">
    <div class="box box-body hr-mini-state hrsalle-mini-stat">
      <a class="text-card-muted" href="<?php echo site_url('admin/tickets'); ?>">
        <div class="flexbox"> <span class="fa fa-server text-danger font-size-50"></span> <span
            class="font-size-40 font-weight-400">
            <?php echo total_open_tickets(); ?>
          </span> </div>
        <div class="text-right">
          <?php echo $this->lang->line('xin_hr_total_open_tickets'); ?>
        </div>
      </a>
    </div>
  </div>
  <div class="col-md-4 col-12">
    <div class="box box-body hr-mini-state hrsalle-mini-stat">
      <a class="text-card-muted" href="<?php echo site_url('admin/tickets'); ?>">
        <div class="flexbox"> <span class="ion ion-thumbsup text-success font-size-50"></span> <span
            class="font-size-40 font-weight-400">
            <?php echo total_closed_tickets(); ?>
          </span> </div>
        <div class="text-right">
          <?php echo $this->lang->line('xin_hr_total_closed_tickets'); ?>
        </div>
      </a>
    </div>
  </div>
</div>
<?php } ?>
<?php if ($theme[0]->dashboard_calendar == 'true'): ?>
<?php $this->load->view('admin/calendar/calendar_hr'); ?>
<?php endif; ?>