<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

<style>
  /* Custom CSS to increase the width of the select box */
  #search-select {
    width: 300px;
  }
</style>

      <div class="container">
        <h2>Add prement</h2>

        <select id="search-select">
          <option>Select Employee</option>
          <?php foreach($total_emp as $data){?>
            <option value="<?= $data->user_id ?>"><?= $data->first_name ?> <?= $data->last_name ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="container" style="right: -508px;position: absolute;">
      <p>last proccess month   <?=  $lastdate ?></p>
        <a class="btn btn-primary" onclick="process()">Process</a>
      </div>

<div id="form-container"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
  // Define the process function in the global scope
  function process() {
    $.ajax({
            url: '<?= base_url('admin/lunch/process') ?>',
            method: 'POST',
            data: { selectedValue: 'selectedValue' },
            success: function(response) {
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

      // Make an AJAX post request to the controller
      $.ajax({
        url: '<?= base_url('admin/lunch/getfrom') ?>',
        method: 'POST',
        data: { selectedValue: selectedValue },
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

          // Generate the form dynamically
          var formHtml = '';
          formHtml += '<form>';
          formHtml += '<div class="form-group">';
          formHtml += '<label for="employeeId">Employee ID</label>';
          formHtml += '<input type="text" class="form-control" id="employeeId" value="' + responseData[0].employee_id + '" readonly>';
          formHtml += '</div>';
          formHtml += '<div class="form-group">';
          formHtml += '<label for="firstName">First Name</label>';
          formHtml += '<input type="text" class="form-control" id="firstName" value="' + responseData[0].first_name + '" readonly>';
          formHtml += '</div>';
          formHtml += '<div class="form-group">';
          formHtml += '<label for="lastName">Last Name</label>';
          formHtml += '<input type="text" class="form-control" id="lastName" value="' + responseData[0].last_name + '" readonly>';
          formHtml += '</div>';
          formHtml += '<div class="form-group">';
          formHtml += '<label for="email">Email</label>';
          formHtml += '<input type="email" class="form-control" id="email" value="' + responseData[0].email + '" readonly>';
          formHtml += '</div>';
          formHtml += '<div class="form-group">';
          formHtml += '<label for="dateOfBirth">Date of Birth</label>';
          formHtml += '<input type="text" class="form-control" id="dateOfBirth" value="' + responseData[0].date_of_birth + '" readonly>';
          formHtml += '</div>';
          formHtml += '<div class="form-group">';
          formHtml += '<label for="gender">Gender</label>';
          formHtml += '<input type="text" class="form-control" id="gender" value="' + responseData[0].gender + '" readonly>';
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
  });
</script>
