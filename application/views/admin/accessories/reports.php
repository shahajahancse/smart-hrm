<?php 
$session = $this->session->userdata('username');
$get_animate = $this->Xin_model->get_content_animate();
$role_resources_ids = $this->Xin_model->user_role_resource(); 
?>
<div class="box <?php echo $get_animate;?>">
<div class="col-lg-12">
<div id="loader" align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;"><img src="http://localhost/smart-hrm//uploads/ajax-loader.gif"></div>
<div class="box animated fadeInRight">
  <div class="box-header with-border" id="report_title">
    <h3 class="box-title" id="report">Report</h3>
  </div>
  <div class="box-body" id="emp_report">
    <div class="row"> 
      <div class="col-md-3">
        <div class="form-group">
          <label for="process_date">First Date</label>
          <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="first_date" name="first_date" type="text" value="<?php echo date('Y-m-d');?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="process_date">Second Date</label>
          <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="second_date" name="second_date" type="text" autocomplete="off">
        </div>
      </div>
      <div class="col-md-3"  >
        <label for="Status">Select Status</label>
        <select class="form-control" id='status'>  
          <option value="" selected>Select Status</option>
          <option value="1" >On Working</option>
          <option value="2" >Store</option>
          <option value="3" >Servicing</option>
          <option value="4" >Destroy</option>
        </select>
      </div>
      <div class="col-md-3">
        <label for="Status">Select Category</label>
        <select class="form-control" id='category'>  
          <option value="" selected>Select Category</option>
            <?php $category = $this->db->select('*')->get('product_accessory_categories')->result(); foreach($category as $row){?>
              <option value="<?= $row->id?>" ><?= $row->cat_name?></option>
            <?php }?>
        </select>
      </div> 
    </div>

    <div class="row">
      <div class="col-md-3">
        <label for="Status">User Name</label>
        <select class="form-control" id='users'>  
          <option value="" disabled selected>Select User</option>
            <?php $users = $this->db->select('user_id,first_name,last_name')->get('xin_employees')->result(); foreach($users as $user){?>
              <option value="<?= $user->user_id?>" ><?= $user->first_name.''.$user->last_name?></option>
            <?php }?>
        </select>
      </div> 
    </div>

    <br>
    <hr>
    <div class="container">
      <button class="btn btn-primary"  style="" onclick="inventory_report(1)">All Report</button>
      <button class="btn btn-info"  style="" onclick="inventory_report(2)">Report</button>
      <button class="btn btn-info"  style="" onclick="user_report(1)">Single User Report</button>
      <button class="btn btn-primary"  style="" onclick="user_report(2)">All User's Report</button>
    </div>
    <br>
    <br>
    <br>
  </div>
</div>
  
</div>
</div>

<script>
  $(document).ready(function() {
    $('process_date').datepicker();
    $('#example').DataTable();
  });

  function inventory_report(report){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest     = new XMLHttpRequest();
    var first_date  = $('#first_date').val();
    var second_date = $('#second_date').val();
    var status      = $('#status').val();
    var category    = $('#category').val();
    
    // alert(first_date+" === " +second_date+" ==== "+status+"==="+category);return false;
    if(report == 1 && status == null){
      alert('Please select status');
      return;
    }
    if(report == 1 && category == null){
      alert('Please select categroy');
      return;
    }
    // console.log(data); return;
    var data = "first_date="+first_date+"&second_date="+second_date+"&status="+status+'&category='+category;

    // alert(data);return false;

    url = base_url + "/inventory_report/"+report+"?"+data;
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp);
      }
    }
  }


    function user_report(report){
    var ajaxRequest; 
    ajaxRequest     = new XMLHttpRequest();

    var user_id = $('#users').val();
    
    if(report==1 && user_id==null){
      alert('Please select user name');
      return;
    }
    // alert(user_id);return;
    if(report == 1){
      var data = "user_id="+user_id;
    } else{
      var data = "user_id="+ null;
    }

    url = base_url + "/user_report?"+data;
    ajaxRequest.open("GET", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp);
      }
    }



  }    
</script>
