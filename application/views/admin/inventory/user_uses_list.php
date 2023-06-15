<?php 
// dd($user_uses_list);
 $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
  .table1 {
    width: 85%;
    margin-bottom: 14px;
    margin-left: 0px;
}
</style>

<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
        <h3 class="box-title">Add new users accessory</h3>
      <div class="box-tools pull-right"> 
        <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> 
       </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate; echo ($col != null)? ' in':''?>" 
      data-parent="#accordion" style="">
        <div class="container pt-4">
          <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/inventory/purchase', $attributes, $hidden);?>
                <table class="table1 table table-bordered table-sm table-striped " id="appRowDiv">
                    <tr>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Desk No</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Sub Category</th>
                        <th class="text-center">Item</th>
                        <th class="text-center">Tag</th>
                        <th class="text-center">Details</th>
                        <th class="text-center"> <button type="button" id="addRow"  class="btn btn-sm btn-success">+ Add More</button></th>
                    </tr>
                    <tr></tr>
                </table>
                <button name="btn" type="submit" class="btn btn-primary btn-sm text-right" style="float: right;margin-right: 171px;margin-bottom: 20px;" > <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            <?php echo form_close(); ?> 
        </div>
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
      addNewRow();
      $('#purchase_table').DataTable();
   });   

   $("#addRow").click(function(e) {
      addNewRow();
   }); 
   //remove row
   function removeRow(id){ 
      $(id).closest("tr").remove();
   }
   //add row function
   function addNewRow(){
      // id="category_'+sl+'"
      let sl=$('#count').val();
      let items = '';
      items+= '<tr>';
      items+= '<td><select name="emp_id[]" class="form-control input-sm" id="emp_id_'+sl+'" required><?php echo $emp_name;?></select></td>';
      items+= '<td><select name="desk_no[]" class="form-control input-sm" id="desk_no_'+sl+'" required><?php echo $desk_no;?></select></td>';
      items+= '<td><select name="cat_id[]" class="form-control input-sm" id="category_'+sl+'" required><?php echo $category_data;?></select></td>';
      items+= '<td><select name="sub_cate_id[]"  id="subcategory_'+sl+'" class="sub_category_val_'+sl+' form-control input-sm" required><option value="">-- Select One --</option></select></td>';
      items+= '<td><select name="product_id[]" class="item_val_'+sl+' form-control input-sm" required><option value="">-- Select One --</option></select></td>';
      items+= '<td><input name="tag[]" id="tag" value="" type="text" class="form-control input-sm" required></td>';
      items+= '<td><input name="details[]" id="details" value="" type="text" class="form-control input-sm" required></td>';
      items+= '<td> <a href="javascript:void();" class="label label-important text-danger" onclick="removeRow(this)"> <i class="fa fa-minus-circle text-danger"></i><span style="color:#a94442;font-size:12px">Remove</span> </a></td>';
      items+= '</tr>';
      $('#count').val(sl+parseInt(1));
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

            }
         });
      });
   }

    //Company Supplier
    $(document).ready(function() {
        $('#cmp_name').change(function() {
            var companyName = $(this).val();
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












<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">User Uses List</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead>
          <tr>
            <th class="text-center" style="width:20px;">No.</th>
            <th class="text-center" style="width:100px;">Name</th>
            <th class="text-center" style="width:100px;">Desk No.</th>
            <th class="text-center" style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; 
                foreach($user_uses_list as $value) {
          ?>
            <tr class="text-center">
                <td><?php echo $i++?></td>
                <td><?php echo $value->first_name.' '.$value->last_name?></td>
                <td><?php echo $value->desk_no?></td>
                <td>
                    <a href="<?php echo $value->id?>" class="btn btn-primary btn-sm" >Edit</a>
                    <a href="<?php echo $value->id?>" class="btn btn-danger btn-sm" >Delete</a>
                    <a id="<?php echo $value->id?>"  onclick="get_details(id)" class="btn btn-info btn-sm get_details" data-toggle="modal" data-target="#largeShoes" data-first='<?php echo $value->first_name?>'>
                     Details
                    </a>
                </td>
            </tr>
            <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>
            <!-- [employee_id] => MHL08C8712942
            [date_of_birth] => 1996-10-03
            [department_name] => Technical Team
            [designation_name] => Jr. Software Engineer
            [tag] => MHL HP-28
            [details] => HP, core i7,8th generation -->

<!-- The modal -->
<div class="modal fade" id="largeShoes" tabindex="-1" role="dialog" aria-labelledby="modalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalLabelLarge">Details</h4>
             </div> 
            <div class="modal-body">
              <h5>Employee Info</h5>
              <div class="row">

                  <div class="col-sm-6 col-md-4 col-lg-6">
                    <p><span class="fw-bold">Employee Id :</span> <span>MHL08C87129623</span></p>
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-6">
                    <p><span class="fw-bold">Name :</span> <span>Md Shahajahan Ali</span></p>
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-6">
                    <p><span class="fw-bold">Department :</span> <span>Technical Team</span></p>
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-6">
                    <p><span class="fw-bold">Designation :</span> <span>Software Engineer</span></p>
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-6">
                    <p><span class="fw-bold">Date of Join :</span> <span>01-Sep-2021</span></p>
                  </div>
                  <div class="col-sm-6 col-md-4 col-lg-6">
                    <p><span class="fw-bold">Desk No :</span> <span>26</span></p>
                  </div>

                </div>     
             </div>
             <div>    
              <h5 style="margin-left:15px" class="fw-bold">Accessory Details</h5>
             </div>

                <table class=" table table-bordered table-sm table-striped" style="margin-bottom:20px !important;">
                    <tr>
                        <th class="text-center">Category</th>
                        <th class="text-center">Sub Category</th>
                        <th class="text-center">Device Name</th>
                        <th class="text-center">Tag</th> 
                        <th class="text-center">Description</th> 
                    </tr>
                    <tr class="text-center">
                      <td id="category"></td>
                      <td id="sub_category"></td>
                      <td id="device_name"></td>
                      <td id="tag"></td>
                      <td id="description"></td>
                    </tr>
                </table>
                  <button type="button" class=" btn btn-sm btn-danger" style="float:right;margin-right: 8px;" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">Close</span>
                </button>
                <br>

                <br>
            </div>
        </div>
    </div>
</div>

 
<script>

  $('.get_details').on('click', function (e) {
    var button = $(e.relatedTarget);
    var leaveId = button.data('leave_id');
    var emname = button.data('emname');
    var companyId = button.data('category');
    var employeeId = button.data('sub_category');
    var departmentId = button.data('device_name');
    var leaveTypeId = button.data('tag');
    var leaveType = button.data('description');

    $('#emname').text(emname);
    $('#leaveType').text(leaveType);
    $('#qty').text(qty);
    $('#fromDate').text(fromDate);
    $('#toDate').text(toDate);
    $('#appliedOn').text(appliedOn);
    $('#reason').text(reason);
    $('#remarks').text(remarks);
    $('#statuss').text(statuss);
  });

  $(document).ready(function() {
    $('#example').DataTable();
  });

</script>
