<?php 
$session = $this->session->userdata('username');
$user_info = $this->Exin_model->read_user_info($session['user_id']);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);
if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
	$lde_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
} else { 
	if($user_info[0]->gender=='Male') {  
		$lde_file = base_url().'uploads/profile/default_male.jpg'; 
	} else {  
		$lde_file = base_url().'uploads/profile/default_female.jpg';
	}
}
$last_login =  new DateTime($user_info[0]->last_login_date);
// get designation
$designation = $this->Designation_model->read_designation_information($user_info[0]->designation_id);
if(!is_null($designation)){
	$designation_name = $designation[0]->designation_name;
} else {
	$designation_name = '--';	
}
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $announcement = $this->Announcement_model->get_new_announcements();?>
<?php  if($user[0]->profile_picture!='' && $user[0]->profile_picture!='no file') {?>
<?php $profile_pic = base_url().'uploads/profile/'.$user[0]->profile_picture;?>
<?php } else {?>
<?php  if($user[0]->gender=='Male') { ?>
<?php 	$profile_pic = base_url().'uploads/profile/default_male.jpg';?>
<?php } else { ?>
<?php 	$profile_pic = base_url().'uploads/profile/default_female.jpg';?>
<?php } ?>
<?php  } ?>
<?php foreach($announcement as $new_announcement):?>
<?php
	$current_date = strtotime(date('Y-m-d'));
	$announcement_end_date = strtotime($new_announcement->end_date);
	if($current_date <= $announcement_end_date) {
?>
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> <?php echo $new_announcement->title;?>:</h4>
    <?php echo $new_announcement->summary;?> <a href="#" class="alert-link" data-toggle="modal" data-target=".view-modal-annoucement" data-announcement_id="<?php echo $new_announcement->announcement_id;?>"><?php echo $this->lang->line('xin_view');?></a>
  </div>
<?php } ?>
<?php endforeach;?>
<div class="box-widget widget-user-2">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header">
      <div class="widget-user-image">
        <img src="<?php  echo $profile_pic;?>" alt="" id="user_avatar" class="img-circle ui-w-50 rounded-circle">
      </div>
      <h4 class="widget-user-username welcome-hrsale-user">Welcome back, <?php echo $user[0]->first_name.' '.$user[0]->last_name;?>!</h4>
      <h5 class="widget-user-desc welcome-hrsale-user-text">Today is <?php echo date('l, j F Y');?></h5>
    </div>
  </div>
  
  <div class="row">
