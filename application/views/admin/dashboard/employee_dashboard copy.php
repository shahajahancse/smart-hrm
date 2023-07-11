<?php
    $session = $this->session->userdata( 'username' );
    $userid  = $session[ 'user_id' ];
    $lastmonthsalarys  = $this->Salary_model->getpassedmonthsalary( $userid );
  
    $lastmonthsalaryy =$lastmonthsalarys[0];
  
    $lastmont=$lastmonthsalarys[0]->salary_month;

    $lastmont = $lastmonthsalarys[0]->salary_month;
    $date_object = DateTime::createFromFormat('Y-m', $lastmont);
    $monthName = $date_object->format('F');     
?>


<?php
 $this->db->select("*");
 $this->db->where("emp_id", $userid);
 $this->db->order_by("id", "desc"); // Order the results by the "id" column in descending order
 $this->db->limit(1); // Limit the result set to 1 row
 $user_lunch = $this->db->get('lunch_payment')->row(); // Retrieve the last row as an object



 $cdate = date('Y-m-d');

 $cyear = date('Y', strtotime($cdate));
 $cmonth = date('m', strtotime($cdate));
 $cday = date('d', strtotime($cdate));
 
 if ($cday < 13) {
     $first_date = date('Y-m', strtotime($cdate . ' -1 month')) . '-13';
     $second_date = date('Y-m', strtotime($cdate . ' +0 month')) . '-12';
 } else {
     $first_date = date('Y-m', strtotime($cdate . ' +0 month')) . '-13';
     $second_date = date('Y-m', strtotime($cdate . ' +1 months')) . '-12';
 }
    $this->db->select('*');
    $this->db->from('lunch_details');
    $this->db->where('emp_id', $userid);
    $this->db->where('date >=', $first_date);
    $this->db->where('date <=', $second_date);
    $lonchdatad=$this->db->get()->result();
    if(count($lonchdatad)>0){
      $total_meal_p=0;
      foreach($lonchdatad as $lonchdat){
        $total_meal_p+=$lonchdat->meal_amount;
      };


    }else{
      $total_meal_p=0;
    };
   

?>






<?php
$leavecal=(leave_cal($userid));
$leave_calel=$leavecal['leaves'][0];
$leave_calsl=$leavecal['leaves'][1];  
?>
<?php
// dd($session);
  $datep        = date( "Y-m-d");
  $date        = date( "Y-m-01");
  $present_stutas  = $this->Salary_model->count_attendance_status_wise($userid, $date , $datep);
  $leave_stutas  = $this->Salary_model->leave_count_status($userid, $date , $datep, 2);
?>
<style>
.info-box2 {
    min-height: 190px;
    background: #f2f2f2;
    width: 100%;
    margin-bottom: 20px;
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    padding: 0 !important;
    color: #333;
    font-family: Arial, sans-serif;
    transition: transform 0.3s ease;
    border: 1px solid black;
}
.contentbox{

  padding: 11px;
}
.box_titel {
    font-size: 13px;
    margin-bottom: 0;
    color: #251e1e;
    padding: 4px;
    text-align: center;
    font-weight: bold;
    
    border-radius: 10px 10px 0px 0px;
    border-bottom: 2px solid black;
    height: 34px;
    overflow: hidden;
}
.overlayth{
    height: 20px;
    overflow: hidden;
}
.box_footer{
    font-size: 13px;
    margin-bottom: 0;
    color: #251e1e;
    padding: 3px;
    text-align: center;
    font-weight: bold;
    border-radius: 0px 0px 10px 10px;
    border-top: 2px solid black;
}

.modalbox{
    border-right: 2px solid black;
    border-left: 2px solid black;
    border-bottom: 2px solid black;
    border-radius: 0px 0px 6px 6px;
    padding: 4px;
    overflow: hidden;
    height: max-content;
    display: inline-block;
    width: 100%;

}
.modalboxheader{
    background-color: #a8b0b2;
    display: inline-block;
    width: 100%;
    height: 32px;
    padding: 5px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    border-top: 2px solid black;
    border-right: 2px solid black;
    border-left: 2px solid black;
    border-radius: 6px 6px 0px 0px;
}
</style>




