<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="col-lg-8">
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="process_date">First Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date" name="process_date" type="text" autocomplete="off">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="process_date">Second Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="second_date" name="second_date" type="text" autocomplete="off">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border" id="report_title">
    <h3 class="box-title" id="report">  Report</h3>
  </div>

  <div class="box-body" id="emp_report">
    <ul class="nav nav-tabs " id="myTab" role="tablist">
      <li class="nav-item active">
        <a class="nav-link " id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Requsition</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Purchase</a>
      </li>

      <!-- <li class="nav-item">
        <a class="nav-link" id="mobile-tab" data-toggle="tab" href="#mobile" role="tab" aria-controls="mobile" aria-selected="false">Mobile Bill</a>
      </li> -->
    </ul>
    
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab" style="margin-top: 30px;">
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(1)">Pending</button>
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(2)">Approved</button>
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(4)">Reject</button>
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(3)">Delivered Item</button>
      </div>
      <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab" style="margin-top: 30px;">
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(1)">Pending</button>
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(2)">Approved</button>
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(4)">Reject</button>
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(3)">Receive</button>
        <button class="btn btn-info btn-sm"  onclick="LP_AlP_Report(7)">Low inventory</button>
        <button class="btn btn-info btn-sm"  onclick="LP_AlP_Report(8)">All Products</button>
      </div>

      <!-- <div class="tab-pane fade" id="mobile" role="tabpanel" aria-labelledby="mobile-tab" style="margin-top: 30px;">
        <button class="btn btn-info btn-sm"  onclick="mobile_bill(1)"> Pending </button>
        <button class="btn btn-info btn-sm"  onclick="mobile_bill(2)"> Approved </button>
        <button class="btn btn-info btn-sm"  onclick="mobile_bill(3)"> Reject </button>
        <button class="btn btn-info btn-sm"  onclick="mobile_bill(4)"> Payment </button>
      </div> -->
    </div>
  </div>

  <div  class="box-body" id="entry_form"></div>

</div>
</div>



<!-- <script type="text/javascript" src="< ?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script> -->
<script>
    // alert(base_url);
function Inv_Report(statusC){
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();

  first_date = document.getElementById('process_date').value;
  second_date = document.getElementById('second_date').value;
  
  if(second_date !='' && first_date =='' )
  {
    alert('Please select first date');
    return ;
  }
  if(second_date =='' && first_date !=='')
  {
    alert('Please select second date');
    return ;
  }
  var data = "first_date="+first_date+"&second_date="+second_date+"&statusC="+statusC;

  url = '<?php echo base_url('admin/reports')?>' + "/inventory_status_report";
  ajaxRequest.open("POST", url, true);
  ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
  ajaxRequest.send(data);
    // alert(url); return;

  ajaxRequest.onreadystatechange = function(){
    if(ajaxRequest.readyState == 4){
      // console.log(ajaxRequest.responseText); return;
      var resp = ajaxRequest.responseText;
      a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
      a.document.write(resp);
      // a.close();
    }
  }
}


function Per1_Report(statusC){

  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();

  first_date = document.getElementById('process_date').value;
  second_date = document.getElementById('second_date').value;

  
  if(first_date =='')
  {
    alert('Please select first date');
    return ;
  }
  if(second_date =='')
  {
    alert('Please select second date');
    return ;
  }
  
  
  var data = "first_date="+first_date+"&second_date="+second_date+"&statusC="+statusC;

  url = '<?php echo base_url('admin/reports')?>' + "/perches_status_report";
  ajaxRequest.open("POST", url, true);
  ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
  ajaxRequest.send(data);
    // alert(url); return;

  ajaxRequest.onreadystatechange = function(){
    if(ajaxRequest.readyState == 4){
      // console.log(ajaxRequest.responseText); return;
      var resp = ajaxRequest.responseText;
      a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
      a.document.write(resp);
      // a.close();
    }
  }
}
  //low inventory report js function
 
function LP_AlP_Report (statusC){
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
      var data = "statusC="+statusC;

      url = '<?php echo base_url('admin/reports')?>' + "/low_inv_all_product_status_report";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);
        // alert(url); return;

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest.responseText); return;
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
          a.document.write(resp);
          // a.close();
        }
      }
}

function mobile_bill(status) { 
  console.table(status);
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();
  first_date = "";
  second_date = "";
  sql = "";
  
  var data = "first_date="+first_date+'&second_date='+second_date+'&sql='+sql;

  url = '<?php echo base_url('admin/reports')?>' + "/mobile_bill_report";

  ajaxRequest.open("POST", url, true);
  ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
  ajaxRequest.send(data);
  // alert(url); return;
  
  ajaxRequest.onreadystatechange = function(){
    if(ajaxRequest.readyState == 4){
      var resp = ajaxRequest.responseText;
      a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
      a.document.write(resp);
      // a.close();
    }
  }
}
</script>