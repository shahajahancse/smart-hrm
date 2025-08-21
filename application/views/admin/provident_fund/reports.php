<?php $session = $this->session->userdata('username');?>
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Provident Fund Reports & Analytics</h4>
        
      </div>
      <div class="card-body collapse in">
        <div class="card-block">
          <ul class="nav nav-tabs nav-top-border no-hover-bg">
            <li class="nav-item">
              <a class="nav-link active" id="base-tab1" data-toggle="tab" aria-controls="tab1" href="#tab1" aria-expanded="true">PF Statement (per Employee)</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2" href="#tab2" aria-expanded="false">Overall Fund Status</a>
            </li>
          </ul>
          <div class="tab-content px-1 pt-1">
            <div role="tabpanel" class="tab-pane active" id="tab1" aria-expanded="true" aria-labelledby="base-tab1">
              <form class="form" method="post" name="pf_statement_form" id="pf_statement_form" action="<?php echo site_url('admin/provident_fund/generate_pf_statement');?>">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="employee_id_statement">Select Employee</label>
                      <select class="form-control" name="employee_id" id="employee_id_statement" required>
                        <option value="">Select Employee</option>
                        <?php foreach($all_employees as $employee):?>
                          <option value="<?php echo $employee->employee_id;?>"><?php echo $employee->first_name . ' ' . $employee->last_name;?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="year_statement">Select Year</label>
                      <select class="form-control" name="year" id="year_statement" required>
                        <?php for($i = date('Y'); $i >= 2000; $i--):?>
                          <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php endfor;?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary">Generate Statement</button>
                </div>
              </form>
              <div id="pf_statement_result" class="mt-2">
                <!-- PF Statement will be loaded here via AJAX -->
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab2" aria-expanded="false" aria-labelledby="base-tab2">
              <h4>Overall Provident Fund Status</h4>
              <div class="row">
                <div class="col-md-4">
                  <div class="card text-white bg-primary">
                    <div class="card-body">
                      <h5 class="card-title text-white">Total Fund Balance</h5>
                      <p class="card-text font-large-2"><?php echo number_format(array_sum(array_column($pf_accounts, 'current_balance')), 2);?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-white bg-success">
                    <div class="card-body">
                      <h5 class="card-title text-white">Total Employee Contributions</h5>
                      <p class="card-text font-large-2"><?php echo number_format(array_sum(array_column($pf_accounts, 'total_employee_contribution')), 2);?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-white bg-info">
                    <div class="card-body">
                      <h5 class="card-title text-white">Total Company Contributions</h5>
                      <p class="card-text font-large-2"><?php echo number_format(array_sum(array_column($pf_accounts, 'total_employer_contribution')), 2);?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="card text-white bg-warning">
                    <div class="card-body">
                      <h5 class="card-title text-white">Total Interest Earned</h5>
                      <p class="card-text font-large-2"><?php echo number_format(array_sum(array_column($pf_accounts, 'total_interest_earned')), 2);?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-white bg-danger">
                    <div class="card-body">
                      <h5 class="card-title text-white">Total Withdrawals (Approved)</h5>
                      <p class="card-text font-large-2">
                        <?php
                          $total_approved_withdrawals = 0;
                          foreach($withdrawals as $w){
                            if($w->status == 'approved' || $w->status == 'disbursed'){
                              $total_approved_withdrawals += $w->approved_amount;
                            }
                          }
                          echo number_format($total_approved_withdrawals, 2);
                        ?>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card text-white bg-dark">
                    <div class="card-body">
                      <h5 class="card-title text-white">Total Loans (Active)</h5>
                      <p class="card-text font-large-2">
                        <?php
                          $total_active_loans = 0;
                          foreach($loans as $l){
                            if($l->status == 'active'){
                              $total_active_loans += $l->outstanding_balance;
                            }
                          }
                          echo number_format($total_active_loans, 2);
                        ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#pf_statement_form").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('action');
        $.ajax({
            type: "POST",
            url: action,
            data: obj.serialize(),
            cache: false,
            success: function (response) {
                $('#pf_statement_result').html(response);
            }
        });
    });
});
</script>