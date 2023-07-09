<?php 
$session = $this->session->userdata('username');
// dd($results);
$get_animate = $this->Xin_model->get_content_animate();
?>
<style>
  .table {
    width: 92%;
    margin-bottom: 14px;
}
</style>
<div class="box <?php echo $get_animate;?>" style="margin-top:20px">
  <div class="box-header with-border">
    <h3 class="box-title"> Purches product details List</h3>
    <button class="btn btn-sm btn-info pull-right" style="margin-right: 10px;" onclick="history.back()"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
    <br/>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive" >
    <input type="hidden" value="1" id="count">
      <table class="datatables-demo table table-striped table-bordered" id="" style="width:100%">
        <thead>
          <tr>
              <th class="text-center" >No.</th>
                <!-- <th class="text-center" >Supplier</th>
                <th class="text-center" >Company</th> -->
                <th class="text-center" >Product Name</th>
                <th class="text-center" >Quantity</th>
          </tr>
        </thead>
        <?php echo form_open('admin/inventory/product_persial_approved/'.$purches_id)?>
        <tbody>
            <?php $i=1;foreach($results as $row){?>
            <tr class="text-center">
                <td><?php echo $i++?></td>
                <!-- <td><?php echo $row->name?></td>
                <td><?php echo $row->company?></td> -->
                <td><?php echo $row->product_name?></td>
                <td><input type="number" id="quantity" name="qunatity[]" min="1" style="width:20%" value="<?php echo $row->quantity?>"></td>
                <!-- <?php if($session['role_id']!=3) {?> -->
                <td><a href="<?php echo base_url('admin/inventory/delete_purches_item/'.$row->id.'/'.$purches_id)?>">Delete</a></td>
                <!-- <?php }?> -->
                <input type="hidden" name="r_id[]" value="<?php echo $row->id?>" >

            </tr>
            <?php }?>
        </tbody>
      </table>
      <input type="hidden" name="update_a" id="update_a" value="0">
      <!-- <a class="btn btn-sm btn-success pull-right" href="<?php echo base_url('admin/inventory/persial_approved/'.$requisition_id);?>">Approved</a> -->
      <?php if(!empty($results)){?>
        <?php if($session['role_id']==1) {?>
          <input type="button"  class="btn btn-sm btn-success pull-right" style="margin-right: 10px;" onclick="upsub()" value="update">

          <input type="submit" id="submit" class="btn btn-sm btn-success pull-right" style="margin-right: 10px;" value="Approved">
         
      <?php }else{?>
        <input type="submit" id="submit" class="btn btn-sm btn-success pull-right" style="margin-right: 10px; display: none;" value="Approved">
        <input  type="button" id="submit"   class="btn btn-sm btn-success pull-right" onclick="upsub()" style="margin-right: 10px;" value="update">
    <?php }}?>
      <?php echo form_close()?>
    </div>
  </div>
</div>

<script>
// $(document).ready(function () {
//     $('#details').DataTable();
// });

function upsub(){
  document.getElementById('update_a').value = 1;
  document.getElementById('submit').click();
}

</script>

