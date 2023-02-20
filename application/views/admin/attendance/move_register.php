<?php
/* Leave Application view
*/
?>
<style>
  hr{
    margin-top: 5px;
    margin-bottom: 5px;
    border: 0;
    border-top: 1px solid #10101029;
  }

</style>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div id="page_load">
<div class="box mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="box-header with-border">
      <h3 class="box-title"><?php echo 'Add Movement leave';?></h3>
      <div class="box-tools pull-right"> 
        <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> 
      </div>
    </div>

    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('id' => 'move_register', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <!-- < ?php $hidden = array('user_id' => $session['user_id']);?> -->
        <?php echo form_open('admin/attendance/create_move_register', $attributes);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <?php
                $sql= 'SELECT user_id,first_name,last_name FROM xin_employees';
                $employees = $this->db->query($sql);
                $emps=$employees->result();

                if($session['role_id']!=3){
              ?>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date">Employee Name</label>
                  <select name="emp_id" class="form-control" id="emp_name">
                    <option value="">Select Employee Name</option>
                    <?php foreach($emps as $emp){?>
                    <option value="<?php echo $emp->user_id?>"><?php echo $emp->first_name.' '.$emp->last_name?></option>
                    <?php }?>
                  </select>
                </div>
              </div>
              <?php }
                else{?>
                     <input type="hidden" name="emp_id" value="<?php echo $session['user_id']?>" id="emp_id">
               <?php }?>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date">Date</label>
                  <input class="form-control date" placeholder="date..." name="date" type="text" value="" id="m_date">
                  <input name="id" type="hidden" value="" id="id">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="out_time">Office out time</label>
                  <input class="form-control  timepicker clear-1" placeholder="Office out time" name="out_time" type="text" value="" id="m_out_time">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="in_time">Office in time</label>
                  <input class="form-control  timepicker clear-2" placeholder="Office in time" name="in_time" type="text" value="" id="m_in_time">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="summary">Reason</label>
                  <textarea class="form-control" placeholder="reason" name="reason" cols="30" rows="3"  id="m_reason"></textarea>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>

  </div>
</div>

<!-- modal for TA DA -->
<div class="modal fade bd-example-modal-lg" id='myModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title" id="exampleModalLabel">Apply for TA/DA</h4>
      </div>
      <form>
        <div class="form-group col-lg-3">
          <label>Add Amount</label>
          <input type="number" class="form-control" id="amount" aria-describedby="amount" placeholder="Enter amount">
          <input type="hidden" id="form_id">
        </div>
        <div class="form-group col-lg-9">
          <label for="exampleInputPassword1">Short Details</label>
          <textarea type="text" class="form-control" id="short_details" placeholder="Details"></textarea>
        </div>

       
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success btn-sm" onclick="apply_for_ta_da()">Submit</button>
        </div>

      </form>
    </div>
  </div>
</div>
<!-- Colsed Modal -->



<!-- Modal for Manage TA/DA-->
<div class="modal fade bd-example-modal-lg" id="my_modals" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Manage Employee TA/DA</h4>
      </div>
      <!-- < ?php
         $sql= 'SELECT user_id,first_name,last_name FROM xin_employees';
         $employees = $this->db->query($sql);
         $emps=$employees->result();
      ?> -->
      <!-- <div class="modal-body"> -->
      <form>

      <div class="form-group col-lg-3">
          <label>Amount</label>
          <input type="number" class="form-control" id="amount" aria-describedby="amount" placeholder="Enter amount">
          <input type="text" id="form_id">
        </div>
        <div class="form-group col-lg-9">
          <label for="exampleInputPassword1">Short Details</label>
          <textarea type="text" class="form-control" id="short_details" placeholder="Details"></textarea>
        </div>

        <div class="form-group col-lg-6">
          <label>Manage TA/DA</label>
           <select class="form-control">       
           <option value="" disabled selected>Select</option>
           <option value="1">Approved</option>
           <option value="2">Rejected</option>
           <option value="3">Modify And Approved</option>
           </select>       
        </div>
        
        <div class="form-group col-lg-6">
          <label>Set Amount</label>
          <input type="number" class="form-control" id="amount" aria-describedby="amount" placeholder="Enter amount">
        </div>


          
          <div class="modal-footer" >
            <button type="button" name="btn" onclick="save_modify_salary()" class="btn btn-sm btn-success" style="margin-top:10px !important">Save</button>
            <button type="button" class="btn btn-sm btn-danger" style="margin-top:10px !important" data-dismiss="modal">Close</button>
          </div>
          </form>
      <!-- </div> -->

    </div>
  </div>
</div>
<!-- modal close -->

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Movement leave list</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable ">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead>
          <tr>
            <th style="width:120px;">No.</th>
            <th style="width:120px;">Name.</th>
            <th style="width:100px;">Date</th>
            <th style="width:100px;">Out</th>
            <th style="width:100px;">In</th>
            <th style="width:100px;">Reason</th>
            <th style="width:100px;">TA/DA Request</th>
            <th style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $key => $row) { ?>
            <tr>
              <td><?php echo $key + 1;?></td>
              <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
              <td><?php echo $row->date; ?></td>
              <td><?php echo $row->out_time == "" ? "" : date('h:i A',strtotime($row->out_time)); ?></td>
              <td><?php echo $row->in_time  == "" ? "" : date('h:i A',strtotime($row->in_time));?></td>
              <td><?php echo $row->reason; ?></td>
              <td><?php echo ($row->status == 0)? '<span class="badge badge-primary"style="background: #000000c7;color: white;padding: 5px;">Not Applied</span>':($row->status == 1? '<span class="badge" style="background: #ff7600c7;color: white;padding: 5px;">Applied</span>':($row->status == 2?"<span class='badge' style='background: #ff0000b8;color: white;padding: 5px;'>Rejected</span>":($row->status == 3?"<span class='badge' style='background: #036a2c;color: white;padding: 5px;'>Approved</span>":"<span class='badge' style='background: #00bb5c;color: white;padding: 5px;'>Paid</span>")));?></td>
              <td>
              <div class="dropdown">

                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </button>

                <div class="dropdown-menu" style=" min-width: 134px !important;border-radius:0;line-height: 1.7;"  aria-labelledby="dropdownMenuButton">
                  <?php if($session['role_id'] != 3){ ?>
                  <a style="padding-left:5px;" onclick="edit(<?php echo $row->id;?>)" class="text-dark collapsed" data-toggle="collapse" href="?<?php echo $row->id; ?>#add_form" aria-expanded="false">Edit</a><hr>
                  <a style="padding-left:5px;" href="<?php echo base_url('admin/attendance/delete_move_register/'.$row->id); ?>">Delete</a>

                  <hr> <a style="padding-left:5px;" href="#" onclick="show_TA_DAModal(<?php echo $row->id?>)">View TA/DA</a>
                  <?php } else {  ?>
                  <?php if(date("Y-m-d") < date("Y-m-d",strtotime("+ 5 days",strtotime($row->date)))){ ?>

                  <a style="padding-left:5px;" onclick="edit(<?php echo $row->id;?>)" class="text-dark collapsed" data-toggle="collapse" href="?<?php echo $row->id; ?>#add_form" aria-expanded="false">Edit</a><hr>
                  <a style="padding-left:5px;" href="<?php echo base_url('admin/attendance/delete_move_register/'.$row->id); ?>" >Delete</a>
                  <?php if($row->status ==0) {?>
                    <hr> <a class="dropdown-item" style="padding-left:5px;" href="#" onclick="showModal(<?php echo $row->id?>)">Apply for TA/DA</a>
                  <?php } ?>


                  <?php }

                  else{?>
                    <span class="dropdown-item" style="padding-left:5px;">No Action Need</span>
                  <?php } }?>
                </div>
              </div>

              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>

<script>

function edit(id){
  var url = "<?php echo base_url('admin/attendance/move_register/')?>" +id;
      $.ajax({
          url: url,
          type: 'POST',
          dataType: "json",
          data:{id:id},
          processData: false,
          contentType: false,
          cache : false,

          success: function(response){
            var a = response[0].out_time;
            var b = response[0].in_time;
            var time = a.slice(10, 16);
            var intime = b.slice(10, 16);

            $("#id").val(response[0].id);
            $("#m_date").val(response[0].date);
            $("#m_in_time").val(intime);
            $("#m_out_time").val(time);
            $("#m_reason").val(response[0].reason);
          }
          
      });
      return false;
    }
 

  $(document).ready(function() {

    $('.clockpicker').clockpicker();
    var input = $('.timepicker').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'
    });


    // file upload
    $("#move_register").on('submit', function(e) {
      var url = "<?php echo base_url('admin/attendance/create_move_register'); ?>";
      e.preventDefault();

      var okyes;
      okyes=confirm('Are you sure you want to leave?');
      if(okyes==false) return;

      $.ajax({
          url: url,
          type: 'POST',
          dataType: "json",
          data: new FormData(this),
          processData: false,
          contentType: false,
          cache : false,


          success: function(response){

            if(response.status == 'success') {
              alert(response.message)
              window.location.replace('<?php echo base_url('admin/attendance/move_register/')?>')
            } else {
              alert(response.message)
            }
          },
          error: function(response) { 
            alert(response.message)
          }
      });
      return false;
    });
    $('#example').DataTable();

  });




