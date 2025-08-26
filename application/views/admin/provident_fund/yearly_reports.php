<?php 
$session = $this->session->userdata('username');
$selected_year = isset($selected_year) ? $selected_year : date('Y');
$selected_employee_id = isset($selected_employee_id) ? $selected_employee_id : '';
?>
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Yearly Reports & Interest Calculation</h4>
        
      </div>
      <div class="card-body collapse in">
        <div class="card-block">
          <form class="form" method="post" name="calculate_interest_form" id="calculate_interest_form" action="<?php echo site_url('admin/provident_fund/yearly_reports');?>">
            <input type="hidden" name="type" value="calculate_interest">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="year">Select Year</label>
                  <select class="form-control" name="year" id="year" required>
                    <?php for($i = date('Y'); $i >= 2000; $i--):?>
                      <option value="<?php echo $i;?>" <?php echo ($i == $selected_year) ? 'selected' : '';?>><?php echo $i;?></option>
                    <?php endfor;?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="employee_id">Select Employee</label>
                  <select class="form-control" name="employee_id" id="employee_id">
                    <option value="">All Employees</option>
                    <?php foreach($all_employees as $employee):?>
                      <option value="<?php echo $employee->user_id;?>" <?php echo ($employee->user_id == $selected_employee_id) ? 'selected' : '';?>><?php echo $employee->first_name . ' ' . $employee->last_name;?></option>
                    <?php endforeach;?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" style="display: flex;flex-direction: column;align-items: flex-start;">
                  <label for="year">&nbsp;</label>
                  <div>
                    <button type="submit" class="btn btn-primary">Calculate & Post Interest</button>
                    <a href="#" id="export_csv_link" class="btn btn-secondary" onclick="reload_table();">Export to Excel</a>
                  </div>
                </div>
              </div>
              
            </div>
          </form>
          <hr>
          <h4>Yearly Interest Reports</h4>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>Interest Year</th>
                  <th>Balance Before Interest</th>
                  <th>Interest Amount</th>
                  <th>Balance After Interest</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($yearly_interests)):
                foreach($yearly_interests as $interest):?>
                <tr>
                  <td><?php echo $interest->first_name . ' ' . $interest->last_name;?></td>
                  <td><?php echo $interest->interest_year;?></td>
                  <td><?php echo $interest->balance_before_interest;?></td>
                  <td><?php echo $interest->interest_amount;?></td>
                  <td><?php echo $interest->balance_after_interest;?></td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                  <td colspan="5">No yearly interest records found for this year.</td>
                </tr>
                <?php endif;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function reload_table(){
      console.log('ndsfjhjf');
      
      setTimeout(function(){
          window.location.reload();
      }, 1000);
    }
$(document).ready(function(){
    function updateExportLink() {
        var year = $('#year').val();
        var employee_id = $('#employee_id').val();
        var export_url = "<?php echo site_url('admin/provident_fund/export_yearly_report');?>?year=" + year + "&employee_id=" + employee_id;
        $('#export_csv_link').attr('href', export_url);
      
    }

    

    // Initial setup
    updateExportLink();

    // Update on change
    $('#year, #employee_id').change(function() {
        updateExportLink();
    });

    // Form submission for Calculate Interest
    $("#calculate_interest_form").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('action');
        var year = $('#year').val();
        var employee_id = $('#employee_id').val();

        $.ajax({
            type: "POST",
            url: action,
            data: obj.serialize(),
            cache: false,
            dataType: 'json',
            success: function (JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                } else {
                    toastr.success(JSON.success);
                }
                // Reload the page with query parameters
                var new_url = "<?php echo site_url('admin/provident_fund/yearly_reports');?>?year=" + year + "&employee_id=" + employee_id;
                window.location.href = new_url;
            },
            error: function (xhr, status, error) {
               var new_url = "<?php echo site_url('admin/provident_fund/yearly_reports');?>?year=" + year + "&employee_id=" + employee_id;
               window.location.href = new_url;
            }
        });
    });
});
</script>