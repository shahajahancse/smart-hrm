<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php
if(isset($_POST['set_date'])){
	$set_date = $_POST['set_date'];
} else {
	$set_date = date('Y-m-d');
}
?>
<?php
if($user_info[0]->user_role_id == '1'){
	$completed_task = $this->Project_model->calendar_complete_tasks();
	$cancelled_task = $this->Project_model->calendar_cancelled_tasks();
	$inprogress_task = $this->Project_model->calendar_inprogress_tasks();
	$not_started_task = $this->Project_model->calendar_not_started_tasks();
	$hold_task = $this->Project_model->calendar_hold_tasks();
} else {
	$completed_task = $this->Project_model->calendar_user_complete_tasks($session['user_id']);
	$cancelled_task = $this->Project_model->calendar_user_cancelled_tasks($session['user_id']);
	$inprogress_task = $this->Project_model->calendar_user_inprogress_tasks($session['user_id']);
	$not_started_task = $this->Project_model->calendar_user_not_started_tasks($session['user_id']);
	$hold_task = $this->Project_model->calendar_user_hold_tasks($session['user_id']);
}
?>
<script type="text/javascript">
$(document).ready(function(){
	
	/* initialize the calendar
	-----------------------------------------------------------------*/
	$('#calendar_hr').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek'
		},
		views: {
			listDay: { buttonText: 'list day' },
			listWeek: { buttonText: 'list week' }
		  },
		eventRender: function(event, element) {
		element.attr('title',event.title).tooltip();
		element.attr('href', event.urllink);
		},
		defaultDate: '<?php echo $set_date;?>',
		eventLimit: false, // allow "more" link when too many events
		navLinks: true, // can click day/week names to navigate views
		events: [
			<?php foreach($completed_task as $ctasks):?>
			<?php
				$task_cat = $this->Project_model->read_task_category_information($ctasks->task_name);
				if(!is_null($task_cat)){
					$tname = $task_cat[0]->category_name;
				} else {
					$tname = '';
				}
			?>
			{
				title: '<?php echo $tname;?>',
				start: '<?php echo $ctasks->start_date?>',
				end: '<?php echo $ctasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$ctasks->task_id;?>',
				color: '#00a65a'
			},
			<?php endforeach;?>
			<?php foreach($inprogress_task as $intasks):?>
			<?php
				$task_cat = $this->Project_model->read_task_category_information($intasks->task_name);
				if(!is_null($task_cat)){
					$tname = $task_cat[0]->category_name;
				} else {
					$tname = '';
				}
			?>
			{
				title: '<?php echo $tname;?>',
				start: '<?php echo $intasks->start_date?>',
				end: '<?php echo $intasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$intasks->task_id;?>',
				color: '#00c0ef'
			},
			<?php endforeach;?>
			<?php foreach($not_started_task as $nttasks):?>
			<?php
				$task_cat = $this->Project_model->read_task_category_information($nttasks->task_name);
				if(!is_null($task_cat)){
					$tname = $task_cat[0]->category_name;
				} else {
					$tname = '';
				}
			?>
			{
				title: '<?php echo $tname;?>',
				start: '<?php echo $nttasks->start_date?>',
				end: '<?php echo $nttasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$nttasks->task_id;?>',
				color: '#605ca8'
			},
			<?php endforeach;?>
			<?php foreach($cancelled_task as $cntasks):?>
			<?php
				$task_cat = $this->Project_model->read_task_category_information($cntasks->task_name);
				if(!is_null($task_cat)){
					$tname = $task_cat[0]->category_name;
				} else {
					$tname = '';
				}
			?>
			{
				title: '<?php echo $tname;?>',
				start: '<?php echo $cntasks->start_date?>',
				end: '<?php echo $cntasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$cntasks->task_id;?>',
				color: '#dd4b39'
			},
			<?php endforeach;?>
			<?php foreach($hold_task as $hltasks):?>
			<?php
				$task_cat = $this->Project_model->read_task_category_information($hltasks->task_name);
				if(!is_null($task_cat)){
					$tname = $task_cat[0]->category_name;
				} else {
					$tname = '';
				}
			?>
			{
				title: '<?php echo $tname;?>',
				start: '<?php echo $hltasks->start_date?>',
				end: '<?php echo $hltasks->end_date?>',
				urllink: '<?php echo site_url().'admin/timesheet/task_details/id/'.$hltasks->task_id;?>',
				color: '#f39c12'
			},
			<?php endforeach;?>
		]
	});
	
	/* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events .fc-event').each(function() {

		// Different colors for events
        $(this).css({'backgroundColor': $(this).data('color'), 'borderColor': $(this).data('color')});

		// store data so the calendar knows to render an event upon drop
		$(this).data('event', {
			title: $.trim($(this).text()), // use the element's text as the event title
			color: $(this).data('color'),
			stick: true // maintain when user navigates (see docs on the renderEvent method)
		});

	});


});
</script>