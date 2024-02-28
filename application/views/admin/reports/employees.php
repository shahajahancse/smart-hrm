
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
  <div class="col-md-7">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Employees Report </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="process_date">First Date</label>
                    <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date" name="process_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="process_date">Second Date</label>
                  <input class="form-control attendance_date" placeholder="Second Date" id="second_date" name="second_date" type="text" autocomplete="off">
                </div>
              </div>
              <!-- <div class="col-md-3">
                <div class="form-group">
                  <label for="upload_file">Type</label>
                  <select class="form-control" name="type" id="type">
                    <option value="">Select one</option>
                    <option value="1">Regular</option>
                    <option value="4">Intern</option>
                    <option value="5">Probation</option>
                  </select>
                </div>
              </div> -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="upload_file">Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="">Select one</option>
                    <option value="0">Regular</option>
                    <!-- <option value="1">Regular</option> -->
                    <option value="2">Left</option>
                    <option value="3">Resign</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
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

              <button class="btn dbtn btn-sm " onclick="show_report(1)">Employee Joining List</button>
              <button class="btn dbtn btn-sm" onclick="show_report(7,1)">All Increment List</button>
              <button class="btn dbtn btn-sm" onclick="show_report(2,1)">Increment</button>
              <button class="btn dbtn btn-sm" onclick="salary_review_report()">Salary Review</button>
              <button class="btn dbtn btn-sm" onclick="show_report(3,1)">Promotion</button>
              <button class="btn dbtn btn-sm" onclick="show_report(1,1)">Probation to Regular</button>
              <button class="btn dbtn btn-sm" onclick="show_report(4,1)">Intern to Probation</button>
              <button class="btn dbtn btn-sm" onclick="show_report(5,1)">Intern to Regular</button>

              <button class="btn btn-success btn-sm" onclick="show_report(5)">Using Device</button>
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


  <div class="col-lg-5">
    <div class="box" style="height: 74vh;overflow-y: scroll;">
      <table class="table table-striped table-hover" id="fileDiv">
        <tr style="position: sticky;top: 0;z-index:1">
            <th class="active" style="width:10%"><input type="checkbox" id="select_all" class="select-all checkbox" name="select-all" /></th>
            <th class="" style="width:10%;background:#0177bcc2;color:white">Id</th>
            <th class=" text-center" style="background:#0177bc;color:white">Name</th>
        </tr>
      </table>
    </div>
  </div>
</div>





<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script>
  $(document).ready(function(){

      $("#select_all").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
      });

      // on load employee
    $("#status").change(function () {
      status = document.getElementById('status').value;
      var url = "<?php echo base_url('admin/reports/get_employeess'); ?>";
      $("#select_all").prop("checked", false);
      $('#fileDiv .removeTr').remove();

      $.ajax({
        url: url,
        type: 'GET',
        data: { "status": status },
        contentType: "application/json",
        dataType: "json",
        success: function (response) {
          arr = response.employees;
          if (arr.length != 0) {
            var i = 1;
            var items = '';
            $.each(arr, function (index, value) {
              items += '<tr class="removeTr">';
              items += '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' + value.emp_id + '" ></td>';
               items += '<td class="success">' + (i++) + '</td>';
              items += '<td class="warning ">' + value.first_name + ' ' + value.last_name + " (" +value.emp_id + ")" + '</td>';
              items += '</tr>';
            });
            // Append the new rows
            $('#fileDiv tr:last').after(items);
          }
        }
      });
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