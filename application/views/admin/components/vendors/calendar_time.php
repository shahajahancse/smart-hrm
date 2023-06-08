<?php
/* Attendance Calendar view > hrsale
*/
?>
<?php
	$session = $this->session->userdata('username');
	// $system = $this->Xin_model->read_setting_info(1);
	$user_info = $this->Xin_model->read_user_info($session['user_id']);
	// get month&year > employee > company
	$month_year = $this->input->post('month_year');
	$employee_id = $this->input->post('employee_id');
	// $company_id = $this->input->post('company_id');

	if($session['role_id'] != 3){
		if (isset($month_year)) {
			$date = strtotime($month_year);
			$day = date("d", $date);
			$month = date("m", $date);
			$year = date("Y", $date);		
		} else {
			$date = strtotime(date("Y-m-d"));
			$day = date('d', $date);
			$month = date('m', $date);
			$year = date('Y', $date);
			$month_year = date("Y-m");
		}

		if($employee_id == ''){
			$r = $this->Xin_model->read_user_info($session['user_id']);
		} else {
			$r = $this->Xin_model->read_user_info($employee_id);
		}
		
	} else {

		if (isset($month_year)) {
			$date = strtotime($month_year);
			$day = date("d", $date);
			$month = date("m", $date);
			$year = date("Y", $date);		
		} else {
			$date = strtotime(date("Y-m-d"));
			$day = date('d', $date);
			$month = date('m', $date);
			$year = date('Y', $date);
			$month_year = date("Y-m");
		}
		$r = $this->Xin_model->read_user_info($session['user_id']);

	}
	$fdate = $month_year;

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
			            title:'<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
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

				} else if(event.etitle == 'Holiday'){
	        		element.popover({
				  
			            title: '<div class="popoverTitleCalendar" style="background-color:'+ event.backgroundColor +'; color:'+ event.textColor +'">'+ event.title +'</div>',
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
	           left: '',  /*today, prevYear, nextYear*/
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
				$(".fc-day-number").css('font-size','12px');
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
	        eventBackgroundColor: "#156b7c",
	        contentHeight: 600,
	       
	        events: [ <?php
				for($i = 1; $i <= $daysInMonth; $i++):
					$i = str_pad($i, 2, 0, STR_PAD_LEFT);
					// get date <
					$attendance_date = $year.'-'.$month.'-'.$i;
					$get_day = strtotime($attendance_date);
					$day = date('l', $get_day);
					$user_id = $r[0]->user_id;
					$attendance_status = '';

					$row = $this->Job_card_model->emp_job_card($attendance_date,$attendance_date, $user_id);

					// get holiday>weekend>present>absent>leave
					// attendance status
					if (!empty($row['emp_data'][0])) {
						if($row['emp_data'][0]->status == 'Leave')
						{
							$status = $this->lang->line('left_leave');
							$estatus = 'Leave';
							$bgcolor = '#f39c12';
							$clockin = '';
							$total_work = '';
							$clockout = '';
							$event_name = '';
							$leave_date = $this->Timesheet_model->leave_date($user_id,$attendance_date);
							if($leave_date[0]->leave_type_id == 1){
								$type_name = "Earn Leave";
							} else if($leave_date[0]->leave_type_id == 2){
								$type_name = "Sick Leave";
							} else {
								$type_name = '--';	
							}

							$_type_name = $type_name;
							$from_date = $leave_date[0]->from_date;
							$to_date = $leave_date[0]->to_date;
							$reason = $leave_date[0]->reason;
							$applied_on = $leave_date[0]->applied_on;
							

						}
						elseif($row['emp_data'][0]->status == 'Hleave')
						{
							$event_name = '';
							$status = 'Hleave';
							$estatus = 'Hleave';
							$bgcolor = '#605ca8';
							$clockin = '';
							$clockout = '';
							$total_work = '';

						}
						elseif($row['emp_data'][0]->status == 'Holiday')
						{
							$status = $this->lang->line('xin_holiday');
							$estatus = 'Holiday';
							$bgcolor = '#eb50a6';
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
						} 
						elseif($row['emp_data'][0]->status == 'Off Day')
						{
							$event_name = '';
							$status = 'Off Day';
							$estatus = 'Off Day';
							$bgcolor = '#805ca8';
							$clockin = '';
							$clockout = '';
							$total_work = '';
						} 
						else if ($row['emp_data'][0]->status == 'HalfDay') 
						{
							$attendance_date = $attendance_date;
							$fclockin = date('h:i', strtotime($row['emp_data'][0]->clock_in));
							$fclockout = date('h:i', strtotime($row['emp_data'][0]->clock_out)); 

							$event_name = '';
							$status = 'HalfDay';
							$estatus = 'HalfDay';
							$bgcolor = '#00a98a';
							$clockin = '<i class="fa fa-clock-o"></i>'.$fclockin;
							$clockout = '<i class="fa fa-clock-o"></i>'.$fclockout;
							$fclockinP = "In : ".$fclockin; 
							$fclockinO = "Out : ".$fclockout; 
							$total_work = '';
						}
						elseif($row['emp_data'][0]->clock_in !='' && $row['emp_data'][0]->clock_out !='')
						{
							$attendance_date = $attendance_date;
							$it = $row['emp_data'][0]->clock_in;
							$ot = $row['emp_data'][0]->clock_out;
							$fclockin = ($it != null && $it != '')?date("h:i A", strtotime($row['emp_data'][0]->clock_in)):'';
							$fclockout = ($ot != null && $ot != '')?date("h:i A", strtotime($row['emp_data'][0]->clock_out)):'';

							$event_name = '';
							$status = $this->lang->line('xin_emp_working');
							$estatus = 'Present';
							$bgcolor = '#00a65a';
							$clockin = '<i class="fa fa-clock-o"></i>'.$fclockin;
							$clockout = '<i class="fa fa-clock-o"></i>'.$fclockout;
							$fclockinP = "In : ".$fclockin; 
							$fclockinO = "Out : ".$fclockout; 
							$total_work = '';
						}
						elseif($row['emp_data'][0]->clock_in !='' || $row['emp_data'][0]->clock_out !='')
						{
							$attendance_date = $attendance_date;
							$it = $row['emp_data'][0]->clock_in;
							$ot = $row['emp_data'][0]->clock_out;
							$fclockin = ($it != null && $it != '')?date("h:i A", strtotime($row['emp_data'][0]->clock_in)):'';
							$fclockout = ($ot != null && $ot != '')?date("h:i A", strtotime($row['emp_data'][0]->clock_out)):'';

							$event_name = '';
							$status = 'Present Error';
							$estatus = 'Present';
							$bgcolor = '#e34242';
							$clockin = '<i class="fa fa-clock-o"></i>'.$fclockin;
							$clockout = '<i class="fa fa-clock-o"></i>'.$fclockout;
							$fclockinP = "In : ".$fclockin; 
							$fclockinO = "Out : ".$fclockout;
							$total_work = ''; 
						}
						else
						{
							$event_name = '';	
							$status = $this->lang->line('xin_absent');
							$estatus = 'Absent';
							$bgcolor = '#dd4b39';
							$clockin = '';
							$clockout = '';
							$total_work = '';
						}
					} else {
						$event_name = '';	
						$status = ' Not Found';
						$estatus = ' Not Found';
						$bgcolor = '';
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

					if($estatus == 'Present'){ ?>
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
			 			{
						   _id: '<?php echo $i;?>',
						   title: '<?php echo $fclockinP;?>',
						   etitle: '<?php echo $estatus;?>',
						   start: '<?php echo $attendance_date;?>',
						   end: '<?php echo $attendance_date;?>',
						   clock_in: '<?php echo $clockin;?>',
						   clock_out: '<?php echo $clockout;?>',
						   total_work: '<?php echo $total_work;?>',
					   },
					   {
						   _id: '<?php echo $i;?>',
						   title: '<?php echo $fclockinO;?>',
						   etitle: '<?php echo $estatus;?>',
						   start: '<?php echo $attendance_date;?>',
						   end: '<?php echo $attendance_date;?>',
						   clock_in: '<?php echo $clockin;?>',
						   clock_out: '<?php echo $clockout;?>',
						   total_work: '<?php echo $total_work;?>',
					   },

					<?php }  else if($estatus == 'Holiday'){ ?>
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
					<?php } else if($estatus == 'Leave'){ ?>
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