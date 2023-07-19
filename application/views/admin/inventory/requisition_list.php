      <table class="datatables-demo table table-striped table-bordered" id="purchase_table" style="width:100%">

        <thead>
          <tr>
            <th class="text-left" style="">No.</th>
            <th class="text-left" style="">Item Name</th>
            <th class="text-left" >Request Date</th>
            <th class="text-left" >Category</th>
            <th class="text-left" >Request Qty</th>
            <th class="text-left" >Approved Qty</th>
            <th class="text-left" >Status</th>
            <th class="text-left" style="">Action</th>
          </tr>
        </thead>

        <tbody>

          <?php foreach ($products as $key => $row) { 
            $status = '';
            if ($row->status == 1) {
              $status = 'Pending';
            } else if ($row->status == 2) {
              $status = 'Approved';
            } else if ($row->status == 3) {
              $status = 'Hand Over';
            } else if ($row->status == 4) {
              $status = 'Rejected';
            } else if ($row->status == 5) {
              $status = 'First Approved';
            }
            ?>
            <tr>
              <td><?= $key + 1 ?></td>
              <td><?= $row->product_name ?></td>
              <td><?= date("d-m-Y", strtotime($row->created_at)) ?></td>
              <td><?= $row->category_name ?></td>
              <td><?= $row->quantity ?></td>
              <td><?= $row->approved_qty ?></td>
              <td><?= $status ?></td>
              <td>
                <?php if($row->status == 1){?> 
                  <div class="dropdown" >
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action
                    </button>
                    <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                      <a class='req_id' data-id="<?= $row->id ?>" data-p="<?= $row->product_name ?>" data-c="<?= $row->category_name ?>" data-q="<?= $row->quantity ?>" data-toggle="modal" data-target="#requisition_edit" style="padding-left:5px; cursor: pointer">Edit</a><br>
                      <a style="padding-left:5px;" href="<?= base_url('admin/inventory/delete_requsiton/'.$row->id);?>">Delete</a>
                    </div>
                  </div>
                <?php } else { echo "..."; } ?>
              </td>
            </tr>
          <?php }?>
          <!-- user equipment list   -->




        </tbody>


      </table>



      <div class="modal fade" id="requisition_edit" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content -->
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
    $('.req_id').on('click', function(e) {
      val = $(this).attr("data-id");
      pro = $(this).attr("data-p");
      cat = $(this).attr("data-c");
      qty = $(this).attr("data-q");
      $('#item').text(pro);
      $('#item_cat').text(cat);
      $('#item_qty').val(qty);
      $('#item_hid').val(val);
    })

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