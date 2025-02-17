<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php 
$this->load->model('Attendance_model');

$stype="Monthly Leave report";
?>
<link rel="stylesheet"
    href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<style type="text/css">
.box-tools {
    margin-right: -5px !important;
}

table {
    margin-top: 15px !important;
}

table thead tr th {
    font-size: 12px;
    padding: 3px !important;
}

table tbody tr td {
    font-size: 12px;
    padding: 3px !important;
}

@media print {
    .box-tools {
        margin-right: -5px !important;
    }

    table thead tr th {
        font-size: 12px;
        padding: 3px !important;
    }

    table tbody tr td {
        font-size: 14px;
        padding: 3px !important;
    }

    body {
        zoom: 80% !important;
    }
}
</style>
<?php


?>
<div class="box" id="print_area">
    <div style="text-align: center;">
        <?php  $this->load->view('admin/head_bangla'); ?>
        <h4>Leave Report</h4>
    </div>
    <div class="container">
        <div class="box-body">
            <div class="box-datatable table-responsive">
                <?php foreach($employee_id as $key => $employee){
				$this->load->model('Xin_model');
				$employee_info=$this->Xin_model->read_user_info($employee);
                $lead_user_id=$employee_info[0]->lead_user_id;
                $lead_user=$this->Xin_model->read_user_info($lead_user_id);

				?>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="10" style="background: #b0ffb2;">
                            <?php echo $employee_info[0]->first_name.' '.$employee_info[0]->last_name; ?>
                        </th>
                            <?php 
								$this->load->model('Attendance_model');
								$leave_report=$this->Attendance_model->leavesm_singale($employee, $first_date, $second_date);
								?>
                        <td rowspan="<?=count($leave_report)+2?>">
                            <?php
									$employee_id=$employee;
									$year = date('Y', strtotime($first_date));
									$total_leave=cals_leave($employee_id,$year);
								?>
                            <table class="table table-bordered" style="background: #4ef7f799;">
                                <tr>
                                    <th colspan="3">Leave Details</th>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <th>EL</th>
                                    <th>SL</th>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><?=(empty($total_leave))? 0:$total_leave->el_total?></td>
                                    <td><?= (empty($total_leave))? 0:$total_leave->sl_total?></td>
                                </tr>
                                <tr id="balance<?=$employee_id?>">
                                    <td>Balance</td>
                                    <td style="color: #0b24e7; font-weight: bold;">
                                        <?= (empty($total_leave))? 0: $total_leave->el_balanace?></td>
                                    <td style="color: #0b24e7; font-weight: bold;">
                                        <?= (empty($total_leave))? 0:$total_leave->sl_balanace?></td>
                                </tr>
                            </table>


                        </td>

                    </tr>

                    <tr>
                        <th>Sl</th>
                        <th>Applied On</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Days</th>
                        <th>Leave Type</th>
                        <th>Reason</th>
                        <th>
                            <span style="white-space: nowrap">Team leader comment</span> <br>
                            <?php if(!empty($lead_user)): ?>
                            <span style="white-space: nowrap;color: #0b24e7"> <?php echo $lead_user[0]->first_name.' '.$lead_user[0]->last_name; ?> </span>
                            <?php endif; ?>
                        </th>
                        <th>Hr comment</th>
                        <th>Status</th>
                    </tr>
                    <?php

                    //dd($leave_report);
                    
                    $tqty=0; foreach($leave_report as $key => $value){ 	
							// 		[leave_id] => 364
							// 		[company_id] => 1
							// 		[employee_id] => 11
							// 		[department_id] => 0
							// 		[leave_type_id] => 1
							// 		[leave_type] => el
							// 		[qty] => 2.0
							// 		[from_date] => 2023-12-17
							// 		[to_date] => 2023-12-18
							// 		[applied_on] => 2023-12-10 11:59:11
							// 		[reason] => Family Program
							// 		[remarks] => 
							// 		[status] => 2
							// 		[is_half_day] => 0
							// 		[notify_leave] => 0
							// 		[leave_attachment] => 
							// 		[team_lead_approved] => 0
							// 		[team_lead_comment] => 
							// 		[created_at] => 2023-12-10 11:59:11
							// 		[current_year] => 2023	
							?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td>
                            <?php echo date('d-F-Y H:i A', strtotime($value->applied_on)); ?> -
                            (<?=date('l', strtotime($value->applied_on)) ?>)


                        </td>
                        <td><?php echo date('d-F-Y', strtotime($value->from_date)); ?> -
                            (<?=date('l', strtotime($value->from_date)) ?>) <?php 
							
							
							$red_alert_check=$this->Attendance_model->red_alert_check($value->leave_id)
							
							?></td>
                        <td><?php echo date('d-F-Y', strtotime($value->to_date)); ?> -
                            (<?=date('l', strtotime($value->to_date)) ?>)</td>
                        <td><?php $tqty= $tqty+$value->qty;  echo $value->qty; ?></td>
                        <td><?php echo ($value->leave_type_id==1)? '<span>Earn Leave</span>' : '<span>Sick Leave</span>';?>
                        </td>
                        <td><?php echo $value->reason; ?></td>
                        <td><?php echo $value->team_lead_comment; ?></td>
                        <td><?php echo $value->remarks; ?></td>
                        <!-- 1=pending, 2=Approved, 3=Rejected, 4=First Level Approval, 5=team lead approved -->
                        <td>
                            <?php 
								if($value->status==1){
									echo '<strong class="text-danger current_status">Pending</strong> <br>
									<div class="dropdown" >
										<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Change Status
										<span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',2,this)" role="menuitem" tabindex="-1" href="#">Approved</a></li>
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',3,this)" role="menuitem" tabindex="-1" href="#">Rejected</a></li>
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',4,this)" role="menuitem" tabindex="-1" href="#">First Level Approval</a></li>
										</ul>
									</div>';
								}elseif($value->status==2){
									echo '<span class="text-success">Approved</span><br>
									<div class="dropdown" >
										<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Change Status
										<span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',3,this)" role="menuitem" tabindex="-1" href="#">Rejected</a></li>
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',4,this)" role="menuitem" tabindex="-1" href="#">First Level Approval</a></li>
											</ul>
									</div>';
								}elseif($value->status==3){
									echo '<span class="text-danger">Rejected</span><br>
									<div class="dropdown" >
										<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Change Status
										<span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',2,this)" role="menuitem" tabindex="-1" href="#">Approved</a></li>
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',4,this)" role="menuitem" tabindex="-1" href="#">First Level Approval</a></li>

										</ul>
									</div>';
								}elseif($value->status==4){
									echo '<strong class="text-info current_status">First Level Approval</strong> <br>
									<div class="dropdown" >
										<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Change Status
										<span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',2,this)" role="menuitem" tabindex="-1" href="#">Approved</a></li>
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',3,this)" role="menuitem" tabindex="-1" href="#">Rejected</a></li>
										</ul>
									</div>';
								}elseif($value->status==5){
									echo '<span class="text-info">Team Lead Approval</span><br>
									<div class="dropdown" >
										<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Change Status
										<span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',2,this)" role="menuitem" tabindex="-1" href="#">Approved</a></li>
											<li role="presentation"><a onclick="leave_status_change('.$value->leave_id.',3,this)" role="menuitem" tabindex="-1" href="#">Rejected</a></li>
										</ul>
									</div>';
								}
								?>
                        </td>
                    </tr>

                    <?php } ?>
                    <tr>
                        <td colspan="4">
                            Total
                        </td>
                        <td colspan="1">
                            <?= $tqty ?>
                        </td>

                    </tr>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
			


?>
<!-- jQuery 3 -->
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js">
</script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js">
</script>

<script
    src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js">
</script>
<!-- Morris.js charts -->
<script>
	function leave_status_change(leave_id, status, obj) {
    event.preventDefault();
    var row = $(obj).closest('td');

    if (status == 3) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to reject this leave?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reject it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: `Why are you refusing this leave? Please tell the reason so they don't make this mistake again`,
                    input: 'text',
                    showCancelButton: true,
                    confirmButtonText: 'Reject',
                }).then((inputResult) => {
                    if (inputResult.isConfirmed) {
                        var why = inputResult.value;
                        if (!why) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please enter why you are rejecting this leave',
                            });
                            return false;
                        }

                        $(row).html('<img src="<?=base_url('skin/img/loading.gif')?>">');
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('admin/timesheet/leave_status_change') ?>",
                            data: {
                                leave_id: leave_id,
                                status: status,
                                reason: why 
                            },
                            success: function(data) {
                                if (data == 'error') {
                                    alert('Something went wrong');
                                } else {
                                    updateStatus(row, leave_id, status);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            }
        });
    } else {
        $(row).html('<img src="<?=base_url('skin/img/loading.gif')?>">');
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/timesheet/leave_status_change') ?>",
            data: {
                leave_id: leave_id,
                status: status
            },
            success: function(data) {
                if (data == 'error') {
                    alert('Something went wrong');
                } else {
                    updateStatus(row, leave_id, status);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
}

function updateStatus(row, leave_id, status) {
    var stext = '';
    if (status == 2) {
        stext = `<strong class="text-danger current_status">Approved</strong> <br>
                <div class="dropdown" >
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Change Status
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a onclick="leave_status_change(${leave_id},3,this)" role="menuitem" tabindex="-1" href="#">Rejected</a></li>
                        <li role="presentation"><a onclick="leave_status_change(${leave_id},4,this)" role="menuitem" tabindex="-1" href="#">First Level Approval</a></li>
                    </ul>
                </div>`;
        update_balance(leave_id);
    } else if (status == 3) {
        stext = `<strong class="text-danger current_status">Rejected</strong> <br>
                <div class="dropdown" >
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Change Status
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a onclick="leave_status_change(${leave_id},2,this)" role="menuitem" tabindex="-1" href="#">Approved</a></li>
                        <li role="presentation"><a onclick="leave_status_change(${leave_id},4,this)" role="menuitem" tabindex="-1" href="#">First Level Approval</a></li>
                    </ul>
                </div>`;
    } else {
        stext = `<strong class="text-danger current_status">First Level Approval</strong> <br>
                <div class="dropdown" >
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Change Status
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a onclick="leave_status_change(${leave_id},2,this)" role="menuitem" tabindex="-1" href="#">Approved</a></li>
                        <li role="presentation"><a onclick="leave_status_change(${leave_id},3,this)" role="menuitem" tabindex="-1" href="#">Rejected</a></li>
                    </ul>
                </div>`;
    }
    $(row).html('<span class="text-success">' + stext + '</span>');
}

</script>
<script>
function update_balance(leave_id) {
    event.preventDefault();
    $.ajax({
        type: "POST",
        url: "<?= base_url('admin/timesheet/update_leave_balance') ?>",
        data: {
            leave_id: leave_id
        },
        success: function(data) {
            total_leave = JSON.parse(data);
            var td_item = `
					<td>Balance</td>
					<td style="color: #0b24e7; font-weight: bold;">${(!total_leave) ? 0 : total_leave.el_balanace}</td>
					<td style="color: #0b24e7; font-weight: bold;">${(!total_leave) ? 0 : total_leave.sl_balanace}</td>
				`;
            $(`#balance${total_leave.emp_id}`).html(td_item);
        }
    })

}
</script>