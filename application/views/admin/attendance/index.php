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
          <div class="col-md-3">
            <div class="form-group">
              <label for="process_date">First Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date" name="process_date" type="text" value="<?php echo date('Y-m-d');?>" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="process_date">Second Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="second_date" name="second_date" type="text">
            </div>
          </div>

          <div class="col-md-3">
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

          <div class="col-md-3">
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
    <h3 class="box-title"> Employee Report
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
          <button class="btn btn-sm mr-5" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="daily_report('Present')">Present Report</button>
          <button class="btn btn-sm mr-5" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="daily_report('Absent')"> Absent Report</button>
          <button class="btn btn-sm mr-5" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="daily_report('Present',1)">Late Report</button>
          <button class="btn btn-sm mr-5" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;">Lunch In/Out</button>
          <button class="btn btn-sm mr-5" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;">Lunch Late</button>
          <button class="btn btn-sm mr-5" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;">Early Out</button>
      </div>

      <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab" style="margin-top: 30px;">
          <button class="btn btn-success" onclick="jobCard()">Job Card</button>

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
      <th class="active" style="width:10%"><input type="checkbox" id="select_all" class="select-all checkbox" name="select-all" /></th>
      <th class="" style="width:10%;background:#0177bcc2;color:white">Id</th>
      <th class=" text-center" style="background:#0177bc80;color:white">Name</th>
  </tr>
</table>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script>
  $(document).ready(function(){
    // select all item or deselect all item
    $("#select_all").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

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
              items += '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="'+value.emp_id+'" ></td>';
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


