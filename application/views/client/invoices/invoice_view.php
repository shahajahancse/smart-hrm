<?php
/* Invoice view
*/
?>
<?php $session = $this->session->userdata('client_username');?>
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
<div class="row">
  <div class="col-xs-12"> &nbsp; <small class="pull-right">
    <div class="btn-group pull-right" role="group" style="margin-top:2px">
      	<a href="<?php echo site_url('client/invoices/preview/'.$invoice_id);?>" class="btn btn-flickr btn-sm" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_inv_preview');?>
      <div class="ripple-wrapper"></div>
      </a>
      <?php $inv_record = get_invoice_transaction_record($invoice_id);?>
        <?php if ($inv_record->num_rows() < 1) { ?>
        <a href="<?php echo site_url('client/invoices/preview/'.$invoice_id);?>" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php echo $this->lang->line('xin_acc_pay_now');?>
      <div class="ripple-wrapper"></div>
      </a>
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
        <?php echo $company_zipcode;?>, <?php echo $company_city;?><br>
        <?php echo $company_country;?><br />
        Phone: <?php echo $company_phone;?>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col"> To
        <address>
        <strong><?php echo $client_name;?></strong><br>
        <?php echo $client_company_name;?><br>
        <?php echo $client_address_1.' '.$client_address_2.' '.$client_city;?><br>
        Phone: <?php echo $client_contact_number;?><br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col"> <b>Invoice #<?php echo $invoice_number;?></b><br>
        <br>
        <b>Date:</b> <?php echo $this->Xin_model->set_date_format($invoice_date);?><br>
        <b>Payment Due:</b> <?php echo $this->Xin_model->set_date_format($invoice_due_date);?><br />
        <?php
		if($status == 0){
			$_status = '<span class="label label-danger">'.$this->lang->line('xin_payroll_unpaid').'</span>';
		} else if($status == 1) {
			$_status = '<span class="label label-success">'.$this->lang->line('xin_payment_paid').'</span>';
		} else {
			$_status = '<span class="label label-info">'.$this->lang->line('xin_acc_inv_cancelled').'</span>';
		}
		echo $_status;
		?></div>
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
              <th class="py-3"> Item </th>
              <th class="py-3"> Tax Rate </th>
              <th class="py-3"> Qty/Hrs </th>
              <th class="py-3"> Unit Price </th>
              <th class="py-3"> Subtotal </th>
            </tr>
          </thead>
          <tbody>
            <?php
				$ar_sc = explode('- ',$system_setting[0]->default_currency_symbol);
				$sc_show = $ar_sc[1];
				?>
            <?php $prod = array(); $i=1; foreach($this->Invoices_model->get_invoice_items($invoice_id) as $_item):?>
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
      <div class="col-xs-6">
        <?php if($invoice_note == ''):?>&nbsp;<?php else:?>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> <?php echo $invoice_note;?> </p>
        <?php endif;?>
      </div>
      <div class="col-lg-6">
        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <th style="width:50%">Subtotal:</th>
                <td><?php echo $this->Xin_model->currency_sign($sub_total_amount);?></td>
              </tr>
              <tr>
                <th>TAX</th>
                <td><?php echo $this->Xin_model->currency_sign($total_tax);?></td>
              </tr>
              <tr>
                <th>Discount:</th>
                <td><?php echo $this->Xin_model->currency_sign($total_discount);?></td>
              </tr>
              <tr>
                <th>Total:</th>
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