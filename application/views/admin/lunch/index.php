
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
Update Lunch Package
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Lunch Package</h5>
     
      </div>



      <div class="modal-body">
     <form id="myForm">
        <div class="col-md-12 text-center">
            <div class="form-group col-md-12">
              <label for="exampleFormControlFile1">Per mill TK</label><br>
              <input type="number" class="common" name="" value=<?= $query[0]->permil ?> id="per_mil">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group col-md-6">
              <label for="exampleFormControlFile1">Office Percentage</label>
              <input type="number" class="common" name=""  value=<?= $query[0]->office_givepercent ?>  id="office_give_percent">
            </div>
            <div class="form-group col-md-6">
              <label for="exampleFormControlFile1">Employee Percentage</label>
              <input type="number" class="common" name="" id="stuf_give_percent" value=<?= $query[0]->stuf_give_percent ?> disabled>
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group col-md-6">
              <label for="exampleFormControlFile1">Office TK</label>
              <input type="number" class="common" name="" id="office_give_tk" value=<?= $query[0]->office_give_tk ?> disabled>
            </div>
            <div class="form-group col-md-6">
              <label for="exampleFormControlFile1">Emplyee TK</label>
              <input type="number" class="common" name="" id="stuf_give_tk" value=<?= $query[0]->stuf_give_tk ?> disabled>
            </div>
         </div>
            




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
// Get all input fields with the class "common"
var commonInputs = document.getElementsByClassName("common");

// Function to be executed on input field change
function handleInputChange() {
  // Retrieve the updated values
  var perMilValue = document.getElementById("per_mil").value;
  var officeGivePercentValue = document.getElementById("office_give_percent").value;
  var stufGivePercentValue = document.getElementById("stuf_give_percent").value;
  var officeGiveTkValue = document.getElementById("office_give_tk").value;
  var stufGiveTkValue = document.getElementById("stuf_give_tk").value;


  var g_stufGivePercentValue=100-officeGivePercentValue;
  var g_officeGiveTkValue=(perMilValue*officeGivePercentValue)/100;
  var g_stufGiveTkValue=perMilValue-g_officeGiveTkValue;


  document.getElementById("stuf_give_percent").value=g_stufGivePercentValue;
  document.getElementById("office_give_tk").value=g_officeGiveTkValue;
  document.getElementById("stuf_give_tk").value=g_stufGiveTkValue;



  // Call your custom function here or perform any other actions
  // functionName();
}

// Attach event listener to all input fields with the class "common"
for (var i = 0; i < commonInputs.length; i++) {
  commonInputs[i].addEventListener("input", handleInputChange);
}


</script>
<script>
 $(document).ready(function() {
  $("#myForm").submit(function(event) {
    event.preventDefault(); // Prevent form submission

    // Get form data
    var perMilValue = document.getElementById("per_mil").value;
    var officeGivePercentValue = document.getElementById("office_give_percent").value;
    var stufGivePercentValue = document.getElementById("stuf_give_percent").value;
    var officeGiveTkValue = document.getElementById("office_give_tk").value;
    var stufGiveTkValue = document.getElementById("stuf_give_tk").value;

    // Create data object
    var data = {
      per_mil: perMilValue,
      office_give_percent: officeGivePercentValue,
      stuf_give_percent: stufGivePercentValue,
      office_give_tk: officeGiveTkValue,
      stuf_give_tk: stufGiveTkValue
    };
    
    $.ajax({
      url: '<?php echo base_url("/admin/lunch/add_lunch_pak")?>',
      type: "POST",
      data: data,
      success: function(response) {
        // Handle the response from the controller\
        alert('success');
        console.log(response);
      },
      error: function(xhr, status, error) {
        // Handle any errors that occurred during the AJAX request
        console.error(error);
      }
    });
  });
});
</script>
