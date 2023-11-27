<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
  .table {
    width: 92%;
    margin-bottom: 14px;
  }
</style>
<?php if($user_role_id !=3){?>
<div class="box mb-4 <?php echo $get_animate;?>">
    <div class="box-header with-border">
        <h3 class="box-title">Purchase Products Requisition </h3>
    </div>
    <div class="container pt-4">
      <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/inventory/purchase', $attributes, $hidden);?>
            <table class="table table-bordered table-sm table-striped " id="appRowDiv">
                <tr>
                    <th class="text-center">Category Name</th>
                    <th class="text-center">Sub Category Name</th>
                    <th class="text-center">Product Name</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Approx amount</th>
                    <th class="text-center">Total amount</th>
                    <th class="text-center"> <button type="button" id="addRow"  class="btn btn-sm btn-success">+ Add More</button></th>
                </tr>
                <tr></tr>
            </table>
            <button name="btn" type="submit" class="btn btn-primary btn-sm text-right" style="float: right;margin-right: 92px;margin-bottom: 20px;" > <i class="fa fa-check-square-o"></i><?php echo $this->lang->line('xin_save');?></button>
        <?php echo form_close(); ?> 
    </div>

<?php if($this->session->flashdata('success')):?>
  <div class="alert alert-success" id="flash_message">
    <?php echo $this->session->flashdata('success');?>
  </div>
<?php endif; ?> 
<script>
  $(function() {$("#flash_message").hide(2000);});
</script>  
<?php if($this->session->flashdata('warning')):?>
  <div class="alert alert-warning"id="flash_message1">
    <?php echo $this->session->flashdata('warning');?>
  </div>
<?php endif; ?> 
<script>
  $(function() {$("#flash_message1").hide(2000);});
</script> 
<?php }?>

<?php if($this->session->flashdata('delete')):?>
  <div class="alert alert-danger"id="flash_message2">
    <?php echo $this->session->flashdata('delete');?>
  </div>
<?php endif; ?> 

<script>
  $(function() {$("#flash_message2").hide(2000);});
</script> 






<?php
  $category_data = '';
  $category_data .= '<option value="">--Select One--</option>';

  foreach ($categorys as $key => $value) {
    $category_data .= '<option value="'.$value->id.'">'.$value->category_name.'</option>';
  }
?>
<script type="text/javascript">
   $(document).ready(function() {
      $('#purchase_table').DataTable();
   });   
   let sl = 1; 
   $("#addRow").click(function(e) {
      sl++;
      addNewRow(sl);
   }); 
   //remove row
   function removeRow(id){ 
      $(id).closest("tr").remove();
   }
   //add row function
   function addNewRow(sl){
      let items = '';
      items+= '<tr>';
      items+= '<td><select name="cat_id[]" class="form-control input-sm" id="category_'+sl+'" required><?php echo $category_data;?></select></td>';
      items+= '<td><select name="sub_cate_id[]"  id="subcategory_'+sl+'" class="sub_category_val_'+sl+' form-control input-sm" required><option value="">-- Select One --</option></select></td>';
      items+= '<td><select name="product_id[]" class="item_val_'+sl+' form-control input-sm" required><option value="">-- Select One --</option></select></td>';
      items+= '<td><input name="quantity[]" id="quantity_'+sl+'" data-id="'+sl+'" value="0" type="number" class="form-control input-sm" required onChange="change_qty(this)"></td>';
      items+= '<td><input name="approx_amount[]" id="approx_amount_'+sl+'" data-am="'+sl+'" step="0.01" min="0" value="0" type="number" class="form-control input-sm approx_amount" required onChange="change_amount(this)" ></td>';
      items+= '<td><input name="total_amount[]" id="total_amount_'+sl+'" value="0" type="number" class="form-control input-sm" required></td>';
      items+= '<td> <a href="javascript:void();" class="label label-important text-danger" onclick="removeRow(this)"> <i class="fa fa-minus-circle text-danger"></i><span style="color:#a94442;font-size:12px">Remove</span> </a></td>';
      items+= '</tr>';
      $('#appRowDiv tr:last').after(items);
      category_dd(sl);
      subcategory_dd(sl);
   } 

    function change_qty(qty) {
      var approx_amount = document.getElementById('approx_amount_'+qty.getAttribute('data-id')).value;
      document.getElementById('total_amount_'+qty.getAttribute('data-id')).value = Math.round(approx_amount * qty.value);
    }

   function change_amount(amount) {
      var quantity = document.getElementById('quantity_'+amount.getAttribute('data-am')).value;
      document.getElementById('total_amount_'+amount.getAttribute('data-am')).value = quantity * amount.value;
   }

  function category_dd(sl){
    //Category Dropdown
    $('#category_'+sl).change(function(){
      $('.sub_category_val_'+sl).addClass('form-control input-sm');
      $('.sub_category_val_'+sl+' > option').remove();
      var id = $('#category_'+sl).val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('admin/inventory/get_sub_category_ajax/');?>" + id,
        success: function(func_data){
        // console.log();
          $.each(func_data,function(id,name){
            var opt = $('<option />');
            opt.val(id);
            opt.text(name);
            $('.sub_category_val_'+sl).append(opt);
          });
        }
      });
    });
  }

  function subcategory_dd(sl){
    //Sub Category Dropdown
    $('#subcategory_'+sl).on('change',function(){
      $('.item_val_'+sl).addClass('form-control input-sm');
      $(".item_val_"+sl+"> option").remove();
      var id = $('#subcategory_'+sl).val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('admin/inventory/get_product_ajax/');?>" + id,
        success: function(func_data){
          $.each(func_data,function(id,name){
            var opt = $('<option />');
            opt.val(id);
            opt.text(name);
            $('.item_val_'+sl).append(opt);
          });
        }
      });
    });
  }

  $(document).ready(function() {
    $('#cmp_name').change(function() {
      var companyName = $(this).val();
      var url='<?php echo base_url('admin/inventory/get_supplier_ajax/');?>'
      $.ajax({
        url: url,
        type: 'POST',
        data: { companyName: companyName },
        dataType: 'json',
        success: function(func_data) {
          $.each(func_data,function(id,name){
          options += '<option value="' + id + '">' + name + '</option>'; 
        });
        $('#spl_name').html(options);
        },
        error: function(xhr, status, error){
          console.log(xhr.responseText);
        }
      });
    });
  });
</script>