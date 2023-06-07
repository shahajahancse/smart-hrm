
<style>
  /* Custom CSS to increase the width of the select box */
  #status {
    width: 194px;
    height: 35px;
    border-radius: 5px;
  }
  .select2-container--default, .select2-container--open{
    z-index: 1500 !important;
  }

  /* Style for the container */
  .container {
    margin: 20px;
  }

  /* Style for the form */
  form {
    max-width: 700px;
    margin: 0 auto;
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
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 3px;
    font-size: 16px;
    transition: background-color 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  .btn:hover {
    background-color: #0056b3;
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
  z-index: 3; /* set z-index higher than other elements */
  background-color: rgba(255, 255, 255, 0.8); /* semi-transparent background */
}

#loading img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
<div id="loading">

  <img src="<?php echo base_url()?>skin/hrsale_assets/img/loding.gif">

</div>

<div class="container">
  <div class="row">
    <div class="col-md-12" style="display: flex;">
      <div class="container col-md-6">
        <h2>Add Payment</h2>
        <select id="search-select">
          <option>Select Employee</option>
          <?php foreach($total_emp as $data){?>
            <option value="<?= $data->user_id ?>"><?= $data->first_name ?> <?= $data->last_name ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="container col-md-6 form-container proccess_container" style="border: 2px solid black;width: 233px;padding: 11px;border-radius: 10px;">
        <p>Last Process Month: <?=  $lastdate ?></p>
        <a class="btn btn-primary" onclick="process()">Process</a>
      </div>
    </div>
  </div>
</div>

<div id="form-container"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
  // Define the process function in the global scope
  function process() {
    document.getElementById("loading").style.visibility = "visible";


    $.ajax({
      url: '<?= base_url('admin/lunch/process') ?>',
      method: 'POST',
      data: { selectedValue: 'selectedValue' },
      success: function(response) {
        document.getElementById("loading").style.visibility = "hidden";

        alert(response); // Print the response to the console for debugging
      },
      error: function(xhr, status, error) {
        // Handle any errors that occur during the request
        console.error(error);
      }
    });
  }

  $(document).ready(function() {
  $('#search-select').select2();

  // Event handler for the select box change event
  $('#search-select').on('change', function() {
    var selectedValue = $(this).val(); // Get the selected value
    var paymonth = '<?= $lastdate ?>'; // Get the selected value

    // Make an AJAX post request to the controller
    $.ajax({
      url: '<?= base_url('admin/lunch/getfrom') ?>',
      method: 'POST',
      data: { selectedValue: selectedValue, paymonth: paymonth },
      success: function(response) {
        console.log(response); // Print the response to the console for debugging

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
        var pay_m=parseInt(responseData[0].pay_amount)-parseInt(responseData[0].prev_amount);
       

        // Generate the form dynamically
        var formHtml = '';
        formHtml += '<form id="payment_form">';
        formHtml += '<div class="form-group">';
        formHtml += '<label for="employeeId">Employee Name</label>';
        formHtml += '<input type="hidden" class="form-control" id="employeeId" name="empid" value="' + responseData[0].emp_id +'">';
        formHtml += '<input type="hidden" class="form-control" id="pay_month"  name="pay_month" value="' + responseData[0].pay_month +'">';

        formHtml += '<input type="text" class="form-control" id="employeeId" value="' + responseData[0].first_name + ' ' + responseData[0].last_name + ' " readonly>';
        formHtml += '</div>';
        formHtml += '<div class="form-group">';
        formHtml += '<label for="firstName">Previous Month Meal</label>';
        formHtml += '<input type="text" class="form-control" id="firstName" value="' + responseData[0].prev_meal + '" readonly>';
        formHtml += '</div>';
        formHtml += '<div class="form-group">';
        formHtml += '<label for="lastName">Previous Month Cost</label>';
        formHtml += '<input type="text" class="form-control" id="lastName" value="' + responseData[0].prev_cost + '" readonly>';
        formHtml += '</div>';
        formHtml += '<div class="form-group">';
        formHtml += '<label for="email">Previous Month Payment</label>';
        formHtml += '<input type="number" class="form-control" id="email" value="' + responseData[0].prev_pay + '" readonly>';
        formHtml += '</div>';
        formHtml += '<div class="form-group">';
        formHtml += '<label for="dateOfBirth">Previous Month Balance</label>';
        formHtml += '<input type="number" class="form-control" id="prev_balance" value="' + responseData[0].prev_amount + '" readonly>';
        formHtml += '</div>';
        formHtml += '<div class="form-group">';
        formHtml += '<label for="gender">Present Month day (probable)</label>';
        formHtml += '<input type="number" class="form-control" id="p_month_day" onchange="calculatePayment()" value="' + (responseData[0].pay_amount/45) + '" >';
        formHtml += '</div>';
        formHtml += '<div class="form-group">';
        formHtml += '<label for="gender">Present Month pay (probable)</label>';
        formHtml += '<input type="text" class="form-control" id="p_month_pay" name="p_month_pay" value="' + pay_m + '" readonly>';
        formHtml += '</div>';
        formHtml += '<div class="form-group">';
        formHtml += '<label for="gender">Prement Status</label>';
        formHtml += '<select name="status" id="status">';       
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
        formHtml += '<div class="form-group">';
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
    method: 'POST',
    data: formData,
    success: function(response) {
      // Handle the success response
      document.getElementById("loading").style.visibility = "hidden";

      alert(response);

      
    },
    error: function(xhr, status, error) {
      // Handle any errors that occur during the request
      alert(error);
    }
  });
});


});

function calculatePayment() {
  var p_month_day = document.getElementById('p_month_day').value;
  var p_month_pay = document.getElementById('p_month_pay').value;
  var prev_balance = document.getElementById('prev_balance').value;
  console.log(prev_balance);
  console.log(p_month_day);


  
  




  
 document.getElementById("p_month_pay").value=parseInt(p_month_day*45)-parseInt(prev_balance);
}


</script>
