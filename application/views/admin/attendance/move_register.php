<style>
.dropdown-item {
    padding: 4px;
    margin: 5px;
    width: 72px;
    height: 28px;
    text-align: center;
    cursor: pointer;
    border: 1px solid #0177bc;
    border-radius: 4px;
    /* New style for dropdown-item */
    background-color: #f8f9fa;
    color: #212529;
    transition: box-shadow 0.3s, color 0.3s;
}

.dropdown-item:hover {
    /* Hover effect */
    box-shadow: 0 0 5px #0177bc;
    color: #fff;
}

.dropdown-menu {
    min-width: 85px !important;
}

.btn {
    padding: 3px !important;
}
.swal2-container{
    z-index: 1111!important;
}
</style>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div id="page_load">
    <div class="box mb-4 <?php echo $get_animate;?>">
        <div id="accordion">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo 'Add Outside Office Movement';?></h3>
                <div class="box-tools pull-right">
                    <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
                        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span>
                            <?php echo $this->lang->line('xin_add_new');?></button>
                    </a>
                </div>
            </div>
            <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
                <div class="box-body">
                    <?php $attributes = array('id' => 'move_register', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
                    <!-- < ?php $hidden = array('user_id' => $session['user_id']);?> -->
                    <?php echo form_open('admin/attendance/create_move_register', $attributes);?>
                    <div class="bg-white">
                        <div class="box-block">
                            <div class="row">
                                <?php
                                  $sql= 'SELECT user_id,first_name,last_name FROM xin_employees';
                                  $employees = $this->db->query($sql);
                                  $emps=$employees->result();
                                  if($session['role_id']!=3){?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date">Employee Name</label>
                                        <select name="emp_id" class="form-control" id="emp_name">
                                            <option id="employeeeees" value="">Select Employee Name</option>
                                            <?php foreach($emps as $emp){?>
                                            <option value="<?php echo $emp->user_id?>">
                                                <?php echo $emp->first_name.' '.$emp->last_name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <?php }else{?>
                                <input type="hidden" name="emp_id" value="<?php echo $session['user_id']?>" id="emp_id">
                                <?php }?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input class="form-control date" placeholder="date..." name="date" type="text"
                                            value="" id="move_date">
                                        <input name="id" type="hidden" value="" id="idesss">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="out_time">Office out time</label>
                                        <input class="form-control  timepicker clear-1" placeholder="Office out time"
                                            name="out_time" type="text" value="" id="m_out_times">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="in_time">Office in time</label>
                                        <input class="form-control  timepicker clear-2" placeholder="Office in time"
                                            name="in_time" type="text" value="" id="m_in_times">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="summary">Reason</label>
                                        <textarea class="form-control" placeholder="reason" name="reason" cols="30"
                                            rows="3" id="m_reasoness"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions box-footer">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i>
                                    <?php echo $this->lang->line('xin_save');?> </button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- modal for TA DA -->
    <div class="modal fade bd-example-modal-lg" id='myModal1' tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modify_ta_da">Modify TA/DA</h4>
                </div>
                <form>
                    <div class="form-group col-lg-3">
                        <label id="add_amount">Add Amount</label>
                        <label id="amounts">Amount</label>
                        <input type="number" class="form-control" onkeyup="copyText()" id="request_amount"
                            aria-describedby="amount" placeholder="Enter amount">
                        <input type="hidden" id="form_id">
                    </div>
                    <div class="form-group col-lg-9">
                        <label for="exampleInputPassword1">Short Details</label>
                        <textarea type="text" class="form-control" id="short_details" placeholder="Details"></textarea>
                    </div>

                    <?php 
        $role_id =$session['role_id'];
        if ($role_id == 1) { ?>
                    <div class="form-group col-lg-6" id="ta_da_div" style="display: none;">
                        <label id="manage_ta_da">Manage TA/DA</label>
                        <select class="form-control" id="status">
                            <option>Select</option>
                            <option value="2">Approved</option>
                            <option value="3">Reject</option>
                        </select>
                    </div>
                    <?php }
        if ($role_id == 1) { ?>
                    <div class="form-group col-lg-6" id="set_ta_da_amount" style="display: none;">
                        <label>Set Amount</label>
                        <input type="text" class="form-control" id="payable_amount" placeholder="Set Amount">
                    </div>
                    <?php }    ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-sm"
                            onclick="manage_ta_da(<?php echo $session['role_id']?>)">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Colsed Modal -->
    <!-- view ta da applied -->
    <div class="modal fade bd-example-modal-lg" id='viewModal' tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="color: white;background: #0177bc;">
                    <h4 class="modal-title">View TA/DA</h4>
                </div>
                <div id="modelcontectview">

                </div>

                <div class="modal-footer">
                    <hr>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <a class="btn btn-info btn-sm" onclick="changetada()"> Submit </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->
    <div class="box <?php echo $get_animate;?>">
        <div class="box-header with-border">
            <h3 class="box-title">Movement leave list</h3>
        </div>
        <div class="box-body">
            <div class="box-datatable ">
                <table class="datatables-demo table table-striped table-bordered" id="example">
                    <thead>
                        <tr>
                            <th style="width:120px;">No.</th>
                            <th style="width:120px;">Name.</th>
                            <th style="width:100px;">Date</th>
                            <th style="width:100px;">Out</th>
                            <th style="width:100px;">In</th>
                            <th style="width:100px;">Reason</th>
                            <th style="width:100px;">TA/DA Request</th>
                            <th style="width:100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $key => $row) { ?>
                        <tr>
                            <td><?php echo $key + 1;?></td>
                            <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
                            <td><?php echo $row->date; ?></td>
                            <td><?php echo $row->out_time == "" ? "" : date('h:i A',strtotime($row->out_time)); ?></td>
                            <td><?php echo $row->in_time  == "" ? "" : date('h:i A',strtotime($row->in_time));?></td>
                            <td><?php echo $row->title; ?></td>
                            <?php
                                $status = $row->status;
                                $statusMessage = '';

                                switch ($status) {
                                    case 0:
                                        $statusMessage = '<span class="pending"><i class="fa fa-dot-circle-o" style="color:black"></i> Not Applied</span>';
                                        break;
                                    case 1:
                                        $statusMessage = '<span class="complet"><i class="fa fa-dot-circle-o" style="color:green"></i>In Process</span>';
                                        break;
                                    case 2:
                                        $statusMessage = '<span class="complet"><i class="fa fa-dot-circle-o" style="color:green"></i>Approved</span>';
                                        break;
                                    case 3:
                                        $statusMessage = '<span class="pending"><i class="fa fa-dot-circle-o" style="color:red"></i>Reject</span>';
                                        break;
                                    case 4:
                                        $statusMessage = '<span class="pending"><i class="fa fa-dot-circle-o" style="color:green"></i>Pay</span>';
                                        break;
                                    case 5:
                                        $statusMessage = '<span class="pending"><i class="fa fa-dot-circle-o" style="color:green"></i>First Step Approved </span>';
                                        break;
                                    case 6:
                                        $statusMessage = '<span class="pending"><i class="fa fa-dot-circle-o" style="color:green"></i>Return of Correction </span>';
                                        break;
                                }
                                ?>

                            <td><?= $statusMessage ?></td>
                            </td>
                            <td>

                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="actionButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right list-group"
                                        aria-labelledby="actionButton">
                                        <?php if($status==0){ ?>
                                        <a class="dropdown-item list-group-item"
                                            href="<?php echo base_url('admin/attendance/delete_move_register/'.$row->id); ?>">Delete</a>
                                        <?php }elseif($status==1){?>
                                        <a class="dropdown-item list-group-item"
                                            href="<?php echo base_url('admin/attendance/delete_move_register/'.$row->id); ?>">Delete</a>

                                        <a class="dropdown-item list-group-item"
                                            onclick="moveview(<?= $row->id ?>,'v')">View</a>
                                        <a class="dropdown-item list-group-item"
                                            onclick="moveview(<?= $row->id ?>,'e')">Edit</a>
                                        <?php }elseif($status==2){?>
                                        <a class="dropdown-item list-group-item"
                                            href="<?php echo base_url('admin/attendance/delete_move_register/'.$row->id); ?>">Pay</a>
                                        <a class="dropdown-item list-group-item"
                                            onclick="moveview(<?= $row->id ?>,'e')">Edit</a>
                                        <a class="dropdown-item list-group-item"
                                            onclick="moveview(<?= $row->id ?>,'v')">View</a>
                                        <?php }elseif($status==3){?>
                                        <a class="dropdown-item list-group-item"
                                            onclick="moveview(<?= $row->id ?>,'v')">View</a>
                                        <?php }elseif($status==4){?>
                                        <a class="dropdown-item list-group-item"
                                            onclick="moveview(<?= $row->id ?>,'v')">View</a>
                                        <?php }elseif($status==5){?>
                                        <a class="dropdown-item list-group-item"
                                            href="<?php echo base_url('admin/attendance/delete_move_register/'.$row->id); ?>">Delete</a>
                                        <a class="dropdown-item list-group-item"
                                            onclick="moveview(<?= $row->id ?>,'e')">Edit</a>
                                        <a class="dropdown-item list-group-item"
                                            onclick="moveview(<?= $row->id ?>,'v')">View</a>
                                        <?php }?>


                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function changetada(){
    $('#viewModal').modal().hide();

var payamValue = document.getElementById("payam").value;
var staValue = document.getElementById("sta").value;
var moveid = document.getElementById("moveid").value;
var return_comment = document.getElementById("return_comment").value;

    var url = "<?php echo base_url('admin/attendance/changetada'); ?>";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                payable_amount: payamValue,
                status: staValue,
                moveid: moveid,
                return_comment: return_comment
                },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            },
            error: function(response) {
                alert(response.message)
            }
        });
}
</script>
<script>
$(document).ready(function() {
    $('.clockpicker').clockpicker();
    var input = $('.timepicker').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    $("#move_register").on('submit', function(e) {
        var url = "<?php echo base_url('admin/attendance/create_move_register'); ?>";
        e.preventDefault();
        var okyes;
        okyes = confirm('Are you sure you want to leave?');
        if (okyes == false) return;
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                if (response.status == 'success') {
                    alert(response.message)
                    window.location.replace(
                        '<?php echo base_url('admin/attendance/move_register/')?>')
                } else {
                    alert(response.message)
                }
            },
            error: function(response) {
                alert(response.message)
            }
        });
        return false;
    });
    $('#example').DataTable();
});

