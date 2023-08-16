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
          <div class="col-md-6">
            <div class="form-group">
              <label for="process_date">First Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date" name="process_date" type="text" autocomplete="off">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="process_date">Second Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="second_date" name="second_date" type="text" autocomplete="off">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border" id="report_title">
    <h3 class="box-title" id="report">  Report</h3>
  </div>

  <div class="box-body" id="emp_report">
    <ul class="nav nav-tabs " id="myTab" role="tablist">
      <li class="nav-item active">
        <a class="nav-link " id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Requsition</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Purchase</a>
      </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab" style="margin-top: 30px;">
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(1)">Pending</button>
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(2)">Approved</button>
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(4)">Reject</button>
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(3)">Delivered Item</button>
      </div>
      <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab" style="margin-top: 30px;">
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(1)">Pending</button>
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(2)">Approved</button>
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(4)">Reject</button>
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(3)">Receive</button>
        <button class="btn btn-info btn-sm"  onclick="LP_AlP_Report(7)">Low inventory</button>
        <button class="btn btn-info btn-sm"  onclick="LP_AlP_Report(8)">All Products</button>
      </div>
    </div>
  </div>

  <div  class="box-body" id="entry_form"></div>

</div>
</div>



<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script>
  $(document).ready(function(){

    // $('#manu_form').hide();
    $("#manually_entry").click(function(){
      $('#emp_report').hide();
   
      $('#report_title').hide();
      $("#entry_form").load("<?php echo base_url()?>"+"admin/attendance/manually");
    });

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
              items += '<td class="warning ">'+value.first_name +' '+ value.last_name +'</td>';
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




