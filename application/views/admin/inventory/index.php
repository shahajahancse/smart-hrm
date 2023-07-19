<!-- <link rel="stylesheet" href="< ?= base_url('skin/hrsale_assets/css/main.css') ?>"> -->
<?php
// dd($products); 
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
        <span class="btn btn-md btn-primary" style="float:right" id="requisition">Requisition</span>
    </div>

<div class="col-md-4" style="display:flex;">
    <a href="#" class="btn" id="listButton">Using List</a>
    <a href="#" class="btn" style="margin-left:10px;" id="infoButton">Request Information</a>
</div>



 

<div class="box-body">
    <div class="box-datatable" >
    <!-- <input type="hidden" value="1" id="count"> -->
      <table class="table table-striped table-bordered" id="purchase_table" style="width:100%">
        <thead>
          <tr>
              <?php if($user_role_id==1 || $user_role_id== 2 || $user_role_id== 4){?>
                <th class="text-center">No.</th>
                <th class="text-center">Requisition By</th>
                <th class="text-center">Status</th>
                <th class="text-center">Request Date</th>
                <th class="text-center">Action</th>
              <?php }?> 
              <?php if($user_role_id==3){?>
                <th class="text-center">Sl.</th>
                <th class="text-center">Equipment Name</th>
                <th class="text-center">MHL Code</th>
                <th class="text-center">Provide Date</th>
                <th class="text-center">Using Days</th>
                <th class="text-center">Provided By</th>
                <th class="text-center">Status</th>
              <?php }?> 
          </tr>
        </thead>
        <tbody>
          <?php if($user_role_id==1 || $user_role_id == 4 || $user_role_id == 2){?>
          <?php  foreach ($products as $key => $rows) { ?>
            <tr>
              <td class="text-center"><?php echo ($key+1)."."; ?></td>
              <td class="text-center"><?php echo $rows->first_name." ".$rows->last_name; ?></td>
              <td class="text-center">
                <?php echo $rows->status == 5 ? "<span class='badge' style='background-color:#28a745'><b>First Step Approved</b></span>" : ($rows->status == 1 ? "<span class='badge' style='background-color:#ffc107'><b>Pending</b></span>" : ($rows->status == 2 ? "<span class='badge' style='background-color:#28a745'><b>Approved</b></span>" : ($rows->status == 3 ? "<span class='badge' style='background-color:#087a58'><b>Handover</b></span>" : "<span class='badge' style='background-color:#d56666'><b>Rejected</b></span>"))); ?>
              </td>
              <td class="text-center"><?php echo date('d-m-Y',strtotime($rows->created_at)); ?></td><td class="text-center">
                <div class="dropdown" >
                  <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                  </button>
                  <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                    <?php if($rows->status==1 || $rows->status==5){?> 
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Edit</a><br>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/delete_requsiton/'.$rows->id);?>">Delete</a> <br>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Approved</a><br>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_rejected/'.$rows->id);?>">Reject</a>
                      <?php } if($rows->status== 2){?>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/hand_over/'.$rows->id);?>">Delivered</a> <br>
                      <?php } if($rows->status== 3){?>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                      <?php } if($rows->status== 4){?>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                      <?php if($session['role_id']== 1 || $session['role_id']== 2 ){?>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Edit</a><br>
                        <a style="padding-left:5px;" href="<?= base_url('admin/inventory/delete_requsiton/'.$rows->id);?>">Delete</a> <br>
                    <?php }?> 
                  </div>
                </div>
              </td>
            </tr>
          <?php }}}?>
                        
            <?php  if($user_role_id==3){ foreach ($products as $key => $rows){ ?>
              <tr>  
                <td class="text-center"><?php echo ($key+1)."."; ?></td>
                <td class="text-center"><?php echo $rows->model_name ?></td>
                <td class="text-center"><?php echo $rows->device_name_id ?></td>
                <td class="text-center"><?php echo ($key+1)."."; ?></td>
                <td class="text-center"><?php echo ($key+1)."."; ?></td>
                <td class="text-center"><?php echo $rows->status ; ?></td>
                <td class="text-center">
                    <?php echo ($rows->status == 1 ? "<span class='using'><i class='fa fa-dot-circle-o' style='color:green'></i>Using</span>" : "<span class='return'><i class='fa fa-dot-circle-o' style='color:#FF715B'></i>Return</span>"  );  ?>
                </td>
              </tr>
            <?php  }}?>
        </tbody>
      </table>
    </div>
</div>

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
