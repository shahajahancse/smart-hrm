<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('name' => 'attendance_daily_report', 'id' => 'attendance_daily_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/timesheet/attendance_list', $attributes, $hidden);?>
        <?php
			$data = array(
			  'type'        => 'hidden',
			  'name'        => 'date_format',
			  'id'          => 'date_format',
			  'value'       => $this->Xin_model->set_date_format(date('Y-m-d')),
			  'class'       => 'form-control',
			);
			echo form_input($data);
			?>
        <div class="row">
        <?php if($user_info[0]->user_role_id==1){ ?>
            <div class="col-md-4">
                <div class="form-group">
                <label for="name"><?php echo $this->lang->line('left_location');?></label>
                <select name="location_id" id="location_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                <?php foreach($all_office_shifts as $elocation) {?>
                <option value="<?php echo $elocation->location_id?>"><?php echo $elocation->location_name?></option>
                <?php } ?>
                </select>
                </div>
            </div>
            <?php } else {?>
            <input type="hidden" value="0" name="location_id" id="location_id" />
            <?php } ?>
            <div class="col-md-4">
            <div class="form-group">
              <label for="first_name"><?php echo $this->lang->line('xin_e_details_date');?></label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" readonly id="attendance_date" name="attendance_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group"> &nbsp;
              <label for="first_name">&nbsp;</label><br />
              <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_get');?></button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('xin_daily_attendance_report');?></h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th colspan="2"><?php echo $this->lang->line('xin_hr_info');?></th>
            <th colspan="9"><?php echo $this->lang->line('xin_attendance_report');?></th>
          </tr>
          <tr>
            <th style="width:120px;"><?php echo $this->lang->line('xin_employee');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('left_company');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_xin_status');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_clock_in');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_clock_out');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_late');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_early_leaving');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_overtime');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_total_work');?></th>
            <th style="width:100px;"><?php echo $this->lang->line('dashboard_total_rest');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
