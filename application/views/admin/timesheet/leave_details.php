<?php

?>
<?php $session = $this->session->userdata('username');?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']);?>
<?php
$datetime1 = new DateTime($from_date);
$datetime2 = new DateTime($to_date);
$interval = $datetime1->diff($datetime2);

if(strtotime($from_date) == strtotime($to_date)){
	$no_of_days =1;
} else {
	$no_of_days = $interval->format('%a') +1;
}
$leave_user = $this->Xin_model->read_user_info($employee_id);

//department head
$department = $this->Department_model->read_department_information($user[0]->department_id);
?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php
if (isset($error)) {
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
<div class="row m-b-1">
  <div class="col-md-5">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title"> <?php echo $this->lang->line('xin_leave_detail');?> </h3>
              </div>
            <div class="box-body">
            <?php $attributes = array('name' => 'update_status', 'autocomplete' => 'off');?>
				        <?php $hidden = array('emp_id' => $employee_id, 'user_id' => $session['user_id'], '_token_status' => $leave_id);?>
                <?php echo form_open('admin/timesheet/update_leave_status/'.$leave_id, $attributes, $hidden);?>
                <div class="table-responsive" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <tr>
                        <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('xin_employee');?></th>
                        <td class="text-right"><?php echo $full_name;?></td>
                      </tr>
                      <tr>
                        <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_department');?></th>
                        <td class="text-right"><?php echo $department_name;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_leave_type');?></th>
                        <td class="text-right">
                          <select  id="leave_type" name="leave_type" data-plugin="select_hrm" data-placeholder="
                            <?php echo $this->lang->line('xin_leave_type');?>">
                            <option value="<?= $leave_type_id?> "><?php echo $type;?></option>
                             <?php $leaves = leave_cal($employee_id);?>
                              <?php foreach($leaves['leaves'] as $key => $row) {  ?>
                               <option value="<?php echo $row['id'];?>"><?php echo $row['leave_name'] .' ('.$row['qty'].' '.$this->lang->line('xin_remaining').')';?></option>
                                <?php } ?>
                          </select>
                        </td>
                      </tr>

                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_applied_on');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($created_at);?></td>
                      </tr>
                      <tr>
                        <th scope="row">Applied from date</th>
                        <td class="text-right">
                          <input type="text" readonly value="<?php echo date('Y-m-d', strtotime($this->Xin_model->set_date_format($applyed_from_date))); ?>" />
                        </td>
                      </tr>

                      <tr>
                        <th scope="row">Applied to date</th>
                        <td class="text-right">
                          <input type="text" readonly value="<?php echo date('Y-m-d', strtotime($this->Xin_model->set_date_format($applyed_to_date))); ?>" />
                        </td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_start_date');?></th>
                        <td class="text-right">
                          <input type="date" name="start_date"  id="start_date" value="<?php echo date('Y-m-d', strtotime($this->Xin_model->set_date_format($from_date))); ?>" />
                        </td>
                      </tr>

                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_end_date');?></th>
                        <td class="text-right">
                          <input type="date" name="end_date" id="end_date" value="<?php echo date('Y-m-d', strtotime($this->Xin_model->set_date_format($to_date))); ?>" />
                        </td>
                      </tr>


                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_attachment');?></th>
                        <td class="text-right">
                        <?php if($leave_attachment!='' && $leave_attachment!='NULL'):?>
                        <a href="<?= base_url('/').$leave_attachment ?>" download><?php echo $this->lang->line('xin_download');?></a>
                        <a href="<?= base_url('/').$leave_attachment ?>" > View </a>
                        <?php else:?>

                        <?php endif;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_hrsale_total_days');?></th>
                        <td class="text-right">
                           <label for="leave_half_day">Leave Half Day</label>
                            <input type="checkbox" <?= ($is_half_day == 1)? 'checked':'';?>  value="<?= $is_half_day; ?>" id="leave_half_day" name="leave_half_day">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           <input type="number" id="day" name="day" value="<?=$day?>" style="width: 60px;">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div style="margin: 6px;width: 90%;border: 1px solid black;padding: 5px;border-radius: 8px;" class="bs-callout-success callout-border-left callout-square callout-transparent mt-1 p-1"> <?php echo $reason;?> </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="col-md-4">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> <?php echo $this->lang->line('xin_update_status');?> </h3>
            </div>
            <div class="box-body">
              <?php //dd($user[0]->user_role_id); ?>

                <div class="row">
                  <div class="col-md-12">
                    <?php  if($user[0]->user_role_id == 1 || $user[0]->user_role_id == 2 || $user[0]->user_role_id == 4) {?>
                    <div class="form-group">
                      <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                      <select class="form-control" name="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                        <option value="1" <?php if($status=='1'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_pending');?></option>
                        <option value="4" <?php if($status=='4'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_role_first_level_approval');?></option>
                        <?php if ($user[0]->user_role_id != 4) { ?>
                        <option value="2" <?php if($status=='2'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_approved');?></option>
                        <?php } ?>
                        <option value="3" <?php if($status=='3'):?> selected <?php endif; ?>><?php echo $this->lang->line('xin_rejected');?></option>
                      </select>
                    </div>
                    <?php } else {?>
                    <div class="form-group">
                      <label for="status"><?php echo $this->lang->line('dashboard_xin_status');?></label>
                      <select class="form-control" name="status" disabled >
                        <option value="1" <?php echo ($status=='1')? "selected":""; ?>><?php echo $this->lang->line('xin_pending');?></option>
                        <option value="2" <?php echo ($status=='2')? "selected":""; ?>><?php echo $this->lang->line('xin_approved');?></option>
                        <option value="3" <?php echo ($status=='3')? "selected":""; ?>><?php echo $this->lang->line('xin_rejected');?></option>
                        <option value="4" <?php echo ($status=='4')? "selected":""; ?>><?php echo $this->lang->line('xin_role_first_level_approval');?></option>
                      </select>
                    </div>
                  <?php } ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="remarks"><?php echo $this->lang->line('xin_remarks');?></label>
                      <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_remarks');?>" name="remarks" id="remarks" cols="30" rows="5"><?php echo $remarks;?></textarea>
                    </div>
                  </div>
                </div>
                <?php if($user[0]->user_role_id != 3) {?>
                <div class="form-actions box-footer">
                  <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                </div>
                <?php }?>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div class="col-md-3">
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"> <?php echo $this->lang->line('xin_last_taken_leave_title');?> </h3>
              </div>
            <div class="box-body">
              <div class="box-block card-dashboard">
              <div class="table-responsive" data-pattern="priority-columns">
                  <table class="table table-striped m-md-b-0">
                    <tbody>
                      <?php $show_last_leave = $this->Timesheet_model->employee_show_last_leave($employee_id,$leave_id); ?>
                      <?php foreach($show_last_leave as $last_leave) {

                					// get leave types
                					$type = $this->Timesheet_model->read_leave_type_information($last_leave->leave_type_id);
                					if(!is_null($type)){
                						$type_name = $type[0]->type_name;
                					} else {
                						$type_name = '--';
                					}
                					$datetime1 = new DateTime($last_leave->from_date);
                					$datetime2 = new DateTime($last_leave->to_date);
                					$interval = $datetime1->diff($datetime2);

                					if(strtotime($last_leave->from_date) == strtotime($last_leave->to_date)){
                						$last_leave_no_of_days =1;
                					} else {
                						$last_leave_no_of_days = $interval->format('%a') +1;
                					}
                					if($last_leave->is_half_day == 1){
                						$last_leave_day_info = $this->lang->line('xin_hr_leave_half_day');
                					} else {
                						$last_leave_day_info = $last_leave_no_of_days;
                					}
                				?>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_leave_type');?></th>
                        <td class="text-right"><?php echo $type_name;?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_applied_on');?></th>
                        <td class="text-right"><?php echo $this->Xin_model->set_date_format($last_leave->created_at);?></td>
                      </tr>
                      <tr>
                        <th scope="row"><?php echo $this->lang->line('xin_hrsale_total_days');?></th>
                        <td class="text-right"><?php echo $last_leave_day_info;?></td>
                      </tr>
                <?php }?>
                </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="decimal">
      <div class="row">
        <div class="col-md-12">
          <!-- <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"> <?php echo $this->lang->line('xin_leave_statistics');?> </h3>
              </div>
            <div class="box-body">
              <div class="box-block card-dashboard">
                                <?php $leave_categories_ids = explode(',',$leave_user[0]->leave_categories); ?>
                                <?php foreach($all_leave_types as $type) {
                          if(in_array($type->leave_type_id,$leave_categories_ids)){?>
                                <?php
                                  $hlfcount =0;
                          //$count_l =0;
                          $leave_halfday_cal = employee_leave_halfday_cal($type->leave_type_id,$employee_id);
                          foreach($leave_halfday_cal as $lhalfday):
                            $hlfcount += 0.5;
                          endforeach;
                          $count_l = count_leaves_info($type->leave_type_id,$employee_id);
                          $count_l = $count_l - $hlfcount;
                        ?>
                                <?php
                          $edays_per_year = $type->days_per_year;

                          if($count_l == 0){
                            $progress_class = '';
                            $count_data = 0;
                          } else {
                            if($edays_per_year > 0){
                              $count_data = $count_l / $edays_per_year * 100;
                            } else {
                              $count_data = 0;
                            }
                            // progress
                            if($count_data <= 20) {
                              $progress_class = 'progress-success';
                            } else if($count_data > 20 && $count_data <= 50){
                              $progress_class = 'progress-info';
                            } else if($count_data > 50 && $count_data <= 75){
                              $progress_class = 'progress-warning';
                            } else {
                              $progress_class = 'progress-danger';
                            }
                          }
                        ?>
                  <div id="leave-statistics">
                    <p><strong><?php echo $type->type_name;?> (<?php echo $count_l;?>/<?php echo $edays_per_year;?>)</strong></p>
                    <div class="progress" style="height: 6px;">
                    <div class="progress-bar" style="width: <?php echo $count_data;?>%;"></div>
                  </div>
                    <?php } }?>
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>
    </section>
  </div>
</div>

<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>

<script>
  function calculateDays() {
    var startDate = new Date(document.getElementById('start_date').value);
    var endDate = new Date(document.getElementById('end_date').value);
    var checkpoint = document.getElementById('leave_half_day');



    // Calculate the time difference in milliseconds
    var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());

    // Calculate the number of days
    var days = Math.ceil(timeDiff / (1000 * 3600 * 24));

    document.getElementById('day').value = days + 1;

    if (days+1 > 1) {
      checkpoint.setAttribute('disabled', 'disabled');
    } else {
      checkpoint.removeAttribute('disabled');
    }

  }

  // Event listeners for date input changes
  document.getElementById('start_date').addEventListener('change', calculateDays);
  document.getElementById('end_date').addEventListener('change', calculateDays);
</script>

<script>

function disableInput() {
    var leave_type = document.getElementById('leave_type');
    var start_date = document.getElementById('start_date');
    var end_date = document.getElementById('end_date');
    var day = document.getElementById('day');

    leave_type.setAttribute('disabled', 'disabled');
    start_date.setAttribute('disabled', 'disabled');
    end_date.setAttribute('disabled', 'disabled');
    day.setAttribute('disabled', 'disabled');
  }

var user_roll = <?= $session['role_id'] ?>;
if (user_roll === 3) {
      disableInput();
    }

console.log(user_roll);

</script>
<script>
 const checkbox = document.getElementById('leave_half_day');

checkbox.addEventListener('change', function() {
  if (this.checked) {
    document.getElementById('day').value = 0.5;
    day.setAttribute('disabled', 'disabled');
} else{
  document.getElementById('day').value = 1;
  day.removeAttribute('disabled', 'disabled');
}
});

</script>