function moveview(id,st) {
    $('#viewModal').modal().show();
    // alert(id);
    var url = "<?php echo base_url('admin/attendance/view_ta_da/')?>" + id + "/" + st;
    $.ajax({
        type: "GET",
        url: url,
        data: {
            id: id
        },
        success: function(data) {
            // console.log(data);
            $('#modelcontectview').empty();
            $('#modelcontectview').html(data);
        }
    });
}


function showModal(id, role_id) {
    //  alert(id + ' '+ role_id); 
    $("#form_id").val(id);
    $('#myModal1').modal().show();
    var url = "<?php echo base_url('admin/attendance/modify_for_ta_da/')?>" + id;
    jQuery.ajax({
        url: url,
        contentType: "application/json",
        dataType: 'json',
        type: 'POST',
        success: function(response) {
            if (role_id != "3") {
                $("#request_amount").val(response[0].request_amount);
                $("#short_details").val(response[0].reason);
                $('#apply_for_ta_da').hide();
                $('#modify_ta_da').show();
                if (response[0].status == 3) {
                    $("#std").html("Reject");
                }

                $('#add_amount').hide();
                $('#amounts').show();
                $('#ta_da_div').show();
                $('#set_ta_da_amount').show();
            } else {
                $('#apply_for_ta_da').show();
                $("#request_amount").val(response[0].request_amount);

                if (response[0].status == 3 || response[0].status == 1) {
                    // console.log(response[0].status);
                    $("#short_details").val(response[0].reason);
                }
                $('#modify_ta_da').hide();
                $('#add_amount').show();
                $('#amounts').hide();
                $('#ta_da_div').hide();
                $('#set_ta_da_amount').hide();
            }
        }
    });


}

