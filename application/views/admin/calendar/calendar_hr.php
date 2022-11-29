<?php 
$session = $this->session->userdata('username');
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-3">
        <div class="box">
          <div class="box-body">
            <div class="box-header with-border">
              <h3 class="box-title"> <?php echo $this->lang->line('xin_hr_draggable_options');?> </h3>
            </div>
            <input type="hidden" id="exact_date" value="" />
              <div class="list-group" id="list_group">
              <?php if(in_array('8',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-green hrsale-drag-option" data-record="0"> <i class="fa fa-space-shuttle"></i> <?php echo $this->lang->line('left_holidays');?></span>
              <?php } ?>
              <?php if(in_array('46',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-aqua hrsale-drag-option" data-record="1"> <i class="fa fa-envelope"></i> <?php echo $this->lang->line('xin_hr_calendar_lv_request');?></span>
              <?php } ?>
              <?php if($system[0]->module_travel=='true'){?>
              <?php if(in_array('17',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-light-blue hrsale-drag-option" data-record="2"> <i class="fa fa-plane"></i> <?php echo $this->lang->line('xin_hr_calendar_trvl_request');?></span>
              <?php } ?>
              <?php } ?>
              <?php if($system[0]->module_training=='true'){?>
              <?php if(in_array('54',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-yellow hrsale-drag-option" data-record="3"> <i class="fa fa-graduation-cap"></i> <?php echo $this->lang->line('xin_hr_calendar_tranings');?></span>
              <?php } ?>
              <?php } ?>
              <?php if($system[0]->module_projects_tasks=='true'){?>
              <?php if(in_array('44',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-purple hrsale-drag-option" data-record="4"> <i class="fa fa-pencil-square"></i> <?php echo $this->lang->line('left_projects');?></span>
              <?php } ?>
              <?php if(in_array('45',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-maroon hrsale-drag-option" data-record="5"> <i class="fa fa-tasks"></i> <?php echo $this->lang->line('left_tasks');?></span>
              <?php } ?>
              <?php } ?>
              <?php if($system[0]->module_events=='true'){?>
              <?php if(in_array('98',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-navy hrsale-drag-option" data-record="6"> <i class="fa fa-calendar-plus-o"></i> <?php echo $this->lang->line('xin_hr_events');?></span>
              <?php } ?>
              <?php if(in_array('99',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-teal hrsale-drag-option" data-record="7"> <i class="fa fa-calendar-check-o"></i> <?php echo $this->lang->line('xin_hr_meetings');?></span>
              <?php } ?>
              <?php } ?>
              <?php if($system[0]->module_goal_tracking=='true'){?>
              <?php if(in_array('107',$role_resources_ids)) { ?>
              <span class="list-group-item calendar-options text-light-blue hrsale-drag-option" data-record="8"> <i class="fa fa-trophy"></i> <?php echo $this->lang->line('xin_hr_goals_title');?></span>
              <?php } ?>
              <?php } ?>
              <span class="list-group-item calendar-options text-red"> <i class="fa fa-gift"></i> <?php echo $this->lang->line('xin_hr_calendar_upc_birthday');?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="box">
          <div class="box-body">
            <div id='calendar_hr'></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
