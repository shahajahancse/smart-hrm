<?php
/* Attendance Calendar view > hrsale
*/
?>
<?php
$session = $this->session->userdata('username');
$system = $this->Xin_model->read_setting_info(1);
$user_info = $this->Xin_model->read_user_info($session['user_id']);
// get month&year > employee > company
$month_year = $this->input->post('month_year');
$employee_id = $this->input->post('employee_id');
$company_id = $this->input->post('company_id');
/* check if company */
/*if(isset($company_id)){
	$date = strtotime(date("Y-m-d"));
	
	$imonth_year = explode('-',$month_year);
	$day = date('d', $date);
	$month = date($imonth_year[1], $date);
	$year = date($imonth_year[0], $date);
	if($employee_id == ''){
		$r = $this->Xin_model->read_user_info($session['user_id']);
	} else {
		$r = $this->Xin_model->read_user_info($employee_id);
	}
	$fdate = $month_year;
} else {
	$date = strtotime(date("Y-m-d"));
	$day = date('d', $date);
	$month = date('m', $date);
	$year = date('Y', $date);
	$fdate = strtotime(date("Y-m-d"));
}*/
if($user_info[0]->user_role_id==1){
	$month_year = $this->input->post('month_year');
	$employee_id = $this->input->post('employee_id');
	$company_id = $this->input->post('company_id');
	/* Set the date */
	//if(isset($company_id)){
	if(isset($company_id)){
		$date = strtotime(date("Y-m-d"));
		
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		if($employee_id == ''){
			$r = $this->Xin_model->read_user_info($session['user_id']);
		} else {
			$r = $this->Xin_model->read_user_info($employee_id);
		}
		$fdate = $month_year;
	} else {
		$date = strtotime(date("Y-m-d"));
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$fdate = strtotime(date("Y-m-d"));
	}
	//$fdate = strtotime(date("Y-m"));
} else {
	if(isset($month_year)){
		$date = strtotime(date("Y-m-d"));
		$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);
		$r = $this->Xin_model->read_user_info($session['user_id']);
		$fdate = $month_year;
	} else {
		$date = strtotime(date("Y-m-d"));
		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		$fdate = date("Y-m-d");
		$month_year = date("Y-m");
		$r = $this->Xin_model->read_user_info($session['user_id']);
	}
}
// total days in month
$daysInMonth = cal_days_in_month(0, $month, $year);
?>
<script type="text/javascript">
var newEvent;
var editEvent;

