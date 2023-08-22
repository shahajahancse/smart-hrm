<?php 
// dd($row);
$session = $this->session->userdata('username');
$get_animate = $this->Xin_model->get_content_animate();
?>

<?php
// dd($row->category_name);
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<!-- < ?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?> -->
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('id' => 'unit_insert', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/payroll/add_festival_bonus', $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-12">
                <h4 class="form-group"><b>Add Festival Name & Date</b></h4>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label >Festival Name</label>
                <input class="form-control" required name="festival_name" placeholder="Festival Name" type="text" value="<?php echo !empty($row->festival_name)? $row->festival_name:''; ?>">
              </div>
            </div>
            <input type="hidden" name="hidden_id" value="<?php echo !empty($row->id)? $row->id:''; ?>">
            <div class="col-md-3">
              <div class="form-group">
                <label for="description">Date</label>
                <input class="form-control attendance_date " placeholder="Select Date" name="festival_date" type="text" value="<?php echo !empty($row->festival_date)? $row->festival_date:''; ?>">
              </div>
            </div>
            <div class="col-md-3">
                <label class="form-check-label" for="inlineRadio1">Status</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status"  value="1" <?php echo ( isset($row->status) && $row->status == 1) ? 'checked' : ''; ?> >
                    <label class="form-check-label" for="status"> Active </label>
                    <input class="form-check-input" type="radio" name="status"  value="2" <?php echo ( !empty($row->status) && $row->status == 2 )? 'checked' : ''; ?> >
                    <label class="form-check-label" for="status"> Inactive </label>
                </div>
            </div>
            <div class="col-md-2">
              <label for="Status"></label>
              <div class="form-group" style="margin-top:5px">
                <?php if(isset($row->id)==null){?>
                <input type="submit" name="submit" class="btn btn-success"  value="Save"/>
                <?php }else{?>
                <input type="submit" name="submit" class="btn btn-primary"  value="Update"/>
                <?php }?>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>


<?php if($this->session->flashdata('msg')):?>
  <div class="alert alert-success" id="flash_message">
    <?php echo $this->session->flashdata('msg');?>
  </div>
<?php endif; ?> 

<?php if($this->session->flashdata('msgs')):?>
  <div class="alert alert-danger" id="flash_message">
    <?php echo $this->session->flashdata('msgs');?>
  </div>
<?php endif; ?> 


<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
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
          <?php $i=1;foreach ($result as $key => $row) { ?>
            <tr class="text-center">
              <td><?= $i++?></td>
              <td><?= $row->festival_name?></td>
              <td><?= $row->festival_date?></td>
              <td><?= $row->status == 1 ? 'Active':'Inactive'?></td>
              <td>
                <a class="btn btn-sm btn-info" href="<?= base_url('admin/payroll/emp_festival_bonus/'.$row->id);?>">Edit</a>
                <a class="btn btn-sm btn-danger" href="<?= base_url('admin/payroll/festival_bonus_delete/'.$row->id);?>" onclick="return confirm('Are you sure to Delete!!!')">Delete</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var flashMessage = $('#flash_message');
    
    setTimeout(function() {
      flashMessage.fadeOut('slow'); // Use 'slow' for a gradual fade out
    }, 1000); // Adjust the delay as needed (in milliseconds)
  });
</script>
 