<!-- Modal -->
<div class="modal fade" id="lunchmidal" tabindex="-1" role="dialog" aria-labelledby="lunchmidalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Lunch Detils</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
             <span class="modalboxheader">Previous</span>
             <div class="modalbox">
                <div class="col-md-12" style="background-color: #e3eaf1; margin: 2px; padding: 2px;">
                    <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Previous Meal:</p>
                    <p style="margin: 0;" class="col-md-4 overlayth"><?php echo isset($user_lunch->prev_meal) ? $user_lunch->prev_meal : '0'; ?></p>
                </div>
                <div class="col-md-12" style="margin: 2px; padding: 2px;">
                    <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Previous Cost:</p>
                    <p style="margin: 0;" class="col-md-4 overlayth"><?php echo isset($user_lunch->prev_cost) ? $user_lunch->prev_cost : '0'; ?></p>
                </div>
                <div class="col-md-12" style="background-color: #e3eaf1; margin: 2px; padding: 2px;">
                    <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Previous Pay </p>
                    <p style="margin: 0;" class="col-md-4 overlayth"><?php echo isset($user_lunch->prev_pay) ? $user_lunch->prev_pay : '0'; ?></p>
                </div>
            </div>
            <span class="modalboxheader">Present</span>
            <div class="modalbox">
                <div class="col-md-12" style="background-color: #e3eaf1; margin: 2px; padding: 2px;">
                    <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Present meal:</p>
                    <p style="margin: 0;" class="col-md-4 overlayth"><?php echo isset($total_meal_p) ? $total_meal_p : '0'; ?></p>
                </div>
                <div class="col-md-12" style="margin: 2px; padding: 2px;">
                    <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Pay Amount :</p>
                    <p style="margin: 0;" class="col-md-4 overlayth"><?php echo isset($user_lunch->pay_amount) ? $user_lunch->pay_amount : '0'; ?></p>
                </div>
                <div class="col-md-12" style="background-color: #e3eaf1; margin: 2px; padding: 2px;">
                    <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Paid Status</p>
                    <p style="margin: 0;" class="col-md-4 overlayth"><?= isset($user_lunch->status) ? ($user_lunch->status == 1 ? "Paid" : "Unpaid") : '0'; ?></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
  </div>
</div>










<?php 
$session = $this->session->userdata('username');
$user_info = $this->Exin_model->read_user_info($session['user_id']);
// dd($user_info[0]->status);
$theme = $this->Xin_model->read_theme_info(1);
if($user_info[0]->profile_picture!='' && $user_info[0]->profile_picture!='no file') {
	$lde_file = base_url().'uploads/profile/'.$user_info[0]->profile_picture;
} else { 
	if($user_info[0]->gender=='Male') {  
		$lde_file = base_url().'uploads/profile/default_male.jpg'; 
	} else {  
		$lde_file = base_url().'uploads/profile/default_female.jpg';
	}
}
$last_login =  new DateTime($user_info[0]->last_login_date);
// get designation
$designation = $this->Designation_model->read_designation_information($user_info[0]->designation_id);
if(!is_null($designation)){
	$designation_name = $designation[0]->designation_name;
} else {
	$designation_name = '--';	
}
$role_user = $this->Xin_model->read_user_role_info($user_info[0]->user_role_id);
if(!is_null($role_user)){
	$role_resources_ids = explode(',',$role_user[0]->role_resources);
} else {
	$role_resources_ids = explode(',',0);	
}
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $announcement = $this->Announcement_model->get_new_announcements();?>
<?php foreach($announcement as $new_announcement):?>
<?php
	$current_date = strtotime(date('Y-m-d'));
	$announcement_end_date = strtotime($new_announcement->end_date);
	if($current_date <= $announcement_end_date) {
?>

<div class="alert alert-success alert-dismissible fade in mb-1" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <strong><?php echo $new_announcement->title;?>:</strong> <?php echo $new_announcement->summary;?> <a href="#" class="alert-link" data-toggle="modal" data-target=".view-modal-annoucement" data-announcement_id="<?php echo $new_announcement->announcement_id;?>"><?php echo $this->lang->line('xin_view');?></a> </div>
<?php } ?>
<?php endforeach;?>
<div class="row <?php echo $get_animate;?>">
<?php if(in_array('14',$role_resources_ids)) { ?>
  <?php if($system[0]->module_awards=='true'){?>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/awards/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-primary"><i class="fa fa-trophy"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->Exin_model->total_employee_awards_dash();?> <?php echo $this->lang->line('left_awards');?></span> <span class="info-box-text"><span class=""> <?php echo $this->lang->line('xin_view');?> </span></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <?php } else {?>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/timesheet/attendance/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-primary"><i class="fa fa-clock-o"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('dashboard_attendance');?></span> <span class="info-box-text"><?php echo $this->lang->line('xin_view');?></span> </div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <?php } ?>
  <?php } ?>
  <?php if(in_array('37',$role_resources_ids)) { ?>
  <!-- /.col -->
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/payroll/payment_history/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('left_payslips');?> <?php echo $this->lang->line('xin_view');?></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>
  <!-- /.col --> 
  <?php } ?>
 
  <!-- box start -->
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state">
    <div class="info-box2 hrsalle-mini-stat">
        <p class="box_titel">Attendance Overview For <?= date("M-Y") ?></p>
        <div class="contentbox">
            <div class="col-md-12" style="background-color: #e3eaf1;margin: 2px; padding: 2px;">
                <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">(Present : Absent):</p>
                <p style="margin: 0;" class="col-md-4 overlayth">(<?php echo ($present_stutas->attend > 0) ? $present_stutas->attend : '0'; ?>: <?php echo ($present_stutas->absent > 0) ? $present_stutas->absent : '0'; ?>)</p>
            </div>
            <div class="col-md-12" style="margin: 2px; padding: 2px;">
                <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Leave : </p>
                <p style="margin: 0;" class="col-md-4 overlayth"><?php echo (($leave_stutas->el) + ($leave_stutas->sl) > 0) ? ($leave_stutas->el) + ($leave_stutas->sl) : '0'; ?></p>
            </div>
            <div class="col-md-12" style="background-color: #e3eaf1;margin: 2px; padding: 2px;">
                <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Holiday + weekend: </p>
                <p style="margin: 0;" class="col-md-4 overlayth"><?php echo (($present_stutas->holiday) + ($present_stutas->weekend) > 0) ? ($present_stutas->holiday) + ($present_stutas->weekend) : '0'; ?></p>
            </div>
            <div class="col-md-12" style="margin: 2px; padding: 2px;">
                <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Late : </p>
                <p style="margin: 0;" class="col-md-4 overlayth"><?php echo ($present_stutas->late_status > 0) ? $present_stutas->late_status : '0'; ?></p>
            </div>
        </div>
        <a href="<?php echo site_url('admin/timesheet/timecalendar/'); ?>">
            <div class="col-md-12 box_footer">
                <p style="margin: 0;font-weight: bold;text-align: center; color:#251e1e;" class="col-md-12">View attendance calendar <span class="pull-right-container"> <i class="fa fa-angle-right"></i> </span></p>
            </div>
        </a>
    </div>
