<?php /* Leave Application view */ ?>
<?php $session = $this->session->userdata('username');

$error = $this->session->flashdata('error');
$success = $this->session->flashdata('success');
?>
<?php 
      $user = $this->Xin_model->read_employee_info($session['user_id']);
      $user_info = $this->Xin_model->read_user_info($session['user_id']);
      $get_animate = $this->Xin_model->get_content_animate();
      $role_resources_ids = $this->Xin_model->user_role_resource();
      // dd($user);
?>
<?php
if (isset($error)){
  ?>
<div class="alert alert-danger" role="alert">
    <?php echo $error; ?>
</div>
<?php
}
if (isset($success)) {
  ?>
<div class="alert alert-success" role="alert">
    <?php echo $success; ?>
</div>
<?php
}
?>
<style>
.myboxx {
    display: flex;
    padding: 0;
    margin: 0;
    border-radius: 5px;
    box-shadow: 0px 0px 2px 2px #e5e5e5;
    flex-direction: column;
}

.myboxx_header {
    background: #dddddd;
    color: black;
    font-size: 17px;
    width: -webkit-fill-available;
    border-bottom: 1px solid #979797;
    text-align: center;
}

.myboxx_body {
    color: black;
    font-size: 15px;
    padding: 5px;
    width: -webkit-fill-available;
}
td, th {
    padding: 0 !important;
}
</style>
<div id="edit-leave-modal-data" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Leave Application</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding: 7px 0px;display: flex;gap: 16px;">
                    <div class="col-md-6 myboxx">
                        <div class="myboxx_header">
                            Employee Information
                        </div>
                        <div class="myboxx_body">
                            <table class="table table-bordered col-md-12" style="margin: 0;">
                                <tr>
                                    <th style="padding: 3px 8px!important;">Employee Name</th>
                                    <td style="padding: 3px 8px!important;">Md Ahaduzzaman</td>
                                </tr>
                                <tr>
                                    <th style="padding: 3px 8px!important;">Department</th>
                                    <td style="padding: 3px 8px!important;">department</td>
                                </tr>
                                <tr>
                                    <th style="padding: 3px 8px!important;">Designation</th>
                                    <td style="padding: 3px 8px!important;">tech</td>
                                </tr>
                                <tr>
                                    <th style="padding: 3px 8px!important;">Basic Salary</th>
                                    <td style="padding: 3px 8px!important;">10000</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 myboxx">
                        <div class="myboxx_header">
                            Leave Status
                        </div>
                        <div class="myboxx_body">
                            <div class="box-block card-dashboard">
                                <div id="leave-statistics">
                                    <p><strong>Earn leave (9.5/12)</strong></p>
                                    <div class="progress" style="margin: 7px;height: 19px;background: aqua;">
                                        <div class="progress-bar" style="background: #ff8484;width: 75%;"> Teken 9.5 </div>
                                    </div>
                                    <div id="leave-statistics">
                                        <p><strong>Sick leave (3/4)</strong></p>
                                        <div class="progress" style="margin: 7px;height: 19px;background: aqua;">
                                            <div class="progress-bar" style="background: #ff8484;width: 75%;"> Teken 3</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 7px 0px;display: flex;gap: 16px;">
                    <div class="col-md-12 myboxx">
                        <div class="myboxx_header">
                            Leave Information
                        </div>
                        <div class="myboxx_body">
                          <div class="col-md-6" style="padding: 5px;border: 1px solid #cfcfcf;border-radius: 4px;">
                            <table class="table table-bordered col-md-12" style="margin: 0;">
                                <tr>
                                    <th style="padding: 3px 8px!important;">Leave Type</th>
                                    <td style="padding: 3px 8px!important;">Sick Leave</td>
                                </tr>
                                <tr>
                                    <th style="padding: 3px 8px!important;">Application Date</th>
                                    <td style="padding: 3px 8px!important;">01-Nov-2022</td>
                                </tr>
                                <tr>
                                    <th style="padding: 3px 8px!important;">Attachment</th>
                                    <td style="padding: 3px 8px!important;"><a href="" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a></td>
                                </tr>
                               
                            </table>
                            <label for=""> Reason</label>
                            <textarea name="" id="" style="width: 412px; height: 64px;"></textarea>
                          </div>
                          <div class="col-md-6" style="padding: 5px;border: 1px solid #cfcfcf;border-radius: 4px;">
                            <table class="table table-bordered col-md-12" style="margin: 0;">
                                  <tr>
                                      <th style="padding: 3px 8px!important;">From Date</th>
                                      <td style="padding: 3px 8px!important;"  colspan="2"><input type="date" name="" id="" value="1/1/2022"></td>
                                  </tr>
                                  <tr>
                                      <th style="padding: 3px 8px!important;">To Date</th>
                                    <td style="padding: 3px 8px!important;" colspan="2"><input type="date" name="" id="" value="1/1/2023"></td>
                                  </tr>
                                  <tr>
                                      <th style="padding: 3px 8px!important;">Total Days</th>
                                      <td style="padding: 3px 8px!important;"><input type="number" name="" id="" value="1"></td> 
                                      <td> <input type="checkbox" name="" id="Half Day"> Halfday </td>
                                  </tr>
                                  <tr>
                                      <th style="padding: 3px 8px!important;">Status</th>
                                      <td style="padding: 3px 8px!important;">
                                        <select class="form-control select2-hidden-accessible" name="status" data-plugin="select_hrm" data-placeholder="Status" tabindex="-1" aria-hidden="true">
                                          <option value="1">Pending</option>
                                          <option value="4">First Level Approval</option>
                                          <option value="2" selected="">Approved</option>
                                          <option value="3">Rejected</option>
                                        </select>
                                      </td>
                                  </tr>
                                  <tr>
                                      <th style="padding: 3px 8px!important;">Remark</th>
                                      <td style="padding: 3px 8px!important;">
                                      <input type="text" name="" id="">
                                      </td>
                                  </tr>
                                
                              </table>
                          </div>
                           
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<?php if(in_array('287',$role_resources_ids)) {?>
<div class="box mb-4 <?php echo $get_animate;?>">
    <div id="accordion">
        <div class="box-header with-border">
            <h3 class="box-title"> <?php echo $this->lang->line('xin_add_leave');?> </h3>
            <div class="box-tools pull-right">
                <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" id="addnew"
                    aria-expanded="false">
                    <button type="button" class="btn btn-xs btn-primary">
                        <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?> </button>
                </a>
            </div>
        </div>
        <div id="add_form" class="collapse add-form 
  			<?php echo $get_animate;?>" data-parent="#accordion" style="">
            <div class="box-body"> <?php $attributes = array('name' => 'add_leave', 'autocomplete' => 'off');?>
                <?php $hidden = array('_user' => $session['user_id']);?>
                <?php echo form_open('admin/timesheet/add_leave', $attributes, $hidden);?>
                <div class="bg-white">
                    <div class="box-block">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="company_id" id="company_id"
                                    value="<?php echo $user[0]->company_id;?>" />
                                <?php $role_resources_ids = $this->Xin_model->user_role_resource();
    				          if(in_array($user_info[0]->user_role_id, array(1,2,4))){ ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="employee_ajax">
                                            <label for="employees" class="control-label">
                                                <?php echo $this->lang->line('xin_employee');?> </label>
                                            <select class="form-control" name="employee_id" id="employee_id"
                                                data-plugin="select_hrm"
                                                data-placeholder=" <?php echo $this->lang->line('xin_choose_an_employee');?>"
                                                required>
                                                <option value=""></option>
                                                <?php  $all_employees = $this->Xin_model->get_employee(1, null, array(1,4,5));
                              foreach ($all_employees as $key => $row) { $employee_id = $row->user_id; ?>
                                                <option value="<?php echo $employee_id; ?>">
                                                    <?php echo $row->first_name .' '. $row->last_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="get_leave_types">
                                            <label for="leave_type" class="control-label">
                                                <?php echo $this->lang->line('xin_leave_type');?> </label>
                                            <select class="form-control" id="leave_type" name="leave_type"
                                                data-plugin="select_hrm" data-placeholder="
          										<?php echo $this->lang->line('xin_leave_type');?>">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } else {?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="employee_ajax">
                                            <label for="employees" class="control-label">
                                                <?php echo $this->lang->line('xin_employee');?> </label>
                                            <select class="form-control" name="employee_id" id="employee_id"
                                                data-placeholder=" <?php echo $this->lang->line('xin_choose_an_employee');?>"
                                                required>
                                                <?php  $all_employees = $this->Xin_model->get_employee(1, $session['user_id'], array(1));
                              foreach ($all_employees as $key => $row) { ?>
                                                <option value="<?php echo $row->user_id; ?>">
                                                    <?php echo $row->first_name .' '. $row->last_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="get_leave_types">
                                            <label for="leave_type" class="control-label">
                                                <?php echo $this->lang->line('xin_leave_type');?> </label>
                                            <select class="form-control" id="leave_type" name="leave_type"
                                                data-plugin="select_hrm"
                                                data-placeholder="<?php echo $this->lang->line('xin_leave_type');?>"
                                                required>
                                                <option value=""></option>
                                                <?php $leaves = leave_cal($session['user_id']);?>
                                                <?php foreach($leaves['leaves'] as $key => $row) {  ?>
                                                <option value="<?php echo $row['id'];?>">
                                                    <?php echo $row['leave_name'] .' ('.$row['qty'].' '.$this->lang->line('xin_remaining').')';?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group col-md-4">
                                    <label for="end_date"> <?php echo $this->lang->line('xin_start_date');?> </label>
                                    <input class="form-control date"
                                        placeholder="<?php echo $this->lang->line('xin_start_date');?>" readonly
                                        name="start_date" type="text" value="" required>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="end_date"> <?php echo $this->lang->line('xin_end_date');?> </label>
                                    <input class="form-control date"
                                        placeholder="<?php echo $this->lang->line('xin_end_date');?>" readonly
                                        name="end_date" type="text" value="" required>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <br />
                                        <input type="checkbox" class="form-control minimal" value="1"
                                            id="leave_half_day" name="leave_half_day">
                                        <label><?php echo $this->lang->line('xin_hr_leave_half_day');?></span> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <fieldset class="form-group">
                        <label for="attachment"> <?php echo $this->lang->line('xin_attachment');?></label>
                        <input type="file" class="form-control-file" id="attachment" name="attachment">
                        <small> <?php echo $this->lang->line('xin_company_file_type');?> </small>
                      </fieldset>
                    </div>
                  </div>
                </div> -->
                        <div class="form-group">
                            <label for="summary"> <?php echo $this->lang->line('xin_leave_reason');?> </label>
                            <textarea class="form-control"
                                placeholder="<?php echo $this->lang->line('xin_leave_reason');?>" name="reason"
                                cols="30" rows="3" id="reason" required></textarea>
                        </div>

                        <div class="form-actions box-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?>
                            </button>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="box <?php echo $get_animate;?>">
    <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?>
            <?php echo $this->lang->line('left_leave');?> </h3> <?php if($user_info[0]->user_role_id==1){ ?> <div
            class="box-tools pull-right">
            <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrsale" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary">
                    <span class="fa fa-filter"></span> <?php echo $this->lang->line('xin_filter');?> </button>
            </a>
        </div> <?php } ?>
    </div>
    <div class="box-body">
        <div class="box-datatable table-responsive">
            <table class="table table-striped table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Employee information</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Total days</th>
                        <th>Leave type</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  foreach ($leaves_info as $key => $leave) :?>

                    <?php
                        $employee_name = '<p style="font-size: 17px;padding: 0;margin: 0;color: black;">'. $leave->first_name.' '.$leave->last_name .' </p>&nbsp;&nbsp; Designation : ' .$leave->designation_name . '<br> &nbsp;&nbsp; Department : '.$leave->department_name;
                    ?>
                    <tr>
                        <td> <?php echo $key+1; ?> </td>
                        <td>
                            <?php echo $employee_name;?>
                        </td>
                        <td>
                            <?php echo '<p style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;font-size: small;cursor: pointer;">'. $this->Xin_model->set_date_format($leave->from_date) . '</p>'; ?>
                        </td>
                        <td>
                            <?php echo '<p style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;font-size: small;cursor: pointer;">'. $this->Xin_model->set_date_format($leave->to_date) . '</p>'; ?>
                        </td>
                        <td>
                            <?php echo $leave->qty; ?>
                        </td>
                        <td>
                            <?php echo $leave->leave_type; ?>
                        </td>
                        <td>
                            <?php echo '<p title="' . $leave->reason . '" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;font-size: small;width: 130px;cursor: pointer;">'. $leave->reason . '</p>';  ?>
                        </td>
                        <td>
                            <?php if($leave->status==1):?>
                            <span class="label label-warning">
                                Pending
                            </span>
                            <?php elseif($leave->status==2):?>
                            <span class="label label-success">
                                Approved
                            </span>
                            <?php elseif($leave->status==3):?>
                            <span class="label label-danger">
                                Rejected
                            </span>
                            <?php elseif($leave->status==4):?>
                            <span class="label label-danger">
                                First Level Approval
                            </span>
                            <?php endif; ?>
                        </td>
                        <td>

                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $this->lang->line('xin_action');?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" role="menu">
                                    <li>
                                        <a style="border-radius: 6px;" href="javascript:void(0);" data-toggle="modal"
                                            data-target="#edit-leave-modal-data">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a style="border-radius: 6px;"
                                            href="<?= site_url('admin/timesheet/leave_details/id/'.$leave->leave_id) ?>">
                                            <i class="fa fa-pencil-square-o"></i> Edit
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a style="border-radius: 6px;"
                                            href="<?= site_url('admin/timesheet/leave_approve/'.$leave->leave_id.'/'.$leave->qty.'/'.$leave->from_date) ?>">
                                            <i class="fa fa-check-square-o"></i> Approve
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a style="border-radius: 6px;"
                                            href="<?= site_url('admin/timesheet/leave_reject/'.$leave->leave_id) ?>">
                                            <i class="fa fa-times"></i> Reject
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a style="border-radius: 6px;"
                                            href="<?= site_url('admin/timesheet/leave_print/'.$leave->leave_id) ?>">
                                            <i class="fa fa-print"></i> Print
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var table = $('#myTable').DataTable({
        "bSort": false
    });
})
</script>
<?php
$error = $this->session->flashdata('error');
?>

<?php
if (isset($error)) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              document.getElementById('addnew').click();
            });
          </script>";
}
?>