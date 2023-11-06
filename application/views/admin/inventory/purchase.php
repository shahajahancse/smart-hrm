<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
.table {
    width: 92%;
    margin-bottom: 14px;
}
</style>
<?php if($user_role_id !=3){?>
<?php if($this->session->flashdata('success')):?>
<div class="alert alert-success" id="flash_message">
    <?php echo $this->session->flashdata('success');?>
</div>
<?php endif; ?>
<script>
$(function() {
    $("#flash_message").hide(2000);
});
</script>
<?php if($this->session->flashdata('warning')):?>
<div class="alert alert-warning" id="flash_message1">
    <?php echo $this->session->flashdata('warning');?>
</div>
<?php endif; ?>
<script>
$(function() {
    $("#flash_message1").hide(2000);
});
</script>
<?php }?>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('admin/inventory/product_purchase_recived/')?>
                <input type="hidden" name="row_id" id="id" value="">
                <table>
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

                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                <?php echo form_close()?>
            </div>

        </div>
    </div>
</div>



<div class="box <?php echo $get_animate;?>" style="margin-top:20px">
    <div class="box-header with-border">
        <h3 class="box-title">Purchase List</h3>
        <a class="pull-right btn btn-primary btn-sm" href="<?= base_url('admin/inventory/purchase_create')?>">Add New</a>
    </div>
    <div class="box-body">
        <div class="box-datatable">
            <input type="hidden" value="1" id="count">
            <table class="datatables-demo table table-striped table-bordered" id="purchase_table" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width:20px;">No.</th>
                        <?php if($user_role_id==1){?>
                        <th class="text-center">Requisition By</th>
                        <?php }?>
                        <th class="text-center">Supplier</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Request Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if (is_array($products)) {
                        foreach ($products as $key => $rows) {?>
                    <tr>
                        <td class="text-center"><?php echo ($key+1)."."; ?></td>
                        <?php if($user_role_id==1 || $user_role_id==2){?>
                        <td class="text-center"><?php echo $rows->first_name." ".$rows->last_name; ?></td>
                        <?php } ?>
                        <td class="text-center"><?php echo isset($rows->name) ?></td>
                        <td class="text-center">
                            <?php echo $rows->status == 1 ?"<span class='badge' style='background-color:#ffc107'><b>Pending</b></span>": ($rows->status == 2 ?  "<span class='badge' style='background-color:#28a745'><b>Approved</b></span>": ( $rows->status ==3? "<span class='badge' style='background-color:#28a745'><b>Deliver</b></span>":"<span class='badge' style='background-color:#d56666'><b>Rejected</b></span>")); ?>
                        </td>
                        <td class="text-center"><?php echo date('d M Y',strtotime($rows->created_at)); ?></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" style="min-width: 100px !important;border-radius:0;line-height: 2;  " aria-labelledby="dropdownMenuButton">
                                    <?php if($session['role_id']==4){?>
                                        <?php if($rows->status == 1){?>
                                            <a style="padding-left:5px; font-weight:bold" class="text-primary" href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                            <hr style="margin:1px;"><a style="padding-left:5px; font-weight:bold" class="text-info" href="<?= base_url('admin/inventory/product_purchase_edit_approved/'.$rows->id);?>">Edit</a> <br>
                                            <hr style="margin:1px;"><a style="padding-left:5px; font-weight:bold" class="text-info" href="<?= base_url('admin/inventory/product_purchase_delete/'.$rows->id);?>">Delete</a> <br>
                                        <?php }else{?>
                                            <a style="padding-left:5px; font-weight:bold" class="text-primary" href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                            <hr style="margin:1px;"><a style="padding-left:5px; font-weight:bold" class="text-info" href="<?= base_url('admin/inventory/product_purchase_delete/'.$rows->id);?>">Delete</a> <br>
                                        <?php }?>
                                    <?php }?>
                                    <?php if($session['role_id'] == 1 ||  $session['role_id'] == 2){?>
                                        <?php if($rows->status==1){?>
                                            <hr style="margin:1px;"><a style="padding-left:5px; font-weight:bold" class="text-success" href="<?= base_url('admin/inventory/product_purchase_edit_approved/'.$rows->id);?>">Approved</a> <br>
                                            <a style="padding-left:5px; font-weight:bold" class="text-primary" href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                            <hr style="margin:1px;"><a style="padding-left:5px; font-weight:bold" class="text-danger" href="<?= base_url('admin/inventory/product_purchase_rejected/'.$rows->id);?>">Reject</a><br>
                                        <?php }else{?>
                                            <hr style="margin:1px;"><a style="padding-left:5px; font-weight:bold" class="text-success" href="#"  data-toggle="modal" data-target="#exampleModalCenter" data-row_id="<?= $rows->id ?>" onclick="openmod(this)">Order Receive</a><br>
                                       <?php  }?>
                                    <?php }?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php } }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
//Company Supplier
$(document).ready(function() {
    $('#purchase_table').DataTable();
    // Handle change event of the company name select field
    $('#cmp_name').change(function() {
        var companyName = $(this).val();
        var url = '<?php echo base_url('admin/inventory/get_supplier_ajax/');?>'
        // Make an AJAX request to fetch the suppliers
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                companyName: companyName
            },
            dataType: 'json',
            success: function(func_data) {
                var options = '';
                $.each(func_data, function(id, name) {
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
</script>
<script>
function openmod(id) {
    var rowId = $(id).attr("data-row_id");
    $("#id").val(rowId); 
}
</script>
