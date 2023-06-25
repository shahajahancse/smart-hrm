<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

<style>
.addbox {
    min-height: 49px;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    line-height: 1.5;
}

.panels {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.6s ease-out;
}

.payment_box {
    opacity: 0;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    transition: max-height 0.2s ease-out, opacity 0.2s ease-out;
}

.p {
    margin: 0 !important;
    padding: 0 !important;
}

.btn {
    float: right;
    padding: 5px;
    font-weight: bold;
}

.panels.open {
    max-height: 1000px;
    margin-top: 11px;
    margin-bottom: 13px;
    opacity: 1;
    transition: max-height .6s ease-out, opacity .6s ease-out;
}

.section_box {
    width: 100%;
    background: #fffcf9;
    height: fit-content;
    margin: 3px;
    padding: 13px;
    border-radius: 5px;
    box-shadow: inset 5px 3px 20px 7px rgb(0 0 0 / 10%);
    overflow: auto;
}

.section-heding {
    font-weight: bold;
    font-size: 19px;
}

.list_box {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;

    color: #333;
}

.levels {
    font-size: 13px;
    font-weight: bold;
}
</style>

<div class="addbox">
    <p class="p" style="font-size: 25px; font-weight: bold; float: left;">Payment List</p>
    <a class="btn btn-primary accordion" onclick="togglePaymentBox()">Make Payment</a>
</div>

<div class="panels payment_box" id="paymentBox">
    <section class="section_box">
        <div class="col-md-12">
            <div class="form-group col-md-4">
                <p class="levels">Last Calculation Date</p>
                <input type="date" class="form-control" style="border-radius: 6px;"
                    value="<?= isset($result->to_date) ? $result->to_date : '0' ?>" disabled>
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Total Meal</p>
                <input type="number" class="form-control" style="border-radius: 6px;"
                    value="<?= isset($result->total_meal) ? $result->total_meal : '0' ?>" disabled>
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Total Amount</p>
                <input type="number" class="form-control" style="border-radius: 6px;"
                    value="<?= isset($result->net_payment) ? $result->net_payment : '0' ?>" disabled>
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Pay Amount</p>
                <input type="number" class="form-control" style="border-radius: 6px;"
                    value="<?= isset($result->paid_amount) ? $result->paid_amount : '0' ?>" disabled>
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Due</p>
                <input type="text" class="form-control" id="pre_due" style="border-radius: 6px;"
                    value="<?= isset($result->due) ? $result->due : '0' ?>" disabled>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group col-md-3">
                <p class="levels">From Date</p>
               
                <input type="date" class="form-control" id="from_date"
                    value="<?= isset($result->to_date) ? $result->to_date : '0' ?>" style="border-radius: 6px;">
            </div>
            <div class="form-group col-md-3">
                <p class="levels">To Date</p>
                <input type="date" class="form-control" onchange="calmeal()" id="to_date" style="border-radius: 6px;">
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Total Meal</p>
                <input type="text" class="form-control" id="total_meal" style="border-radius: 6px;" disabled>
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Total Amount</p>
                <input type="text" class="form-control" id="total_amount" style="border-radius: 6px;" disabled>
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Payable Amount</p>
                <input type="text" class="form-control" id="payable_amount" style="border-radius: 6px;" disabled>
            </div>
        </div>

        <div class="col-md-12" style="justify-content: right;display: inline-flex;">
            <div class="form-group col-md-2">
                <p class="levels">Pay Amount</p>
                <input type="number" class="form-control" onchange="caldue()" id="pay_amount"
                    style="border-radius: 6px;">
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Due Amount</p>
                <input type="number" class="form-control" id="due_amount" style="border-radius: 6px;" disabled>
            </div>
            <div class="form-group col-md-4">
                <p class="levels">Remarks</p>
                <textarea name="" cols="30" rows="1" class="form-control" id="remarks" style="border-radius: 6px;"></textarea>
            </div>
        </div>

        <div class="col-md-12">
            <a onclick="submit()" class="btn btn-primary" style="float: right;margin-right: 19px;">Submit</a>
        </div>
    </section>


