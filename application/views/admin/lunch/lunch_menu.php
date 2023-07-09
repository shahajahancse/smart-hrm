<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form submitted, process the data
    
    // Perform form validation and data processing here
    
    // Redirect the user to another page
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<!-- Your HTML form code goes here -->

<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
.table {
    width: 92%;
    margin-bottom: 14px;

}

.dropup .dropdown-menu {
    top: 20px;
    bottom: inherit;
    right: 50px !important;
    left: auto !important;
    min-width: 100px !important;
}
</style>
<?php if($user_role_id !=3){?>
<div class="box mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
        <div class="box-header with-border">
            <h3 class="box-title">Add Lunch Menu Information</h3>
            <div class="box-tools pull-right">
                <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
                    <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span>
                        <?php echo $this->lang->line('xin_add_new');?></button>
                </a>
            </div>
        </div>
        <div id="add_form" class="collapse add-form <?php echo $get_animate; echo ($col != null)? ' in':''?>"
            data-parent="#accordion" style="">
            <div class="container pt-4">
                <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                <?php $hidden = array('user_id' => $session['user_id']);?>

                <?php echo form_open(current_url(), $attributes, $hidden);?>

                <table class="table table-bordered table-sm table-striped" id="appRowDiv">
                    <tr>
                        <input type="hidden" name="hid" id="hid">
                        <th class="text-center">Package Name</th>
                        <td class="text-center">
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Enter Package Name" required>
                        </td>
                        <th class="text-center">Description</th>
                        <td class="text-center">
                            <!-- <input type="text" id="description" name="description" class="form-control" placeholder="Enter Description" required> -->
                            <textarea id="description" name="description" class="form-control"
                                placeholder="Enter Description" required></textarea>
                        </td>
                        <td class="text-center">
                            <button name="btn" type="submit" class="btn btn-primary btn-sm text-right"> <i
                                    class="fa fa-check-square-o"></i><?php echo $this->lang->line('xin_save');?></button>
                        </td>
                    </tr>
                </table>


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
$(function() {
    $("#flash_message").hide(2000);
});
</script>
<?php if($this->session->flashdata('warning')):?>
<div class="alert alert-danger" id="flash_message1">
    <?php echo $this->session->flashdata('warning');?>
</div>
<?php endif; ?>
<script>
$(function() {
    $("#flash_message1").hide(2000);
});
</script>
<?php }?>




<div class="box <?php echo $get_animate;?>" style="margin-top:20px">
    <div class="box-header with-border">
        <h3 class="box-title"> Lunch Menu Information List</h3>
    </div>
    <div class="box-body">
        <div class="box-datatable table-responsive">
            <input type="hidden" value="1" id="count">
            <table class="datatables-demo table table-striped table-bordered" id="purchase_table" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center" style="width:20px;">No.</th>
                        <?php if($user_role_id==1 || $user_role_id==3){?>
                        <th class="text-center" style="width:100px;">Pakage Name</th>
                        <th class="text-center" style="width:20px;">Description</th>
                        <th class="text-center" style="width:20px;">Action</th>

                        <?php }?>
                        <?php if($user_role_id==4){?>
                        <th class="text-center" style="width:100px;">Pakage Name</th>
                        <th class="text-center" style="width:20px;">Description</th>

                        <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menulist as $key => $rows) { ?>
                    <tr>
                        <td class="text-center"><?php echo ($key+1)."."; ?></td>
                        <?php if($user_role_id==1 || $user_role_id==2){?>
                        <input type="hidden">
                        <td class="text-center"><?php echo $rows->pakage_name ?></td>
                        <td class="text-center"><?php echo $rows->details ?></td>

                        <!-- <td class="text-center"> 
                    <a onclick="edit(<?php echo $rows->id ?>)" class=" btn btn-sm btn-info text-dark collapsed" data-toggle="collapse" href="?<?php echo $rows->id; ?>#add_form" aria-expanded="false"><i class="fa fa-info" aria-hidden="true"></i>Edit
                  </td> -->
                        <td class="text-center">
                            <div class="dropup">
                                <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenu2"
                                    data-toggle="dropdown">Action
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <li><a class="btn btn-sm btn-info" onclick="edit(<?php echo $rows->id ?>)"
                                            data-toggle="collapse" href="?<?php echo $rows->id; ?>#add_form">Edit</a>
                                    </li>
                                    <li><a class="btn btn-sm btn-danger"
                                            href="<?= base_url('admin/lunch/menu_delete/'.$rows->id);?>"
                                            onclick="return confirm('Are you sure to delete!!!')">delete</a></li>
                                </ul>
                            </div>
                        </td>

                        <?php } ?>

                    </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- <?php
  $category_data = '';
  $category_data .= '<option value="">--Select One--</option>';
  $i=1;
  foreach ($categorys as $key => $value) {
    $category_data .= '<option value="'.$i++.'">'.$value->category_name.'</option>';
  }
?> -->

<script type="text/javascript">
function edit(id) {

    $.ajax({
        type: "POST",
        url: "<?php echo base_url('admin/lunch/get_menu_ajax/');?>" + id,
        success: function(func_data) {
            console.log(func_data);

            $('#name').val(func_data.pakage_name);
            $('#description').val(func_data.details);
            $('#hid').val(func_data.id);
            $('#add_form').show();

        }
    });



}
</script>