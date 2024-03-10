<?php 
// dd($row);
  $session = $this->session->userdata('username');
  $eid = $this->uri->segment(4);
  $get_animate = $this->Xin_model->get_content_animate();
  $role_resources_ids = $this->Xin_model->user_role_resource(); 
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
            
            <input type="hidden" name="hidden_id" value="<?php echo isset($row->id)? $row->id:''; ?>">



            <div class="col-md-3" >
              <label for="Status">Device Model</label>
              <select name="device_model" class="form-control" id="model_name">  
                <option value="">Select Model</option>
                <?php  if($row->id != null){
                    if(!empty($models)) { ?>
                        <option value="" >Select</option>
                        <?php foreach($models as $model) {?>
                            <option value="<?php echo $model->id; ?>" <?php echo $model->id == $row->device_model ? 'selected':'' ?> > <?php echo $model->model_name?> </option>
                        <?php  }
                    } else { ?>
                        <option value="" >Select</option>
                  <?php } }?>
              </select>
            </div>

            <div class="col-md-3" >
              <div class="form-group">
                <label for="description">Device Number</label>
                <input class="form-control" placeholder="Device Number" name="device_name_id"  type="text" value="<?php echo isset($row->device_name_id)? $row->device_name_id:''; ?>" > 
              </div>
            </div>
            <div class="col-md-3" >
              <label for="Status">Item Status</label>
              <select name="status" class="form-control"  id="status">  
                <option value="">Select status</option>
                <option value="1" <?php echo (isset($row->status) && $row->status == 1)? 'selected':''; ?> >On Working</option>
                <option value="2" <?php echo (isset($row->status) && $row->status == 2)? 'selected':''; ?> >Stocked   </option>
                <option value="3" <?php echo (isset($row->status) && $row->status == 3)? 'selected':''; ?> >Servicing </option>
                <option value="4" <?php echo (isset($row->status) && $row->status == 4)? 'selected':''; ?> >Destroyed </option>
                <option value="5" <?php echo (isset($row->status) && $row->status == 5)? 'selected':''; ?> >Movement </option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4" >
              <div class="form-group">
                <label for="description">Details</label>
                <textarea class="form-control" placeholder="Details" name="description" type="text" ><?php echo isset($row->description)? $row->description:''; ?></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="description">Comments</label>
                <textarea class="form-control" placeholder="Comments" name="remark" type="text" ><?php echo isset($row->remark)? $row->remark:''; ?></textarea>
              </div>
            </div>
            <div class="col-md-3" id="number" style="display:none">
              <label for="Status">Select Sim Number</label>
              <select name="number" class="form-control">  
                <option value="">Select Number</option>
                <?php $numbers =$this->db->select('*')->get('mobile_numbers')->result(); foreach($numbers as $number){?>
                <option value="<?php echo $number->id?>" <?php echo (isset($row->number) && $row->number == $number->number )? 'selected':''; ?> ><?php echo $number->number?></option>
                <?php }?>
              </select>
            </div>
          </div>

          </div>        
          </div>
          <?php if(isset($row->id)==null){?>
            <input type="submit" name="submit" class="btn btn-md btn-success" style="float:right" value="Add Item"/>
            <?php } else{?>
            <input type="submit" name="submit" class="btn btn-md btn-primary" style="float:right" value="Update Item"/>
            <?php }?>
          <?php echo form_close(); ?></div>
    </div>
  </div>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<script>
  $(document).ready(function(){
    $('#user_id').select2();
    $('#cat_id').select2();


<?php if(isset($row)){?>
var val = $('#cat_id').find(":selected").val();  
var url ='<?php echo base_url('admin/accessories/get_model/')?>'+val+'/'+<?=  isset($row->device_model) ?>;
$.ajax({
  type: "GET",
  url: url,
  data:'cat_id='+val,
  success: function(data){
    $("#model_name").html(data);
  }
});
<?php }?>


$('#cat_id').on('change',function(){
  var val = $('#cat_id').find(":selected").val();  
  var category = $('#cat_id').find(":selected").text();
  $.ajax({
    type: "GET",
    url: "<?php echo base_url('admin/accessories/get_model/')?>"+val,
    data:'cat_id='+val,
    success: function(data){
      $("#model_name").html(data);
    }
  });
  var sim = category.search(/Sim/i); 
  if( sim ==-1){
    $("#number").val(null);
    $("#number").hide();
  }else{
    $("#number").show();
  }
});


<?php 
if(isset($row->status)==1){
?>
  var status = $('#status').find(":selected").val();  
  if(status==1){
  $("#user_id").prop('disabled', false);
  }else{
  $("#user_id").prop('disabled', true);
    $("#user_id").val(null);
  }
 <?php }?>
}); 
</script>
