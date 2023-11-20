<?php
// dd($session); 
$session = $this->session->userdata('username');
$using_list = $this->db->select('COUNT(user_id) as using_list')->where('user_id',$session['user_id'])->get('product_accessories')->row()->using_list;
$requisition_list = $this->db->select('COUNT(user_id) as using_list, COUNT(status) as status')->where('user_id',$session['user_id'])->get('products_requisition_details')->row();
// dd($requisition_list);
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
            <div class="h5">Total Request</div>
            <div class="h5"><?= $using_list ?></div>
        </div>

        <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
            <div class="h5">Using Device</div>
            <div class="h5"><?= $requisition_list->using_list  ?></div>
        </div>
        <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
            <div class="h5">Unusing Device</div>
            <div class="h5"><?=  0 ?></div>
        </div>
        <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
            <div class="h5">Pending Items</div>
            <div class="h5"><?= $requisition_list->status ?></div>
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
