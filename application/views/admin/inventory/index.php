<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/main.css') ?>">
<?php
// dd($results); 
$session = $this->session->userdata('username');
?>

<style>
    .t1{float: right; border-radius: 4px;border: 1px solid var(--b, #599AE7);background: var(--b, #599AE7); display: inline-flex;height: 41px;
         padding: 17px 91px;justify-content: center;align-items: center;gap: 10px;flex-shrink: 0;
         color: #FFF;
        text-align: center;
        font-family: Roboto;
        font-size: 15px;
        font-style: normal;
        font-weight: 400;
        line-height: 22.5px;
        text-transform: uppercase;
        }
       .t2 {float: left;color: #000;font-family: Roboto;font-size: 15px;font-style: normal;font-weight: 400;line-height: 22.5px;
    text-transform: capitalize;
    padding-left:5px;
  }
  .te{
color: var(--white, #FFF);
font-family: Roboto;
font-size: 18px;
font-style: normal;
font-weight: 600;
line-height: 100%;
  }

</style>

<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">

<?php $get_animate = $this->Xin_model->get_content_animate();?>


<div class="row">
  <div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="heading">Active Days</div>
        <div class="heading2"><?= 0 ?></div>
    </div>

    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="heading">Late Days</div>
        <div class="heading2"><?= 0  ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
        <div class="heading">Absent</div>
        <div class="heading2"><?=  0 ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
        <div class="heading">Taking Leave</div>
        <div class="heading2"><?= 0 ?></div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12">
        <span class="t2" style="font-family: sans-serif;" >If you need stationery items (Pen, Paper, Diary, etc.) or devices to work, feel free to fill out the requisition form.</span>
        <span class="t1 btn" id="requisition">requisition</span>
    </div>
    <div class="row">
        <div class="col-md-2"style=" display: inline-flex;padding: 9px 46px;justify-content: center;gap: 10px;">
            <h4 >Using List</h3>
        </div>
        <div class="col-md-5"style=" width:18.666667%;  text-align:left; display: inline-flex;padding: 5px 46px;justify-content: center;align-items: center;gap: 10px;">
              <h4 class="btn te" style="border-radius: 2px;
               background: var(--g, #2DCA8C);">Requsiton information</h4>
        </div>
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
                <td><input type="number" id="item_qty" name="quantity"></td>
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
  // Assuming you have the base URL defined somewhere
  var base_url = "http://localhost/smart-hrm/";

  // Retrieve the <span> element by its ID
  var spanElement = document.getElementById("requisition");

  // Add a click event listener to the <span> element
  spanElement.addEventListener("click", function() {
    // Redirect the user to the desired URL
    window.location.href = base_url + "/create";
  });
</script>








