<?php /* Leave Application view */ ?> 
<?php $session = $this->session->userdata('username');?> 
<?php 
      $user = $this->Xin_model->read_employee_info($session['user_id']);
      $user_info = $this->Xin_model->read_user_info($session['user_id']);
      $get_animate = $this->Xin_model->get_content_animate();
      $role_resources_ids = $this->Xin_model->user_role_resource();
      // dd($user);
?> 

<?php if(in_array('287',$role_resources_ids)) {?> 
  <div class="box mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_add_leave');?> </h3>
        <div class="box-tools pull-right">
          <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary">
              <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?> </button>
          </a>
        </div>
      </div>
      <div id="add_form" class="collapse add-form 
  			<?php echo $get_animate;?>" data-parent="#accordion" style="">
        <div class="box-body"> <?php $attributes = array('name' => 'add_leave', 'id' => 'xin-form', 'autocomplete' => 'off');?> 
          <?php $hidden = array('_user' => $session['user_id']);?> 
          <?php echo form_open('admin/timesheet/add_leave', $attributes, $hidden);?> 
            <div class="bg-white">
              <div class="box-block">
                <div class="row">
                  <div class="col-md-6"> 
                    <input type="hidden" name="company_id" id="company_id" value="<?php echo $user[0]->company_id;?>" /> 
                    <?php $role_resources_ids = $this->Xin_model->user_role_resource();
    				          if(in_array($user_info[0]->user_role_id, array(1,2,4))){ ?> 
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group" id="employee_ajax">
                            <label for="employees" class="control-label"> <?php echo $this->lang->line('xin_employee');?> </label>
                            <select class="form-control" name="employee_id" id="employee_id" data-plugin="select_hrm" data-placeholder=" <?php echo $this->lang->line('xin_choose_an_employee');?>">
                              <option value=""></option>
                              <?php  $all_employees = $this->Xin_model->get_employee(1, null, 1);
                              foreach ($all_employees as $key => $row) { $employee_id = $row->user_id; ?>
                              <option value="<?php echo $employee_id; ?>"> <?php echo $row->first_name .' '. $row->last_name; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group" id="get_leave_types">
                            <label for="leave_type" class="control-label"> <?php echo $this->lang->line('xin_leave_type');?> </label>
                            <select class="form-control" id="leave_type" name="leave_type" data-plugin="select_hrm" data-placeholder="
          										<?php echo $this->lang->line('xin_leave_type');?>">
                              <option value=""></option> 
                            </select>
                          </div>
                        </div>
                      </div> 
                    <?php } else {?> 
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group" id="employee_ajax">
                            <label for="employees" class="control-label"> <?php echo $this->lang->line('xin_employee');?> </label>
                            <select class="form-control" name="employee_id" id="employee_id" data-placeholder=" <?php echo $this->lang->line('xin_choose_an_employee');?>">
                              <?php  $all_employees = $this->Xin_model->get_employee(1, $session['user_id'], 1);
                              foreach ($all_employees as $key => $row) { ?>
                                <option value="<?php echo $row->user_id; ?>"> <?php echo $row->first_name .' '. $row->last_name; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group" id="get_leave_types">
                            <label for="leave_type" class="control-label"> <?php echo $this->lang->line('xin_leave_type');?> </label>
                            <select class="form-control" id="leave_type" name="leave_type" data-plugin="select_hrm" data-placeholder="
                              <?php echo $this->lang->line('xin_leave_type');?>">
                              <option value=""></option> 
                                <?php $leaves = leave_cal($session['user_id']);?>
                                <?php foreach($leaves['leaves'] as $key => $row) {  ?>
                                  <option value="<?php echo $row['id'];?>"><?php echo $row['leave_name'] .' ('.$row['qty'].' '.$this->lang->line('xin_remaining').')';?></option>
                                <?php } ?> 
                            </select>
                          </div>
                        </div>
                      </div> 
                    <?php } ?> 
                  </div>

                  <div class="col-md-6">
                    <div class="form-group col-md-4">
                      <label for="end_date"> <?php echo $this->lang->line('xin_start_date');?> </label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly name="start_date" type="text" value="">
                    </div>

                    <div class="form-group col-md-4">
                      <label for="end_date"> <?php echo $this->lang->line('xin_end_date');?> </label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly name="end_date" type="text" value="">
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <br/>
                        <input type="checkbox" class="form-control minimal" value="1" id="leave_half_day" name="leave_half_day">
                        <label><?php echo $this->lang->line('xin_hr_leave_half_day');?></span> </label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="attachment"> <?php echo $this->lang->line('xin_attachment');?></label>
                        <input type="file" class="form-control-file" id="attachment" name="attachment">
                        <small> <?php echo $this->lang->line('xin_company_file_type');?> </small>
                      </fieldset>
                    </div>
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="summary"> <?php echo $this->lang->line('xin_leave_reason');?> </label>
                  <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_leave_reason');?>" name="reason" cols="30" rows="3" id="reason"></textarea>
                </div>
                
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary" >
                    <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              </div>
            </div> 
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div> 
<?php } ?> 

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('left_leave');?> </h3> <?php if($user_info[0]->user_role_id==1){ ?> <div class="box-tools pull-right">
      <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrsale" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary">
          <span class="fa fa-filter"></span> <?php echo $this->lang->line('xin_filter');?> </button>
      </a>
    </div> <?php } ?>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th> <?php echo $this->lang->line('xin_action');?> </th>
            <th width="300"> <?php echo $this->lang->line('xin_leave_type');?> </th>
            <th> <?php echo $this->lang->line('left_department');?> </th>
            <th> <?php echo $this->lang->line('xin_employee');?> </th>
            <th>
              <i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_leave_duration');?>
            </th>
            <th>
              <i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_applied_on');?>
            </th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    jQuery('[data-plugin="select_hrm"]').select2({ width:'100%' });
    jQuery("#employee_id").change(function(){
      var employee_id = jQuery(this).val();
      jQuery.get(base_url+"/get_employee_assigned_leave_types/"+employee_id, function(data, status){
        jQuery('#get_leave_types').html(data);
      });   
    });
  });
</script>