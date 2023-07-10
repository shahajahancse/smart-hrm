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
                <?php echo form_open('admin/inventory/product_purchase_delivered/')?>
                <input type="hidden" name="id" id="rawid" value="">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                <?php echo form_close()?>
            </div>

        </div>
    </div>
</div>



<div class="box <?php echo $get_animate;?>" style="margin-top:20px">
    <div class="box-header with-border">
        <h3 class="box-title">Purchase List</h3>
        <a class="pull-right btn btn-primary btn-sm" href="<?= base_url('admin/inventory/purchase_create')?>">Add
            New</a>
    </div>
    <div class="box-body">
        <div class="box-datatable">
            <input type="hidden" value="1" id="count">
            <table class="datatables-demo table table-striped table-bordered" id="purchase_table" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width:20px;">No.</th>
                        <?php if($user_role_id==1){?>
                        <th class="text-center" style="width:100px;">Requisition By</th>
                        <?php }?>
                        <th class="text-center" style="width:100px;">Supplier</th>
                        <th class="text-center" style="width:20px;">Status</th>
                        <th class="text-center" style="width:50px;">Request Date</th>
                        <th class="text-center" style="width:50px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  foreach ($products as $key => $rows) { ?>
                    <tr>
                        <td class="text-center"><?php echo ($key+1)."."; ?></td>
                        <?php if($user_role_id==1){?>
                        <td class="text-center"><?php echo $rows->first_name." ".$rows->last_name; ?></td>
                        <?php } ?>
                        <td class="text-center"><?php echo $rows->name ?></td>
                        <td class="text-center">
                            <?php echo $rows->status==1?"
                <span class='badge' style='background-color:#ffc107'><b>Pending</b></span>": ($rows->status==2?  "<span class='badge' style='background-color:#28a745'><b>Approved</b></span>": ( $rows->status ==3? "<span class='badge' style='background-color:#28a745'><b>Deliver</b></span>":"<span class='badge' style='background-color:#d56666'><b>Rejected</b></span>")); ?>
                        </td>

                        <!-- status==1=Pending status==2=Approved status ==3 Deliver Rejected -->

                        <td class="text-center"><?php echo date('d-m-Y',strtotime($rows->created_at)); ?></td>
                        <td class="text-center">
                            <?php if($user_role_id==1 || $user_role_id==2 ){ ?>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Action
                                </button>
                                <?php if ($rows->status==1) { ?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_edit_approved/'.$rows->id);?>">Edit</a>
                                    <br>
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_edit_approved/'.$rows->id);?>">Approved</a>
                                    <br>
                                    <a style="padding-left:5px; "
                                        href="<?= base_url('admin/inventory/product_purchase_rejected/'.$rows->id);?>">Reject</a>
                                    <br>
                                    <!-- <a style="padding-left:5px;"
                                                    href="<?= base_url('admin/inventory/product_purchase_delivered/'.$rows->id);?>">Order
                                                    Receive</a> <br> -->
                                </div>
                                <?php }elseif($rows->status==2) { ?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                    <!-- <a style="padding-left:5px;" 
                                        href="<?= base_url('admin/inventory/product_purchase_delivered/'.$rows->id);?>">Order
                                        Receive</a> <br> -->
                                </div>
                                <?php }elseif($rows->status==3) { ?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                </div>
                                <?php }else{?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;"
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                </div>
                                <?php } ?>
                            </div>
                            <?php }elseif($user_role_id==4){ ?>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Action
                                </button>
                                <?php if ($rows->status==1) { ?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_edit_approved/'.$rows->id);?>">Edit</a>
                                    <br>

                                    <a style="padding-left:5px; "
                                        href="<?= base_url('admin/inventory/product_purchase_rejected/'.$rows->id);?>">Reject</a>
                                    <br>
                                    <!-- <a style="padding-left:5px;"
                                                    href="<?= base_url('admin/inventory/product_purchase_delivered/'.$rows->id);?>">Order
                                                    Receive</a> <br> -->
                                </div>
                                <?php }elseif($rows->status==2) { ?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                    <a style="padding-left:5px;" data-toggle="modal" data-target="#exampleModalCenter"
                                        id="<?= $rows->id ?>" onclick="openmod(this)">Order
                                        Receive</a> <br>
                                </div>
                                <?php }elseif($rows->status==3) { ?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                </div>
                                <?php }else{?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                </div>
                                <?php } ?>
                            </div>

                            <?php }elseif($user_role_id==3){ ?>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Action
                                </button>
                                <?php if ($rows->status==1) { ?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_edit_approved/'.$rows->id);?>">Edit</a>
                                </div>
                                <?php }elseif($rows->status==2) { ?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>

                                </div>
                                <?php }elseif($rows->status==3) { ?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                </div>
                                <?php }else{?>
                                <div class="dropdown-menu"
                                    style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "
                                    aria-labelledby="dropdownMenuButton">
                                    <a style="padding-left:5px;"
                                        href="<?= base_url('admin/inventory/product_purchase_details/'.$rows->id);?>">Details</a><br>
                                </div>
                                <?php } ?>
                            </div>

                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
//Company Supplier
$(document).ready(function() {
    // Handle change event of the company name select field
    $('#cmp_name').change(function() {
        var companyName = $(this).val();
        // var url = 'fetch_suppliers.php'; // Replace with the URL to fetch suppliers based on the selected company
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
                // console.log(response[0]['name']);
                var options = '';
                // $.each(response, function(index, supplier) {

                //     options += '<option value="' + supplier.id + '">' + supplier.name + '</option>';
                // });

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
function openmod(data) {

    document.getElementById('rawid').value = data.id;
}
</script>