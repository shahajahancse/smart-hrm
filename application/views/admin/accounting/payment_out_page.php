<style>
.container {
    max-width: -webkit-fill-available;
}

.modal {
    z-index: 11111111111111111111 !important;
}

.row1 {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 20px;
}

.DivStatsInfo {
    flex-basis: calc(25% - 20px);
    height: 92px;
    position: relative;
    border-radius: 5px;
    border: 1px #E5E5E5 solid;
    margin-bottom: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 7px;
}

.Heading {
    text-align: center;
    color: #1F1F1F;
    font-size: 16px;
    font-weight: 400;
    margin-bottom: 10px;
}

.Amount {
    text-align: center;
    color: #1F1F1F;
    font-size: 17px;
    font-weight: 500;
}

.Frame32 {
    width: 100%;
    display: flex;
    align-items: center;
    margin-top: 20px;
    flex-direction: row;
}

.addbtn {
    color: black;
    font-size: 15px;
    font-weight: 400;
    line-height: 22.5px;
    margin-bottom: 10px;
}

.Link {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
    padding: 10px 20px;
    text-transform: uppercase;
}

.AddAmount {
    color: white;
    font-size: 15px;
    font-weight: 400;
    background: #599AE7;
    margin: 0;
    padding: 6px 13px;
    border-radius: 3px;
    cursor: pointer;
}

@media (max-width: 990px) {
    .row1 {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-direction: column;
        flex-wrap: wrap;
    }

    .Frame32 {
        width: 100%;
        display: flex;
        align-items: center;
        margin-top: 20px;
        flex-direction: column;
    }

}

@media (max-width: 768px) {
    .DivStatsInfo {
        flex-basis: calc(50% - 20px);
    }
}

.btn-primary .badge {
    color: #ffffff;
    background-color: #f00;
    border-radius: 40%;
    display: inline;
}

.listd {
    box-shadow: 0px 0px 0px 1px #c1c1c1;
    margin: 5px;
}

.listd:hover {
    box-shadow: 0px 0px 5px 2px #c1c1c1;
}

td,
th {
    padding: 6px !important;
}


.inputBox {
    position: relative;
    width: 100%;
}

.inputBox input {
    padding: 6px 20px;
    outline: none;
    background: transparent;
    border-radius: 5px;
    color: #000;
    border: 1px solid #7a7a7a;
    font-size: 1em;
    width: 100%;
}

.inputBox select {
    padding: 6px 20px;
    outline: none;
    background: transparent;
    border-radius: 5px;
    color: #000;
    border: 1px solid #7a7a7a;
    font-size: 1em;
    width: 100%;
}

.inputBox strong {
    font-size: 0.8em;
    padding: 0px 4px;
    margin: -1px 1px 1px 11px;
    border-radius: 2px;
    background: #fff;
    letter-spacing: 0em;
    position: absolute;
    top: -9px;
    z-index: 2;
}

.add-payment-out {
    position: relative;
    background-color: var(--white);
    width: 100%;
    height: fit-content;
    display: flex;
    gap: 29px;
    text-align: left;
    font-size: var(--font-size-mini);
    color: var(--color-gray-100);
    font-family: var(--font-roboto);
    flex-direction: column;
}
</style>
<?php
// Assuming you have already loaded the database library in CodeIgniter

$currentMonth = date('m');
$firstDate = date('Y-' . $currentMonth . '-01');
$lastDate = date('Y-' . $currentMonth . '-t');

$this->db->select_sum('amount'); // Calculates the total amount
$this->db->from('xin_payment_out_invoice');
$this->db->where('date >=', $firstDate);
$this->db->where('date <=', $lastDate);
$query = $this->db->get();

if ($query->num_rows() > 0) {
    $result = $query->row();
    $totalAmount_monthly = 0 + $result->amount;
} else {
    $totalAmount_monthly = 0;
}

$this->load->helper('date');
$currentWeekStart = date('Y-m-d', strtotime('monday this week'));
$currentWeekEnd = date('Y-m-d', strtotime('sunday this week'));

$this->db->select_sum('amount');
$this->db->from('xin_payment_out_invoice');
$this->db->where('date >=', $currentWeekStart);
$this->db->where('date <=', $currentWeekEnd);
$query = $this->db->get();

if ($query->num_rows() > 0) {
    $result = $query->row();
    $totalAmount_week = 0 + $result->amount;

} else {
    $totalAmount_week = 0;
}

$this->db->select_sum('amount');
$this->db->from('xin_payment_out_invoice');
$this->db->where('date', date('Y-m-d'));
$query = $this->db->get();

$totalAmount_today = 0;
if ($query->num_rows() > 0) {
    $result = $query->row();
    $totalAmount_today = 0 + $result->amount;
} else {
    $totalAmount_today = 0;
}

$currentYear = date('Y');
$firstDateOfYear = $currentYear . '-01-01';
$lastDateOfYear = $currentYear . '-12-31';

$this->db->select_sum('amount');
$this->db->where('date >=', $firstDateOfYear);
$this->db->where('date <=', $lastDateOfYear);
$query = $this->db->get('xin_payment_out_invoice');

