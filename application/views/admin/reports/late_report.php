
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Employees Late Report </h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="process_date">First Date</label>
                  <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date" name="process_date" type="text" value="<?php echo date('Y-m-d');?>" required>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="process_date">Second Date</label>
                  <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="second_date" name="second_date" type="text" required>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="upload_file">Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="">Select one</option>
                    <option value="1">Regular</option>
                    <option value="2">Left</option>
                    <option value="3">Resign</option>
                    <option value="4">All</option>
                  </select>
                </div>
              </div>
              <div class="col-md-8" style="margin-left:-15px;">
                <div class="form-inline"> &nbsp;
                  <label for="first_name">&nbsp;</label>
                  <button class="btn btn-success btn-sm" onclick="show_report(1)">Dailys</button>&nbsp;&nbsp;
                  <button class="btn btn-success btn-sm" onclick="show_report(2)">Weekly</button>&nbsp;&nbsp;
                  <button class="btn btn-success btn-sm" onclick="show_report(3)">Continuously</button>
                </div>
              </div>
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
              <th class="" style="width:10%;background:#0177bcc2;color:white">Sl.</th>
              <th class=" text-center" style="background:#0177bc;color:white">Name</th>
              <!-- <th class=" text-center" style="background:#0177bc;color:white">Id</th> -->
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
  var url = "<?php echo base_url('admin/attendance/get_employee_ajax_request'); ?>";
  // Remove existing rows with id="removeTr"
  $('#fileDiv #removeTr').remove();

  $.ajax({
    url: url,
    type: 'GET',
    data: { "status": status },
    contentType: "application/json",
    dataType: "json",
    success: function (response) {
      arr = response.employees;
      if (arr.length != 0) {
        let i = 1;
        let items = "";

        arr.forEach(function (value, index) {
          items += '<tr id="removeTr">';
          items += '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' + value.emp_id + '" ></td>';
          items += '<td class="success">' + (i++) + '</td>';
          items += '<td class="warning ">' + value.first_name + ' ' + value.last_name + " (" +value.emp_id + ")" + '</td>';
          // items += '<td class="success">' + + '</td>';
          items += '</tr>';
        });
        // Append the new rows
        $('#fileDiv tr:last').after(items);
      }
    }
  });
});

});


function show_report(key){
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();
  status = document.getElementById('status').value;
  attendance_date = document.getElementById('process_date').value;
  second_date = document.getElementById('second_date').value;
  if(status ==''){
    alert('Please select status');
    return ;
  }
  if(second_date == ''){
    alert('Please select second date');
    return ;
  }
  var checkboxes = document.getElementsByName('select_emp_id[]');
  var sql = get_checked_value(checkboxes);
  if(sql ==''){
    alert('Please select employee Id');
    return ;
  }
  var data = "attendance_date="+attendance_date+"&second_date="+second_date+"&key="+key+"&status="+status+'&sql='+sql;
  url = base_url + "/show_late_report";
  ajaxRequest.open("POST", url, true);
  ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
  ajaxRequest.send(data);
  ajaxRequest.onreadystatechange = function(){
    if(ajaxRequest.readyState == 4){
      var resp = ajaxRequest.responseText;
      a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
      a.document.write(resp);
    }
  }
}
</script>

    