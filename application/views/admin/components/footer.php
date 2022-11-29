<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php
if($theme[0]->fixed_layout=='true') {
	$lay_fixed = 'navbar-fixed-bottom';
} else {
	$lay_fixed = 'footer-static';
}
?>

<footer class="main-footer <?php echo $theme[0]->footer_layout;?>"> <strong>
  <?php if($system[0]->enable_current_year=='yes'):?>
  <?php echo date('Y');?>
  <?php endif;?>
  © <b><?php echo $system[0]->footer_text;?> <?php echo $this->Xin_model->hrsale_version();?></b>
  <?php if($system[0]->enable_page_rendered=='yes'):?>
  - <?php echo $this->lang->line('xin_page_rendered_text');?> <strong>{elapsed_time}</strong> <?php echo $this->lang->line('xin_rendered_seconds');?>. <?php echo  (ENVIRONMENT === 'development') ?  ''.$this->lang->line('xin_codeigniter_version').' <strong>' . CI_VERSION . '</strong>' : '' ?>
  <?php endif; ?>
  </strong> </footer>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark"> 
  <!-- Tab panes -->
  <div class="tab-content"> 
    <!-- Home tab content -->
    <div class="tab-pane" id="control-sidebar-home-tab"> </div>
    <!-- /.tab-pane --> 
  </div>
</aside>
<style type="text/css">
.info-box-text-hrsale-modal {
    font-size: 16px !important;
	text-transform: none;
	font-weight: 500 !important;
}
.info-box-content-hrsale-modal {
	font-size: 20px !important;
	padding: 24px 0px 0px 0 !important;
    margin-left: 70px !important;
}
.info-box-icon-hrsale-modal {
    background: none !important;
	font-size: 40px !important;
}
.modal-hrsale-modal {
    background: rgba(34,37,42,0.95);
}
.hrsale-close-button {
	color:#fff;
	opacity: 1.2;
	font-size: 35px !important;
	background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    width: 35px;
    border-radius: 4px;
}
.info-box-text-hrsale-modal a{
	color:#000 !important;
}
</style>
<div class="modal modal-hrsale-modal modal-hrsaleapps animated fadeIn" id="modal-hrsaleapps" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="    background: none; box-shadow: 0 0px 0px rgba(0,0,0,.5);">
      <div class="modal-header" style="padding: 0; border-bottom: 0;">
        <button type="button" class="close hrsale-close-button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="">×</span></button>
      </div>
      <div class="modal-body">
       <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon info-box-icon-hrsale-modal"><i class="fa fa-ticket text-aqua"></i></span>

            <div class="info-box-content info-box-content-hrsale-modal">
              <span class="info-box-text info-box-text-hrsale-modal">
			  <a href="<?php echo site_url('admin/tickets');?>"><?php echo $this->lang->line('left_tickets');?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon info-box-icon-hrsale-modal"><i class="fa fa-money text-yellow"></i></span>

            <div class="info-box-content info-box-content-hrsale-modal">
              <span class="info-box-text info-box-text-hrsale-modal">
			  <a href="<?php echo site_url('admin/accounting/bank_cash');?>"><?php echo $this->lang->line('xin_hr_finance');?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon info-box-icon-hrsale-modal"><i class="fa fa-calendar-plus-o text-red"></i></span>
            <div class="info-box-content info-box-content-hrsale-modal">
              <span class="info-box-text info-box-text-hrsale-modal">
			  <a href="<?php echo site_url('admin/events');?>"><?php echo $this->lang->line('xin_hr_events');?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon info-box-icon-hrsale-modal"><i class="fa fa-calculator text-green"></i></span>
            <div class="info-box-content info-box-content-hrsale-modal">
              <span class="info-box-text info-box-text-hrsale-modal">
			  <a href="<?php echo site_url('admin/payroll/generate_payslip');?>"><?php echo $this->lang->line('left_payroll');?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon info-box-icon-hrsale-modal"><i class="fa fa-user text-green"></i></span>

            <div class="info-box-content info-box-content-hrsale-modal">
              <span class="info-box-text info-box-text-hrsale-modal">
              <a href="<?php echo site_url('admin/employees');?>"><?php echo $this->lang->line('dashboard_employees');?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon info-box-icon-hrsale-modal"><i class="fa fa-clock-o text-light-blue"></i></span>
            <div class="info-box-content info-box-content-hrsale-modal">
              <span class="info-box-text info-box-text-hrsale-modal">
			  <a href="<?php echo site_url('admin/timesheet/attendance');?>"><?php echo $this->lang->line('left_timesheet');?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon info-box-icon-hrsale-modal"><i class="fa fa-newspaper-o text-yellow"></i></span>
            <div class="info-box-content info-box-content-hrsale-modal">
              <span class="info-box-text info-box-text-hrsale-modal">
			  <a href="<?php echo site_url('jobs');?>"><?php echo $this->lang->line('left_recruitment');?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon info-box-icon-hrsale-modal"><i class="fa fa-file-text-o text-red"></i></span>
            <div class="info-box-content info-box-content-hrsale-modal">
              <span class="info-box-text info-box-text-hrsale-modal">
			  <a href="<?php echo site_url('admin/files');?>"><?php echo $this->lang->line('xin_files_manager');?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon info-box-icon-hrsale-modal"><i class="fa fa-tasks text-blue"></i></span>
            <div class="info-box-content info-box-content-hrsale-modal">
              <span class="info-box-text info-box-text-hrsale-modal">
			  <a href="<?php echo site_url('admin/project');?>"><?php echo $this->lang->line('xin_project_manager_title');?></a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.control-sidebar --> 
