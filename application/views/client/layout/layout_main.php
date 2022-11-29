<?php
$session = $this->session->userdata('client_username');
$system = $this->Xin_model->read_setting_info(1);
$layout = $this->Xin_model->system_layout();
$company_info = $this->Xin_model->read_company_setting_info(1);
$user_info = $this->Clients_model->read_client_info($session['client_id']);
//material-design
$theme = $this->Xin_model->read_theme_info(1);
// set layout / fixed or static
if($theme[0]->boxed_layout=='true') {
	$lay_fixed = 'container boxed-layout';
} else {
	$lay_fixed = '';
}
if($theme[0]->compact_menu=='true') {
	$menu_collapsed = 'menu-collapsed';
} else {
	$menu_collapsed = '';
}
if($theme[0]->flipped_menu=='true') {
	$menu_flipped = 'menu-flipped';
} else {
	$menu_flipped = '';
}
if($this->router->fetch_class() =='chat'){
	$chat_app = 'chat-application';
} else {
	$chat_app = '';
}
?>
<?php $this->load->view('client/components/htmlheader');?>
<body class="hrsale-layout hold-transition skin-black idebar-mini fixed">
<div class="wrapper">

  <?php $this->load->view('client/components/header');?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <!-- Links -->
    <?php $this->load->view('client/components/left_menu');?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php if($this->router->fetch_class() !='dashboard' && $this->router->fetch_class() !='chat' && $this->router->fetch_class() !='calendar' && $this->router->fetch_class() !='profile'){?>
    <section class="content-header">
      <h1>
        <?php echo $breadcrumbs;?>
        <!--<small><?php echo $breadcrumbs;?></small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('client/dashboard/');?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('xin_e_details_home');?></a></li>
        <li class="active"><?php echo $breadcrumbs;?></li>
      </ol>
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
  <?php $this->load->view('client/components/footer');?>
 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Layout footer -->
<?php $this->load->view('client/components/htmlfooter');?>
<!-- / Layout footer -->
          
</body>
</html>