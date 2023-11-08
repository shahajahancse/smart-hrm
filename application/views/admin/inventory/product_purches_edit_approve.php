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
                <th class="text-center" >Product Name</th>
                <th class="text-center" >Quantity</th>
                <th class="text-center" >Approved Quantity</th>
                <th class="text-center" >Approximate Amount</th>
                <th class="text-center" >Total Approximate Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1;foreach($results as $row){?>
            <?php echo form_open('admin/inventory/product_persial_approved/'.$row->id)?>
            <tr class="text-center">
                <td><?php echo $i++?></td>
                <td><?php echo $row->product_name?></td>
                <td><?php echo $row->quantity?></td>
                <td><input type="number" id="quantity" name="ap_quantity" min="1" style="width:30%"></td>
                <td><span id="aprox_amount"><?php echo $row->approx_amount?></span></td>
                <td><span id="aprox_t_amount"><?php echo $row->approx_t_amount?><span></td>
                <td><a href="<?php echo base_url('admin/inventory/delete_purches_item/'.$row->id)?>">Delete</a></td>
                <input type="hidden" name="id" value="<?php echo $row->id?>" >
            </tr>
            <?php }?>
        </tbody>
      </table>
      <input type="hidden" name="update_a" id="update_a" value="0">
     <?php if(!empty($results)){?>
      <?php if($session['role_id']==1  || $session['role_id']==2) {?>
          <input type="submit" id="submit" class="btn btn-sm btn-success pull-right" style="margin-right: 10px;" value="Approved">
    <?php }}?>
      <?php echo form_close()?>
    </div>
  </div>
</div>

<script>


updateAproxTAmount();
$('#quantity').on('input', updateAproxTAmount);
function updateAproxTAmount() {
  const quantity = parseInt($('#quantity').val());
  const initialAproxAmount = parseFloat($('#aprox_amount').text());
  const calculatedAproxTAmount = quantity * initialAproxAmount;
  $('#aprox_t_amount').text(calculatedAproxTAmount.toFixed(2)); // Display the calculated value
}
</script>

