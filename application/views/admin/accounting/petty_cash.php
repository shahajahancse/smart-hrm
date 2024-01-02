<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?=base_url('skin/hrsale_assets/css/lunch_emp_bill.css')?>">
<style>
.divrow {
    position: relative;
    text-align: center;
    display: flex;
    gap: 17px;
    margin-top: 40px;
}
.content {
    display: flex;
    flex-direction: column;
}

</style>
<div class="monthname">
    Petty Cash Summery of <input id="get_date" type="date" value="<?= date('Y-m-d') ?>"
        style="border-radius: 10px;border: none;padding: 4px;box-shadow: inset 0px 0px 2px 1px #c1b9b9;"
        onchange="get_data()">
</div>
<div class="divrow col-md-12">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="heading">Previous Balance</div>
        <div class="heading2" id="previous_balance_data"></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="heading">Today Balance</div>
        <div class="heading2" id="today_balance_data">

        </div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
        <div class="heading">Today Expenses</div>
        <div class="heading2" id="today_expenses_data">

        </div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
        <div class="heading">Rest Amount</div>
        <div class="heading2" id="rest_amount_data"></div>
    </div>
</div>
<div class="col-md-12" style="margin: 10px 0px;display: flex;justify-content: flex-end;">
    <div>
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cashinmodal">Cash In</button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cashoutmodal">Cash Out</button>

        <!-- Modal -->
        <div id="cashinmodal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form id="cashinform">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Today Cash In </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="cash_received_from">Cash Received From</label>
                                    <input type="text" class="form-control" id="cash_received_from"
                                        name="cash_received_from">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="received_amount">Amount</label>
                                    <input type="number" class="form-control" id="received_amount"
                                        name="received_amount">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="cashoutmodal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <form id="cashoutform">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Today Cash Out </h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="cash_received_from">Purpose</label>
                                        <input type="text" class="form-control" id="cash_out_purpose"
                                            name="cash_out_purpose">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="received_amount">Details</label>
                                        <input type="text" class="form-control" id="cash_out_details"
                                            name="cash_out_details">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="cash_received_from">Amount</label>
                                        <input type="number" class="form-control" id="cash_out_amount"
                                            name="cash_out_amount">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="received_amount">Remarks</label>
                                        <textarea class="form-control" id="cash_out_remarks" name="cash_out_remarks">

                                        </textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12" style="display: flex; gap: 10px">
    <div class="col-md-6 " style="box-shadow: 0px 0px 6px 2px #c9c9c9;padding: 6px;">
     <h4>Cash Out</h4>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Item Name</th>
                    <th>Details</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody id="cash_out_data">
            </tbody>
        </table>
    </div>

    <div class="col-md-6" style="box-shadow: 0px 0px 6px 2px #c9c9c9;padding: 6px;">
     <h4>Cash In</h4>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Cash Received From</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody id="cash_in_data">
            </tbody>
        </table>
    </div>
    
</div>





<script>
$(document).on('submit', '#cashinform', function(e) {
    e.preventDefault();
    var form = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: '<?= base_url('admin/accounting/petty_cash_in') ?>',
        data: form,
        success: function(data) {
            if (data === 'success') {
                $('#cashinmodal').modal('hide');
                showMessage('success', 'Cash In Success');
                get_data();

            } else {
                $('#cashinmodal').modal('hide');
                showErrorAlert('Cash In Failed');
            }
        }
    });
});
</script>
<script>
$(document).on('submit', '#cashoutform', function(e) {
    e.preventDefault();
    var form = $(this).serialize();
    $.ajax({
        type: 'POST',
        url: '<?= base_url('admin/accounting/petty_cash_out') ?>',
        data: form,
        success: function(data) {
            if (data === 'success') {
                $('#cashoutmodal').modal('hide');
                showMessage('success', 'Cash Out Success');
                get_data();

            } else {
                $('#cashoutmodal').modal('hide');
                showErrorAlert('Cash Out Failed');
            }
        }
    });
});
</script>
<script>
function get_data() {
    var date = $('#get_date').val();
    $.ajax({
        type: 'get',
        url: '<?= base_url('admin/accounting/get_data_petty_cash') ?>',
        data: {
            'date': date
        },
        success: function(json) {
            var data = JSON.parse(json);
            if (data.status == 'error') {
                $('#previous_balance_data').html(data.previous_balance);
                $('#today_balance_data').html(0);
                $('#today_expenses_data').html(0);
                $('#rest_amount_data').html(data.previous_balance);
                $('#cash_in_data').html('There is no data');
                $('#cash_out_data').html('There is no data');
            } else {
                console.log(data);
                var card_data = data.petty_cash_data;
                var petty_cash_in_data = data.petty_cash_in_data;
                var petty_cash_out_data = data.petty_cash_out_data;

                $('#previous_balance_data').html(card_data.previous_balance);
                $('#today_balance_data').html(card_data.today_cash_in);
                $('#today_expenses_data').html(card_data.today_expenses);
                $('#rest_amount_data').html(card_data.rest_amount);
                if (petty_cash_in_data.length != 0) {
                    var table_data_in = '';
                    for (let index = 0; index < petty_cash_in_data.length; index++) {
                        const cash_in = petty_cash_in_data[index];
                        table_data_in += `<tr >
                                                <td>${index+1}</td>
                                                <td>${cash_in.received_to}</td>
                                                <td>${cash_in.amount}</td>
                                                <td></td>
                                            </tr>`

                    }
                } else {
                    table_data_in = '<tr><td colspan="4">There is no data</td></tr>';
                }

                if (petty_cash_out_data.length != 0) {

                    var table_data_out = '';
                    for (let index = 0; index < petty_cash_out_data.length; index++) {
                        const cash_out = petty_cash_out_data[index];
                         table_data_out += `<tr>
                                                <td>${index+1}</td>
                                                <td>${cash_out.purpose}</td>
                                                <td>${cash_out.details}</td>
                                                <td>${cash_out.amount}</td>
                                                <td>${cash_out.remarks}</td>
                                            </tr>`
                    }
                } else {
                    table_data_out = '<tr><td colspan="5">There is no data</td></tr>';

                }
                $('#cash_in_data').empty();

                $('#cash_out_data').empty();

                $('#cash_in_data').append(table_data_in);

                $('#cash_out_data').append(table_data_out);
            }
        }
    })
}
$(document).ready(function() {
    get_data();
})
</script>