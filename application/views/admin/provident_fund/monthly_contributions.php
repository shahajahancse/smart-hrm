<?php $session = $this->session->userdata('username');?>
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Monthly Contributions</h4>
        
      </div>
      <div class="card-body collapse in">
        <div class="card-block">
          <button type="button" class="btn btn-success mb-1 add-contribution-btn">Add New Contribution</button>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>Contribution Month</th>
                  <th>Employee Contribution</th>
                  <th>Company Contribution</th>
                  <th>Total Contribution</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($contributions)):?>
                <?php foreach($contributions as $contribution):?>
                <?php
                  $employee_name = 'N/A';
                  foreach($all_employees as $employee){
                    if($employee->user_id == $contribution->user_id){
                      $employee_name = $employee->first_name . ' ' . $employee->last_name;
                      break;
                    }
                  }
                ?>
                <tr>
                  <td><?php echo $employee_name;?></td>
                  <td><?php echo date('F Y', strtotime($contribution->contribution_month));?></td>
                  <td><?php echo $contribution->employee_contribution;?></td>
                  <td><?php echo $contribution->employer_contribution;?></td>
                  <td><?php echo $contribution->total_contribution;?></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-primary edit-contribution" data-contribution-id="<?php echo $contribution->contribution_id;?>">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger delete-contribution" data-contribution-id="<?php echo $contribution->contribution_id;?>">Delete</button>
                  </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                  <td colspan="6">No contributions found.</td>
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

<!-- Add/Edit Contribution Modal -->
<div class="modal fade text-left" id="add_edit_contribution_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel2">Add/Edit Contribution</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" name="add_edit_contribution" id="add_edit_contribution" action="<?php echo site_url('admin/provident_fund/add_edit_contribution');?>">
        <input type="hidden" name="type" value="add_edit_contribution">
        <input type="hidden" name="contribution_id" id="contribution_id" value="">
        <div class="modal-body">
          <div class="form-group">
            <label for="employee_id">Employee</label>
            <select class="form-control" name="employee_id" id="employee_id" required>
              <option value="">Select Employee</option>
              <?php foreach($all_employees as $employee):?>
                <option value="<?php echo $employee->user_id;?>"><?php echo $employee->first_name . ' ' . $employee->last_name;?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="form-group">
            <label for="contribution_month">Contribution Month</label>
            <input type="month" class="form-control" name="contribution_month" id="contribution_month" required>
          </div>
          <div class="form-group">
            <label for="employee_contribution">Employee Contribution</label>
            <input type="number" step="0.01" class="form-control" name="employee_contribution" id="employee_contribution" required>
          </div>
          <div class="form-group">
            <label for="employer_contribution">Company Contribution</label>
            <input type="number" step="0.01" class="form-control" name="employer_contribution" id="employer_contribution" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    // Add Contribution button click
    $('.add-contribution-btn').on('click', function(){
        $('#add_edit_contribution')[0].reset(); // Reset form
        $('#contribution_id').val(''); // Clear contribution_id for add operation
        $('#myModalLabel2').text('Add New Contribution');
        $('#add_edit_contribution_modal').modal('show');
    });

    // Edit Contribution button click
    $('.edit-contribution').on('click', function(){
        var contribution_id = $(this).data('contribution-id');
        $('#add_edit_contribution')[0].reset(); // Reset form
        $('#contribution_id').val(contribution_id);
        $('#myModalLabel2').text('Edit Contribution');

        // Fetch contribution details via AJAX
        $.ajax({
            url: '<?php echo site_url('admin/provident_fund/get_contribution_details');?>', // New AJAX endpoint
            type: 'POST',
            data: {contribution_id: contribution_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    var data = response.data;
                    $('#employee_id').val(data.employee_id);
                    $('#contribution_month').val(data.contribution_month.substring(0, 7)); // Format YYYY-MM
                    $('#employee_contribution').val(data.employee_contribution);
                    $('#employer_contribution').val(data.employer_contribution);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                    $('#add_edit_contribution_modal').modal('show');
                } else {
                    toastr.error(response.error);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                }
            }
        });
    });

    // Delete Contribution button click
    $('.delete-contribution').on('click', function(){
        var contribution_id = $(this).data('contribution-id');
        if(confirm('Are you sure you want to delete this contribution?')) {
            $.ajax({
                url: '<?php echo site_url('admin/provident_fund/delete_contribution');?>', // New AJAX endpoint
                type: 'POST',
                data: {contribution_id: contribution_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.success);
                        $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                        location.reload(); // Reload page to update table
                    } else {
                        toastr.error(response.error);
                        $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                    }
                }
            });
        }
    });

    // Form submission for Add/Edit Contribution
    $("#add_edit_contribution").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('action');
        $.ajax({
            type: "POST",
            url: action,
            data: obj.serialize(),
            cache: false,
            dataType: 'json',
            success: function (JSON) {
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                } else {
                    toastr.success(JSON.success);
                    $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                    $('#add_edit_contribution_modal').modal('hide');
                    location.reload(); // Reload page to update table
                }
            }
        });
    });
});
</script>