<?php
/* Settings view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $file_setting = $this->Xin_model->read_file_setting_info(1);?>
<?php $system = $this->Xin_model->read_setting_info(1); ?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<section id="basic-listgroup">
  <div class="row match-heights <?php echo $get_animate?>">
    <div class="col-lg-3 col-md-3">
      <div class="card">
          <div class="card-blocks">
        <div class="list-group"> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item active" href="#system" data-setting="3" data-profile-block="system" data-toggle="tab" aria-expanded="true" id="setting_3"> <i class="fa fa-tv"></i> <?php echo $this->lang->line('xin_system');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#general" data-setting="1" data-profile-block="general" data-toggle="tab" aria-expanded="true" id="setting_1"> <i class="fa fa-user"></i> <?php echo $this->lang->line('xin_general');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#role" data-profile="4" data-profile-block="role" data-toggle="tab" aria-expanded="true" id="setting_4"> <i class="fa fa-unlock-alt"></i> <?php echo $this->lang->line('xin_employee_role');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#payroll" data-profile="6" data-profile-block="payroll" data-toggle="tab" aria-expanded="true" id="setting_6"> <i class="fa fa-money"></i> <?php echo $this->lang->line('left_payroll');?> </a>
          <?php if($system[0]->module_orgchart=='true'){?>
          <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#job" data-profile="7" data-profile-block="job" data-toggle="tab" aria-expanded="true" id="setting_7"> <i class="fa fa-newspaper-o"></i> <?php echo $this->lang->line('left_recruitment');?> </a>
          <?php }?>
          <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#email" data-profile="8" data-profile-block="email" data-toggle="tab" aria-expanded="true" id="setting_8"> <i class="fa fa-envelope"></i> <?php echo $this->lang->line('xin_email_notifications');?> </a>
          <?php if($system[0]->module_files=='true'){?>
          <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#file_manager" data-setting="9" data-profile-block="file_manager" data-toggle="tab" aria-expanded="true"> <i class="fa fa-file"></i> <?php echo $this->lang->line('xin_files_manager');?> </a>
          <?php }?>
          <a class="list-group-item list-group-item-action nav-tabs-link hrsale-tab-item" href="#performance" data-setting="10" data-profile-block="performance" data-toggle="tab" aria-expanded="true"> <i class="fa fa-cube"></i> <?php echo $this->lang->line('left_performance');?> </a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 current-tab <?php echo $get_animate;?>" id="general"  style="display:none;">
    <?php $attributes = array('name' => 'company_info', 'id' => 'company_info', 'autocomplete' => 'off');?>
    <?php $hidden = array('u_company_info' => 'UPDATE');?>
    <?php echo form_open('admin/settings/company_info/'.$company_info_id, $attributes, $hidden);?>
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_general');?> <?php echo $this->lang->line('header_configuration');?> </h3>
      </div>
      <div class="box-body">
        <div class="card-block">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>" name="company_name" type="text" value="<?php echo $company_name;?>">
              </div>
              <div class="form-group">
                <label for="contact_person"><?php echo $this->lang->line('xin_contact_person');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_person');?>" name="contact_person" type="text" value="<?php echo $contact_person;?>">
              </div>
              <div class="form-group">
                <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>" name="email" type="email" value="<?php echo $email;?>">
              </div>
              <div class="form-group">
                <label for="phone"><?php echo $this->lang->line('xin_phone');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_phone');?>" name="phone" type="text" value="<?php echo $phone;?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_employee_address');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>" name="address_1" type="text" value="<?php echo $address_1;?>">
                <br>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>" name="address_2" type="text" value="<?php echo $address_2;?>">
                <br>
                <div class="row">
                  <div class="col-md-5">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>" name="city" type="text" value="<?php echo $city;?>">
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>" name="state" type="text" value="<?php echo $state;?>">
                  </div>
                  <div class="col-md-3">
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>" name="zipcode" type="text" value="<?php echo $zipcode;?>">
                  </div>
                </div>
                <br>
                <select class="form-control" name="country" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                  <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                  <?php foreach($all_countries as $scountry) {?>
                  <option value="<?php echo $scountry->country_id;?>" <?php if($country==$scountry->country_id):?> selected <?php endif;?>> <?php echo $scountry->country_name;?></option>
                  <?php } ?>
                </select>
              </div>
              <input name="config_type" type="hidden" value="general">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo form_close(); ?> </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="system">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_system');?> <?php echo $this->lang->line('header_configuration');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <?php $attributes = array('name' => 'system_info', 'id' => 'system_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('admin/settings/system_info/'.$company_info_id, $attributes, $hidden);?>
          <div class="bg-white">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="company_name"><?php echo $this->lang->line('xin_application_name');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_system_settings');?>" name="application_name" type="text" value="<?php echo $application_name;?>" id="application_name">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email"><?php echo $this->lang->line('xin_default_currency');?></label>
                  <select class="form-control select2-hidden-accessible" name="default_currency_symbol" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_default_currency_symbol');?>" tabindex="-1" aria-hidden="true">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <?php foreach($this->Xin_model->get_currencies() as $currency){?>
                    <?php $_currency = $currency->code.' - '.$currency->symbol;?>
                    <option value="<?php echo $_currency;?>" <?php if($default_currency_symbol==$_currency):?> selected <?php endif;?>> <?php echo $_currency;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_default_currency_symbol_code');?></label>
                  <select class="form-control" name="show_currency" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_show_currency');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="code" <?php if($show_currency=='code'){?> selected <?php }?>><?php echo $this->lang->line('xin_currency_code');?></option>
                    <option value="symbol" <?php if($show_currency=='symbol'){?> selected <?php }?>><?php echo $this->lang->line('xin_currency_symbol');?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_currency_position');?></label>
                  <input type="hidden" name="notification_position" value="Bottom Left">
                  <input type="hidden" name="enable_registration" value="no">
                  <input type="hidden" name="login_with" value="username">
                  <select class="form-control" name="currency_position" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_currency_position');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="Prefix" <?php if($currency_position=='Prefix'){?> selected <?php }?>><?php echo $this->lang->line('xin_prefix');?></option>
                    <option value="Suffix" <?php if($currency_position=='Suffix'){?> selected <?php }?>><?php echo $this->lang->line('xin_suffix');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_login_employee');?></label>
                  <select class="form-control" name="employee_login_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_login_employee');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="username" <?php if($employee_login_id=='username'){?> selected <?php }?>><?php echo $this->lang->line('xin_login_employee_with_username');?></option>
                    <option value="email" <?php if($employee_login_id=='email'){?> selected <?php }?>><?php echo $this->lang->line('xin_login_employee_with_email');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_date_format');?></label>
                  <select class="form-control" name="date_format" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_date_format');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="d-m-Y" <?php if($date_format_xi=='d-m-Y'){?> selected <?php }?>>dd-mm-YYYY (<?php echo date('d-m-Y');?>)</option>
                    <option value="m-d-Y" <?php if($date_format_xi=='m-d-Y'){?> selected <?php }?>>mm-dd-YYYY (<?php echo date('m-d-Y');?>)</option>
                    <option value="d-M-Y" <?php if($date_format_xi=='d-M-Y'){?> selected <?php }?>>dd-MM-YYYY (<?php echo date('d-M-Y');?>)</option>
                    <option value="M-d-Y" <?php if($date_format_xi=='M-d-Y'){?> selected <?php }?>>MM-dd-YYYY (<?php echo date('M-d-Y');?>)</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="footer_text"><?php echo $this->lang->line('xin_footer_text');?></label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_footer_text');?>" name="footer_text" type="text" value="<?php echo $footer_text;?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_setting_timezone');?></label>
                  <select class="form-control" name="system_timezone" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_setting_timezone');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <?php foreach($this->Xin_model->all_timezones() as $tval=>$labels):?>
                    <option value="<?php echo $tval;?>" <?php if($system_timezone==$tval):?> selected <?php endif;?>><?php echo $labels;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <?php if($system_ip_address==''): $ipAddress = $this->input->ip_address(); else: $ipAddress = $system_ip_address; endif;?>
                  <label for="footer_text"><?php echo $this->lang->line('xin_setting_sys_ip_address');?>
                    <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_setting_sys_ip_address_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_setting_sys_ip_address');?>"> <span class="fa fa-question-circle"></span></button>
                  </label>
                  <input class="form-control" placeholder="<?php echo $this->lang->line('xin_setting_sys_ip_address');?>" name="system_ip_address" type="text" value="<?php echo $ipAddress;?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="footer_text"><?php echo $this->lang->line('xin_enable_auth_bg_imgs');?>
                    <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_enable_auth_bg_imgs_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_enable_auth_bg_imgs');?>"><span class="fa fa-question-circle"></span></button>
                  </label>
                  <input type="checkbox" id="enable_auth_background" name="enable_auth_background" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($enable_auth_background=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contact_role"><?php echo $this->lang->line('xin_enable_year_on_footer');?> <small>(footer)</small></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <input type="checkbox" id="enable_current_year" name="enable_current_year" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($enable_current_year=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contact_role"><?php echo $this->lang->line('xin_enable_codeigniter_on_footer');?> <small>(footer)</small></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                     <input type="checkbox" id="enable_page_rendered" name="enable_page_rendered" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($enable_page_rendered=='yes'):?> checked="checked" <?php endif;?> value="yes" />          </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                <label for="footer_text"><?php echo $this->lang->line('xin_enable_geolocation_ssl');?>
                    <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_enable_geolocation_ssl_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_enable_geolocation_ssl');?>"><span class="fa fa-question-circle"></span></button>
                  </label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <input type="checkbox" name="is_ssl_available" id="is_ssl_available" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($is_ssl_available=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="contact_role"><?php echo $this->lang->line('xin_payroll_statutory_fixed');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                     <input type="checkbox" id="statutory_fixed" name="statutory_fixed" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($statutory_fixed=='yes'):?> checked="checked" <?php endif;?> value="yes" />          </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                	<?php $languages = $this->Xin_model->all_languages();?>
                  <label for="default_language"><?php echo $this->lang->line('xin_hrsale_default_language');?></label>
                  <select class="form-control" name="default_language" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_hrsale_default_language');?>">
                    <?php foreach($languages as $lang):?>
                    <option value="<?php echo $lang->language_code;?>" <?php if($lang->language_code==$default_language):?> selected="selected"<?php endif;?>><?php echo $lang->language_name;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="footer_text"><?php echo $this->lang->line('xin_setting_google_maps_api_key');?>
                    <button type="button" class="btn icon-btn btn-xs btn-default itheme-btn borderless" data-toggle="popover" data-placement="top" data-content="<?php echo $this->lang->line('xin_setting_google_maps_api_key_details');?>" data-trigger="hover" data-original-title="<?php echo $this->lang->line('xin_setting_google_maps_api_key');?>"><span class="fa fa-question-circle"></span></button>
                  </label>
                  <br />
                  <textarea class="form-control" name="google_maps_api_key" id="google_maps_api_key" rows="1"><?php echo $google_maps_api_key;?></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="role" style="display:none;">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_employee_role');?> <?php echo $this->lang->line('header_configuration');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <?php $attributes = array('name' => 'role_info', 'id' => 'role_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('admin/settings/role_info/'.$company_info_id, $attributes, $hidden);?>
          <div class="bg-white">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="contact_role"><?php echo $this->lang->line('xin_employe_can_manage_contact_info');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <input type="checkbox" name="contact_role" id="contact_role" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_contact=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="bank_account_role"><?php echo $this->lang->line('xin_employe_can_manage_bank_account');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <input type="checkbox" name="bank_account_role" id="bank_account_role" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_bank_account=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="edu_role"><?php echo $this->lang->line('xin_employe_can_manage_qualification');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <input type="checkbox" name="edu_role" id="edu_role" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_qualification=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="work_role"><?php echo $this->lang->line('xin_employe_can_manage_work_experience');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <input type="checkbox" name="work_role" id="work_role" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_work_experience=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="doc_role"><?php echo $this->lang->line('xin_employe_can_manage_documents');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                   <input type="checkbox" name="doc_role" id="doc_role" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_document=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="pic_role"><?php echo $this->lang->line('xin_employe_can_manage_profile_picture');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <input type="checkbox" name="pic_role" id="pic_role" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_picture=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="profile_role"><?php echo $this->lang->line('xin_employe_can_manage_profile_info');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                    <input type="checkbox" name="profile_role" id="profile_role" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_profile=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
                <div class="form-group">
                  <label for="social_role"><?php echo $this->lang->line('xin_employe_can_manage_social_info');?></label>
                  <br>
                  <div class="pull-xs-left m-r-1">
                   <input type="checkbox" name="social_role" id="social_role" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($employee_manage_own_social=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="payroll" style="display:none;">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('left_payroll');?> <?php echo $this->lang->line('header_configuration');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <?php $attributes = array('name' => 'payroll_config', 'id' => 'payroll_config', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('admin/settings/payroll_config/'.$company_info_id, $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="contact_role"><?php echo $this->lang->line('xin_payslip_password_format');?></label>
                <br>
                <div class="pull-xs-left m-r-1">
                  <select class="form-control" name="payslip_password_format" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_select_one');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <option value="dateofbirth" <?php if($payslip_password_format=='dateofbirth'){?> selected <?php }?>>Employee date of birth (<?php echo date('dmY');?>)</option>
                    <option value="contact_no" <?php if($payslip_password_format=='contact_no'){?> selected <?php }?>>Employee Contact Number. (<?php echo '123456789';?>)</option>
                    <option value="full_name" <?php if($payslip_password_format=='full_name'){?> selected <?php }?>>Employee First name Last name (<?php echo 'JhonDoe';?>)</option>
                    <option value="email" <?php if($payslip_password_format=='email'){?> selected <?php }?>>Employee Email Address (<?php echo 'employee@example.com';?>)</option>
                    <option value="password" <?php if($payslip_password_format=='password'){?> selected <?php }?>>Employee Password (<?php echo 'testpassword';?>)</option>
                    <option value="user_password" <?php if($payslip_password_format=='user_password'){?> selected <?php }?>>Employee Username & Password (<?php echo 'usernametestpassword';?>)</option>
                    <option value="employee_id" <?php if($payslip_password_format=='employee_id'){?> selected <?php }?>>Employee ID (<?php echo 'EMP001WA5';?>)</option>
                    <option value="employee_id_password" <?php if($payslip_password_format=='employee_id_password'){?> selected <?php }?>>Employee ID & Password (<?php echo 'EMP001WA5testpassword';?>)</option>
                    <option value="dateofbirth_name" <?php if($payslip_password_format=='dateofbirth_name'){?> selected <?php }?>>Employee date of birth & 2 first character from Name (<?php echo date('dmY').'JD';?>)</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="contact_role"><?php echo $this->lang->line('xin_enable_password_generate_payslip');?></label>
                <br>
                <div class="pull-xs-left m-r-1">
                  <input type="checkbox" name="payslip_password_generate" id="payslip_password_generate" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($is_payslip_password_generate=='1'):?> checked="checked" <?php endif;?> value="1" />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
          <div class="col-md-3" id="half_monthly_is">
              <div class="form-group">
                <label for="is_half_monthly"><?php echo $this->lang->line('xin_is_half_monthly');?></label>
                <select name="is_half_monthly" id="is_half_monthly" class="form-control" data-plugin="select_hrm">
                  <option value="0" <?php if($is_half_monthly==0 || $is_half_monthly==''):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_no');?></option>
                  <option value="1" <?php if($is_half_monthly==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_yes');?></option>
                  
                </select>
            </div>
          </div>
          <?php if($is_half_monthly==1): $stl = 'style="display:block;"';  else: $stl = 'style="display:none;"'; endif;?>
          <div class="col-md-3" id="deduct_options"  <?php echo $stl;?>>
              <div class="form-group">
                <label for="half_deduct_month"><?php echo $this->lang->line('xin_half_deduct_month');?></label>
                <select name="half_deduct_month" id="half_deduct_month" class="form-control" data-plugin="select_hrm">
                  <option value="1" <?php if($half_deduct_month==1):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_is_half_monthly_bs_only');?></option>
                  <option value="2" <?php if($half_deduct_month==2):?> selected="selected"<?php endif;?>><?php echo $this->lang->line('xin_is_half_monthly_bs_only_both');?></option>
                </select>
              </div>
            </div>
         </div>   
          <div class="row">
            <div class="col-md-12">
              <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
  <?php if($system[0]->module_recruitment=='true'){?>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="job" style="display:none;">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('dashboard_recruitment');?> <?php echo $this->lang->line('header_configuration');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <?php $attributes = array('name' => 'job_info', 'id' => 'job_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('admin/settings/job_info/'.$company_info_id, $attributes, $hidden);?>
          <div class="col-sm-12">
            <div class="form-group">
              <label for="enable_job"><?php echo $this->lang->line('xin_enable_jobs_for_employees');?></label>
              <br>
              <div class="pull-xs-left m-r-1">
                <input type="checkbox" name="enable_job2" id="enable_job2" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($enable_job_application_candidates=='1'):?> checked="checked" <?php endif;?> value="1" />
              </div>
            </div>
            <div class="form-group">
              <label for="job_application_format"><?php echo $this->lang->line('xin_job_application_file_format');?></label>
              <br>
              <input type="text" value="<?php echo $job_application_format;?>" data-role="tagsinput" name="job_application_format">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="email" style="display:none;">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_email_notification_config');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <?php $attributes = array('name' => 'email_info', 'id' => 'email_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('admin/settings/email_info/'.$company_info_id, $attributes, $hidden);?>
          <div class="bg-white">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('xin_email_notification_enable');?></label>
                <br>
                <div class="pull-xs-left m-r-1">
                  <input type="checkbox" name="srole_email_notification" id="srole_email_notification" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($enable_email_notification=='yes'):?> checked="checked" <?php endif;?> value="yes" />
                </div>
              </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label for="phone"><?php echo $this->lang->line('xin_mail_type_config');?></label>
                  <select class="form-control" name="email_type" id="email_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_mail_type_config');?>">
                    <option value="codeigniter" <?php if($email_type == 'codeigniter'):?> selected="selected"<?php endif;?>>CodeIgniter Mail()</option>
                    <option value="phpmail" <?php if($email_type == 'phpmail'):?> selected="selected"<?php endif;?>>PHP Mail()</option>
                    <option value="smtp" <?php if($email_type == 'smtp'):?> selected="selected"<?php endif;?>>SMTP</option>
                  </select>
                </div>
              </div>
            </div>
            <?php if($email_type == 'smtp'): $sm_opt = 'style="display:block;"';  else: $sm_opt = 'style="display:none;"'; endif;?>
            <div class="row" id="smtp_options" <?php echo $sm_opt;?>>
            	<div class="col-md-4">
                    <div class="form-group">
                    <label for="smtp_host"><?php echo $this->lang->line('xin_mail_smtp_host');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_mail_smtp_host');?>" name="smtp_host" type="text" value="<?php echo $smtp_host;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="smtp_username"><?php echo $this->lang->line('xin_mail_smtp_username');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_mail_smtp_username');?>" name="smtp_username" type="text" value="<?php echo $smtp_username;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="smtp_password"><?php echo $this->lang->line('xin_mail_smtp_password');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_mail_smtp_password');?>" name="smtp_password" type="password" value="<?php echo $smtp_password;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="smtp_port"><?php echo $this->lang->line('xin_mail_smtp_port');?></label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_mail_smtp_port');?>" name="smtp_port" type="text" value="<?php echo $smtp_port;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="smtp_secure"><?php echo $this->lang->line('xin_mail_smtp_secure');?></label>
                    <select class="form-control" name="smtp_secure" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_mail_smtp_secure');?>">
                    <option value="tls"<?php if($smtp_secure == 'tls'):?> selected="selected"<?php endif;?>>TLS</option>
                    <option value="ssl"<?php if($smtp_secure == 'ssl'):?> selected="selected"<?php endif;?>>SSL</option>
                  </select>
                    </div>
                </div>
            </div> 
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
  <?php if($system[0]->module_files=='true'){?>
  <div role="tabpanel" class="col-md-9 current-tab <?php echo $get_animate;?>" id="file_manager" style="display:none;">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_files_manager');?> <?php echo $this->lang->line('header_configuration');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <?php $attributes = array('name' => 'setting_info', 'id' => 'file_setting_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('admin/files/setting_info/'.$company_info_id, $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="enable_job"><?php echo $this->lang->line('xin_file_maxsize');?></label>
                <br>
                <div class="input-group">
                <input type="text" class="form-control" value="<?php echo $file_setting[0]->maximum_file_size;?>" name="maximum_file_size" placeholder="<?php echo $this->lang->line('xin_file_size_mb');?>" maxlength="2000" min="1">
                <span class="input-group-addon">MB</span>
              </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="job_application_format"><?php echo $this->lang->line('xin_allowed_extensions');?></label>
                <br>
                <input type="text" value="<?php echo $file_setting[0]->allowed_extensions;?>" data-role="tagsinput" name="allowed_extensions">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('xin_employee_can_view_download_other_files');?></label>
                <br>
                <div class="pull-xs-left m-r-1">
                  <input type="checkbox" name="view_all_files" id="view_all_files" class="js-switch switch" data-group-cls="btn-group-sm"  data-color="#3e70c9" data-secondary-color="#ddd" <?php if($file_setting[0]->is_enable_all_files=='yes'):?> checked="checked" <?php endif;?> value="yes">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="performance" style="display:none;">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('left_performance');?> <?php echo $this->lang->line('header_configuration');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <?php $attributes = array('name' => 'performance_info', 'id' => 'performance_info', 'autocomplete' => 'off');?>
          <?php $hidden = array('u_basic_info' => 'UPDATE');?>
          <?php echo form_open('admin/settings/performance_info/'.$company_info_id, $attributes, $hidden);?>
          <div class="col-sm-12">
            <div class="form-group">
              <label for="technical_competencies"><?php echo $this->lang->line('xin_performance_technical_competencies');?></label>
              <br>
              <div class="pull-xs-left m-r-1">
                <input type="text" value="<?php echo $technical_competencies;?>" data-role="tagsinput" name="technical_competencies">
              </div>
            </div>
            <div class="pull-xs-left m-r-1">
              <label for="organizational_competencies"><?php echo $this->lang->line('xin_performance_behv_technical_competencies');?></label>
              <br>
              <input type="text" value="<?php echo $organizational_competencies;?>" data-role="tagsinput" name="organizational_competencies">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
</div>
</section>