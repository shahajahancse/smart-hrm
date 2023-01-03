<!-- < ?php
$dept_names = $this->db->select('department_name')->from('xin_departments')->get()->result();
$desig_names = $this->db->select('designation_name')->from('xin_designations')->get()->result();
?> -->

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
  <form class="">
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
  <div class="form-group col-lg-6">
    <label>Time</label>
    <input type="" class="form-control timepicker clear-1" placeholder="Selcet Time HH:MM">
  </div>

  <div class="col-lg-12">
  <button type="submit" class="btn btn-sm btn-success" id="btn" style="padding: 6px 10px !important;margin-right:16px">Submit</button>
  </div>
</form>

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

     $('#btn').on('click',function(e){
      e.preventDefault();
      status = document.getElementById('status').value;
      if(status == '')
      {
        alert('Please select status');
        return;
      }
      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      if(sql =='')
      {
        alert('Please select employee Id');
        return ;
      }
      alert(sql);
     });

    });
</script>
