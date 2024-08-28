<?php
// dd($emplist);

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<style>
/* Custom CSS to increase the width of the select box */

.select2-container--default,
.select2-container--open {
    z-index: 0 !important;
}

#over_select2 span.select2-container--default {
    z-index: 0 !important;
}

h2 {
    margin-top: 3px;
}

/* Style for the form */
form {
    max-width: 1096px;

    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Style for the form fields */
.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
    font-size: 16px;
}

/* Style for the Process button */
.btn {
    display: inline-block;
    padding: 10px 20px;
    color: #fff;
    text-decoration: none;
    border-radius: 3px;
    font-size: 16px;
    transition: background-color 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

/* Box shadow effect for the form container */
.form-container {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Style for the process container */
.proccess_container {
    align-items: center;
    justify-content: center;
    background-color: #f5f5f5;
    border: 2px solid #000;
    width: 233px;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

.proccess_container:hover {
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
}

.proccess_container p {
    margin-bottom: 10px;
    font-weight: bold;
    text-align: center;
}

.proccess_container .btn {
    display: block;
    width: 100%;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 3px;
    font-size: 16px;
    transition: background-color 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.proccess_container .btn:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

#loading {
    visibility: hidden;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 3;
    /* set z-index higher than other elements */
    background-color: rgba(255, 255, 255, 0.8);
    /* semi-transparent background */
}

#loading img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<div id="loading">

    <img src="<?php echo base_url()?>skin/hrsale_assets/img/loding.gif">

</div>
<?php
// dd($last_prement);
?>
<div class="container" style="padding: 0;">
    <div class="content" style="padding: 0;margin: 0;min-height: 147px;">
        <!-- <div class="col-md-12" style="display: flex;"> -->
        <div class="container col-md-5" style="padding: 0;" id="over_select2">
            <h4 style="display: inline-block;">Last Process:</h4>
            <span
                style="color: blue;"><?php echo isset($last_prement->from_date)? date('d-m-Y', strtotime($last_prement->from_date)):'';?></span>
            to
            <span style="color: blue;">
                <?php echo isset($last_prement->end_date)? date('d-m-Y', strtotime($last_prement->end_date)):'';?></span>
            <?php
          if ($last_prement->end_date=='2023-06-15'){ } else{
            ?>
            <a style="padding: 2px;margin: 0;width: 80px;" class="btn btn-info" onclick='updateprocess()'>Update</a>

            <?php } ?>
            <input type="hidden"
                value="<?php echo isset($last_prement->from_date)? date('Y-m-d', strtotime($last_prement->from_date)):'';?>"
                id="from_dateu">
            <input type="hidden"
                value="<?php echo isset($last_prement->end_date)? date('Y-m-d', strtotime($last_prement->end_date)):'';?>"
                id="end_dateu">
            <input type="hidden"
                value="<?php echo isset($last_prement->next_date)? date('Y-m-d', strtotime($last_prement->next_date)):'';?>"
                id="next_dateu">

            <h2>Add Payment</h2>
            <select id="search-select">
                <option value="none">Select Employee</option>

                <?php  foreach($emplist as $data){?>
                <option value="<?= $data->user_id ?>"><?= $data->first_name ?> <?= $data->last_name ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="container col-md-7 form-container proccess_container"
            style="width: 599px;padding: 0px;border-radius: 10px;margin: 0;height: fit-content;margin-top: 8px;">
            <form id="process_form" class="col-md-12" style="padding: 9px;margin: 0px;">
                <div class="form-group col-md-3" style="padding: 0px;margin: 0px;">
                    <label for="process_date">First Date</label>
                    <input class="form-control attendance_date" id="process_date" name="process_date" type="text"
                        value="<?php echo isset($last_prement->from_date)? date('Y-m-d', strtotime($last_prement->end_date . ' +1 day')):'';?>"
                        disabled>
                </div>
                <div class="form-group col-md-3">
                    <label for="process_date">Second Date</label>
                    <input class="form-control"
                        min="<?php echo date('Y-m-d', strtotime($last_prement->end_date . ' +1 day')); ?>"
                        id="second_date" name="second_date" type="date" autocomplete="off">
                </div>
                <div class=" col-md-3">
                    <label for="process_date">Next Pay Date</label>
                    <input class="form-control" placeholder="<?php echo $this->lang->line('xin_select_date');?>"
                        id="probable_date" name="probable_date" type="date" autocomplete="off">
                </div>
                <div class="form-group col-md-3" style="margin: 0px;padding: 0px;float:right;">
                    <label for="" style="color: whitesmoke!important;">.</label>
                    <a class="btn btn-primary" style="margin: 0px;padding: 4px;" id="process_button">Process</a>
                </div>

            </form>
        </div>
        <!-- </div> -->
    </div>
</div>

<div id="form-container">

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
$lunch_package=lunch_package(date('Y-m-d'));

?>
<script>
$(document).ready(function() {
    // Event handler for the select box change event
    $('#search-select').on('change', function() {
        var selectedValue = $(this).val();
        $('#form-container').empty(); // Get the selected value
        var paymonth =
            '<?php echo date('Y-m-d', strtotime($last_prement->end_date));?>'; // Get the selected value
        // Make an AJAX post request to the controller
        $.ajax({
            url: '<?= base_url('admin/lunch/getfrom') ?>',
            method: 'GET',
            data: {
                selectedValue: selectedValue,
                paymonth: paymonth
            },
            success: function(response) {
                // console.log(response); return;// Print the response to the console for debugging

                // Check if the response is already an object
                if (typeof response === 'object') {
                    // If it is an object, use it directly
                    responseData = response;
                } else {
                    // Parse the JSON response
                    try {
                        responseData = JSON.parse(response);
                    } catch (error) {
                        console.error("Error parsing JSON response:", error);
                        return; // Exit the success callback
                    }
                }
                if (responseData.length == 0) {
                    var formHtml = '';
                    formHtml += '<form id="new_payment_form" style="overflow: auto;">';
                    formHtml += '<h2>No Data Found</h2>';
                    formHtml +='<input type="hidden" class="form-control" id="new_employeeId" name="new_employeeId" value="' + selectedValue + '">';
                    formHtml += '<div class="form-group col-md-3">';
                     formHtml += '<label for="firstName">Add pay amount</label>';
                    formHtml +='<input type="number" class="form-control" id="new_pay_amt" name="new_pay_amt" value="">';
                    formHtml += '</div>';
                    formHtml += '</br>';
                    formHtml +='<div class="form-group col-md-12 ">';
                    formHtml += '<button type="submit" class="btn btn-primary">Submit</button>';
                    formHtml += '</div>';
                    formHtml += '</form>';




                    $('#form-container').html(formHtml);
                    return 
                }
                var pay_m = parseInt(responseData[0].pay_amount) - parseInt(responseData[0].prev_amount);
                var payday = parseInt(pay_m) / parseInt(<?php echo $lunch_package->stuf_give_tk; ?>);

                // Generate the form dynamically
                var formHtml = '';
                formHtml += '<form id="payment_form" style="overflow: auto;">';




                formHtml +=
                    '<input type="hidden" class="form-control" id="employeeId" name="empid" value="' +
                    responseData[0].emp_id + '">';
                formHtml +=
                    '<input type="hidden" class="form-control" id="pay_month"  name="pay_month" value="' +
                    responseData[0].end_date + '">';

                formHtml += '<h4>' + responseData[0].first_name + ' ' + responseData[0]
                    .last_name + '</h4>';



                formHtml += '<div class="row">';
                formHtml += '<div class="form-group col-md-3">';
                formHtml += '<label for="firstName">Previous Month Meal</label>';
                formHtml +=
                    '<input type="text" class="form-control" id="firstName" value="' +
                    responseData[0].prev_meal + '" readonly>';
                formHtml += '</div>';
                formHtml += '<div class="form-group col-md-3">';
                formHtml += '<label for="lastName">Previous Month Cost</label>';
                formHtml +=
                    '<input type="text" class="form-control" id="lastName" value="' +
                    responseData[0].prev_cost + '" readonly>';
                formHtml += '</div>';
                formHtml += '<div class="form-group col-md-3">';
                formHtml += '<label for="email">Previous Month Payment</label>';
                formHtml += '<input type="number" class="form-control" id="email" value="' +
                    responseData[0].prev_pay + '" readonly>';
                formHtml += '</div>';
                formHtml += '<div class="form-group col-md-3">';
                formHtml += '<label for="dateOfBirth">Previous Month Balance</label>';
                formHtml +=
                    '<input type="number" class="form-control" id="prev_balance" name="prev_amount" value="' +
                    responseData[0].prev_amount + '" readonly>';
                formHtml += '</div>';
                formHtml += '</div>';

                formHtml += '<div class="row">';
                formHtml += '<div class="form-group col-md-3">';
                formHtml += '<label for="gender">Current M. Lunch day</label>';
                formHtml += '<input type="number" class="form-control"  value="' +
                    responseData[0].probable_meal + '" readonly>';
                formHtml += '</div>';
                formHtml += '<div class="form-group col-md-3">';
                formHtml += '<label for="gender">Collection Day</label>';
                formHtml +=
                    '<input type="number" class="form-control" id="p_month_day" onchange="calculatePayment()" value="' +
                    payday + '" >';
                formHtml += '</div>';
                formHtml += '<div class="form-group col-md-3">';
                formHtml += '<label for="gender">Collection Amount</label>';
                formHtml +=
                    '<input type="text" class="form-control" id="p_month_pay" name="p_month_pay" value="' +
                    responseData[0].collection_amount + '" readonly>';
                formHtml += '</div>';

                formHtml += '<div class="form-group col-md-3">';
                formHtml += '<label for="gender">Pay Status</label>';
                formHtml += '<select class="form-control" name="status" id="status">';
                // Set the selected option based on responseData[0].status
                if (responseData[0].status === '0') {
                    formHtml += '<option value="0" selected>Unpaid</option>';
                    formHtml += '<option value="1">Paid</option>';
                } else if (responseData[0].status === '1') {
                    formHtml += '<option value="0">Unpaid</option>';
                    formHtml += '<option value="1" selected>Paid</option>';
                } else {
                    formHtml += '<option>Select Employee</option>';
                    formHtml += '<option value="0">Unpaid</option>';
                    formHtml += '<option value="1">Paid</option>';
                }
                formHtml += '</select>';
                formHtml += '</div>';

                formHtml += '</div>';


                formHtml +=
                    '<div class="form-group col-md-12 float-right" style="justify-content: right;display: flex;">';
                formHtml += '<button type="submit" class="btn btn-primary">Submit</button>';
                formHtml += '</div>';
                // Add more fields as needed

                formHtml += '</form>';

                // Append the generated form HTML to the form-container div
                $('#form-container').html(formHtml);
            },

            error: function(xhr, status, error) {
                // Handle any errors that occur during the request
                console.error(error);
            }
        });
    });




    // Submit event handler for the form
    $('#form-container').on('submit', '#payment_form', function(event) {
        event.preventDefault(); // Prevent the default form submission
        document.getElementById("loading").style.visibility = "visible";

        // Get the form data
        var formData = $(this).serialize();

        // Make an AJAX post request to the controller
        $.ajax({
            url: '<?= base_url('admin/lunch/submit_payment') ?>', // Change the URL to the appropriate controller method
            method: 'GET',
            data: formData,
            success: function(response) {
                // Handle the success response
                document.getElementById("loading").style.visibility = "hidden";
                alert(response);
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the request
                alert(error);
                document.getElementById("loading").style.visibility = "hidden";
            }
        });
    });

    $('#form-container').on('submit', '#new_payment_form', function(event) {
        event.preventDefault(); // Prevent the default form submission
        document.getElementById("loading").style.visibility = "visible";

        // Get the form data
        var formData = $(this).serialize();

        // Make an AJAX post request to the controller
        $.ajax({
            url: '<?= base_url('admin/lunch/new_submit_payment') ?>', // Change the URL to the appropriate controller method
            method: 'GET',
            data: formData,
            success: function(response) {
                // Handle the success response
                document.getElementById("loading").style.visibility = "hidden";
                alert(response);
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the request
                alert(error);
                document.getElementById("loading").style.visibility = "hidden";
            }
        });
    });


});

function calculatePayment() {
    var p_month_day = document.getElementById('p_month_day').value;
    document.getElementById("p_month_pay").value = parseInt(p_month_day * parseInt(<?php echo $lunch_package->stuf_give_tk; ?>));
}
</script>

<script>
$(document).ready(function() {
    $('#search-select').select2();
});
</script>
<script>
$(document).ready(function() {
    $('#process_button').click(function() {

        // Get the values of the input fields
        var firstDate = $('#process_date').val();
        var secondDate = $('#second_date').val();
        var probable_date = $('#probable_date').val();
        if (secondDate == '') {
            alert('Please select Second date');
            return;
        }
        if (probable_date == '') {
            alert('Please select probable_date');
            return;
        }

        document.getElementById("loading").style.visibility = "visible";
        // Create the AJAX request
        $.ajax({
            url: '<?= base_url('admin/lunch/process') ?>', // Replace with the URL to send the request
            method: 'GET', // Replace with the desired HTTP method (POST, GET, etc.)
            data: {
                firstDate: firstDate,
                secondDate: secondDate,
                probable_date: probable_date
            },
            success: function(res) {
                var response = JSON.parse(res);
                if (response.error !== undefined) {
                    showErrorAlert(response.error);
                }else{
                    showSuccessAlert(response.success);
                }
            },
            
            error: function(xhr, status, error) {
                console.log(error);
                document.getElementById("loading").style.visibility = "hidden";
            }
        });
    });
});
</script>
<script>
function updateprocess() {
    var from_date = $('#from_dateu').val();
    var end_date = $('#end_dateu').val();
    var next_date = $('#next_dateu').val();
    if (from_date == '' || end_date == '') {
        alert('First Process');
    } else {
        document.getElementById("loading").style.visibility = "visible";
        $.ajax({
            url: '<?= base_url('admin/lunch/process') ?>', // Replace with the URL to send the request
            method: 'GET', // Replace with the desired HTTP method (POST, GET, etc.)
            data: {
                firstDate: from_date,
                secondDate: end_date,
                probable_date: next_date,
                status: 1
            },
            success: function(res) {
                var response = JSON.parse(res);
                if (response.error !== undefined) {
                    showErrorAlert(response.error);
                }else{
                    showSuccessAlert(response.success);
                }
            },
            error: function(xhr, status, error) {
                // Handle the error response from the server
                console.log(error);
                document.getElementById("loading").style.visibility = "hidden";

            }
        });


    }
}
</script>