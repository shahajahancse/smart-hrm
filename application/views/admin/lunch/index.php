<a href="<?=base_url('admin/lunch/today_lunch/')?>" class="btn btn-primary">Today Lunch r</a>

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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>



      <div class="modal-body">
        <div class="form-group">
          <label for="exampleFormControlFile1">Per mill TK</label>
        <input type="number" class="common" name="" value=100 id="per_mil">
        </div>
        <div class="form-group">
          <label for="exampleFormControlFile1">Office Percentenc</label>
          <input type="number" class="common" name="" value=50  id="office_give_percent">
        </div>
        <div class="form-group">
          <label for="exampleFormControlFile1">Employee Percentenc</label>
    <input type="number" class="common" name="" id="stuf_give_percent" value=50 disabled>
        </div>
        <div class="form-group">
          <label for="exampleFormControlFile1">Office TK</label>
    <input type="number" class="common" name="" id="office_give_tk" value=50 disabled>
        </div>
        <div class="form-group">
          <label for="exampleFormControlFile1">Emplyee TK</label>
    <input type="number" class="common" name="" id="stuf_give_tk" value=50 disabled>
        </div>
            




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
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