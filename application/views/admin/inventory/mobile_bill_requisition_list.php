      
<table class="datatables-demo table table-striped table-bordered" id="bill_table" style="width:100%">
  <thead>
    <tr>
      <th class="text-center">No.</th>
      <th class="text-center">Date</th>
      <th class="text-center">Name</th>
      <th class="text-center">Number</th>
      <th class="text-center">Amount</th>
      <th class="text-center">App. Amount</th>
      <th class="text-center">Status</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php  foreach($mobiles as $key => $rows) { ?>
      <tr>
            <td  class="text-center"><?php echo ($key+1)."."; ?></td>
            <td  class="text-center"><?php echo date('d M Y',strtotime($rows->created_at)); ?></td>
            <td  class="text-center"><?php echo $rows->first_name." ".$rows->last_name; ?></td>
            <td  class="text-center"><?php echo '0'.$rows->phone_number?></td>
            <td  class="text-center"><?php echo $rows->amount; ?></td>
            <td  class="text-center"><?php echo $rows->approved_amount=='' || $rows->approved_amount==null ? '0': $rows->approved_amount; ?></td>
            <td  class="text-center">
              <?php echo $rows->status == 1 ? "<span class='using' style='color:#c3b901'> <i class='fa fa-dot-circle-o'></i> Pending</span>" : ($rows->status == 2 ? "<span class='using' style='color:green'> <i class='fa fa-dot-circle-o'></i> Approved</span>" : ($rows->status == 3 ? "<span class='using' style='color:red'> <i class='fa fa-dot-circle-o'></i>Rejected</span>":"<span class='using' style='color:#19ae1c'> <i class='fa fa-dot-circle-o'></i>Payment</span>") ); ?>
            </td>
            <td  class="text-center">
              <div class="btn-group <?php echo $rows->status == 3?'d-hidden':''?>" >
                <button type="button" class="btn btn-sm dropdown-toggle" style="background: transparent;box-shadow:none !important" data-toggle="dropdown">
                  <span><i class="fa fa-ellipsis-v" ></i></span> 
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li class="<?php echo ($rows->status == 2) ?'d-hidden':''?>">
                    <a href="<?= base_url('admin/inventory/mobile_bill_edit_approved/'.$rows->id);?>">
                      <b class="text-success">Approved</b>
                    </a>
                  </li>
                  <li class="divider <?php echo ($rows->status == 2  || $rows->status == 4) ?'d-hidden':''?>"></li>
                  <li class="<?php echo ($rows->status == 2  || $rows->status == 4) ?'d-hidden':''?>">
                    <a href="<?= base_url('admin/inventory/edit_mobile_bill_rejected/'.$rows->id);?>">
                      <b class="text-danger">Rejected</b>
                    </a>
                  </li>
                  <li class="divider <?php echo $rows->status == 2 ?'d-hidden':''?>"></li>
                  <li class="<?php echo $rows->status == 2 ?'d-hidden':''?>">
                    <a href="<?= base_url('admin/inventory/mobile_delete/'.$rows->id);?>">
                      <b class="text-danger">Delete</b>
                    </a>
                  </li>
                  <li class="divider <?php echo $rows->status == 2 || $rows->status == 4 || $rows->status == 1  ?'d-hidden':''?>"></li>
                  <li class="<?php echo ($rows->status == 4) || ($rows->status == 1) ?'d-hidden':''?>">
                      <a style="padding-left:5px;" href="<?= base_url('admin/inventory/mobile_bill_hand_over/'.$rows->id);?>">
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

<script>
  $('#bill_table').DataTable({
      "bSort": false,
  });
</script>