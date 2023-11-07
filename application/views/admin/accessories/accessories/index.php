
<?php 
// dd($results);
$session = $this->session->userdata('username');
$eid = $this->uri->segment(4);
$get_animate = $this->Xin_model->get_content_animate();
$role_resources_ids = $this->Xin_model->user_role_resource(); 
?>

<?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success" style="width: 250px;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
      <?php echo $this->session->flashdata('success');?>
    </div>
<?php endif; ?> 


<style>
  .dropup .dropdown-menu{
    top: 20px;
    bottom: inherit;
    right: 15px !important;
    left: auto !important;
    min-width: 100px !important;
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
</style>


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Item list</h3>
    <a class="btn btn-sm btn-info" style="float:right" href="<?php echo base_url('admin/accessories/item_add')?>">Add Item</a>
  </div>
  <ul class="nav nav-tabs">
      <li class="">
        <a href="#working" data-toggle="tab" id="1">On Working</a>
      </li>
      <li>
        <a href="#movementttt" data-toggle="tab" id="5">Movement</a>
      </li>
      <li>
        <a href="#stored" data-toggle="tab" id="2">Stored</a>
      </li>
      <li>
        <a href="#servicing" data-toggle="tab" id="3">Servicing</a>
      </li>
      <li>
        <a href="#destroyed" data-toggle="tab" id="4">Destroyed</a>
      </li>
      <li class="active">
        <a href="#all" data-toggle="tab" id="6" >All List</a>
      </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <div class="tab-pane fade " id="working">
      <div class="box-body">
        <div class="box-datatable">
          <div id="on_working"></div>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="movementttt">
      <div class="box-body">
        <div class="box-datatable">
          <div id="on_movement"></div>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="stored">
      <div class="box-body">
        <div class="box-datatable">
          <div id="on_stored"></div>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="servicing">
       <div class="box-body">
        <div class="box-datatable">
          <div id="on_servicing"></div>
        </div>
      </div>
    </div>

    <div class="tab-pane fade" id="destroyed">
      <div class="box-body">
        <div class="box-datatable ">
          <div id="on_destroyed"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="tab-pane fade in active" id="all">
    <div class="box-body">
        <div class="box-datatable">
          <div id="on_all"></div>
        </div>
      </div>
    </div>
  </div>


</div>
<script>
  $(document).ready(function() {
    $('#example').DataTable({
      "pageLength": 50,
      "lengthMenu": [[25, 50,100, -1], [25, 50, 100, "All"]],
    });
  });

  $('#1').click(function () {
    $("#on_all").hide();
    $("#on_working").show();
    var id = $(this).attr('id');
    $("#on_working").load("<?php echo base_url("admin/accessories/item_lists/")?>"+id);
  });

  $('#2').click(function () {
    $("#on_all").hide();
    $("#on_stored").show();
    var id = $(this).attr('id');
    $("#on_stored").load("<?php echo base_url("admin/accessories/item_lists/")?>"+id);
  });

  $('#3').click(function () {
    $("#on_all").hide();
    $("#on_servicing").show();
    var id = $(this).attr('id');
    $("#on_servicing").load("<?php echo base_url("admin/accessories/item_lists/")?>"+id);
  }); 

  $('#4').click(function () {
    $("#on_all").hide();
    $("#on_destroyed").show();
    var id = $(this).attr('id');
    $("#on_destroyed").load("<?php echo base_url("admin/accessories/item_lists/")?>"+id);
  });

  $('#5').click(function () {
    var id = $(this).attr('id');
    $("#on_movement").show();
    $("#on_all").hide();
    $("#on_movement").load("<?php echo base_url("admin/accessories/item_lists/")?>"+id);
  });

  $('#6').click(function () {
    $("#on_working").hide();
    $("#on_stored").hide();
    $("#on_servicing").hide();
    $("#on_destroyed").hide();
    $("#on_movement").hide();
    $("#on_all").show();
    var id = $(this).attr('id');
    $("#on_all").load("<?php echo base_url("admin/accessories/item_lists/")?>"+id);
  });

$(document).ready(function() {
   $("#on_all").load("<?php echo base_url("admin/accessories/item_lists/")?>"+6);
});
</script>
