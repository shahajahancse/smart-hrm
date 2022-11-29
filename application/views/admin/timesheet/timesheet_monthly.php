<?php
/* Monthly Timesheet view > hrsale
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_resources_ids = $this->Xin_model->user_role_resource();
$month_year = $this->input->post('month_year');
if($user_info[0]->user_role_id==1){
	$employee_id = $this->input->post('employee_id');
	$company_id = $this->input->post('company_id');
	/* Set the date */
	$date = strtotime(date("Y-m-d"));
	// get month and year
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$xin_employees = $this->Timesheet_model->get_xin_employees();
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($this->input->post('employee_id')==0){
			$xin_employees = $this->Timesheet_model->get_xin_employees();
		} else {
			$xin_employees = $this->Xin_model->read_user_info($this->input->post('employee_id'));
		}
	}
} else if(in_array('10',$role_resources_ids)) {
	$employee_id = $this->input->post('employee_id');
	$company_id = $this->input->post('company_id');
	/* Set the date */
	$date = strtotime(date("Y-m-d"));
	// get month and year
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$xin_employees = $this->Timesheet_model->get_xin_employees();
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($this->input->post('employee_id')==0){
			$xin_employees = $this->Timesheet_model->get_xin_employees();
		} else {
			$xin_employees = $this->Xin_model->read_user_info($this->input->post('employee_id'));
		}
	}
} else {
	$date = strtotime(date("Y-m-d"));
	/* Set the date */
	if(!isset($month_year)){
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$month_year = date('Y-m');
	} else {
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		$month_year = $month_year;
	}
	$xin_employees = $this->Xin_model->read_user_info($session['user_id']);
}
// total days in month
$daysInMonth = cal_days_in_month(0, $month, $year);
$imonth = date('F', $date);
?>

<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('name' => 'xin-form', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/', $attributes, $hidden);?>
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('xin_e_details_date');?></label>
              <input class="form-control d_month_year" value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo $month_year; endif;?>" name="month_year" type="text">
            </div>
          </div>
          <?php if($user_info[0]->user_role_id==1){?>
          <div class="col-md-3">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                <option value=""></option>
                <?php foreach($get_all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>" 
					<?php if(isset($employee_id)): if($company->company_id==$company->company_id): ?> selected="selected" <?php endif; endif;?>><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group" id="employee_ajax">
              <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
              <select name="employee_id" id="employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                <?php if(isset($employee_id)): ?>
                <?php $result = $this->Department_model->ajax_company_employee_info($company_id); ?>
                <option value="0">All</option>
                <?php foreach($result as $employee) {?>
                <option value="<?php echo $employee->user_id;?>" <?php if($employee->user_id==$employee_id): ?> selected="selected" <?php endif;?>> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                <?php } ?>
                <?php endif;?>
              </select>
            </div>
          </div>
          <?php } ?>
          <div class="col-md-3">
            <div class="form-group">
              <label for="first_name">&nbsp;</label>
              <br />
              <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_get'))); ?> </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_employees_monthly_timesheet');?></h3>
    <h5>For the month of
      <?php if(isset($month_year)): echo date('F Y', strtotime($month_year)); else: echo date('F Y'); endif;?>
    </h5>
    <div class="box-tools pull-right"> A: Absent, P: Present, H: Holiday, L: Leave</div>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_employee');?></th>
            <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
            <?php $i = str_pad($i, 2, 0, STR_PAD_LEFT); ?>
            <?php
			$tdate = $year.'-'.$month.'-'.$i;
			//Convert the date string into a unix timestamp.
			$unixTimestamp = strtotime($tdate);
			//Get the day of the week
			$dayOfWeek = date("D", $unixTimestamp);
			?>
            <th><strong><?php echo '<div>'.$i.' </div><span style="text-decoration:underline;">'.$dayOfWeek.'</span>';?></strong></th>
            <?php endfor; ?>
            <th width="100px"><?php echo $this->lang->line('xin_timesheet_workdays');?></th>
          </tr>
        </thead>
        <tbody>
          <?php $j=0;foreach($xin_employees as $r):?>
          <?php
		  	// user full name 
			$full_name = $r->first_name.' '.$r->last_name;
			// get designation
			$designation = $this->Designation_model->read_designation_information($r->designation_id);
			if(!is_null($designation)){
				$designation_name = $designation[0]->designation_name;
			} else {
				$designation_name = '--';	
			}
			// department
			$department = $this->Department_model->read_department_information($r->department_id);
			if(!is_null($department)){
			$department_name = $department[0]->department_name;
			} else {
			$department_name = '--';	
			}
			$department_designation = $designation_name.' ('.$department_name.')';$pcount=0;
			?>
          <?php $employee_name = $full_name.'<br><small class="text-muted"><i>'.$department_designation.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_employees_id').': '.$r->employee_id.'<i></i></i></small>';?>
          <tr>
            <td><?php echo $employee_name;?></td>
            <?php
			for($i = 1; $i <= $daysInMonth; $i++):
			$i = str_pad($i, 2, 0, STR_PAD_LEFT);
			// get date <
			$attendance_date = $year.'-'.$month.'-'.$i;
			$get_day = strtotime($attendance_date);
			$day = date('l', $get_day);
			$user_id = $r->user_id;
			// office shift
			$office_shift = $this->Timesheet_model->read_office_shift_information($r->office_shift_id);
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
			//echo '<pre>'; print_r($holiday_arr);
			// get leave/employee
			$leave_date_chck = $this->Timesheet_model->leave_date_check($r->user_id,$attendance_date);
			$leave_arr = array();
			if($leave_date_chck->num_rows() == 1){
				$leave_date = $this->Timesheet_model->leave_date($r->user_id,$attendance_date);
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
			$attendance_status = '';
			$check = $this->Timesheet_model->attendance_first_in_check($r->user_id,$attendance_date);
			if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
				$status = 'H';	
			} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
				$status = 'H';
			} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
				$status = 'H';
			} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
				$status = 'H';
			} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
				$status = 'H';
			} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
				$status = 'H';
			} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
				$status = 'H';
			} else if(in_array($attendance_date,$holiday_arr)) { // holiday
				$status = 'H';
			} else if(in_array($attendance_date,$leave_arr)) { // on leave
				$status = 'L';
			} else if($check->num_rows() > 0){
			$attendance = $this->Timesheet_model->attendance_first_in($r->user_id,$attendance_date);
			$status = 'P';//$attendance[0]->attendance_status;
				
			} else {
				
				 
				$status = 'A';
				//$pcount += 0;
			}
			$pcount += $check->num_rows();
			// set to present date
			$iattendance_date = strtotime($attendance_date);
			$icurrent_date = strtotime(date('Y-m-d'));
			if($iattendance_date <= $icurrent_date){
				$status = $status;
			} else {
				$status = '';
			}
			$idate_of_joining = strtotime($r->date_of_joining);
			if($idate_of_joining < $iattendance_date){
				$status = $status;
			} else {
				$status = '';
			}
			
			?>
            <td><?php echo $status; ?></td>
            <?php endfor; ?>
            <td><?php echo $pcount;?></td>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.box-tools {
    margin-right: -5px !important;
}
.col-md-8 {
	padding-left:0px !important;
	padding-right: 0px !important;
}
.dataTables_length {
	float:left;
}
.dt-buttons {
    position: relative;
    float: right;
    margin-left: 10px;
}
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