function manage_ta_da(role_id) {
    let request_amount = $("#request_amount").val();
    let short_details = $("#short_details").val();
    let form_id = $("#form_id").val();
    if (request_amount == '') {
        alert('Please Set Amount');
        $("#request_amount").focus();
        $("#request_amount").attr('style', 'border: 1px solid red !important');
        return false;
    }

    if (short_details == '') {
        alert('Please Enter Short Description');
        $("#short_details").focus()
        $("#short_details").attr('style', 'border: 1px solid red !important');
        return false;
    }

    if (role_id != 3) {
        var id = $("#form_id").val();
        var status = $("#status").val();
        var payable_amount = $("#payable_amount").val();
        if ($('#status').val() == null) {
            // alert('Please Select Status');
            $('#status').focus();
            $("#status").attr('style', 'border: 1px solid red !important');

            return false;
        }

        if ($('#payable_amount').val() == '') {
            // alert('Please Insert Effective Date');
            $('#payable_amount').focus();
            $("#payable_amount").attr('style', 'border: 1px solid red !important');

            return false;
        }
        var url = "<?php echo base_url('admin/attendance/update_ta_da');?>";
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            data: {
                "form_id": form_id,
                "status": status,
                "payable_amount": payable_amount,
            },
            success: function(response) {
                alert('Modify Successfully');
                $('.modal').modal('hide');
                window.location.replace("<?php echo base_url('admin/attendance/move_register/');?>")
            }
        });
    } else {
        var id = $("#form_id").val();

        var url = "<?php echo base_url('admin/attendance/apply_for_ta_da');?>";
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            data: {
                "form_id": form_id,
                "request_amount": request_amount,
                "short_details": short_details,
            },
            success: function(response) {
                alert('Submitted Successfully');
                $('.modal').modal('hide');
                window.location.replace("<?php echo base_url('admin/attendance/move_register/');?>")
            }
        });
    }

}

$(document).ready(function() {

    $('#myModal1').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $("#request_amount").attr('style', 'border: 1px solid #ccd6e6 !important');
        $("#short_details").attr('style', 'border: 1px solid #ccd6e6 !important');
    });

    $("request_amount").on('input', function() {
        $("#request_amount").attr('style', 'border: 1px solid #ccd6e6 !important');
        if ($("#request_amount").val() == '') {
            $("#request_amount").attr('style', 'border: 1px solid red !important');
            return false;
        }
    });

    $("#short_details").on('input', function() {
        $("#short_details").attr('style', 'border: 1px solid #ccd6e6 !important');
        if ($("#short_details").val() == '') {
            $("#short_details").attr('style', 'border: 1px solid red !important');
            return false;
        }
    });

});

function copyText() {
    var request_amount = $('#request_amount').val();
    var url = "<?php echo base_url('admin/attendance/copy_value'); ?>";
    $.ajax({
        type: 'POST',
        // url: 'admin/attendance/copy_value',
        url: url,
        data: {
            request_amount: request_amount
        },
        success: function(response) {
            $('#payable_amount').val(response);
        }
    });
}
</script>