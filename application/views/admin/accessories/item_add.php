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
    <?php echo validation_errors(); ?>
    
<?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
    <?php echo $this->session->flashdata('success');?>
    </div>
<?php endif; ?> 

<?php if($this->session->flashdata('warning')):?>
    <div class="alert alert-warning">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo $this->session->flashdata('warning');?>
    </div>
<?php endif; ?> 

    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('id' => 'unit_insert','enctype'=>'multipart/form-data', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/accessories/item_add', $attributes, $hidden);?>
          <div class="row">

            <div class="col-md-3">
              <label for="Status">Category Name</label>
              <select name="cat_id" class="form-control" required>  
                <option value="">Select Category</option>
                <?php foreach ($categories as $key => $category) {?>
                <option value="<?php echo $category->id ?>" <?php echo (!empty($row->cat_id) && $row->cat_id == $category->id)? 'selected':''; ?> ><?php echo $category->cat_name ?></option>
                <?php }?>
              </select>
            </div>
            
            <input type="hidden" name="hidden_id" value="<?php echo !empty($row->id)? $row->id:''; ?>">

            <div class="col-md-2">
              <div class="form-group">
                <label for="description">Device Number</label>
                <input class="form-control" placeholder="Device Number" name="device_name_id" type="text" value="<?php echo !empty($row->device_name_id)? $row->device_name_id:''; ?>" required> 
              </div>
            </div>

            <div class="col-md-2">
              <label for="Status">Device Model</label>
              <select name="device_model" class="form-control" required>  
                <option value="">Select Model</option>
                <?php foreach ($models as $key => $model) {?>
                <option value="<?php echo $model->id ?>" <?php echo (!empty($row->device_model) && $row->device_model == $model->id)? 'selected':''; ?> ><?php echo $model->model_name?></option>
                <?php }?>
              </select>
            </div>
            
            <div class="col-md-3">
              <div class="form-group">
                <label for="description">Image</label>
                <input class="form-control" name="image" type="file" value="<?php echo !empty($row->image)? $row->image:''; ?>">
              </div>
            </div>     

            <div class="col-md-2">
              <label for="Status">Item Status</label>
              <select name="status" class="form-control" id="status_id" required>  
                <option value="">Select status</option>
                <option value="1" <?php echo (isset($row->status) && $row->status == 1)? 'selected':''; ?> >On Working</option>
                <option value="2" <?php echo (isset($row->status) && $row->status == 2)? 'selected':''; ?> >Stocked   </option>
                <option value="3" <?php echo (isset($row->status) && $row->status == 3)? 'selected':''; ?> >Servicing </option>
                <option value="4" <?php echo (isset($row->status) && $row->status == 4)? 'selected':''; ?> >Destroyed </option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="description">Dtails</label>
                <textarea class="form-control" placeholder="Details" name="description" type="text" required><?php echo !empty($row->description)? $row->description:''; ?></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="description">Coments</label>
                <textarea class="form-control" placeholder="Coments" name="remark" type="text" required><?php echo !empty($row->remark)? $row->remark:''; ?></textarea>
              </div>
            </div>
            
            <div class="col-md-4" id="user_id" style="display:none">
              <label for="Status">User</label>
              <select name="user_id" class="form-control" id="user_id">  
                <option value="">Select User</option>
                <?php foreach ($users as $key => $user) {?>
                <option value="<?php echo $user->user_id ?>" <?php echo (!empty($row->cat_id) && $row->cat_id == $user->id)? 'selected':''; ?> ><?php echo $user->first_name.' '.$user->last_name ?></option>
                <?php }?>
              </select>
            </div>   
          </div>
          <input type="submit" name="submit" class="btn btn-success btn-sm" value="Add Item" style="float:right"/>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>


<script>

  $('#status_id').on('change',function() {
   var status = $('#status_id').find(":selected").val();  
  //  alert(status);
  if(status ==1){
    $('#user_id').show(500);
  }
  else{
    $('#user_id').hide(500);
  }

  });

</script>
