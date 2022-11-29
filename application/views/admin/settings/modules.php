<style type="text/css">
.todo-list ul {
	list-style-type: none;
	padding: 0;
	margin: 0;
}
.todo-list ul li {
	position: relative;
	border: 1px solid #ebebee;
	padding: 15px 40px 15px 45px;
	border-radius: 10px;
	margin-top: 10px;
}
.control {
	display: block;
	position: absolute;
	cursor: pointer;
	left: 15px;
	top: 12px;
}
.control input {
	position: absolute;
	z-index: -1;
	opacity: 0;
}
.control .control-indicator {
	position: absolute;
	top: 2px;
	left: 0;
	height: 22px;
	width: 22px;
	border: 1px solid #e6e6e6;
	border-radius: 50%;
}
.todo-list ul li .task {
	font-size: 14px;
}
span {
	display: inline-block;
}
</style>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_modules');?> </h3>
  </div>
  <div class="box-body todo-list">
    <p class="card-text"><?php echo sprintf($this->lang->line('xin_setting_module_details'),$company[0]->company_name);?> </p>
    <div class="card-datatable table-responsive">
      <table class="datatables-demo table table-striped table-hover table-bordered" id="xin_table">
        <?php $attributes = array('name' => 'modules_info', 'id' => 'modules_info', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => 0);?>
        <?php echo form_open('admin/settings/modules_info', $attributes, $hidden);?>
        <tbody>
            <tr>
                <td style="width:160px;"><?php echo $this->lang->line('left_recruitment');?></td>
                <td>
                <?php echo sprintf($this->lang->line('xin_setting_module_recruitment_details'),$company[0]->company_name);?></td>
                <td style="width:100px;"><input data-group-cls="btn-group-sm" type="checkbox" id="m-recruitment" class="js-switch switch" value="true" <?php if($module_recruitment=='true'):?> checked="checked" <?php endif;?>/></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line('left_travels');?></td>
                <td><?php echo $this->lang->line('xin_setting_module_travels_details');?></td>
                <td><input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch" id="m-travel" <?php if($module_travel=='true'):?> checked="checked" <?php endif;?> value="true" /></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line('xin_files_manager');?></td>
                <td><?php echo $this->lang->line('xin_setting_module_fmanager_details');?></td>
                <td><input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch" id="m-files" <?php if($module_files=='true'):?> checked="checked" <?php endif;?> value="true" /></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line('xin_multi_language');?></td>
                <td><?php echo $this->lang->line('xin_setting_module_mlanguage_details');?></td>
                <td><input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch" id="m-language" <?php if($module_language=='true'):?> checked="checked" <?php endif;?> value="true" /></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line('xin_org_chart_title');?></td>
                <td><?php echo $this->lang->line('xin_setting_module_orgchart_details');?></td>
                <td><input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch" id="m-orgchart" <?php if($module_orgchart=='true'):?> checked="checked" <?php endif;?> value="true" /></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line('xin_hr_events_meetings');?></td>
                <td><?php echo $this->lang->line('xin_hr_events_meetings_details');?></td>
                <td><input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch" id="m-events" <?php if($module_events=='true'):?> checked="checked" <?php endif;?> value="true" /></td>
            </tr>	
            <tr>
                <td><?php echo $this->lang->line('xin_hr_chat_box');?></td>
                <td><?php echo sprintf($this->lang->line('xin_hr_chat_box_details'),$company[0]->company_name);?></td>
                <td><input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch" id="m-chatbox" <?php if($module_chat_box=='true'):?> checked="checked" <?php endif;?> value="true" /></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line('xin_enable_sub_departments');?></td>
                <td><?php echo sprintf($this->lang->line('xin_subdepartments_title_details'),$company[0]->company_name);?></td>
                <td><input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch" id="m-sub_departments" <?php if($is_active_sub_departments=='yes'):?> checked="checked" <?php endif;?> value="yes" /></td>
            </tr>	
            <tr>
                <td><?php echo $this->lang->line('left_payroll');?></td>
                <td><?php echo sprintf($this->lang->line('xin_payroll_title_details'),$company[0]->company_name);?></td>
                <td><input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch" id="m-payroll" <?php if($module_payroll=='yes'):?> checked="checked" <?php endif;?> value="yes" /></td>
            </tr>
            <tr>
                <td><?php echo $this->lang->line('left_performance');?></td>
                <td><?php echo sprintf($this->lang->line('xin_setting_module_performance_details'),$company[0]->company_name);?></td>
                <td><input data-group-cls="btn-group-sm" type="checkbox" class="js-switch switch" id="m-performance" <?php if($module_performance=='yes'):?> checked="checked" <?php endif;?> value="yes" /></td>
            </tr>						
        </tbody>
      </table>
      <?php echo form_close(); ?> </div>
  </div>
</div>
