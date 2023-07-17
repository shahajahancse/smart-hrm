<?php
// dd($results); 
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
  .table {
    width: 92%;
    margin-bottom: 14px;
}
</style>
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


<div class="box <?php echo $get_animate;?>" style="margin-top:20px">
  <div class="box-header with-border">
    <h3 class="box-title">Requisition List</h3>
    <a class="btn btn-sm btn-primary pull-right" href="<?= base_url('admin/inventory/create');?>">Add New</a>
  </div>
  <div class="box-body">
    <div class="box-datatable" >
    <!-- <input type="hidden" value="1" id="count"> -->
      <table class="datatables-demo table table-striped table-bordered" id="purchase_table" style="width:100%">
        <thead>
          <tr>
              <?php if($user_role_id==1 || $user_role_id== 2 || $user_role_id== 4){?>
              <th class="text-center" style="width:20px;">No.</th>
                <th class="text-center"style="width: 34%;">Requisition By</th>
                <th class="text-center" style="width:20px;">Status</th>
                <th class="text-center" style="width:20px;">Request Date</th>
                <th class="text-center" style="width:50px;">Action</th>
              <?php }?> 
              <?php if($user_role_id==3){?>
              <th class="text-center" style="width:20px;">No.</th>
              <th class="text-center" style="width: 34%;">Requisition By</th>
                <!-- <th class="text-center" >Category</th>
                <th class="text-center" >Sub Category</th>
                <th class="text-center" >Product Name</th> -->
                <!-- <th class="text-center" >Quantity</th>
                <th class="text-center" >Approved Quantity</th> -->
                <th class="text-center" >Status</th>
                <th class="text-center" >Request Date</th>
                <!-- <th class="text-center" ></th> -->
                <th class="text-center" style="width:50px;">Action</th>
              <?php }?> 
          </tr>
        </thead>
        <tbody>
          <?php if($user_role_id==1 || $user_role_id == 4 || $user_role_id == 2){?>
          <?php  foreach ($products as $key => $rows) { ?>
            <tr>
                  <td class="text-center"><?php echo ($key+1)."."; ?></td>
                  <td class="text-center"><?php echo $rows->first_name." ".$rows->last_name; ?></td>
                  <td class="text-center">
                    <?php echo $rows->status == 5 ? "<span class='badge' style='background-color:#28a745'><b>First Step Approved</b></span>" : ($rows->status == 1 ? "<span class='badge' style='background-color:#ffc107'><b>Pending</b></span>" : ($rows->status == 2 ? "<span class='badge' style='background-color:#28a745'><b>Approved</b></span>" : ($rows->status == 3 ? "<span class='badge' style='background-color:#087a58'><b>Handover</b></span>" : "<span class='badge' style='background-color:#d56666'><b>Rejected</b></span>"))); ?>
                  </td>

                <td class="text-center"><?php echo date('d-m-Y',strtotime($rows->created_at)); ?></td>
                <!-- <td class="text-center"> <a class="btn btn-sm btn-info" href="<?= base_url('admin/inventory/purchase_details/'.$rows->id);?>"><i class="fa fa-info" aria-hidden="true"></i> Details</td> -->
                <td class="text-center">
                        <div class="dropdown" >
                      <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                    
                      <?php if($rows->status==1 || $rows->status==5){?> 
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Edit</a><br>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/delete_requsiton/'.$rows->id);?>">Delete</a> <br>
                          <a style="padding-left:5px; " href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Approved</a><br>
                          <a style="padding-left:5px; " href="<?= base_url('admin/inventory/requsition_rejected/'.$rows->id);?>">Reject</a>
                        <?php } if($rows->status== 2){?>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/hand_over/'.$rows->id);?>">Delivered</a> <br>
                        <?php } if($rows->status== 3){?>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                        <?php } if($rows->status== 4){?>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                        <?php if($session['role_id']== 1 || $session['role_id']== 2 ){?>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Edit</a><br>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/delete_requsiton/'.$rows->id);?>">Delete</a> <br>
                        <?php }?> 
                      </div>
              </td>
             
                <?php } } }?>
                        
              <?php  if($user_role_id==3){ 
                foreach ($products as $key => $rows){  
              ?>
                <td class="text-center"><?php echo ($key+1)."."; ?></td>
                <td class="text-center"><?php echo $rows->first_name." ".$rows->last_name; ?></td>
             
               
                
                <td class="text-center">
                    <?php echo $rows->status == 5 ? "<span class='badge' style='background-color:#28a745'><b>First Step Approved</b></span>" : ($rows->status == 1 ? "<span class='badge' style='background-color:#ffc107'><b>Pending</b></span>" : ($rows->status == 2 ? "<span class='badge' style='background-color:#28a745'><b>Approved</b></span>" : ($rows->status == 3 ? "<span class='badge' style='background-color:#28a745'><b>Handover</b></span>" : "<span class='badge' style='background-color:#d56666'><b>Rejected</b></span>"))); ?>
                </td>
                <td class="text-center"><?php echo $rows->created_at; ?></td>
                <td class="text-center">
                    <!-- <a class="btn btn-sm btn-info" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>"><i class="fa fa-eye" aria-hidden="true"></i> Details</a> -->
                   
                    <div class="dropdown" >
                      <!-- < ?php if($rows->status== 2 || $rows->status== 3){?> -->
                      <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <!-- < ?php }?> -->
                      <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                        <!-- <a style="padding-left:5px;" href="< ?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br> -->
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                          <?php if($rows->status==1){?> 
                              <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Edit</a> <br>
                              <a style="padding-left:5px; " href="<?= base_url('admin/inventory/delete_requsiton/'.$rows->id);?>">Delete</a>
                       
                      </div>
                    </div>
                    <?php } ?>
                </td>
            </tr>
  <?php  }}?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
   $(document).ready(function() {

      $('#purchase_table').DataTable();
   });   

  </script>