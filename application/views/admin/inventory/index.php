<?php
// // dd($session); 
 $session = $this->session->userdata('username');
// $using_list = $this->db->select('COUNT(user_id) as using_list')->where('user_id',$session['user_id'])->where('status',1)->get('product_accessories')->row()->using_list;
 $requisition_list = $this->db->select('COUNT(user_id) as using_list, COUNT(status) as status')->where('user_id',$session['user_id'])->get('products_requisition_details')->row();
// // dd($requisition_list);
// $check = $this->db->select('use_number,number')->where('number !=','')->where('user_id',$session['user_id'])->get('product_accessories')->row();
// // dd($check ."<br>nai");
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

 .btn.active {
    /* Add your custom styling for the active button here */
    background-color: #31b0d5; /* For example, change background color to red */
    color: #ffffff; /* For example, change text color to white */
  }



    .custom-divider {
    height: 2px;
    background-color: #ccc; /* You can adjust the color */
    margin: 5px 0; /* Adjust margin as needed */
  }
  .dropdown-menu a.dropdown-item {
    color: #333; /* Text color */
    text-decoration: none; /* Remove underlines */
    padding: 10px 20px; /* Adjust padding as needed */
  }

</style>

<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">

<?php $get_animate = $this->Xin_model->get_content_animate();?>


<div class="row" >

<div>
    <div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
        <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
            <div class="h5">Total Using Items</div>
            <div class="h5"><?= 0 ?></div>
        </div>

        <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
            <div class="h5">Total Requisition</div>
            <div class="h5"><?= $requisition_list->using_list  ?></div>
        </div>
        <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
            <div class="h5">Return Items</div>
            <div class="h5"><?=  0 ?></div>
        </div>
        <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
            <div class="h5">Pending Items</div>
            <div class="h5"><?= $requisition_list->status ?></div>
        </div>
    </div>
</div>


</div>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <span class="t2" >If you need stationery items (Pen, Paper, Diary, etc.) or devices to work, feel free to fill out the requisition form.</span>
<div class="dropdown" style="float: right;">

    <!-- <?php //if(empty($check)){?> -->
      <a class="btn btn-info btn-sm" type="button"  href="<?= base_url('admin/inventory/create') ?>" >Requisition</a>
    <!-- <?php// }else{  if(( $check->number !='')){?>
      <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
       Requisition
      </button>
    <div class="dropdown-menu dropdown-menu-right">
      <a href="<?= base_url('admin/inventory/create') ?>" class="dropdown-item">For Equipments</a>      
      <div class="custom-divider"></div>
      <a href="<?= base_url('admin/inventory/create_phone') ?>" class="dropdown-item">For Mobile Bill </a>
    </div>
    <?php //} }?> -->
</div>

 </div>

  <div class="col-md-12" style="display:flex;margin-top:40px;">
    <div class="col-md-5" style="padding-left: 0px;margin-left: 0px;">
      <a href="#" class="btn btn-success" id="listButton">Using List</a>
      <a href="#" class="btn btn-info" style="margin-left:10px;" id="infoButton">Request Information</a>
    </div>
    <div class="col-md-5 <?php echo $get_animate;?>">
      <?php if($this->session->flashdata('success')):?>
        <div class="alert alert-success" id="flash_message" style="text-align: center;padding: 6px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          <?php echo $this->session->flashdata('success');?>
        </div>
      <?php endif; ?> 
    </div>
  </div>
</div>

<div class="row" >
  <div id="list_data"></div>
</div>
  


<script>
  $(document).ready(function() {
    // Handle click event for the buttons
    $('#listButton, #infoButton').click(function() {
      // Remove the 'active' class from all buttons within the container
      $('#listButton, #infoButton').removeClass('active');
      
      // Add the 'active' class to the clicked button
      $(this).addClass('active');
    });
  });
  $(document).ready(function(){
    $("#list_data").load("<?php echo base_url("admin/inventory/equipment_list")?>");
  });
  $('#listButton').click(function () {
    $("#list_data").load("<?php echo base_url("admin/inventory/equipment_list")?>");
  });

  $('#infoButton').click(function () {
    $("#list_data").load("<?php echo base_url("admin/inventory/requisition_list")?>");
  });
</script>