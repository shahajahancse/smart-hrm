<?php $session = $this->session->userdata('username');?>
<?php $fuser_info = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php
$location = $this->Location_model->read_location_information($fuser_info[0]->location_id);
if(!is_null($location)){
	$location_name = $location[0]->location_name;
} else {
	$location_name = '--';
}
$department = $this->Department_model->read_department_information($fuser_info[0]->department_id);
if(!is_null($department)){
	$_department_name = $department[0]->department_name;
} else {
	$_department_name = '';
}
		
if($fuser_info[0]->online_status==1):
	$stgm = 'avatar-online';
	$status_title = $this->lang->line('xin_iamavailable_title');
elseif($fuser_info[0]->online_status==3):
	$stgm = 'avatar-busy';
	$status_title = $this->lang->line('xin_iambusy_title');
else:
	$stgm = 'avatar-away';
	$status_title = $this->lang->line('xin_iamaway_title');
endif;
?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<div class="row"> 
  <!-- /.col -->
  <div class="col-lg-4 col-md-12">
  	<div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line('xin_chatgroup_title');?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="">
          <ul class="nav nav-stacked">
            <li>
            <button href="#" class="list-group-item list-group-item-action media no-border" id="set_department-groupbox_<?php echo $fuser_info[0]->department_id;?>" data-from-id="<?php echo $session['user_id'];?>" data-chat_group_department_id="<?php echo $fuser_info[0]->department_id;?>" data-toggle="modal" data-target=".chatbox-department-group">
            <a href="#"><?php echo $this->lang->line('left_department');?> (<?php echo $_department_name;?>)</a>
            </button>
            </li>
            <li>
            <button href="#" class="list-group-item list-group-item-action media no-border" id="set_location-groupbox_<?php echo $fuser_info[0]->location_id;?>" data-from-id="<?php echo $session['user_id'];?>" data-chat_group_location_id="<?php echo $fuser_info[0]->location_id;?>" data-toggle="modal" data-target=".chatbox-location-group">
            <a href="#"><?php echo $this->lang->line('left_location');?> (<?php echo $location_name;?>)</a>
            </button>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
    </div>
  </div>
