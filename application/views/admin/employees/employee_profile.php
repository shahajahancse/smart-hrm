<?php
$bank_account = $this->Employees_model->set_employee_bank_account($user_id);
if($bank_account->num_rows() > 0){
  $bank_account = $bank_account->row();
}

?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php if($profile_picture!='' && $profile_picture!='no file') {?>
<?php $de_file = base_url().'uploads/profile/'.$profile_picture;?>
<?php } else {?>
<?php if($gender=='Male') { ?>
<?php $de_file = base_url().'uploads/profile/default_male.jpg';?>
<?php } else { ?>
<?php $de_file = base_url().'uploads/profile/default_female.jpg';?>
<?php } ?>
<?php } ?>
<?php $full_name = $user[0]->first_name.' '.$user[0]->last_name;?>
<?php $department = $this->Department_model->read_department_information($user[0]->department_id);
      $department_name = ($department[0]->department_name);
?>
<?php $designation = $this->Designation_model->read_designation_information($user[0]->designation_id);?>
<?php #dd($user);
	if(!is_null($designation)){
		$designation_name = $designation[0]->designation_name;
	} else {
		$designation_name = '--';	
	}
	$leave_user = $this->Xin_model->read_user_info($session['user_id']);
?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
  .toph{
       justify-content: center;
       display: flex;
      }
</style>
<div class="row">
  <!-- Navbar tab -->
  <div class="col-md-12">
    <div class="nav-tabs-custom mb-4">
      <ul class="nav nav-tabs">
        <li class="nav-item active"> <a class="nav-link active show" data-toggle="tab" href="#xin_general"><?php echo $this->lang->line('xin_general');?></a> </li>
        <?php //if(in_array('351',$role_resources_ids)) {?>
        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#xin_employee_set_salary">Salary & Bank Information</a> </li>
     </ul>
    <div>
      
  </div>
  <!-- End of Navbar Tab -->
  <div class="tab-content">
    <!-- Basic Information Tab -->
    <div class="tab-pane <?php echo $get_animate;?> active" style="margin-left: -36px;" id="xin_general">
        <div class="box-body box-profile col-md-12">
          <h3 class="box-title col-md-3 toph" > <?php echo $this->lang->line('xin_e_details_basic_info');?> </h3>
          <a class="col-md-2" href="#profile-picture" data-profile="2" data-profile-block="profile_picture" data-toggle="tab" aria-expanded="true" id="user_profile_2"> 
            <img class="profile-user-img img-responsive img-circle" src="<?php echo $de_file;?>" alt="<?php echo $full_name;?>">
          </a>
        </div>
        <div class="box-body form-alignment ">
          <div class="col-md-8">
            <div class="">
              <div class="col-md-12">
                <div class="col-md-6">
                    <label for="username" class="control-label labelmargin"><?php echo $this->lang->line('dashboard_username');?></label>
                    <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="<?php echo $username;?>">   
                  </div>          
                  <div class="col-md-6">
                    <label for="employee_id" class="control-label labelmargin"><?php echo $this->lang->line('dashboard_employee_id');?></label>
                    <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('dashboard_employee_id');?>" name="employee_id" type="text" value="<?php echo $employee_id;?>">              
                  </div>
                <div class="col-md-6">
                  <label for="first_name" class="control-label labelmargin"><?php echo $this->lang->line('xin_employee_first_name');?></label>
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_employee_first_name');?>" name="first_name" type="text" value="<?php echo $first_name;?>">   
                </div>          
                <div class="col-md-6">
                  <label for="last_name" class="control-label labelmargin"><?php echo $this->lang->line('xin_employee_last_name');?></label>
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_employee_last_name');?>" name="last_name" type="text" value="<?php echo $last_name;?>">              
                </div>

                <div class="col-md-6">
                  <label for="last_name" class="control-label labelmargin"><?php echo $this->lang->line('xin_employee_department');?></label>
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_employee_department');?>" name="last_name" type="text" value="<?php echo $department_name;?>">              
                </div>
                <div class="col-md-6">
                  <label for="last_name" class="control-label labelmargin">Designation</label>
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_employee_designation');?>" name="last_name" type="text" value="<?php echo $designation_name;?>">              
                </div>
