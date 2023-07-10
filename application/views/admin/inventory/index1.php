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
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/main.css') ?>">

<div class="row">
    <div class="col-md-12">
        <span class="t2" >If you need stationery items (Pen, Paper, Diary, etc.) or devices to work, feel free to fill out the requisition form.</span>
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
    <!-- <input type="hidden" value="1" id="count"> -->
      <table class="datatables-demo table table-striped table-bordered" id="purchase_table" style="width:100%">
        <thead>
          <tr>
              <?php if($user_role_id==1 || $user_role_id== 2 || $user_role_id== 4){?>
              <th class="text-center" style="width:20px;">No.</th>
                <th class="text-center"style="width: 34%;">Requisition By</th>
                <th class="text-center" style="width:20px;">Status</th>
                <th class="text-center" style="width:20px;">Request Date</th>
                <th class="text-center" style="width:50px;">Action</th>
              <?php }?> 
              <?php if($user_role_id==3){?>
              <th class="text-center" style="width:20px;">No.</th>
              <th class="text-center" style="width: 34%;">Requisition By</th>
                <!-- <th class="text-center" >Category</th>
                <th class="text-center" >Sub Category</th>
                <th class="text-center" >Product Name</th> -->
                <!-- <th class="text-center" >Quantity</th>
                <th class="text-center" >Approved Quantity</th> -->
                <th class="text-center" >Status</th>
                <th class="text-center" >Request Date</th>
                <!-- <th class="text-center" ></th> -->
                <th class="text-center" style="width:50px;">Action</th>
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

                <td class="text-center"><?php echo date('d-m-Y',strtotime($rows->created_at)); ?></td>
                <!-- <td class="text-center"> <a class="btn btn-sm btn-info" href="<?= base_url('admin/inventory/purchase_details/'.$rows->id);?>"><i class="fa fa-info" aria-hidden="true"></i> Details</td> -->
                <td class="text-center">
                        <div class="dropdown" >
                      <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                    
                      <?php if($rows->status==1 || $rows->status==5){?> 
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Edit</a><br>
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/delete_requsiton/'.$rows->id);?>">Delete</a> <br>
                          <a style="padding-left:5px; " href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Approved</a><br>
                          <a style="padding-left:5px; " href="<?= base_url('admin/inventory/requsition_rejected/'.$rows->id);?>">Reject</a>
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
              </td>
             
                <?php } } }?>
                        
              <?php  if($user_role_id==3){ 
                foreach ($products as $key => $rows){  
              ?>
                <td class="text-center"><?php echo ($key+1)."."; ?></td>
                <td class="text-center"><?php echo $rows->first_name." ".$rows->last_name; ?></td>
             
               
                
                <td class="text-center">
                    <?php echo $rows->status == 5 ? "<span class='badge' style='background-color:#28a745'>  <b>First Step Approved</b></span>" : ($rows->status == 1 ? "<span class='badge' style='background-color:#ffc107'><b>Pending</b></span>" : ($rows->status == 2 ? "<span class='badge' style='background-color:#28a745'><b>Approved</b></span>" : ($rows->status == 3 ? "<span class='badge' style='background-color:#28a745'><b>Handover</b></span>" : "<span class='badge' style='background-color:#d56666'><b>Rejected</b></span>"))); ?>
                </td>
                <td class="text-center"><?php echo $rows->created_at; ?></td>
                <td class="text-center">
                    <!-- <a class="btn btn-sm btn-info" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>"><i class="fa fa-eye" aria-hidden="true"></i> Details</a> -->
                   
                    <div class="dropdown" >
                      <!-- < ?php if($rows->status== 2 || $rows->status== 3){?> -->
                      <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <!-- < ?php }?> -->
                      <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                        <!-- <a style="padding-left:5px;" href="< ?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br> -->
                          <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_details/'.$rows->id);?>" >Details</a><br>
                          <?php if($rows->status==1){?> 
                              <a style="padding-left:5px;" href="<?= base_url('admin/inventory/requsition_edit_approved/'.$rows->id);?>">Edit</a> <br>
                              <a style="padding-left:5px; " href="<?= base_url('admin/inventory/delete_requsiton/'.$rows->id);?>">Delete</a>
                       
                      </div>
                    </div>
                    <?php } ?>
                </td>
            </tr>
  <?php  }}?>
        </tbody>
      </table>
    </div>
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









<!-- <div class="v167_2851 row" style="height: 52px; width:1220px;"><div class="v167_2852">
<span class="v167_2853" left="884px">requisition</span></div><span class="v167_2854">If you need
stationery items (Pen, Paper, Drairy etc ) or devices to work, feel free and
fill out the requisition form</span></div> -->
<!-- <div class="container">
  <div class="row">
    <div class="col-sm-9">
    <span class="v167_2854" style="
    padding-left: 11px;">If you need
       stationery items (Pen, Paper, Drairy etc ) or devices to work, feel free andfill out the requisition form</span>
    
  </div>
    <div class="col-sm-2" left="884px">
    <span left="v167_2853">requisition</span></div>
    </div>
  
  </div>
</div> -->


