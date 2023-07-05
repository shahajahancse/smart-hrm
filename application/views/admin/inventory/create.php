<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
  .table {
    width: 92%;
    margin-bottom: 14px;
}
</style>
<?php if($user_role_id ==1 || $user_role_id==3 || $user_role_id==2){?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
        <h3 class="box-title">Add Requisition</h3>
    </div>
        <div class="container pt-4">
          <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/inventory/create', $attributes, $hidden);?>
                <table class="table table-bordered table-sm table-striped " id="appRowDiv">
                    <tr>
                        <th class="text-center">Category Name</th>
                        <th class="text-center">Sub Category Name</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center"> <button type="button" id="addRow"  class="btn btn-sm btn-success">+ Add More</button></th>
                    </tr>
                    <tr></tr>
                </table>
                <!-- <input type="submit" name="btn" class="" value="Save"> -->
                <button name="btn" type="submit" class="btn btn-primary btn-sm text-right" style="float: right;margin-right: 92px;margin-bottom: 20px;" > <i class="fa fa-check-square-o"></i><?php echo $this->lang->line('xin_save');?></button>
            <?php echo form_close(); ?> 
        </div>

  </div>
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




<?php
  $category_data = '';
  $category_data .= '<option value="">--Select One--</option>';
  $i=1;
  foreach ($categorys as $key => $value) {
    $category_data .= '<option value="'.$i++.'">'.$value->category_name.'</option>';
  }
?>
<script type="text/javascript">
    // load auto row when page load
   $(document).ready(function() {
      //Load First row
      addNewRow();
      // $('#purchase_table').DataTable();
   });  

   // add row to new item
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
      // id="category_'+sl+'"
      // let sl=$('#count').val();
      let items = '';
      items+= '<tr>';
      items+= '<td><select name="cat_id[]" class="form-control input-sm" id="category_'+sl+'" required><?php echo $category_data;?></select></td>';
      items+= '<td><select name="sub_cate_id[]"  id="subcategory_'+sl+'" class="sub_category_val_'+sl+' form-control input-sm" required><option value="">-- Select One --</option></select></td>';
      items+= '<td><select name="product_id[]" class="item_val_'+sl+' form-control input-sm" required ><option value="">-- Select One --</option></select></td>';
      items+= '<td><input name="quantity[]" id="quantity" value="" type="text" class="form-control input-sm" required></td>';
      items+= '<td> <a href="javascript:void();" class="label label-important text-danger" onclick="removeRow(this)"> <i class="fa fa-minus-circle text-danger"></i><span style="color:#a94442;font-size:12px">Remove</span> </a></td>';
      items+= '</tr>';
      // $('#count').val(sl+parseInt(1));
      $('#appRowDiv tr:last').after(items);
      category_dd(sl);
      subcategory_dd(sl);
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
            success: function(func_data)
            {
               // console.log(func_data);
               $.each(func_data,function(id,name)
               {
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
         $('.item_val_'+sl).addClass('forcontrolm- input-sm');
         $(".item_val_"+sl+"> option").remove();
         var id = $('#subcategory_'+sl).val();

         $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/inventory/get_product_ajax/');?>" + id,
            success: function(func_data)
            {
               $.each(func_data,function(id,name)
               {

                  var opt = $('<option />');
                  opt.val(id);
                  opt.text(name);
                  $('.item_val_'+sl).append(opt);
               });
              //  handleSelectionChange(this)
           


            }
         });
      });
   }
  


    function handleSelectionChange(selectedMenu) {
      var selectionMenus = document.getElementsByClassName("selection-menu");
      

      // Disable all options
      for (var i = 0; i < selectionMenus.length; i++) {
        var options = selectionMenus[i].options;
        console.log(options);
        for (var j = 0; j < options.length; j++) {console.log(options[j]);
          options[j].disabled = false;
        }
      }

      // Iterate over all selection menus
      for (var i = 0; i < selectionMenus.length; i++) {
        var options = selectionMenus[i].options;
        var selectedValues = [];

        // Get the selected values from each selection menu
        for (var j = 0; j < options.length; j++) {
          if (options[j].selected) {
            selectedValues.push(options[j].value);
          }
        }

        // Disable selected options in other selection menus
        for (var j = 0; j < selectionMenus.length; j++) {
          if (selectionMenus[j] !== selectedMenu) {
            var otherOptions = selectionMenus[j].options;
            for (var k = 0; k < otherOptions.length; k++) {
              if (selectedValues.includes(otherOptions[k].value)) {
                otherOptions[k].disabled = true;
              }
            }
          }
        }
      }
    }
  </script>