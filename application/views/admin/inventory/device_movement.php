
<?php
$this_month_first_date = date('Y-m-01');
$today_date = date('Y-m-d');
$last_seven_days = date('Y-m-d', strtotime('-1 week'));
$last_month = date('Y-m-d', strtotime('-2 month'));
$this_month = date('Y-m-1');
$session = $this->session->userdata('username');
$requisition_list = $this->db->get('move_list')->result();

$today_data = array_filter($requisition_list, function ($item) use ($today_date) {
    $created_at = date('Y-m-d', strtotime($item->created_at));
    return $created_at == $today_date;
});


$last_seven_data = array_filter($requisition_list, function ($item) use ($last_seven_days, $today_date) {
    $created_at = date('Y-m-d', strtotime($item->created_at));
    return ($created_at >= $last_seven_days) && ($created_at <= $today_date);
});


$last_month_data = array_filter($requisition_list, function ($item) use ($last_month, $this_month_first_date) {
    $created_at = date('Y-m-d', strtotime($item->created_at));
    return ($created_at >= $last_month) && ($created_at <$this_month_first_date);
});


$this_month_data = array_filter($requisition_list, function ($item) use ($this_month,$today_date) {
    $created_at = date('Y-m-d', strtotime($item->created_at));
    return ($created_at >= $this_month) && ($created_at <= $today_date);
});

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
    background:#0fb0d6;
}
.btnn {
  background-color: #0fb0d6;
  color:white;
  border: none;
  cursor: pointer;
}
.btnn.active {
  background-color: #007bff;
  color: #fff;
}
.btnn:hover{
  color:white;
}



</style>
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">

<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="card" >
    <div class="card-body">
        
    <div class="divrow " style="margin-bottom: 27px;">
        <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
            <div class="h5">Today's</div>
            <div class="h5"><?= count($today_data) ?></div>
        </div>

        <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
            <div class="h5">Last 7days</div>
            <div class="h5"><?= count($last_seven_data)  ?></div>
        </div>
        <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
            <div class="h5">This Month</div>
            <div class="h5"><?= count($this_month_data) ?></div>
        </div>
        <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
            <div class="h5">Last Month</div>
            <div class="h5"><?=  count($last_month_data) ?></div>
        </div>
    </div>


<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
   <a href="<?= base_url('admin/inventory/create_movement') ?>" class="btn btn-md btn-primary" style="float:right">Crate Movement </a>
  </div>

  <div class="col-md-12" style="display:flex;margin-top:5px">
    <div class="col-md-7" style="padding-left: 0px;margin-left: 0px;">
      
      <?php if($session['role_id']==3){?>
        <a href="#" class="btn btnn" style="margin-left:10px;" id="active_deivce">Active Device</a>
        <a href="#" class="btn btnn" style="margin-left:10px;" id="move_history">Movement history</a>
      <?php }else{?>
      <!-- <a href="#" class="btn btnn" id="listButton">Request List</a> -->
      <a href="#" class="btn btnn" style="margin-left:10px;" id="infoButtonn">Used Device</a>
      <a href="#" class="btn btnn" style="margin-left:10px;" id="infoButtonnn">All Device</a>
      <?php }?>
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
        <?php if($this->session->flashdata('error')):?>
            <div class="alert alert-error" id="flash_message" style="text-align: center;padding: 6px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php echo $this->session->flashdata('error');?>
            </div>
        <?php endif; ?> 
    </div>
  </div>
</div>

<div class="row">
  <div id="list_data">

  </div>
</div>
    </div>
</div>
  


<script>

  $(document).ready(function(){
    $('#listButton').addClass('active');
    $("#list_data").load("<?php echo base_url("admin/inventory/active_list")?>");
  });
  // $('#listButton').click(function () {
  //   $("#list_data").load("< ?php echo base_url("admin/inventory/requested_list")?>");
  // });

  $('#infoButtonn').click(function () {
    $("#list_data").load("<?php echo base_url("admin/inventory/active_list")?>");
  });

    $('#infoButtonnn').click(function () {
    $("#list_data").load("<?php echo base_url("admin/inventory/inactive_list")?>");
  });
  setTimeout(function() {
      $("#flash_message").fadeOut();
  }, 3000);
   $('.btnn').click(function(event) {
      event.preventDefault();
      $('.btnn').removeClass('active');
      $(this).addClass('active');
    });
</script>
