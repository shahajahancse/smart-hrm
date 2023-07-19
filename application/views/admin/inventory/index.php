<?php
// dd($results); 
$session = $this->session->userdata('username');
?>

<style>
.btn.active {
  background-color: #2DCA8C;
  color: white;
}

.using {
    display: inline-flex;
    padding: 4.5px 14.3px 5.5px 9px;
    align-items: center;
    gap: 9px;
    border-radius: 50px;
    border: 1px solid #CCC;
    background: #FFF;
}

.return {
    display: inline-flex;
    padding: 4.5px 14.3px 5.5px 9px;
    align-items: center;
    gap: 9px;
    border-radius: 50px;
    border: 1px solid #CCC;
    background: #FFF;
}

</style>

<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">

<?php $get_animate = $this->Xin_model->get_content_animate();?>


<div class="row">
  <div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="h4">Total Using Items</div>
        <div class="h4"><?= 0 ?></div>
    </div>

    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="h4">Total Requisition</div>
        <div class="heading2"><?= 0  ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
        <div class="h4">Return Items</div>
        <div class="h4"><?=  0 ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
        <div class="h4">Pending Items</div>
        <div class="h4"><?= 0 ?></div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <span class="t2" >If you need stationery items (Pen, Paper, Diary, etc.) or devices to work, feel free to fill out the requisition form.</span>
    <a href="<?= base_url('admin/inventory/create') ?>" class="btn btn-md btn-primary" style="float:right">Requisition</a>
    
  </div>

  <div class="col-md-4" style="display:flex;">
    <a href="<?= base_url('admin/inventory') ?>" class="btn" id="listButton">Using List</a>
    <a href="<?= base_url('admin/inventory') ?>" class="btn" style="margin-left:10px;" id="infoButton">Request Information</a>
  </div>

  <div class="box-body">
    <div class="box-datatable" >
      <?php if($this->session->flashdata('success')):?>
        <div class="alert alert-success" id="flash_message">
          <?php echo $this->session->flashdata('success');?>
        </div>
      <?php endif; ?> 

      <!-- <input type="hidden" value="1" id="count"> -->
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
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<!-- The Modal -->
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
    })
  });
</script>


<script>
    // Get references to the buttons
    var listButton = document.getElementById("listButton");
    var infoButton = document.getElementById("infoButton");

    // Function to handle button click event
    function handleClick(event) {
        // Prevent the default behavior of the anchor tag
        event.preventDefault();

        // Remove the "active" class from both buttons
        listButton.classList.remove("active");
        infoButton.classList.remove("active");

        // Add the "active" class to the clicked button
        event.target.classList.add("active");

        // Store the ID of the clicked button in Local Storage
        localStorage.setItem("activeButtonId", event.target.id);
    }

    // Add event listeners to the buttons
    listButton.addEventListener("click", handleClick);
    infoButton.addEventListener("click", handleClick);

    // Check Local Storage for an active button ID and set it as active on page load
    document.addEventListener("DOMContentLoaded", function() {
        var activeButtonId = localStorage.getItem("activeButtonId");
        if (activeButtonId) {
            var activeButton = document.getElementById(activeButtonId);
            if (activeButton) {
                activeButton.classList.add("active");
            }
        }
    });
</script>






