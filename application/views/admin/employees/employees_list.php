
<?php $result = $this->Department_model->ajax_location_departments_information(1);?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<div class="row <?php echo $get_animate;?>">
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-success-4 mr-3">
                    <i class="fa fa-user"></i>
                </span>
                <div>
                    <h5 class="mb-1"> <b> <?php echo active_employees();?> <?php echo $this->lang->line('xin_employees_active');?></b></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-danger-4 mr-3">
                    <i class="fa fa-user-times"></i>
                </span>
                <div>
                    <h5 class="mb-1"><b><a href="<?php echo base_url('admin/employees/inactive_employee')?>"><?php echo inactive_employees();?> <?php echo $this->lang->line('xin_employees_inactive');?></a></b></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-secondary mr-3">
                    <i class="fa fa-male"></i>
                </span>
                <div>
                    <h5 class="mb-1"><b><?php echo $this->Xin_model->male_employees();?>% <?php echo $this->lang->line('xin_gender_male');?></b></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-warning-4 mr-3">
                    <i class="fa fa-female"></i>
                </span>
                <div>
                    <h5 class="mb-1"><b><?php echo $this->Xin_model->female_employees();?>% <?php echo $this->lang->line('xin_gender_female');?></b></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($user_info[0]->user_role_id==1){ ?>
<div id="filter_hrsale" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
  <div class="box mb-4 <?php echo $get_animate;?>">
    <div class="box-header  with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_filter_employee');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrsale" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-minus"></span> <?php echo $this->lang->line('xin_hide');?></button>
        </a> </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
          <?php $hidden = array('user_id' => $session['user_id']);?>
          <?php echo form_open('admin/employees/employees_list', $attributes, $hidden);?>
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
              <div class="col-md-3">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?></label>
                  <select class="form-control" name="company_id" id="filter_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3" id="location_ajaxflt">
              <div class="form-group">
                <label for="name"><?php echo $this->lang->line('left_location');?></label>
                <select name="location_id" id="filter_location" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                  <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                </select>
              </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" id="department_ajaxflt">
                  <label for="department"><?php echo $this->lang->line('left_department');?></label>
                  <select class="form-control" id="filter_department" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" >
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-2" id="designation_ajaxflt">
                <div class="form-group">
                  <label for="designation"><?php echo $this->lang->line('xin_designation');?></label>
                  <select class="form-control" name="designation_id" data-plugin="select_hrm"  id="filter_designation" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-1"><label for="designation">&nbsp;</label><?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_get'))); ?>
              </div>
          </div>
          <!--<div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_get'))); ?> </div>-->
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>


<?php if(in_array('201',$role_resources_ids)) {?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header  with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_add_new');?> <?php echo $this->lang->line('xin_employee');?></h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>

    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('name' => 'add_employee', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('_user' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/employees/add_employee', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?><i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="last_name" class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?><span style="color:red" class="hrsale-asterisk">*</span></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="">
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label for="employee_id" class="control-label"><?php echo $this->lang->line('dashboard_employee_id');?><i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_employee_id');?>" name="employee_id" type="text" value="">
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label for="proxi_id" class="control-label"><?php echo"Proxi Id";?><i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <input class="form-control" placeholder="Punch device id" name="proxi_id" type="text" value="">
              </div>
            </div>
            <input type="hidden" name="company_id" value="1">
            <input type="hidden" name="location_id" value="1">
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group" id="ajx_department">
                <label for="designation"><?php echo $this->lang->line('xin_hr_main_department');?><i class="hrsale-asterisk">*</i></label>
                <select class="select2" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_department');?>" name="department_id" id="aj_subdepartments" >
                  <option value=""></option>
                  <?php foreach($result as $deparment) {?>
                  <option value="<?php echo $deparment->department_id?>"><?php echo $deparment->department_name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-4" id="designation_ajax">
              <div class="form-group">
                <label for="designation"><?php echo $this->lang->line('xin_designation');?><i class="hrsale-asterisk">*</i></label>
                <select class="form-control" name="designation_id" data-plugin="select_hrm" disabled="disabled" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="email" class="control-label"><?php echo $this->lang->line('dashboard_email');?><i class="hrsale-asterisk"><!-- <span style="color:red">*</span> --></i></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email" type="text" value="">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="date_of_joining" class="control-label"><?php echo $this->lang->line('xin_employee_doj');?><i class="hrsale-asterisk"></i></label>
                <input class="form-control date_of_joining" readonly placeholder="<?php echo $this->lang->line('xin_employee_doj');?>" name="date_of_joining" type="text" value="">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="probition" class="control-label">Probation month<i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <input class="form-control" placeholder="Number of probition month" name="probation" type="text" value="">
              </div>
            </div>


            <div class="col-md-4">
              <div class="form-group">
                <label for="date_of_birth"><?php echo $this->lang->line('xin_employee_dob');?><i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <input class="form-control date_of_birth" readonly placeholder="<?php echo $this->lang->line('xin_employee_dob');?>" name="date_of_birth" type="text" value="">
              </div>
            </div>
          </div>

          <input type="hidden" name="subdepartment_id" value="YES" />

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                  <option value="Male"><?php echo $this->lang->line('xin_gender_male');?></option>
                  <option value="Female"><?php echo $this->lang->line('xin_gender_female');?></option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="office_shift_id" class="control-label"><?php echo $this->lang->line('xin_employee_office_shift');?></label>
                <select class="form-control" name="office_shift_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_office_shift');?>">
                  <?php foreach($all_office_shifts as $shift) {?>
                  <option value="<?php echo $shift->office_shift_id?>"><?php echo $shift->shift_name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="role"><?php echo $this->lang->line('xin_employee_role');?><i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <select class="form-control" name="role" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_role');?>">
                  <option value=""></option>
                  <?php foreach($all_user_roles as $role) {?>
                  <?php if($user_info[0]->user_role_id==1){?>
                  <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                  <?php } else {?>
                    <?php if($role->role_id!=1){?>
                    <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                    <?php } ?>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="xin_hr_leave_cat"><?php echo $this->lang->line('xin_hr_leave_cat');?></label>
                <input type="hidden" name="leave_categories[]" value="0" />
                <select multiple="multiple" class="form-control" name="leave_categories[]" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_hr_leave_cat');?>">
                  <?php foreach($all_leave_types as $leave_type) {?>
                  <option value="<?php echo $leave_type->leave_type_id?>"><?php echo $leave_type->type_name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="contact_no" class="control-label"><?php echo $this->lang->line('xin_contact_number');?><i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>" name="contact_no" type="text" value="">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="username">Username<i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <input class="form-control" placeholder="Username" name="username" type="text" value="">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="xin_employee_password"><?php echo $this->lang->line('xin_employee_password');?><i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_password');?>" name="password" type="text" value="">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="confirm_password" class="control-label"><?php echo $this->lang->line('xin_employee_cpassword');?><i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_cpassword');?>" name="confirm_password" type="text" value="">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_employee_address');?></label>
                <input type="text" class="form-control" placeholder="<?php echo $this->lang->line('xin_employee_address');?>" name="address">
              </div>
            </div>
          </div>

          <div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?> </div>

        </div>


        <?php $count_module_attributes = $this->Custom_fields_model->count_module_attributes();?>
        <?php $module_attributes = $this->Custom_fields_model->all_hrsale_module_attributes();?>

        <?php if($count_module_attributes > 0):?>
          <div class="row">
           <?php foreach($module_attributes as $mattribute):?>
            <?php if($mattribute->attribute_type == 'date'){?>
            <div class="col-md-4">
              <div class="form-group">
                <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                <input class="form-control date" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
              </div>
            </div>
            <?php } else if($mattribute->attribute_type == 'select'){?>
            <div class="col-md-4">
            <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
              <div class="form-group">
                <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                <select class="form-control" name="<?php echo $mattribute->attribute;?>" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                  <?php foreach($iselc_val as $selc_val) {?>
                  <option value="<?php echo $selc_val->attributes_select_value_id?>"><?php echo $selc_val->select_label?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php } else if($mattribute->attribute_type == 'multiselect'){?>
            <div class="col-md-4">
            <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
              <div class="form-group">
                <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                <select multiple="multiple" class="form-control" name="<?php echo $mattribute->attribute;?>[]" data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                  <?php foreach($imulti_selc_val as $multi_selc_val) {?>
                  <option value="<?php echo $multi_selc_val->attributes_select_value_id?>"><?php echo $multi_selc_val->select_label?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php } else if($mattribute->attribute_type == 'textarea'){?>
            <div class="col-md-8">
              <div class="form-group">
                <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
              </div>
            </div>
            <?php } else if($mattribute->attribute_type == 'fileupload'){?>
            <div class="col-md-4">
              <div class="form-group">
                <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                <input class="form-control-file" name="<?php echo $mattribute->attribute;?>" type="file">
              </div>
            </div>
            <?php } else { ?>
            <div class="col-md-4">
              <div class="form-group">
                <label for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>" name="<?php echo $mattribute->attribute;?>" type="text">
              </div>
            </div>
            <?php } ?>
            <?php endforeach;?>
          </div>
        <?php endif;?>

        <?php echo form_close(); ?> 

      </div>
    </div>

  </div>
</div>
<?php }?>


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_employees');?> </h3>
    <?php if($user_info[0]->user_role_id==1){ ?>
    <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrsale" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-filter"></span> <?php echo $this->lang->line('xin_filter');?></button>
       </a> <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="fa fa-bar-chart"></span> <?php echo $this->lang->line('xin_report');?> <span class="fa fa-caret-down"></span></button>
       <ul class="dropdown-menu">
        <li><a href="<?php echo site_url('admin/reports/employees/');?>" target="_blank"><?php echo $this->lang->line('xin_filter_employement_report');?></a></li>
      </ul></div>
      <?php } ?>
  </div>

  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th style="width:80px;"><?php echo $this->lang->line('xin_action');?></th>
            <th width="200"><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_employees_full_name');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><?php echo $this->lang->line('dashboard_contact');?></th>
            <th><?php echo $this->lang->line('xin_employee_role');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>


<!-- left resign modal -->
<div class="modal fadeInLeft animated " role="dialog" aria-hidden="true" id="left-resign-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-danger">
        <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong>
      </div>
      <?php $attributes = array('name' => 'delete_record', 'id' => 'delete_record', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>
        <?php echo form_open('', $attributes, $hidden);?> 
        <div class="modal-footer">
        
    <?php
    $del_token = array(
      'type'  => 'hidden',
      'id'  => 'token_type',
      'name'  => 'token_type',
      'value' => 0,
    );
    echo form_input($del_token);
    ?>
        
    <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> 
    <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  $(document).ready(function(){
    // get designations
    jQuery("#aj_subdepartments").change(function(){
      jQuery.get(base_url+"/is_designation/"+jQuery(this).val(), function(data, status){
        jQuery('#designation_ajax').html(data);
      });
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({ width:'100%' });

  });
</script>

<script>
  function left_resign(id) {
    alert(id)
     $("#left-resign-modal").modal("show");
  }
</script>