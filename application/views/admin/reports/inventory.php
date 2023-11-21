
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<style>
   option {
            background-color: white;
            color: black; /* Replace with your desired color */
            text-align :left;
        }
</style>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-6">

  <div class="box">
    <div class="box-body">
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
        <div class="col-md-4">
          <div class="form-group">
            <label for="upload_file">Status</label>
            <select class="form-control" name="status" id="status">
              <option value="">Select one</option>
              <option value="0">Regular</option>
              <option value="2">Left</option>
              <option value="3">Resign</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="box">
    <div class="box-body">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Inventory Report</a></li>
        <li><a data-toggle="tab" href="#tab2">Movement Report</a></li>
      </ul>

      <div class="tab-content">
        <div id="tab1" class="tab-pane fade in active" style="margin-top:20px">
          <button class="btn btn-sm btn-success" onclick="show_report('all')">All Report</button>
          <select class="btn btn-sm btn-success" style="margin-left:10px" id="mySelect">
            <option value="">Category Wise report </option>
              <?php
                $categories =$this->db->select('id,cat_name')->get('product_accessory_categories')->result(); 
                foreach($categories as $category){
              ?>
              <option value="<?php echo $category->id?>" onclick="show_report(2)"><?php echo $category->cat_name?></option>
              <?php }?>
          </select>
          <button class="btn btn-sm btn-success" style="margin-left:10px" onclick="show_report('using')">Employee using device</button><br><br>
          <button class="btn btn-sm btn-success" onclick="show_report('store')">Stored Report</button>
          <button class="btn btn-sm btn-success" style="margin-left:10px" onclick="show_report('damage')">Damaged Report</button>
        </div>
        <div id="tab2" class="tab-pane fade"  style="margin-top:20px">
        <button class="btn btn-sm btn-success" onclick="move_report('daily')">Daily Report</button>
        <button class="btn btn-sm btn-success" style="margin-left:10px" onclick="move_report('weekly')">Weekly Report</button>
        <button class="btn btn-sm btn-success" style="margin-left:10px" onclick="move_report('monthly')">Monthly Report</button>
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
        var i = 1;
        var items = '';
        $.each(arr, function (index, value) {
          items += '<tr id="removeTr">';
          items += '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' + value.emp_id + '" ></td>';
          items += '<td class="success">' + (i++) + '</td>';
          items += '<td class="warning ">' + value.first_name + ' ' + value.last_name + " (" +value.emp_id + ")" + '</td>';
          items += '</tr>';
        });
        $('#fileDiv tr:last').after(items);
        }
      }
    });
  });
});
$("#mySelect").on("change", function () {
  var selectedValue = $(this).val();
  show_report(selectedValue);
});
function show_report(r){
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();
  var status = $('#status').val();
  var first_date = $('#process_date').val();
  var second_date = $('#second_date').val();
  var checkboxes = document.getElementsByName('select_emp_id[]');
  var sql = get_checked_value(checkboxes);

  if(status =='' && r =='using'){
    alert('Please select status');
    return ;
  }
  if(status !='' && r =='using' && sql ==''){
    alert('Please select employee id');
    return ;
  }

  var data = "first_date="+first_date+"&second_date="+second_date+"&status="+r+'&sql='+sql;
  url = base_url + "/show_inventory_report";
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

function move_report(r){
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();
  var status = $('#status').val();
  var first_date = $('#process_date').val();
  var second_date = $('#second_date').val();
  var checkboxes = document.getElementsByName('select_emp_id[]');
  var sql = get_checked_value(checkboxes);

  if(status =='' && r =='using'){
    alert('Please select status');
    return ;
  }
  if(status !='' && r =='using' && sql ==''){
    alert('Please select employee id');
    return ;
  }

  var data = "first_date="+first_date+"&second_date="+second_date+"&status="+r+'&sql='+sql;
  url = base_url + "/show_move_report";
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


<script>
  $(document).ready(function () {
      $("#mySelect").on("change", function () {
        $(this).prop("selectedIndex", "");
      });
  });
</script>