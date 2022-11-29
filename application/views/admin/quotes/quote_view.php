<?php
/* Quote view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system_setting = $this->Xin_model->read_setting_info(1);?>
<?php
$client_name = $name;
$client_contact_number = $contact_number;
$client_company_name = $client_company_name;
$client_website_url = $website_url;
$client_address_1 = $address_1;
$client_address_2 = $address_2;
//$client_country = $countryid;
$client_city = $city;
$client_zipcode = $zipcode;
$country = $this->Xin_model->read_country_info($countryid);
if(!is_null($country)){
$client_country = $country[0]->country_name;
} else {
$client_country = '--';	
}

?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php if($this->session->flashdata('response')):?>
<div class="callout callout-success">
<p><?php echo $this->session->flashdata('response');?></p>
</div>
<?php endif;?>
<div class="row">
  <div class="col-xs-12"> &nbsp; <small class="pull-right">
    <div class="btn-group pull-right" role="group" style="margin-top:2px">
      	<?php $quote_convert_record = $this->Quotes_model->read_quote_converted_info($quote_id);?>
        <?php if ($quote_convert_record < 1) { ?>
        <button type="button" class="btn icon-btn btn-xs btn-success waves-effect waves-light"  data-toggle="modal" data-target=".view-modal-data"  data-quote_id="<?php echo $quote_id; ?>"><span class="fa fa-exchange"></span> <?php echo $this->lang->line('xin_quote_convert_project');?></button>
        <a href="<?php echo site_url('admin/quotes/edit/'.$quote_id);?>" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $this->lang->line('xin_edit');?></a>
        <?php } else { ?>
        <a href="javascript:void(0);" class="btn btn-success btn-sm"><i class="fa fa-check-square" aria-hidden="true"></i> <?php echo $this->lang->line('xin_quote_converted_project');?> </a>
        <?php } ?>
        
      <button type="button" id="print-invoice" class="btn btn-vk btn-sm print-invoice"><i class="fa fa-print" aria-hidden="true"></i> <?php echo $this->lang->line('xin_print');?></button>
    </div>
    </small> </div>
  <!-- /.col --> 
</div>
<div class="invoice  <?php echo $get_animate;?>" style="margin:10px 10px;">
  <div id="print_invoice_hr"> 
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
       <h2 class="page-header"> <i class="fa fa-globe"></i> <?php echo $company_name;?> <small class="pull-right">Date: <?php echo date('d-m-Y');?></small> </h2>
      </div>
      <!-- /.col --> 
    </div>
    
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col"> From
        <address>
        <strong><?php echo $company_name;?></strong><br>
        <?php echo $company_address;?><br>
        <?php echo $company_city;?> <?php echo $company_state;?> <?php echo $company_zipcode;?><br>
        <?php echo $company_country;?><br />
        Phone: <?php echo $company_phone;?><br /><br />
        <strong>Attn: <?php echo $name;?></strong><br>
        Project: <?php echo $project_name;?><br />
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-2 invoice-col"> To
        <address>
        
        <strong><?php echo $client_company_name;?></strong><br>
        <?php echo $client_address_1.' '.$client_address_2.'<br>'.$client_city.' '.$state.' '.$client_zipcode.'<br>'.$client_country;?><br>
        Phone: <?php echo $client_contact_number;?><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-6 invoice-col"> <b><?php echo $this->lang->line('xin_title_quote_hash');?> <?php echo $quote_number;?></b>
        <br>
        <b>Date:</b> <?php echo $this->Xin_model->set_date_format($quote_date);?><br>
        <b>Due Date:</b> <?php echo $this->Xin_model->set_date_format($quote_due_date);?><br />
        <?php $_status = '';
		if($status == 0){
			$_status = '<span class="label label-warning">'.$this->lang->line('xin_quoted_title').'</span>';
		} else {
			$_status = '<span class="label label-success">'.$this->lang->line('xin_quote_invoiced').'</span>';
		}
		echo $_status;
		?> </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
    
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th class="py-3"> # </th>
              <th class="py-3" width="300px"> <?php echo $this->lang->line('xin_title_item');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('xin_title_tax_rate');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('xin_title_qty_hrs');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('xin_title_unit_price');?> </th>
              <th class="py-3"> <?php echo $this->lang->line('xin_title_sub_total');?> </th>
            </tr>
          </thead>
          <tbody>
            <?php
				$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
				$sc_show = $ar_sc[1];
				?>
            <?php $prod = array(); $i=1; foreach($this->Quotes_model->get_quote_items($quote_id) as $_item):?>
            <tr>
              <td class="py-3"><div class="font-weight-semibold"><?php echo $i;?></div></td>
              <td class="py-3" style="width:"><div class="font-weight-semibold"><?php echo $_item->item_name;?></div></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->currency_sign($_item->item_tax_rate);?></strong></td>
              <td class="py-3"><strong><?php echo $_item->item_qty;?></strong></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->currency_sign($_item->item_unit_price);?></strong></td>
              <td class="py-3"><strong><?php echo $this->Xin_model->currency_sign($_item->item_sub_total);?></strong></td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row -->
    
    <div class="row"> 
      <!-- /.col -->
      <div class="col-xs-8">
        <?php if($quote_note == ''):?>&nbsp;<?php else:?>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> <?php echo $quote_note;?> </p>
        <?php endif;?>
      </div>
      <div class="col-lg-4">
        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <th style="width:50%"><?php echo $this->lang->line('xin_title_sub_total');?>:</th>
                <td><?php echo $this->Xin_model->currency_sign($sub_total_amount);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('xin_title_tax_c');?></th>
                <td><?php echo $this->Xin_model->currency_sign($total_tax);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('xin_discount');?>:</th>
                <td><?php echo $this->Xin_model->currency_sign($total_discount);?></td>
              </tr>
              <tr>
                <th><?php echo $this->lang->line('xin_acc_total');?>:</th>
                <td><?php echo $this->Xin_model->currency_sign($grand_total);?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </div>
</div>
