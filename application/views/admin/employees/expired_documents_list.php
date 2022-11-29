<?php
/* Expired documents
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php
$user_info = $this->Xin_model->read_user_info($session['user_id']);
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<div class="row match-heights">
  <div class="col-lg-3 col-md-3 <?php echo $get_animate;?>">
  
    <div class="box">
      <div class="box-blocks">
        <div class="list-group"> 
        <a class="list-group-item list-group-item-action nav-tabs-link active" href="#exp_documents" data-constant="1" data-constant-block="exp_documents" data-toggle="tab" aria-expanded="true" id="constant_1"> <?php echo $this->lang->line('xin_e_details_exp_documents');?> </a> <a class="list-group-item list-group-item-action nav-tabs-link" href="#immigration" data-constant="2" data-constant-block="immigration" data-toggle="tab" aria-expanded="true" id="constant_2"> <?php echo $this->lang->line('xin_employee_immigration');?> </a> 
        <?php if(in_array('5',$role_resources_ids)) { ?>
        <a class="list-group-item list-group-item-action nav-tabs-link" href="#official_documents" data-constant="3" data-constant-block="official_documents" data-toggle="tab" aria-expanded="true" id="constant_3"> <?php echo $this->lang->line('xin_hr_official_documents');?> </a><?php } ?>
        <a class="list-group-item list-group-item-action nav-tabs-link" href="#assets_warranty" data-constant="4" data-constant-block="assets_warranty" data-toggle="tab" aria-expanded="true" id="constant_4"> <?php echo $this->lang->line('xin_assets_warranty');?> </a>
         </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 current-tab <?php echo $get_animate;?>" id="exp_documents">
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_e_details_exp_documents');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table_document" style="width:100%;">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
            <th><?php echo $this->lang->line('xin_e_details_dtype');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_e_details_doe');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
</div>
<div class="col-md-9 current-tab <?php echo $get_animate;?>" id="immigration" style="display:none;">
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_employee_immigration');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table_imgdocument" style="width:100%;">
        <thead>
          <tr>
              <th><?php echo $this->lang->line('xin_action');?></th>
              <th><?php echo $this->lang->line('dashboard_single_employee');?></th>
              <th><?php echo $this->lang->line('xin_e_details_document');?></th>
              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_issue_date');?></th>
              <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_expiry_date');?></th>
              <th><?php echo $this->lang->line('xin_issued_by');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
</div>
<?php if(in_array('5',$role_resources_ids)) { ?>
<div class="col-md-9 current-tab <?php echo $get_animate;?>" id="official_documents" style="display:none;">
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_hr_official_documents');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table_company_license" style="width:100%;">
        <thead>
          <tr>
            <th width="100px;"><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
            <th><?php echo $this->lang->line('left_company');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_expiry_date');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
</div>
<?php } ?>
<div class="col-md-9 current-tab <?php echo $get_animate;?>" id="assets_warranty" style="display:none;">
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_assets_warranty');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table_assets_warranty" style="width:100%;">
        <thead>
          <tr>
          <th><?php echo $this->lang->line('xin_action');?></th>
          <th><i class="fa fa-flask"></i> <?php echo $this->lang->line('xin_asset_name');?></th>
          <th><?php echo $this->lang->line('xin_acc_category');?></th>
          <th><?php echo $this->lang->line('xin_company_asset_code');?></th>
          <th><?php echo $this->lang->line('xin_is_working');?></th>
          <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_assets_assign_to');?></th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
</div>