</div>
<div class="list_box">
    <table class="table" id="myTable" style="text-align: center;">
        <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>P.Due</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Total Meal</th>
                <th>Pay Amount</th>
                <th>Net Payment</th>
                <th>Paid Amount</th>
                <th>Due</th>
                
                <th>Remarks</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payment_data as $key=>$row): ?>
            <tr>
                <td><?php echo $key+1 ?></td>
                <?php    $convert = date('d-m-Y', strtotime($row->date)); ?>
                <td><?php echo $convert; ?></td>
                <td><?php echo $row->previous_due; ?></td>
                <?php   
                $convertedDate = date('d-m-Y', strtotime($row->from_date));
                $convertedDate2 = date('d-m-Y', strtotime($row->to_date));
                
                ?>
                <td><?php echo $convertedDate  ?></td>
                <td><?php echo  $convertedDate2 ?></td>
                <td><?php echo $row->total_meal; ?></td>
                <td><?php echo $row->pay_amount; ?></td>
                <td><?php echo $row->net_payment; ?></td>
                <td><?php echo $row->paid_amount; ?></td>
                <td><?php echo $row->due; ?></td>
                
                <td style="text-align: center;" title="<?php echo $row->Remarks; ?>"><?php echo implode(' ', array_slice(explode(' ', $row->Remarks ), 0, 4)); ?></td>
        
               

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
<script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>

<script>
function togglePaymentBox() {
    var paymentBox = document.getElementById('paymentBox');
    paymentBox.classList.toggle('open');
}

function calmeal() {
    var first_date = $('#from_date').val();
    var second_date = $('#to_date').val();
    if (first_date>second_date) 
        {
        alert('Please select valid Date');
        document.getElementById('to_date').value = first_date;
        return false;
     }
   
    // Prepare the data object
    var data = {
        first_date: first_date,
        second_date: second_date
    };
    url = '<?= base_url('/admin/lunch/get_payment_data/')?>'

    // Send AJAX request
    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function(response) {
            if (response == 0) {
                        document.getElementById('total_meal').value = response;
                var total_amount = response * 90
                document.getElementById('total_amount').value = total_amount;
                var pre_due = document.getElementById('pre_due').value;
                var payable_amount = parseInt(parseInt(total_amount) + parseInt(pre_due));
                document.getElementById('payable_amount').value = payable_amount;
            } else {

                document.getElementById('total_meal').value = response;
                var total_amount = response * 90
                document.getElementById('total_amount').value = total_amount;
                var pre_due = document.getElementById('pre_due').value;
                var payable_amount = parseInt(parseInt(total_amount) + parseInt(pre_due));
                document.getElementById('payable_amount').value = payable_amount;
            }

        },
        error: function(xhr, status, error) {
            // Handle errors
            console.log(xhr.responseText);
        }
    });
}

function caldue() {
    var pay_amount = document.getElementById('pay_amount').value
    var payable_amount = document.getElementById('payable_amount').value
    document.getElementById('due_amount').value = parseInt(payable_amount) - parseInt(pay_amount)
}
</script>
<script>
function submit() {
    var pre_due = document.getElementById('pre_due').value;
    var fromDate = document.getElementById('from_date').value;
    var toDate = document.getElementById('to_date').value;
    var totalMeal = document.getElementById('total_meal').value;
    var totalAmount = document.getElementById('total_amount').value;
    var payableAmount = document.getElementById('payable_amount').value;
    var dueAmount = document.getElementById('due_amount').value;
    var payAmount = document.getElementById('pay_amount').value;
    var remarks = document.getElementById('remarks').value;

    // Create an object with the input data
    var inputData = {
        pre_due: pre_due,
        fromDate: fromDate,
        toDate: toDate,
        totalMeal: totalMeal,
        totalAmount: totalAmount,
        payableAmount: payableAmount,
        dueAmount: dueAmount,
        payAmount: payAmount,
        remarks: remarks
    };
    url = '<?= base_url('/admin/lunch/make_payment/')?>'

    // Make an AJAX request to send the input data
    // Replace the URL with your actual server endpoint
    $.ajax({
        url: url,
        type: 'POST',
        data: inputData,
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: response,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        },
        error: function(xhr, status, error) {
            // Handle the error
            console.log('AJAX request error');
            console.log(xhr.responseText);
        }
    });
}
</script>