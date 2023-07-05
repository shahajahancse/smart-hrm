<style>
/* Custom styles for the form */
.form-container {
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 0 auto;
    max-width: 500px;
}

.form-container .form-group {
    margin-bottom: 15px;
}

.form-container .form-control {
    border-radius: 5px;
}

.form-container .btn-primary {
    width: 100%;
}
</style>



<div class="container">
    <div class="form-container">
        <form id="myForm" class="form-horizontal">
            <div class="form-group">
                <label class="col-md-4 control-label">Per mill TK</label>
                <div class="col-md-8">
                    <input type="number" class="form-control common" name="per_mil" value="<?= $query[0]->permeal ?>"
                        id="per_mil">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Office Percentage</label>
                <div class="col-md-8">
                    <input type="number" class="form-control common" name="office_give_percent"
                        value="<?= $query[0]->office_givepercent ?>" id="office_give_percent">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Employee Percentage</label>
                <div class="col-md-8">
                    <input type="number" class="form-control common" name="stuf_give_percent" id="stuf_give_percent"
                        value="<?= $query[0]->stuf_give_percent ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Office TK</label>
                <div class="col-md-8">
                    <input type="number" class="form-control common" name="office_give_tk" id="office_give_tk"
                        value="<?= $query[0]->office_give_tk ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Employee TK</label>
                <div class="col-md-8">
                    <input type="number" class="form-control common" name="stuf_give_tk" id="stuf_give_tk"
                        value="<?= $query[0]->stuf_give_tk ?>" disabled>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
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


    var g_stufGivePercentValue = 100 - officeGivePercentValue;
    var g_officeGiveTkValue = (perMilValue * officeGivePercentValue) / 100;
    var g_stufGiveTkValue = perMilValue - g_officeGiveTkValue;


    document.getElementById("stuf_give_percent").value = g_stufGivePercentValue;
    document.getElementById("office_give_tk").value = g_officeGiveTkValue;
    document.getElementById("stuf_give_tk").value = g_stufGiveTkValue;
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