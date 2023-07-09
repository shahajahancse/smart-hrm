
<?php 
// dd($results);
$session = $this->session->userdata('username');
$eid = $this->uri->segment(4);
$get_animate = $this->Xin_model->get_content_animate();
$role_resources_ids = $this->Xin_model->user_role_resource(); 
?>

<?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success" style="width: 250px;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
      <?php echo $this->session->flashdata('success');?>
    </div>
<?php endif; ?> 


<style>
  .dropup .dropdown-menu{
    top: 20px;
    bottom: inherit;
    right: 50px !important;
    left: auto !important;
    min-width: 100px !important;
  }
</style>


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Item list</h3>
    <a class="btn btn-sm btn-info" style="float:right" href="<?php echo base_url('admin/accessories/item_add')?>">Add Item</a>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead class="text-center">
          <tr>
            <th  style="width:60px;">No.</th>
            <!-- <th class="text-center" style="width:100px;">User</th> -->
            <th style="width:100px;">Category</th>
            <th style="width:80px;">Device</th>
            <th style="width:80px;">Model</th>
            <th style="width:80px;">Number</th>
            <th style="width:120px;">Description</th>
            <th style="width:80px;">Purpose</th>
            <th style="width:80px;">Image</th>
            <th style="width:80px;">Status</th>
            <th style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $key => $row) { ?>
            <tr class="text-center">
              <td><?= $key + 1; ?></td>
              <!-- <td>< ?= $row->first_name.' '.$row->last_name; ?></td> -->
              <td><?= $row->cat_name; ?></td>
              <td><?= "MHL ".$row->cat_short_name.'-'.$row->device_name_id; ?></td>
              <td><?= $row->model_name?></td>
              <td><?= $row->number?></td>
              <td><?= $row->description; ?></td>
              <td><?= $row->remark; ?></td>
              <td><img src="<?php echo (empty($row->image)) ? base_url("uploads/no_image.png"): base_url("uploads/accessory_images/".$row->image)?>"> 
              </td>
              <td>
                 <?php 
                      echo    $row->status; 
                  ?>
              </td>
              <td>
                <div class="dropup">
                  <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" >
                      Action
                      <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                      <li><a class="btn btn-sm btn-info" href="<?= base_url('admin/accessories/item_add/'.$row->id);?>">Edit</a></li>
                      <li><a class="btn btn-sm btn-danger" href="<?= base_url('admin/accessories/delete/'.$row->id.'/product_accessories/index');?>" onclick="return confirm('Are you sure to delete!!!')">delete</a></li>
                  </ul>
                </div>
                <a class="btn btn-sm btn-info" type="button" href="<?= base_url('admin/accessories/item_add/'.$row->a_id);?>">Edit</a>
                <a class="btn btn-sm btn-danger" type="button" href="<?= base_url('admin/accessories/delete/'.$row->a_id.'/product_accessories/index');?>" onclick="return confirm('Are you sure to delete!!!')">Delete</a>

              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      
    </div>
  </div>
</div>

 
<script>

  $(document).ready(function() {
    $('#example').DataTable({
      "pageLength": 50,
      "lengthMenu": [[25, 50,100, -1], [25, 50, 100, "All"]],
    });
  });

</script>