$totalAmount_year = 0;
if ($query->num_rows() > 0) {
    $result = $query->row();
    $totalAmount_year = 0 + $result->amount;
}
?>
<div class="container">
    <div class="row1">
        <div class="DivStatsInfo" style="background: #D1ECF1;">
            <div class="Heading">Today Expense</div>
            <div class="Amount"><?=$totalAmount_today?></div>
        </div>
        <div class="DivStatsInfo" style="background: #F1CFEE;">
            <div class="Heading">This Week Expense</div>
            <div class="Amount"><?=$totalAmount_week?></div>
        </div>
        <div class="DivStatsInfo" style="background: #FDDCDF;">
            <div class="Heading"><?=date('M')?> Month Expense</div>
            <div class="Amount"><?=$totalAmount_monthly?></div>
        </div>
        <div class="DivStatsInfo" style="background: #D2F9EE;">
            <div class="Heading"><?=date('Y')?> Year Total Payment</div>
            <div class="Amount"><?=$totalAmount_year?></div>
        </div>
    </div>
    <div class="Frame32">
        <div class="addbtn col-md-8">Want to Out an amount? Please make sure to enter the amount and purpose.</div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal_payout">Add Payment
            Out</button>
    </div>
</div>
<div id="myModal_payout" class="modal fade" role="dialog" style="z-index: 1111111111111111111 !important;">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Payment Out From</h4>
            </div>
            <!-- Modal Body -->
            <form id="payout_form">
                <div class="modal-body">
                    <div class="add-payment-out">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="inputBox">
                                    <strong>Purpose Of Costing<b style="color: red;">**</b></strong>
                                    <select name="purposes" id="purposes" class="col-md-12">
                                        <option>Select Purpose</option>
                                        <?php foreach ($purposes as $key => $value) {
                                            echo '<option value="' . $value->id . '">' . $value->title . '</option>';
                                        }
                                        ;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="inputBox">
                                    <strong>Amount<b style="color: red;">**</b></strong>
                                    <input type="text" name="amount" id="amount" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="inputBox">
                                    <strong>Date<b style="color: red;">**</b></strong>
                                    <input type="date" name="date" id="date" value="<?=date('Y-m-d')?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="inputBox">
                                    <strong>Expense Type<b style="color: red;">**</b></strong>
                                    <select name="Expense_Type" id="Expense_Type" class="col-md-12">
                                        <option>Select type</option>
                                        <option value="5">Daily</option>
                                        <option value="2">Weekly</option>
                                        <option value="3">Monthly</option>
                                        <option value="4">Yearly</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="inputBox">
                                    <strong>Payment Way<b style="color: red;">**</b></strong>
                                    <select name="Payment_Way" id="Payment_Way" class="col-md-12">
                                        <option>Select Status type</option>
                                        <option value='Bkash'>Bkash</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="inputBox">
                                    <strong>Remark</strong>
                                    <textarea name="note" id="" style="width: 100%; height: 63px;"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
        </div>
        </form>
    </div>
</div>

<div>
    <script>
    $(document).ready(function() {
        $('#invoicesTable').DataTable();
    });
    </script>
    <table id="invoicesTable" class="col-md-12">
        <thead>
            <tr>
                <th>SL</th>
                <th>Purposes</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Expense Type</th>
                <th>Payment Way</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
foreach ($table_data as $key => $row) {
    ?>
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $row->title; ?></td>
                <td><?php echo $row->amount; ?></td>
                <td><?php echo $row->date; ?></td>
                <td>
                    <?php
$expenseType = $row->Expense_Type;
    if ($expenseType == 5) {
        echo "daily";
    } elseif ($expenseType == 2) {
        echo "weekly";
    } elseif ($expenseType == 3) {
        echo "monthly";
    } elseif ($expenseType == 4) {
        echo "yearly";
    }
    ?>
                </td>
                <td><?php echo $row->Payment_Way; ?></td>
                <td><?php echo $row->note; ?></td>
                <td><a class="btn btn-primary btn-sm">Action</a></td>
            </tr>
            <?php
}
?>
        </tbody>
    </table>

</div>
<script>
function get_invoice_n(params) {
    $.ajax({
        url: "<?=base_url('admin/project/get_invoice_n/')?>",
        type: "POST",
        data: {
            id: params
        },
        success: function(data) {


            var a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
            a.document.write(data);
        }

    });
}
</script>
<script>
$(document).ready(function() {
    $('#purposes').on('change', function() {
        var id = $(this).val();

        $.ajax({
            url: '<?=base_url('admin/accounting/get_purposes_amount')?>',
            method: 'GET',
            data: {
                id: id
            },
            success: function(responseData) {
                var parsedData = JSON.parse(responseData);
                $('#amount').val(parsedData.amount)
                $('#Expense_Type').val(parsedData.expense_type)
            },
            error: function(xhr, status, error) {
                // Handle any errors
                console.log(error);
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    $('#payout_form').submit(function(event) {
        // Prevent the default form submission
        event.preventDefault();
        // Get the form data
        var formData = $(this).serialize();
        $.ajax({
            url: '<?=base_url('admin/accounting/payout_form_submit')?>',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response === 'success') {
                    $('#myModal_payout').modal('hide');
                    showSuccessAlert(response);
                } else {
                    // Handle validation errors or empty fields
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the Ajax request
                console.log(error);
            }
        });
    });
});
</script>