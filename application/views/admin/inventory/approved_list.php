<?php 
  // dd($products);
  $session = $this->session->userdata('username');
  $get_animate = $this->Xin_model->get_content_animate();
?>
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
    <h3 class="box-title">
      <?php 
        $status_text = "Approved";
        if($products != null || !empty($products)) { 
          switch ($products[0]->status) {
            case 1:
              $status_text = "Pending";
              break;
            case 2:
              $status_text = "Approved";
              break;
            case 3:
              $status_text = "Received";
              break;
          }
        }
        echo $status_text;
      ?> 
      List
    </h3>
  </div>
  <div class="box-body">
    <div class="box-datatable " >
    <input type="hidden" value="1" id="count">
      <table class="datatables-demo table table-striped table-bordered" id="purchase_table" style="width:100%">
        <thead>
          <tr>
            <th class="text-center" style="width:40px;">No.</th>
              <th class="text-center" style="width:150px;">Requisition By</th>
              <th class="text-center" style="width:50px;">Item_Name</th>
              <th class="text-center" style="width:40px;">Qty</th>
              <th class="text-center" style="width:20px;">App_Qty</th>
              <th class="text-center" style="width:20px;">Status</th>
              <th class="text-center" style="width:20px;">Req_Date</th>
              <th class="text-center" style="width:20px;">Priority</th>
              <th class="text-center" style="width:20px;">Remark</th>
              <th class="text-center" style="width:50px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $key => $rows) { 
            if ($rows->status == 5 ) {
              $status = "<span class='using' style='color:#28a745'>First Step Approved</span>";
            } else if ($rows->status == 1 ) {
              $status = "<span class='using' style='color:#ffc107'> <i class='fa fa-dot-circle-o'></i> Pending</span>";
            } else if ($rows->status == 2 ) {
              $status = "<span class='using' style='color:#28a745'> <i class='fa fa-dot-circle-o'></i> Approved</span>";
            } else if ($rows->status == 3 ) {
              $status = "<span class='using' style='color:#087a58'> <i class='fa fa-dot-circle-o'></i> Handover</span>";
            } else if ($rows->status == 4 ) {
              $status = "<span class='using' style='color:#d56666'> <i class='fa fa-dot-circle-o'></i> Rejected</span>";
            } else if ($rows->status == 6 ) {
              $status = "<span class='using' style='color:#0b70ed'> <i class='fa fa-dot-circle-o'></i> Admin Approved</span>";
            }
          ?>

            <tr>
              <td class="text-center"><?php echo ($key+1)."."; ?></td>
              <td class="text-center"><?php echo $rows->first_name." ".$rows->last_name; ?></td>
              <td class="text-center"><?= $rows->product_name?></td>
              <td class="text-center"><?= $rows->quantity?></td>
              <td class="text-center"><?= $rows->approved_qty?></td>
              <td class="text-center"><?= $status  ?> </td>
              <td class="text-center"><?php echo date('d-m-Y',strtotime($rows->created_at)); ?></td>
              <td class="text-center">
                <?php
                if ($rows->priority == 1) { 
                    echo "<span class='label label-danger'>High</span>";
                } elseif ($rows->priority == 2) { 
                    echo "<span class='label label-warning'>Medium</span>";
                } else {
                    echo "<span class='label label-success'>Low</span>";
                }
                ?>
              </td>
              <td style="cursor: pointer; color: #310bff" title="<?= $rows->note ?>" ><?= substr($rows->note, 0,10) ?></td>
              <td class="text-center">
                <div class="btn-group <?php echo $rows->status == 3?'d-hidden':''?>" >
                  <button type="button" class="btn btn-sm dropdown-toggle" style="background: transparent;box-shadow:none !important" data-toggle="dropdown">
                    <span><i class="fa fa-ellipsis-v" ></i></span> 
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li class="<?php echo ($session['role_id'] != 1) ?'d-hidden':''?>">
                      <a href="<?= base_url('admin/inventory/requsition_rejected/'.$rows->id);?>">
                        <b class="text-danger">Rejected</b>
                      </a>
                    </li>
                    <li >
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/hand_over/'.$rows->id);?>">
                        <b class="text-info">Delivered</b>
                      </a>
                    </li>
                  </ul>
                </div>
              </td>
          <?php } ?>
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