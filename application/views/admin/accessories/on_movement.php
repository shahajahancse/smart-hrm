<?php 
// dd($rows);
$get_animate = $this->Xin_model->get_content_animate();
?>
<div class="<?php echo $get_animate?>">
  <table class="datatables-demo table table-striped table-bordered" id="table_five">
    <thead class="text-center">
      <tr>
        <th class="text-center">No.</th>
        <th class="text-center">Category</th>
        <th class="text-center">Device</th>
        <th class="text-center">Model</th>
        <th class="text-center">Number</th>
        <th class="text-center">Image</th>
        <th class="text-center">Status</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $key => $row) { ?>
        <tr class="text-center">
          <td><?= $key + 1; ?></td>
          <td><?= $row->cat_name; ?></td>
          <td><?= "MHL ".$row->cat_short_name.'-'.$row->device_name_id; ?></td>
          <td><?= $row->model_name?></td>
          <td><?= $row->number?></td>
          <td><img height= "50px" src="<?php echo (empty($row->image)) ? base_url("uploads/no_image.png"): base_url("uploads/accessory_images/".$row->image)?>"> 
          </td>
          <td>
            <span class="using">
              <?php echo $row->status==1?"<i class='fa fa-dot-circle-o' style='color:green'></i> Working":($row->status==2?"<i class='fa fa-dot-circle-o' style='color:#22af8e'></i> Stored":($row->status==3?"<i class='fa fa-dot-circle-o' style='color:#d30d70'></i> Servicing":($row->status==4?"<i class='fa fa-dot-circle-o' style='color:red'></i> Destroyed":" <i class='fa fa-dot-circle-o' style='color:#a808e2'></i>Movemnet")));?>
            </span>
          </td>
          <td>
            <div class="dropup">
              <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" >
                Action
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <li><a  href="<?= base_url('admin/accessories/item_add/'.$row->a_id);?>"><span class="text-info"><b>Edit</b></span></a></li>
                <li><a  href="<?= base_url('admin/accessories/delete/'.$row->a_id.'/product_accessories/index');?>" onclick="return confirm('Are you sure to delete!!!')"><span class="text-danger"><b>delete</b></span></a></li>
              </ul>
            </div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script>
  $('#table_five').DataTable();
</script> 