
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<style>
  .breadcrumb {
       margin-bottom: 0px !important; 
  }
  .dbtn {
    background: #0177bc !important;
    color: #fff !important;
  }
</style>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-8">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Employees Report </h3>
      </div>
      <div class="box-body">
      <?php   $this->load->view('admin/filter'); ?>
      </div>
    </div>
    <div class="box">
      <div class="box-body">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#tab1">Employees Report</a></li>
          <li><a data-toggle="tab" href="#tab2">Movement</a></li>
        </ul>

        <div class="tab-content">
          <div id="tab1" class="tab-pane fade in active">
            <div class="form-group" style="margin-top:20px; margin-top: 20px; display: flex; flex-wrap: wrap; gap: 5px;">

              <button class="btn dbtn btn-sm " onclick="employee_summary()">Employee summary</button>
              <button class="btn dbtn btn-sm " onclick="date_active_inactive_report()">Employee Active/Inactive List</button>
              <button class="btn dbtn btn-sm " onclick="show_report(1)">Employee Joining List</button>
              <button class="btn dbtn btn-sm " onclick="employee_regular_report()">Regular List</button>
              <button class="btn dbtn btn-sm" onclick="show_report(7,1)">All Increment List</button>
              <button class="btn dbtn btn-sm" onclick="show_report(2,1)">Increment</button>
              <button class="btn dbtn btn-sm" onclick="salary_review_report()">Salary Review</button>
              <button class="btn dbtn btn-sm" onclick="show_report(3,1)">Promotion</button>
              <button class="btn dbtn btn-sm" onclick="show_report(1,1)">Probation to Regular</button>
              <button class="btn dbtn btn-sm" onclick="show_report(4,1)">Intern to Probation</button>
              <button class="btn dbtn btn-sm" onclick="show_report(5,1)">Intern to Regular</button>
              <button class="btn dbtn btn-sm" onclick="employee_increment()">Single Increment/Promotion List</button>
              <button class="btn btn-success btn-sm" onclick="show_report(5)">Using Device</button>
              <button class="btn btn-success btn-sm" onclick="holyday_list()">Holidays</button>
            </div>
          </div>
          <div id="tab2" class="tab-pane fade">
                <div class="form-group" style="margin-top:20px">
                  <button class="btn btn-success btn-sm"  style="margin-right:10px" onclick="show_meeting_report(1)">Dailys</button>
                  <button class="btn btn-success btn-sm"  style="margin-right:10px" onclick="show_meeting_report(2)">Weekly</button>
                  <button class="btn btn-success btn-sm"  style="margin-right:10px" onclick="show_meeting_report(3)">Monthly</button>
                </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
  <?php   $this->load->view('admin/filtered_data'); ?>
  </div>
</div>





<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script>
  $(document).ready(function(){

      $("#select_all").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
      });
  });

  function show_report(r, done){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    status = document.getElementById('status').value;
    first_date = document.getElementById('process_date').value;
    second_date = document.getElementById('second_date').value;
    if(status ==''){
      alert('Please select status');
      return ;
    }

    if(r == 2 ){
      if(first_date ==''){
        alert('Please select first date');
        return ;
      }
      if(second_date ==''){
        alert('Please select second date');
        return ;
      }
    }

    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);
    if(sql ==''){
      alert('Please select employee Id');
      return ;
    }
    var data = "first_date="+first_date+"&second_date="+second_date+"&status="+r+'&sql='+sql+'&done='+done;
    url = base_url + "/show_report";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest);
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp);
      }
    }
  }
  function employee_summary(){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    status = document.getElementById('status').value;

    if(status ==''){
      alert('Please select status');
      return ;
    }
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);
    if(sql ==''){
      alert('Please select employee Id');
      return ;
    }
    var data = "sql="+sql;
    url = base_url + "/get_employee_summary";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest);
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp);
      }
    }
  }
  function employee_regular_report(){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    first_date = document.getElementById('process_date').value;
    if(first_date ==''){
      alert('Please select status');
      return ;
    }
    var data = "first_date="+first_date;
    url = base_url + "/employee_regular_report";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest);
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp);
      }
    }
  }
  function holyday_list(){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    first_date = document.getElementById('process_date').value;
    if(first_date ==''){
      alert('Please select status');
      return ;
    }
    var data = "first_date="+first_date;
    url = base_url + "/holyday_list";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest);
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp);
      }
    }
  }
  function employee_increment(){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    status = document.getElementById('status').value;
    if(status ==''){
      alert('Please select status');
      return ;
    }
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);
    if(sql ==''){
      alert('Please select employee Id');
      return ;
    }
    let array = sql.split(",");
    if(array.length!= 1){
      alert('Please select only one employee');
      return
    };
    var data = "sql="+sql;
    url = base_url + "/employee_increment";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest);
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp);
      }
    }
  }
  function salary_review_report(){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    status = document.getElementById('status').value;
    first_date = document.getElementById('process_date').value;
    second_date = document.getElementById('second_date').value;
    if(status ==''){
      alert('Please select status');
      return ;
    }

 
      if(first_date ==''){
        alert('Please select first date');
        return ;
      }
      if(second_date ==''){
        alert('Please select second date');
        return ;
      }
    

    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);
    if(sql ==''){
      alert('Please select employee Id');
      return ;
    }
    var data = "first_date="+first_date+"&second_date="+second_date+'&sql='+sql
    url = base_url + "/salary_review_report";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest);
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp);
      }
    }
  }
  function date_active_inactive_report(){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    status = document.getElementById('status').value;
    first_date = document.getElementById('process_date').value;
    second_date = document.getElementById('second_date').value;
    if(status ==''){
      alert('Please select status');
      return ;
    }

 
      if(first_date ==''){
        alert('Please select first date');
        return ;
      }
      if(second_date ==''){
        alert('Please select second date');
        return ;
      }
    

    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);
    if(sql ==''){
      alert('Please select employee Id');
      return ;
    }
    var data = "first_date="+first_date+"&second_date="+second_date+'&sql='+sql
    url = base_url + "/date_active_inactive_report";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest);
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp);
      }
    }
  }

  function show_meeting_report(key){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    status = document.getElementById('status').value;
    attendance_date = document.getElementById('process_date').value;
    if(status ==''){
      alert('Please select status');
      return ;
    }
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);
    if(sql ==''){
      alert('Please select employee Id');
      return ;
    }
    if(attendance_date ==''){
      alert('Please select date');
      return ;
    }
    var data = "a_date="+attendance_date+"&status="+status+'&sql='+sql+"&key="+key;
    url = base_url + "/show_meeting_report";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest);
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
        a.document.write(resp);
      }
    }
  }
</script>