$(document).ready(function() {
    
   var calendar = $('#calendar_hr').fullCalendar({
       
       eventRender: function(event, element, view) {
         var displayEventDate;    
         if(event.etitle == 'Present'){
          element.popover({
			  
            title:    '<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
            content:  '<div class="popoverInfoCalendar">' +
                      '<p><strong>Clock In:</strong> ' + event.clock_in + '</p>' +
                      '<p><strong>Clock Out:</strong> ' + event.clock_out + '</p>' +
                      '<p><strong>Total Work:</strong> ' + event.total_work + '</p>' +
                      '</div>',
            delay: { 
               show: "400", 
               hide: "50"
            },
            trigger: 'hover',
            placement: 'top',
            html: true,
            container: 'body'
          }); 
		  }   else if(event.etitle == 'Holiday'){
          element.popover({
			  
            title:    '<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
            content:  '<div class="popoverInfoCalendar">' +
						'<p><strong>Event Name:</strong> ' + event.event_name + '</p>' +
						'<p><strong>Start Date:</strong> ' + event.estart + '</p>' +
						'<p><strong>End Date:</strong> ' + event.eend + '</p>' +
                        '<div class="popoverDescCalendar"><strong>Description:</strong> '+ event.description +'</div>' +
                      '</div>',
            delay: { 
               show: "400", 
               hide: "50"
            },
            trigger: 'hover',
            placement: 'top',
            html: true,
            container: 'body'
          }); 
		  } else if(event.etitle == 'Leave'){
          element.popover({
			  
            title:    '<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
            content:  '<div class="popoverInfoCalendar">' +
						'<p><strong>Type:</strong> ' + event.leave_type + '</p>' +
						'<p><strong>Start Date:</strong> ' + event.from_date + '</p>' +
						'<p><strong>End Date:</strong> ' + event.to_date + '</p>' +
                        '<div class="popoverDescCalendar"><strong>Description:</strong> '+ event.reason +'</div>' +
                      '</div>',
            delay: { 
               show: "400", 
               hide: "50"
            },
            trigger: 'hover',
            placement: 'top',
            html: true,
            container: 'body'
          }); 
		  }      
       },
       header: {
           left: 'today, prevYear, nextYear, printButton',
           center: 'prev, title, next',
           right: 'month,listWeek'
       },
	   themeSystem: 'bootstrap4',
       eventAfterAllRender: function(view) {
           if(view.name == "month"){
              $(".fc-content").css('height','auto');
            } else {
				$(".fc-content").css('height','auto');
			}
       },
       eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {
            $('.popover.fade.top').remove();
       },
       locale: 'en-GB',
       allDaySlot: false,
       firstDay: 1,
       weekNumbers: false,
       selectable: false,
       weekNumberCalculation: "ISO",
       eventLimit: true,
       eventLimitClick: 'week', //popover
       navLinks: true,
       defaultDate: moment('<?php echo $fdate;?>'),
       timeFormat: 'HH:mm',
       editable: false,
       weekends: true,
       nowIndicator: true,
       dayPopoverFormat: 'dddd DD/MM', 
       longPressDelay : 0,
       eventLongPressDelay : 0,
       selectLongPressDelay : 0,
       
       events: [
	   <?php
			for($i = 1; $i <= $daysInMonth; $i++):
			$i = str_pad($i, 2, 0, STR_PAD_LEFT);
			// get date <
			$attendance_date = $year.'-'.$month.'-'.$i;
			$get_day = strtotime($attendance_date);
			$day = date('l', $get_day);
			$user_id = $r[0]->user_id;
			$office_shift_id = $r[0]->office_shift_id;
			$attendance_status = '';
			$office_shift = $this->Timesheet_model->read_office_shift_information($office_shift_id);
			$check = $this->Timesheet_model->attendance_first_in_check($user_id,$attendance_date);
			// get holiday>events
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
			$leave_date_chck = $this->Timesheet_model->leave_date_check($user_id,$attendance_date);
			$leave_arr = array();
			if($leave_date_chck->num_rows() > 0){
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
			// get holiday>weekend
			if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
			} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$event_name = '';
			} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
			} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$event_name = '';
				$clockout = '';
			} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
			} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
				$status = '1';	
				$bgcolor = '';
				$total_work = '';
				$event_name = '';
				$clockout = '';
			} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
				$status = '1';
				$bgcolor = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
			} else if(in_array($attendance_date,$holiday_arr)) { // holiday
				$status = $this->lang->line('xin_holiday');
				$estatus = 'Holiday';
				$bgcolor = '#605ca8';
				$clockin = '';
				$total_work = '';
				$clockout = '';
				$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
				$event_name = '';
				if($h_date_chck->num_rows() > 0){
					$h_date = $this->Timesheet_model->holiday_date($attendance_date);
					foreach($h_date as $hevent){
						$event_name = $hevent->event_name;
						$description = $hevent->description;
					}
				}
			} else if(in_array($attendance_date,$leave_arr)) { // on leave
				$status = $this->lang->line('left_leave');
				$estatus = 'Leave';
				$bgcolor = '#f39c12';
				$clockin = '';
				$total_work = '';
				$clockout = '';
				$event_name = '';
				$leave_date_chck = $this->Timesheet_model->leave_date_check($user_id,$attendance_date);
				$leave_arr = array();
				if($leave_date_chck->num_rows() > 0){
					$leave_date = $this->Timesheet_model->leave_date($user_id,$attendance_date);
					foreach($leave_date as $_leave_date){
						// get leave type
						$leave_type = $this->Timesheet_model->read_leave_type_information($_leave_date->leave_type_id);
						if(!is_null($leave_type)){
							$type_name = $leave_type[0]->type_name;
						} else {
							$type_name = '--';	
						}
						$_type_name = $type_name;
						$from_date = $_leave_date->from_date;
						$to_date = $_leave_date->to_date;
						$reason = $_leave_date->reason;
						$applied_on = $_leave_date->applied_on;
					}
				}
			} else if($check->num_rows() > 0){
				$attendance = $this->Timesheet_model->attendance_first_in($user_id,$attendance_date);
				$status = $this->lang->line('xin_emp_working');
				$estatus = 'Present';
				$bgcolor = '#00a65a';
				$attendance_date = $attendance_date;
				$iclock_in = new DateTime($attendance[0]->clock_in);
				$fclockin = $iclock_in->format('h:i a');
				$iclock_out = new DateTime($attendance[0]->clock_out);
				$fclockout = $iclock_out->format('h:i a');
				$clockin = '<i class="fa fa-clock-o"></i>'.$fclockin;
				$clockout = '<i class="fa fa-clock-o"></i>'.$fclockout;
				// total hours work/ed
				$total_hrs = $this->Timesheet_model->total_hours_worked_attendance($user_id,$attendance_date);
				$hrs_old_int1 = 0;
				$Total = '';
				$Trest = '';
				$event_name = '';
				$hrs_old_seconds = 0;
				$hrs_old_seconds_rs = 0;
				$total_time_rs = '';
				$hrs_old_int_res1 = 0;
				foreach ($total_hrs->result() as $hour_work){		
					// total work			
					$timee = $hour_work->total_work.':00';
					$str_time =$timee;
		
					$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
					
					sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
					
					$hrs_old_seconds = $hours * 3600 + $minutes * 60 + $seconds;
					
					$hrs_old_int1 += $hrs_old_seconds;
					
					$Total = gmdate("H:i", $hrs_old_int1);	
				}
				if($Total=='') {
					$total_work = '';
				} else {
					$total_work = $Total;
				}
			} else {	
				$event_name = '';	
				$status = $this->lang->line('xin_absent');
				$estatus = 'Absent';
				$bgcolor = '#dd4b39';
				$attendance_date = $attendance_date;
				$clockin = '';
				$clockout = '';
				$total_work = '';
			}
			// set to present date
			$iattendance_date = strtotime($attendance_date);
			$icurrent_date = strtotime(date('Y-m-d'));
			if($iattendance_date <= $icurrent_date){
				$status = $status;
				$bgcolor = $bgcolor;
				$attendance_date = $attendance_date;
			} else {
				$status = '';
				$bgcolor = '';
				$attendance_date = '';
			}
			$idate_of_joining = strtotime($r[0]->date_of_joining);
			if($idate_of_joining < $iattendance_date){
				$status = $status;
			} else {
				$status = '';
			}
			if($status==1){
				$attendance_date = '';
			}
			if($estatus == 'Present'){
			?>
		   {
			   _id: '<?php echo $i;?>',
			   title: '<?php echo $status;?>',
			   etitle: '<?php echo $estatus;?>',
			   start: '<?php echo $attendance_date;?>',
			   end: '<?php echo $attendance_date;?>',
			   clock_in: '<?php echo $clockin;?>',
			   clock_out: '<?php echo $clockout;?>',
			   total_work: '<?php echo $total_work;?>',
			   backgroundColor: "<?php echo $bgcolor;?>",
			   textColor: "#ffffff",
		   },
			<?php } 
			else if($estatus == 'Holiday'){
			?>
		   {
			   _id: '<?php echo $i;?>',
			   title: '<?php echo $status;?>',
			   etitle: '<?php echo $estatus;?>',
			   event_name: '<?php echo $event_name;?>',
			   estart: '<?php echo $attendance_date;?>',
			   eend: '<?php echo $attendance_date;?>',
			   start: '<?php echo $attendance_date;?>',
			   end: '<?php echo $attendance_date;?>',
			   description: '<?php echo $description;?>',
			   backgroundColor: "<?php echo $bgcolor;?>",
			   textColor: "#ffffff",
		   },
			<?php } else if($estatus == 'Leave'){
			?>
		   {
			   _id: '<?php echo $i;?>',
			   title: '<?php echo $status;?>',
			   etitle: '<?php echo $estatus;?>',
			   leave_type: '<?php echo $_type_name;?>',
			   from_date: '<?php echo $from_date;?>',
			   to_date: '<?php echo $to_date;?>',
			   start: '<?php echo $attendance_date;?>',
			   end: '<?php echo $attendance_date;?>',
			   reason: '<?php echo $reason;?>',
			   backgroundColor: "<?php echo $bgcolor;?>",
			   textColor: "#ffffff",
		   },
			<?php } else { ?>
			{
			   _id: '<?php echo $i;?>',
			   title: '<?php echo $status;?>',
			   etitle: '<?php echo $estatus;?>',
			   start: '<?php echo $attendance_date;?>',
			   end: '<?php echo $attendance_date;?>',
			   backgroundColor: "<?php echo $bgcolor;?>",
			   textColor: "#ffffff",
		   },
		<?php }	?>   
	   <?php endfor;?>
	   ]

   }); 
});
</script>