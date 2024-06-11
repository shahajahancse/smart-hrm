<style>
  .using {
    display: inline-flex;
    padding: 4.5px 14.3px 5.5px 9px;
    align-items: center;
    gap: 9px;
    border-radius: 50px;
    border: 1px solid #CCC;
    background: #FFF;
   
}
</style>



<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="card <?= $get_animate?>" style="margin-left:15px;margin-top:15px;margin-right: 15px;border-radius: 0px;">
  <div class="card-body">
    <table class="datatables-demo table table-striped table-bordered" id="table_id" style="width: 100%;background: white;margin-left: 0px;">
      <thead>
        <tr>
          <th class="text-center" style="width: 50px;">No.</th>
          <th class="text-center">Item Name</th>
          <th class="text-center">Req Date</th>
          <th class="text-center">Category</th>
          <th class="text-center">Req Qty</th>
          <th class="text-center">Approved Qty</th>
          <th class="text-center">Remark</th>
          <th class="text-center">Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $key => $row) {
          
          
          ?>
          <tr>
            <td class="text-center"><?= $key + 1 ?></td>
            <td class="text-center"><?= $row->product_name ?></td>
            <td class="text-center"><?= date("d M Y", strtotime($row->created_at))?></td>
            <td class="text-center"><?= $row->category_name ?></td>
            <td class="text-center"><?= $row->quantity ?></td>
            <td class="text-center"><?= $row->approved_qty ?></td>
            <td class="text-center"><?= $row->note ?></td>
            <td class="text-center">
              <span class="using">
                <?= $row->status==1 ?"<i class='fa fa-dot-circle-o' style='color:#ffda00'>Pending</i> ":($row->status==2?"<i class='fa fa-dot-circle-o' style='color:#6ebe09'></i>Approved ":($row->status==3?"<i class='fa fa-dot-circle-o' style='color:#09bea9'></i>  Handover":($row->status==4?"<i class='fa fa-dot-circle-o' style='color:#de0000'></i> Rejected":"First Step Approved")))?>
              </span>
            </td>
            <td class="text-center">
              <?php if($row->status == 1){?> 
                <div class="dropdown" >
                  <i class="fa fa-ellipsis-v dropdown-toggle btn" style="border:none; background: transparent;box-shadow:none !important" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                  <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                    <a class='req_id text-info' data-id="<?= $row->prd_id ?>" data-p="<?= $row->product_name ?>" data-c="<?= $row->category_name ?>" data-q="<?= $row->quantity ?>" data-toggle="modal" data-target="#requisition_edit" style="padding-left:5px; cursor: pointer"><b>Edit</b></a><br>
                    <a class="text-danger"style="padding-left:5px;" href="<?= base_url('admin/inventory/delete_requsiton/'.$row->prd_id);?>"><b>Delete</b></a>
                  </div>
                </div>
              <?php } else { echo ""; } ?>
            </td>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
</div>


<div class="modal fade" id="requisition_edit" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Requsiton</h4>
      </div>
      <div class="modal-body">      
        <table class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th class="text-left" style="">Item Name</th>
              <th class="text-left" >Category</th>
              <th class="text-left" >Request Qty</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <input type="hidden" id="item_hid" name="requisition_id">
                <td id="item"></td>
                <td id="item_cat"></td>
                <td><input type="text" id="item_qty" name="quantity"></td>
              </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button id="submit" type="submit" class="btn btn-success">Update</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table_id').DataTable();
    $('.req_id').on('click', function(e) {
      val = $(this).attr("data-id");
      pro = $(this).attr("data-p");
      cat = $(this).attr("data-c");
      qty = $(this).attr("data-q");
      $('#item').text(pro);
      $('#item_cat').text(cat);
      $('#item_qty').val(qty);
      $('#item_hid').val(val);
    });

    $('#submit').on('click', function(){
      qty     = $('#item_qty').val();
      item_id = $('#item_hid').val();
      $.ajax({
        type: "POST",
        data:{'quantity':qty},
        url: "<?php echo base_url('admin/inventory/requisition_edit/');?>" + item_id,
        success: function(response)
        {
          $('#requisition_edit').modal('hide');
          window.location.href = base_url;
        }
      });
    });
  });
</script>