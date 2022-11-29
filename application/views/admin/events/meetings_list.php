<?php
/* Meetings view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?php echo $get_animate;?>">
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php if(in_array('273',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="col-md-4">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"> <?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_hr_meeting');?> </h3>
    </div>
    <div class="box-body">
      <?php $attributes = array('name' => 'add_meeting', 'id' => 'xin-form', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
      <?php $hidden = array('user_id' => $session['user_id']);?>
      <?php echo form_open('admin/meetings/add_meeting', $attributes, $hidden);?>
      <div class="row">
        <div class="col-md-12">
          <?php if($user_info[0]->user_role_id==1){ ?>
          <div class="form-group">
            <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
            <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
              <option value=""></option>
              <?php foreach($get_all_companies as $company) {?>
              <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
              <?php } ?>
            </select>
          </div>
          <?php } else {?>
          <?php $ecompany_id = $user_info[0]->company_id;?>
            <div class="form-group">
            <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
            <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
              <option value=""></option>
              <?php foreach($get_all_companies as $company) {?>
              <?php if($ecompany_id == $company->company_id):?>
              <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
              <?php endif;?>
              <?php } ?>
            </select>
          </div>
            <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group" id="employee_ajax">
            <label for="first_name"><?php echo $this->lang->line('dashboard_single_employee');?></label>
            <select disabled="disabled" class="form-control" name="employee_id" id="employee_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
              <option value=""></option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="meeting_title"><?php echo $this->lang->line('xin_hr_meeting_title');?></label>
            <input type="text" class="form-control" name="meeting_title" placeholder="<?php echo $this->lang->line('xin_hr_meeting_title');?>">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="meeting_date"><?php echo $this->lang->line('xin_hr_meeting_date');?></label>
            <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_hr_meeting_date');?>" readonly name="meeting_date" type="text">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="meeting_time"><?php echo $this->lang->line('xin_hr_meeting_time');?></label>
            <input class="form-control timepicker" placeholder="<?php echo $this->lang->line('xin_hr_meeting_time');?>" readonly name="meeting_time" type="text">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="meeting_room"><?php echo $this->lang->line('xin_meeting_room');?></label>
            <input type="text" class="form-control" name="meeting_room" placeholder="<?php echo $this->lang->line('xin_meeting_room');?>">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="event_note"><?php echo $this->lang->line('xin_hr_meeting_note');?></label>
            <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_hr_meeting_note');?>" name="meeting_note" id="meeting_note"></textarea>
          </div>
        </div>
      </div>
      <div class="form-actions box-footer">
        <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
      </div>
      <?php echo form_close(); ?> </div>
  </div>
</div>
<?php $colmdval = 'col-md-8';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_hr_meetings');?> </h3>
    </div>
    <div class="box-body">
      <div class="box-datatable table-responsive">
        <table class="datatables-demo table table-striped table-bordered" id="xin_table">
          <thead>
            <tr>
              <th style="width:100px;"><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('left_company');?></th>
              <th><?php echo $this->lang->line('xin_hr_meeting_title');?></th>
              <th><?php echo $this->lang->line('xin_hr_meeting_date');?></th>
              <th><?php echo $this->lang->line('xin_hr_meeting_time');?></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>
