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
      <table class="datatables-demo table table-striped table-bordered" id="suplyer" style="width:100%">
        <thead>
          <tr>
              <th class="text-center" >No.</th>
                <th class="text-center" >Name</th>
                <th class="text-center" >Company</th>
                <th class="text-center" >Phone</th>
                <th class="text-center" >Address</th>
          </tr>
        </thead>
        <tbody>
            <?php $i=1;foreach($results as $row){?>
            <tr class="text-center">
                <td><?php echo $i++?></td>
                <td><?php echo $row->name?></td>
                <td><?php echo $row->company?></td>
                <td><?php echo $row->phone?></td>
                <td><?php echo $row->address?></td>
            </tr>
            <?php }?>
        </tbody>
      </table>

    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    $('#suplyer').DataTable();
});


</script>