</div>
<div class="row">   
<div class="col-lg-4 col-md-12">        
    <div class="box">
      <?php $f_name = $fuser_info[0]->first_name.' '.$fuser_info[0]->last_name;?>
      <div class="box-header with-border">
          <h3 class="box-title"><?php echo $this->lang->line('xin_privatechat_title');?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <div class="box-header" style="">
        <ul class="control-sidebar-menu" style="margin: 0 0px;">
          <li>
            <h4 class="control-sidebar-subheading"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo $f_name;?> <span class="caret"></span></a> <span class="pull-right"><span class="list-group-item-text text-muted" id="hr_status"><?php echo $status_title;?></span></span>
              <ul class="dropdown-menu animated flipInY" role="menu">
                <li><a class="dropdown-item online-status" href="#" data-status-id="1" data-status-title="<?php echo $this->lang->line('xin_iamavailable_title');?>" data-avatar-status="avatar-online"><?php echo $this->lang->line('xin_available_title');?></a></li>
                <li><a class="dropdown-item online-status" href="#" data-status-id="2" data-status-title="<?php echo $this->lang->line('xin_iamaway_title');?>" data-avatar-status="avatar-away"><?php echo $this->lang->line('xin_away_title');?></a></li>
                <li><a class="dropdown-item online-status" href="#" data-status-id="3" data-status-title="<?php echo $this->lang->line('xin_iambusy_title');?>" data-avatar-status="avatar-busy"><?php echo $this->lang->line('xin_busy_title');?></a></li>
              </ul>
            </h4>
            <div class="progress progress-xxs">
              <div class="" style="width: 40%"></div>
            </div>
          </li>
        </ul>
      </div>
      <div class="box-body p-0">
        <div id="chat-contact">
          <ul class="control-sidebar-menu" id="chat_users">
          	<?php
			if($fuser_info[0]->user_role_id==1){
            	$all_active_employees = $this->Xin_model->all_active_employees();
			} else {
				$all_active_employees = $this->Xin_model->all_active_departments_employees();
			}
			?>
            <?php foreach($all_active_employees as $active_employees):?>
            <?php if($active_employees->user_id!=$session['user_id']):?>
            <?php if ($active_employees->is_logged_in == 0):?>
            <?php $bgm = 'avatar-away';?>
            <?php else:
				if($active_employees->online_status==1):
					$bgm = 'avatar-online';
				elseif($active_employees->online_status==3):
					$bgm = 'avatar-busy';
				else:
					$bgm = 'avatar-away';
				endif;	
			?>
            <?php endif;?>
            <li class="avatfar avatar-md <?php echo $bgm;?>">
              <button href="#" class="list-group-item list-group-item-action media no-border" id="set_box_<?php echo $active_employees->user_id;?>" data-from-id="<?php echo $session['user_id'];?>" data-to-id="<?php echo $active_employees->user_id;?>" data-toggle="modal" data-target=".chatbox-single">
              <a href="#">
              <?php  if($active_employees->profile_picture!='' && $active_employees->profile_picture!='no file') {?>
              <img class="direct-chat-img" src="<?php  echo base_url().'uploads/profile/'.$active_employees->profile_picture;?>" alt=""> <i></i> </span>
              <?php } else {?>
              <?php  if($active_employees->gender=='Male') { ?>
              <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
              <?php } else { ?>
              <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
              <?php } ?>
              <img class="direct-chat-img" src="<?php  echo $de_file;?>" alt=""> <i></i> </span>
              <?php  } ?>
              <?php $fname = $active_employees->first_name.' '.$active_employees->last_name;?>
              <?php $unread_msgs = $this->Chat_model->get_unread_message($active_employees->user_id,$session['user_id']);?>
              <?php $last_chat = $this->Chat_model->last_user_message($active_employees->user_id,$session['user_id']);?>
              <?php 
				if(!is_null($last_chat)){
					$last_chat_date = $this->Chat_model->timeAgo($last_chat[0]->message_date);
					$message_content = $last_chat[0]->message_content;
				} else {
					$last_chat_date = '--';
					$message_content = 'No Message.';
				}
				?>
              <div class="menu-info">
                <h4 class="control-sidebar-subheading"><?php echo $fname;?> <span class="label text-green pull-right" style="margin-right: 10px;"><?php echo $last_chat_date;?></span></h4>
                <p><?php echo substr($message_content,0,8).'...';?>
                  <?php
                    if($unread_msgs > 0) { ?>
                  <span class="badge bg-aqua pull-right"> <?php echo $unread_msgs;?></span>
                  <?php } else {
                    }
                  ?>
                  </span> </p>
              </div>
              </a>
              </button>
            </li>
            <?php endif;?>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- /. box --> 
  <!-- /.col -->
  <div class="col-lg-8 col-md-12">
    <div class="box box-solid"> 
      <!-- /.box-header -->
      <div class="box-body">
        <div class="mb-1" style="margin-top: 30px;">
          <?php $f_name = $fuser_info[0]->first_name.' '.$fuser_info[0]->last_name;?>
          <h4 class="">Welcome To <?php echo $company[0]->company_name;?> Chat Application</h4>
          <p>&nbsp;</p>
          <p><?php echo $company[0]->company_name;?> Chat Application is quite hot and easy-to-use for internal communication, at the moment it offers only private messages.</p>
          <p>To get started, select a user from the left tab.</p>
          <p>Chat immediately as you start your work day. You can use private messages for direct, one-on-one communication</p>
        </div>
      </div>
      <!-- /.box-body --> 
    </div>
    <!-- /.box-body --> 
  </div>
  <!-- /. box --> 
</div>
<div class="modal fade text-xs-left chatbox-location-group" id="chatbox-location-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="chatgroup_location_modal"> </div>
  </div>
</div>
<div class="modal fade text-xs-left chatbox-department-group" id="chatbox-department-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="chatgroup_department_modal"> </div>
  </div>
</div>
<div class="modal fade text-xs-left chatbox-single" id="chatbox-single" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" style="display: none;" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="chat_modal"> </div>
  </div>
</div>
