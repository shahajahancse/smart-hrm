<?php $session = $this->session->userdata('username');?>
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Provident Fund Loan Applications</h4>
        
      </div>
      <div class="card-body collapse in">
        <div class="card-block">
          <button type="button" class="btn btn-success mb-1 add-loan-btn">Add New Loan Application</button>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>Request Date</th>
                  <th>Loan Amount</th>
                  <th>Approved Amount</th>
                  <th>Interest Rate</th>
                  <th>Repayment Period (Months)</th>
                  <th>Monthly Installment</th>
                  <th>Outstanding Balance</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($loans)):?>
                <?php foreach($loans as $loan):?>
                <?php
                  $employee_name = 'N/A';
                  foreach($all_employees as $employee){
                    if($employee->employee_id == $loan->employee_id){
                      $employee_name = $employee->first_name . ' ' . $employee->last_name;
                      break;
                    }
                  }
                ?>
                <tr>
                  <td><?php echo $employee_name;?></td>
                  <td><?php echo date('Y-m-d', strtotime($loan->request_date));?></td>
                  <td><?php echo $loan->loan_amount;?></td>
                  <td><?php echo $loan->approved_amount ? $loan->approved_amount : 'N/A';?></td>
                  <td><?php echo $loan->interest_rate;?>%</td>
                  <td><?php echo $loan->repayment_period_months;?></td>
                  <td><?php echo $loan->monthly_installment;?></td>
                  <td><?php echo $loan->outstanding_balance;?></td>
                  <td><?php echo ucfirst($loan->status);?></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-primary edit-loan" data-loan-id="<?php echo $loan->loan_id;?>">Edit</button>
                    <button type="button" class="btn btn-sm btn-info update-loan-status" data-loan-id="<?php echo $loan->loan_id;?>">Update Status</button>
                    <button type="button" class="btn btn-sm btn-danger delete-loan" data-loan-id="<?php echo $loan->loan_id;?>">Delete</button>
                  </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                  <td colspan="10">No loan applications found.</td>
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

<!-- Add/Edit Loan Modal -->
<div class="modal fade text-left" id="add_edit_loan_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel5">Add/Edit Loan Application</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" name="add_edit_loan" id="add_edit_loan" action="<?php echo site_url('admin/provident_fund/add_edit_loan');?>">
        <input type="hidden" name="type" value="add_edit_loan">
        <input type="hidden" name="loan_id" id="loan_id" value="">
        <div class="modal-body">
          <div class="form-group">
            <label for="employee_id">Employee</label>
            <select class="form-control" name="employee_id" id="employee_id" required>
              <option value="">Select Employee</option>
              <?php foreach($all_employees as $employee):?>
                <option value="<?php echo $employee->employee_id;?>"><?php echo $employee->first_name . ' ' . $employee->last_name;?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="form-group">
            <label for="loan_amount">Loan Amount</label>
            <input type="number" step="0.01" class="form-control" name="loan_amount" id="loan_amount" required>
          </div>
          <div class="form-group">
            <label for="interest_rate">Interest Rate (%)</label>
            <input type="number" step="0.01" class="form-control" name="interest_rate" id="interest_rate" required>
          </div>
          <div class="form-group">
            <label for="repayment_period_months">Repayment Period (Months)</label>
            <input type="number" class="form-control" name="repayment_period_months" id="repayment_period_months" required>
          </div>
          <div class="form-group">
            <label for="monthly_installment">Monthly Installment</label>
            <input type="number" step="0.01" class="form-control" name="monthly_installment" id="monthly_installment" required>
          </div>
          <div class="form-group">
            <label for="approved_amount">Approved Amount</label>
            <input type="number" step="0.01" class="form-control" name="approved_amount" id="approved_amount">
          </div>
          <div class="form-group">
            <label for="outstanding_balance">Outstanding Balance</label>
            <input type="number" step="0.01" class="form-control" name="outstanding_balance" id="outstanding_balance" required>
          </div>
          <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea class="form-control" name="remarks" id="remarks"></textarea>
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

