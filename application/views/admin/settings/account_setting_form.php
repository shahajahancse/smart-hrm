<div class="container">
    <!-- Button to trigger add modal -->
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addPurposeModal">
        <i class="fas fa-plus-circle"></i> Add Purpose
    </button>

    <!-- Table to display payment purposes -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Sl</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purposes as $key=>$purpose): ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $purpose->title ?></td>
                    <td><?= $purpose->amount ?></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-info edit-purpose" data-id="<?= $purpose->id ?>"
                            data-toggle="modal" data-target="#editPurposeModal">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <a href="#" class="btn btn-sm btn-danger delete-purpose" data-id="<?= $purpose->id ?>">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Purpose Modal -->
    <div class="modal fade" style="z-index: 111111111111111111 !important;" id="addPurposeModal" tabindex="-1"
        role="dialog" aria-labelledby="addPurposeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add-purpose-form" method="post">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addPurposeModalLabel">Add Purpose</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount:</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Expense Type:</label>
                            <select name="Expense_Type" id="Expense_Type" class="col-md-12">
                                <option>Select type</option>
                                <option value="5">Daily</option>
                                <option value="2">Weekly</option>
                                <option value="3">Monthly</option>
                                <option value="4">Yearly</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Add Purpose">
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
                    <div class="modal-header">
                        <h4 class="modal-title" id="editPurposeModalLabel">Edit Purpose</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit-title">Title:</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-amount">Amount:</label>
                            <input type="number" class="form-control" id="edit-amount" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Expense Type:</label>
                            <select name="Expense_Type" id="Expense_Type" class="col-md-12">
                                <option>Select type</option>
                                <option value="5">Daily</option>
                                <option value="2">Weekly</option>
                                <option value="3">Monthly</option>
                                <option value="4">Yearly</option>
                            </select>
                        </div>
                        <input type="hidden" id="edit-id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save Changes">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// AJAX to add a new purpose
$('#add-purpose-form').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: '<?= base_url('admin/settings/account_setting_form/add') ?>',
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
        url: '<?= base_url('admin/settings/account_setting_form/edit/') ?>' + id,
        dataType: 'json',
        success: function(response) {
            $('#edit-title').val(response.title);
            $('#edit-amount').val(response.amount);
            $('#edit-id').val(response.id);
            $('#Expense_Type').val(response.expense_type);
        }
    });
});

// AJAX to update a purpose
$('#edit-purpose-form').submit(function(e) {
    e.preventDefault();
    var id = $('#edit-id').val();
    $.ajax({
        type: 'POST',
        url: '<?= base_url('admin/settings/account_setting_form/edit/') ?>' + id,
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
            url: '<?= base_url('admin/settings/account_setting_form/delete/') ?>' + id,
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