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
                <th class="text-center" >Request Qty</th>
                <th class="text-center" >App. Qty</th>
                <th class="text-center" >Stock Qty</th>
                <th class="text-center" >Comment</th>
                <th class="text-center" >Action</th>
          </tr>
        </thead>
        <?php echo form_open('admin/inventory/persial_approved/'.$row->id)?>

        <tbody>
            <tr class="text-center">
                <td><?php echo 1; ?></td>
                <td><?php echo $row->category_name?></td>
                <td><?php echo $row->sub_cate_name?></td>
                <td><?php echo $row->product_name?></td>
                <td><?php echo $row->quantity?></td>
                <td><input type="number" id="quantity" onkeyup="check_qty()" name="approved_qty" min="1" style="width:100px" value="<?php echo $row->quantity?>"></td>
                <td><?php echo $row->p_qty?></td>
                <td style="cursor: pointer; color: #310bff" title="<?= $row->note ?>" ><?= substr($row->note, 0,10) ?></td>

                <td><a class="btn btn-sm btn-danger" href="<?php echo base_url('admin/inventory/delete_requsiton_item/'.$row->id.'/'.$row->id)?>">Delete</a></td>
                <input type="hidden" name="r_id" value="<?php echo $row->id?>">
                <input type="hidden" name="stock_quantity" value="<?php echo $row->p_qty?>">
                <input type="hidden" name="p_permission" value="<?php echo $row->p_permission?>">
            </tr>
        </tbody>
      </table>
      <?php if(!empty($row) && $session['role_id']!=3 ){?>
      <input type="submit" class="btn btn-mini btn-success pull-right" id="submit" style="margin-right: 10px;" value="Approved">
      <?php } ?>

        <?php echo form_close()?>
    </div>
  </div>
</div>

<script>
  function check_qty() {
    p_qty = parseFloat("<?= $row->p_qty ?>");
    req_qty = parseFloat(document.getElementById('quantity').value);
    sub_id = document.getElementById('submit');
    if (p_qty >= req_qty) {
      sub_id.removeAttribute("disabled");
    } else {
      sub_id.setAttribute("disabled", true);
    }
  }
  check_qty();
</script>