<!-- Update Loan Status Modal -->
<div class="modal fade text-left" id="update_loan_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel6" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel6">Update Loan Status</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" name="update_loan_status" id="update_loan_status" action="<?php echo site_url('admin/provident_fund/update_loan_status');?>">
        <input type="hidden" name="loan_id" id="status_loan_id" value="">
        <div class="modal-body">
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status" required>
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
              <option value="active">Active</option>
              <option value="completed">Completed</option>
            </select>
          </div>
          <div class="form-group">
            <label for="approval_level">Approval Level</label>
            <input type="number" class="form-control" name="approval_level" id="approval_level" min="0" required>
          </div>
          <div class="form-group">
            <label for="disbursed_date">Disbursed Date</label>
            <input type="date" class="form-control" name="disbursed_date" id="disbursed_date">
          </div>
          <div class="form-group">
            <label for="status_remarks">Remarks</label>
            <textarea class="form-control" name="status_remarks" id="status_remarks"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Status</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    // Add Loan button click
    $('.add-loan-btn').on('click', function(){
        $('#add_edit_loan')[0].reset(); // Reset form
        $('#loan_id').val(''); // Clear loan_id for add operation
        $('#myModalLabel5').text('Add New Loan Application');
        $('#add_edit_loan_modal').modal('show');
    });

    // Edit Loan button click
    $('.edit-loan').on('click', function(){
        var loan_id = $(this).data('loan-id');
        $('#add_edit_loan')[0].reset(); // Reset form
        $('#loan_id').val(loan_id);
        $('#myModalLabel5').text('Edit Loan Application');

        // Fetch loan details via AJAX
        $.ajax({
            url: '<?php echo site_url('admin/provident_fund/get_loan_details');?>', // New AJAX endpoint
            type: 'POST',
            data: {loan_id: loan_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    var data = response.data;
                    $('#employee_id').val(data.employee_id);
                    $('#loan_amount').val(data.loan_amount);
                    $('#interest_rate').val(data.interest_rate);
                    $('#repayment_period_months').val(data.repayment_period_months);
                    $('#monthly_installment').val(data.monthly_installment);
                    $('#approved_amount').val(data.approved_amount);
                    $('#outstanding_balance').val(data.outstanding_balance);
                    $('#remarks').val(data.remarks);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                    $('#add_edit_loan_modal').modal('show');
                } else {
                    toastr.error(response.error);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                }
            }
        });
    });

    // Update Loan Status button click
    $('.update-loan-status').on('click', function(){
        var loan_id = $(this).data('loan-id');
        $('#status_loan_id').val(loan_id);
        $('#update_loan_status_modal').modal('show');

        // Fetch current status details for pre-filling
        $.ajax({
            url: '<?php echo site_url('admin/provident_fund/get_loan_details');?>', // Re-use endpoint
            type: 'POST',
            data: {loan_id: loan_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    var data = response.data;
                    $('#status').val(data.status);
                    $('#approval_level').val(data.approval_level);
                    $('#disbursed_date').val(data.disbursed_date);
                    $('#status_remarks').val(data.remarks);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                } else {
                    toastr.error(response.error);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                }
            }
        });
    });

    // Delete Loan button click
    $('.delete-loan').on('click', function(){
        var loan_id = $(this).data('loan-id');
        if(confirm('Are you sure you want to delete this loan application?')) {
            $.ajax({
                url: '<?php echo site_url('admin/provident_fund/delete_loan');?>', // New AJAX endpoint
                type: 'POST',
                data: {loan_id: loan_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
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

    // Form submission for Add/Edit Loan
    $("#add_edit_loan").submit(function(e){
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
                    $('#add_edit_loan_modal').modal('hide');
                    location.reload(); // Reload page to update table
                }
            }
        });
    });

    // Form submission for Update Loan Status
    $("#update_loan_status").submit(function(e){
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
                    $('#update_loan_status_modal').modal('hide');
                    location.reload(); // Reload page to update table
                }
            }
        });
    });
});
</script>