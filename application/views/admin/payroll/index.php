<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<link rel="stylesheet" href="<?php echo base_url() ?>skin/hrsale_assets/css/loader.css">

<div class="col-lg-8">
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-7">
            <div class="form-group">
              <br>
              <label>Select Month and Year :</label>
              <select id='sal_month' onchange="chenge_s()">
                <?php 
                  $year = date('Y');
                  for($i=1; $i<=12;$i++)
                  {
                    $month = date( 'F', mktime(0, 0, 0, $i, 1, $year) );
                    $month_numeric =  date( 'm', mktime(0, 0, 0, $i, 1, $year) );
                    $current_month = date('m');
                    if($current_month == $month_numeric){
                    ?>
                      <option value="<?php echo $month_numeric;?>" selected="selected"><?php echo $month;?></option>
                    <?php
                    }else{
                    ?>
                      <option value="<?php echo $month_numeric;?>" ><?php echo $month;?></option>
                    <?php
                    }
                  }
                ?>
              </select>
              <select id='sal_year'  onchange="chenge_s()">
                <?php
                  $current_year = date('Y');
                  for($i = $current_year-10; $i <= $current_year + 10; $i++)
                  {
                    if($current_year == $i){
                    ?>
                      <option value="<?php echo $i;?>" selected="selected"><?php echo $i;?></option>
                    <?php
                    }else{
                    ?>
                      <option value="<?php echo $i;?>" ><?php echo $i;?></option>
                    <?php
                    }
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <br/>
              <span ><b>Status:</b></span>
              <select   name="status" id="status">
                <option value="">Select one</option>
                <option value="1">Active</option>
                <option value="2">Inactive</option>
                <!-- <option value="3">resign</option> -->
              </select>
            </div>
          </div>

          <div class="col-md-1">
            <div class="form-group"> 
              <button style="margin-top:15px;margin-left: -70px;" class="btn btn-success" onclick="salary_process()">Process</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- modal -->
<div class="modal fade bd-example-modal-lg" id="my_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button  type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modify Employee Salary</h4>
      </div>
  


      <div class="modal-body">
      

            <form  id="salaryForm">
                <div id="total" class="col-md-12" style="display: inline-flex;"> 
              </div>
              <div class="col-md-12" style="display: inline-flex;margin-bottom: -16px;"> 
                        <div class="form-group col-md-3">
                          <label style="margin-left: -22px;">Employee name</label>
                        </div>
                        
                        
                        <!-- hh -->
                        <div class="form-group col-md-2">
                          <label>Basic Salary</label>
                        </div>
                        <div class="form-group col-md-1" style="padding: 0;text-align-last: center;">
                          <label>Late</label>
                          </div>
                        <div class="form-group col-md-1" style="padding: 0;text-align-last: center;">
                          <label >d day</label>
                          </div>
                        
                        <div class="form-group col-md-2" style="padding: 0;text-align-last: center;">
                          <label>L Deduct</label>
                        </div>
                        <div class="form-group col-md-1" style="padding: 0;text-align-last: center;">
                          <label style="margin-left: 16px;">m day</label>
                        </div>
                        <!-- hh -->
                        
                        
                        <div class="form-group col-md-2">
                          <label style="margin-left: 27px;">Modify</label>
                        </div>
              </div>
                 <div id="empfrom"></div>
            <div class="modal-footer" >
                <button type="button" name="btn" onclick=save_modify_salary() class="btn btn-sm btn-success" style="margin-top:10px !important">Save</button>
                <button type="button" class="btn btn-sm btn-danger" style="margin-top:10px !important" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>

    </div>
    
  </div>
</div>
<!-- modal close -->


<div id="loader"  align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;"><img src="<?php echo base_url();?>/uploads/ajax-loader.gif" /></div>

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border" id="report_title">
    <h3 class="box-title" id="report"> Salary Report
      <!-- < ?php echo $this->lang->line('xin_daily_attendance_report');?> -->
   </h3>
     <button onclick=modify_salary()  class="btn btn-sm btn-primary pull-right" style="padding: 6px 10px !important;">Modify Salary</button>
     <a href="<?= base_url('admin/payroll/bank_salary_config') ?>" class="btn btn-sm btn-primary pull-right" style="padding: 6px 10px !important;margin: 0 9px;">Bank salary configuration</a>
  </div>

  <div class="box-body" id="emp_report">
    <ul class="nav nav-tabs " id="myTab" role="tablist">
        <li class="nav-item active">
          <a class="nav-link " id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Report</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Excel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="continuously-tab" data-toggle="tab" href="#continuously" role="tab" aria-controls="continuously" aria-selected="false">Continuously</a>
        </li>
    </ul>
    <!-- hh -->
    
    <div class="tab-content" id="myTabContent">
      

      <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab" style="margin-top: 30px;">
          <button class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="Actual_salary_sheet_excel()">Salary Sheet</button>
          <button class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="Actual_salary_sheet_excel_bank(2,1)">Bank Salary Sheet</button>
          <button class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="Actual_salary_sheet_excel_bank(2,0)">Cash Salary Sheet</button>
          <button class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="report_salary_sheet()">Salary Report</button>
          <button class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="genarate_payslip()">Genarate Payslip</button>
         <br> 
         <br>
        <button  class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px  !important;"  onclick="movReport(2)">Unpaid Movement</button>
        <button  class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="movReport(1)">Process Movement</button>
        <button  class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="movReport(3)">Reject Movement</button>
        <button  class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;"  onclick="movReport(4)">Paid Movement</button>

      </div>

      <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab" style="margin-top: 30px;">
        <button class="btn btn-sm mr-5 rounded" style="background: #2393e3eb; color: white;margin-right: 10px;padding:6px 10px !important;" onclick="salary_sheet_excel()">Salary Sheet</button>

      </div>

      <div class="tab-pane fade" id="continuously" role="tabpanel" aria-labelledby="continuously-tab" style="margin-top: 30px;">
        <button class="btn btn-sm btn-success rounded" style="padding:6px 10px !important;" onclick="jobCard()">Job Card</button>

      </div>
<!-- h -->
    </div>

  </div>


  <div  class="box-body" id="entry_form">

  </div>



</div>
</div>

<div class="col-lg-4">
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



<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/salary.js"></script>
<script>
  $(document).ready(function(){

    // select all item or deselect all item
    $("#select_all").click(function(){
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    // on load employee
    $("#status").change(function(){
      status = document.getElementById('status').value;
      sal_month = document.getElementById('sal_month').value;
      if(sal_month =='')
      {
        alert('Please select salary month');
        return ;
      }
      sal_year = document.getElementById('sal_year').value;
      if(sal_year =='')
      {
        alert('Please select alary year');
        return ;
      }
      $('#fileDiv #removeTr').remove();
      salary_month = sal_year +'-'+ sal_month
      var url = "<?php echo base_url('admin/attendance/get_employee_ajax_request'); ?>";
      $.ajax({
        url: url,
        type: 'GET',
        data: {
          "status":status,
          "salary_month":salary_month
        },
        contentType: "application/json",
        dataType: "json",


        success: function(response){
      
          arr = response.employees;
          console.log(arr);
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

   $("#emp_name option").filter(function() {
        return $id= $(this).val() == $("#gross_salary").val();
     }).attr('selected', true);

   
   
   
 function save_modify_salary() {
  
            // retrieve form data
            var formData = $('#salaryForm').serializeArray();

            // define the URL for the server-side PHP script that will handle the AJAX request
            var url = "<?php echo base_url('admin/payroll/save_modify_salary_all');?>";

            // send an AJAX request to the server-side PHP script
            $.ajax({
              url: url, // specify the URL of the PHP script
              type: 'POST', // specify the HTTP method (POST in this case)
              data: formData, // include the form data in the request
              success: function(response) {
              
                 $('#total').empty();
                $('#empfrom').empty();
                 modify_salary()
                 $('#my_modal').modal('show');
                 // Create alert
                alert("Operation successful!");
               }
            });

  }


 $(document).ready(function(){
    $("#modify_salary").on('input',function(){
      $("#modify_salary").attr('style', 'border: 1px solid #ccd6e6 !important');
      if($("#modify_salary").val() ==''){
        $("#modify_salary").attr('style', 'border: 1px solid red !important');
        return false;
      }
    });

    $("#emp_name").on('input',function(){
      $("#emp_name").attr('style', 'border: 1px solid #ccd6e6 !important');
      if($("#emp_name").val() ==''){
        $("#emp_name").attr('style', 'border: 1px solid red !important');
        return false;
      }
    });
  });
</script>

<script>
  function chenge_s() {
    $("#status").trigger('change');
    
  }
</script>


