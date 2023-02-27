<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_add_new');?> Product</h3>
      <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/inventory/products', $attributes, $hidden);?>
        <div class="form-body">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="cat_id">Select Category<i class="hrsale-asterisk">*</i></label>
                  <select class="form-control" id="cat_id" name="cat_id" id="cat_id">
                  <option value="text">Text Field</option>
                  <option value="textarea">Text Area</option>
                </select>
              </div>
            </div>

            <div class="col-md-5"> 
              <div class="form-group">
                <label for="sub_cate_id">Select Sub Category<i class="hrsale-asterisk">*</i></label>
                <select class="form-control" id="sub_cate_id" name="sub_cate_id" id="sub_cate_id">
                  <option value="text">Text Field</option>
                  <option value="textarea">Text Area</option>
                  <option value="select">Select</option>
                  <option value="multiselect">Multi Select</option>
                </select>
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-group">
                <label for="order_level">Order Level<i class="hrsale-asterisk">*</i></label>
                <input class="form-control" placeholder="order level..." name="order_level" type="text" id="order_level">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-7">  
              <div class="form-group">
                <label for="product_name">Product Name<i class="hrsale-asterisk">*</i></label>
                <input class="form-control" placeholder="product name..." name="product_name" type="text" id="product_name">
              </div>
            </div>

            <div class="col-md-3">      
              <div class="form-group" id="add_items">
                <label for="unit_id">Select Unit<i class="hrsale-asterisk">*</i></label>
                <select class="form-control" id="unit_id" name="unit_id" data-placeholder="unit...">
                  <option value="text">Text Field</option>
                  <option value="textarea">Text Area</option>
                  <option value="select">Select</option>
                  <option value="multiselect">Multi Select</option>
                </select>
              </div>
            </div>

            <div class="col-md-2">      
              <div class="form-group" id="add_items">
                <label for="quantity">Quantity<i class="hrsale-asterisk">*</i></label>
                <input class="form-control" placeholder="quantity..." name="quantity" type="text" id="quantity">
              </div>
            </div>
          </div>
        </div>

        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Inventory Product List</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead>
          <tr>
            <th style="width:120px;">No.</th>
            <th style="width:100px;">Product Name</th>
            <th style="width:100px;">Status</th>
            <th style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $key => $row) { ?>
            <tr>
              <td><?php echo $key + 1; ?></td>
              <td><?php echo $row->product_name; ?></td>
              <td><a href="<?php echo base_url('admin/timesheet/delete_attn_file/'.$row->id); ?>" class="btn btn-danger btn-sm">Delete</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

 
<script>

  $(document).ready(function() {
    // file upload
    $("#attn_file_upload").on('submit', function(e) {
      var url = "<?php echo base_url('admin/timesheet/attn_file_upload'); ?>";
      e.preventDefault();

      var okyes;
      okyes=confirm('Are you sure you want to upload file?');
      if(okyes==false) return;

      $.ajax({
          url: url,
          type: 'POST',
          dataType: "json",
          data: new FormData(this),
          processData: false,
          contentType: false,
          cache : false,


          success: function(response){

            if(response.status == 'success') {
              alert(response.message)
            } else {
              alert(response.message)
            }
          },
          error: function(response) { 
            alert(response.message)
          }
      });
      return false;
    });


    $('#example').DataTable();


  });

</script>
