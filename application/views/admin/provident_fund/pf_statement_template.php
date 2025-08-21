<div class="card">
    <div class="card-header">
        <h4 class="card-title">Provident Fund Statement - <?php echo $employee->first_name . ' ' . $employee->last_name;?> (<?php echo $year;?>)</h4>
    </div>
    <div class="card-body">
        <div class="card-block">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Employee ID:</strong> <?php echo $employee->employee_id;?></p>
                    <p><strong>PF Account Number:</strong> <?php echo $pf_account->account_number;?></p>
                    <p><strong>Opening Balance (<?php echo $year;?>):</strong> <?php echo number_format($pf_account->opening_balance, 2);?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Current Balance:</strong> <?php echo number_format($pf_account->current_balance, 2);?></p>
                    <p><strong>Total Employee Contribution:</strong> <?php echo number_format($pf_account->total_employee_contribution, 2);?></p>
                    <p><strong>Total Company Contribution:</strong> <?php echo number_format($pf_account->total_employer_contribution, 2);?></p>
                    <p><strong>Total Interest Earned:</strong> <?php echo number_format($pf_account->total_interest_earned, 2);?></p>
                </div>
            </div>
            <hr>
            <h5>Contributions in <?php echo $year;?></h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Employee Contribution</th>
                            <th>Company Contribution</th>
                            <th>Total Contribution</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($contributions)):?>
                            <?php foreach($contributions as $contribution):?>
                                <tr>
                                    <td><?php echo date('F', strtotime($contribution->contribution_month));?></td>
                                    <td><?php echo number_format($contribution->employee_contribution, 2);?></td>
                                    <td><?php echo number_format($contribution->employer_contribution, 2);?></td>
                                    <td><?php echo number_format($contribution->total_contribution, 2);?></td>
                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="4">No contributions found for <?php echo $year;?>.</td>
                            </tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
            <hr>
            <h5>Interest Earned in <?php echo $year;?></h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Balance Before Interest</th>
                            <th>Interest Amount</th>
                            <th>Balance After Interest</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($interests)):?>
                            <?php foreach($interests as $interest):?>
                                <tr>
                                    <td><?php echo $interest->interest_year;?></td>
                                    <td><?php echo number_format($interest->balance_before_interest, 2);?></td>
                                    <td><?php echo number_format($interest->interest_amount, 2);?></td>
                                    <td><?php echo number_format($interest->balance_after_interest, 2);?></td>
                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr>
                                <td colspan="4">No interest records found for <?php echo $year;?>.</td>
                            </tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>