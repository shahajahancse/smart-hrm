<?php
// This view is loaded by Provident_fund/my_fund_details
// It expects $has_pf_account, and if true, also $employee, $pf_account, $opening_balance, $transactions, etc.
?>
<style>
    body {
        font-family: 'Fira Mono', monospace;
    }

    .list-group>li:nth-child(5n+1) {
        border-top: 1px solid rgba(0, 0, 0, .125);
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
    }

    .list-group>li:nth-child(5n+0) {
        border-bottom-left-radius: .25rem;
        border-bottom-right-radius: .25rem;
    }

    .pagination-container {
        justify-content: right !important;
        display: flex !important;
    }

    #customModal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: -webkit-fill-available;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        padding: 4px 35px;
        margin: 8% 0% 0% 23%;
        border: 1px solid #888;
        width: 65%;
        overflow: auto;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .texta {
        padding: 18px;
    }

    .timediv {
        padding: 0;
        display: flex;
        flex-direction: row;
        gap: 11px;
    }

    @media screen and (max-width: 992px) {
        .timediv {
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .modal-content {
            padding: 14px;
        }
    }

    @media screen and (max-width: 762px) {
        .modal-content {
            margin: 19% 0% 0% 26%;
        }

        .texta {
            padding: 0;
        }
    }

    @media screen and (max-width: 400px) {
        .modal-content {
            margin: 27% 0% 0% 12%;
            width: 256px;
        }
    }
</style>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/emp_attandenc.css') ?>">

<?php if (!$has_pf_account): ?>
    <div class="alert alert-warning" role="alert">
        <strong>Information:</strong> You are currently not enrolled in the Provident Fund scheme or your account details
        are not available. Please contact HR for more information.
    </div>
<?php else: // Has PF Account ?>





  <div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
                            <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
                                <div class="heading">Current Balance</div>
                                <div class="heading2"><?php echo number_format($pf_account->current_balance, 2); ?></div>
                            </div>
                            <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
                                <div class="heading">Total Employee Contribution</div>
                                <div class="heading2">
                                    <?php echo number_format($pf_account->total_employee_contribution, 2); ?></div>
                            </div>
                            <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
                                <div class="heading">Total Employer Contribution</div>
                                <div class="heading2">
                                    <?php echo number_format($pf_account->total_employer_contribution, 2); ?></div>
                            </div>
                            <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
                                <div class="heading">Total Interest Earned</div>
                                <div class="heading2"><?php echo number_format($pf_account->total_interest_earned, 2); ?>
                                </div>
                            </div>
                        </div>


                        <div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
                            <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
                                <div class="heading">Opening Balance (Scheme Start)</div>
                                <div class="heading2"><?php echo number_format($opening_balance, 2); ?></div>
                            </div>
                            <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
                                <div class="heading">Total Credits (Period)</div>
                                <div class="heading2"><?php echo number_format($total_credits, 2); ?></div>
                            </div>
                            <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
                                <div class="heading">Total Debits (Period)</div>
                                <div class="heading2"><?php echo number_format($total_debits, 2); ?></div>
                            </div>
                            <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
                                <div class="heading">Closing Balance (As of Today)</div>
                                <div class="heading2"><?php echo number_format($closing_balance, 2); ?></div>
                            </div>
                        </div>



    <div class="row match-height">
        <div class="col-md-12" style="padding: 0 28px;">
            <div class="card">

                <div class="card-body collapse in">
                    <div class="card-block" style="padding: 20px;">

                      

                       

                        <h5 class="mt-2">Detailed Transactions</h5>
                        <div style="clear: both;">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success" id="flash_message" style="text-align: center;padding: 6px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?php echo $this->session->flashdata('success'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger" id="flash_message" style="text-align: center;padding: 6px;">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="datatable" class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Employee Contribution</th>
                                        <th class="text-right">Employer Contribution</th>
                                        <th class="text-right">Other Credit</th>
                                        <th class="text-right">Running Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo date("d M Y", strtotime($start_date)); ?></td>
                                        <td>Opening Balance</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right"><?php echo number_format($opening_balance, 2); ?></td>
                                    </tr>
                                    <?php if (!empty($transactions)): ?>
                                        <?php foreach ($transactions as $trans): ?>
                                            <tr>
                                                <td><?php echo date("d M Y", strtotime($trans->date)); ?></td>
                                                <td><i class="<?php echo $trans->icon_class; ?>"></i>
                                                    <?php echo $trans->description; ?></td>
                                                <td
                                                    class="text-right <?php echo ($trans->type == 'debit') ? 'text-danger' : ''; ?>">
                                                    <?php echo ($trans->type == 'debit') ? number_format($trans->amount, 2) : ''; ?>
                                                </td>
                                                <td
                                                    class="text-right <?php echo ($trans->description == 'Contribution') ? 'text-success' : ''; ?>">
                                                    <?php echo ($trans->description == 'Contribution') ? number_format($trans->employee_contrib_amount, 2) : ''; ?>
                                                </td>
                                                <td
                                                    class="text-right <?php echo ($trans->description == 'Contribution') ? 'text-success' : ''; ?>">
                                                    <?php echo ($trans->description == 'Contribution') ? number_format($trans->employer_contrib_amount, 2) : ''; ?>
                                                </td>
                                                <td
                                                    class="text-right <?php echo ($trans->type == 'credit' && $trans->description != 'Contribution') ? 'text-success' : ''; ?>">
                                                    <?php echo ($trans->type == 'credit' && $trans->description != 'Contribution') ? number_format($trans->amount, 2) : ''; ?>
                                                </td>
                                                <td class="text-right"><?php echo number_format($trans->running_balance, 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No transactions found.</td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th colspan="6" class="text-right">Closing Balance as of
                                            <?php echo date("d M Y", strtotime($end_date)); ?></th>
                                        <th class="text-right"><?php echo number_format($closing_balance, 2); ?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; // End has_pf_account check ?>
    
<script>
    function getdata(status) {

        // console.log(status.id);
        if (status.id == 'datef') {
            var firstdate = document.getElementById('datef').value
            var seconddate = document.getElementById('datef').value
        } else if (status.id == 'month') {
            var date = new Date(document.getElementById('month').value);


            var firstDate = new Date(date.getFullYear(), date.getMonth(), 2);

            // Get the last date of the month by setting the day to 0 (which gives the last day of the previous month) and adding 1 day
            var lastDate = new Date(date.getFullYear(), date.getMonth() + 1, 1);

            // Format the dates as strings in the format 'YYYY-MM-DD'
            var firstdate = firstDate.toISOString().slice(0, 10);
            var seconddate = lastDate.toISOString().slice(0, 10);

        } else if (status.id == 'year') {
            var date = document.getElementById('year').value;
            var firstDate = new Date(date, 0, 1); // Month is zero-based, so 0 represents January
            var lastDate = new Date(date, 11, 31); // Month is zero-based, so 11 represents December

            // Format the dates as strings
            var firstdate = firstDate.toDateString();
            var seconddate = lastDate.toDateString();
        }
        $.ajax({
            url: '<?php echo base_url('admin/provident_fund/my_fund_details'); ?>', // Changed URL to provident_fund
            method: 'POST',
            data: {
                firstdate: firstdate,
                seconddate: seconddate
            },
            success: function (resp) {
                // Assuming the response contains the updated table body
                // You might need to adjust this based on how the controller returns data
                $('#datatable').empty(); // Assuming there's a div with id 'datatable' for the table
                $('#datatable').html(resp);
            }
        });
    }
</script>

<script>
    function getyarly_data() {
        var year = document.getElementById('year').value;
        Swal.fire({
            title: 'You Selected ' + year,
            text: 'If not please select another year',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Generate it!'
        }).then((result) => {
            if (result.value) {
                var url = '<?php echo base_url('admin/reports/getyarly_data'); ?>'; // This might need to be adjusted based on where the yearly report is generated for provident fund
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: { year: year },
                    success: function (resp) {
                        var a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
                        a.document.write(resp);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error generating the report'
                        });
                    }
                });
            }
        });
    }
</script>