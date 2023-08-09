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
        <?php echo form_open_multipart('admin/inventory/category', $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label >Category Name</label>
                <input class="form-control" required name="category_name" placeholder="category name" type="text" value="<?php echo !empty($row->category_name)? $row->category_name:''; ?>">
              </div>
            </div>
            <input type="hidden" name="hidden_id" value="<?php echo !empty($row->id)? $row->id:''; ?>">

            <div class="col-md-5">
              <div class="form-group">
                <label for="description">Description</label>
                <input class="form-control" placeholder="description" name="description" type="text" value="<?php echo !empty($row->description)? $row->description:''; ?>">
              </div>
            </div>

            <div class="col-md-2">
              <label for="description">Status</label>
              <select name="status" class="form-control" required>  
                <option value="">select status</option>
                <option <?php echo(!empty($row->status) && $row->status == 'Enable')? 'selected':''; ?> value="Enable">Enable</option>
                <option <?php echo(!empty($row->status) && $row->status == 'Disable')? 'selected':''; ?> value="Disable">Disable</option>
              </select>
            </div>

            <div class="col-md-2">
              <div class="form-group"> &nbsp;
                <label for="first_name">&nbsp;</label><br />
                <input type="submit" name="submit" class="btn btn-primary" value="Insert"/>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

            <?php echo validation_errors(); ?>
            <?php if($this->session->flashdata('success')):?>
              <div class="alert alert-success">
                <?php echo $this->session->flashdata('success');?>
              </div>
            <?php endif; ?> 

            <?php if($this->session->flashdata('warning')):?>
              <div class="alert alert-warning">
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
            <th class="text-center" style="width:100px;">Description</th>
            <th class="text-center" style="width:100px;">Status</th>
            <th class="text-center" style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $key => $row) { ?>
            <tr class="text-center">
              <td><?= $key + 1; ?></td>
              <td><?= $row->category_name; ?></td>
              <td><?= $row->description; ?></td>
              <td><?= $row->status=='Enable'?"<span class='label label-success'>Active</span>":"<span class='label label-danger'>Inctive</span>"; ?></td>
              <td>
                <a class="btn btn-sm btn-info" href="<?= base_url('admin/inventory/category/'.$row->id);?>">Edit</a>
                <a class="btn btn-sm btn-danger" href="<?= base_url('admin/inventory/delete_category/'.$row->id);?>">Delete</a>
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
