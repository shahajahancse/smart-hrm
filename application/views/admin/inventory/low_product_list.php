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
<div class="box <?php echo $get_animate;?>" style="margin-top:20px">
  <div class="box-header with-border">
    <h3 class="box-title">Low Products List</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive" >
    <input type="hidden" value="1" id="count">
      <table class="datatables-demo table table-striped table-bordered" id="table_data" style="width:100%">
        <thead>
          <tr>
              <th class="text-center" >No.</th>
                <th class="text-center" >Product Name</th>
                <th class="text-center" >Quantity</th>
          </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach($results as $row){?>
            <tr class="text-center">
                <td><?php echo $i++?></td>
                <td><?php echo $row->product_name?></td>
                <td><?php echo $row->quantity?></td>
            </tr>
            <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    $('#table_data').DataTable();
});

</script>

