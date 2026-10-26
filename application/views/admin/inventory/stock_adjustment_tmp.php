<?php
  $session = $this->session->userdata('username');
  $get_animate = $this->Xin_model->get_content_animate();
?>
<style>
  .table {
      width: 92%;
      margin-bottom: 14px;
  }
</style>

<div class="box <?php echo $get_animate;?>" style="margin-top:20px">

  <?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success">
      <?php echo $this->session->flashdata('success');?>
    </div>
  <?php endif; ?>

  <?php if($this->session->flashdata('warning')):?>
    <div class="alert alert-warning">
      <?php echo $this->session->flashdata('warning');?>
    </div>
  <?php endif; ?>

  <div class="box-header with-border" style="display: flex;justify-content: center;">
    <div class="col-md-3">
      <select class="select2 form-control" name="item_name" id="item_name">
        <option value="">Select Item</option>
        <?php foreach ($product_lists as $key => $list) { ?>
        <option value="<?php echo $list->id ?>"><?php echo $list->product_name ?></option>
        <?php }?>
      </select>
    </div>
  </div>

  <div class="box-body">
    <?php $attributes = array('id' => 'adj-form', 'autocomplete' => 'off');?>
    <?php $hidden = array('user_id' => $session['user_id']);?>
    <?php echo form_open('admin/inventory/stock_adjustment_form', $attributes, $hidden);?>
      <div class="col-md-6">
        <table class="datatables-demo table table-striped table-bordered" id="table_data" style="width:100%">
          <tr>
            <th style="font-size:10px; text-align:center;" >Date</th>
            <th style="font-size:10px; text-align:center;">Quantity</th>
            <th style="font-size:10px; text-align:center;">App Qty</th>
            <th style="font-size:10px; text-align:center;">Prev Qty</th>
            <th style="font-size:10px; text-align:center;">Balance</th>
          </tr>
          <tbody id="purchase_tr">

          </tbody>
        </table>
      </div>

      <div class="col-md-6">
        <table class="datatables-demo table table-striped table-bordered" id="table_data" style="width:100%">
          <tr>
            <th style="font-size:10px; text-align:center;" >Date</th>
            <th style="font-size:10px; text-align:center;">Quantity</th>
            <th style="font-size:10px; text-align:center;">App Qty</th>
            <th style="font-size:10px; text-align:center;">Prev Qty</th>
            <th style="font-size:10px; text-align:center;">Balance</th>
          </tr>
          <tbody id="requisition_tr">

          </tbody>
        </table>
      </div>

      <div class="box-header with-border" style="display: flex;justify-content: center;">
        <label style="margin-top: 8px;">Final Quantity</label>
        <div class="col-md-3">
          <input name="product_id" type="hidden" id="product_id" >
          <input name="actual_amt" value="0" id="actual_amt" class="form-control" >
        </div>
        <input type="submit" class="btn btn-sm btn-primary" >
      </div>
    <?php echo form_close(); ?>
  </div>
</div>


<script>
  $(document).ready(function(){
    $('#item_name').select2();
    $("#item_name").change(function(){
      var selectedValue = $(this).val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('admin/inventory/get_item_data')?>",
        data: { item_id: selectedValue },
        success: function(response) {
          var purchase_tr = '';
          var requisition_tr = '';
          var data = JSON.parse(response);
          purchase = data.purchase;
          requisition = data.requisition;
          $.each(purchase, function(index, element) {
            purchase_tr += '<tr>';
            purchase_tr += '<td><input type="hidden" name="purchase_id[]" value="'+element.purchase_id+'">'+element.created_at+'</td>';
            purchase_tr += '<td> <input name="quantity[]" value="'+element.quantity+'" class="form-control input-sm"> </td>';
            purchase_tr += '<td> <input name="ap_quantity[]" value="'+element.ap_quantity+'" class="form-control input-sm"> </td>';
            purchase_tr += '<td> <input name="prev_quantity[]" value="'+element.prev_quantity+'" class="form-control input-sm"> </td>';
            purchase_tr += '<td> <input name="current_quantity[]" value="'+element.current_quantity+'" class="form-control input-sm"> </td>';
            purchase_tr += '</tr>';
          });

          $.each(requisition, function(index, element) {
            requisition_tr += '<tr>';
            requisition_tr += '<td><input type="hidden" name="requsition_id[]" value="'+element.requsition_id+'">'+element.created_at+'</td>';
            requisition_tr += '<td> <input name="rquantity[]" value="'+element.quantity+'" class="form-control input-sm"> </td>';
            requisition_tr += '<td> <input name="rap_quantity[]" value="'+element.ap_quantity+'" class="form-control input-sm"> </td>';
            requisition_tr += '<td> <input name="rprev_quantity[]" value="'+element.prev_quantity+'" class="form-control input-sm"> </td>';
            requisition_tr += '<td> <input name="rcurrent_quantity[]" value="'+element.current_quantity+'" class="form-control input-sm"> </td>';
            requisition_tr += '</tr>';
          });

          $('#purchase_tr').html(purchase_tr);
          $('#requisition_tr').html(requisition_tr);
          product = data.product;
          $('#actual_amt').val(product.quantity);
          $('#product_id').val(product.id);
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error: " + error);
        }
      });
    });
    $('#item_name').on('select2:clear', function (e) {
      // Clear the input field
      $(this).val('').trigger('change.select2');
    });
  });

</script>
