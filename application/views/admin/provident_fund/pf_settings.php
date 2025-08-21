<?php $session = $this->session->userdata('username');?>
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Provident Fund Settings</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
            <li><a data-action="close"><i class="ft-x"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="card-block">
          <form class="form" method="post" name="add_edit_settings" id="add_edit_settings" action="<?php echo site_url('admin/provident_fund');?>">
            <input type="hidden" name="type" value="add_edit_settings">
            <div class="form-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="employee_contribution_rate">Employee Contribution Rate (%)</label>
                    <input type="text" class="form-control" placeholder="e.g., 10.00" name="employee_contribution_rate" id="employee_contribution_rate" value="<?php echo isset($pf_settings->employee_contribution_rate) ? $pf_settings->employee_contribution_rate : '';?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="employer_contribution_rate">Company Contribution Rate (%)</label>
                    <input type="text" class="form-control" placeholder="e.g., 10.00" name="employer_contribution_rate" id="employer_contribution_rate" value="<?php echo isset($pf_settings->employer_contribution_rate) ? $pf_settings->employer_contribution_rate : '';?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bank_interest_rate">Bank Interest Rate (%) (Annual)</label>
                    <input type="text" class="form-control" placeholder="e.g., 5.00" name="bank_interest_rate" id="bank_interest_rate" value="<?php echo isset($pf_settings->bank_interest_rate) ? $pf_settings->bank_interest_rate : '';?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="min_service_period_withdrawal">Minimum Service Period for Withdrawal (Years)</label>
                    <input type="number" class="form-control" placeholder="e.g., 5" name="min_service_period_withdrawal" id="min_service_period_withdrawal" value="<?php echo isset($pf_settings->min_service_period_withdrawal) ? $pf_settings->min_service_period_withdrawal : '';?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="min_service_period_loan">Minimum Service Period for Loan (Years)</label>
                    <input type="number" class="form-control" placeholder="e.g., 3" name="min_service_period_loan" id="min_service_period_loan" value="<?php echo isset($pf_settings->min_service_period_loan) ? $pf_settings->min_service_period_loan : '';?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> Save Settings </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#add_edit_settings").submit(function(e){
	/*Form Submit*/
	e.preventDefault();
		var obj = $(this), action = obj.attr('action');
		$.ajax({
			type: "POST",
			url: action,
			data: obj.serialize(),
			cache: false,
			success: function (JSON) {
				if (JSON.error != '') {
					toastr.error(JSON.error);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				} else {
					toastr.success(JSON.success);
					$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				}
			}
		});
	});
});
</script>