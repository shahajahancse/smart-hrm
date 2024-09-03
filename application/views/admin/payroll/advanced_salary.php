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
        <h4>Manual Advanced Salary Add</h4>
        <!-- <form class="form-inline" id="myForm"> -->
        <?php $attributes = array('id' => 'unit_insert', 'autocomplete' => 'off', 'class' => 'add form-hrm ');?>
        <!-- < ?php $hidden = array('user_id' => $session['user_id'],'user_id' => $session['user_id']);?> -->
        <?php echo form_open_multipart('admin/payroll/advanced_salary_add', $attributes);?>
        <div class="row">
            <div class="form-group mb-2 col-md-4">
                <label for="select_data" class="mr-2">Select Employee</label>
                <select class="form-control" id="select_data" name="user_id" required>
                    <option value="">Select Employee</option>
                    <?php
                    $users = $this->db->select('user_id,first_name,last_name')->where_in('status',[1,4,5])->get('xin_employees')->result();
                    foreach($users as $user) {
                    ?>
                    <option value="<?php echo $user->user_id ?>"><?php echo $user->first_name.' '.$user->last_name; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="formGroupExampleInput">Amount</label>
                <input type="number" onkeyup="installment()" class="form-control form-control-sm" id="total_amount"
                    name="requested_amount" placeholder="Set Amount" required>
            </div>
            <div class="form-group col-md-3">
                <label for="formGroupExampleInput2">Start Month</label>
                <input class="form-control attendance_date" onchange="installment()" placeholder="Select Date" id="first_date"
                    name="effective_month" type="text" autocomplete="off" required>
            </div>
            <div class="form-group col-md-2">
                <label for="formGroupExampleInput2">Instalment</label>
                <input class="form-control" id="total_instalment" onkeyup="installment()"
                    name="effective_month" type="number" autocomplete="off" required>
            </div>
        </div>
        <div class="row" id="installment_div">
            
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="formGroupExampleInput2">Reason</label>
                <textarea style="width: 1047px; height: 91px;" class="form-control" id="formGroupExampleInput2" name="reason" placeholder="Enter reason" required></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mb-2" style="float:right" name="btn_advanced">Save</button>
        <?php echo form_close(); ?>




        <br><br>
        <p class="h4">Requested List</p>
        <table class="table table-striped table-bordered" id="table_id">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Sl.</th>
                    <th scope="col" class="text-center">Name</th>

                    <th scope="col" class="text-center">Req_amnt</th>
                    <th scope="col" class="text-center">App_amnt</th>
                    <th scope="col" class="text-center">Effective_month</th>
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

                    <td><?= $row->requested_amount?></td>
                    <td><?= $row->approved_amount?></td>
                    <td><?= date("d M Y", strtotime($row->effective_month))?></td>
                    <td><?= $row->reason?></td>
                    <td>
                        <span class="using">
                            <?php echo $row->status == 1 ? "<i class='fa fa-dot-circle-o' style='color:#cd9a0f'></i> Pending" : ($row->status == 2 ? "<i class='fa fa-dot-circle-o' style='color:green'></i> Accepted" : "<i class='fa fa-dot-circle-o' style='color:green'></i> Paid");?>
                        </span>
                    </td>
                    <td>
                        <?php if($row->status != 2) { ?>
                        <a href="#" class="btn btn-sm btn-info edit-data-btn" data-id="<?=  $row->id ?>"
                            data-amount="<?= $row->requested_amount?>" data-effect-month="<?=$row->effective_month?>"
                            data-details="<?=$row->reason?>" data-toggle="modal" data-target="#myModalsss">Edit</a>
                        <a href="#" class="btn btn-sm btn-info approved_data" data-idd="<?=  $row->id ?>"
                            data-amountt="<?= $row->requested_amount?>" data-effect_month="<?=$row->effective_month?>"
                            data-detailss="<?=$row->reason?>" data-toggle="modal" data-target="#myModalss">Approved</a>
                        <?php }?>
                        <a href="<?php echo base_url('admin/payroll/delete_list/'.$row->id)?>"
                            onclick="return confirm('Are you sure to delete')" class="btn btn-sm btn-danger">Delete</a>
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
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open_multipart('admin/payroll/advanced_salary', $attributes, $hidden);?>
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

<div class="modal fade" id="myModalss" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Approved</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $attributes = array('id' => 'unit_insert', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open_multipart('admin/payroll/advanced_salary', $attributes, $hidden);?>
            <div class="modal-body">
                <label for="requestedAmount">Requested Amount:</label>
                <input type="text" id="requested_amount" class="form-control" value="" required>
                <input type="hidden" id="row_idd" class="form-control" value="">

                <label for="requestedAmount">Approved Amount:</label>
                <input type="text" id="ap_amount" class="form-control" value="" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="approved_dataa">Approved</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#table_id').DataTable();
    $('#select_data').select2();
});

$('.edit-data-btn').on('click', function() {
    var rowId = $(this).data("id");
    var amount = $(this).data("amount");
    var effectMonth = $(this).data("effect-month");
    var details = $(this).data("details");

    $('#requestedAmount').val(amount);
    $('#effectiveMonth').val(effectMonth);
    $('#reason').val(details);
    $('#row_id').val(rowId);
});

$('.approved_data').on('click', function() {
    var rowId = $(this).data("idd");
    var amount = $(this).data("amountt");
    $('#requested_amount').val(amount);
    $('#row_idd').val(rowId);
});

$('#save_data').on('click', function() {
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
        success: function(response) {
            showSuccessAlert("Update Successfully");
            $('#myModalsss').modal('hide');
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});



$('#approved_dataa').on('click', function() {
    var rowId = $('#row_idd').val();
    var approved_amount = $('#ap_amount').val();
    // alert(approved_amount);return false;

    if (approved_amount == '') {
        alert('Field is required!');
        return false;
    }
    var dataToSend = {
        rowId: rowId,
        approved_amount: approved_amount,
    };
    var url = "<?php echo base_url('admin/payroll/approved_amount/')?>" + rowId;
    // Send the AJAX request to update the data on the server.
    $.ajax({
        type: "POST",
        url: url,
        data: dataToSend,
        success: function(response) {
            $('#myModalss').modal('hide');
            showSuccessAlert("Approved");
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
        }
    });
});
</script>

<script>
    function installment(){
        var total_amount = $('#total_amount').val();
        var first_date = $('#first_date').val();
        var total_instalment = $('#total_instalment').val();
        $('#installment_div').html('');
        if (total_amount == '') {
            return false;
        }
        if (first_date == '') {
            return false;
        }
        if (total_instalment == '') {
            return false;
        }

        var sab_amount = Math.ceil(total_amount / total_instalment);
        var html='';
        for(var i = 0; i < total_instalment; i++){
            date= new Date(first_date);
            date.setMonth(date.getMonth() + i);
            date = date.toISOString().slice(0, 10);
            html +=`
            <div class="col-md-12">
                <h5>Installment ${i+1}</h5>
                <div class="form-group col-md-6">
                    <label for="requestedAmount">Amount:</label>
                    <input type="text" name="sab_amount[]" id="installment_${i}" class="form-control" value="${sab_amount}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="requestedAmount">Date:</label>
                    <input type="date" name="sab_date[]" id="date_${i}" class="form-control" value="${date}" required>
                </div>
            </div>
            `
        }

        $('#installment_div').html(html);




        
    }
</script>
