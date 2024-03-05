<?php
$user_info=$user_info[0];
?>


<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">
<body style="background:white">
<?php   $this->load->view('admin/head_bangla'); ?>
<h4 class="text-center">Report of All Increment Promotion List of <b><?= $user_info->first_name.' '.$user_info->last_name?> </b> </h4>
<div class="container"> 
    <br>
    <div style="display: flex;justify-content: center;"><?php
           echo "<table border='0' style='font-size:13px;' width='480'>";
           echo "<tr>";
           echo "<td width='70'>";
           echo "<strong>Emp ID:</strong>";
           echo "</td>";
           echo "<td width='200'>";
           echo $user_info->employee_id;
           echo "</td>";
   
           echo "<td width='55'>";
           echo "<strong>Name :</strong>";
           echo "</td>";
           echo "<td width='150'>";
           echo $user_info->first_name ." ". $user_info->last_name;
           echo "</td>";
           echo "</tr>";
   
   
           echo "<tr>";
           echo "<td>";
           echo "<strong>Dept :</strong>";
           echo "</td>";
           echo "<td>";
           echo $user_info->department_name;
           echo "</td>";
           echo "<td>";
           echo "<strong>Desig :</strong>";
           echo "</td>";
           echo "<td>";
           echo $user_info->designation_name;
           echo "</td>";
           echo "</tr>";
   
           echo "<tr>";
           echo "<td>";
           echo "<strong>DOJ :</strong>";
           echo "</td>";
           echo "<td>";
           echo date("d-M-Y", strtotime($user_info->date_of_joining));
           echo "</td>";
   
           echo "<td >";
           echo "<strong>DOB :</strong>";
           echo "</td>";
           echo "<td >";
           echo date("d-M-Y", strtotime($user_info->date_of_birth));
           echo "</td>";
           echo "</tr>";
           echo "</table>";
           ?>
        </div>
       
   <br>

   <table class="table table-striped table-bordered">
       <thead style="font-size:12px;" >
           <tr>
               <th class="text-center">S.N</th>
               <th class="text-center">Start</th>
               <th class="text-center">End </th>
               <th class="text-center">Status</th>
               <th class="text-center">Period</th>
               <th class="text-center">Increment Amount</th>
               <th class="text-center">Old Salary</th>
               <th class="text-center">New Salary</th>
               <th class="text-center">Remark</th>
   
           </tr>
       </thead>
       <tbody style="font-size:12px;" >
           <?php foreach ($list as $key => $value) {?>
           <tr>
               <td><?= $key+1 ?></td>
               <td>
                   <?= $value->effective_date?>
               </td>
               <td><?= $value->end_date?></td>
             <td>
                 <?php
                 switch ($value->status) {
                     case 1:
                         echo 'Probation_to_Regular';
                         break;
                     case 2:
                         echo 'Increment';
                         break;
                     case 3:
                         echo 'Promotion';
                         break;
                     case 4:
                         echo 'Intern_to_Probation';
                         break;
                     case 5:
                         echo 'Intern_to_Regular';
                         break;
                     default:
                         echo $value->status;
                         break;
                 }
                 ?>
             </td>
               <td>
                   <?php
                   $joiningDate = new DateTime($value->effective_date);
                   $nextIncreDate = new DateTime($value->end_date);
                   $diff = $joiningDate->diff($nextIncreDate);
                   $years = $diff->y;
                   $months = $diff->m;
                   $days = $diff->d;?>
                  <?=($years)?$years.' Years ':''?><?=($months)?$months.' Months ':''?><?=($days)?$days.' Days ':''?>      
               </td>
               <td><?= $value->new_salary - $value->old_salary?></td>
               <td><?= $value->old_salary?></td>
               <td><?= $value->new_salary?></td>
               <td><?= $value->remark?></td>
              </tr>
           <?php }?>
       </tbody>
   </table>
 </div>

</body>