<!-- hh -->
                <div class="col-md-12 labelmargin">
                  <label for="email" class="control-label"><?php echo $this->lang->line('dashboard_email');?></label> <br>
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('dashboard_email');?><?php echo $this->lang->line('dashboard_employee_id');?>" name="email" type="text" value="<?php echo $email;?>">
                </div>
                <div class="col-md-6 labelmargin">
                  <label for="contact_no" class="control-label"><?php echo $this->lang->line('xin_e_details_contact');?></label> <br>
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_e_details_contact');?>" name="contact_no" type="text" value="<?php echo $contact_no;?>">
                </div>
                <div class="col-md-6 labelmargin">
                  <label for="dob" class="control-label"><?php echo $this->lang->line('xin_employee_dob');?></label> <br>
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_employee_dob');?>" name="dob" type="text" value="<?php echo $date_of_birth;?>">
                </div>
                <div class="col-md-6 labelmargin">
                  <label for="gender" class="control-label"><?php echo $this->lang->line('xin_employee_gender');?></label> <br>
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_employee_gender');?>" name="gender" type="text" value="<?php echo $gender;?>">
                </div>
                <div class="col-md-6 labelmargin">
                  <label for="marital_status" class="control-label"><?php echo $this->lang->line('xin_employee_mstatus');?></label> <br>
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_employee_mstatus');?>" name="marital_status" type="text" value="<?php echo $marital_status;?>">
                </div>
                <div class="col-md-12 labelmargin">
                  <label for="address" class="control-label"><?php echo $this->lang->line('xin_employee_address');?></label> <br>
                  <textarea class="form-control" disabled placeholder="<?php echo $this->lang->line('xin_employee_address');?>" name="address" cols="30" rows="3" id="address"><?php echo $address;?></textarea>
                </div>
              </div> 
            </div>
          </div>
        </div>
    </div>
    <!-- End of Basic Information Tab -->
    
    <!-- Salary Tab -->
    <div class="tab-pane <?php echo $get_animate;?>" id="xin_employee_set_salary">
        <div class="box-header with-border">
          <h3 class="box-title">Salary</h3>
        </div>
        <div class="box-body pb-2">
          <div class="bg-white">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="wages_type"><?php echo $this->lang->line('xin_employee_type_wages');?></label><br />
                  <?php if($wages_type==1):?> <?php echo $this->lang->line('xin_payroll_basic_salary');?><?php endif;?>
                  <?php if($wages_type==2):?> <?php echo $this->lang->line('xin_employee_daily_wages');?><?php endif;?>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="basic_salary"><?php echo $this->lang->line('xin_salary_title');?></label><br />
                  <?php echo $this->Xin_model->currency_sign($basic_salary);?>
                </div>
              </div>
                                                    
            </div>                                        
          </div>
        </div>
        <!-- End of Salary Information -->
        
        <!-- Bank Information -->
        <div class="box-header with-border">
          <h3 class="box-title">Bank Information</h3>
        </div>
        <div class="box-body pb-2">
          <div class="bg-white">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="acc_number">Account Number</label><br />
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_e_details_acc_number');?>" name="acc_name" type="text" value="<?php echo isset($bank_account->account_number) ? $bank_account->account_number : ''; ?>" >
                </div>  
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="acc_title"><?php echo $this->lang->line('xin_e_details_acc_title');?></label><br />
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_e_details_acc_title');?>" name="acc_title" type="text" value="<?php echo isset($bank_account->account_title) ? $bank_account->account_title : ''; ?>"
                  >
                </div>
              </div>                                     
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="bank_name">Bank Name</label><br />
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_e_details_bank_name');?>" name="bank_name" type="text"  value="<?php echo isset($bank_account->bank_name) ? $bank_account->bank_name : ''; ?>"
                  >
                </div>  
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="bank_branch">Bank Branch</label><br />
                  <input class="form-control inputfield" disabled placeholder="<?php echo $this->lang->line('xin_e_details_bank_branch');?>" name="bank_branch" type="text"  value="<?php echo $bank_account->bank_branch; ?>"
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End of Bank Information -->
    </div>
    <!-- End of Salary Tab -->   
  </div>
  
</div>     
     

