<?php $session = $this->session->userdata('username');?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php
if($user_info[0]->user_role_id == '1'){
	$completed_projects = $this->Project_model->calendar_complete_projects();
	$cancelled_projects = $this->Project_model->calendar_cancelled_projects();
	$inprogress_projects = $this->Project_model->calendar_inprogress_projects();
	$not_started_projects = $this->Project_model->calendar_not_started_projects();
	$hold_projects = $this->Project_model->calendar_hold_projects();
} else {
	$completed_projects = $this->Project_model->calendar_user_complete_projects($session['user_id']);
	$cancelled_projects = $this->Project_model->calendar_user_cancelled_projects($session['user_id']);
	$inprogress_projects = $this->Project_model->calendar_user_inprogress_projects($session['user_id']);
	$not_started_projects = $this->Project_model->calendar_user_not_started_projects($session['user_id']);
	$hold_projects = $this->Project_model->calendar_user_hold_projects($session['user_id']);
}
$projects = $this->Project_model->get_projects();
if($projects->num_rows() > 0) {
?>
<div class="row" style="overflow-x: auto; overflow-y: auto; white-space:nowrap;">
<div class="col-md-12">
  <div ng-app="ScrumApp">
    <div class="flex">
      <div class="col-md-4 hrsale-scrum-board">
        <div class="scrum-board notstarted">
          <h5><?php echo $this->lang->line('xin_not_started');?> <span>
          <i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-project_status="0"></i></span></h5>
          <?php foreach($not_started_projects as $ntprojects) {?>
          
          <?php
		$ol = '';
		$cc = count(explode(',',$ntprojects->assigned_to));
		$iuser = 0;
		foreach(explode(',',$ntprojects->assigned_to) as $uid) {
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
		$pedate = $this->Xin_model->set_date_format($ntprojects->end_date);
		if($ntprojects->project_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($ntprojects->project_progress > 20 && $ntprojects->project_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($ntprojects->project_progress > 50 && $ntprojects->project_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$ntprojects->project_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$ntprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$ntprojects->project_progress.'%"></div></div></p>';
		?>
          <div class="input-group overflow"> <span><a target="_blank" href="<?php echo site_url('admin/project/detail/').$ntprojects->project_id;?>"><?php echo $ntprojects->title;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-project-id="<?php echo $ntprojects->project_id;?>" data-project-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-project-id="<?php echo $ntprojects->project_id;?>" data-project-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-project-status="2" data-project-id="<?php echo $ntprojects->project_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-project-status="3" data-project-id="<?php echo $ntprojects->project_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-project-status="4" data-project-id="<?php echo $ntprojects->project_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
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
          <h5><?php echo $this->lang->line('xin_in_progress');?> <span><i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-project_status="1"></i></span></h5>
          <?php foreach($inprogress_projects as $inprojects) {?>
          
          <?php
		$ol = '';
		$cc = count(explode(',',$inprojects->assigned_to));
		$iuser = 0;
		foreach(explode(',',$inprojects->assigned_to) as $uid) {
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
		$pedate = $this->Xin_model->set_date_format($inprojects->end_date);
		if($inprojects->project_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($inprojects->project_progress > 20 && $inprojects->project_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($inprojects->project_progress > 50 && $inprojects->project_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$inprojects->project_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$inprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$inprojects->project_progress.'%"></div></div></p>';
		?>
         <div class="input-group overflow" style="background-color: rgb(187, 233, 255); border: none;"> <span><a target="_blank" href="<?php echo site_url('admin/project/detail/').$inprojects->project_id;?>"><?php echo $inprojects->title;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-project-id="<?php echo $inprojects->project_id;?>" data-project-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-project-id="<?php echo $inprojects->project_id;?>" data-project-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-project-status="2" data-project-id="<?php echo $inprojects->project_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-project-status="3" data-project-id="<?php echo $inprojects->project_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-project-status="4" data-project-id="<?php echo $inprojects->project_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
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
          <h5><?php echo $this->lang->line('xin_completed');?> <span><i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-project_status="2"></i></span></h5>
          <?php foreach($completed_projects as $cprojects) {?>
         <?php
		$ol = '';
		$cc = count(explode(',',$cprojects->assigned_to));
		$iuser = 0;
		foreach(explode(',',$cprojects->assigned_to) as $uid) {
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
		$pedate = $this->Xin_model->set_date_format($cprojects->end_date);
		if($cprojects->project_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($cprojects->project_progress > 20 && $cprojects->project_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($cprojects->project_progress > 50 && $cprojects->project_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$cprojects->project_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$cprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$cprojects->project_progress.'%"></div></div></p>';
		?>
          <div class="input-group overflow" style="background-color: rgb(207, 255, 208); border: none;"> <span><a target="_blank" href="<?php echo site_url('admin/project/detail/').$cprojects->project_id;?>"><?php echo $cprojects->title;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-project-id="<?php echo $cprojects->project_id;?>" data-project-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-project-id="<?php echo $cprojects->project_id;?>" data-project-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-project-status="2" data-project-id="<?php echo $cprojects->project_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-project-status="3" data-project-id="<?php echo $cprojects->project_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-project-status="4" data-project-id="<?php echo $cprojects->project_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
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
          <h5><?php echo $this->lang->line('xin_project_cancelled');?> <span><i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-project_status="3"></i></span></h5>
          <?php foreach($cancelled_projects as $cnprojects) {?>
          <?php
		$ol = '';
		$cc = count(explode(',',$cnprojects->assigned_to));
		$iuser = 0;
		foreach(explode(',',$cnprojects->assigned_to) as $uid) {
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
		$pedate = $this->Xin_model->set_date_format($cnprojects->end_date);
		if($cnprojects->project_progress <= 20) {
			$progress_class = 'progress-bar-danger';
		} else if($cnprojects->project_progress > 20 && $cnprojects->project_progress <= 50){
			$progress_class = 'progress-bar-warning';
		} else if($cnprojects->project_progress > 50 && $cnprojects->project_progress <= 75){
			$progress_class = 'progress-bar-info';
		} else {
			$progress_class = 'progress-bar-success';
		}
		$progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$cnprojects->project_progress.'%</span>
		<div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$cnprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$cnprojects->project_progress.'%"></div></div></p>';
		?>
          <div class="input-group overflow" style="background-color: rgb(255, 216, 216); border: none;"> <span><a target="_blank" href="<?php echo site_url('admin/project/detail/').$cnprojects->project_id;?>"><?php echo $cnprojects->title;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-project-id="<?php echo $cnprojects->project_id;?>" data-project-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-project-id="<?php echo $cnprojects->project_id;?>" data-project-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-project-status="2" data-project-id="<?php echo $cnprojects->project_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-project-status="3" data-project-id="<?php echo $cnprojects->project_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-project-status="4" data-project-id="<?php echo $cnprojects->project_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
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
          <h5><?php echo $this->lang->line('xin_project_hold');?> <span><i class="fa fa-plus edit-data add-task" data-toggle="modal" data-target=".edit-modal-data" data-project_status="4"></i></span></h5>
          <?php foreach($hold_projects as $hlprojects) {?>
			  <?php
            $ol = '';
            $cc = count(explode(',',$hlprojects->assigned_to));
            $iuser = 0;
            foreach(explode(',',$hlprojects->assigned_to) as $uid) {
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
            $pedate = $this->Xin_model->set_date_format($hlprojects->end_date);
            if($hlprojects->project_progress <= 20) {
                $progress_class = 'progress-bar-danger';
            } else if($hlprojects->project_progress > 20 && $hlprojects->project_progress <= 50){
                $progress_class = 'progress-bar-warning';
            } else if($hlprojects->project_progress > 50 && $hlprojects->project_progress <= 75){
                $progress_class = 'progress-bar-info';
            } else {
                $progress_class = 'progress-bar-success';
            }
            $progress_bar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$hlprojects->project_progress.'%</span>
            <div class="progress progress-xs"><div class="progress-bar '.$progress_class.' progress-bar-striped" role="progressbar" aria-valuenow="'.$hlprojects->project_progress.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$hlprojects->project_progress.'%"></div></div></p>';
            ?>
          <div class="input-group overflow" style="background-color: rgba(251, 255, 162, 1); border: none;"> <span><a target="_blank" href="<?php echo site_url('admin/project/detail/').$hlprojects->project_id;?>"><?php echo $hlprojects->title;?></a></span>
            <div class="margin-top-10">
              <button class="button button-notstarted" data-project-id="<?php echo $hlprojects->project_id;?>" data-project-status="0"><?php echo $this->lang->line('xin_not_started');?></button>
              <button class="button button-progress" data-project-id="<?php echo $hlprojects->project_id;?>" data-project-status="1"><?php echo $this->lang->line('xin_in_progress');?></button>
              <button class="button button-complete" data-project-status="2" data-project-id="<?php echo $hlprojects->project_id;?>"><?php echo $this->lang->line('xin_completed');?></button>
              <button class="button button-cancelled" data-project-status="3" data-project-id="<?php echo $hlprojects->project_id;?>"><?php echo $this->lang->line('xin_project_cancelled');?></button>
              <button class="button button-hold" data-project-status="4" data-project-id="<?php echo $hlprojects->project_id;?>"><?php echo $this->lang->line('xin_project_hold');?></button>
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

