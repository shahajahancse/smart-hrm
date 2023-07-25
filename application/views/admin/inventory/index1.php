<?php
// dd($products);   
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
  .table {
    width: 92%;
    margin-bottom: 14px;
}
.using {
    display: inline-flex;
    padding: 4.5px 14.3px 5.5px 9px;
    align-items: center;
    gap: 9px;
    border-radius: 50px;
    border: 1px solid #CCC;
    background: #FFF;
    font-size:12px
}

.d-hidden {
  display: none !important;
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

  <div class="card">
    <div class="card-body">
      <table class="datatables-demo table table-striped table-bordered" id="purchase_tables" style="width:100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>Date</th>
            <th>Name</th>
            <th>Category</th>
            <th>Item Name</th>
            <th>Qty</th>
            <th>App. Qty</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php  foreach($products as $key => $rows) { ?>
            <tr>
                  <td><?php echo ($key+1)."."; ?></td>
                  <td><?php echo date('d-m-Y',strtotime($rows->created_at)); ?></td>
                  <td><?php echo $rows->first_name." ".$rows->last_name; ?></td>
                  <td><?php echo $rows->category_name?></td>
                  <td><?php echo $rows->product_name; ?></td>
                  <td><?php echo $rows->quantity; ?></td>
                  <td><?php echo $rows->approved_qty; ?></td>
                  <td>
                    <?php echo $rows->status == 5 ? "<span class='using' style='color:#28a745'>First Step Approved</span>" : ($rows->status == 1 ? "<span class='using' style='color:#ffc107'> <i class='fa fa-dot-circle-o'></i> Pending</span>" : ($rows->status == 2 ? "<span class='using' style='color:#28a745'> <i class='fa fa-dot-circle-o'></i> Approved</span>" : ($rows->status == 3 ? "<span class='using' style='color:#087a58'> <i class='fa fa-dot-circle-o'></i> Handover</span>" : "<span class='using' style='color:#d56666'> <i class='fa fa-dot-circle-o'></i> Rejected</span>"))); ?>
                  </td>
                  <td>
                    <div class="btn-group <?php echo $rows->status == 3?'d-hidden':''?>" >
                      <button type="button" class="btn btn-sm dropdown-toggle" style="background: transparent;box-shadow:none !important" data-toggle="dropdown">
                        <span><i class="fa fa-ellipsis-v" ></i></span> 
                      </button>
                      <ul class="dropdown-menu dropdown-menu-right">
                        <li class="<?php echo ($rows->status == 2) ?'d-hidden':''?>">
                          <a href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">
                            <b class="text-success">Approved</b>
                          </a>
                        </li>
                        <li class="divider <?php echo ($rows->status == 2  || $rows->status == 4) ?'d-hidden':''?>"></li>
                        <li class="<?php echo ($rows->status == 2  || $rows->status == 4) ?'d-hidden':''?>">
                          <a href="<?= base_url('admin/inventory/requsition_rejected/'.$rows->id);?>">
                            <b class="text-danger">Rejected</b>
                          </a>
                        </li>
                        <li class="divider <?php echo $rows->status == 2 ?'d-hidden':''?>"></li>
                        <li class="<?php echo $rows->status == 2 ?'d-hidden':''?>">
                          <a href="<?= base_url('admin/inventory/delete_requsiton/'.$rows->id);?>">
                            <b class="text-danger">Delete</b>
                          </a>
                        </li>
                        <li class="divider <?php echo $rows->status == 2 || $rows->status == 4 || $rows->status == 1  ?'d-hidden':''?>"></li>
                        <li class="<?php echo ($rows->status == 4) || ($rows->status == 1) ?'d-hidden':''?>">
                            <a style="padding-left:5px;" href="<?= base_url('admin/inventory/hand_over/'.$rows->id);?>">
                            <b class="text-info">Delivered</b>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </td>
            </tr>      
          <?php }?>         
        </tbody>
      </table>

    </div>
  </div>

</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#purchase_tables').DataTable();
  });   
</script>