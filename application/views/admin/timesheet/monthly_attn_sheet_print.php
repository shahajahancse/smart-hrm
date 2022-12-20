
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<style type="text/css">
	.box-tools {
	    margin-right: -5px !important;
	}

	table thead tr th {
		font-size:12px;
		padding: 3px !important;
	}

	table tbody tr td {
		font-size: 12px;
		padding: 3px !important;
	}

	@media print {
		.box-tools {
	    margin-right: -5px !important;
		}

		table thead tr th {
			font-size: 12px;
			padding: 3px !important;
		}

		table tbody tr td {
			font-size: 14px;
			padding: 3px !important;
		}
	}

</style>

<div class="box" id="print_area">
  <div style="text-align: center;">
	  <h3 class="box-title"> <?php echo $this->lang->line('xin_employees_monthly_timesheet');?></h3>
	  <p>For the month of
	    <?php if(isset($month_year)): echo date('F Y', strtotime($month_year)); else: echo date('F Y'); endif;?>
	  </p>
    <span class="box-tools"> A: Absent, P: Present, H: Holiday, L: Leave</span><br><br>
  </div>

  <?php
	  $date = strtotime(date("Y-m-d"));
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$month_year = date('Y-m');
		// total days in month
		$daysInMonth = cal_days_in_month(0, $month, $year);
		$xin_employees = $this->Timesheet_model->get_xin_employees();
  ?>


  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="table table-striped table-bordered">
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
          <?php $employee_name = $full_name.'<br><small class="text-muted"><i>'.$department_designation.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_employees_id').': '.$r->employee_id.'<i></i></i></small>';
          ?>
          <tr>

            <td><?php echo $employee_name;?></td>
            <?php for($i = 1; $i <= $daysInMonth; $i++):
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

<!-- jQuery 3 -->
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js"></script>

<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
