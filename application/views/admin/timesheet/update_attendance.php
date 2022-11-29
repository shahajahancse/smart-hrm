<?php
/* Update Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-4">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('left_update_attendance');?> </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'update_attendance_report', 'id' => 'update_attendance_report', 'autocomplete' => 'off');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/timesheet/update_attendance', $attributes, $hidden);?>
            <?php
				$data = array(
				  'name'        => 'emp_id',
				  'id'          => 'emp_id',
				  'value'       => $session['user_id'],
				  'type'   		=> 'hidden',
				  'class'       => 'form-control',
				);
			
				echo form_input($data);
				?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                  <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_e_details_date');?>" readonly id="attendance_date" name="attendance_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <?php } else if(in_array('310',$role_resources_ids)) {?>
                <?php $ecompany_id = $user_info[0]->company_id;?>
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>" required>
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <?php if($ecompany_id == $company->company_id):?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php endif;?>
                    <?php } ?>
                  </select>
                </div>
                <?php } ?>
                <?php if($user_info[0]->user_role_id==1 || in_array('310',$role_resources_ids)){ ?>
                <div class="form-group" id="employee_ajax">
                  <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
                  <select disabled="disabled" name="employee_id" id="employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                  </select>
                </div>
                <?php } else {?>
                <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $session['user_id'];?>" />
                <?php }?>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_get');?> </button>
                </div>
              </div>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8 <?php echo $get_animate;?>">
    <div class="box mb-4">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('left_update_attendance');?></h3>
        <div class="box-tools pull-right">
        <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
		<?php if(in_array('277',$role_resources_ids)) {?>
          <button type="button" class="btn btn-xs btn-outline-primary" id="add_attendance_btn" data-toggle="modal" style="display:none;" data-target=".add-modal-data"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
          <?php } else {?>
          <span id="add_attendance_btn" style="display:none;">&nbsp;</span>
          <?php } ?>
        </div>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('xin_in_time');?></th>
                <th><?php echo $this->lang->line('xin_out_time');?></th>
                <th><?php echo $this->lang->line('dashboard_total_work');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
