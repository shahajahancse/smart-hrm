<?php
/* Invoices view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row animated fadeInRight">
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/invoices/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-primary"><i class="fa fa-files-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo all_invoice_paid_count();?></span> <span class="info-box-number client-hr-invoice"><?php echo $this->lang->line('xin_invoice_paid_client');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/invoices/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-green"><i class="fa fa-table"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo all_invoice_unpaid_count();?></span> <span class="info-box-number client-hr-invoice"><?php echo $this->lang->line('xin_invoice_unpaid_client');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/invoices/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Xin_model->currency_sign(all_invoice_paid_amount());?></span> <span class="info-box-number client-hr-invoice"><?php echo $this->lang->line('xin_paid_amount');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/invoices/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-table"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Xin_model->currency_sign(all_invoice_unpaid_amount());?></span> <span class="info-box-number client-hr-invoice"><?php echo $this->lang->line('xin_invoice_due_amount');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_invoices_title');?></h3>
    <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
	<?php if(in_array('120',$role_resources_ids)) {?>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-xs btn-primary" onclick="window.location='<?php echo site_url('admin/invoices/create/')?>'"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_invoice_create');?></button>
    </div>
    <?php } ?>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th><?php echo $this->lang->line('xin_invoice_no');?></th>
            <th><?php echo $this->lang->line('xin_project');?></th>
            <th><?php echo $this->lang->line('xin_acc_total');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_date');?></th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_invoice_due_date');?></th>
            <th><?php echo $this->lang->line('kpi_status');?></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<style type="text/css">
.info-box-number {
	font-size:15px !important;
	font-weight:300 !important;
}
</style>