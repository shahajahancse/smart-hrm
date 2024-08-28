<!-- < ?php dd('KO');?> -->

<table class="datatables-demo table table-striped table-bordered" id="eqp_table" style="width:100%">
  <thead>
    <tr class="text-center">
      <th class="text-center">No.</th>
      <th class="text-center">Date</th>
      <th class="text-center">Name</th>
      <th class="text-center">Category</th>
      <th class="text-center">Item Name</th>
      <th class="text-center">Qty</th>
      <th class="text-center">App. Qty</th>
      <th class="text-center">Remark</th>
      <th class="text-center">Status</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php  foreach($equipments as $key => $rows) { ?>
      <tr>
            <td><?php echo ($key+1)."."; ?></td>
            <td><?php echo date('d M Y',strtotime($rows->created_at)); ?></td>
            <td><?php echo $rows->first_name." ".$rows->last_name; ?></td>
            <td><?php echo $rows->category_name?></td>
            <td><?php echo $rows->product_name; ?></td>
            <td><?php echo intval( $rows->quantity).' '.$rows->unit_name; ?></td>
            <td><?php echo intval($rows->approved_qty).' '.$rows->unit_name; ?></td>
            <td><?php echo $rows->note; ?></td>
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

<script>
  $(document).ready(function() {
    $('#eqp_table').DataTable({
     "bSort": false
    });
  });

</script>