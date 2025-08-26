<?php
// Calculate totals for summary
$total_credits = 0;
$total_debits = 0;
foreach($transactions as $trans) {
    if($trans->type == 'credit') {
        $total_credits += $trans->amount;
    } else {
        $total_debits += $trans->amount;
    }
}
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Provident Fund Statement</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><button type="button" class="btn btn-secondary btn-sm" onclick="window.print();"><i class="fa fa-print"></i> Print</button></li>
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="card-block">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Employee:</strong> <?php echo $employee->first_name . ' ' . $employee->last_name; ?></p>
                    <p><strong>PF Account No:</strong> <?php echo $pf_account->account_number; ?></p>
                </div>
                <div class="col-md-6 text-right">
                    <p><strong>Statement Period:</strong> <?php echo date("d M Y", strtotime($start_date)); ?> to <?php echo date("d M Y", strtotime($end_date)); ?></p>
                </div>
            </div>

            <hr>

            <h5>Statement Summary</h5>
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td>Opening Balance</td>
                        <td class="text-right"><?php echo number_format($opening_balance, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Total Contributions & Credits</td>
                        <td class="text-right"><?php echo number_format($total_credits, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Total Withdrawals & Debits</td>
                        <td class="text-right"><?php echo number_format($total_debits, 2); ?></td>
                    </tr>
                    <tr>
                        <th>Closing Balance</th>
                        <th class="text-right"><?php echo number_format($closing_balance, 2); ?></th>
                    </tr>
                </tbody>
            </table>

            <h5 class="mt-2">Transaction Details</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th class="text-right">Debit</th>
                            <th class="text-right">Credit</th>
                            <th class="text-right">Running Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo date("d M Y", strtotime($start_date)); ?></td>
                            <td>Opening Balance</td>
                            <td></td>
                            <td></td>
                            <td class="text-right"><?php echo number_format($opening_balance, 2); ?></td>
                        </tr>
                        <?php if(!empty($transactions)): ?>
                        <?php foreach($transactions as $trans): ?>
                            <tr>
                                <td><?php echo date("d M Y", strtotime($trans->date)); ?></td>
                                <td><?php echo $trans->description; ?></td>
                                <td class="text-right"><?php echo ($trans->type == 'debit') ? number_format($trans->amount, 2) : ''; ?></td>
                                <td class="text-right"><?php echo ($trans->type == 'credit') ? number_format($trans->amount, 2) : ''; ?></td>
                                <td class="text-right"><?php echo number_format($trans->running_balance, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No transactions found in this period.</td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th colspan="4" class="text-right">Closing Balance as of <?php echo date("d M Y", strtotime($end_date)); ?></th>
                            <th class="text-right"><?php echo number_format($closing_balance, 2); ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
