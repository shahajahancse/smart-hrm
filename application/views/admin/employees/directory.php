<?php
/* Employee Directory view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $countries = $this->Xin_model->get_countries();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php if($user_info[0]->user_role_id==1){ ?>
<div class="box mb-4 <?php echo $get_animate;?>">
<div class="box-header  with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_filter_employee');?></h3>
    </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/employees/hr', $attributes, $hidden);?>
        <?php
			$data = array(
			  'type'        => 'hidden',
			  'name'        => 'hrsale_directory',
			  'id'          => 'date_format',
			  'value'       => 1,
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
<?php } ?>
<div class="row <?php echo $get_animate;?>">
<?php if($total_record > 0) {?>
  <?php foreach($results as $employee) { ?>
  <?php
	if($employee->profile_picture!='' && $employee->profile_picture!='no file') {
		$u_file = base_url().'uploads/profile/'.$employee->profile_picture;
	} else {
		if($employee->gender=='Male') { 
			$u_file = base_url().'uploads/profile/default_male.jpg';
		} else {
			$u_file = base_url().'uploads/profile/default_female.jpg';
		}
	}
	?>
  <?php $designation = $this->Designation_model->read_designation_information($employee->designation_id);?>
  <?php
		if(!is_null($designation)){
		$designation_name = strtolower($designation[0]->designation_name);
	  } else {
		$designation_name = '--';	
	  }
	?>
  <div class="col-6 col-lg-3">
    <div class="box box-body">
      <div class="text-center"> <a href="#"> <img class="hr-user-img user-img-xin rounded-circle xin-mb-5" src="<?php echo $u_file;?>" alt="<?php echo $employee->first_name;?> <?php echo $employee->last_name;?>"> </a>
        <h3 class="xin-mb-5 emp-name">
          <?php if(in_array('202',$role_resources_ids)) {?>
          <a href="<?php echo site_url('admin/employees/detail')?>/<?php echo $employee->user_id;?>"><?php echo $employee->first_name;?> <?php echo $employee->last_name;?></a>
          <?php } else {?>
          <?php echo $employee->first_name;?> <?php echo $employee->last_name;?>
          <?php } ?>
        </h3>
        <h6 class="user-info mt-0 xin-mb-5 text-lighter"><?php echo ucwords($designation_name);?></h6>
        <div class="gap-items user-social font-size-16 p-15"> <a class="text-facebook" href="<?php echo $employee->facebook_link;?>"><i class="fa fa-facebook"></i></a> <a class="text-light-blue" href="<?php echo $employee->instagram_link;?>"><i class="fa fa-instagram"></i></a> <a class="text-red" href="<?php echo $employee->google_plus_link;?>"><i class="fa fa-google"></i></a> <a class="text-aqua" href="<?php echo $employee->twitter_link;?>"><i class="fa fa-twitter"></i></a> </div>
        <p><?php echo $employee->address;?> </p>
        <?php if(in_array('202',$role_resources_ids)) {?>
        <a href="<?php echo site_url('admin/employees/detail')?>/<?php echo $employee->user_id;?>" class="btn btn-rounded btn-primary btn-sm"><?php echo $this->lang->line('xin_view_invoice_more');?> <i class="fa fa-arrow-circle-right"></i></a> <a href="<?php echo site_url('admin/employees/download_profile')?>/<?php echo $employee->user_id;?>" class="btn btn-rounded btn-primary btn-sm" target="_blank"><?php echo $this->lang->line('xin_profile');?> <i class="fa fa-download"></i></a>
        <?php } else {?>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php } else {?> <div class="col-12 col-lg-12">
    <div class="box box-body">
      <div class="text-center"><?php echo $this->lang->line('xin_record_not_found');?></div></div></div>
  <?php }?>
</div>
<?php if (isset($links)) { ?>
<ul class="pagination pagination-sm no-margin">
  <?php foreach ($links as $link) { 
    echo "<li>". $link."</li>";
    } ?>
</ul>
<?php } ?>

