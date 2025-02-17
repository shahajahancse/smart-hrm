<?php 
// dd($results);
$session = $this->session->userdata('username');
$eid = $this->uri->segment(4);
$get_animate = $this->Xin_model->get_content_animate();
$role_resources_ids = $this->Xin_model->user_role_resource(); 
?>

<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('id' => 'unit_insert', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/accessories/device_model', $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-3">
              <label for="Status">Category Name</label>
              <select id="cat_iddd" name="cat_id" class="form-control" required>  
                <option value="">Select</option>
                <?php foreach ($categories as $key => $category) {?>
                <option value="<?php echo $category->id ?>" <?php echo (!empty($row->cat_id) && $row->cat_id == $category->id)? 'selected':''; ?> ><?php echo $category->cat_name ?></option>
                <?php }?>
              </select>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label >Model Name</label>
                <input class="form-control" required name="model_name" placeholder="Model Name" type="text" value="<?php echo !empty($row->model_name)? $row->model_name:''; ?>">
              </div>
            </div>
            <input type="hidden" name="hidden_id" value="<?php echo !empty($row->id)? $row->id:''; ?>">

            <div class="col-md-6">
              <div class="form-group">
                <label for="description">Description</label>
                <input class="form-control" placeholder="Description" name="details" type="text" value="<?php echo !empty($row->details)? $row->details:''; ?>">
              </div>
            </div>
            
          </div>
          <div class="row">
            <div class="col-md-3">
              <label for="Status">Model Status</label>
              <select name="status" class="form-control" required>  
                <option value=""  selected>Select status</option>
                <option value="1" <?php echo (!empty($row->status) && $row->status == 1)? 'selected':''; ?> >Active</option>
                <option value="0" <?php echo (isset($row->status) && $row->status == 0)? 'selected':''; ?> >Inactive</option>
             </select>
            </div>
            <div class="col-md-4">
                <label for="Status">Image</label>
              <input class="form-control" type="file" name="image">
            </div>
            <div class="col-md-3">
              <div class="form-group"> &nbsp;
                <label for="">&nbsp;</label><br />
                <?php if(isset($row->id)==null){?>
                <input type="submit" name="submit" class="btn btn-success" value="Add Model"/>
                <?php }else{?>
                <input type="submit" name="submit" class="btn btn-primary" value="Update Model"/>
                <?php }?>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

<?php echo validation_errors(); ?>
<?php if($this->session->flashdata('success')):?>
  <div class="alert alert-success" style="width:250px">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
      <?php echo $this->session->flashdata('success');?>
  </div>
<?php endif; ?> 


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Model list</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead class="text-center">
          <tr >
            <th class="text-center" style="width:20px;">No.</th>
            <th class="text-center" style="width:100px;">Category Name</th>
            <th class="text-center" style="width:100px;">Model Name</th>
            <th class="text-center" style="width:100px;">Description</th>
            <th class="text-center" style="width:100px;">Status</th>
            <th class="text-center" style="width:100px;">Image</th>
            <th class="text-center" style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $key => $row) { ?>
            <tr class="text-center">
              <td><?= $key + 1; ?></td>
              <td><?= $row->cat_name; ?></td>
              <td><?= $row->model_name; ?></td>
              <td><?= $row->details; ?></td>
              <td><?= $row->status=='1'?"<span class='label label-success'>Active</span>":"<span class='label label-danger'>Inctive</span>"; ?></td>
               <td><img src="<?php echo (empty($row->image)) ? base_url("uploads/no_image.png"): base_url("uploads/accessory_images/".$row->image)?>" width="80px" height="80px"> 
              <td>
                <a class="btn btn-sm btn-info" href="<?= base_url('admin/accessories/device_model/'.$row->id);?>">Edit</a>
                <a class="btn btn-sm btn-danger" href="<?= base_url('admin/accessories/delete/'.$row->id.'/product_accessories_model'.'/device_model');?>" onclick="return confirm('Are you sure to delete!!!')">Delete</a>
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
    $('#example').DataTable();
      $('#cat_iddd').select2();
  });

</script>
