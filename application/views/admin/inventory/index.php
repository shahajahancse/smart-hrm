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


<div class="row" id="card_list">

</div>

<div class="row">
  <div class="col-md-12">
    <span class="t2" >If you need stationery items (Pen, Paper, Diary, etc.) or devices to work, feel free to fill out the requisition form.</span>
    <a href="<?= base_url('admin/inventory/create') ?>" class="btn btn-md btn-primary" style="float:right">Requisition</a>
    
  </div>

  <div class="col-md-4" style="display:flex;">
    <a href="#" class="btn" id="listButton">Using List</a>
    <a href="#" class="btn" style="margin-left:10px;" id="infoButton">Request Information</a>
  </div>

<?php if($this->session->flashdata('success')):?>
  <div class="alert alert-success" id="flash_message">
    <?php echo $this->session->flashdata('success');?>
  </div>
<?php endif; ?> 

  <div class="box-body">
    <div class="box-datatable" >
      <div id="list_data">

      </div>


    </div>
  </div>
</div>


<!-- The Modal -->





<script>
$(document).ready(function(){
  $("#list_data").load("<?php echo base_url("admin/inventory/equipment_list")?>");
  $("#card_list").load("<?php echo base_url("admin/inventory/equipment_card")?>");
});
$('#listButton').click(function () {
  $("#list_data").load("<?php echo base_url("admin/inventory/equipment_list")?>");
  $("#card_list").load("<?php echo base_url("admin/inventory/equipment_car")?>");
});

$('#infoButton').click(function () {
  $("#list_data").load("<?php echo base_url("admin/inventory/requisition_list")?>");
  $("#card_list").load("<?php echo base_url("admin/inventory/requisition_card")?>");

});
</script>






