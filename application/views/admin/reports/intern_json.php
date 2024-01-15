            <div style="float: right;">
                <form style="float: right;"  action="<?php echo base_url('admin/reports/fetch_data/'); ?>" method="post">
                <input type="hidden" name="first_date" value="<?php echo $first_date; ?>">
                <input type="hidden" name="second_date" value="<?php echo $second_date; ?>">
                <input type="hidden" name="elc" value="1">

                <button class="btn btn-sm btn-info" style="margin-right:15px" type="submit" id="excel">Excel</button>
                </form>
            </div>
            
            <h4 class="text-center"><span>Report of <?= $data_type ?> Pending List From <?php echo $first_date; ?> To <?php echo $second_date; ?></span></h4>
            <table class="table table-striped table-bordered">
                <thead style="font-size:12px;" >
                    <tr>
                        <th class="text-center">S.N</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Designation</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Joining Date</th>
                        <th class="text-center" style="background: #e9ed46;">Emp. Type</th>
                        <th class="text-center">End Date</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Increment</th>
                        <?php if($session['role_id']==1){?>
                        <th class="text-center">Gross Salary</th>
                        <?php } ?>
                        <th class="text-center">Note File</th>
                        <th class="text-center">Job Duration</th>
                        <th class="text-center">Remark</th>
                    </tr>
                </thead>
                <tbody style="font-size:12px;" >
                    <?php  if (!empty($pending_list)) {
                        $i=1; foreach ($pending_list as $key => $value) {?>
                        <tr class="text-center">
                            <td><?= $i++?></td>
                            <td><?= $value->first_name.' '.$value->last_name?></td>
                            <td><?= $value->department_name?></td>
                            <td><?= $value->designation_name?></td>
                            <?php if ($value->status == 1) {
                                $emp_status = 'Regular';
                            } else if ($value->status == 4) {
                                $emp_status = 'Intern';
                            } else {
                                $emp_status = 'Probation';
                            } ?>
                            <td><?= $value->date_of_joining?></td>
                            <td style="background: #e9ed46;"><?= $emp_status ?></td>
                            <td><?= $value->next_incre_date?></td>
                            <td>
                            <?php
                            
                                if ($value->status == 1 && !empty($value->last_incre_date)) {
                                    $joiningDate = new DateTime($value->last_incre_date);
                                    $nextIncreDate = new DateTime($value->next_incre_date);
                                    $diff = $joiningDate->diff($nextIncreDate);
                                    
                                    $years = $diff->y;
                                    $months = $diff->m;
                                    $days = $diff->d;

                                } else if (!empty($value->next_incre_date)) {
                                $joiningDate = new DateTime($value->date_of_joining);
                                $nextIncreDate = new DateTime($value->next_incre_date);
                                
                                $diff = $joiningDate->diff($nextIncreDate);
                                
                                $years = $diff->y;
                                $months = $diff->m;
                                $days = $diff->d;
                                } else {
                                    $years = 0;
                                    $months = 0;
                                    $days = 0;
                                }

                            ?>
                            
                           <?=($years)?$years.' Years ':''?><?=($months)?$months.' Months ':''?><?=($days)?$days.' Days ':''?>
                         
                            </td>
                            <td><?= $value->new_salary - $value->old_salary?></td>
                            <?php if($session['role_id'] == 1){?>
                            <td><?= $value->basic_salary?></td>
                            <?php } ?>
                            <td>
                                <?php if($value->note_file == null){
                                    echo 'No File';
                                }else{?>
                                    <a href="<?=  base_url('uploads/profile/').$value->note_file?>" target="_blank">View</a>
                                    <a href="<?=  base_url('uploads/profile/').$value->note_file?>" download="<?=  base_url('uploads/profile/').$value->note_file?>">Download</a>
                                <?php  }?>
                            </td>

                            <?php 
                                $date1 = new DateTime($value->date_of_joining);
                                $date2 = new DateTime();
                                $interval = date_diff($date1, $date2);
                            ?>
                            <td><?= ($interval->y == 0 ? '':$interval->y.' years ').$interval->m.' months '.$interval->d.' days'?></td>
                            <td><?= $value->remark?></td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
            
            <br>
            <h4 class="text-center"><span>Report of <?= $data_type ?> Complete List From <?php echo $first_date; ?> To <?php echo $second_date; ?></span></h4>
            <table class="table table-striped table-bordered">
                <thead style="font-size:12px;" >
                    <tr>
                        <th class="text-center">S.N</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Designation</th>
                        <th class="text-center">Department</th>
                        <th class="text-center">Joining Date</th>
                        <th class="text-center">Emp. Type</th>
                        <th class="text-center">End Date</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Increment</th>
                        <?php if($session['role_id']==1){?>
                        <th class="text-center">Gross Salary</th>
                        <?php } ?>
                        <th class="text-center">Note File</th>
                        <th class="text-center">Job Duration</th>
                        <th class="text-center">Remark</th>
                    </tr>
                </thead>
                <tbody style="font-size:12px;" >
                    <?php if (!empty($done_list)) { 
                        $i=1; foreach ($done_list as $key => $value) {?>
                        <tr class="text-center">
                            <td><?= $i++?></td>
                            <td><?= $value->first_name.' '.$value->last_name?></td>
                            <td><?= $value->department_name?></td>
                            <td><?= $value->designation_name?></td>
                            <?php if ($value->status == 1) {
                                $emp_status = 'Regular';
                            } else if ($value->status == 4) {
                                $emp_status = 'Intern';
                            } else {
                                $emp_status = 'Probation';
                            } ?>
                            <td><?= $value->date_of_joining?></td>
                            <td><?= $emp_status ?></td>
                            <td><?= $value->next_incre_date?></td>
                            <td>
                            <?php
                            
                                if ($value->status == 1 && !empty($value->last_incre_date)) {
                                    $joiningDate = new DateTime($value->last_incre_date);
                                    $nextIncreDate = new DateTime($value->next_incre_date);
                                    $diff = $joiningDate->diff($nextIncreDate);
                                    
                                    $years = $diff->y;
                                    $months = $diff->m;
                                    $days = $diff->d;

                                } else if (!empty($value->next_incre_date)) {
                                $joiningDate = new DateTime($value->date_of_joining);
                                $nextIncreDate = new DateTime($value->next_incre_date);
                                
                                $diff = $joiningDate->diff($nextIncreDate);
                                
                                $years = $diff->y;
                                $months = $diff->m;
                                $days = $diff->d;
                                } else {
                                    $years = 0;
                                    $months = 0;
                                    $days = 0;
                                }

                            ?>
                            
                           <?=($years)?$years.' Years ':''?><?=($months)?$months.' Months ':''?><?=($days)?$days.' Days ':''?>
                         
                            </td>
                            <td><?= $value->new_salary - $value->old_salary?></td>
                            <?php if($session['role_id']==1){?>
                            <td><?= $value->basic_salary?></td>
                            <?php } ?>
                            <td>
                                <?php if($value->note_file == null){
                                    echo 'No File';
                                }else{?>
                                    <a href="<?=  base_url('uploads/profile/').$value->note_file?>" target="_blank">View</a>
                                    <a href="<?=  base_url('uploads/profile/').$value->note_file?>" download="<?=  base_url('uploads/profile/').$value->note_file?>">Download</a>
                                <?php  }?>
                            </td>
                            
                            <?php 
                                $date1 = new DateTime($value->date_of_joining);
                                $date2 = new DateTime();
                                $interval = date_diff($date1, $date2);
                            ?>
                            <td><?= ($interval->y == 0 ? '':$interval->y.' years ').$interval->m.' months '.$interval->d.' days'?></td>
                            <td><?= $value->remark?></td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>