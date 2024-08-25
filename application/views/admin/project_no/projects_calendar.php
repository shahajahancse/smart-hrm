<?php $session = $this->session->userdata('username');?>

<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-3">
        <div class="box">
          <div class="box-body">
            <div class="box-header with-border">
              <h3 class="box-title"> <?php echo $this->lang->line('xin_hr_calendar_options');?> </h3>
            </div>
            
            <div class="list-group" id="list_group">
              <span class="list-group-item calendar-options text-green hrsale-drag-option" data-record="0"> <i class="ion ion-thumbsup"></i> <?php echo $this->lang->line('xin_completed');?></span>
              <span class="list-group-item calendar-options text-aqua hrsale-drag-option" data-record="0"> <i class="fa fa-server"></i> <?php echo $this->lang->line('xin_in_progress');?></span>
              <span class="list-group-item calendar-options text-purple hrsale-drag-option" data-record="0"> <i class="fa fa-life-bouy"></i> <?php echo $this->lang->line('xin_not_started');?></span>
              <span class="list-group-item calendar-options text-red hrsale-drag-option" data-record="0"> <i class="fa fa-cube"></i> <?php echo $this->lang->line('xin_project_cancelled');?></span>
              <span class="list-group-item calendar-options text-yellow hrsale-drag-option" data-record="0"> <i class="fa fa-space-shuttle"></i> <?php echo $this->lang->line('xin_project_hold');?></span>
            </div>  
            </div>
            <div class="box-body">
            <?php $attributes = array('name' => 'hr_calendar_option', 'id' => 'xin-form', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('', $attributes, $hidden);?>
            <input type="hidden" id="exact_date" value="" />
            <div class="form-body">
              <div class="form-group">
                <label for="set_date"><?php echo $this->lang->line('xin_set_date');?></label>
                <input class="form-control set_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="set_date" name="set_date" type="text" value="<?php if(isset($_POST['set_date'])){ echo $_POST['set_date']; } else { echo date('Y-m-d'); }?>">
              </div>
            </div>
            <div class="form-actions right">
              <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_get');?></button>
            </div>
            <?php echo form_close(); ?>
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