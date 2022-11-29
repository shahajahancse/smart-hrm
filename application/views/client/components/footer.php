<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php
if($theme[0]->fixed_layout=='true') {
	$lay_fixed = 'navbar-fixed-bottom';
} else {
	$lay_fixed = 'footer-static';
}
?>

<footer class="main-footer">
  <div class="pull-right hidden-xs"> <b><?php echo $system[0]->footer_text;?> <?php echo $this->Xin_model->hrsale_version();?></b> </div>
  <strong>
  <?php if($system[0]->enable_current_year=='yes'):?>
  <?php echo date('Y');?>
  <?php endif;?>
  ©
  <?php if($system[0]->enable_page_rendered=='yes'):?>
  - <?php echo $this->lang->line('xin_page_rendered_text');?> <strong>{elapsed_time}</strong> <?php echo $this->lang->line('xin_rendered_seconds');?>. <?php echo  (ENVIRONMENT === 'development') ?  ''.$this->lang->line('xin_codeigniter_version').' <strong>' . CI_VERSION . '</strong>' : '' ?>
  <?php endif; ?>
  </strong> </footer>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark"> 
  <!-- Tab panes -->
  <div class="tab-content"> 
    <!-- Home tab content -->
    <div class="tab-pane" id="control-sidebar-home-tab">
      
    </div>
    <!-- /.tab-pane --> 
  </div>
</aside>
<!-- /.control-sidebar --> 
