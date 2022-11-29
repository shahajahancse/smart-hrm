<?php $session = $this->session->userdata('client_username'); ?>
<?php $clientinfo = $this->Clients_model->read_client_info($session['client_id']); ?>

<div class="box-widget widget-user-2">
  <div class="widget-user-header">
    <h4 class="widget-user-username welcome-hrsale-user">Welcome back, <?php echo $clientinfo[0]->name;?>!</h4>
    <h5 class="widget-user-desc welcome-hrsale-user-text">Today is <?php echo date('l, j F Y');?></h5>
  </div>
</div>
<div class="row animated fadeInRight">
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('client/invoices/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-primary"><i class="fa fa-files-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo clients_invoice_paid_count($session['client_id']);?></span> <span class="info-box-number client-hr-invoice"><?php echo $this->lang->line('xin_invoice_paid_client');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('client/invoices/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-green"><i class="fa fa-table"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo clients_invoice_unpaid_count($session['client_id']);?></span> <span class="info-box-number client-hr-invoice"><?php echo $this->lang->line('xin_invoice_unpaid_client');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('client/projects/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-purple"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_in_progress');?></span> <span class="info-box-text"><span class="badge bg-red"> <?php echo $this->lang->line('xin_project');?> <?php echo clients_project_inprogress($session['client_id']);?> </span></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('client/projects/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_completed');?></span> <span class="info-box-text"><span class="badge bg-red"> <?php echo $this->lang->line('xin_project');?> <?php echo clients_project_completed($session['client_id']);?> </span> </span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
</div>
<div class="row animated fadeInRight">
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('client/invoices/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Xin_model->currency_sign(clients_invoice_paid_amount($session['client_id']));?></span> <span class="info-box-number client-hr-invoice"><?php echo $this->lang->line('xin_paid_amount');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('client/invoices/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-table"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Xin_model->currency_sign(clients_invoice_unpaid_amount($session['client_id']));?></span> <span class="info-box-number client-hr-invoice"><?php echo $this->lang->line('xin_invoice_due_amount');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('client/projects/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_not_started');?></span> <span class="info-box-text"><span class="badge bg-red"> <?php echo $this->lang->line('xin_project');?> <?php echo clients_project_notstarted($session['client_id']);?> </span></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <div class="col-xl-3 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('client/projects/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-aqua"><i class="fa fa-tasks"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_deffered');?></span> <span class="info-box-text"><span class="badge bg-red"> <?php echo $this->lang->line('xin_project');?> <?php echo clients_project_deffered($session['client_id']);?> </span> </span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
</div>
<div class="row"> 
  <!-- Left col -->
  <div class="col-md-6"> 
    <!-- TABLE: LATEST ORDERS -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_my_projects');?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_project_summary');?></th>
                <th><?php echo $this->lang->line('xin_p_priority');?></th>
                <th><?php echo $this->lang->line('xin_p_enddate');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($this->Xin_model->last_five_client_projects($session['client_id']) as $_project) {?>
              <?php
                    if($_project->priority == 1) {
                    	$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_highest').'</span>';
                    } else if($_project->priority ==2){
                    	$priority = '<span class="badge badge-danger">'.$this->lang->line('xin_high').'</span>';
                    } else if($_project->priority ==3){
                    	$priority = '<span class="badge badge-primary">'.$this->lang->line('xin_normal').'</span>';
                    } else {
                    	$priority = '<span class="badge badge-success">'.$this->lang->line('xin_low').'</span>';
                    }
                    	$pdate = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($_project->end_date);
					//project_progress
					if($_project->project_progress <= 20) {
						$progress_class = 'progress-danger';
					} else if($_project->project_progress > 20 && $_project->project_progress <= 50){
						$progress_class = 'progress-warning';
					} else if($_project->project_progress > 50 && $_project->project_progress <= 75){
						$progress_class = 'progress-info';
					} else {
						$progress_class = 'progress-success';
					}
					// progress
				$pbar = '<p class="m-b-0-5">'.$this->lang->line('xin_completed').' <span class="pull-xs-right">'.$_project->project_progress.'%</span></p><progress class="progress '.$progress_class.' progress-sm" value="'.$_project->project_progress.'" max="100">'.$_project->project_progress.'%</progress>';
                    ?>
              <tr>
                <td><a href="<?php echo site_url().'client/projects/detail/'.$_project->project_id;?>"><?php echo $_project->title;?></a></td>
                <td><?php echo $priority;?></td>
                <td><?php echo $pdate;?></td>
                <td><?php echo $pbar;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive --> 
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix"> <a href="<?php echo site_url('client/projects/');?>" class="btn btn-sm btn-info btn-flat pull-left"><?php echo $this->lang->line('xin_role_view');?></a> </div>
      <!-- /.box-footer --> 
    </div>
    <!-- /.box --> 
  </div>
  <div class="col-md-6"> 
    <!-- TABLE: LATEST ORDERS -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_invoices_title');?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">
            <thead>
              <tr>
                <th>Invoice#
                  <?php //echo $this->lang->line('xin_client_name');?></th>
                <th><?php echo $this->lang->line('xin_project');?></th>
                <th>Total
                  <?php //echo $this->lang->line('xin_email');?></th>
                <th>Invoice Date
                  <?php //echo $this->lang->line('xin_website');?></th>
                <th>Due Date
                  <?php //echo $this->lang->line('xin_city');?></th>
                <th>Status
                  <?php //echo $this->lang->line('xin_country');?></th>
              </tr>
            </thead>
            <tbody>
              <?php //$client = last_five_client_invoices_info($session['client_id']);?>
              <?php foreach($this->Invoices_model->last_five_client_invoices($session['client_id']) as $r) {?>
              <?php
                // get country
                $grand_total = $this->Xin_model->currency_sign($r->grand_total);
                // get project
                $project = $this->Project_model->read_project_information($r->project_id); 
                if(!is_null($project)){
                $project_name = $project[0]->title;
                } else {
                $project_name = '--';
                }
                // if($project[0]->client_id==$session['client_id']) {
                
                $invoice_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_date);
                $invoice_due_date = '<i class="far fa-calendar-alt position-left"></i> '.$this->Xin_model->set_date_format($r->invoice_due_date);
                //invoice_number
                $invoice_number = '<a href="'.site_url().'client/invoices/view/'.$r->invoice_id.'/">'.$r->invoice_number.'</a>';
                if($r->status == 0){
                $istatus = $this->lang->line('xin_payroll_unpaid');
                } else {
                $istatus = $this->lang->line('xin_payment_paid');
                }
                ?>
              <tr>
                <td><?php echo $invoice_number;?></td>
                <td><?php echo $project_name;?></td>
                <td><?php echo $grand_total;?></td>
                <td><?php echo $invoice_date;?></td>
                <td><?php echo $invoice_due_date;?></td>
                <td><?php echo $istatus;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- /.table-responsive --> 
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix"> <a href="<?php echo site_url('client/invoices/');?>" class="btn btn-sm btn-info btn-flat pull-left"><?php echo $this->lang->line('xin_invoices_all');?></a> </div>
      <!-- /.box-footer --> 
    </div>
    <!-- /.box --> 
  </div>
  <!-- /.col --> 
</div>
<style type="text/css">
.box-body {
    padding: 0 !important;
}
.info-box-number {
	font-size:16px !important;
	font-weight:300 !important;
}
</style>
