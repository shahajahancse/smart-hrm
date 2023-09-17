<style>
.listprimari {
    border: 1px solid #009312;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
    width: 100%;
    display: inline-block;
}

.column {
    border-radius: 12px;
    background-color: #f5f5f5;
    padding: 20px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.listdanger {
    border: 1px solid #f00;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
    color: black;
    width: 100%;
    display: inline-block;
    cursor: pointer;
}

.ulclasss {
    padding: 10px;
    overflow: auto;
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
}
</style>
<div style="display: flex;flex-direction: column;gap: 19px;">
    <div class="col-md-12" style="padding:4px;display: flex;gap: 24px;">
        <div class="col-md-6 column" style="padding:0px;height: 218px;overflow: auto;">
            <span
                style="width: 100%;background: #adadad;display: block;text-align: center;font-size: 19px;position: sticky;top: 0;color: black;height: 34px;">Unpaid
                Project</span>
            <ul style="list-style: none;background: #e7e7e7;padding: 11px">
                <?php if (count($soft_payment_data)>0){
             foreach ($soft_payment_data as $key => $value) { ?>
                <li class="listdanger" onclick="get_instdata(<?=$value->project_id?>)">
                    <span><b>Client Name : </b><?= $value->client_name ?></span><br>
                    <span><b>Project Name : </b><?= $value->title ?></span><br>
                    <span><b>Instalment Date:</b><?= $value->next_installment_date ?></span><br>
                </li>
                <?php  } }else{ ?>
                <span> There Is No Data</span>
                <?php } ?>

            </ul>
        </div>
        <!-- <div class="col-md-6 column" style="padding:0px;height: 218px;overflow: auto;">
            <span
                style="width: 100%;background: #adadad;display: block;text-align: center;font-size: 19px;position: sticky;top: 0;color: black;height: 34px;">Installment</span>

            <div id="listdata"> <span> Please Select A Project</span>
            </div>
        </div> -->
    </div>

    <div class="box" style="padding: 29px 6px;display: none;" id="installment_section">
        <div class="col-md-12 bg-white">
            <h5>Installment Section </h5>
            <div id="deusectionenable" style="display:none">
                <h5 style="color:red">This Is Last Installment Please Get All Payment</h5>
                <h5> Do you want to Payment with Deu
                    <input type="checkbox" id="ifpaymentin" checked>
                </h5><br>
            </div>

            <form id="payment_in_form" style="display: flex;flex-direction: column;gap: 16px;">
                <input type="hidden" name="project_id" id="project_id">
                <input type="hidden" name="client_id" id="client_id">
                <input type="hidden" name="number" id="number">

                <div class="row">
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Client name <b style="color: red;">*</b></strong>
                            <input type="text" id="client_name" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Project name <b style="color: red;">*</b></strong>
                            <input type="text" id="title" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Installment Date<b style="color: red;">*</b></strong>
                            <input type="date" id="installment_date" value="<?= date('Y-m-d')?>"
                                name="installment_date">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Total Budget<b style="color: red;">*</b></strong>
                            <input type="number" id="total_budget" name="total_budget" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Payment Received<b style="color: red;">*</b></strong>
                            <input type="number" name="payment_received" id="payment_received" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Remaining Payment<b style="color: red;">*</b></strong>
                            <input type="number" name="remaining_payment" id="remaining_payment" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Today Payment<b style="color: red;">*</b></strong>
                            <input type="number" name="today_payment" onkeyup=showPaymentValue() id="today_payment"
                                required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Latest Remaining Payment<b style="color: red;">*</b></strong>
                            <input type="number" name="latest_remaining_payment" id="latest_remaining_payment" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Payment Way<b style="color: red;">*</b></strong>
                            <input type="text" name="payment_way" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Installment No.<b style="color: red;">*</b></strong>
                            <input type="number" name="installment_no" id="installment_no" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Next Installment Date<b style="color: red;">*</b></strong>
                            <input type="date" name="next_installment_date" id="next_installment_date" required>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row" style="padding: 1px 14px;">
            <button type="submit" style="float: right;" class="btn btn-primary">Payment In</button>
        </div>
        </form>
    </div>
</div>
<script>
function get_instdata(project_id) {

    $.ajax({
        url: '<?php echo base_url('admin/project/get_instalment_data/');?>',
        type: 'POST',
        data: {
            project_id: project_id
        },
        success: function(data) {
            $('#installment_section').slideDown();
            var parsedData = JSON.parse(data);
            console.log(parsedData.soft_payment_data);
            var pay_data = parsedData.soft_payment_data
            // return false;
            let installment_date = new Date(pay_data.next_installment_date);
            let formattedDate = installment_date.toISOString().substring(0, 10);
            $('#project_id').val(parsedData.project_id);
            $('#number').val(parsedData.number);
            $('#client_name').val(pay_data.client_name);
            $('#title').val(pay_data.title);
            $('#installment_date').val(formattedDate);
            $('#client_id').val(pay_data.clint_id);
            $('#total_budget').val(pay_data.software_budget);
            $('#payment_received').val(pay_data.Payment_Received);
            $('#remaining_payment').val(pay_data.Remaining_Payment);
            $('#today_payment').val(0);
            $('#today_payment').attr('max', pay_data.Remaining_Payment);
            $('#latest_remaining_payment').val(pay_data.Remaining_Payment);
            var intValue = parseInt(parsedData.number) + 1;
            $('#installment_no').val(intValue);
            console.log(pay_data.soft_total_installment);
            if (pay_data.soft_total_installment <= intValue) {
                $('#ifpaymentin').prop('checked', false);
                // console.log('hello');
            }
        }
    });
}
</script>
<script>
function showPaymentValue() {
    var paymentAmount = document.getElementById("today_payment").value;
    let deu = parseInt(($('#remaining_payment').val()) - paymentAmount);
    $('#latest_remaining_payment').val(deu);
}

$(document).ready(function() {
    $('#payment_in_form').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        if (!$('#ifpaymentin').is(':checked')) {
            if (!$('#latest_remaining_payment').val()==0) {
                $('#deusectionenable').css('display', 'block');
                return false;
            };
        }
        return false;

        var formData = $(this).serialize();
        $.ajax({
            url: '<?php echo base_url('admin/project/payment_in_form/');?>',
            type: 'POST', // Set the request method (GET, POST, etc.)
            data: formData, // Pass the serialized form data
            success: function(response) {
                console.log(response);
                var url = '<?php echo base_url('admin/project/get_payment_page');?>';
                showSuccessAlert(response, url);
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the request
                console.error(error);
            }
        });
    });
});
</script>