// appply for ta / da

function showModal(id) {
    $("#form_id").val(id);
    $('#myModal').modal().show();
}

function show_TA_DAModal(id) {
    // $("#form_id").val(id);
    $('#my_modals').modal().show();
}
 

function apply_for_ta_da(){
  let amount= $("#amount").val();
  let amount_lenght = amount.toString().length;
  let short_details= $("#short_details").val();
  let form_id= $("#form_id").val();  

  if(amount ==''){
    alert('Please Set Amount');
    $("#amount").focus();
    $("#amount").attr('style', 'border: 1px solid red !important');
    return false;
  }
  // if(amount_lenght>6){
  //     alert("not ok"); return false;
  // }

  if(short_details==''){
        alert('Please Enter Short Description');
        $("#short_details").focus()
        $("#short_details").attr('style', 'border: 1px solid red !important');
        return false;
  }
        var url = "<?php echo base_url('admin/attendance/apply_for_ta_da');?>";
        $.ajax({
        url: url,
        type: 'POST',
        dataType: "json",
        data: {
                "form_id":form_id,
                "amount":amount,
                "short_details":short_details,
              },
        success: function(response){
					alert('Submitted Successfully');
          $('.modal').modal('hide');  
          window.location.replace("<?php echo base_url('admin/attendance/move_register/');?>")
        }
      });
  
 } 


 $(document).ready(function(){

  $('.modal').on('hidden.bs.modal', function(){
              $(this).find('form')[0].reset();
              $("#amount").attr('style', 'border: 1px solid #ccd6e6 !important');
              $("#short_details").attr('style', 'border: 1px solid #ccd6e6 !important');
  });

  $("#amount").on('input',function(){
    $("#amount").attr('style', 'border: 1px solid #ccd6e6 !important');
    if($("#amount").val() ==''){
      $("#amount").attr('style', 'border: 1px solid red !important');
      return false;
    }
  });

  $("#short_details").on('input',function(){
    $("#short_details").attr('style', 'border: 1px solid #ccd6e6 !important');
    if($("#short_details").val() ==''){
      $("#short_details").attr('style', 'border: 1px solid red !important');
      return false;
    }
  });

});

</script>

