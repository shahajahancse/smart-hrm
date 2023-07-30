<?php 
$session = $this->session->userdata('username');
// dd($results);
// dd($session['role_id']);
$get_animate = $this->Xin_model->get_content_animate();
?>
<style>
  .table {
    width: 92%;
    margin-bottom: 14px;
}
</style>
            
        <?php if($this->session->flashdata('success')):?>
          <div class="alert alert-success" id="flash_message">
            <?php echo $this->session->flashdata('success');?>
          </div>
        <?php endif; ?> 
        <script>
          $(function() {$("#flash_message").hide(2000);});
        </script>  
        <?php if($this->session->flashdata('warning')):?>
          <div class="alert alert-warning"id="flash_message1">
            <?php echo $this->session->flashdata('warning');?>
            <?php echo ", Name = ".$this->session->flashdata('flash_data')?>
            <?php echo " Available Quantity = ".$this->session->flashdata('flash_data1')?>
          </div>
        <?php endif; ?> 
        <script>
          $(function() {$("#flash_message1").hide(4000);});
        </script> 

<div class="box <?php echo $get_animate;?>" style="margin-top:20px">
  <div class="box-header with-border">
    <h3 class="box-title">Requisition List</h3>

    <?php if($session['role_id']== 1 || $session['role_id']== 4){ if($status == 1 || $status == 4){?>
      <?php if(!empty($results)){?>

         <?php echo form_open('admin/inventory/persial_approved/'.$id)?>
         <?php $i=1;foreach($results as $row){?>
            <input type="hidden" name="r_id[]" value="<?php echo $row->id?>" >
            <input type="hidden" id="quantity" name="qunatity[]" min="1" style="width:20%" value="<?php echo $row->quantity?>">

          <?php }?>
        <?php echo form_close()?>
       <a class="btn btn-sm btn-danger pull-right" href="<?php echo base_url('admin/inventory/requsition_rejected/'.$results [0]->id);?>" style="margin-right: 10px;">Rejected</a>
       <a class="btn btn-sm btn-warning pull-right" style="margin-right: 10px;" href="<?php echo base_url('admin/inventory/requsition_edit_approved/'.$results [0]->id);?>">Edit & Approved</a>
    <?php }}}?>
    <button class="btn btn-sm btn-info pull-right" style="margin-right: 10px;" onclick="history.back()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
    <br/>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive" id="details">
      <input type="hidden" value="1" id="count">
      <table class="datatables-demo table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th class="text-center" >No.</th>
            <th class="text-center" >Category</th>
            <th class="text-center" >Sub Category</th>
            <th class="text-center" >Product Name</th>
            <th class="text-center" >Quantity</th>
            <th class="text-center" > Apv Quantity</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1;foreach($results as $row){?>
            <tr class="text-center">
              <td><?php echo $i++?></td>
              <td><?php echo $row->category_name?></td>
              <td><?php echo $row->sub_cate_name?></td>
              <td><?php echo $row->product_name?></td>
              <td><?php echo $row->quantity?></td>
              <td><?php echo $row->approved_qty?></td>
            </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  /*$(document).ready(function () {
      $('#details').DataTable();
  });*/

</script>

