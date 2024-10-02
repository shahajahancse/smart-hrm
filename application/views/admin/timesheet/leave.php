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

                                <?php if($lead !=2){ ?>
                                    <li>
                                        <a onclick="modal_leave_data_ajax('<?= $leave->leave_id ?>')" style="border-radius: 6px;" data-toggle="modal"
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
                                    <?php if (in_array($user[0]->user_role_id, array(1,2))) { ?>
                                    <li class="divider"></li>
                                    <li>
                                        <a style="border-radius: 6px;"
                                            href="<?= site_url('admin/timesheet/leave_approve/'.$leave->leave_id.'/'.$leave->qty.'/'.$leave->from_date) ?>">
                                            <i class="fa fa-check-square-o"></i> Approve
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li class="divider"></li>
                                    <li>
                                        <a style="border-radius: 6px;"
                                            href="<?= site_url('admin/timesheet/leave_reject/'.$leave->leave_id) ?>">
                                            <i class="fa fa-times"></i> Reject
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a style="border-radius: 6px;" onclick="print_leave(<?= $leave->leave_id ?>)" >
                                            <i class="fa fa-print"></i> Print
                                        </a>
                                    </li>
                                    <?php }else{ ?> 
                                        <li>
                                        <a onclick="modal_leave_data_ajax('<?= $leave->leave_id ?>')" style="border-radius: 6px;" data-toggle="modal"
                                            data-target="#edit-leave-modal-data">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </li>
                                        <li>
                                            <a style="border-radius: 6px;"
                                                href="<?= site_url('admin/timesheet/leave_reject/'.$leave->leave_id) ?>">
                                                <i class="fa fa-times"></i> Reject
                                            </a>
                                        </li>
                                    <?php } ?>
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
    function checkhulf() {
        $total_day=$('#total_days_m');
        $Half_Day=$('#Half_Day_m');
        $from_date= $('#from_date_m');
        $to_date= $('#to_date_m');
        if($Half_Day.is(':checked')){
            $total_day.val(0.5);
            $to_date.val($from_date.val());
        }else{
            $total_day.val(1);
        }

        if ($total_day.val()==0.5) {
            $Half_Day.attr('checked','checked');
        }else(
            $Half_Day.removeAttr('checked')
        )
    }
</script>
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
<script>
   function  print_leave(id){
    var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();

      var data = "id="+id;
      url = base_url + "/print_leave";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
       ajaxRequest.send(data);
      ajaxRequest.onreadystatechange = function(){
        $('#loading').css({
          visibility: 'hidden'
      });
        if(ajaxRequest.readyState == 4){
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
          a.document.write(resp);
        }
      }


  }
</script>
