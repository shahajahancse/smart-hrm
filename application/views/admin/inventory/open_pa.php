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
    <script>
      setTimeout(function() {
        $(".alert-success").hide(1000);
      }, 3000);
    </script>
  <?php endif; ?>

  <?php if($this->session->flashdata('warning')):?>
    <div class="alert alert-warning">
      <?php echo $this->session->flashdata('warning');?>
    </div>
    <script>
      setTimeout(function() {
        $(".alert-warning").hide(1000);
      }, 3000);
    </script>
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
        <?php echo form_open('admin/inventory/stock_opening_adjust', $attributes, $hidden);?>
            <div class="box-header with-border" style="display: flex;justify-content: center;">
                <input name="product_id" type="hidden" id="product_id" >
                <div class="col-md-3">
                    <label>Item Item</label>
                    <input name="product_name" id="product_name" value="" class="form-control input-sm" readonly>
                </div>
                <div class="col-md-3">
                    <label>Opening Quantity</label>
                    <input name="opening_qty" value="" id="opening_qty" class="form-control input-sm" >
                </div>
                <div class="col-md-1">
                    <label style='color: transparent !important' >.</label>
                    <input type="submit" class="btn btn-sm btn-primary" >
                </div>
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
                var data = JSON.parse(response);
                product = data.product;
                $('#product_id').val(product.id);
                $('#product_name').val(product.product_name);
                $('#opening_qty').val(product.opening_qty);
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