</div>


  <!-- box end -->
   <!-- box start -->
   <div class="col-xl-6 col-md-3 col-12 hr-mini-state">
      <div class="info-box2 hrsalle-mini-stat">
        <p class="box_titel">Lunch Overview For <?= isset($user_lunch->pay_month) ? $user_lunch->pay_month : '0' ?></p>
        <div class="contentbox">
          <div class="col-md-12" style="background-color: #e3eaf1;margin: 2px; padding: 2px;">
            <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Previous Cost:</p>
            <p style="margin: 0;" class="col-md-4 overlayth"><?= isset($user_lunch->prev_cost) ? $user_lunch->prev_cost : '0' ?></p>
          </div>
          <div class="col-md-12" style="margin: 2px; padding: 2px;">
            <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Previous Pay</p>
            <p style="margin: 0;" class="col-md-4 overlayth"><?= isset($user_lunch->prev_pay) ? $user_lunch->prev_pay : '0' ?></p>
          </div>
          <div class="col-md-12" style="background-color: #e3eaf1;margin: 2px; padding: 2px;">
            <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Pay Amount:</p>
            <p style="margin: 0;" class="col-md-4 overlayth"><?= isset($user_lunch->pay_amount) ? $user_lunch->pay_amount : '0' ?></p>
          </div>
          <div class="col-md-12" style="margin: 2px; padding: 2px;">
            <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Present Meal</p>
            <p style="margin: 0;" class="col-md-4 overlayth"><?= isset($total_meal_p) ? $total_meal_p : '0' ?></p>
          </div>
        </div>
        <a data-toggle="modal" data-target="#lunchmidal">
          <div class="col-md-12 box_footer">
            <p style="margin: 0;font-weight: bold;text-align: center; color:#251e1e;" class="col-md-12">
              View Details
              <span class="pull-right-container">
                <i class="fa fa-angle-right"></i>
              </span>
            </p>
          </div>
        </a>
      </div>
  </div>

  <!-- box end -->

  <!-- box start -->
          <div class="col-xl-6 col-md-3 col-12 hr-mini-state">
            <div class="info-box2 hrsalle-mini-stat"> 
              <p class="box_titel">Salary of <?=$monthName?></p>
              <div class="contentbox"> 
                
                
                <div class="col-md-12" style="background-color: #e3eaf1;margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Salary : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth"><?php echo ( $lastmonthsalaryy->basic_salary) ?></p>
                </div>
                <div class="col-md-12" style="margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Pay Salary : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth"><?php echo ( $lastmonthsalaryy->grand_net_salary + $lastmonthsalaryy->modify_salary) ?></p>
                </div>
               
                <div class="col-md-12" style=" background-color: #e3eaf1; margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Deduct : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth"><?php echo ( $lastmonthsalaryy->late_deduct + $lastmonthsalaryy->absent_deduct) ?></p>
                  
                </div>
                <div class="col-md-12" style="margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Working Day:</p>
                  <p style="margin: 0;" class="col-md-4 overlayth"><?php echo ($lastmonthsalaryy->present)+($lastmonthsalaryy->holiday)+($lastmonthsalaryy->weekend) ?></p>
                  
                </div>
              </div>
              <a onclick="payslip('<?=$lastmont ?>','<?=$userid ?>','1')">
                  <div class="col-md-12 box_footer">
                      
                      <p style="margin: 0;font-weight: bold;text-align: center; color:#251e1e;" class="col-md-12">View Payslip <span class="pull-right-container">  <i class="fa fa-angle-right"></i> </span></p>
                    
                  </div>
                </a>
               
            </div>
          </div>
  <!-- box end -->
   
   <!-- box start -->
   <div class="col-xl-6 col-md-3 col-12 hr-mini-state">
            <div class="info-box2 hrsalle-mini-stat"> 
              <p class="box_titel">Leave Managment</p>
              <div class="contentbox"> 
                
                <?php if ($user_info[0]->status==1){ ?>
                <div class="col-md-12" style="background-color: #e3eaf1;margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;"  class="col-md-8 overlayth">Available Earn Leave : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth"><?php echo $leave_calel['qty'] ?></p>
                </div>
                <div class="col-md-12" style="margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Available Sick Leave : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth"><?php echo $leave_calsl['qty'] ?></p>
                </div>
                <div class="col-md-12" style="background-color: #e3eaf1;margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Used Earn Leave : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth"><?php echo (12-($leave_calel['qty']))?></p>
                </div>
                <div class="col-md-12" style="margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Used Sick Leave : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth"><?php echo (4-($leave_calsl['qty'])) ?></p>
                </div>
                <?php }else{
                 ?>


                <div class="col-md-12" style="background-color: #e3eaf1;margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;"  class="col-md-8 overlayth">Available Earn Leave : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth">0</p>
                </div>
                <div class="col-md-12" style="margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Available Sick Leave : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth">0</p>
                </div>
                <div class="col-md-12" style="background-color: #e3eaf1;margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Used Earn Leave : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth">0</p>
                </div>
                <div class="col-md-12" style="margin: 2px; padding: 2px;">
                  
                  <p style="margin: 0;font-weight: bold;padding: 0;" class="col-md-8 overlayth">Used Sick Leave : </p>
                  <p style="margin: 0;" class="col-md-4 overlayth">0</p>
                </div>
                <?php } ?>
              </div>
                <a  href="<?php echo site_url('admin/timesheet/leave/');?>">
                  <div class="col-md-12 box_footer" >
                      
                      <p style="margin: 0;font-weight: bold;text-align: center; color:#251e1e;" class="col-md-12">Request Leave <span class="pull-right-container">  <i class="fa fa-angle-right"></i> </span></p>
                    
                  </div>
                </a>
            </div>
          </div>
  <!-- box end -->
 
  <!-- <?php if(in_array('46',$role_resources_ids)) { ?>
  <div class="clearfix visible-sm-block"></div>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/timesheet/leave/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-purple"><i class="fa fa-calendar"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_performance_management');?> <?php echo $this->lang->line('left_leave');?></span></div>
      
    </div>
    </a> 
    
  </div>
  <?php } ?> -->
  <?php if($system[0]->module_travel=='true'){?>
  <!-- /.col -->
  <?php if(in_array('17',$role_resources_ids)) { ?>
  <div class="col-xl-6 col-md-3 col-12 hr-mini-state"> <a class="text-muted" href="<?php echo site_url('admin/travel/');?>">
    <div class="info-box hrsalle-mini-stat"> <span class="info-box-icon bg-red"><i class="fa fa-plane"></i></span>
      <div class="info-box-content"> <span class="info-box-number"><?php echo $this->lang->line('xin_travel');?> <?php echo $this->lang->line('xin_requests');?></span></div>
      <!-- /.info-box-content --> 
    </div>
    </a> 
    <!-- /.info-box --> 
  </div>  
  <?php } ?>
  <!-- /.col -->
  <?php } ?>
