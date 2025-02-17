<?php $result = $this->Department_model->ajax_location_departments_information(1);?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $lefts = $this->Xin_model->left_resign_list(1); ?>
<?php $resigns = $this->Xin_model->left_resign_list(2); ?>
<div class="row <?php echo $get_animate;?>">
    <div class="col-sm-6 col-lg-3">
        <div class="card p-3">
            <div class="d-flex align-items-center">
                <span class="stamp-hrsale-4 stamp-hrsale-md bg-hrsale-success-4 mr-3">
                    <i class="fa fa-user"></i>
                </span>
                <div>
                    <h5 class="mb-1"> <b> <?php echo active_employees();?>
                            <?php echo $this->lang->line('xin_employees_active');?></b></h5>
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
                    <h5 class="mb-1"><b><?php echo inactive_employees();?>
                            <?php echo $this->lang->line('xin_employees_inactive');?></b></h5>
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
                    <h5 class="mb-1"><b><?php echo $this->Xin_model->male_employees();?>%
                            <?php echo $this->lang->line('xin_gender_male');?></b></h5>
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
                    <h5 class="mb-1"><b><?php echo $this->Xin_model->female_employees();?>%
                            <?php echo $this->lang->line('xin_gender_female');?></b></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($user_info[0]->user_role_id==1 || $user_info[0]->user_role_id==2 ) { ?>
<div id="filter_hrsale" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
    <div class="box mb-4 <?php echo $get_animate;?>">
        <div class="box-header  with-border">
            <h3 class="box-title"><?php echo $this->lang->line('xin_filter_employee');?></h3>
            <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse"
                    href="#filter_hrsale" aria-expanded="false">
                    <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-minus"></span>
                        <?php echo $this->lang->line('xin_hide');?></button>
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
                                <select class="form-control" name="company_id" id="filter_company"
                                    data-plugin="select_hrm"
                                    data-placeholder="<?php echo $this->lang->line('left_company');?>">
                                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                                    <?php foreach($get_all_companies as $company) {?>
                                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="location_ajaxflt">
                            <div class="form-group">
                                <label for="name"><?php echo $this->lang->line('left_location');?></label>
                                <select name="location_id" id="filter_location" class="form-control"
                                    data-plugin="select_hrm"
                                    data-placeholder="<?php echo $this->lang->line('left_location');?>">
                                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" id="department_ajaxflt">
                                <label for="department"><?php echo $this->lang->line('left_department');?></label>
                                <select class="form-control" id="filter_department" name="department_id"
                                    data-plugin="select_hrm"
                                    data-placeholder="<?php echo $this->lang->line('left_department');?>">
                                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" id="designation_ajaxflt">
                            <div class="form-group">
                                <label for="designation"><?php echo $this->lang->line('xin_designation');?></label>
                                <select class="form-control" name="designation_id" data-plugin="select_hrm"
                                    id="filter_designation"
                                    data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1"><label
                                for="designation">&nbsp;</label><?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_get'))); ?>
                        </div>
                    </div>
                    <!--<div class="form-actions box-footer"> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_get'))); ?> </div>-->
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<?php if(in_array('201', $role_resources_ids)) {?>
<div class="box mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
        <div class="box-header  with-border">
            <h3 class="box-title"><?php echo $this->lang->line('xin_add_new');?>
                <?php echo $this->lang->line('xin_employee');?></h3>
            <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form"
                    aria-expanded="false">
                    <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span>
                        <?php echo $this->lang->line('xin_add_new');?></button>
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
                                <label for="first_name"><?php echo $this->lang->line('xin_employee_first_name');?><i
                                        class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input class="form-control"
                                    placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>"
                                    name="first_name" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="last_name"
                                    class="control-label"><?php echo $this->lang->line('xin_employee_last_name');?><span
                                        style="color:red" class="hrsale-asterisk">*</span></label>
                                <input class="form-control"
                                    placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>"
                                    name="last_name" type="text" value="">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="employee_id"
                                    class="control-label"><?php echo $this->lang->line('dashboard_employee_id');?><i
                                        class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input class="form-control"
                                    placeholder="<?php echo $this->lang->line('dashboard_employee_id');?>"
                                    name="employee_id" type="text" value="">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="proxi_id" class="control-label">Punch id<i class="hrsale-asterisk"><span
                                            style="color:red">*</span></i></label>
                                <input class="form-control" placeholder="Punch device id" name="proxi_id" type="text"
                                    value="" required>
                            </div>
                        </div>

                        <input type="hidden" name="company_id" value="1">
                        <input type="hidden" name="location_id" value="1">
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="proxi_id" class="control-label">Set Salary<i class="hrsale-asterisk"><span
                                            style="color:red">*</span></i></label>
                                <input class="form-control" placeholder="Set Salary" name="salary" type="text" value=""
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" id="ajx_department">
                                <label for="designation"><?php echo $this->lang->line('xin_hr_main_department');?><i
                                        class="hrsale-asterisk">*</i></label>
                                <select class="select2" data-plugin="select_hrm"
                                    data-placeholder="<?php echo $this->lang->line('xin_select_department');?>"
                                    name="department_id" id="aj_subdepartments">
                                    <option value=""></option>
                                    <?php foreach($result as $deparment) {?>
                                    <option value="<?php echo $deparment->department_id?>">
                                        <?php echo $deparment->department_name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" id="designation_ajax">
                            <div class="form-group">
                                <label for="designation"><?php echo $this->lang->line('xin_designation');?><i
                                        class="hrsale-asterisk">*</i></label>
                                <select class="form-control" name="designation_id" data-plugin="select_hrm"
                                    disabled="disabled"
                                    data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email"
                                    class="control-label"><?php echo $this->lang->line('dashboard_email');?><i
                                        class="hrsale-asterisk">
                                        <!-- <span style="color:red">*</span> -->
                                    </i></label>
                                <input class="form-control"
                                    placeholder="<?php echo $this->lang->line('dashboard_email');?>" name="email"
                                    type="text" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_of_joining"
                                    class="control-label"><?php echo $this->lang->line('xin_employee_doj');?><i
                                        class="hrsale-asterisk"></i></label>
                                <input class="form-control date_of_joining" readonly
                                    placeholder="<?php echo $this->lang->line('xin_employee_doj');?>"
                                    name="date_of_joining" type="text" value="">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="probition" class="control-label">Intern/Probation month<i
                                        class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input class="form-control" placeholder="Number of probition month" name="probation"
                                    type="text" value="">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?><i
                                        class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <select name="status" id="status" class="form-control" data-plugin="select_hrm">
                                    <option> Select Status </option>
                                    <option value="4">Internship</option>
                                    <option value="5">Probation</option>
                                    <option value="1">Regular</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="floor_status">Floor Set<i class="hrsale-asterisk"><span
                                            style="color:red">*</span></i></label>
                                <select name="floor_status" id="floor_status" class="form-control">
                                    <option>Select Floor</option>
                                    <option value="3">3 <sup>rd</sup></option>
                                    <option value="5">5 <sup>th</sup></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date_of_birth"><?php echo $this->lang->line('xin_employee_dob');?><i
                                        class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input class="form-control date_of_birth" readonly
                                    placeholder="<?php echo $this->lang->line('xin_employee_dob');?>"
                                    name="date_of_birth" type="text" value="">
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="subdepartment_id" value="YES" />

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gender"
                                    class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label>
                                <select class="form-control" name="gender" data-plugin="select_hrm"
                                    data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                                    <option value="Male"><?php echo $this->lang->line('xin_gender_male');?></option>
                                    <option value="Female"><?php echo $this->lang->line('xin_gender_female');?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="office_shift_id"
                                    class="control-label"><?php echo $this->lang->line('xin_employee_office_shift');?></label>
                                <select class="form-control" name="office_shift_id" data-plugin="select_hrm"
                                    data-placeholder="<?php echo $this->lang->line('xin_employee_office_shift');?>">
                                    <?php foreach($all_office_shifts as $shift) {?>
                                    <option value="<?php echo $shift->office_shift_id?>"><?php echo $shift->shift_name?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="role"><?php echo $this->lang->line('xin_employee_role');?><i
                                        class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <select class="form-control" name="role" data-plugin="select_hrm"
                                    data-placeholder="<?php echo $this->lang->line('xin_employee_role');?>">
                                    <option value=""></option>
                                    <?php foreach($all_user_roles as $role) {?>
                                    <?php if($user_info[0]->user_role_id==1) {?>
                                    <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                                    <?php } else {?>
                                    <?php if($role->role_id!=1) {?>
                                    <option value="<?php echo $role->role_id?>"><?php echo $role->role_name?></option>
                                    <?php } ?>
                                    <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="xin_hr_leave_cat">Employee or Lead</label>
                                <select class="form-control" name="is_emp_lead">
                                    <option value="1">Employee</option>
                                    <option value="2">Team Lead</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="xin_hr_leave_cat">Team Leader</label>
                                <select class="form-control" name="is_emp_lead">
                                    <?php
                                        $team_leads = $this->db->select('user_id,first_name,last_name')->where('is_emp_lead',2)->get('xin_employees')->result(); 
                                        foreach($team_leads as $row){
                                    ?>
                                    <option value="<?php echo $row->user_id?>"><?php echo $row->first_name." ".$row->last_name?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label
                                    for="xin_hr_leave_cat"><?php echo $this->lang->line('xin_hr_leave_cat');?></label>
                                <input type="hidden" name="leave_categories[]" value="0" />
                                <select multiple="multiple" class="form-control" name="leave_categories[]"
                                    data-plugin="select_hrm"
                                    data-placeholder="<?php echo $this->lang->line('xin_hr_leave_cat');?>">
                                    <?php foreach($all_leave_types as $leave_type) {?>
                                    <option value="<?php echo $leave_type->leave_type_id?>">
                                        <?php echo $leave_type->type_name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="contact_no"
                                    class="control-label"><?php echo $this->lang->line('xin_contact_number');?><i
                                        class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input class="form-control"
                                    placeholder="<?php echo $this->lang->line('xin_contact_number');?>"
                                    name="contact_no" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="username">Username<i class="hrsale-asterisk"><span
                                            style="color:red">*</span></i></label>
                                <input class="form-control" placeholder="Username" name="username" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label
                                    for="xin_employee_password"><?php echo $this->lang->line('xin_employee_password');?><i
                                        class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input class="form-control"
                                    placeholder="<?php echo $this->lang->line('xin_employee_password');?>"
                                    name="password" type="text" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="confirm_password"
                                    class="control-label"><?php echo $this->lang->line('xin_employee_cpassword');?><i
                                        class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input class="form-control"
                                    placeholder="<?php echo $this->lang->line('xin_employee_cpassword');?>"
                                    name="confirm_password" type="text" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address"><?php echo $this->lang->line('xin_employee_address');?></label>
                                <input type="text" class="form-control"
                                    placeholder="<?php echo $this->lang->line('xin_employee_address');?>"
                                    name="address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Permanent Address</label>
                                <input type="text" class="form-control" placeholder="Enter Permanent Address"name="per_address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Emergency Contact</h4>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="relation"><?php echo $this->lang->line('xin_e_details_relation');?><i
                                            class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                    <select class="form-control" name="relation" data-plugin="select_hrm"
                                        data-placeholder="<?php echo $this->lang->line('xin_select_one');?>" required>
                                        <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                                        <option value="Self"><?php echo $this->lang->line('xin_self');?></option>
                                        <option value="Parent"><?php echo $this->lang->line('xin_parent');?></option>
                                        <option value="Spouse"><?php echo $this->lang->line('xin_spouse');?></option>
                                        <option value="Child"><?php echo $this->lang->line('xin_child');?></option>
                                        <option value="Sibling"><?php echo $this->lang->line('xin_sibling');?></option>
                                        <option value="In Laws"><?php echo $this->lang->line('xin_in_laws');?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name"
                                        class="control-label"><?php echo $this->lang->line('xin_name');?><i
                                            class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                    <input class="form-control"
                                        placeholder="<?php echo $this->lang->line('xin_name');?>" name="contact_name"
                                        type="text" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" id="designation_ajax">
                                    <label for="address_1"
                                        class="control-label"><?php echo $this->lang->line('xin_address');?></label>
                                    <input class="form-control"
                                        placeholder="<?php echo $this->lang->line('xin_address');?>" name="address_1"
                                        type="text" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="work_phone"><?php echo $this->lang->line('xin_phone');?><i
                                            class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                    <input class="form-control"
                                        placeholder="<?php echo $this->lang->line('xin_phone');?>" name="e_phone_number"
                                        type="text" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12" style="display:flex;flex-direction:row">
                                    <div class='form-group'>
                                        <fieldset class="form-group">
                                            <label for="logo">Profile Picture<i class="hrsale-asterisk"><span
                                                        style="color:red">*</span></i></label>
                                            <input type="file" class="form-control-file" id="p_file" name="p_file"
                                                accept=".gif, .png, .jpg, .jpeg">
                                            <small><?php echo $this->lang->line('xin_e_details_picture_type');?></small>
                                        </fieldset>
                                    </div>
                                    <div class='form-group'>
                                        <fieldset class="form-group">
                                            <label for="logo">Note</label>
                                            <input type="file" class="form-control-file" id="n_file" name="n_file"
                                                accept=".gif, .png, .jpg, .jpeg">
                                            <small><?php echo $this->lang->line('xin_e_details_picture_type');?></small>
                                        </fieldset>
                                    </div>
                                    <div class='form-group'>
                                        <fieldset class="form-group">
                                            <label for="logo">Remark</label>
                                            <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions box-footer">
                        <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_save'))); ?>
                    </div>
                </div>
                <?php $count_module_attributes = $this->Custom_fields_model->count_module_attributes();?>
                <?php $module_attributes = $this->Custom_fields_model->all_hrsale_module_attributes();?>
                <?php if($count_module_attributes > 0):?>
                <div class="row">
                    <?php foreach($module_attributes as $mattribute):?>
                    <?php if($mattribute->attribute_type == 'date') {?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label
                                for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                            <input class="form-control date" placeholder="<?php echo $mattribute->attribute_label;?>"
                                name="<?php echo $mattribute->attribute;?>" type="text">
                        </div>
                    </div>
                    <?php } elseif($mattribute->attribute_type == 'select') {?>
                    <div class="col-md-4">
                        <?php $iselc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                        <div class="form-group">
                            <label
                                for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                            <select class="form-control" name="<?php echo $mattribute->attribute;?>"
                                data-plugin="select_hrm" data-placeholder="<?php echo $mattribute->attribute_label;?>">
                                <?php foreach($iselc_val as $selc_val) {?>
                                <option value="<?php echo $selc_val->attributes_select_value_id?>">
                                    <?php echo $selc_val->select_label?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } elseif($mattribute->attribute_type == 'multiselect') {?>
                    <div class="col-md-4">
                        <?php $imulti_selc_val = $this->Custom_fields_model->get_attribute_selection_values($mattribute->custom_field_id);?>
                        <div class="form-group">
                            <label
                                for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                            <select multiple="multiple" class="form-control"
                                name="<?php echo $mattribute->attribute;?>[]" data-plugin="select_hrm"
                                data-placeholder="<?php echo $mattribute->attribute_label;?>">
                                <?php foreach($imulti_selc_val as $multi_selc_val) {?>
                                <option value="<?php echo $multi_selc_val->attributes_select_value_id?>">
                                    <?php echo $multi_selc_val->select_label?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php } elseif($mattribute->attribute_type == 'textarea') {?>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label
                                for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                            <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>"
                                name="<?php echo $mattribute->attribute;?>" type="text">
                        </div>
                    </div>
                    <?php } elseif($mattribute->attribute_type == 'fileupload') {?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label
                                for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                            <input class="form-control-file" name="<?php echo $mattribute->attribute;?>" type="file">
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label
                                for="<?php echo $mattribute->attribute;?>"><?php echo $mattribute->attribute_label;?></label>
                            <input class="form-control" placeholder="<?php echo $mattribute->attribute_label;?>"
                                name="<?php echo $mattribute->attribute;?>" type="text">
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
        

        <h3 class="box-title">Employee List</h3>
        <!-- <?php 
        //if($user_info[0]->user_role_id==1) {
             ?> -->
        <div class="box-tools pull-right">
            <button class="btn btn-sm btn-info" id="inactive">Left Or Resign List</button>
            <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrsale" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-filter"></span>
                    <?php echo $this->lang->line('xin_filter');?></button>
            </a> <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown"
                aria-expanded="false"><span class="fa fa-bar-chart"></span>
                <?php echo $this->lang->line('xin_report');?> <span class="fa fa-caret-down"></span></button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('admin/reports/employees/');?>"
                        target="_blank"><?php echo $this->lang->line('xin_filter_employement_report');?></a></li>
            </ul>
        </div>
        <!-- //<?php //} ?> -->
    </div>

    <div class="box-body">
        <div class="box-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered" id="xin_table">
                <thead>
                    <tr>
                        <th>Sl.</th>
                        <th width="200"><i class="fa fa-user"></i>
                            <?php echo $this->lang->line('xin_employees_full_name');?></th>
                        <th><?php echo $this->lang->line('left_company');?></th>
                        <th><?php echo $this->lang->line('dashboard_contact');?></th>
                        <th><?php echo $this->lang->line('xin_employee_role');?></th>
                        <th style="width:80px;"><?php echo $this->lang->line('xin_action');?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- left resign list modal -->
<div class="modal fade " id="left_resign_list" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card" style="padding:10px">
                <h3 style="margin-left:15px">Employee Left/Resign List</h3>
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item active">
                        <a class="nav-link" id="left-tab" data-toggle="tab" href="#left" role="tab" aria-controls="left"
                            aria-selected="false">Employee Left List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="resign-tab" data-toggle="tab" href="#resign" role="tab"
                            aria-controls="resign" aria-selected="false">Employee Resign List</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active in" id="left" role="tabpanel" aria-labelledby="left-tab">
                        <div class="box-body">
                            <div class="box-datatable ">
                                <table class="datatables-demo table table-responsive table-striped table-bordered"
                                    id="left_table">
                                    <?php
                                    if(count($lefts)=='') {
                                        echo "<h3 class='text-center text-danger'>Data not Found</h3>";
                                    } else {?>
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">Sl. No.</th>
                                            <th class="text-center" scope="col">Name</th>
                                            <th class="text-center" scope="col">Department Name</th>
                                            <th class="text-center" scope="col">Designation Name</th>
                                            <th class="text-center" scope="col">Left Date</th>
                                            <th class="text-center" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;
                                         foreach($lefts as $left) {?>
                                        <tr>
                                            <td class="text-center" scope="row"><?php echo $i++?></td>
                                            <td class="text-center"><?php echo $left->first_name.' '.$left->last_name?>
                                            </td>
                                            <td class="text-center"><?php echo $left->department_name?></td>
                                            <td class="text-center"><?php echo $left->designation_name?></td>
                                            <td class="text-center"><?php echo $left->effective_date?></td>
                                            <td class="text-center"><a class="btn btn-sm btn-primary"
                                                    href="<?php echo base_url('admin/employees/detail/').$left->user_id?>"><i
                                                        class="fa fa-eye"></i> Details</a></td>
                                        </tr>
                                        <?php }
            }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="resign" role="tabpanel" aria-labelledby="resign-tab">
                        <div class="box-body">
                            <div class="box-datatable">
                                <table class="datatables-demo table table-striped table-bordered" id="resign_table">
                                    <?php
                    if(count($resigns)=='') {
                        echo "<h3 class='text-center text-danger'>Data not Found</h3>";
                    } else {?>
                                    <thead>
                                        <tr>
                                            <th class="text-center" scope="col">Sl. No.</th>
                                            <th class="text-center" scope="col">Name</th>
                                            <th class="text-center" scope="col">Department Name</th>
                                            <th class="text-center" scope="col">Designation Name</th>
                                            <th class="text-center" scope="col">Resign Date</th>
                                            <th class="text-center" scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;
                        foreach($resigns as $resign) {?>
                                        <tr>
                                            <td class="text-center" scope="row"><?php echo $i++?></td>
                                            <td class="text-center">
                                                <?php echo $resign->first_name.' '.$resign->last_name?></td>
                                            <td class="text-center"><?php echo $resign->department_name?></td>
                                            <td class="text-center"><?php echo $resign->designation_name?></td>
                                            <td class="text-center"><?php echo $resign->effective_date?></td>
                                            <td class="text-center"><a class="btn btn-sm btn-primary"
                                                    href="<?php echo base_url('admin/employees/detail/').$resign->user_id?>"><i
                                                        class="fa fa-eye"></i> Details</a></td>
                                        </tr>
                                        <?php }
                        }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <button data-dismiss="modal" id="buttonsss" class="btn btn-sm btn-danger"
                style="margin-left:16px;margin-bottom:20px">Close</button>
        </div>
    </div>
</div>


<!-- left resign form modal -->
<div class="modal fade " id="left-resign-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card" style="padding:10px">
                <h3 style="margin-left:15px">Employee Left/Resign Form</h3>
                <?php $attributes = array('id' => 'emp_left_resign', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
                <?php $hidden = array('user_id' => $session['user_id']);?>
                <?php echo form_open('admin/employees/emp_left_resign', $attributes, $hidden);?>
                <div class="form-group col-md-6">
                    <level>Employee Name</label>
                        <input disabled class="form-control" id="emp_namesss">
                </div>
                <div class="form-group col-md-6">
                    <level>Department Name</label>
                        <input disabled class="form-control" id="department">
                </div>
                <div class="form-group col-md-6">
                    <level>Designation Name</label>
                        <input disabled class="form-control" id="designation">
                </div>
                <div class="form-group col-md-6">
                    <level>Joining Date</label>
                        <input disabled class="form-control" id="doj">
                </div>
                <input id='hidden_id_emp' type="hidden" name="hidden_id_emp">

                <div class="form-group col-md-6">
                    <level> Employee Status </label>
                        <select class="form-control" id="left_resign_status" name="left_resign_status">
                            <option value="" disabled selected>Select Status</option>
                            <option value="1">Left</option>
                            <option value="2">Resign</option>
                        </select>
                </div>
                <div class="form-group col-md-6">
                    <level>Effective Date</label>
                        <input type="date" class="form-control" id="lr_effective_date" name="effective_date">
                </div>

                <button id="button" class="btn btn-sm btn-primary pull-right "
                    style="margin-right:16px;margin-bottom:20px">Submit</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // get designations
    jQuery("#aj_subdepartments").change(function() {
        jQuery.get(base_url + "/is_designation/" + jQuery(this).val(), function(data, status) {
            jQuery('#designation_ajax').html(data);
        });
    });

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({
        width: '100%'
    });

});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $("#emp_left_resign").on("submit", function(e) {
        e.preventDefault();

        // validation here
        if ($('#left_resign_status').val() === null) {
            $('#left_resign_status').focus();
            $('#left_resign_status').attr('style', 'border: 1px solid red !important');
            return false;
        } else {
            $("#left_resign_status").attr('style', 'border: 1px solid #ccd6e6 !important');
        }

        if ($('#lr_effective_date').val() == '') {
            $('#lr_effective_date').focus();
            $('#lr_effective_date').attr('style', 'border: 1px solid red !important');
            return false;
        } else {
            $("#lr_effective_date").attr('style', 'border: 1px solid #ccd6e6 !important');
        }
        // end validation 

        // ajax request on form submit
        var emp_id = $('#hidden_id_emp').val();
        var sendData = $(this).serialize();
        var targetUrl = "<?=base_url('admin/employees/emp_left_resign/')?>" + emp_id;
        $.ajax({
            url: targetUrl,
            type: "POST",
            data: sendData,
            dataType: "json",
            success: function(response) {
                if (response.status == true) {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
                location.reload();
            },
        });
    });
});
</script>

<script>
function left_resign(id) {

    var url = "<?php echo base_url('admin/employees/fetch_user_info_ajax/');?>" + id;

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // alert(response[0].first_name)
            $('#hidden_id_emp').val(id);
            $('#emp_namesss').val(response[0].first_name + ' ' + response[0].last_name);
            $('#department_id').val(response[0].department_id);
            $('#department').val(response[0].department_name);
            $('#designation_id').val(response[0].designation_id);
            $('#designation').val(response[0].designation_name);
            $('#doj').val(response[0].date_of_joining);
        }
    });

    $("#left-resign-modal").modal("show");
}

$(document).ready(function() {

    $('#left-resign-modal').on('hidden.bs.modal', function() {
        $('#left_resign_status').val('');
        $('#lr_effective_date').val('');
        $("#left_resign_status").attr('style', 'border: 1px solid #ccd6e6 !important');
        $("#lr_effective_date").attr('style', 'border: 1px solid #ccd6e6 !important');
    });

    $("#left_resign_status").on('input', function() {
        $("#left_resign_status").attr('style', 'border: 1px solid #ccd6e6 !important');
        if ($("#left_resign_status").val() == '') {
            $("#left_resign_status").attr('style', 'border: 1px solid red !important');
            return false;
        }
    });

    $("#lr_effective_date").on('input', function() {
        $("#lr_effective_date").attr('style', 'border: 1px solid #ccd6e6 !important');
        if ($("#lr_effective_date").val() == '') {
            $("#lr_effective_date").attr('style', 'border: 1px solid red !important');
            return false;
        }
    });

    $('#inactive').click(function(e) {
        e.preventDefault();
        $('#left_resign_list').modal('show');
        $('#left_table').DataTable();
        $('#resign_table').DataTable();
    })

});
</script>

