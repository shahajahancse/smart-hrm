<?php
/* Leave Application 

 
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
      <h3 class="box-title"><?php echo 'Requsition Form';?></h3>
      <div class="box-tools pull-right"> 
        <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
          <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> 
      </div>
    </div>

    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="box-body">
        <?php $attributes = array('id' => 'requisition_id', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <!-- < ?php $hidden = array('user_id' => $session['user_id']);?> -->
        <?php echo form_open('admin/requisition/create_requsition', $attributes);?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <input type="hidden" name="emp_id" value="<?php echo $session['user_id']?>" id="emp_id">
              <!-- <div class="col-md-3">
                <div class="form-group">
                 
                    
                </div>
            </div> -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date">Date</label>
                  <input class="form-control date" placeholder="date..." name="date" type="text" value="" id="m_date" required>
                  <input name="id" type="hidden" value="" id="id">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input class="form-control" placeholder="Amount of Money" name="amount" type="number" value="" id="amount" required>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="description">Description</label>
                      <textarea class="form-control" placeholder="description" name="description" cols="30" rows="1"  id="description" required></textarea>
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
       <h4 class="modal-title" id="
       ">Apply for TA/DA</h4>
       <h4 class="modal-title" id="modify_ta_da">Modify TA/DA</h4>
      </div>
      <form>
        <div class="form-group col-lg-3">
          <label id="add_amount">Add Amount</label>
          <label id="amounts">Amount</label>
          <input type="number" class="form-control" onkeyup="copyText()"  id="request_amount" aria-describedby="amount" placeholder="Enter amount">
          <input type="hidden" id="form_id">
        </div>
        <div class="form-group col-lg-9">
          <label for="exampleInputPassword1">Short Details</label>
          <textarea type="text" class="form-control" id="short_details" placeholder="Details"></textarea>
        </div>
        
        <?php 
			    //  $role_id = $this->session->userdata('role_id');
           $role_id =$session['role_id'];
         
            // dd($session['role_id']);

        if ($role_id == 3) { ?>
          <div class="form-group col-lg-6" id="ta_da_div" style="display: none;">
            <label id="manage_ta_da">Manage TA/DA</label>
            <select class="form-control" id="status">
              <option value="" disabled selected>Select</option>
              <option value="2">Approved</option>
              <option value="3">Reject</option>
            </select>
          </div>
			  <?php } else { ?>
          <div class="form-group col-lg-6" id="ta_da_div" >
            <label id="manage_ta_da">Manage TA/DA</label>
            <select class="form-control" id="status">
              <option value="" disabled selected id="std">Select</option>
              <option value="2">Approved</option>
              <option value="3">Reject</option>
            </select>
          </div>
		  <?php } ?>




      <?php 
			  
           $role_id1 =$session['role_id'];
         
            // dd($session['role_id']);

        if ($role_id1 == 3) { ?>
          <div class="form-group col-lg-6" id="set_ta_da_amount" style="display: none;">
            <label>Set Amount</label>
            <input type="text" class="form-control" id="payable_amount" placeholder="Set Amount">
          </div>
			  <?php } else { ?>
              <div class="form-group col-lg-6" id="set_ta_da_amount">
              <label>Set Amount</label>
              <input type="text" class="form-control" id="payable_amount" placeholder="Set Amount">
            </div>
		  <?php } ?>   
       
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                  
          <button type="button" class="btn btn-success btn-sm" onclick="manage_ta_da(<?php echo $session['role_id']?>)">Submit</button>

        </div>

      </form>
    </div>
  </div>
</div>
<!-- Colsed Modal -->

<!-- view ta da applied -->
<div class="modal fade bd-example-modal-lg" id='viewModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
       <h4 class="modal-title" >View TA/DA</h4>
      </div>
          <table class="table table-condensed table-bordered table-hover table-striped w-75">
              <thead>
                <tr >
                  <th class="text-center">Requested Amount</th>
                  <th class="text-center">Payable Amount</th>
                </tr>
              </thead>
              <tbody id="ta_da_view">
              
              </tbody>
        </table>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>

  
    </div>
  </div>
</div>


<!-- end modal -->

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Requisition  list</h3>
  </div>
  <!-- <div class="box-body">
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
              <td><?php echo ($row->status == 0)? '<span class="badge badge-primary"style="background: #000000c7;color: white;padding: 5px;">Not Applied</span>':($row->status == 1? '<span class="badge" style="background: #ff7600c7;color: white;padding: 5px;">Applied</span>':($row->status == 2?"<span class='badge' style='background: #036a2c;color: white;padding: 5px;'>Approved</span>":($row->status == 3?"<span class='badge' style='background: #ff0000b8;color: white;padding: 5px;'>Rejected</span>":"<span class='badge' style='background: #00bb5c;color: white;padding: 5px;'>Paid</span>")));?></td>
              <td>
              <div class="dropdown">

                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </button>

                <div class="dropdown-menu" style=" min-width: 134px !important;border-radius:0;line-height: 1.7;"  aria-labelledby="dropdownMenuButton">
                  
                <?php 
                  if($session['role_id'] != 3){ ?>
                  <a style="padding-left:5px;" onclick="edit(<?php echo $row->id;?>)" class="text-dark collapsed" data-toggle="collapse" href="?<?php echo $row->id; ?>#add_form" aria-expanded="false">Edit</a><hr>
                  <a style="padding-left:5px;" href="<?php echo base_url('admin/attendance/delete_move_register/'.$row->id); ?>">Delete</a>
                  
                   <?php if($row->status==1){?> 
                  <hr> <a style="padding-left:5px;" href="#" onclick="showModal(<?php echo $row->id?>,<?php echo $session['role_id']?>)">View TA/DA</a>
                  <?php } else{ if($row->status ==2){?>
                       <hr><a class='dropdown-item' style='padding-left:5px;'  href='#view_applied_report' onclick='view_applied_report(<?php echo $row->id?>)'>View</a>
                <?php }
                  else{ if($row->status ==3 ){?>
                <hr> <a style="padding-left:5px;" href="#" onclick="showModal(<?php echo $row->id?>,<?php echo $session['role_id']?>)"> Modify TA/DA</a>
                <hr><a class='dropdown-item' style='padding-left:5px;'  href='#view_applied_report' onclick='view_applied_report(<?php echo $row->id?>)'>View</a>
                 <?php }}
              }} 
                 
                 else {  
                        if(date("Y-m-d") < date("Y-m-d",strtotime("+ 5 days",strtotime($row->date)))){ ?>

                  
                         <?php if( $row->status==3 ||$row->status==2){?>
                           <a style="padding-left:5px; pointer-events: none; " onclick="edit(<?php echo $row->id;?>)" class="text-dark collapsed" data-toggle="collapse" href="?<?php echo $row->id; ?>#add_form" aria-expanded="false">Edit</a><hr>
                          <a style="padding-left:5px; pointer-events: none;" href="<?php echo base_url('admin/attendance/delete_move_register/'.$row->id);?>" disable >Delete</a>       
                          <?php } else{?>

                             <a style="padding-left:5px;" onclick="edit(<?php echo $row->id;?>)" class="text-dark collapsed" data-toggle="collapse" href="?<?php echo $row->id; ?>#add_form" aria-expanded="false">Edit</a><hr>
                              <a style="padding-left:5px;" href="<?php echo base_url('admin/attendance/delete_move_register/'.$row->id); ?>" >Delete</a>
                            <?php }?>
                  
                  <?php if($row->status ==0) {?>
                    <hr> <a class="dropdown-item" style="padding-left:5px;" href="#" onclick="showModal(<?php echo $row->id?>,<?php echo $session['role_id']?>)">Apply for TA/DA</a>
                  <?php } 
                    else{?>
                       <hr><a class='dropdown-item' style='padding-left:5px;'  href='#view_applied_report' onclick='view_applied_report(<?php echo $row->id?>)'>View</a>
                   <?php }
                    }
                    else {  
                          if($row->status ==0) {?>
                            <a class="dropdown-item" style="padding-left:5px;" href="#" onclick="showModal(<?php echo $row->id?>,<?php echo $session['role_id']?>)">Apply for TA/DA</a>
                            <?php } else{?>
                            <span class="dropdown-item" style="padding-left:5px;">No Action Need</span>
                    <?php }}  if($row->status ==1 ){?>
                <hr> <a style="padding-left:5px;" href="#" onclick="showModal(<?php echo $row->id?>,<?php echo $session['role_id']?>)"> Edit TA/DA </a>
                 <?php }   }?>
                </div>
              </div>

              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div> -->
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

          success: function(data){
            response=data[0]
          

            emp=data[1][0];
            var a = response[0].out_time;
            var b = response[0].in_time;
            var time = a.slice(10, 16);
            var intime = b.slice(10, 16);

            $("#id").val(response[0].id);
            $("#id").val(response[0].id);

            $("#m_date").val(response[0].date);
            $("#m_in_time").val(intime);
            $("#m_out_time").val(time);
            $("#emp").html(emp['first_name']+' '+emp['last_name']);
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
    $("#requisition_id").on('submit', function(e) {
      var url = "<?php echo base_url('admin/requisition/create_requsition'); ?>";
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
              window.location.replace('<?php echo base_url('admin/requisition/index/')?>')
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

 function view_applied_report(id){
  $('#viewModal').modal().show();
  // alert(id);
  var url = "<?php echo base_url('admin/attendance/view_ta_da/')?>"+id;

  $.ajax({    
        type: "GET",
        url: url,
        dataType:"json",     
        data:{id:id},                 
        success: function(data){                    
          // $('#view_ta_td').html(data[0].request_amount);
          var trHTML = '';
        // $.each(data, function (i, item) {
        //     trHTML += '<tr class="text-center"><td>' + item.request_amount + '</td><td>' + item.payable_amount + '</td></tr>';
        // });
        $.each(data, function (i, item) {
            var payable = item.payable_amount !== null ? item.payable_amount : 'waiting';
            trHTML += '<tr class="text-center"><td>' + item.request_amount + '</td><td>' + payable + '</td></tr>';
          });
        $('#ta_da_view').html(trHTML);

        }
    });
}


// appply for ta / da

function showModal(id,role_id) {
  //  alert(id + ' '+ role_id); 
    $("#form_id").val(id);
    $('#myModal').modal().show();
     
    var url = "<?php echo base_url('admin/attendance/modify_for_ta_da/')?>" + id;
    jQuery.ajax({
          url: url,
          contentType : "application/json", 
          dataType: 'json',
          type: 'POST',

          success: function(response){
              //console.log(response[0].request_amount);
              // console.log(response[0].status);

              if(role_id !="3"){
                $("#request_amount").val(response[0].request_amount);
                $("#short_details").val(response[0].reason);
                $('#apply_for_ta_da').hide();
                $('#modify_ta_da').show();
                 if(response[0].status==3){
                  $("#std").html("Reject");}
             
                $('#add_amount').hide();
                $('#amounts').show();
                $('#ta_da_div').show();
                $('#set_ta_da_amount').show();
              }
              else{
                $('#apply_for_ta_da').show();
                $("#request_amount").val(response[0].request_amount);
                
                if(response[0].status==3 || response[0].status==1){
                  // console.log(response[0].status);
                   $("#short_details").val(response[0].reason);
                }
                $('#modify_ta_da').hide();
                $('#add_amount').show();
                $('#amounts').hide();
                $('#ta_da_div').hide();
                $('#set_ta_da_amount').hide();
              }
          }
      });


}

function manage_ta_da(role_id){
  let request_amount= $("#request_amount").val();
  let short_details= $("#short_details").val();
  let form_id= $("#form_id").val(); 
  if(request_amount ==''){
    alert('Please Set Amount');
    $("#request_amount").focus();
    $("#request_amount").attr('style', 'border: 1px solid red !important');
    return false;
  }


  if(short_details==''){
        alert('Please Enter Short Description');
        $("#short_details").focus()
        $("#short_details").attr('style', 'border: 1px solid red !important');
        return false;
  }   
  
  if(role_id !=3){
    var id=   $("#form_id").val();
    var status=   $("#status").val();
    var payable_amount=   $("#payable_amount").val();
    if($('#status').val()==null){
        // alert('Please Select Status');
        $('#status').focus();
        $("#status").attr('style', 'border: 1px solid red !important');
        
        return false;
      }

      if($('#payable_amount').val()==''){
        // alert('Please Insert Effective Date');
        $('#payable_amount').focus();
        $("#payable_amount").attr('style', 'border: 1px solid red !important');

        return false;
      }
    var url = "<?php echo base_url('admin/attendance/update_ta_da');?>";
      $.ajax({
      url: url,
      type: 'POST',
      dataType: "json",
      data: {
              "form_id"         : form_id,   
              "status"          : status,
              "payable_amount"  : payable_amount,
            },
      success: function(response){
        alert('Modify Successfully');
        $('.modal').modal('hide');  
        window.location.replace("<?php echo base_url('admin/attendance/move_register/');?>")
      } 
    });
  } 

  else{
    var id=   $("#form_id").val();
        
        var url = "<?php echo base_url('admin/attendance/apply_for_ta_da');?>";
        $.ajax({
        url: url,
        type: 'POST',
        dataType: "json",
        data: {
                "form_id":form_id,
                "request_amount":request_amount,
                "short_details":short_details,
              },
        success: function(response){
					alert('Submitted Successfully');
          $('.modal').modal('hide');  
          window.location.replace("<?php echo base_url('admin/attendance/move_register/');?>")
        }
      });
  }

 } 


 $(document).ready(function(){

  $('#myModal').on('hidden.bs.modal', function(){
              $(this).find('form')[0].reset();
              $("#request_amount").attr('style', 'border: 1px solid #ccd6e6 !important');
              $("#short_details").attr('style', 'border: 1px solid #ccd6e6 !important');
  });

  $("request_amount").on('input',function(){
    $("#request_amount").attr('style', 'border: 1px solid #ccd6e6 !important');
    if($("#request_amount").val() ==''){
      $("#request_amount").attr('style', 'border: 1px solid red !important');
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



function copyText() {
    var request_amount = $('#request_amount').val();
    var url = "<?php echo base_url('admin/attendance/copy_value'); ?>";
    $.ajax({
      type: 'POST',
      // url: 'admin/attendance/copy_value',
      url: url,
      data: {request_amount: request_amount},
      success: function(response) {
        $('#payable_amount').val(response);
      }
    });
  }
</script>





</scrip>

