
<?php 
// dd($row);
$session = $this->session->userdata('username');
$eid = $this->uri->segment(4);
$get_animate = $this->Xin_model->get_content_animate();
$role_resources_ids = $this->Xin_model->user_role_resource(); 
?>


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Category list</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead class="text-center">
          <tr >
            <th class="text-center" style="width:20px;">No.</th>
            <th class="text-center" style="width:100px;">Category</th>
            <th class="text-center" style="width:100px;">Device</th>
            <th class="text-center" style="width:100px;">Model</th>
            <th class="text-center" style="width:100px;">Details</th>
            <th class="text-center" style="width:100px;">Coments</th>
            <th class="text-center" style="width:100px;">Image</th>
            <th class="text-center" style="width:100px;">User</th>
            <th class="text-center" style="width:100px;">Status</th>
            <th class="text-center" style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $key => $row) { ?>
            <tr class="text-center">
              <td><?= $key + 1; ?></td>
              <td><?= $row->cat_name; ?></td>
              <td><?= "MHL ".$row->cat_short_name.'-'.$row->device_name_id; ?></td>
              <td><?= $row->model_name?></td>
              <td><?= $row->description; ?></td>
              <td><?= $row->remark; ?></td>
              <td><img src="<?= base_url("uploads/accessory_images/".$row->image);  ?>"> </td>
              <td><?= $row->first_name.' '.$row->last_name; ?></td>
              <td><?= $row->status=='1'?"<span class='label label-success'>Active</span>":"<span class='label label-danger'>Inctive</span>"; ?></td>
              <td><a class="btn btn-sm btn-info" type="button" href="<?= base_url('admin/accessories/item_add/'.$row->id);?>">Edit</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

 
<script>

  $(document).ready(function() {
    // $('#example').DataTable();
  });

</script>
