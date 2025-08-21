<?php $session = $this->session->userdata('username');?>
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Provident Fund Withdrawal Requests</h4>
        
      </div>
      <div class="card-body collapse in">
        <div class="card-block">
          <button type="button" class="btn btn-success mb-1 add-withdrawal-btn">Add New Withdrawal Request</button>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>Request Date</th>
                  <th>Type</th>
                  <th>Requested Amount</th>
                  <th>Approved Amount</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($withdrawals)):?>
                <?php foreach($withdrawals as $withdrawal):?>
                <?php
                  $employee_name = 'N/A';
                  foreach($all_employees as $employee){
                    if($employee->user_id == $withdrawal->user_id){
                      $employee_name = $employee->first_name . ' ' . $employee->last_name;
                      break;
                    }
                  }
                ?>
                <tr>
                  <td><?php echo $employee_name;?></td>
                  <td><?php echo date('Y-m-d', strtotime($withdrawal->request_date));?></td>
                  <td><?php echo ucfirst($withdrawal->withdrawal_type);?></td>
                  <td><?php echo $withdrawal->requested_amount;?></td>
                  <td><?php echo $withdrawal->approved_amount ? $withdrawal->approved_amount : 'N/A';?></td>
                  <td><?php echo ucfirst($withdrawal->status);?></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-primary edit-withdrawal" data-withdrawal-id="<?php echo $withdrawal->withdrawal_id;?>">Edit</button>
                    <button type="button" class="btn btn-sm btn-info update-withdrawal-status" data-withdrawal-id="<?php echo $withdrawal->withdrawal_id;?>">Update Status</button>
                    <button type="button" class="btn btn-sm btn-danger delete-withdrawal" data-withdrawal-id="<?php echo $withdrawal->withdrawal_id;?>">Delete</button>
                  </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                  <td colspan="7">No withdrawal requests found.</td>
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

<!-- Add/Edit Withdrawal Modal -->
<div class="modal fade text-left" id="add_edit_withdrawal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel3">Add/Edit Withdrawal Request</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" name="add_edit_withdrawal" id="add_edit_withdrawal" action="<?php echo site_url('admin/provident_fund/add_edit_withdrawal');?>">
        <input type="hidden" name="type" value="add_edit_withdrawal">
        <input type="hidden" name="withdrawal_id" id="withdrawal_id" value="">
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
            <label>Current Balance</label>
            <input type="text" class="form-control" id="current_balance_display" readonly>
          </div>
          <div class="form-group">
            <label for="withdrawal_type">Withdrawal Type</label>
            <select class="form-control" name="withdrawal_type" id="withdrawal_type" required>
              <option value="partial">Partial</option>
              <option value="full">Full</option>
            </select>
          </div>
          <div class="form-group">
            <label for="requested_amount">Requested Amount</label>
            <input type="number" step="0.01" class="form-control" name="requested_amount" id="requested_amount" required>
          </div>
          <div class="form-group">
            <label for="purpose">Purpose</label>
            <textarea class="form-control" name="purpose" id="purpose"></textarea>
          </div>
          <div class="form-group">
            <label for="approved_amount">Approved Amount</label>
            <input type="number" step="0.01" class="form-control" name="approved_amount" id="approved_amount">
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

