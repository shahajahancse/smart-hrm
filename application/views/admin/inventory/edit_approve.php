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
    <h3 class="box-title">Requisition List</h3>
    <button class="btn btn-sm btn-info pull-right" style="margin-right: 10px;" onclick="history.back()"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
    <br/>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
    <!-- <input type="text" value="1" id="count"> -->
      <table class="table table-striped table-bordered" id="" style="width:100%">
        <thead>
          <tr>
              <th class="text-center" >No.</th>
                <th class="text-center" >Category</th>
                <th class="text-center" >Sub Category</th>
                <th class="text-center" >Product Name</th>
                <th class="text-center" >Request Quantity</th>
                <th class="text-center" >Approved Quantity</th>
                <th class="text-center" >Stock Quantity</th>
          </tr>
        </thead>
        <?php echo form_open('admin/inventory/persial_approved/'.$requisition_id)?>

        <tbody>
          
            <?php  $i=1;foreach($results as $row){?>
            <tr class="text-center">
                <td><?php echo $i++?></td>
                <td><?php echo $row->category_name?></td>
                <td><?php echo $row->sub_cate_name?></td>
                <td><?php echo $row->product_name?></td>
                <td><?php echo $row->quantity?></td>
                <td><input type="number" id="quantity" name="qunatity[]" min="1" style="width:40%" value="<?php echo $row->quantity?>"></td>
                <td><?php echo $row->p_qty?></td>
                <td><a href="<?php echo base_url('admin/inventory/delete_requsiton_item/'.$row->id.'/')?>">Delete</a></td>
                <!-- <input type="hidden" name="r_id[]" value="<?php echo $row->id?>"> -->

            </tr>
            <?php }?>
           
        </tbody>
      </table>
      <?php if(!empty($results)){?>
      <?php if($session['role_id']!=3) {?>
      <input type="submit" class="btn btn-sm btn-success pull-right" style="margin-right: 10px;" value="Approved">
      <?php } }?>

        <?php echo form_close()?>
    </div>
  </div>
</div>