<?php
  $session = $this->session->userdata('username');
  $system = $this->Xin_model->read_setting_info(1);
  $company_info = $this->Xin_model->read_company_setting_info(1);
  $user = $this->Xin_model->read_employee_info($session['user_id']);
  $theme = $this->Xin_model->read_theme_info(1);
?>

<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php
  if(!empty($wz_lang)):
  	$lang_code = $this->Xin_model->get_language_info($wz_lang);
  	$flg_icn = $lang_code[0]->language_flag;
  	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
  elseif($system[0]->default_language!=''):
  	$lang_code = $this->Xin_model->get_language_info($system[0]->default_language);
  	$flg_icn = $lang_code[0]->language_flag;
  	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
  else:
  	$flg_icn = '<img src="'.base_url().'uploads/languages_flag/gb.gif">';	
  endif;
?>

<?php
  $role_user = $this->Xin_model->read_user_role_info($user[0]->user_role_id);
  if(!is_null($role_user)){
  	$role_resources_ids = explode(',',$role_user[0]->role_resources);
  } else {
  	$role_resources_ids = explode(',',0);	
  }
  //$designation_info = $this->Xin_model->read_designation_info($user_info[0]->designation_id);
  // set color
  if($theme[0]->is_semi_dark==1):
  	$light_cls = 'navbar-semi-dark navbar-shadow';
  	$ext_clr = '';
  else:
  	$light_cls = 'navbar-dark';
  	$ext_clr = $theme[0]->top_nav_dark_color;
  endif;
  // set layout / fixed or static
  if($theme[0]->boxed_layout=='true'){
  	$lay_fixed = 'container boxed-layout';
  } else {
  	$lay_fixed = '';
  }
  if($theme[0]->animation_style == '') {
  	$animated = 'animated flipInY';
  } else {
  	$animated = 'animated '.$theme[0]->animation_style;
  }
?>

<style type="text/css">
  .main-header .sidebar-toggle-hrsale-chat:before {
  	content: "\f0e6";
  }
  .main-header .sidebar-toggle-hrsale-quicklinks:before {
  	content: "\f00a";
  }
</style>

