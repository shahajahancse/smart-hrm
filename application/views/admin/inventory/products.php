<?php
/* Attendance view
*/
// dd($results);
?>
<style>
.dropdown-item {
    padding: 4px;
    margin: 5px;
    width: 72px;
    height: 28px;
    text-align: center;
    border: 1px solid #0177bc;
    border-radius: 4px;
    /* New style for dropdown-item */
    background-color: #f8f9fa;
    color: #212529;
    transition: box-shadow 0.3s, color 0.3s;
}

.dropdown-item:hover {
    /* Hover effect */
    box-shadow: 0 0 5px #0177bc;
    color: #fff;
}

.dropdown-menu {
    min-width: 85px !important;
}

.btn {
    padding: 3px !important;
}
</style>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="box mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $this->lang->line('xin_add_new');?> Item</h3>
            <div class="box-tools pull-right">
                <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
                    <button type="button" class="btn btn-xs btn-primary">Add New</button>
                </a>
            </div>
        </div>

        <div id="add_form" class="collapse add-form <?php echo $get_animate; echo ($col != null)? ' in':''?>"
            data-parent="#accordion" style="">
            <div class="box-body">
                <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                <?php $hidden = array('user_id' => $session['user_id']);?>
                <?php echo form_open('admin/inventory/products', $attributes, $hidden);?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Category<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                                <select class="form-control" name="cat_id" id="cat_id" required>
                                    <option value="">select category</option>
                                    <?php foreach ($categorys as $rows) { ?>
                                    <option <?php echo (!empty($row) && $row->cat_id == $rows->id)? 'selected':'' ?>
                                        value="<?= $rows->id?>"><?= $rows->category_name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Sub Category<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                                <?php echo form_error('sub_cate_id');?>
                                <select class="form-control" name="sub_cate_id" id="sub_cate_id" required>
                                    <option value="">Select Sub Category</option>
                                    <?php foreach ($sub_categorys as $rows) { ?>
                                    <option
                                        <?php echo (!empty($row) && $row->sub_cate_id == $rows->id)? 'selected':'' ?>
                                        value="<?= $rows->id?>"><?= $rows->sub_cate_name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="order_level">Order Level<i class="hrsale-asterisk"
                                        style="color:red !important">*</i></label>
                                <input class="form-control" placeholder="order level..." name="order_level" type="text"
                                    required value="<?php echo !empty($row->order_level)? $row->order_level:''; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="product_name">Product Name<i class="hrsale-asterisk"
                                        style="color:red !important">*</i></label>
                                <input class="form-control" placeholder="Product name" name="product_name" required
                                    value="<?php echo !empty($row->product_name)? $row->product_name:''; ?>">
                            </div>
                        </div>
                        <input type="hidden" name="hidden_id" value="<?php echo !empty($row->id)? $row->id:''; ?>">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="unit_id">Select Unit<i class="hrsale-asterisk"
                                        style="color:red !important">*</i></label>
                                <select class="form-control" name="unit_id" required>
                                    <option value="">select category</option>
                                    <?php foreach ($units as $rows) { ?>
                                    <option <?php echo (!empty($row) && $row->unit_id == $rows->id)? 'selected':'' ?>
                                        value="<?= $rows->id?>"><?= $rows->unit_name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="quantity">Quantity<i class="hrsale-asterisk"
                                        style="color:red !important">*</i></label>
                                <input class="form-control" placeholder="Quantity" name="quantity" type="text"
                                    value="<?php echo !empty($row->quantity)? $row->quantity:''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="quantity">Product Description<i class="hrsale-asterisk"
                                        style="color:red !important">*</i></label>
                                <textarea class="form-control" placeholder="Product description" name="short_details"
                                    type="text"><?php echo !empty($row->short_details)? $row->short_details:''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions box-footer" style="margin-top :20px">
                    <button type="submit" class="btn btn-sm btn-primary" style="margin-right: -15px;">  Save </button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php echo validation_errors(); ?>
<?php if($this->session->flashdata('success')):?>
<div class="alert alert-success alert-dismissible" id="flash_message1"><a href="#" class="close" data-dismiss="alert"
        aria-label="close">&times;</a>
    <?php echo $this->session->flashdata('success');?>
</div>
<script>
$(function() {
    $("#flash_message1").hide(2000);
});
</script>
<?php endif; ?>

<?php if($this->session->flashdata('warning')):?>
<div class="alert alert-warning alert-dismissible"><a href="#" class="close" data-dismiss="alert"
        aria-label="close">&times;</a>
    <?php echo $this->session->flashdata('warning');?>
</div>
<?php endif; ?>

<div class="box <?php echo $get_animate;?>">
    <div class="box-header with-border">
        <h3 class="box-title">Item List</h3>
    </div>
    <div class="box-body">
        <div class="box-datatable table-responsive">
            <table class="datatables-demo table table-striped table-bordered" id="example">
                <thead>
                    <tr>
                        <th style="width:40px;">No.</th>
                        <th style="">Product Name</th>
                        <th style="">Category</th>
                        <th style="">Sub Category</th>
                        <th style="">Unit Name</th>
                        <th style="">Quantity</th>
                        <th style="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $key => $rows) { ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $rows->product_name; ?></td>
                        <td><?php echo $rows->category_name; ?></td>
                        <td><?php echo $rows->sub_cate_name; ?></td>
                        <td><?php echo $rows->unit_name; ?></td>
                        <td><?php echo $rows->quantity; ?></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm dropdown-toggle" style="background: transparent;box-shadow:none !important" data-toggle="dropdown">
                                    <span><i class="fa fa-ellipsis-v" ></i></span> 
                                </button>
                                <div class="dropdown-menu dropdown-menu-right list-group"
                                    aria-labelledby="actionButton">
                                    <a style="padding-left:5px;"  href="<?= base_url('admin/inventory/product_details/'.$rows->id) ?>">Details</a>
                                    <hr class="divider">
                                    <a style="padding-left:5px;" href="<?= base_url('admin/inventory/products/'.$rows->id);?>">Edit</a>
                                    <hr class="divider">
                                    <a style="padding-left:5px;" href="<?= base_url('admin/inventory/products_delete/'.$rows->id);?>">Delete</a>
                                </div>
                            </div>
                        </td>
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
    $("#cat_id").on('change', function(e) {
        $('#sub_cate_id').addClass('form-control');
        $("#sub_cate_id > option").remove();
        var pt = $('<option />');
        pt.val('');
        pt.text('Select Sub Category');
        $('#sub_cate_id').append(pt);
        cat_id = document.getElementById('cat_id').value;
        var url = "<?php echo base_url('admin/inventory/get_sub_category_ajax/');?>" + cat_id;
        $.ajax({
            url: url,
            contentType: "application/json",
            dataType: "json",
            type: "POST",
            success: function(func_data) {
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('#sub_cate_id').append(opt);
                });
            }
        });
    });


    $('#example').DataTable({
        "pageLength": 25,
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
    });
});
</script>