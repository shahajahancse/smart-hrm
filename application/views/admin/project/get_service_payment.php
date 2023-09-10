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
                Service</span>
            <ul style="list-style: none;background: #e7e7e7;padding: 11px">
                <?php if (count($service_payment_data)>0){
             foreach ($service_payment_data as $key => $value) { ?>
                <li class="listdanger" onclick="get_instdata(<?=$value->service_id?>)">
                    <span><b>Client Name : </b><?= $value->client_name ?></span><br>
                    <span><b>Project Name : </b><?= $value->title ?></span><br>
                    <span><b>Payment Date Date:</b><?= $value->payment_date ?></span><br>
                </li>
                <?php  } }else{ ?>
                <span> There Is No Data</span>
                <?php } ?>
            </ul>
        </div>
        <div class="col-md-6 column" style="padding:0px;height: 218px;overflow: auto;">
            <span
                style="width: 100%;background: #adadad;display: block;text-align: center;font-size: 19px;position: sticky;top: 0;color: black;height: 34px;">Service</span>

            <div id="listdata"> <span> Please Select A Project</span>
            </div>
        </div>
    </div>

    <div class="box" style="padding: 29px 6px;display: none;" id="installment_section">
        <div class="col-md-12 bg-white">
            <h5>Payment Section </h5>
            <form id="payment_in_form" style="display: flex;flex-direction: column;gap: 16px;">
                <input type="hidden" name="service_id" id="service_id">
                <input type="hidden" name="project_id" id="project_id">
                <input type="hidden" name="client_id" id="client_id">
                <div class="row">
                    <div class="col-md-2">
                        <div class="inputBox">
                            <strong>Client name <b style="color: red;">*</b></strong>
                            <input type="text" id="client_name" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="inputBox">
                            <strong>Project name <b style="color: red;">*</b></strong>
                            <input type="text" id="title" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="inputBox">
                            <strong>Payment Date<b style="color: red;">*</b></strong>
                            <input type="date" id="installment_date">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="inputBox">
                            <strong>Total Payment<b style="color: red;">*</b></strong>
                            <input type="text" name="amount" id="total_payment"  readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="inputBox">
                            <strong>Payment Way<b style="color: red;">*</b></strong>
                            <input type="text" name="payment_way" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                    <div class="inputBox">
                    <strong>Service Status<b style="color: red;">*</b></strong>
                        <select name="status" id="status" class="col-md-12">
                            <option>Select Status type</option>
                            <option value=0 >Unpaid</option>
                            <option value=1 >Paid</option>
                        </select>
                    </div>
                </div>
                </div>
                <div class="row" style="padding: 1px 14px;">
                    <button type="submit" style="float: right;" class="btn btn-primary">Payment In</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function get_instdata(service_id) {

    $.ajax({
        url: '<?php echo base_url('admin/project/get_service_data/');?>',
        type: 'POST',
        data: {
            service_id: service_id
        },
        success: function(data) {
            try {
                var parsedData = JSON.parse(data); // Parse the JSON response
                // console.log(parsedData.service_payment_data);
                // return false;

                    var listdataElement = document.getElementById("listdata");
                    var ul = document.createElement("ul");
                    ul.className = "ulclasss";

                    // Loop through the installment data and create list items
                    for (var i = 0; i < parsedData.service_payment_data.length; i++) {
                        var item = parsedData.service_payment_data[i];
                        var li = document.createElement("li");
                            li.className = "listdanger"; // Add the listdanger class
                            li.onclick = function() {
                                getpaymentofinstallments(item);
                            }
                        
                        li.innerHTML = "<b>Date:</b> " + item.payment_date + "<br><b>Payment:</b> " + item
                            .amount + "<br><b>Status:</b> Unpaid";
                        ul.appendChild(li);
                    }
                    // Clear previous content and append the new list
                    listdataElement.innerHTML = "";
                    listdataElement.appendChild(ul);
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        }
    });
}
</script>
<script>
function getpaymentofinstallments(data) {
    console.log(data);
            $('#installment_section').slideDown();
            let installment_date = new Date(data.payment_date);
            let formattedDate = installment_date.toISOString().substring(0, 10);
            $('#project_id').val(data.project_id);
            $('#client_id').val(data.client_id);
            $('#service_id').val(data.id);
            $('#client_name').val(data.client_name);
            $('#title').val(data.title);
            $('#installment_date').val(formattedDate);
            $('#total_payment').val(data.amount);
            $('#status').val(data.status);
}
</script>
<script>
$(document).ready(function() {
    $('#payment_in_form').submit(function(event) {
        event.preventDefault(); // Prevent the form from submitting normally
        var formData = $(this).serialize();
        $.ajax({
            url: '<?php echo base_url('admin/project/payment_in_form_service/');?>',
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