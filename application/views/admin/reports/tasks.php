<?php
/* Tasks report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-3">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_hr_report_filters');?> </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'task_reports', 'id' => 'task_reports', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('euser_id' => $session['user_id']);?>
            <?php echo form_open('admin/reports/task_reports', $attributes, $hidden);?>
            <?php
				$data = array(
				  'name'        => 'user_id',
				  'id'          => 'user_id',
				  'type'        => 'hidden',
				  'value'   	   => $session['user_id'],
				  'class'       => 'form-control',
				);
			
			echo form_input($data);
			?>
			<?php
			$user_info = $this->Xin_model->read_user_info($session['user_id']);
			if($user_info[0]->user_role_id==1){
				$etask = $_tasks->result();
			} else {
				$itask = $this->Timesheet_model->get_employee_tasks($session['user_id']);
				$etask = $itask->result();
			}
			?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('xin_worksheets');?></label>
                  <select class="form-control" name="project_id" id="project_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_projects');?>" required>
                    <option value="0"><?php echo $this->lang->line('xin_hr_reports_tasks_all');?></option>
                    <?php foreach($etask as $tasks) {?>
                    <option value="<?php echo $tasks->task_id?>"><?php echo $tasks->task_name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                  <select name="status" id="status" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                    <option value="4"><?php echo $this->lang->line('xin_acc_all');?></option>
                    <option value="0"><?php echo $this->lang->line('xin_not_started');?></option>
                    <option value="1"><?php echo $this->lang->line('xin_in_progress');?></option>
                    <option value="2"><?php echo $this->lang->line('xin_completed');?></option>
                    <option value="3"><?php echo $this->lang->line('xin_deffered');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_get');?> </button>
            </div>
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 <?php echo $get_animate;?>">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('xin_hr_reports_tasks');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                <th><?php echo $this->lang->line('xin_start_date');?></th>
                <th><?php echo $this->lang->line('xin_end_date');?></th>
                <th><?php echo $this->lang->line('xin_assigned_to');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
