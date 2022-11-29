<?php 
$session = $this->session->userdata('username');
$user_info = $this->Exin_model->read_user_info($session['user_id']);
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
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $announcement = $this->Announcement_model->get_new_announcements();?>
<?php foreach($announcement as $new_announcement):?>
<?php
	$current_date = strtotime(date('Y-m-d'));
	$announcement_end_date = strtotime($new_announcement->end_date);
	if($current_date <= $announcement_end_date) {
?>

<div class="alert alert-success alert-dismissible fade in mb-1" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <strong><?php echo $new_announcement->title;?>:</strong> <?php echo $new_announcement->summary;?> <a href="#" class="alert-link" data-toggle="modal" data-target=".view-modal-annoucement" data-announcement_id="<?php echo $new_announcement->announcement_id;?>"><?php echo $this->lang->line('xin_view');?></a> </div>
<?php } ?>
<?php endforeach;?>
<div class="row <?php echo $get_animate;?>">
<?php if(in_array('14',$role_resources_ids)) { ?>
  <?php if($system[0]->module_awards=='true'){?>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/awards/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-primary"><i class="fa fa-trophy"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Exin_model->total_employee_awards_dash();?> <?php echo $this->lang->line('left_awards');?></span> <span class="info-box-text"><span class=""> <?php echo $this->lang->line('xin_view');?> </span></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <?php } else {?>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/timesheet/attendance/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-primary"><i class="fa fa-clock-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('dashboard_attendance');?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_view');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <?php } ?>
  <?php } ?>
  <?php if(in_array('37',$role_resources_ids)) { ?>
  <!-- /.col -->
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/payroll/payment_history/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('left_payslips');?> <?php echo $this->lang->line('xin_view');?></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <!-- /.col --> 
  <?php } ?>
  <!-- fix for small devices only -->
  <?php if(in_array('46',$role_resources_ids)) { ?>
  <div class="clearfix visible-sm-block"></div>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/timesheet/leave/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-purple"><i class="fa fa-calendar"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_performance_management');?> <?php echo $this->lang->line('left_leave');?></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <?php } ?>
  <?php if($system[0]->module_travel=='true'){?>
  <!-- /.col -->
  <?php if(in_array('17',$role_resources_ids)) { ?>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/travel/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-plane"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_travel');?> <?php echo $this->lang->line('xin_requests');?></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>  
  <?php } ?>
  <!-- /.col -->
  <?php } ?>
</div>
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
<?php $attendances = $this->Timesheet_model->attendance_time_checks($user_info[0]->user_id); $dat = $attendances->result();?>
<?php
$bgatt = 'bg-success';
if($attendances->num_rows() < 1) {
	$bgatt = 'bg-success';
} else {
	$bgatt = 'bg-danger';
}
?>
<div class="row <?php echo $get_animate;?>">
  <div class="col-md-4">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab"><?php echo $this->lang->line('xin_attendance_mark_attendance');?></a></li>
        <li><a href="#tab_2" data-toggle="tab"><?php echo $this->lang->line('xin_attendance_overview_this_month');?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="box-widget widget-user"> 
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header <?php echo $bgatt;?> bg-darken-2">
              <h3 class="widget-user-username"><?php echo $user_info[0]->first_name. ' ' .$user_info[0]->last_name;?> </h3>
              <h5 class="widget-user-desc"><?php echo $designation_name;?></h5>
            </div>
            <div class="widget-user-image"> <img class="img-circle" src="<?php echo $lde_file;?>" alt="User Avatar"> </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-12">
                  <div class="description-block">
                    <p class="text-muted pb-0-5"><?php echo $this->lang->line('dashboard_last_login');?>: <?php echo $this->Xin_model->set_date_format($user_info[0]->last_login_date).' '.$last_login->format('h:i a');?></p>
                    <p class="text-muted pb-0-5"><?php echo $office_shift;?></p>
                  </div>
                  <!-- /.description-block --> 
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="text-xs-center">
                    <div class="text-xs-center pb-0-5">
                      <?php $attributes = array('name' => 'set_clocking', 'id' => 'set_clocking', 'autocomplete' => 'off', 'class' => 'form');?>
                      <?php $hidden = array('exuser_id' => $session['user_id']);?>
                      <?php echo form_open('admin/timesheet/set_clocking', $attributes, $hidden);?>
                      <input type="hidden" name="timeshseet" value="<?php echo $user_info[0]->user_id;?>">
                      <?php if($attendances->num_rows() < 1) {?>
                      <input type="hidden" value="clock_in" name="clock_state" id="clock_state">
                      <input type="hidden" value="" name="time_id" id="time_id">
                      <div class="row">
                        <div class="col-md-6">
                          <button class="btn btn-success btn-block text-uppercase" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('dashboard_clock_in');?></button>
                        </div>
                        <div class="col-md-6">
                          <button class="btn btn-danger btn-block text-uppercase" disabled="disabled" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-left"></i> <?php echo $this->lang->line('dashboard_clock_out');?></button>
                        </div>
                      </div>
                      <?php } else {?>
                      <input type="hidden" value="clock_out" name="clock_state" id="clock_state">
                      <input type="hidden" value="<?php echo $dat[0]->time_attendance_id;?>" name="time_id" id="time_id">
                      <div class="row">
                        <div class="col-md-6">
                          <button class="btn btn-success btn-block text-uppercase" disabled="disabled" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('dashboard_clock_in');?></button>
                        </div>
                        <div class="col-md-6">
                          <button class="btn btn-danger btn-block text-uppercase" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-left"></i> <?php echo $this->lang->line('dashboard_clock_out');?></button>
                        </div>
                      </div>
                      <?php } ?>
                      <?php echo form_close(); ?> </div>
                  </div>
                </div>
              </div>
              <?php if(in_array('10',$role_resources_ids)) { ?>
              <div class="row">
                <div class="col-md-12 col-md-offset-1">
                  <div class="margin">
                    <div class="btn-group"> <a type="button" href="<?php echo site_url('admin/timesheet/');?>" class="btn btn-default btn-flat">My Attendance Timesheet</a> </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <!-- /.row --> 
          </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
          <?php
                $date = strtotime(date("Y-m-d"));
                $day = date('d', $date);
                $month = date('m', $date);
                $year = date('Y', $date);
				// total days in month
				$daysInMonth = cal_days_in_month(0, $month, $year);
				$imonth = date('F', $date);
				$r = $this->Xin_model->read_user_info($session['user_id']);
				$pcount = 0;
				$acount = 0;
				$lcount = 0;
				for($i = 1; $i <= $daysInMonth; $i++):
					$i = str_pad($i, 2, 0, STR_PAD_LEFT);
					// get date <
					$attendance_date = $year.'-'.$month.'-'.$i;
					$get_day = strtotime($attendance_date);
					$day = date('l', $get_day);
					$user_id = $r[0]->user_id;
					$office_shift_id = $r[0]->office_shift_id;
					$attendance_status = '';
					// get holiday
					$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
					$holiday_arr = array();
					if($h_date_chck->num_rows() == 1){
						$h_date = $this->Timesheet_model->holiday_date($attendance_date);
						$begin = new DateTime( $h_date[0]->start_date );
						$end = new DateTime( $h_date[0]->end_date);
						$end = $end->modify( '+1 day' ); 
						
						$interval = new DateInterval('P1D');
						$daterange = new DatePeriod($begin, $interval ,$end);
						
						foreach($daterange as $date){
							$holiday_arr[] =  $date->format("Y-m-d");
						}
					} else {
						$holiday_arr[] = '99-99-99';
					}
					// get leave/employee
					$leave_date_chck = $this->Timesheet_model->leave_date_check($user_id,$attendance_date);
					$leave_arr = array();
					if($leave_date_chck->num_rows() == 1){
						$leave_date = $this->Timesheet_model->leave_date($user_id,$attendance_date);
						$begin1 = new DateTime( $leave_date[0]->from_date );
						$end1 = new DateTime( $leave_date[0]->to_date);
						$end1 = $end1->modify( '+1 day' ); 
						
						$interval1 = new DateInterval('P1D');
						$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
						
						foreach($daterange1 as $date1){
							$leave_arr[] =  $date1->format("Y-m-d");
						}	
					} else {
						$leave_arr[] = '99-99-99';
					}
					$office_shift = $this->Timesheet_model->read_office_shift_information($office_shift_id);
					$check = $this->Timesheet_model->attendance_first_in_check($user_id,$attendance_date);
					// get holiday>events
					if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
						$status = 'H';	
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
						$status = 'H';
						$pcount += 0;
						//$acount -= 1;
					} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
						$status = 'H';
						$pcount += 0;
						//$acount -= 1;
					} else if(in_array($attendance_date,$holiday_arr)) { // holiday
						$status = 'H';
						$pcount += 0;
						//$acount += 0;
					} else if(in_array($attendance_date,$leave_arr)) { // on leave
						$status = 'L';
						$pcount += 0;
						$lcount += 1;
					//	$acount += 0;
					} else if($check->num_rows() > 0){
						$pcount += 1;
						//$acount -= 1;
					}	else {
						$status = 'A';
						//$acount += 1;
						$pcount += 0;
						// set to present date
						$iattendance_date = strtotime($attendance_date);
						$icurrent_date = strtotime(date('Y-m-d'));
						if($iattendance_date <= $icurrent_date){
							$acount += 1;
						} else {
							$acount += 0;
						}
					}
				endfor;
                ?>
          <div class="">
            <div class="box-body">
              <div class="table-responsive" data-pattern="priority-columns">
                <table class="table table-striped m-md-b-0">
                  <tbody>
                    <tr>
                      <th scope="row" colspan="2" style="text-align: center;"><?php echo $this->lang->line('xin_attendance_this_month');?></th>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_attendance_total_present');?></th>
                      <td class="text-right"><?php echo $pcount;?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_attendance_total_absent');?></th>
                      <td class="text-right"><?php echo $acount;?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_attendance_total_leave');?></th>
                      <td class="text-right"><?php echo $lcount;?></td>
                    </tr>
                    <?php if(in_array('261',$role_resources_ids)) { ?>
                    <tr>
                      <th scope="row" colspan="2" style="text-align: center;"><a href="<?php echo site_url('admin/timesheet/timecalendar/');?>"><?php echo $this->lang->line('xin_attendance_cal_view');?></a></th>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.tab-pane --> 
      </div>
      <!-- /.tab-content --> 
    </div>
    <!-- Widget: user widget style 1 --> 
  </div>
  <!-- /.widget-user -->
  <?php if(in_array('45',$role_resources_ids)) { ?>
  <?php //if($system[0]->module_projects_tasks=='true'){?>
  <div class="col-xl-8 col-lg-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_my_tasks');?></h3>
      </div>
      <div class="box-body">
        <div class="table-responsive height-200">
          <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_end_date');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
              </tr>
            </thead>
            <tbody>
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
					$tdate = $this->Xin_model->set_date_format($et->end_date);
					// task progress
					if($et->task_progress <= 20) {
						$progress_class = 'progress-danger';
						$tag_class = 'tag-danger';
					} else if($et->task_progress > 20 && $et->task_progress <= 50){
						$progress_class = 'progress-warning';
						$tag_class = 'tag-warning';
					} else if($et->task_progress > 50 && $et->task_progress <= 75){
						$progress_class = 'progress-info';
						$tag_class = 'tag-info';
					} else {
						$progress_class = 'progress-success';
						$tag_class = 'tag-success';
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
					// task project
					$prj_task = $this->Project_model->read_project_information($et->project_id);
					if(!is_null($prj_task)){
						$prj_name = $prj_task[0]->title;
					} else {
						$prj_name = '--';
					}
					
					// tasks completed
					$c_task = $this->Exin_model->get_completed_tasks($et->task_id);
					$ct_tasks += $c_task;
					// tasks overdue
					$ov_task = $this->Exin_model->get_overdue_tasks($et->task_id);
					$ovt_tasks += $ov_task;
					// todo tasks
					$tod_task = $this->Exin_model->get_todo_tasks($et->task_id);
					$tot_tasks += $tod_task;
					?>
              <tr>
                <td><?php echo '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/task_details/id/'.$et->task_id.'/"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="fa fa-arrow-circle-right"></i></button></a></span>';?></td>
                <td class="text-truncate"><?php echo $et->task_name;?><br />
                  <a href="<?php echo site_url();?>admin/project/detail/<?php echo $et->project_id;?>/"><?php echo $prj_name;?></a></td>
                <td class="text-truncate"><i class="fa fa-calendar position-left"></i> <?php echo $tdate;?></td>
                <td class="text-truncate"><span class="tag tag-default <?php echo $tag_class;?>"><?php echo $status;?></span></td>
                <td class="text-truncate"><p class="m-b-0-5"><?php echo $this->lang->line('dashboard_completed');?> <span class="pull-xs-right"> <?php echo $et->task_progress;?>%</span></p>
                  <progress class="progress <?php echo $progress_class;?> progress-sm d-inline-block mb-0" value="<?php echo $et->task_progress;?>" max="100"><?php echo $et->task_progress;?>%</progress></td>
              </tr>
              <?php }
							} ?>
              <?php $i++; endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php //} ?>
  <?php } else {?>
  <div class="col-xl-4 col-lg-4">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_personal_details');?></h3>
      </div>
      <div class="box-body px-1">
        <div id="recent-buyers" class="list-group scrollable-container height-350 position-relative">
          <div class="table-responsive" data-pattern="priority-columns">
            <table width="" class="table table-striped m-md-b-0">
              <tbody>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_fullname');?></th>
                  <td><?php echo $first_name.' '.$last_name;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_employee_id');?></th>
                  <td><?php echo $employee_id;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_username');?></th>
                  <td><?php echo $username;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_email');?></th>
                  <td><?php echo $email;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_designation');?></th>
                  <td><?php echo $designation_name;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('left_department');?></th>
                  <td><?php echo $department_name;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_dob');?></th>
                  <td><?php echo $this->Xin_model->set_date_format($date_of_birth);?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-4">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_recruitment');?> <?php echo $this->lang->line('dashboard_timeline');?></h3>
      </div>
      <div class="box-body px-1">
        <div id="recent-buyers" class="list-group scrollable-container height-350 position-relative">
          <?php foreach($all_jobs as $job):?>
          <?php $jtype = $this->Job_post_model->read_job_type_information($job->job_type); ?>
          <?php
			if(!is_null($jtype)){
				$jt_type = $jtype[0]->type;
			} else {
				$jt_type = '--';	
			}
		  ?>
          <a href="<?php echo site_url('jobs/detail/').$job->job_url;?>" class="list-group-item list-group-item-action media no-border">
          <div class="media-body">
            <h6 class="list-group-item-heading"><?php echo $job->job_title;?> <span class="float-xs-right pt-1"><span class="tag tag-warning ml-1"><?php echo $jt_type;?></span></span></h6>
          </div>
          </a>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<!--/ Stats --> 
<?php if(in_array('44',$role_resources_ids)) { ?>
<div class="row match-height">
  <?php if($system[0]->module_projects_tasks=='true'){?>
  <div class="col-xl-8 col-lg-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_my_projects');?></h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <p><?php echo $this->lang->line('xin_my_assigned_projects');?> <span class="float-xs-right"><a href="<?php echo site_url('admin/project');?>"><?php echo $this->lang->line('xin_more_projects');?> <i class="ft-arrow-right"></i></a></span></p>
        </div>
        <div class="table-responsive" style="height:250px;">
          <table id="recent-orderss" class="table table-hover mb-0 ps-container ps-theme-default">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                <th><?php echo $this->lang->line('xin_p_priority');?></th>
                <th><?php echo $this->lang->line('dashboard_project_date');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
              </tr>
            </thead>
            <tbody>
              <?php $project = $this->Project_model->get_projects();?>
              <?php $dId = array(); $i=1; foreach($project->result() as $pj):
			 // $aw_name = $hrm->e_award_type($emp_award->award_type_id);
			 $asd = array($pj->assigned_to);
			 $aim = explode(',',$pj->assigned_to);
			 foreach($aim as $dIds) {
				 if($session['user_id'] === $dIds) {
					$dId[] = $session['user_id'];
				// project date		
				$pdate = $this->Xin_model->set_date_format($pj->end_date);
				// project progress
				if($pj->project_progress <= 20) {
					$progress_class = 'progress-danger';
				} else if($pj->project_progress > 20 && $pj->project_progress <= 50){
					$progress_class = 'progress-warning';
				} else if($pj->project_progress > 50 && $pj->project_progress <= 75){
					$progress_class = 'progress-info';
				} else {
					$progress_class = 'progress-success';
				}
				 
				// project progress
				if($pj->status == 0) {
					$status = $this->lang->line('xin_not_started');
				} else if($pj->status ==1){
					$status = $this->lang->line('xin_in_progress');
				} else if($pj->status ==2){
					$status = $this->lang->line('xin_completed');
				} else {
					$status = $this->lang->line('xin_deffered');
				}
				// priority
				if($pj->priority == 1) {
					$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_highest').'</span>';
				} else if($pj->priority ==2){
					$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_high').'</span>';
				} else if($pj->priority ==3){
					$priority = '<span class="tag tag-primary">'.$this->lang->line('xin_normal').'</span>';
				} else {
					$priority = '<span class="tag tag-success">'.$this->lang->line('xin_low').'</span>';
				}
				?>
              <tr>
                <td class="text-truncate"><a href="<?php echo site_url();?>admin/project/detail/<?php echo $pj->project_id;?>/"><?php echo $pj->title;?></a></td>
                <td class="text-truncate"><?php echo $priority;?></td>
                <td class="text-truncate"><i class="fa fa-calendar position-left"></i> <?php echo $pdate;?></td>
                <td class="text-truncate"><?php echo $status;?></td>
                <td class="text-truncate"><p class="m-b-0-5"><?php echo $this->lang->line('dashboard_completed');?> <span class="pull-xs-right"><?php echo $pj->project_progress;?>%</span></p>
                  <progress class="progress <?php echo $progress_class;?> progress-sm d-inline-block mb-0" value="<?php echo $pj->project_progress;?>" max="100"><?php echo $pj->project_progress;?>%</progress></td>
              </tr>
              <?php }
								} ?>
              <?php $i++; endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php //} else {?>
  <div class="col-xl-4 col-lg-4">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_recruitment');?> <?php echo $this->lang->line('dashboard_timeline');?></h3>
      </div>
      <div class="box-body px-1">
        <div id="recent-buyers" class="list-group scrollable-container height-300 position-relative">
          <?php foreach($all_jobs as $job):?>
          <?php $jtype = $this->Job_post_model->read_job_type_information($job->job_type); ?>
          <?php
			if(!is_null($jtype)){
				$jt_type = $jtype[0]->type;
			} else {
				$jt_type = '--';	
			}
		  ?>
          <a target="_blank" href="<?php echo site_url('jobs/detail/').$job->job_url;?>" class="list-group-item list-group-item-action media no-border">
          <div class="media-body">
            <h6 class="list-group-item-heading"><?php echo $job->job_title;?> <span class="float-xs-right pt-1"><span class="tag tag-warning ml-1"><?php echo $jt_type;?></span></span></h6>
          </div>
          </a>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php } ?>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
<?php $this->load->view('admin/calendar/calendar_hr');?>
<?php endif; ?>
<style type="text/css">
.btn-group {
	margin-top:5px !important;
}
</style>