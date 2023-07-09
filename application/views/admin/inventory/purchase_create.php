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
        <h3 class="box-title">Purches Products Requisition </h3>
    
    </div>
     
        <div class="container pt-4">
          <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/inventory/purchase', $attributes, $hidden);?>
                <table class="table table-bordered table-sm table-striped " id="appRowDiv">
                  <tr>
                    
                        <th class="text-center">Comany Name</th>
                        <th class="text-center">Supplier Name</th>
                        
                  </tr>
                   <tr>
                   <td>
                        <select name="cmp_name" class="form-control" id="cmp_name" required>
                            <option id="cmp" value="">Select Company Name</option>
                            <?php foreach($company as $cmp): ?>
                                <option value="<?php echo $cmp->company; ?>"><?php echo $cmp->company; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select name="spl_name" class="form-control" id="spl_name" required>
                            <option id="spl" value="">Select Supplier Name</option>
                        </select>
                    </td>
                      
                   </tr>

                   <!-- <?php foreach($company as $cmp){?>
                          <option value="<?php echo $cmp->company?>"><?php echo $cmp->company?></option>
                          <?php }?> -->
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
   $(document).ready(function() {
      //Load First row
      
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
      // id="category_'+sl+'"
      // let sl=$('#count').val();
      let items = '';
      items+= '<tr>';
      items+= '<td><select name="cat_id[]" class="form-control input-sm" id="category_'+sl+'" required><?php echo $category_data;?></select></td>';
      items+= '<td><select name="sub_cate_id[]"  id="subcategory_'+sl+'" class="sub_category_val_'+sl+' form-control input-sm" required><option value="">-- Select One --</option></select></td>';
      items+= '<td><select name="product_id[]" class="item_val_'+sl+' form-control input-sm" required><option value="">-- Select One --</option></select></td>';
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
         $('.item_val_'+sl).addClass('form-control input-sm');
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

    //Company Supplier
    $(document).ready(function() {
        // Handle change event of the company name select field
        $('#cmp_name').change(function() {
            var companyName = $(this).val();
            // var url = 'fetch_suppliers.php'; // Replace with the URL to fetch suppliers based on the selected company
            var url='<?php echo base_url('admin/inventory/get_supplier_ajax/');?>'
            // Make an AJAX request to fetch the suppliers
            $.ajax({
                url: url,
                type: 'POST',
                data: { companyName: companyName },
                dataType: 'json',
                success: function(func_data) {
                    // console.log(response[0]['name']);
                    var options = '';
                    // $.each(response, function(index, supplier) {
                       
                    //     options += '<option value="' + supplier.id + '">' + supplier.name + '</option>';
                    // });

                    $.each(func_data,function(id,name)
                {

                  options += '<option value="' + id + '">' + name + '</option>';
                  
                });
                      $('#spl_name').html(options);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });


   
      //Sub Category Dropdown

      
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