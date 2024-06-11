<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);

?>
<style>
	.button {
    padding: 5px;
    background: #f4f5f7;
	}
.margin-top-10 {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}
</style>
<div class="col-md-12" style="box-shadow: 0px 0px 7px 1px #8d8d8d;border-radius: 6px;padding: 9px;display: flex;justify-content: space-between;align-items: center;">
	<h3 style="padding: 0;margin: 0;">Task Board</h3>
	<a id="create-task-button" class="btn btn-primary btn-sm" href="javascript:void(0);">Add task</a>
</div>
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
$task = $this->Timesheet_model->get_tasks();
if($task->num_rows() > 0) {
?>

<div class="row" style="overflow-x: auto; overflow-y: auto; white-space:nowrap;">
<div class="col-md-12">
  <div ng-app="ScrumApp">
    <div class="flex">
      <div class="col-md-4 hrsale-scrum-board">
        <div class="scrum-board notstarted">
          <h5><?php echo $this->lang->line('xin_not_started');?> <span><i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-task_status="0"></i></span></h5>
          <?php foreach($not_started_task as $nt_task) {?>
          <?php
			$task_cat = $this->Project_model->read_task_category_information($nt_task->task_name);
			if(!is_null($task_cat)){
				$tname = $task_cat[0]->category_name;
			} else {
				$tname = '';
			}
		?>
          <?php
		$ol = '';
		$cc = count(explode(',',$nt_task->assigned_to));
		$iuser = 0;
		foreach(explode(',',$nt_task->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($nt_task->end_date);
		if($nt_task->task_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($nt_task->task_progress > 20 && $nt_task->task_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($nt_task->task_progress > 50 && $nt_task->task_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$nt_task->task_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$nt_task->task_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$nt_task->task_progress.'%"></div></div></p>';
		?>
          <div class="input-group overflow"> <span><a target="_blank" href="<?php echo site_url('admin/timesheet/task_details/id/').$nt_task->task_id;?>"><?php echo $tname;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-task-id="<?php echo $nt_task->task_id;?>" data-task-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-task-id="<?php echo $nt_task->task_id;?>" data-task-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-task-status="2" data-task-id="<?php echo $nt_task->task_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-task-status="3" data-task-id="<?php echo $nt_task->task_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-task-status="4" data-task-id="<?php echo $nt_task->task_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
            </div>
            <div class="margin-top-15"> <span><i class="fa fa-calendar"></i> <?php echo $pedate;?></span> <span class="pull-right"> <?php echo $ol;?>
              <?php if($cc > 5):?>
              <span class="task-more-user">+<?php echo $cc-5;?></span>
              <?php endif;?>
              </span> </div>
            <hr />
            <?php echo $progress_bar;?> </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-4 hrsale-scrum-board">
        <div class="scrum-board in-progress">
          <h5><?php echo $this->lang->line('xin_in_progress');?> <span><i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-task_status="1"></i></span></h5>
          <?php foreach($inprogress_task as $in_task) {?>
          <?php
			$task_cat = $this->Project_model->read_task_category_information($in_task->task_name);
			if(!is_null($task_cat)){
				$tname = $task_cat[0]->category_name;
			} else {
				$tname = '';
			}
		?>
          <?php
		$ol = '';
		$cc = count(explode(',',$in_task->assigned_to));
		$iuser = 0;
		foreach(explode(',',$in_task->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($in_task->end_date);
		if($in_task->task_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($in_task->task_progress > 20 && $in_task->task_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($in_task->task_progress > 50 && $in_task->task_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$in_task->task_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$in_task->task_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$in_task->task_progress.'%"></div></div></p>';
		?>
          <div class="input-group overflow" style="background-color: rgb(187, 233, 255); border: none;"> <span><a target="_blank" href="<?php echo site_url('admin/timesheet/task_details/id/').$in_task->task_id;?>"><?php echo $tname;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-task-id="<?php echo $in_task->task_id;?>" data-task-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-task-id="<?php echo $in_task->task_id;?>" data-task-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-task-status="2" data-task-id="<?php echo $in_task->task_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-task-status="3" data-task-id="<?php echo $in_task->task_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-task-status="4" data-task-id="<?php echo $in_task->task_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
            </div>
            <div class="margin-top-15"> <span><i class="fa fa-calendar"></i> <?php echo $pedate;?></span> <span class="pull-right"> <?php echo $ol;?>
              <?php if($cc > 5):?>
              <span class="task-more-user">+<?php echo $cc-5;?></span>
              <?php endif;?>
              </span> </div>
            <hr />
            <?php echo $progress_bar;?> </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-4 hrsale-scrum-board">
        <div class="scrum-board complete">
          <h5><?php echo $this->lang->line('xin_completed');?> <span><i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-task_status="2"></i></span></h5>
          <?php foreach($completed_task as $ctask) {?>
          <?php
			$task_cat = $this->Project_model->read_task_category_information($ctask->task_name);
			if(!is_null($task_cat)){
				$tname = $task_cat[0]->category_name;
			} else {
				$tname = '';
			}
		?>
          <?php
		$ol = '';
		$cc = count(explode(',',$ctask->assigned_to));
		$iuser = 0;
		foreach(explode(',',$ctask->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($ctask->end_date);
		if($ctask->task_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($ctask->task_progress > 20 && $ctask->task_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($ctask->task_progress > 50 && $ctask->task_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$ctask->task_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ctask->task_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ctask->task_progress.'%"></div></div></p>';
		?>
          <div class="input-group overflow" style="background-color: rgb(207, 255, 208); border: none;"> <span><a target="_blank" href="<?php echo site_url('admin/timesheet/task_details/id/').$ctask->task_id;?>"><?php echo $tname;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-task-id="<?php echo $ctask->task_id;?>" data-task-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-task-id="<?php echo $ctask->task_id;?>" data-task-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-task-status="2" data-task-id="<?php echo $ctask->task_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-task-status="3" data-task-id="<?php echo $ctask->task_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-task-status="4" data-task-id="<?php echo $ctask->task_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
            </div>
            <div class="margin-top-15"> <span><i class="fa fa-calendar"></i> <?php echo $pedate;?></span> <span class="pull-right"> <?php echo $ol;?>
              <?php if($cc > 5):?>
              <span class="task-more-user">+<?php echo $cc-5;?></span>
              <?php endif;?>
              </span> </div>
            <hr />
            <?php echo $progress_bar;?> </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-4 hrsale-scrum-board">
        <div class="scrum-board cancelled">
          <h5><?php echo $this->lang->line('xin_project_cancelled');?> <span><i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-task_status="3"></i></span></h5>
          <?php foreach($cancelled_task as $cn_task) {?>
          <?php
			$task_cat = $this->Project_model->read_task_category_information($cn_task->task_name);
			if(!is_null($task_cat)){
				$tname = $task_cat[0]->category_name;
			} else {
				$tname = '';
			}
		?>
          <?php
		$ol = '';
		$cc = count(explode(',',$cn_task->assigned_to));
		$iuser = 0;
		foreach(explode(',',$cn_task->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($cn_task->end_date);
		if($cn_task->task_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($cn_task->task_progress > 20 && $cn_task->task_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($cn_task->task_progress > 50 && $cn_task->task_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$cn_task->task_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$cn_task->task_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$cn_task->task_progress.'%"></div></div></p>';
		?>
          <div class="input-group overflow" style="background-color: rgb(255, 216, 216); border: none;"> <span>
          <a target="_blank" href="<?php echo site_url('admin/timesheet/task_details/id/').$cn_task->task_id;?>"><?php echo $tname;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-task-id="<?php echo $cn_task->task_id;?>" data-task-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-task-id="<?php echo $cn_task->task_id;?>" data-task-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-task-status="2" data-task-id="<?php echo $cn_task->task_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-task-status="3" data-task-id="<?php echo $cn_task->task_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-task-status="4" data-task-id="<?php echo $cn_task->task_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
            </div>
            <div class="margin-top-15"> <span><i class="fa fa-calendar"></i> <?php echo $pedate;?></span> <span class="pull-right"> <?php echo $ol;?>
              <?php if($cc > 5):?>
              <span class="task-more-user">+<?php echo $cc-5;?></span>
              <?php endif;?>
              </span> </div>
            <hr />
            <?php echo $progress_bar;?> </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-4 hrsale-scrum-board">
        <div class="scrum-board hold">
          <h5><?php echo $this->lang->line('xin_project_hold');?> <span><i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-task_status="4"></i></span></h5>
          <?php foreach($hold_task as $hltask) {?>
          <?php
			$task_cat = $this->Project_model->read_task_category_information($hltask->task_name);
			if(!is_null($task_cat)){
				$tname = $task_cat[0]->category_name;
			} else {
				$tname = '';
			}
		?>
          <?php
		$ol = '';
		$cc = count(explode(',',$hltask->assigned_to));
		$iuser = 0;
		foreach(explode(',',$hltask->assigned_to) as $uid) {
			//$user = $this->Xin_model->read_user_info($uid);
			if($iuser < 5) {
				$assigned_to = $this->Xin_model->read_user_info($uid);
				if(!is_null($assigned_to)){
					
				$assigned_name = $assigned_to[0]->first_name.' '.$assigned_to[0]->last_name;
				 if($assigned_to[0]->profile_picture!='' && $assigned_to[0]->profile_picture!='no file') {
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.base_url().'uploads/profile/'.$assigned_to[0]->profile_picture.'" class="user-image-hr" alt=""></span></a>';
					} else {
					if($assigned_to[0]->gender=='Male') { 
						$de_file = base_url().'uploads/profile/default_male.jpg';
					 } else {
						$de_file = base_url().'uploads/profile/default_female.jpg';
					 }
					$ol .= '<a href="javascript:void(0);" class="task-media" data-toggle="tooltip" data-placement="top" title="'.$assigned_name.'"><span class="avatar box-32"><img src="'.$de_file.'" class="user-image-hr" alt=""></span></a>';
					}
				}
			}
			$iuser++;
		 }
		 $ol .= '';
		$pedate = $this->Xin_model->set_date_format($hltask->end_date);
		if($hltask->task_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($hltask->task_progress > 20 && $hltask->task_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($hltask->task_progress > 50 && $hltask->task_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$hltask->task_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$hltask->task_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$hltask->task_progress.'%"></div></div></p>';
		?>
          <div class="input-group overflow" style="background-color: rgba(251, 255, 162, 1); border: none;"> <span>
          <a target="_blank" href="<?php echo site_url('admin/timesheet/task_details/id/').$hltask->task_id;?>"><?php echo $tname;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-task-id="<?php echo $hltask->task_id;?>" data-task-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-task-id="<?php echo $hltask->task_id;?>" data-task-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-task-status="2" data-task-id="<?php echo $hltask->task_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-task-status="3" data-task-id="<?php echo $hltask->task_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-task-status="4" data-task-id="<?php echo $hltask->task_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
            </div>
            <div class="margin-top-15"> <span><i class="fa fa-calendar"></i> <?php echo $pedate;?></span> <span class="pull-right"> <?php echo $ol;?>
              <?php if($cc > 5):?>
              <span class="task-more-user">+<?php echo $cc-5;?></span>
              <?php endif;?>
              </span> </div>
            <hr />
            <?php echo $progress_bar;?> </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } else {?>
<div class="row">
    <div class="col-md-7 col-md-offset-3">
    <img src="<?php echo base_url();?>skin/img/no-record-found.png" />
    </div>
</div>
<?php } ?>
<script>

	//Init
init();

//Button Functions------------------------------------------
function init() {
  $(".button-notstarted").on("click", function() {
    if (!($(this).closest(".notstarted").length > 0)) {
      $(this).parents(".input-group").appendTo(".notstarted").css({
        "background-color": "",
        "border": ""
      });
		var task_id = $(this).data('task-id');
		var task_status = $(this).data('task-status');
		jQuery.get(site_url+"project/update_task_scrum_board_status/"+task_id+"/"+task_status, function(data, status){
		});
    }
  });
  $(".button-progress").on("click", function() {
    if (!($(this).closest(".in-progress").length > 0)) {
      $(this).parents(".input-group").appendTo(".in-progress").css({
        "background-color": "#bbe9ff",
        "border": "none"
      });
		var task_id = $(this).data('task-id');
		var task_status = $(this).data('task-status');
		jQuery.get(site_url+"project/update_task_scrum_board_status/"+task_id+"/"+task_status, function(data, status){
		});
    }
  });
  $(".button-complete").on("click", function() {
    if (!($(this).closest(".complete").length > 0)) {
      $(this).parents(".input-group").appendTo(".complete").css({
        "background-color": "#cfffd0",
        "border": "none"
      });
	  	var task_id = $(this).data('task-id');
		var task_status = $(this).data('task-status');
		jQuery.get(site_url+"project/update_task_scrum_board_status/"+task_id+"/"+task_status, function(data, status){
		});
    }
  });
  $(".button-cancelled").on("click", function() {
    if (!($(this).closest(".cancelled").length > 0)) {
      $(this).parents(".input-group").appendTo(".cancelled").css({
        "background-color": "#ffd8d8",
        "border": "none"
      });
	  	var task_id = $(this).data('task-id');
		var task_status = $(this).data('task-status');
		jQuery.get(site_url+"project/update_task_scrum_board_status/"+task_id+"/"+task_status, function(data, status){
		});
    }
  });
  $(".button-hold").on("click", function() {
    if (!($(this).closest(".hold").length > 0)) {
      $(this).parents(".input-group").appendTo(".hold").css({
        "background-color": "#fbffa2",
        "border": "none"
      });
	  	var task_id = $(this).data('task-id');
		var task_status = $(this).data('task-status');
		jQuery.get(site_url+"project/update_task_scrum_board_status/"+task_id+"/"+task_status, function(data, status){
		});
    }
  });
  
  $(".button-delete").on("click", function() {
    $(this).parents(".input-group").remove();
  });

  var placeholderDiv = document.createElement("div");
  var placeholderAtt = document.createAttribute("class");
  var taskDivAttVal = placeholderAtt.value = "placeholder";
  placeholderDiv.setAttributeNode(placeholderAtt);

}
$(document).ready(function() {
	// create
	$('#create-task-button').on('click', function (event) {
		console.log("create");
		var modal = '<div class="modal fade" id="ajax" role="basic" aria-hidden="true">' +
			'<div class="modal-dialog modal-lg">' +
			'<div class="modal-content">' +
			'<div class="modal-body">' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</div>';
		$('body').append(modal);
		$.ajax({
			url : site_url+"project/get_scrumboard_task/",
			type: "GET",
			data: 'jd=1&is_ajax=1&mode=modal&data=scrum_board&task_status=0',
			success: function (response) {
				console.log(response);
				if(response) {
					$("#ajax").find('.modal-body').html(response);
					$("#ajax").modal('show');
				}
			},
			error: function (xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	});
});

</script>