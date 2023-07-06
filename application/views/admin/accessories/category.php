<?php 
$session = $this->session->userdata('username');
$eid = $this->uri->segment(4);
$get_animate = $this->Xin_model->get_content_animate();
$role_resources_ids = $this->Xin_model->user_role_resource(); 
?>

<?php
// dd($row->category_name);
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
        <?php echo form_open_multipart('admin/accessories/category', $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label >Category Name</label>
                <input class="form-control" required name="cat_name" placeholder="Category Name" type="text" value="<?php echo !empty($row->cat_name)? $row->cat_name:''; ?>">
              </div>
            </div>
            <input type="hidden" name="hidden_id" value="<?php echo !empty($row->id)? $row->id:''; ?>">

            <div class="col-md-3">
              <div class="form-group">
                <label for="description">Short Name</label>
                <input class="form-control" placeholder="Short Name" name="cat_short_name" type="text" value="<?php echo !empty($row->cat_short_name)? $row->cat_short_name:''; ?>">
              </div>
            </div>
            <div class="col-md-3">
              <label for="Status">Category Status</label>
              <select name="status" class="form-control" required>  
                <option value="">Select status</option>
                <option value="1" <?php echo (isset($row->status) && $row->status == 1) ? 'selected':''; ?> >Active</option>
                <option value="0" <?php echo (isset($row->status) && $row->status == 0) ? 'selected':''; ?> >Inactive</option>
              </select>
            </div>
            <div class="col-md-2">
              <label for="Status"></label>
              <div class="form-group" style="margin-top:5px">
                <?php if(isset($row->id)==null){?>
                <input type="submit" name="submit" class="btn btn-success" style="float:right" value="Add Category"/>
                <?php }else{?>
                <input type="submit" name="submit" class="btn btn-primary" style="float:right" value="Update Category"/>
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
    <div class="alert alert-success" style="width: 250px;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo $this->session->flashdata('success');?>
    </div>
<?php endif; ?> 

<?php if($this->session->flashdata('warning')):?>
    <div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo $this->session->flashdata('warning');?>
    </div>
<?php endif; ?> 


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
            <th class="text-center" style="width:100px;">Name</th>
            <th class="text-center" style="width:100px;">Short Name</th>
            <th class="text-center" style="width:100px;">Status</th>
            <th class="text-center" style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $key => $row) { ?>
            <tr class="text-center">
              <td><?= $key + 1; ?></td>
              <td><?= $row->cat_name; ?></td>
              <td><?= $row->cat_short_name; ?></td>
              <td><?= $row->status=='1'?"<span class='label label-success'>Active</span>":"<span class='label label-danger'>Inctive</span>"; ?></td>
              <td>
                <a class="btn btn-sm btn-info" href="<?= base_url('admin/accessories/category/'.$row->id);?>">Edit</a>
                <a class="btn btn-sm btn-danger" href="<?= base_url('admin/accessories/delete/'.$row->id.'/product_accessory_categories'.'/category');?>" onclick="return confirm('Are you sure to delete!!!')">Delete</a>
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
  });

</script>
