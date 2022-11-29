<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$layout = $this->Xin_model->system_layout();
$user_info = $this->Xin_model->read_user_info($session['user_id']);
//material-design
$theme = $this->Xin_model->read_theme_info(1);
// set layout / fixed or static
if($user_info[0]->fixed_header=='fixed_layout_hrsale') {
	$fixed_header = 'fixed';
} else {
	$fixed_header = '';
}
if($user_info[0]->boxed_wrapper=='boxed_layout_hrsale') {
	$boxed_wrapper = 'layout-boxed';
} else {
	$boxed_wrapper = '';
}
if($user_info[0]->compact_sidebar=='sidebar_layout_hrsale') {
	$compact_sidebar = 'sidebar-collapse';
} else {
	$compact_sidebar = '';
}
/*
if($this->router->fetch_class() =='chat'){
	$chat_app = 'chat-application';
} else {
	$chat_app = '';
}*/
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $this->load->view('admin/components/htmlheader');?>
<body class="hrsale-layout hold-transition sidebar-mini skin-blue <?php echo $fixed_header;?> <?php echo $boxed_wrapper;?> <?php echo $compact_sidebar;?>">
<div class="wrapper">
<?php if($theme[0]->theme_option == 'template_1'):?>
  <?php $this->load->view('admin/components/header');?>
<?php elseif($theme[0]->theme_option == 'template_2'):?>  
  <?php $this->load->view('admin/components/header_template2');?>  
<?php else:?>
	<?php $this->load->view('admin/components/header');?>
<?php endif;?>  

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <!-- Links -->
    <?php //$this->load->view('admin/components/left_menu');?>
	<?php if($theme[0]->theme_option == 'template_1'):?>
    	<?php $this->load->view('admin/components/left_menu');?>
    <?php elseif($theme[0]->theme_option == 'template_2'):?>  
    	<?php $this->load->view('admin/components/left_menu_template2');?>
    <?php else:?>
    	<?php $this->load->view('admin/components/left_menu');?>
    <?php endif;?>
    <!-- /.sidebar -->
    <div class="sidebar-footer">
		<?php  if(in_array('60',$role_resources_ids)) { ?>
        <!-- item-->
		<a href="<?php echo site_url('admin/settings');?>" class="link" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('header_configuration');?>"><i class="fa fa-cog fa-spin"></i></a>
        <?php } else {?>
        <a href="<?php echo site_url('admin/dashboard');?>" class="link" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('dashboard_title');?>"><i class="fa fa-dashboard"></i></a>
        <?php } ?>
		<!-- item-->
		<a href="<?php echo site_url('admin/profile');?>" class="link" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('header_my_profile');?>"><i class="fa fa-user"></i></a>
		<!-- item-->
		<a href="<?php echo site_url('admin/logout');?>" class="link" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('header_sign_out');?>"><i class="fa fa-power-off"></i></a>
	</div>
  </aside>
  
  <div class="content-wrapper">
  <?php if($this->router->fetch_class() =='dashboard' || $this->router->fetch_class() =='chat' || $this->router->fetch_class() =='1calendar' || $this->router->fetch_class() =='profile'){?>
  <div id="header_wrapper" class="header-lg overlay ecom-header">
    <div class="container">
    </div>
  </div>
  <?php } ?>
    <!-- Content Header (Page header) -->
    <?php if($this->router->fetch_class() !='dashboard' && $this->router->fetch_class() !='chat' && $this->router->fetch_class() !='calendar' && $this->router->fetch_class() !='profile'){?>
    <section class="<?php echo $theme[0]->page_header;?> content-header">
      <h1>
        <?php echo $breadcrumbs;?>
        <!--<small><?php echo $breadcrumbs;?></small>-->
        <div class="row breadcrumbs-hr-top">
              <div class="breadcrumb-wrapper col-xs-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo site_url('admin/dashboard/');?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('xin_e_details_home');?></a>
                  </li>
                  <li class="breadcrumb-item active"><?php echo $breadcrumbs;?></li>
                </ol>
              </div>
            </div>
      </h1>
      <img id="hrload-img" src="<?php echo base_url()?>skin/img/loading.gif" style="">
	<style type="text/css">
    #hrload-img {
        display: none;
        z-index: 87896969;
        float: right;
        margin-right: 25px;
        margin-top: -32px;
    }
    </style>
      <?php if($user_info[0]->user_role_id==1): ?>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/theme/');?>"><i class="fa fa-columns"></i> <?php echo $this->lang->line('xin_theme_settings');?></a></li>
        <li><a href="<?php echo site_url('admin/settings/');?>"><i class="fa fa-cog"></i> <?php echo $this->lang->line('header_configuration');?></a></li>
      </ol>
      <?php endif;?>
    </section>
    <?php } ?>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      
      <!-- /.row -->
      <!-- Main row -->
      <?php // get the required layout..?>
	   <?php echo $subview;?>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('admin/components/footer');?>
 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Layout footer -->
<?php $this->load->view('admin/components/htmlfooter');?>
<!-- / Layout footer -->
</body>
</html>