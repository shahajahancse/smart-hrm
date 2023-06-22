
<?php 
// dd($row);
$session = $this->session->userdata('username');
$eid = $this->uri->segment(4);
$get_animate = $this->Xin_model->get_content_animate();
$role_resources_ids = $this->Xin_model->user_role_resource(); 
?>

<div class="box <?php echo $get_animate;?>">
<div class="col-lg-8">


<div id="loader" align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;"><img src="http://localhost/smart-hrm//uploads/ajax-loader.gif"></div>

<div class="box animated fadeInRight">
  <div class="box-header with-border" id="report_title">
    <h3 class="box-title" id="report">Report</h3>
    <!-- <div class="col-md-4" style="float:right">
    <div class="form-group" >
        <select class="form-control" name="status" id="status">
        <option value="">Select Status</option>
        <option value="1">regular</option>
        <option value="2">left</option>
        <option value="3">resign</option>
        </select>
    </div>
    </div> -->
</div>
  <div class="box-body" id="emp_report">
    <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item active">
          <a class="nav-link " id="working-tab" data-toggle="tab" href="#working" role="tab" aria-controls="working" aria-selected="true">On Working</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="stock-tab" data-toggle="tab" href="#stock" role="tab" aria-controls="stock" aria-selected="false">Stock</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="servising-tab" data-toggle="tab" href="#servising" role="tab" aria-controls="servising" aria-selected="false">Servising</a>
        </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade active in" id="working" role="tabpanel" aria-labelledby="working-tab" style="margin-top: 30px;">
            <button class="btn btn-info btn-sm mt-2" style="margin-right:5px" onclick="inventory_report('all')">All Employee Report</button>
          <!-- <button class="btn btn-sm mr-5 btn-success" onclick="latecomment('latecomment')">Id Wise Report</button> -->
        </div>

        <div class="tab-pane fade" id="stock" role="tabpanel" aria-labelledby="stock-tab" style="margin-top: 30px;">
            <!-- <button class="btn btn-sm btn-danger"> Button one</button>-->
            <button class="btn btn-sm mr-5 sbtn mt-2" onclick="monthly_report()">Monthly Register Report</button> 
        </div>

        <div class="tab-pane fade" id="servising" role="tabpanel" aria-labelledby="servising-tab" style="margin-top: 30px;">
            <button class="btn btn-sm mr-5 sbtn mt-2" onclick="jobCard()">Job Card</button>
        </div>

    </div>

  </div>

</div>
</div>


<div class="col-lg-4">
<div class="box" style="height: 74vh;overflow-y: scroll;">
<table class="table table-striped table-hover" id="fileDiv">
  <tbody><tr style="position: sticky;top: 0;z-index:1">
      <th class="active" style="width:10%"><input type="checkbox" id="select_all" class="select-all checkbox" name="select-all"></th>
      <th class="" style="width:10%;background:#0177bcc2;color:white">Id</th>
      <th class=" text-center" style="background:#0177bc;color:white">Name</th>
  </tr>
</tbody></table>
</div>
</div>
</div>

 
<script>

  $(document).ready(function() {
    $('#example').DataTable();
  });



    function inventory_report(status)
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
    
      // console.log(data); return;
       var data = "status="+status;
      url = base_url + "/inventory_report";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
          a.document.write(resp);
        }
      }
    }

</script>
