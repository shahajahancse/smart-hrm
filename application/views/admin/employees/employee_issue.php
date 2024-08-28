<!-- <div class="container"> -->
    <!-- Button to trigger add modal -->

    <!-- Table to display payment purposes -->
    <div class="box">
        <div class="box-body">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPurposeModal">
                <i class="fa fa-plus-circle"></i> Add Issue
            </button>
            <div class="table-responsive" style="margin-top:10px">
                <table class="table table-bordered table-hover " id="issues">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sl</th>
                            <th>Employee name</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;  foreach ($purposes as $key=>$purpose) {
                            if( $session['user_id'] == $purpose->emp_id || $session['role_id'] == 1 ){

                            
                        ?>
                        <tr>
                            <td><?=   $session['user_id'] == $purpose->emp_id ? $i++ : $key+1 ?></td>
                            <td>
                            <?php
                            $data=$this->Employees_model->fetch_user_info($purpose->emp_id);
                            //    dd($data);
                            echo $data[0]->first_name.' '.$data[0]->last_name
                            ?>
                            </td>
                            <td><?= $purpose->comment ?></td>
                            <td>
                                <!-- <a href="#" class="btn btn-sm btn-info edit-purpose" data-id="<?= $purpose->id ?>"
                                    data-toggle="modal" data-target="#editPurposeModal">
                                    <i class="fa fa-pencil"></i> Edit
                                </a> -->
                                <a href="#" class="btn btn-sm btn-danger delete-purpose" data-id="<?= $purpose->id ?>">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php } }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Purpose Modal -->
    <div class="modal fade" style="z-index: 111111111111111111 !important;" id="addPurposeModal" tabindex="-1"
        role="dialog" aria-labelledby="addPurposeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-purpose-form" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addPurposeModalLabel">Add Issue</h4>
                    </div>
                    <div class="modal-body">
                       
                        <div class="form-group">
                            <label for="amount">Enter your issue</label>
                            <textarea name="comment" id="comment" style="height: 77px; width: 100%;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Add Issue">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Purpose Modal -->
    <div class="modal fade" style="z-index: 111111111111111111 !important;" id="editPurposeModal" tabindex="-1"
        role="dialog" aria-labelledby="editPurposeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="edit-purpose-form" method="post">
                    <input type="hidden" name="edit_id" id="edit-id">
                    <div class="modal-header">
                        <h4 class="modal-title" id="editPurposeModalLabel">Edit Issue</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount">Comment</label>
                            <textarea name="comment" id="comment" cols="30" rows="10">

                            </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save Changes">
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- </div> -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#issues').dataTable();
});
// AJAX to add a new purpose
$('#add-purpose-form').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: '<?= base_url('admin/employees/employee_issue/add') ?>',
        data: $(this).serialize(),
        success: function(response) {
            if (response === 'success') {
                $('#addPurposeModal').modal('hide');
                showSuccessAlert(response);
            } else {
                // Handle validation errors or empty fields
                console.log(response);
            }
        }
    });
});

// AJAX to edit a purpose (fill data in the edit modal)
$('.edit-purpose').click(function() {
    var id = $(this).data('id');
    $.ajax({
        type: 'GET',
        url: '<?= base_url('admin/employees/employee_issue/edit/') ?>' + id,
        dataType: 'json',
        success: function(response) {
            $('#emp_id').val(response.emp_id);
            $('#edit-id').val(response.id);
            $('#comment').val(response.comment);
        }
    });
});

// AJAX to update a purpose
$('#edit-purpose-form').submit(function(e) {
    e.preventDefault();
    var id = $('#edit-id').val();
    $.ajax({
        type: 'POST',
        url: '<?= base_url('admin/employees/employee_issue/edit/') ?>' + id,
        data: $(this).serialize(),
        success: function(response) {
            if (response === 'success') {
                $('#editPurposeModal').modal('hide');
                showSuccessAlert(response);
            } else {
                // Handle validation errors or empty fields
                console.log(response);
            }
        }
    });
});

// AJAX to delete a purpose
$('.delete-purpose').click(function() {
    if (confirm('Are you sure you want to delete this purpose?')) {
        var id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: '<?= base_url('admin/employees/employee_issue/delete/') ?>' + id,
            success: function(response) {
                if (response === 'success') {
                    showSuccessAlert(response);
                } else {
                    // Handle any errors
                    console.log(response);
                }
            }
        });
    }
});
</script>