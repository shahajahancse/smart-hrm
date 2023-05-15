<!-- < ?php
$dept_names = $this->db->select('department_name')->from('xin_departments')->get()->result();
$desig_names = $this->db->select('designation_name')->from('xin_designations')->get()->result();
?> -->
<?php $session = $this->session->userdata('username');?>
<span class="h4" id="manu_form">Manually Entry Form</span>
<button id="back_report" class="btn btn-sm btn-primary col-6"  style="float:right;padding: 6px 10px !important;">Back Report</button>

<div id="form_manually" style="margin-top:30px">


<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item active">
    <a class="nav-link active" id="insert-tab" data-toggle="tab" href="#insert" role="tab" aria-controls="insert" aria-selected="true">Insert</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="delete-tab" data-toggle="tab" href="#delete" role="tab" aria-controls="delete" aria-selected="false">Delete</a>
  </li>

</ul>



<div class="tab-content" id="myTabContent" style="margin-top:20px">
  <div class="tab-pane fade active in" id="insert" role="tabpanel" aria-labelledby="insert-tab">
    <!-- <div class="form-group col-lg-6">
      <label>Department</label>
      <select class="form-control" >
          <option value="">Select Department</option>
          < ?php foreach($dept_names as $dept_name){?>
          <option value="">< ?php echo $dept_name->department_name?></option>
          < ?php }?>
      </select>
    </div> -->
    <!-- <div class="form-group col-lg-6">
      <label>Designation</label>
      <select class="form-control" >
          <option value="">Select Designation</option>
          < ?php foreach($desig_names as $desig_name){?>
          <option value="">< ?php echo $desig_name->designation_name?></option>
          < ?php }?>
      </select>
    </div> -->
    <div class="row">
      <?php $attributes = array('id' => 'manual_attendance', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
      <?php $hidden = array('user_id' => $session['user_id']);?>
      <?php echo form_open('admin/attendance/manual_attendance', $attributes, $hidden);?>
        <p style="padding: 0px 15px;" id="checked_value">Attendance Insert
          <span style="padding: 0px 20px"><label >Punch Miss</label> <input checked type="radio" name="check_value" value="0"></span>
          <span><label >Meeting</label> <input class="" type="radio" name="check_value" value="1">
          </span>
        </p>

        <div class="form-group col-lg-3">
          <label>In Time</label>
          <input type="text" name="in_time" id="in_time" class="form-control timepicker clear-1" placeholder="HH:MM">
        </div>
        <div class="form-group col-lg-3">
          <label>Out Time</label>
          <input type="text" name="out_time" id="out_time" class="form-control timepicker clear-1" placeholder="HH:MM">
        </div>
        <div class="col-lg-6" id="reason">
          <div class="form-group">
            <label>Reason</label>
            <textarea type="text" id="reason_value" class="form-control" name="reason"></textarea>
          </div>
        </div>

        <div class="col-lg-12">
        <button type="submit" class="btn btn-sm btn-success" style="padding: 6px 10px !important;margin-right:16px">Submit</button>
        </div>
      </form>
    </div>
  </div>


  <div class="tab-pane fade" id="delete" role="tabpanel" aria-labelledby="delete-tab">

    <div class="form-group col-lg-6">
      <button type="submit" class="btn btn-sm btn-success" style="padding: 6px 10px !important;margin-right:16px;margin-top:5px">Weekend Delete</button>
  </div>

  <div class="form-group col-lg-6">
      <button type="submit" class="btn btn-sm btn-success" style="padding: 6px 10px !important;margin-right:16px;margin-top:5px">Holiday Delete</button>
  </div>

  </div>
</div>


</div>

<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script>

    $(document).ready(function(){
        $('#reason').hide();

        $('.clockpicker').clockpicker();
            var input = $('.timepicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            'default': 'now'
        });

        $("#back_report").click(function(){
            $('#emp_report').show();
            $('#report_title').show();
            $("#back_report").hide();   
            $('#manu_form').hide();
            $("#form_manually").hide();
        });

        $("#checked_value").click(function(){
          var value = document.querySelector("input[type='radio'][name=check_value]:checked").value;
          if (value == 1) {
            $('#reason').show();
          } else {
            $('#reason').hide();
          }
          // alert(value);
        });

        // manual attendance
      $("#manual_attendance").on('submit', function(e) {

        var ajaxRequest;  // The variable that makes Ajax possible!
        ajaxRequest = new XMLHttpRequest();

        var url = "<?php echo base_url('admin/attendance/manual_attendance'); ?>";
        e.preventDefault();

        status = document.querySelector("input[type='radio'][name=check_value]:checked").value;
        date = document.getElementById('process_date').value;
        in_time = document.getElementById('in_time').value;
        out_time = document.getElementById('out_time').value;
        reason = document.getElementById('reason_value').value;

        var emp_id = document.getElementsByName('select_emp_id[]');
        var sql = get_checked_value(emp_id);
        // alert(sql); return;
         
        if(sql == ''){
          alert('Please select employee Id');
          return ;
        }

        var okyes;
        okyes=confirm('Are you sure you want to Insert?');
        if(okyes==false) return;

        var data = "date="+date+"&in_time="+in_time+"&out_time="+out_time+"&reason="+reason+"&sql="+sql+"&status="+status;


        ajaxRequest.open("POST", url, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
        ajaxRequest.send(data);

        ajaxRequest.onreadystatechange = function(){
          if(ajaxRequest.readyState == 4){
            // console.log(ajaxRequest);
            var resp = ajaxRequest.responseText;
            alert(resp);
            // a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
            // a.document.write(resp);
          }
        }

      });
    });
</script>
