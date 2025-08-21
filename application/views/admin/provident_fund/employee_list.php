<?php $session = $this->session->userdata('username');?>
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Employee Provident Fund Accounts</h4>
        
      </div>
      <div class="card-body collapse in">
        <div class="card-block">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>PF Account Number</th>
                  <th>Current Balance</th>
                  <th>Total Employee Contribution</th>
                  <th>Total Company Contribution</th>
                  <th>Total Interest Earned</th>
                  <th>Eligible for Withdrawal</th>
                  <th>Eligible for Loan</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($all_employees)):?>
                <?php foreach($all_employees as $employee):?>
                <?php
                  $pf_account = null;
                  foreach($pf_accounts as $account){
                    if($account->user_id == $employee->user_id){
                      $pf_account = $account;
                      break;
                    }
                  }
                ?>
                <tr>
                  <td><?php echo $employee->first_name . ' ' . $employee->last_name;?></td>
                  <td><?php echo $pf_account ? $pf_account->account_number : 'N/A';?></td>
                  <td><?php echo $pf_account ? $pf_account->current_balance : '0.00';?></td>
                  <td><?php echo $pf_account ? $pf_account->total_employee_contribution : '0.00';?></td>
                  <td><?php echo $pf_account ? $pf_account->total_employer_contribution : '0.00';?></td>
                  <td><?php echo $pf_account ? $pf_account->total_interest_earned : '0.00';?></td>
                  <td><?php echo $pf_account && $pf_account->is_eligible_withdrawal ? 'Yes' : 'No';?></td>
                  <td><?php echo $pf_account && $pf_account->is_eligible_loan ? 'Yes' : 'No';?></td>
                  <td>
                    <?php if($pf_account):?>
                      <button type="button" class="btn btn-sm btn-primary edit-pf-account" data-account-id="<?php echo $pf_account->account_id;?>" data-employee-id="<?php echo $employee->employee_id;?>">Edit</button>
                      <button type="button" class="btn btn-sm btn-danger delete-pf-account" data-account-id="<?php echo $pf_account->account_id;?>">Delete</button>
                    <?php else:?>
                      <button type="button" class="btn btn-sm btn-success add-pf-account" data-employee-id="<?php echo $employee->user_id;?>">Add Account</button>
                    <?php endif;?>
                  </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                  <td colspan="9">No employees found.</td>
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

<!-- Add/Edit PF Account Modal -->
<div class="modal fade text-left" id="add_edit_pf_account_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1">Add/Edit PF Account</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form" method="post" name="add_edit_pf_account" id="add_edit_pf_account" action="<?php echo site_url('admin/provident_fund/add_edit_pf_account');?>">
        <input type="hidden" name="type" value="add_edit_pf_account">
        <input type="hidden" name="account_id" id="account_id" value="">
        <input type="hidden" name="employee_id" id="modal_employee_id" value="">
        <div class="modal-body">
          <div class="form-group">
            <label for="account_number">PF Account Number</label>
            <input type="text" class="form-control" name="account_number" id="account_number" required>
          </div>
          <div class="form-group">
            <label for="opening_balance">Opening Balance</label>
            <input type="number" step="0.01" class="form-control" name="opening_balance" id="opening_balance" required>
          </div>
          <div class="form-group">
            <label for="current_balance">Current Balance</label>
            <input type="number" step="0.01" class="form-control" name="current_balance" id="current_balance" required>
          </div>
          <div class="form-group">
            <label for="total_employee_contribution">Total Employee Contribution</label>
            <input type="number" step="0.01" class="form-control" name="total_employee_contribution" id="total_employee_contribution" required>
          </div>
          <div class="form-group">
            <label for="total_employer_contribution">Total Company Contribution</label>
            <input type="number" step="0.01" class="form-control" name="total_employer_contribution" id="total_employer_contribution" required>
          </div>
          <div class="form-group">
            <label for="total_interest_earned">Total Interest Earned</label>
            <input type="number" step="0.01" class="form-control" name="total_interest_earned" id="total_interest_earned" required>
          </div>
          <div class="form-group">
            <label for="is_eligible_withdrawal">Eligible for Withdrawal</label>
            <select class="form-control" name="is_eligible_withdrawal" id="is_eligible_withdrawal">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
          <div class="form-group">
            <label for="is_eligible_loan">Eligible for Loan</label>
            <select class="form-control" name="is_eligible_loan" id="is_eligible_loan">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
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
    // Add Account button click
    $('.add-pf-account').on('click', function(){
        var employee_id = $(this).data('employee-id');
        $('#add_edit_pf_account')[0].reset(); // Reset form
        $('#account_id').val(''); // Clear account_id for add operation
        $('#modal_employee_id').val(employee_id);
        $('#myModalLabel1').text('Add PF Account');
        $('#add_edit_pf_account_modal').modal('show');
    });

    // Edit Account button click
    $('.edit-pf-account').on('click', function(){
        var account_id = $(this).data('account-id');
        var employee_id = $(this).data('employee-id');
        $('#add_edit_pf_account')[0].reset(); // Reset form
        $('#account_id').val(account_id);
        $('#modal_employee_id').val(employee_id);
        $('#myModalLabel1').text('Edit PF Account');

        // Fetch account details via AJAX
        $.ajax({
            url: '<?php echo site_url('admin/provident_fund/get_pf_account_details');?>', // New AJAX endpoint
            type: 'POST',
            data: {account_id: account_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    var data = response.data;
                    $('#account_number').val(data.account_number);
                    $('#opening_balance').val(data.opening_balance);
                    $('#current_balance').val(data.current_balance);
                    $('#total_employee_contribution').val(data.total_employee_contribution);
                    $('#total_employer_contribution').val(data.total_employer_contribution);
                    $('#total_interest_earned').val(data.total_interest_earned);
                    $('#is_eligible_withdrawal').val(data.is_eligible_withdrawal);
                    $('#is_eligible_loan').val(data.is_eligible_loan);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                    $('#add_edit_pf_account_modal').modal('show');
                } else {
                    toastr.error(response.error);
                    $('input[name="csrf_hrsale"]').val(response.csrf_hash);
                }
            }
        });
    });

    // Delete Account button click
    $('.delete-pf-account').on('click', function(){
        var account_id = $(this).data('account-id');
        if(confirm('Are you sure you want to delete this PF account?')) {
            $.ajax({
                url: '<?php echo site_url('admin/provident_fund/delete_pf_account');?>', // New AJAX endpoint
                type: 'POST',
                data: {account_id: account_id, csrf_hrsale: $('input[name="csrf_hrsale"]').val()},
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

    // Form submission for Add/Edit PF Account
    $("#add_edit_pf_account").submit(function(e){
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
                    $('#add_edit_pf_account_modal').modal('hide');
                    location.reload(); // Reload page to update table
                }
            }
        });
    });
});
</script>