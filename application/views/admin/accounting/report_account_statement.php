<?php
/* Accounting > Account Statement view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_acc_account_statement');?> </h3>
  </div>
  <div class="box-body">
    <?php $attributes = array('name' => 'report_account_statement', 'id' => 'hrm-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('re_user_id' => $session['user_id']);?>
    <?php echo form_open('admin/accounting/report_statement_list', $attributes, $hidden);?>
    <?php
		$data = array(
		  'name'        => 'user_id',
		  'id'          => 'user_id',
		  'type'       => 'hidden',
		  'value'   => $session['user_id'],
		  'class'       => 'form-control',
		);
			
	echo form_input($data);
	?>
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <select name="account_id" id="account_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_acc_select_account');?>">
            <option value="0"><?php echo $this->lang->line('xin_acc_select_account');?></option>
            <?php foreach($all_bank_cash as $bank_cash) {?>
            <option value="<?php echo $bank_cash->bankcash_id;?>"> <?php echo $bank_cash->account_name;?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_frm_date');?>" readonly id="from_date" name="from_date" type="text" value="<?php echo date('Y-m-d')?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_e_details_to_date');?>" readonly id="to_date" name="to_date" type="text" value="<?php echo date('Y-m-d')?>">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_get');?></button>
        </div>
      </div>
    </div>
    <?php echo form_close(); ?> </div>
</div>
<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> <?php echo $this->lang->line('xin_acc_account_statement');?> </h3>
  </div>
  <div class="box-body">
  <div class="box-datatable table-responsive">
    <table class="datatables-demo table table-striped table-bordered" id="xin_table">
      <thead>
        <tr>
            <th><?php echo $this->lang->line('xin_e_details_date');?></th>
            <th><?php echo $this->lang->line('xin_type');?></th>
            <th><?php echo $this->lang->line('xin_description');?></th>
            <th><?php echo $this->lang->line('xin_acc_credit');?></th>
            <th><?php echo $this->lang->line('xin_acc_debit');?></th>
          </tr>
      </thead>
      <tbody><tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available in table</td></tr></tbody>
      <tfoot id="get_footer">
      </tfoot>
    </table>
  </div>
</div>
</div>