<!-- Update Withdrawal Status Modal -->
<div class="modal fade text-left" id="update_withdrawal_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">Update Withdrawal Status</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" name="update_withdrawal_status" id="update_withdrawal_status" action="<?php echo site_url('admin/provident_fund/update_withdrawal_status');?>">
        <input type="hidden" name="withdrawal_id" id="status_withdrawal_id" value="">
        <div class="modal-body">
          <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status" required>
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
              <option value="disbursed">Disbursed</option>
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
    var current_balance = 0;

    $('#employee_id').on('change', function(){
        var user_id = $(this).val();
        if(user_id) {
            $.ajax({
                url: '<?php echo site_url('admin/provident_fund/get_employee_pf_balance');?>',
                type: 'POST',
                data: {user_id: user_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
                dataType: 'json',
                success: function(response) {
                    if(response.balance) {
                        current_balance = response.balance;
                        $('#current_balance_display').val(current_balance);
                        $('#requested_amount').attr('max', current_balance);
                        toastr.success('Balance updated.');
                    } else {
                        current_balance = 0;
                        $('#current_balance_display').val(0);
                        $('#requested_amount').attr('max', 0);
                        toastr.error(response.error);
                    }
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                }
            });
        } else {
            current_balance = 0;
            $('#current_balance_display').val(0);
            $('#requested_amount').attr('max', 0);
        }
    });

    $('#requested_amount').on('input', function(){
        var requested_amount = $(this).val();
        if(parseFloat(requested_amount) > current_balance) {
            $(this).val(current_balance);
            toastr.error('Requested amount cannot be greater than the current balance.');
        }
    });
    // Add Withdrawal button click
    $('.add-withdrawal-btn').on('click', function(){
        $('#add_edit_withdrawal')[0].reset(); // Reset form
        $('#withdrawal_id').val(''); // Clear withdrawal_id for add operation
        $('#myModalLabel3').text('Add New Withdrawal Request');
        $('#add_edit_withdrawal_modal').modal('show');
    });

    // Edit Withdrawal button click
    $('.edit-withdrawal').on('click', function(){
        var withdrawal_id = $(this).data('withdrawal-id');
        $('#add_edit_withdrawal')[0].reset(); // Reset form
        $('#withdrawal_id').val(withdrawal_id);
        $('#myModalLabel3').text('Edit Withdrawal Request');

        // Fetch withdrawal details via AJAX
        $.ajax({
            url: '<?php echo site_url('admin/provident_fund/get_withdrawal_details');?>',
            type: 'POST',
            data: {withdrawal_id: withdrawal_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    var data = response.data;
                    $('#employee_id').val(data.user_id).trigger('change');
                    $('#withdrawal_type').val(data.withdrawal_type);
                    $('#requested_amount').val(data.requested_amount);
                    $('#purpose').val(data.purpose);
                    $('#approved_amount').val(data.approved_amount);
                    $('#remarks').val(data.remarks);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                    $('#add_edit_withdrawal_modal').modal('show');
                } else {
                    toastr.error(response.error);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                }
            }
        });
    });

    // Update Withdrawal Status button click
    $('.update-withdrawal-status').on('click', function(){
        var withdrawal_id = $(this).data('withdrawal-id');
        $('#status_withdrawal_id').val(withdrawal_id);
        $('#update_withdrawal_status_modal').modal('show');

        // Fetch current status details for pre-filling
        $.ajax({
            url: '<?php echo site_url('admin/provident_fund/get_withdrawal_details');?>',
            type: 'POST',
            data: {withdrawal_id: withdrawal_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
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

    // Delete Withdrawal button click
    $('.delete-withdrawal').on('click', function(){
        var withdrawal_id = $(this).data('withdrawal-id');
        if(confirm('Are you sure you want to delete this withdrawal request?')) {
            $.ajax({
                url: '<?php echo site_url('admin/provident_fund/delete_withdrawal');?>',
                type: 'POST',
                data: {withdrawal_id: withdrawal_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
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

    // Form submission for Add/Edit Withdrawal
    $("#add_edit_withdrawal").submit(function(e){
        e.preventDefault();
        var requested_amount = $('#requested_amount').val();
        if(parseFloat(requested_amount) > current_balance) {
            toastr.error('Requested amount cannot be greater than the current balance.');
            return false;
        }
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
                    $('#add_edit_withdrawal_modal').modal('hide');
                    location.reload(); // Reload page to update table
                }
            }
        });
    });

    // Form submission for Update Withdrawal Status
    $("#update_withdrawal_status").submit(function(e){
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
                    $('#update_withdrawal_status_modal').modal('hide');
                    location.reload(); // Reload page to update table
                }
            }
        });
    });
});
</script>
<style>
.modal-dialog {
    max-width: 600px;
}
</style>