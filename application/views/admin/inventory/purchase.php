<?php
/* Attendance view
*/
// dd($username);
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
  .table {
    width: 92%;
    margin-bottom: 14px;
}
</style>
<?php if($user_role_id !=1){?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
        <h3 class="box-title">Add Requisition</h3>
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
                <button name="btn" type="submit" class="btn btn-primary btn-sm text-right" style="float: right;margin-right: 92px;margin-bottom: 20px;" > <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            <?php echo form_close(); ?> 
        </div>
    </div>

  </div>
</div>

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

<?php }?>

<!-- modal -->
<div class="modal fade " id="left_resign_list"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" 
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <h3 class="box-title" style="margin:20px; padding-top:20px;">Requisition List</h3>
        <table class="table table-responsive table-striped table-bordered text-center" style="width: 96%;margin: 20px;">
          <tr>
            <th>Sub Category Name</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Requisition Date</th>
          </tr>
          <tr>
            <td>a</td>
            <td>a</td>
            <td>a</td>
            <td>a</td>
          </tr>
          <tr>
            <td>a</td>
            <td>a</td>
            <td>a</td>
            <td>a</td>
          </tr>
          <tr>
            <td>a</td>
            <td>a</td>
            <td>a</td>
            <td>a</td>
          </tr>
          <tr>
            <td>a</td>
            <td>a</td>
            <td>a</td>
            <td>a</td>
          </tr>
        </table>
        <button data-dismiss="modal" id="buttonsss" class="btn btn-sm btn-danger" style="margin-left:20px;margin-bottom:20px">Close</button>
    </div>
  </div>
</div>
<!-- modal -->

<div class="box <?php echo $get_animate;?>" style="margin-top:20px">
  <div class="box-header with-border">
    <h3 class="box-title">Requisition List</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive" >
    <input type="hidden" value="1" id="count">
      <table class="datatables-demo table table-striped table-bordered" id="purchase_table" style="width:100%">
        <thead>
          <tr>
              <th class="text-center" style="width:20px;">No.</th>
              <?php if($user_role_id==1){?>
                <th class="text-center" style="width:100px;">Requisition By</th>
                <th class="text-center" style="width:20px;">Status</th>
                <th class="text-center" style="width:50px;">Action</th>
              <?php }?> 
              <?php if($user_role_id==4){?>
                <th class="text-center" style="width:100px;">Category Name</th>
                <th class="text-center" style="width:20px;">Status</th>
                <th class="text-center" style="width:50px;">Action</th>
              <?php }?> 
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $key => $rows) { ?>
            <tr>
              <td class="text-center"><?php echo ($key+1)."."; ?></td>
                <?php if($user_role_id==1){?>
                  <td class="text-center"><?php echo $rows->first_name." ".$rows->last_name; ?></td>
                  <td class="text-center"><?php echo $rows->status==1?"
                      <span class='badge' style='background-color:#ffc107'><b>Pending</b></span>":
                      ($rows->status==2 ? "<span class='badge' style='background-color:#28a745'><b>Approved</b>
                      </span>" : "<span class='badge' style='background-color:#28a745'><b>Persial Approved</b></span>");
                ?>
              </td>
                <td class="text-center"> <a class="btn btn-sm btn-info" name="btn" href="<?= base_url('admin/inventory/purchase/'.$rows->id);?>">Details</a></td>
              <?php } ?>
              <?php if($user_role_id==4){?>
                <td class="text-center"><?php echo $rows->category_name; ?></td>
                <td class="text-center"><?php echo $rows->status==1?"
                      <span class='badge' style='background-color:#ffc107'><b>Pending</b></span>":
                     ($row->status==2?  "<span class='badge' style='background-color:#28a745'><b>Approved</b></span>": "<span class='badge' style='background-color:#28a745'><b>Persial Approved</b></span>");
                    ?></td>
                <td class="text-center">
                <?php if($rows->status ==1){?>
                  <button class="btn btn-sm btn-info" name="btn" id="modal">Edits</button>
                <?php } else{?>
                <a class="btn btn-sm btn-light" href="<?= base_url('admin/inventory/purchase/'.$rows->id);?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <?php }?>
              </td>
            </tr>
          <?php }} ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
$category_data = '';
$category_data .= '<option value="">--Select One--</option>';
$i=1;
foreach ($categorys as $key => $value) {
   $category_data .= '<option value="'.$i++.'">'.$value->category_name.'</option>';
}?>
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

      items+= '<td><select name="cat_id[]" class="form-control input-sm" id="category_'+sl+'" required><?php echo $category_data;?></select></td>';
      items+= '<td><select name="sub_cate_id[]"  id="subcategory_'+sl+'" class="sub_category_val_'+sl+' form-control input-sm" required><option value="">-- Select One --</option></select></td>';
      items+= '<td><select name="product_id[]" class="item_val_'+sl+' form-control input-sm" required><option value="">-- Select One --</option></select></td>';
      items+= '<td><input name="quantity[]" value="" type="text" class="form-control input-sm" required></td>';
      items+= '<td> <a href="javascript:void();" class="label label-important text-danger" onclick="removeRow(this)"> <i class="fa fa-minus-circle text-danger"></i> <span style="color:#a94442;font-size:12px">Remove</span> </a></td>';
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
 $('#modal').on('click',function(){
  $('#left_resign_list').modal('show');
  $('#req_table').DataTable();
 });

</script>  