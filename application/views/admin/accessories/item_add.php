<?php 
// dd($row);
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
<?php $user_info   = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body" >
    
<?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success" style="width:250px">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
    <?php echo $this->session->flashdata('success');?>
    </div>
<?php endif; ?> 


    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('id' => 'unit_insert','enctype'=>'multipart/categoryform-data', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/accessories/item_add', $attributes, $hidden);?>
          <div class="row">

            <div class="col-md-3">
              <label for="Status">Category Name</label>
              <select name="cat_id" id="cat_id" class="form-control" required >  
                <option value="">Select Category</option>
                <?php foreach ($categories as $key => $category) {?>
                <option value="<?php echo $category->id ?>" <?php echo (isset($row->cat_id) && $row->cat_id == $category->id)? 'selected':''; ?> ><?php echo $category->cat_name ?></option>
                <?php }?>
              </select>
            </div>
            
            <input type="hidden" name="hidden_id" value="<?php echo isset($row->a_id)? $row->a_id:''; ?>">

            <div class="col-md-2" >
              <div class="form-group">
                <label for="description">Device Number</label>
                <input class="form-control" placeholder="Device Number" name="device_name_id"  type="text" value="<?php echo isset($row->device_name_id)? $row->device_name_id:''; ?>" > 
              </div>
            </div>

            <div class="col-md-2" >
              <label for="Status">Device Model</label>
              <select name="device_model" class="form-control" id="model_name">  
                <option value="">Select Model</option>
              </select>
            </div>
            
            <div class="col-md-3" >
              <div class="form-group">
                <label for="description">Image</label>
                <input class="form-control" name="image" type="file" value="<?php echo (isset($row->image))? $row->image:''; ?>">
              </div>
            </div>     

            <div class="col-md-2" >
              <label for="Status">Item Status</label>
              <select name="status" class="form-control"  id="status">  
                <option value="">Select status</option>
                <option value="1" <?php echo (isset($row->status) && $row->status == 1)? 'selected':''; ?> >On Working</option>
                <option value="2" <?php echo (isset($row->status) && $row->status == 2)? 'selected':''; ?> >Stocked   </option>
                <option value="3" <?php echo (isset($row->status) && $row->status == 3)? 'selected':''; ?> >Servicing </option>
                <option value="4" <?php echo (isset($row->status) && $row->status == 4)? 'selected':''; ?> >Destroyed </option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4" >
              <div class="form-group">
                <label for="description">Dtails</label>
                <textarea class="form-control" placeholder="Details" name="description" type="text" ><?php echo isset($row->description)? $row->description:''; ?></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="description">Coments</label>
                <textarea class="form-control" placeholder="Coments" name="remark" type="text" ><?php echo isset($row->remark)? $row->remark:''; ?></textarea>
              </div>
            </div>
            
            <div class="col-md-4" >
              <label for="Status">User</label>
              <select name="user_id" id="user_id" class="form-control" disabled>  
                <option value="">Select User</option>
                <?php foreach ($users as $key => $user) {?>
                <option value="<?php echo $user->user_id ?>" <?php echo (isset($row->user_id) && $row->user_id == $user->user_id)? 'selected':''; ?> ><?php echo $user->first_name.' '.$user->last_name ?></option>
                <?php }?>
              </select>
            </div>   
          </div>
          <div class="row">

            <div class="col-md-2"  >
              <label for="Status">Use Sim Number</label>
              <select name="use_number" id="use_number" class="form-control" disabled>  
                <option value="" disabled selected>Select</option>
                <option value="1" <?php echo (isset($row->use_number) && $row->use_number == 1)? 'selected':''; ?> >Yes</option>
                <option value="2" <?php echo (isset($row->use_number) && $row->use_number == 2)? 'selected':''; ?> >No</option>
              </select>
            </div>


            <div class="col-md-3" >
              <label for="Status">Select Sim Number</label>
              <select name="number" id="number"  class="form-control" disabled>  
                <option value="">Select Number</option>
                <?php foreach($numbers as $number){?>
                <option value="<?php echo $number->id?>" <?php echo (isset($row->number) && $row->number == $number->number )? 'selected':''; ?> ><?php echo $number->number?></option>
                <?php }?>
              </select>
            </div>
          </div>
          </div>        

          </div>
          
          <?php if(isset($row->id)==null){?>
                <input type="submit" name="submit" class="btn btn-success" style="float:right" value="Add Item"/>
                <?php }else{?>
                <input type="submit" name="submit" class="btn btn-primary" style="float:right" value="Update Item"/>
                <?php }?>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<script>
  
	// function category(val) {
  //       var category = $('#cat_id').find(":selected").text();  

  //   // var sim = category.search(/sim/i); 

  //    alert(category);return;

	// }

$('#cat_id').on('change',function(){
  var val = $('#cat_id').find(":selected").val();  
  var category = $('#cat_id').find(":selected").text();  
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('admin/accessories/get_model')?>",
      data:'cat_id='+val,
      success: function(data){
      $("#model_name").html(data);
      }
    });
  var mobile = category.search(/Mobile/i); 
  var sim = category.search(/Sim/i); 

    if(mobile !== -1){
    $("#use_number").prop('disabled', false);
    $('#use_number').on('change',function(){
       var status = $('#use_number').find(":selected").val();  
      if(status==1){
       $("#number").prop('disabled', false);
      }else{
       $("#number").prop('disabled', true);
      }
    });
  }

  if(sim !== -1){
    $("#use_number").prop('disabled', false);
    $('#use_number').on('change',function(){
       var status = $('#use_number').find(":selected").val();  
      if(status==1){
       $("#number").prop('disabled', false);
      }else{
       $("#number").prop('disabled', true);
      }
    });
  }
});
// able/disable user name list according to item status [ 1 == able , else disable ]
$('#status').on('change',function(){
  var status = $('#status').find(":selected").val();  
  if(status==1){
  $("#user_id").prop('disabled', false);
  // $("#user_id").prop('required', true);
  }else{
  $("#user_id").prop('disabled', true);
  }
});

// onChange="category(this.value);"
</script>