<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('admin/dashboard/');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><img alt="<?php echo $system[0]->application_name;?>" src="<?php echo base_url();?>uploads/logo/<?php echo $company_info[0]->logo;?>" class="brand-logo" style="width:32px;"></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img alt="<?php echo $system[0]->application_name;?>" src="<?php echo base_url();?>uploads/logo/<?php echo $company_info[0]->logo;?>" class="brand-logo" style="width:32px;"> <b><?php echo $system[0]->application_name;?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" title="<?php echo $this->lang->line('xin_sidebar_title');?>">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <?php if($system[0]->module_chat_box=='true'){?>
        <a href="<?php echo site_url('admin/chat');?>" class="sidebar-toggle sidebar-toggle-hrsale-chat" role="button" title="<?php echo $this->lang->line('xin_hr_chat_box');?>">
          <?php $unread_msgs = $this->Xin_model->get_single_unread_message($session['user_id']);?>
          <?php if($unread_msgs > 0) {?><span class="chat-badge label label-aqua" id="msgs_count"><?php echo $unread_msgs;?></span><?php } ?>
        </a>
      <?php } if($user[0]->user_role_id=='1'){?>
        <a href="javascript:void(0);" class="sidebar-toggle sidebar-toggle-hrsale-quicklinks" role="button" data-toggle="modal" data-target=".modal-hrsaleapps" title="<?php echo $this->lang->line('xin_quick_links');?>">	</a>
      <?php } ?>  
            
      <!-- Notification here -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">     
  		    <?php  if(in_array('90',$role_resources_ids)) { 
          $fcount = 0;
  				if($user[0]->user_role_id != 3){
  					$leaveapp = $this->Xin_model->get_notify_leave_applications();
            $start_date = date('Y-m-d', strtotime('-1 month', strtotime(date("Y-m-01"))));
            $end_date = date('Y-m-d', strtotime('+2 month', strtotime(date("Y-m-00"))));
            $incrementapp = $this->Xin_model->get_notify_incr_prob_applications($start_date, $end_date, 1);
            $probationapp = $this->Xin_model->get_notify_incr_prob_applications($start_date, $end_date, 4);

  					// $nproject = $this->Xin_model->get_notify_projects();
  					// $ntask = $this->Xin_model->get_notify_tasks();
  					// $nannouncements = $this->Xin_model->get_notify_announcements();
  					// $ntickets = $this->Xin_model->get_notify_tickets();
  					// count
  					// $leave_count = $this->Xin_model->count_notify_leave_applications();
  					// $proj_count = $this->Xin_model->count_notify_projects();
  					// $tsk_count = $this->Xin_model->count_notify_tasks();
  					// $nst_count = $this->Xin_model->count_notify_announcements();

            //$this->Xin_model->count_notify_tickets();
  					//$tsk_count = $this->Xin_model->count_notify_tasks();

  					$fcount = count($leaveapp) + count($incrementapp) + count($probationapp);
  				} ?>
          <style>
            .menu>li>a>.nrcolor { color: #ff0101 !important; }
            .menu>li>a>.ngcolor { color: #037c29 !important; }
          </style>

          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" title="<?php echo $this->lang->line('header_notifications');?>">
              <i class="fa fa-bell-o"></i>
              <span class="label" style="font-size: 12px !important; background: #fb0202 !important"><?php echo $fcount;?></span>
            </a>
            <?php if(count($leaveapp) > 0  ){?>
            <ul class="dropdown-menu menu <?php echo $animated;?>">
              <li>
                <!-- inner menu: contains the actual data --> 
                <!-- Ieave application here -->              
                <?php if(count($leaveapp) > 0){?>
                <ul class="menu">
                  <div class="callout callout-hrsale-bg-leave callout-hrsale">
                    <p><?php echo $this->lang->line('xin_leave_notifications');?><span style="color: #d30505; padding: 4px; font-weight: bolder;"><?=count($leaveapp) ?></p>
                  </div>
                  <?php foreach($leaveapp as $row){?>
  					        <?php $emp_info = $this->Xin_model->read_user_info($row->employee_id);?>
                    <?php
                      if(!is_null($emp_info)){
                          $emp_name = $emp_info[0]->first_name. ' '.$emp_info[0]->last_name;
                      } else {
                          $emp_name = '--';	
                      }
                    ?>

                    <li><!-- start message -->
                      <a href="<?php echo site_url('admin/timesheet/leave_details/id')?>/<?php echo $row->leave_id;?>/">
                        <div class="pull-left">
                          <?php  if($emp_info[0]->profile_picture!='' && $emp_info[0]->profile_picture!='no file') {?>
                          <img src="<?php  echo base_url().'uploads/profile/'.$emp_info[0]->profile_picture;?>" alt="" id="user_avatar" 
                          class="img-circle user_profile_avatar">
                          <?php } else {?>
                          <?php  if($emp_info[0]->gender=='Male') { ?>
                          <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
                          <?php } else { ?>
                          <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
                          <?php } ?>
                          <img src="<?php  echo $de_file;?>" alt="" id="user_avatar" class="img-circle user_profile_avatar">
                          <?php  } ?>
                        </div>
                        <h4> <?php echo $emp_name;?> </h4>
                        <p>applied for leave <?php echo $this->Xin_model->set_date_format($row->applied_on);?></p>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
                <br>
				        <?php } ?>

                <!-- Increment here -->
                <?php if(count($incrementapp) > 0){?>
                <ul class="menu">
                  <div class="callout callout-hrsale" style="background: #0691d3; color: white;">
                    <p>Increment notifications <span style="color: #d30505; padding: 4px; font-weight: bolder;"><?=count($incrementapp) ?></p>
                  </div>
                  <?php foreach($incrementapp as $row){?>
                    <?php 
                      $ipdate = $row->notify_incre_prob;
                      $red_zone = date('Y-m-d', strtotime('-20 days', strtotime(date($ipdate)))); 
                    ?>
                    <li class="lir">
                      <a onclick="incrementFun(<?php echo $row->user_id; ?>)">
                        <div class="pull-left">
                          <?php  if($row->profile_picture!='' && $row->profile_picture!='no file') {?>
                          <img src="<?php  echo base_url('uploads/profile/'.$row->profile_picture);?>" alt="" id="user_avatar" 
                          class="img-circle user_profile_avatar">
                          <?php } else {?>
                          <?php  if($row->gender=='Male') { ?>
                          <?php   $de_file = base_url().'uploads/profile/default_male.jpg';?>
                          <?php } else { ?>
                          <?php   $de_file = base_url().'uploads/profile/default_female.jpg';?>
                          <?php } ?>
                          <img src="<?php  echo $de_file;?>" alt="" id="user_avatar" class="img-circle user_profile_avatar">
                          <?php  } ?>
                        </div>
                        <h4 class="<?php echo ($red_zone < date('Y-m-d'))? 'nrcolor':'ngcolor' ?>"> <?php echo $row->first_name. ' '.$row->last_name;?> </h4>
                        <p class="<?php echo ($red_zone < date('Y-m-d'))? 'nrcolor':'ngcolor' ?>"> Increment on <?php echo date("d-M-Y", strtotime($ipdate));?> </p>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
                <br>
                <?php } ?>  

                <!--  Probation here  -->
                <?php if(count($probationapp) > 0){?>
                <ul class="menu">
                  <div class="callout callout-hrsale" style="background: #6266df; color: white;">
                    <p>Probation notifications <span style="color: #d30505; padding: 4px; font-weight: bolder;"><?=count($probationapp) ?></span></p>
                  </div>
                  <?php foreach($probationapp as $row){?>
                    <?php 
                      $ipdate = $row->notify_incre_prob;
                      $red_zone = date('Y-m-d', strtotime('-20 days', strtotime(date($ipdate)))); 
                    ?>
                    <li class="lir"><!-- start message -->
                      <a onclick="probationFun(<?php echo $row->user_id; ?>)">
                        <div class="pull-left">
                          <?php  if($row->profile_picture!='' && $row->profile_picture!='no file') {?>
                          <img src="<?php  echo base_url('uploads/profile/'.$row->profile_picture);?>" alt="" id="user_avatar" 
                          class="img-circle user_profile_avatar">
                          <?php } else {?>
                          <?php  if($row->gender=='Male') { ?>
                          <?php   $de_file = base_url().'uploads/profile/default_male.jpg';?>
                          <?php } else { ?>
                          <?php   $de_file = base_url().'uploads/profile/default_female.jpg';?>
                          <?php } ?>
                          <img src="<?php  echo $de_file;?>" alt="" id="user_avatar" class="img-circle user_profile_avatar">
                          <?php  } ?>
                        </div>
                        <h4 class="<?php echo ($red_zone < date('Y-m-d'))? 'nrcolor':'ngcolor' ?>"> <?php echo $row->first_name. ' '.$row->last_name;?> </h4>
                        <p class="<?php echo ($red_zone < date('Y-m-d'))? 'nrcolor':'ngcolor' ?>"> Probation on <?php echo date("d-M-Y", strtotime($ipdate));?> </p>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
                <?php } ?>                
              </li>
            </ul>
            <?php } ?>
          </li> 
          
          <?php } ?>




          <!-- Tasks: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          	<?php  if(in_array('61',$role_resources_ids) || in_array('93',$role_resources_ids) || in_array('63',$role_resources_ids) || in_array('92',$role_resources_ids) || in_array('62',$role_resources_ids) || in_array('94',$role_resources_ids) || in_array('96',$role_resources_ids) || in_array('60',$role_resources_ids) || $user[0]->user_role_id==1 || $system[0]->module_recruitment=='true' || $system[0]->enable_job_application_candidates=='1' || in_array('50',$role_resources_ids) || in_array('393',$role_resources_ids) || in_array('118',$role_resources_ids)) { ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true" title="<?php echo $this->lang->line('header_configuration');?>">
                  <i class="fa fa-qrcode"></i>
                </a>
                <ul class="dropdown-menu <?php echo $animated;?>">
                  <?php if($system[0]->module_recruitment=='true'){?>
				  <?php if($system[0]->enable_job_application_candidates=='1'){?>
                  <?php  if(in_array('50',$role_resources_ids)) { ?>
                  <li role="presentation">
                    <a role="menuitem" tabindex="-1" target="_blank" href="<?php echo site_url('jobs');?>"><i class="fa fa-newspaper-o"></i><?php echo $this->lang->line('left_jobs_listing');?>
                    </a>
                  </li>
                  <?php  } ?>
                  <?php  } ?>
                  <?php  } ?>
				  <?php  if(in_array('61',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/constants');?>"> <i class="fa fa-align-justify"></i><?php echo $this->lang->line('left_constants');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('393',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/custom_fields');?>"> <i class="fa fa-sliders"></i><?php echo $this->lang->line('xin_hrsale_custom_fields');?></a></li>
                  <?php } ?>
				  <?php  if($user[0]->user_role_id==1) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/roles');?>"> <i class="fa fa-unlock-alt"></i><?php echo $this->lang->line('xin_role_urole');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('93',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/modules');?>"> <i class="fa fa-life-ring"></i><?php echo $this->lang->line('xin_setup_modules');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('63',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/email_template');?>"> <i class="fa fa-envelope"></i><?php echo $this->lang->line('left_email_templates');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('92',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/employees/import');?>"> <i class="fa fa-users"></i><?php echo $this->lang->line('xin_import_employees');?></a></li>
                  <?php } ?>
				  <?php  if(in_array('62',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/database_backup');?>"> <i class="fa fa-database"></i><?php echo $this->lang->line('header_db_log');?></a></li>
                  <?php } ?>
                  <?php  if(in_array('94',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/theme');?>"> <i class="fa fa-columns"></i><?php echo $this->lang->line('xin_theme_settings');?></a></li>
                  <?php } ?>
                  <?php if(in_array('118',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/payment_gateway');?>"> <i class="fa fa-cc-visa"></i><?php echo $this->lang->line('xin_acc_payment_gateway');?></a></li>
                  <?php } ?>
                  <?php if($system[0]->module_orgchart=='true'){?>
            	  <?php if(in_array('96',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/organization/chart');?>"> <i class="fa fa-sitemap"></i><?php echo $this->lang->line('xin_org_chart_title');?></a></li>
                  <?php } ?>
                  <?php } ?>
                  <?php if(in_array('60',$role_resources_ids)) { ?>
                  <li class="divider"></li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings');?>"> <i class="fa fa-cog text-aqua"></i><?php echo $this->lang->line('header_configuration');?></a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>  
          	<?php if($system[0]->module_language=='true'){?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true" title="<?php echo $this->lang->line('xin_languages');?>">
                  <?php echo $flg_icn;?>
                </a>
                <ul class="dropdown-menu <?php echo $animated;?>">
                <?php $languages = $this->Xin_model->all_languages();?>
				<?php foreach($languages as $lang):?>
                <?php $flag = '<img src="'.base_url().'uploads/languages_flag/'.$lang->language_flag.'">';?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/dashboard/set_language/').$lang->language_code;?>"><?php echo $flag;?> &nbsp; <?php echo $lang->language_name;?></a></li>
                  <?php endforeach;?>
                  <?php if($system[0]->module_language=='true'){?>
            	<?php  if(in_array('89',$role_resources_ids)) { ?>
                  <li class="divider"></li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/languages');?>"> <i class="fa fa-cog text-aqua"></i><?php echo $this->lang->line('left_settings');?></a></li>
                  <?php } ?>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>   
           <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true" title="<?php echo $this->lang->line('header_my_profile');?>">
              <i class="glyphicon glyphicon-user"></i>
            </a>
            <ul class="dropdown-menu <?php echo $animated;?>">
              	<li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/profile');?>"> <i class="ion ion-person"></i><?php echo $this->lang->line('header_my_profile');?></a></li>
                  <li role="presentation">
                  <a data-toggle="modal" data-target=".policy" href="#"> <i class="fa fa-flag-o"></i><?php echo $this->lang->line('header_policies');?></a></li>
                  <?php if(in_array('60',$role_resources_ids)) { ?>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings');?>"> <i class="ion ion-settings"></i><?php echo $this->lang->line('left_settings');?></a></li>
                  <?php } ?>
                  
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/profile?change_password=true');?>"> <i class="fa fa-key"></i><?php echo $this->lang->line('header_change_password');?></a></li>
                  <li class="divider"></li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/auth/lock');?>"> <i class="fa fa-lock"></i><?php echo $this->lang->line('xin_lock_user');?></a></li>
                  <li role="presentation">
                  <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/logout');?>"> <i class="fa fa-power-off text-red"></i><?php echo $this->lang->line('header_sign_out');?></a></li>
                </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar" title="<?php echo $this->lang->line('xin_role_layout_settings');?>"><i class="fa fa-cog fa-spin"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>