<div class="col-md-4">
          <!-- Attendance -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <i class="fa fa-user d-block" style="font-size: 4rem; line-height: 1.1; position: absolute; top: 2%; left: 157px; margin-bottom: 13px;"></i>
              <h3 class="profile-username text-center" style="font-size: 21px; margin-top: 45px;"><?php echo $this->lang->line('xin_mark_attendance');?></h3>

              <hr />
              <div>
              <?php
				$att_date =  date('d-M-Y');
				$attendance_date = date('d-M-Y');
				// get office shift for employee
				$get_day = strtotime($att_date);
				$day = date('l', $get_day);
				$strtotime = strtotime($attendance_date);
				$new_date = date('d-M-Y', $strtotime);
				// office shift
				$u_shift = $this->Timesheet_model->read_office_shift_information($user_info[0]->office_shift_id);
				
				// get clock in/clock out of each employee
				if($day == 'Monday') {
					if($u_shift[0]->monday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_monday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->monday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->monday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Tuesday') {
					if($u_shift[0]->tuesday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_tuesday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->tuesday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->tuesday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Wednesday') {
					if($u_shift[0]->wednesday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_wednesday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->wednesday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->wednesday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Thursday') {
					if($u_shift[0]->thursday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_thursday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->thursday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->thursday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Friday') {
					if($u_shift[0]->friday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_friday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->friday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->friday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Saturday') {
					if($u_shift[0]->saturday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_saturday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->saturday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->saturday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				} else if($day == 'Sunday') {
					if($u_shift[0]->sunday_in_time==''){
						$office_shift = $this->lang->line('dashboard_today_sunday_shift');
					} else {
						$in_time =  new DateTime($u_shift[0]->sunday_in_time. ' ' .$attendance_date);
						$out_time =  new DateTime($u_shift[0]->sunday_out_time. ' ' .$attendance_date);
						$clock_in = $in_time->format('h:i a');
						$clock_out = $out_time->format('h:i a');
						$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
					}
				}
			  ?>
              <?php $sys_arr = explode(',',$system[0]->system_ip_address); ?>
              <div class="text-xs-center">
                <div class="text-xs-center pb-0-5">
                  <?php $attributes = array('name' => 'set_clocking', 'id' => 'set_clocking', 'autocomplete' => 'off', 'class' => 'form');?>
                  <?php $hidden = array('exuser_id' => $session['user_id']);?>
                  <?php echo form_open('admin/timesheet/set_clocking', $attributes, $hidden);?>
                  <input type="hidden" name="timeshseet" value="<?php echo $user_info[0]->user_id;?>">
                  <?php $attendances = $this->Timesheet_model->attendance_time_checks($user_info[0]->user_id); $dat = $attendances->result();?>
                  <?php if($attendances->num_rows() < 1) {?>
                  <input type="hidden" value="clock_in" name="clock_state" id="clock_state">
                  <input type="hidden" value="" name="time_id" id="time_id">
                  <button class="btn btn-primary btn-block text-uppercase" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('dashboard_clock_in');?></button>
                  <?php } else {?>
                  <input type="hidden" value="clock_out" name="clock_state" id="clock_state">
                  <input type="hidden" value="<?php echo $dat[0]->time_attendance_id;?>" name="time_id" id="time_id">
                  <button class="btn btn-warning btn-block text-uppercase" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-left"></i> <?php echo $this->lang->line('dashboard_clock_out');?></button>
                  <?php } ?>
                  <?php echo form_close(); ?> </div>
              </div>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    <div class="d-flex col-md-8 align-items-stretch">
         <?php if($system[0]->module_awards=='true'){?>
			 <?php if(in_array('14',$role_resources_ids)) { ?>
             <div class="col-md-4 col-sm-6 col-xs-12 box-footer text-black">
              <div class="clearfix">
                <span class="pull-left"><i class="fa fa-trophy text-light-blue dasboard-icon"></i> <span class="hrsale-font-dash"><a href="<?php echo site_url('admin/awards');?>"><?php echo $this->Exin_model->total_employee_awards_dash();?> <?php echo $this->lang->line('left_awards');?></a></span></span>
              </div>
            </div>
            <?php } ?>
        <?php } else {?>
        <?php if(in_array('29',$role_resources_ids)) { ?>
        <div class="col-md-4 col-sm-6 col-xs-12 box-footer text-black">
          <div class="clearfix">
            <span class="pull-left"><i class="fa fa-calendar-check-o text-light-blue dasboard-icon"></i> <span class="hrsale-font-dash"><a href="<?php echo site_url('admin/timesheet/attendance');?>"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('dashboard_attendance');?></a></span></span>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
        <?php if(in_array('10',$role_resources_ids)) { ?>
        <div class="col-md-4 col-sm-6 col-xs-12 box-footer text-black">
          <div class="clearfix">
            <span class="pull-left"><i class="fa fa-dollar text-light-blue dasboard-icon"></i> <span class="hrsale-font-dash"><a href="<?php echo site_url('admin/expense');?>">
            <?php echo $this->Exin_model->total_employee_expense_dash();?> <?php echo $this->lang->line('xin_expense');?></a></span></span>
          </div>
        </div>
        <?php } ?>
        <?php if(in_array('43',$role_resources_ids)) { ?>
        <div class="col-md-4 col-sm-6 col-xs-12 box-footer">
          <div class="clearfix">
            <span class="pull-left"><i class="fa fa-tags text-light-blue dasboard-icon"></i> <span class="hrsale-font-dash"><a href="<?php echo site_url('admin/tickets');?>"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('left_tickets');?></a></span></span>
          </div>
        </div>
        <?php } ?>
        <?php if(in_array('46',$role_resources_ids)) { ?>
        <div class="col-md-6 col-sm-6 col-xs-12 box-footer text-black">
          <div class="clearfix">
            <span class="pull-left"><i class="fa fa-calendar text-light-blue dasboard-icon"></i> <span class="hrsale-font-dash"><a href="<?php echo site_url('admin/timesheet/leave');?>"><?php echo $this->lang->line('left_leave');?> <?php echo $this->lang->line('xin_performance_management');?></a></span></span>
          </div>
        </div>
        <?php } ?>
        <?php if($system[0]->module_travel=='true'){?>
			<?php if(in_array('17',$role_resources_ids)) { ?>
            <div class="col-md-6 col-sm-6 col-xs-12 box-footer">
              <div class="clearfix">
                <span class="pull-left"><i class="fa fa-plane text-light-blue dasboard-icon"></i> <span class="hrsale-font-dash"><a href="<?php echo site_url('admin/travel');?>"><?php echo $this->lang->line('xin_travel');?> <?php echo $this->lang->line('xin_requests');?></a></span></span>
              </div>
            </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<hr class="container-m--x mt-0 mb-4">
<?php if($system[0]->module_projects_tasks=='true'){?>
<div class="row">
<?php if(in_array('44',$role_resources_ids)) { ?>
  <div class="col-md-8">
  <div class="box">
    <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('dashboard_my_projects');?> </h3>
  </div>
    <div id="project-scrollbar" class="ps ps--active-y hrsale-proj-style"> 
      <!-- Tasks -->
      <?php $project = $this->Project_model->get_projects();?>
      <?php $dId = array(); $i=1; foreach($project->result() as $pj):
     // $aw_name = $hrm->e_award_type($emp_award->award_type_id);
     $asd = array($pj->assigned_to);
     $aim = explode(',',$pj->assigned_to);
     foreach($aim as $dIds) {
         if($session['user_id'] === $dIds) {
            $dId[] = $session['user_id'];
        // priority
        if($pj->priority == 1) {
            $priority = '<span class="label label-danger">'.$this->lang->line('xin_highest').'</span>';
        } else if($pj->priority ==2){
            $priority = '<span class="label label-danger">'.$this->lang->line('xin_high').'</span>';
        } else if($pj->priority ==3){
            $priority = '<span class="label label-primary">'.$this->lang->line('xin_normal').'</span>';
        } else {
            $priority = '<span class="label label-success">'.$this->lang->line('xin_low').'</span>';
        }
		$pdate = '<i class="fa fa-calendar position-left"></i> '.$this->Xin_model->set_date_format($pj->end_date);
        ?>
      <div class="card pb-4 mb-2 hrsale-dash-prj">
        <div class="row no-gutters align-items-center">
          <div class="col-12 col-md-4 px-4 pt-4"> <a href="<?php echo site_url();?>admin/project/detail/<?php echo $pj->project_id;?>/" class="text-dark-hr font-weight-semibold"><?php echo $pj->title;?></a> <br>
            <small class="text-muted"><?php echo $pj->summary;?></small> </div>
          <div class="col-4 col-md-2 text-muted small px-4 pt-4"> <?php echo $priority;?> </div>
          <div class="col-4 col-md-3 text-muted small px-4 pt-4"> <?php echo $pdate;?> </div>
          <div class="col-4 col-md-3 px-4 pt-4">
            <div class="text-right text-muted small"><?php echo $pj->project_progress;?>%</div>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar" style="width: <?php echo $pj->project_progress;?>%;"></div>
            </div>
          </div>
        </div>
      </div>
      <?php }
		} ?>
      <?php $i++; endforeach;?>
    </div>
    </div>
  </div>
  <?php } ?>
  <?php if(in_array('45',$role_resources_ids)) { ?>
  <div class="col-md-4">
    <div class="box">
    <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('dashboard_my_tasks');?> </h3>
  </div>
    <div class="card mb-4">
      <ul id="tasks-scrollbar" class="list-group list-group-flush ps ps--active-y" style="height: 300px">
        <?php $task = $this->Timesheet_model->get_tasks();?>
        <?php $dId = array(); $i=1; $ct_tasks = 0;
		$ovt_tasks = 0; $tot_tasks=0; foreach($task->result() as $et):
		 // $aw_name = $hrm->e_award_type($emp_award->award_type_id);
		 $asd = array($et->assigned_to);
		 $aim = explode(',',$et->assigned_to);
		 foreach($aim as $dIds) {
			 if($session['user_id'] === $dIds) {
				$dId[] = $session['user_id'];
			// task end date		
			//$tdate = $this->Xin_model->set_date_format($et->end_date);
			// task progress
			if($et->task_progress <= 20) {
				$progress_class = 'progress-danger';
				$tag_class = 'label label-danger';
			} else if($et->task_progress > 20 && $et->task_progress <= 50){
				$progress_class = 'progress-warning';
				$tag_class = 'label label-warning';
			} else if($et->task_progress > 50 && $et->task_progress <= 75){
				$progress_class = 'progress-info';
				$tag_class = 'label label-info';
			} else {
				$progress_class = 'progress-success';
				$tag_class = 'label label-success';
			}
			 
			// project progress
			if($et->task_status == 0) {
				$status = $this->lang->line('xin_not_started');
			} else if($et->task_status ==1){
				$status = $this->lang->line('xin_in_progress');
			} else if($et->task_status ==2){
				$status = $this->lang->line('xin_completed');
			} else {
				$status = $this->lang->line('xin_deffered');
			}
			
			$pdate = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($et->end_date);
		
			?>
        <li class="list-group-item employee-list-tasks py-3">
          <div class="<?php echo $tag_class;?> float-right"><?php echo $status;?></div>
          <div class="font-weight-semibold"> <a href="<?php echo site_url('admin/timesheet/task_details/id/').$et->task_id.'/';?>"> <?php echo $et->task_name;?></a></div>
          <small class="text-muted"><?php echo $pdate;?></small> </li>
        <?php }
							} ?>
        <?php $i++; endforeach;?>
      </ul>
    </div>
  </div>
</div>
<?php } ?>
</div>
<?php } ?>
<hr class="container-m--x mt-0 mb-4">
<?php //$this->load->view('admin/calendar/calendar_employee');?>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
<?php $this->load->view('admin/calendar/calendar_hr');?>
<?php endif; ?>
<style type="text/css">
.d-flex {
    display: table-footer-group !important;
}</style>
