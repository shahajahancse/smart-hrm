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
    color: red;
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

/* 
.inputBox input:focus~strong,
.inputBox input:valid~strong {
    font-size: 0.8em;
    transform: translateX(9px) translateY(-10.5px);
    padding: 0 5px;
    border-radius: 2px;
    background: #fff;
    letter-spacing: 0em;
}

.inputBox select:focus~strong,
.inputBox select:valid~strong {
    font-size: 0.8em;
    transform: translateX(9px) translateY(-10.5px);
    padding: 0 5px;
    border-radius: 2px;
    background: #fff;
    letter-spacing: 0em;

} */
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
        <div class="col-md-6 column" style="padding:0px;height: 218px;overflow: auto;">
            <span
                style="width: 100%;background: #adadad;display: block;text-align: center;font-size: 19px;position: sticky;top: 0;color: black;height: 34px;">Installment</span>

            <div id="listdata"> <span> Please Select A Project</span>
            </div>
        </div>
    </div>

    <div class="box" style="padding: 29px 6px;display: none;" id="installment_section">
        <div class="col-md-12 bg-white">
            <h5>Installment Section </h5>
            <form id="payment_in_form" style="display: flex;flex-direction: column;gap: 16px;">
                <input type="hidden" name="project_id" id="project_id">
                <input type="hidden" name="client_id" id="client_id">
                <input type="hidden" name="number" id="number">
                <div class="row">
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Client name <b style="color: red;">*</b></strong>
                            <input type="text" id="client_name" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Project name <b style="color: red;">*</b></strong>
                            <input type="text" id="title" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Installment Date<b style="color: red;">*</b></strong>
                            <input type="date" id="installment_date" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Last Installment Due <b style="color: red;">*</b></strong>
                            <input type="number" id="last_deu" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="inputBox">
                            <strong>Installment Payment<b style="color: red;">*</b></strong>
                            <input type="number" id="installment_payment" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="inputBox">
                            <strong>Total Payment<b style="color: red;">*</b></strong>
                            <input type="text" id="total_payment" disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Payment<b style="color: red;">*</b></strong>
                            <input type="text" name="payment" id="pay_amount" onkeyup="showPaymentValue()" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="inputBox">
                            <strong>Due<b style="color: red;">*</b></strong>
                            <input type="text" name="payment_deu" id="deu" onkeyup="showPaymentValue()" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Payment Way<b style="color: red;">*</b></strong>
                            <input type="text" name="payment_way" required>
                        </div>
                    </div>
                    
                    <!-- <div class="col-md-3">
                        <div class="inputBox">
                            <strong>Deu<b style="color: red;">*</b></strong>
                            <input type="text" name="present" id="deu" disabled>
                        </div>
                    </div> -->
                </div>
                <div class="row" style="padding: 1px 14px;">
                    <button type="submit" style="float: right;" class="btn btn-primary">Payment In</button>
                </div>
            </form>
        </div>
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
            try {
                var parsedData = JSON.parse(data); // Parse the JSON response

                if (parsedData && parsedData.instdata && Array.isArray(parsedData.instdata)) {
                    var listdataElement = document.getElementById("listdata");
                    var ul = document.createElement("ul");
                    ul.className = "ulclasss";

                    // Loop through the installment data and create list items
                    for (var i = 0; i < parsedData.instdata.length; i++) {
                        var item = parsedData.instdata[i];
                        var li = document.createElement("li");
                        if (item.intmnt_status === "1") {
                            li.className = "listprimari"; // Add the listprimari class
                        } else {
                            li.className = "listdanger"; // Add the listdanger class
                            li.onclick = function() {
                                getpaymentofinstallments(i, parsedData.project_id);
                            }
                        }
                        li.innerHTML = "<b>Date:</b> " + item.intmnt_dates + "<br><b>Payment:</b> " + item
                            .intmnt_payments + "<br><b>Status:</b> " + (item.intmnt_status == 1 ? "Paid" :
                                "Unpaid");
                        ul.appendChild(li);
                        if (item.intmnt_status !== "1") {
                            break;
                        }
                    }
                    // Clear previous content and append the new list
                    listdataElement.innerHTML = "";
                    listdataElement.appendChild(ul);
                } else {
                    console.error("Invalid or missing instdata in the response.");
                }
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        }
    });
}
</script>
<script>
function getpaymentofinstallments(number, project_id) {
    $.ajax({
        url: '<?php echo base_url('admin/project/get_instalment_data/');?>',
        type: 'POST',
        data: {
            number: number,
            project_id: project_id
        },
        success: function(data) {
            $('#installment_section').slideDown();
            var parsedData = JSON.parse(data);
            console.log(parsedData);
            let installment_date = new Date(parsedData.instdata[number].intmnt_dates);
            let formattedDate = installment_date.toISOString().substring(0, 10);


            $('#project_id').val(parsedData.project_id);
            $('#number').val(number);
            $('#client_name').val(parsedData.soft_payment_data.client_name);
            $('#title').val(parsedData.soft_payment_data.title);
            $('#installment_date').val(formattedDate);
            $('#last_deu').val(parsedData.soft_payment_data.installment_deu);
            $('#installment_payment').val(parsedData.instdata[number].intmnt_payments);
            var totalPayment = parseInt(parsedData.soft_payment_data.installment_deu, 10) + parseInt(
                parsedData.instdata[number].intmnt_payments, 10);
            $('#total_payment').val(totalPayment);
            $('#pay_amount').val(totalPayment);
            $('#deu').val(0);
            $('#client_id').val(parsedData.soft_payment_data.clint_id);
        }
    });
}
</script>
<script>
function showPaymentValue() {
    var paymentAmount = document.getElementById("pay_amount").value;
    let deu = parseInt(($('#total_payment').val()) - paymentAmount);
    $('#deu').val(deu);
}

$(document).ready(function() {
    $('#payment_in_form').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        var formData = $(this).serialize();
        $.ajax({
            url: '<?php echo base_url('admin/project/payment_in_form/');?>',
            type: 'POST', // Set the request method (GET, POST, etc.)
            data: formData, // Pass the serialized form data
            success: function(response) {
                console.log(response);
                var url='<?php echo base_url('admin/project/get_payment_page');?>';
                showSuccessAlert(response,url);
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the request
                console.error(error);
            }
        });
    });
});
</script>