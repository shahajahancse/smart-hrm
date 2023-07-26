<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<style>
    .btn{
        padding: 2px 5px;
    }
</style>

<div class="box">
    <div class="box-header" style="padding-bottom: 0px !important;">
        <h1 style="float: left; margin-top: 10px !important;">Move Place List</h1>
        <!-- "Add Employee" button -->
        <span style="float: right; margin-top: 15px !important;">
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addEmployeeModal">Add Place</button>
        </span>
    </div>

    <!-- Bootstrap card to display the employee table -->
    <div class="box-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Place Address</th>
                    <th>Place Description</th>
                    <th>Place Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap modal for "Add Employee" form -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add Place</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add the form inside the modal -->
                <form id="addEmployeeFormModal">
                    <div class="form-group">
                        <label for="place_status_modal">Place Status:</label>
                        <select class="form-control" name="place_status_modal" id="place_status_modal">
                            <option>Select Place Status</option>
                            <option value="1">Outside Office</option>
                            <option value="2">Outside Dhaka</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address_modal">Place Address:</label>
                        <input type="text" class="form-control" name="address_modal" id="address_modal"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="place_discreption_modal">Place Description:</label>
                        <input type="text" class="form-control" name="place_discreption_modal"
                            id="place_discreption_modal" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap modal for "Edit Employee" form -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Edit Place</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit Employee form inside the modal -->
                <form id="editEmployeeFormModal">
              
                        <input type="hidden" class="form-control" name="place_id_modal" id="place_id_modale" >
                 
                    <div class="form-group">
                        <label for="place_status_modal">Place Status:</label>
                        <select class="form-control" name="place_status_modal" id="place_status_modale">
                            <option>Select Place Status</option>
                            <option value="1">Outside Office</option>
                            <option value="2">Outside Dhaka</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address_modal">Place Address:</label>
                        <input type="text" class="form-control" name="address_modal" id="address_modale"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="place_discreption_modal">Place Description:</label>
                        <input type="text" class="form-control" name="place_discreption_modal"
                            id="place_discreption_modale" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Place</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>

<script>
// Function to show a SweetAlert success message
function showSuccessAlert(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}

// Function to show a SweetAlert error message
function showErrorAlert(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}

// Function to update the employee table content
function updateEmployeeTable() {
    $.ajax({
        url: '<?php echo base_url('admin/attendance/get_moveplace_ajax'); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.employees.length > 0) {
                var tableBody = '';
                var i=1;
                $.each(response.employees, function(index, employee) {
                    
                    tableBody += `
                                <tr id="${employee.place_id}">
                                    <td>${i}</td>
                                    <td>${employee.address}</td>
                                    <td>${employee.place_discreption}</td>
                                    <td>${employee.place_status === '1' ? 'Outside Office' : 'Outside Dhaka'}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary update-btn" data-toggle="modal" data-target="#editEmployeeModal">Edit</button>
                                        <button type="button" class="btn btn-danger delete-btn" onclick=deleteplace(${employee.place_id})>Delete</button>
                                    </td>
                                </tr>
                            `;i++
                });
                $('tbody').html(tableBody);
            } else {
                $('tbody').html('<tr><td colspan="5" class="text-center">No Place found.</td></tr>');
            }
        },
        error: function() {
            $('tbody').html(
                '<tr><td colspan="5" class="text-center">Error occurred while fetching employees.</td></tr>'
                );
        }
    });
}

// AJAX to add a new employee
$('#addEmployeeFormModal').submit(function(event) {
    event.preventDefault();
    var place_status = $('#place_status_modal').val();
    var address = $('#address_modal').val();
    var place_discreption = $('#place_discreption_modal').val();

    if (address !== '') {
        $.ajax({
            url: '<?php echo base_url('admin/attendance/manage_moveplace/add'); ?>',
            type: 'POST',
            data: {
                place_status: place_status,
                address: address,
                place_discreption: place_discreption
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showSuccessAlert('Place added successfully!');
                    // Update the employee table content
                    updateEmployeeTable();
                    // Reset the form fields
                    $('#place_status_modal').val('1');
                    $('#address_modal').val('');
                    $('#place_discreption_modal').val('');
                    // Close the modal
                    $('#addEmployeeModal').modal('hide');
                } else {
                    showErrorAlert('Failed to add Place.');
                }
            },
            error: function() {
                showErrorAlert('Error occurred while processing the request.');
            }
        });
    }
});

// AJAX to update an employee
function showUpdateForm(row) {
    var place_id =  row.attr('id');
    var place_status = row.find('td:eq(3)').text();
    var address = row.find('td:eq(1)').text();
    var place_discreption = row.find('td:eq(2)').text();

    $('#editEmployeeModal').find('#place_id_modale').val(place_id);
    $('#editEmployeeModal').find('#place_status_modale').val(place_status === 'Outside Office' ? '1' : '2');
    $('#editEmployeeModal').find('#address_modale').val(address);
    $('#editEmployeeModal').find('#place_discreption_modale').val(place_discreption);

}

// Attach the click event to the document using event delegation
$(document).on('click', '.update-btn', function(event) {
    event.preventDefault(); // Prevent the default behavior of the update button
    var row = $(this).closest('tr');
    showUpdateForm(row);
});

// AJAX to submit the updated employee details
$('#editEmployeeFormModal').submit(function(event) {
    event.preventDefault();
   
    var place_id = $('#place_id_modale').val();
    var place_status = $('#place_status_modale').val();
    var address = $('#address_modale').val();
    var place_discreption = $('#place_discreption_modale').val();

    if (address !== '') {
     
        $.ajax({
            url: '<?php echo base_url('admin/attendance/manage_moveplace/update'); ?>',
            type: 'POST',
            data: {
                place_id: place_id,
                place_status: place_status,
                address: address,
                place_discreption: place_discreption
            },
            dataType: 'json',
            success: function(response) {
                
                if (response.status === 'success') {
                    showSuccessAlert('Place updated successfully!');
                    // Update the employee table content
                    updateEmployeeTable();
                    // Close the modal
                    $('#editEmployeeModal').modal('hide');
                } else {
                    showErrorAlert('Failed to update Place.');
                }
            },
            error: function() {
                showErrorAlert('Error occurred while processing the request.');
            }
        });
    }
});

// AJAX to delete an employee
function deleteplace(id) {
    Swal.fire({
        icon: 'warning',
        title: '',
        text: 'Are you sure you want to delete this Place?',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo base_url('admin/attendance/manage_moveplace/delete'); ?>',
                type: 'POST',
                data: {
                    place_id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        showSuccessAlert('Place deleted successfully!');
                        // Update the employee table content
                        updateEmployeeTable();
                    } else {
                        showErrorAlert('Failed to delete Place.');
                    }
                },
                error: function() {
                    showErrorAlert('Error occurred while processing the request.');
                }
            });
        }
    });
};

// Initial update of the employee table content
updateEmployeeTable();
</script>