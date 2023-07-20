<?php
// dd($session); 
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


<div class="row" >

<div>
    <div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
        <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
            <div class="h5">Total Using Items</div>
            <div class="h5"><?= 0 ?></div>
        </div>

        <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
            <div class="h5">Total Requisition</div>
            <div class="h5"><?= 0  ?></div>
        </div>
        <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
            <div class="h5">Return Items</div>
            <div class="h5"><?=  0 ?></div>
        </div>
        <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
            <div class="h5">Pending Items</div>
            <div class="h5"><?= 0 ?></div>
        </div>
    </div>
</div>


</div>

<div class="row <?php echo $get_animate;?>">
  <div class="col-md-12">
    <span class="t2" >If you need stationery items (Pen, Paper, Diary, etc.) or devices to work, feel free to fill out the requisition form.</span>
    <a href="<?= base_url('admin/inventory/create') ?>" class="btn btn-md btn-primary" style="float:right">Requisition</a>
  </div>

  <div class="col-md-12" style="display:flex;">
    <div class="col-md-5" style="padding-left: 0px;margin-left: 0px;">
    <a href="#" class="btn" id="listButton">Using List</a>
    <a href="#" class="btn" style="margin-left:10px;" id="infoButton">Request Information</a>
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

<div class="row">
  <div id="list_data">

  </div>
</div>
  


<script>
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