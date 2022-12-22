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
          <div class="col-md-4">
            <div class="form-group">
              <label for="process_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date" name="process_date" type="text" value="<?php echo date('Y-m-d');?>" required>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="upload_file">status</label>
              <select class="form-control" name="status" id="status">
                <option value="8">Select one</option>
                <option value="1">regular</option>
                <option value="2">left</option>
                <option value="3">resign</option>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group"> &nbsp;
              <label for="first_name">&nbsp;</label><br />
              <button class="btn btn-success" onclick="attn_process()">Process</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="loader"  align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;"><img src="<?php echo base_url();?>/uploads/ajax-loader.gif" /></div>

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> Attendence Report
      <!-- < ?php echo $this->lang->line('xin_daily_attendance_report');?> -->
   </h3>
  </div>
  <div class="box-body">
      <ul class="nav nav-tabs " id="myTab" role="tablist">
      <li class="nav-item active">
        <a class="nav-link " id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Daily</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Monthly</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="continuously-tab" data-toggle="tab" href="#continuously" role="tab" aria-controls="continuously" aria-selected="false">Continuously</a>
      </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab" style="margin-top: 30px;">
          <button class="btn btn-sm" style="background: #2393e3eb; color: white;" onclick="daily_present_report('Present')">Present Report</button>
          <button class="btn btn-sm" style="background: #2393e3eb; color: white;"> Button two</button>
          <button class="btn btn-sm" style="background: #2393e3eb; color: white;"> Button three</button>
          <button class="btn btn-sm" style="background: #2393e3eb; color: white;"> Button four</button>
          <button class="btn btn-sm" style="background: #2393e3eb; color: white;"> Button five</button>
          <button class="btn btn-sm" style="background: #2393e3eb; color: white;"> Button six</button>
          <button class="btn btn-sm" style="background: #2393e3eb; color: white;"> Button seven</button>
          <button class="btn btn-sm" style="background: #2393e3eb; color: white;"> Button eight</button>
      </div>

      <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab" style="margin-top: 30px;">
        <button class="btn btn-sm btn-danger"> Button one</button>
        <button class="btn btn-sm btn-danger"> Button two</button>
        <button class="btn btn-sm btn-danger"> Button three</button>
        <button class="btn btn-sm btn-danger"> Button four</button>
        <button class="btn btn-sm btn-danger"> Button five</button>
        <button class="btn btn-sm btn-danger"> Button six</button>
        <button class="btn btn-sm btn-danger"> Button seven</button>
        <button class="btn btn-sm btn-danger"> Button eight</button>
      </div>

      <div class="tab-pane fade" id="continuously" role="tabpanel" aria-labelledby="continuously-tab" style="margin-top: 30px;">
        <button class="btn btn-sm btn-info"> Button one</button>
        <button class="btn btn-sm btn-info"> Button two</button>
        <button class="btn btn-sm btn-info"> Button three</button>
        <button class="btn btn-sm btn-info"> Button four</button>
        <button class="btn btn-sm btn-info"> Button five</button>
        <button class="btn btn-sm btn-info"> Button six</button>
        <button class="btn btn-sm btn-info"> Button seven</button>
        <button class="btn btn-sm btn-info"> Button eight</button>
      </div>

    </div>
  </div>



</div>
</div>

<div class="col-lg-4">
<div class="box" style="height: 74vh;overflow-y: scroll;">
<table class="table table-striped" id="fileDiv">
  <tr>
      <th class="active" style="width:10%"><input type="checkbox" class="select-all checkbox" name="select-all" /></th>
      <th class="success" style="width:10%">Id</th>
      <th class="warning text-center">Name</th>
  </tr>
</table>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script>
  $(document).ready(function(){
    // on load employee
    $("#status").change(function(){
      status = document.getElementById('status').value;
      var url = "<?php echo base_url('admin/attendance/get_employee_ajax_request'); ?>";
      $.ajax({
        url: url,
        type: 'GET',
        data: {"status":status},
        contentType: "application/json",
        dataType: "json",


        success: function(response){
          arr = response.employees;
          if (arr.length != 0) {
            var items = '';
            $.each(arr, function(index,value) {
              items += '<tr id="removeTr">';
              items += '<td><input type="checkbox" class="select-item checkbox" name="select-item" value="'+value.emp_id+'" ></td>';
              items += '<td class="success">'+value.emp_id+'</td>';
              items += '<td class="warning text-center">'+value.first_name +' '+ value.last_name +'</td>';
              items += '</tr>';
            });
            // console.log(items);
            $('#fileDiv tr:last').after(items);
          } else {
            $('#fileDiv #removeTr').remove();
          }
        }
      });
    });
  });
</script>
<script>
    $(function(){
      //button select all or cancel
      $("#select-all").click(function () {
          var all = $("input.select-all")[0];
          all.checked = !all.checked
          var checked = all.checked;
          $("input.select-item").each(function (index,item) {
              item.checked = checked;
          });
      });

      //column checkbox select all or cancel
      $("input.select-all").click(function () {
          var checked = this.checked;
          $("input.select-item").each(function (index,item) {
              item.checked = checked;
          });
      });
    });
</script>

