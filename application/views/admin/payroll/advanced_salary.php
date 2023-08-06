<!-- Ensure you include the required libraries for DataTables and jQuery
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->

<style>
    .using {
        display: inline-flex;
        padding: 4.5px 14.3px 5.5px 9px;
        align-items: center;
        gap: 9px;
        border-radius: 50px;
        border: 1px solid #CCC;
        background: #FFF;
    }
</style>

<div class="card">
    <div class="card-body">
        <p class="h4">Requested List</p>
        <table class="table table-striped table-bordered" id="table_id">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Sl.</th>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">Dept</th>
                    <th scope="col" class="text-center">Desig</th>
                    <th scope="col" class="text-center">Req_Amnt</th>
                    <th scope="col" class="text-center">App_Amnt</th>
                    <th scope="col" class="text-center">Effective_Month</th>
                    <th scope="col" class="text-center">Reason</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($results as $row){ ?>
                    <tr class="text-center">
                        <td><?php echo $i++?></td>
                        <td><?= $row->first_name.' '.$row->last_name?></td>
                        <td><?= $row->department_name?></td>
                        <td><?= $row->designation_name?></td>
                        <td><?= $row->requested_amonut?></td>
                        <td><?= $row->approved_amount?></td>
                        <td><?= date("d M Y", strtotime($row->effective_month))?></td>
                        <td><?= $row->reason?></td>
                        <td>
                            <span class="using">
                                <?php echo $row->status == 1 ? "<i class='fa fa-dot-circle-o' style='color:#cd9a0f'></i> Pending" : "<i class='fa fa-dot-circle-o' style='color:green'></i> Accepted";?>
                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info edit-data-btn" data-id="<?=  $row->id ?>" data-amount="<?= $row->requested_amonut?>" data-effect-month="<?=$row->effective_month?>" data-details="<?=$row->reason?>" data-toggle="modal" data-target="#myModalsss">Edit</a>
                            <a href="<?php echo base_url('admin/payroll/delete_list/'.$row->id)?>" onclick="return confirm('Are you sure to delete')" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModalsss" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'unit_insert', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('user_id' => $session['user_id'],'user_id' => $session['user_id']);?>
            <?php echo form_open_multipart('admin/payroll/advanced_salary_add', $attributes, $hidden);?>
            <div class="modal-body">
                <label for="requestedAmount">Requested Amount:</label>
                <input type="text" id="requestedAmount" class="form-control" value="">
                <input type="hidden" id="row_id" class="form-control" value="">
                <label for="effectiveMonth">Effective Month:</label>
                <input type="text" id="effectiveMonth" class="form-control attendance_date" value="">
                <label for="reason">Reason:</label>
                <textarea id="reason" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="save_data">Save</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#table_id').DataTable();
    });

    $('.edit-data-btn').on('click', function () {
        var rowId = $(this).data("id");
        var amount = $(this).data("amount");
        var effectMonth = $(this).data("effect-month");
        var details = $(this).data("details");

        $('#requestedAmount').val(amount);
        $('#effectiveMonth').val(effectMonth);
        $('#reason').val(details);
        $('#row_id').val(rowId);
    });

    $('#save_data').on('click', function () {
        var rowId = $('#row_id').val();
        var requestedAmount = $('#requestedAmount').val();
        var effectiveMonth = $('#effectiveMonth').val();
        var reason = $('#reason').val();
        var dataToSend = {
            rowId: rowId,
            requestedAmount: requestedAmount,
            effectiveMonth: effectiveMonth,
            reason: reason
        };

        // console.log(dataToSend);return false;
        var url = "<?php echo base_url('admin/payroll/update_salary/')?>" + rowId;
        // Send the AJAX request to update the data on the server.
        $.ajax({
            type: "POST",
            url: url, 
            data: dataToSend,
            // dataType: "json", 
            success: function (response) {
                if (response.success) {
                    console.log(response);
                } else {
                    console.error("Update failed.");
                }
                // $('#myModalsss').modal('hide');
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
    });

});
</script>
