<!-- < ?php dd( $results)?> -->
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
<div class="box mb-4 animated fadeInRight">
  <div id="accordion">
    <div class="box-header  with-border">
      <h3 class="box-title">Advanced Salary </h3>
        <div class="box-tools pull-right"> 
            <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span>Add New</button>
            </a>
        </div>
    </div>
    <div id="add_form" class="add-form animated fadeInRight collapse" data-parent="#accordion" style="height: 0px;" aria-expanded="false">
      <div class="box-body">
        <?php $attributes = array('id' => 'unit_insert', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id'],'user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/payroll/advanced_salary_add', $attributes, $hidden);?>
        <div class="row">
            <div class="form-group col-md-2">
                <label for="formGroupExampleInput">Amount</label>
                <input type="text" class="form-control form-control-sm" id="formGroupExampleInput" name="requested_amount"placeholder="Set Amount" required>
            </div>
            <div class="form-group col-md-2">
                <label for="formGroupExampleInput2">Effective Month</label>
                <input class="form-control attendance_date" placeholder="Select Date" id="e_m_date" name="effective_month" type="text" autocomplete="off" required>
            </div>
            <div class="form-group col-md-8">
                <label for="formGroupExampleInput2">Reason</label>
                <input type="text" class="form-control form-control-sm" id="formGroupExampleInput2" name="reason" placeholder="Enter reason" required>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-success" name="btn_advanced" style="float:right">Submit</button>
    <?php echo form_close(); ?>
        
      </div>
    </div>

  </div>
</div>


<?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success" style="width:230px;padding: 10px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
        <?php echo $this->session->flashdata('success');?>
    </div>
<?php endif; ?> 

<?php if($this->session->flashdata('delete')):?>
    <div class="alert alert-danger" style="width:230px;padding: 10px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
        <?php echo $this->session->flashdata('delete');?>
    </div>
<?php endif; ?> 

<div class="card">
    <div class="card-body">
        <p class="h4">Requested List</p>
        <table class="table table-striped table-bordered" id="table_id">
            <thead>
                <tr>
                <th scope="col" class="text-center">Sl. No.</th>
                <th scope="col" class="text-center">Approved By</th>
                <!-- <th scope="col" class="text-center">Dept</th> -->
                <!-- <th scope="col" class="text-center">Desig</th> -->
                <th scope="col" class="text-center">Req. Amount</th>
                <th scope="col" class="text-center">App. Amount</th>
                <th scope="col" class="text-center">Effective Month</th>
                <th scope="col" class="text-center">Reason</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($results as $row){ ?>
                    <tr class="text-center">
                        <td><?php echo $i++?></td>
                        <td><?= $admin_name->first_name .' '.$admin_name->last_name?></td>
                        <td><?= $row->requested_amount?></td>
                        <td><?= $row->approved_amount?></td>
                        <td><?= date("d M Y",strtotime($row->effective_month))?></td>
                        <td><?= $row->reason?></td>
                        <td>            
                            <span class="using">
                                <?php echo $row->status==1 ? "<i class='fa fa-dot-circle-o' style='color:#cd9a0f'></i> Pending":"<i class='fa fa-dot-circle-o' style='color:green'></i> Accepted";?>
                            </span>
                        </td>
                        <td>
                            <?php if($row->status != 2){?>
                            <a href="#" class="btn btn-sm btn-info edit-data-btn" data-id="<?=  $row->id ?>" data-amount="<?= $row->requested_amount?>" data-effect-month="<?=$row->effective_month?>" data-details="<?=$row->reason?>" data-toggle="modal" data-target="#myModalsss">Edit</a>
                            <?php }?>
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
            <form>
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
                <button type="button" class="btn btn-success btn-sm" id="save_dataaa">Save</button>
            </div>
            <form>
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

    $('#save_dataaa').on('click', function () {

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
        // alert(dataToSend.rowId); return false;
        var url = "<?php echo base_url('admin/payroll/update_salary/')?>" + rowId;
        $.ajax({
            type: "POST",
            url: url, 
            data: dataToSend,
            success: function (response) {
                 console.log(response);
                showSuccessAlert("Update Successfully");
                $('#myModalsss').modal('hide');
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", error);
            }
    });

});
</script>