</div>
<?php
$att_date =  date('d-M-Y');
$attendance_date = date('d-M-Y');
// get office shift for employee
$get_day = strtotime($att_date);
$day = date('l', $get_day);
$strtotime = strtotime($attendance_date);
$new_date = date('d-M-Y', $strtotime);
// office shift
$u_shift = $this->Timesheet_model->read_office_shift_information($user_info[0]->office_shift_id);

// get clock in/clock out of each employee
if($day == 'Monday') {
	if($u_shift[0]->monday_in_time==''){
		$office_shift = $this->lang->line('dashboard_today_monday_shift');
	} else {
		$in_time =  new DateTime($u_shift[0]->monday_in_time. ' ' .$attendance_date);
		$out_time =  new DateTime($u_shift[0]->monday_out_time. ' ' .$attendance_date);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Tuesday') {
	if($u_shift[0]->tuesday_in_time==''){
		$office_shift = $this->lang->line('dashboard_today_tuesday_shift');
	} else {
		$in_time =  new DateTime($u_shift[0]->tuesday_in_time. ' ' .$attendance_date);
		$out_time =  new DateTime($u_shift[0]->tuesday_out_time. ' ' .$attendance_date);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Wednesday') {
	if($u_shift[0]->wednesday_in_time==''){
		$office_shift = $this->lang->line('dashboard_today_wednesday_shift');
	} else {
		$in_time =  new DateTime($u_shift[0]->wednesday_in_time. ' ' .$attendance_date);
		$out_time =  new DateTime($u_shift[0]->wednesday_out_time. ' ' .$attendance_date);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Thursday') {
	if($u_shift[0]->thursday_in_time==''){
		$office_shift = $this->lang->line('dashboard_today_thursday_shift');
	} else {
		$in_time =  new DateTime($u_shift[0]->thursday_in_time. ' ' .$attendance_date);
		$out_time =  new DateTime($u_shift[0]->thursday_out_time. ' ' .$attendance_date);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Friday') {
	if($u_shift[0]->friday_in_time==''){
		$office_shift = $this->lang->line('dashboard_today_friday_shift');
	} else {
		$in_time =  new DateTime($u_shift[0]->friday_in_time. ' ' .$attendance_date);
		$out_time =  new DateTime($u_shift[0]->friday_out_time. ' ' .$attendance_date);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Saturday') {
	if($u_shift[0]->saturday_in_time==''){
		$office_shift = $this->lang->line('dashboard_today_saturday_shift');
	} else {
		$in_time =  new DateTime($u_shift[0]->saturday_in_time. ' ' .$attendance_date);
		$out_time =  new DateTime($u_shift[0]->saturday_out_time. ' ' .$attendance_date);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
} else if($day == 'Sunday') {
	if($u_shift[0]->sunday_in_time==''){
		$office_shift = $this->lang->line('dashboard_today_sunday_shift');
	} else {
		$in_time =  new DateTime($u_shift[0]->sunday_in_time. ' ' .$attendance_date);
		$out_time =  new DateTime($u_shift[0]->sunday_out_time. ' ' .$attendance_date);
		$clock_in = $in_time->format('h:i a');
		$clock_out = $out_time->format('h:i a');
		$office_shift = $this->lang->line('dashboard_office_shift').': '.$clock_in.' '.$this->lang->line('dashboard_to').' '.$clock_out;
	}
}
?>
<?php $sys_arr = explode(',',$system[0]->system_ip_address); ?>
<?php $attendances = $this->Timesheet_model->attendance_time_checks($user_info[0]->user_id); $dat = $attendances->result();?>
<?php
$bgatt = 'bg-success';
if($attendances->num_rows() < 1) {
	$bgatt = 'bg-success';
} else {
	$bgatt = 'bg-danger';
	$bgatt = 'bg-success';
}
?>
<!-- <div class="row <?php echo $get_animate;?>">
  <div class="col-md-4">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab"><?php echo $this->lang->line('xin_attendance_mark_attendance');?></a></li>
        <li><a href="#tab_2" data-toggle="tab"><?php echo $this->lang->line('xin_attendance_overview_this_month');?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="box-widget widget-user"> 
            <div class="widget-user-header <?php echo $bgatt;?> bg-darken-2">
              <h3 class="widget-user-username"><?php echo $user_info[0]->first_name. ' ' .$user_info[0]->last_name;?> </h3>
              <h5 class="widget-user-desc"><?php echo $designation_name;?></h5>
            </div>
            <div class="widget-user-image"> <img class="img-circle" src="<?php echo $lde_file;?>" alt="User Avatar"> </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-12">
                  <div class="description-block">
                    <p class="text-muted pb-0-5"><?php echo $this->lang->line('dashboard_last_login');?>: <?php echo $this->Xin_model->set_date_format($user_info[0]->last_login_date).' '.$last_login->format('h:i a');?></p>
                    <p class="text-muted pb-0-5"><?php echo $office_shift;?></p>
                  </div>
                  
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="text-xs-center">
                    <div class="text-xs-center pb-0-5">
                      <?php $attributes = array('name' => 'set_clocking', 'id' => 'set_clocking', 'autocomplete' => 'off', 'class' => 'form');?>
                      <?php $hidden = array('exuser_id' => $session['user_id']);?>
                      <?php echo form_open('admin/timesheet/set_clocking', $attributes, $hidden);?>
                      <input type="hidden" name="timeshseet" value="<?php echo $user_info[0]->user_id;?>">
                      <?php if($attendances->num_rows() < 1) {?>
                      <input type="hidden" value="clock_in" name="clock_state" id="clock_state">
                      <input type="hidden" value="" name="time_id" id="time_id">
                      <div class="row">
                        <div class="col-md-6">
                          <button class="btn btn-success btn-block text-uppercase" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('dashboard_clock_in');?></button>
                        </div>
                        <div class="col-md-6">
                          <button class="btn btn-danger btn-block text-uppercase" disabled="disabled" type="submit" id="clock_btn"><i class="fa fa-arrow-circle-left"></i> <?php echo $this->lang->line('dashboard_clock_out');?></button>
                        </div>
                      </div>
                      <?php } else {?>
                      <input type="hidden" value="clock_out" name="clock_state" id="clock_state">
                      <input type="hidden" value="<?php echo $dat[0]->time_attendance_id;?>" name="time_id" id="time_id">
                      <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                        </div>
                      </div>
                      <?php } ?>
                      <?php echo form_close(); ?> </div>
                  </div>
                </div>
              </div>
              <?php if(in_array('10',$role_resources_ids)) { ?>
              <div class="row">
                <div class="col-md-12 col-md-offset-1">
                  <div class="margin">
                    <div class="btn-group"> <a type="button" href="<?php echo site_url('admin/timesheet/');?>" class="btn btn-default btn-flat">My Attendance Timesheet</a> </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
    
        <div class="tab-pane" id="tab_2">

          <div class="">
            <div class="box-body">
              <div class="table-responsive" data-pattern="priority-columns">
                <table class="table table-striped m-md-b-0">
                  <tbody>
                    <tr>
                      <th scope="row" colspan="2" style="text-align: center;"><?php echo $this->lang->line('xin_attendance_this_month');?></th>

                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_attendance_total_present');?></th>
                      <td class="text-right"><?php echo $pcount;?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_attendance_total_absent');?></th>
                      <td class="text-right"><?php echo $acount;?></td>
                    </tr>
                    <tr>
                      <th scope="row"><?php echo $this->lang->line('xin_attendance_total_leave');?></th>
                      <td class="text-right"><?php echo $lcount;?></td>
                    </tr>
                    <?php if(in_array('261',$role_resources_ids)) { ?>
                    <tr>
                      <th scope="row" colspan="2" style="text-align: center;"><a href="<?php echo site_url('admin/timesheet/timecalendar/');?>"><?php echo $this->lang->line('xin_attendance_cal_view');?></a></th>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php if(in_array('45',$role_resources_ids)) { ?>
  <?php //if($system[0]->module_projects_tasks=='true'){?>
  <div class="col-xl-8 col-lg-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_my_tasks');?></h3>
      </div>
      <div class="box-body">
        <div class="table-responsive height-200">
          <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_action');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_end_date');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
              </tr>
            </thead>
            <tbody>
              <?php $task = $this->Timesheet_model->get_tasks();?>
              <?php $dId = array(); $i=1; $ct_tasks = 0;
				$ovt_tasks = 0; $tot_tasks=0; foreach($task->result() as $et):
				 // $aw_name = $hrm->e_award_type($emp_award->award_type_id);
				 $asd = array($et->assigned_to);
				 $aim = explode(',',$et->assigned_to);
				 foreach($aim as $dIds) {
					 if($session['user_id'] === $dIds) {
						$dId[] = $session['user_id'];
					// task end date		
					$tdate = $this->Xin_model->set_date_format($et->end_date);
					// task progress
					if($et->task_progress <= 20) {
						$progress_class = 'progress-danger';
						$tag_class = 'tag-danger';
					} else if($et->task_progress > 20 && $et->task_progress <= 50){
						$progress_class = 'progress-warning';
						$tag_class = 'tag-warning';
					} else if($et->task_progress > 50 && $et->task_progress <= 75){
						$progress_class = 'progress-info';
						$tag_class = 'tag-info';
					} else {
						$progress_class = 'progress-success';
						$tag_class = 'tag-success';
					}
					 
					// project progress
					if($et->task_status == 0) {
						$status = $this->lang->line('xin_not_started');
					} else if($et->task_status ==1){
						$status = $this->lang->line('xin_in_progress');
					} else if($et->task_status ==2){
						$status = $this->lang->line('xin_completed');
					} else {
						$status = $this->lang->line('xin_deffered');
					}
					// task project
					$prj_task = $this->Project_model->read_project_information($et->project_id);
					if(!is_null($prj_task)){
						$prj_name = $prj_task[0]->title;
					} else {
						$prj_name = '--';
					}
					
					// tasks completed
					$c_task = $this->Exin_model->get_completed_tasks($et->task_id);
					$ct_tasks += $c_task;
					// tasks overdue
					$ov_task = $this->Exin_model->get_overdue_tasks($et->task_id);
					$ovt_tasks += $ov_task;
					// todo tasks
					$tod_task = $this->Exin_model->get_todo_tasks($et->task_id);
					$tot_tasks += $tod_task;
					?>
              <tr>
                <td><?php echo '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_view_details').'"><a href="'.site_url().'admin/timesheet/task_details/id/'.$et->task_id.'/"><button type="button" class="btn btn-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="fa fa-arrow-circle-right"></i></button></a></span>';?></td>
                <td class="text-truncate"><?php echo $et->task_name;?><br />
                  <a href="<?php echo site_url();?>admin/project/detail/<?php echo $et->project_id;?>/"><?php echo $prj_name;?></a></td>
                <td class="text-truncate"><i class="fa fa-calendar position-left"></i> <?php echo $tdate;?></td>
                <td class="text-truncate"><span class="tag tag-default <?php echo $tag_class;?>"><?php echo $status;?></span></td>
                <td class="text-truncate"><p class="m-b-0-5"><?php echo $this->lang->line('dashboard_completed');?> <span class="pull-xs-right"> <?php echo $et->task_progress;?>%</span></p>
                  <progress class="progress <?php echo $progress_class;?> progress-sm d-inline-block mb-0" value="<?php echo $et->task_progress;?>" max="100"><?php echo $et->task_progress;?>%</progress></td>
              </tr>
              <?php }
							} ?>
              <?php $i++; endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php //} ?>
  <?php } else {?>
  <div class="col-xl-4 col-lg-4">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_personal_details');?></h3>
      </div>
      <div class="box-body px-1">
        <div id="recent-buyers" class="list-group scrollable-container height-350 position-relative">
          <div class="table-responsive" data-pattern="priority-columns">
            <table width="" class="table table-striped m-md-b-0">
              <tbody>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_fullname');?></th>
                  <td><?php echo $first_name.' '.$last_name;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_employee_id');?></th>
                  <td><?php echo $employee_id;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_username');?></th>
                  <td><?php echo $username;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_email');?></th>
                  <td><?php echo $email;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_designation');?></th>
                  <td><?php echo $designation_name;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('left_department');?></th>
                  <td><?php echo $department_name;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_dob');?></th>
                  <td><?php echo $this->Xin_model->set_date_format($date_of_birth);?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-4">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_recruitment');?> <?php echo $this->lang->line('dashboard_timeline');?></h3>
      </div>
      <div class="box-body px-1">
        <div id="recent-buyers" class="list-group scrollable-container height-350 position-relative">
          <?php foreach($all_jobs as $job):?>
          <?php $jtype = $this->Job_post_model->read_job_type_information($job->job_type); ?>
          <?php
			if(!is_null($jtype)){
				$jt_type = $jtype[0]->type;
			} else {
				$jt_type = '--';	
			}
		  ?>
          <a href="<?php echo site_url('jobs/detail/').$job->job_url;?>" class="list-group-item list-group-item-action media no-border">
          <div class="media-body">
            <h6 class="list-group-item-heading"><?php echo $job->job_title;?> <span class="float-xs-right pt-1"><span class="tag tag-warning ml-1"><?php echo $jt_type;?></span></span></h6>
          </div>
          </a>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div> -->
<!--/ Stats --> 
<?php if(in_array('44',$role_resources_ids)) { ?>
<div style="margin-top: 15px;" class="row match-height">
  <?php if($system[0]->module_projects_tasks=='true'){?>
  <div class="col-xl-8 col-lg-8">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_my_projects');?></h3>
      </div>
      <div class="box-body">
        <div class="box-block">
          <p><?php echo $this->lang->line('xin_my_assigned_projects');?> <span class="float-xs-right"><a href="<?php echo site_url('admin/project');?>"><?php echo $this->lang->line('xin_more_projects');?> <i class="ft-arrow-right"></i></a></span></p>
        </div>
        <div class="table-responsive" style="height:250px;">
          <table id="recent-orderss" class="table table-hover mb-0 ps-container ps-theme-default">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('dashboard_xin_title');?></th>
                <th><?php echo $this->lang->line('xin_p_priority');?></th>
                <th><?php echo $this->lang->line('dashboard_project_date');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_progress');?></th>
              </tr>
            </thead>
            <tbody>
              <?php $project = $this->Project_model->get_projects();?>
              <?php $dId = array(); $i=1; foreach($project->result() as $pj):
			 // $aw_name = $hrm->e_award_type($emp_award->award_type_id);
			 $asd = array($pj->assigned_to);
			 $aim = explode(',',$pj->assigned_to);
			 foreach($aim as $dIds) {
				 if($session['user_id'] === $dIds) {
					$dId[] = $session['user_id'];
				// project date		
				$pdate = $this->Xin_model->set_date_format($pj->end_date);
				// project progress
				if($pj->project_progress <= 20) {
					$progress_class = 'progress-danger';
				} else if($pj->project_progress > 20 && $pj->project_progress <= 50){
					$progress_class = 'progress-warning';
				} else if($pj->project_progress > 50 && $pj->project_progress <= 75){
					$progress_class = 'progress-info';
				} else {
					$progress_class = 'progress-success';
				}
				 
				// project progress
				if($pj->status == 0) {
					$status = $this->lang->line('xin_not_started');
				} else if($pj->status ==1){
					$status = $this->lang->line('xin_in_progress');
				} else if($pj->status ==2){
					$status = $this->lang->line('xin_completed');
				} else {
					$status = $this->lang->line('xin_deffered');
				}
				// priority
				if($pj->priority == 1) {
					$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_highest').'</span>';
				} else if($pj->priority ==2){
					$priority = '<span class="tag tag-danger">'.$this->lang->line('xin_high').'</span>';
				} else if($pj->priority ==3){
					$priority = '<span class="tag tag-primary">'.$this->lang->line('xin_normal').'</span>';
				} else {
					$priority = '<span class="tag tag-success">'.$this->lang->line('xin_low').'</span>';
				}
				?>
              <tr>
                <td class="text-truncate"><a href="<?php echo site_url();?>admin/project/detail/<?php echo $pj->project_id;?>/"><?php echo $pj->title;?></a></td>
                <td class="text-truncate"><?php echo $priority;?></td>
                <td class="text-truncate"><i class="fa fa-calendar position-left"></i> <?php echo $pdate;?></td>
                <td class="text-truncate"><?php echo $status;?></td>
                <td class="text-truncate"><p class="m-b-0-5"><?php echo $this->lang->line('dashboard_completed');?> <span class="pull-xs-right"><?php echo $pj->project_progress;?>%</span></p>
                  <progress class="progress <?php echo $progress_class;?> progress-sm d-inline-block mb-0" value="<?php echo $pj->project_progress;?>" max="100"><?php echo $pj->project_progress;?>%</progress></td>
              </tr>
              <?php }
								} ?>
              <?php $i++; endforeach;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php //} else {?>
  <div class="col-xl-4 col-lg-4">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $this->lang->line('dashboard_recruitment');?> <?php echo $this->lang->line('dashboard_timeline');?></h3>
      </div>
      <div class="box-body px-1">
        <div id="recent-buyers" class="list-group scrollable-container height-300 position-relative">
          <?php foreach($all_jobs as $job):?>
          <?php $jtype = $this->Job_post_model->read_job_type_information($job->job_type); ?>
          <?php
			if(!is_null($jtype)){
				$jt_type = $jtype[0]->type;
			} else {
				$jt_type = '--';	
			}
		  ?>
          <a target="_blank" href="<?php echo site_url('jobs/detail/').$job->job_url;?>" class="list-group-item list-group-item-action media no-border">
          <div class="media-body">
            <h6 class="list-group-item-heading"><?php echo $job->job_title;?> <span class="float-xs-right pt-1"><span class="tag tag-warning ml-1"><?php echo $jt_type;?></span></span></h6>
          </div>
          </a>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<?php } ?>
<?php if($theme[0]->dashboard_calendar == 'true'):?>
<!-- <?php $this->load->view('admin/calendar/calendar_hr');?> -->
<?php endif; ?>
<style type="text/css">
.btn-group {
	margin-top:5px !important;
}
</style>

<script>
  function payslip(date,userid,s){

      // alert(csrf_token); return;
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();


     var salary_month = date;

      status = s;
      

      var sql = userid;

       var data = "salary_month="+salary_month+"&status="+status+'&sql='+sql+"&excel="+0;
  
      // console.log(data); return;

      url = base_url + "/payslip";
      
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
       
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1200,height=800');
          a.document.write(resp);
        }
      }
    }



</script>