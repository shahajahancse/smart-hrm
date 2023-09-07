<?php
// dd($products);   
$session = $this->session->userdata('username');
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
  .table {
    width: 92%;
    margin-bottom: 14px;
}
.using {
    display: inline-flex;
    padding: 4.5px 14.3px 5.5px 9px;
    align-items: center;
    gap: 9px;
    border-radius: 50px;
    border: 1px solid #CCC;
    background: #FFF;
    font-size:12px
}

.d-hidden {
  display: none !important;
}

</style>
<?php if($this->session->flashdata('success')):?>
  <div class="alert alert-success" id="flash_message">
    <?php echo $this->session->flashdata('success');?>
  </div>
<?php endif; ?> 
<script>
  $(function() {$("#flash_message").hide(2000);});
</script>  
<?php if($this->session->flashdata('warning')):?>
  <div class="alert alert-warning"id="flash_message1">
    <?php echo $this->session->flashdata('warning');?>
  </div>
<?php endif; ?> 
<script>
  $(function() {$("#flash_message1").hide(2000);});
</script> 


<div class="box <?php echo $get_animate;?>" style="margin-top:20px">

  <div class="box-header with-border">
    <h3 class="box-title">Requisition List</h3>
    <!-- <a class="btn btn-sm btn-primary pull-right" href="<?= base_url('admin/inventory/create');?>">New Requisition</a> -->
    <button class="btn btn-info btn-sm dropdown-toggle pull-right" type="button" data-toggle="dropdown">
   Requisition
  </button>
  <div class="dropdown-menu dropdown-menu-right">
    <a href="<?= base_url('admin/inventory/create') ?>" class="dropdown-item">For Equipments</a>
      <div class="custom-divider"></div>
    <a href="<?= base_url('admin/inventory/create_phone') ?>" class="dropdown-item">For Mobile Bill </a>
  </div>
  </div><hr>
  <div class="" style="margin-bottom:20px; margin-left:10px">
    <a href="#" class="btn btn-success" id="listButton">Equipment List</a>
    <a href="#" class="btn btn-info" style="margin-left:10px;" id="infoButton">Mobile Bill List</a>
  </div>
  <div class="card">
    <div class="card-body" id="list_data"></div>
  </div>

</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#purchase_tables').DataTable();
      $("#list_data").load("<?php echo base_url("admin/inventory/requisition_equipment_list")?>");
    });
    $('#listButton').click(function () {
      $("#list_data").load("<?php echo base_url("admin/inventory/requisition_equipment_list")?>");
    });
    $('#infoButton').click(function () {
      $("#list_data").load("<?php echo base_url("admin/inventory/mobile_bill_requisition_list")?>");
    });

</script>