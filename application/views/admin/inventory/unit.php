<?php
// dd($row->unit_name);
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
        <?php echo form_open_multipart('admin/inventory/unit', $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="unit_name">Unit Name</label>
                <input class="form-control" required name="unit_name" placeholder="unit name" type="text" value="<?php echo !empty($row->unit_name)? $row->unit_name:''; ?>">
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
    <h3 class="box-title">Unit  list</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead>
          <tr>
            <th style="width:120px;">No.</th>
            <th style="width:100px;">Unit Name</th>
            <th style="width:100px;">description</th>
            <th style="width:100px;">Status</th>
            <th style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $key => $row) { ?>
            <tr>
              <td><?= $key + 1; ?></td>
              <td><?= $row->unit_name; ?></td>
              <td><?= $row->description; ?></td>
              <td><?= $row->status; ?></td>
              <td><a href="<?= base_url('admin/inventory/unit/'.$row->id);?>">Edit</a></td>
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
