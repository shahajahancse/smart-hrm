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
    <h3 class="box-title">Requisition List</h3>

    <?php if($session['role_id']==1){ if($status == 1 || $status == 4){?>
      <?php if(!empty($results)){?>
     
    <a class="btn btn-sm btn-success pull-right" href="<?php echo base_url('admin/inventory/purchase_approved/'.$results [0]->requisition_id .'/'.$results [0]->quantity);?>"> Approved </a>
    <a class="btn btn-sm btn-danger pull-right" href="<?php echo base_url('admin/inventory/purchase_rejected/'.$results [0]->requisition_id);?>" style="margin-right: 10px;">Rejected</a>
    <a class="btn btn-sm btn-warning pull-right" style="margin-right: 10px;" href="<?php echo base_url('admin/inventory/purchase_edit_approved/'.$results [0]->requisition_id);?>">Edit & Approved</a>
    <?php }}}?>

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
$(document).ready(function () {
    $('#details').DataTable();
});

</script>

