<?php
/* Projects List view
*/
?>
<?php $session = $this->session->userdata('client_username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon bg-aqua"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-text"><?php echo $this->Project_model->not_started_client_projects($session['client_id']); ?></span> <span class="info-box-number"><?php echo $this->lang->line('xin_not_started');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-text"><?php echo $this->Project_model->inprogress_client_projects($session['client_id']);?></span> <span class="info-box-number"><?php echo $this->lang->line('xin_in_progress');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
  <!-- /.col --> 
  
  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-text"><?php echo $this->Project_model->complete_client_projects($session['client_id']); ?></span> <span class="info-box-number"><?php echo $this->lang->line('xin_completed');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
  <!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box"> <span class="info-box-icon bg-yellow"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-text"><?php echo $this->Project_model->deffered_client_projects($session['client_id']); ?></span> <span class="info-box-number"><?php echo $this->lang->line('xin_deffered');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    <!-- /.info-box --> 
  </div>
  <!-- /.col --> 
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_projects');?> </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_project_summary');?></th>
            <th><?php echo $this->lang->line('xin_p_priority');?></th>
            <th><?php echo $this->lang->line('xin_p_enddate');?></th>
            <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
            <th><?php echo $this->lang->line('xin_project_users');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.info-box-number {
	font-size:16px !important;
	font-weight:300 !important;
}
</style>