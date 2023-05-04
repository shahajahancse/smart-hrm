


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">

  
  <?php
$month_year=$first_date;

$date = strtotime(date("Y-m-d"));

$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);


// total days in month
$daysInMonth = cal_days_in_month(0, $month, $year);
$imonth = date('F', $date);
?>
<?php


$filename = "Salary_$month_year.xls";
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
?>


<table width="900"width="900" align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">
<tr width="900" align="center" style="height:150px;">
    <td colspan="39" style="text-align:center;">
        <div style="font-size:35px; font-weight:bold; text-align:center;margin-top:3px"><?php echo xin_company_info(1)->company_name; ?></div>
        <div style="font-size:25px; font-weight:bold; text-align:center;"><?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
        
        <div style="font-size:20px; font-weight:bold; text-align:center;margin-bottom:3px">Attendenc Month : <?php echo $month_year; ?></div>
        <div style="font-size:12px; color:red; font-weight:bold; text-align:left;"> A: Absent, P: Present, H: Holiday, L: Leave, W=Weekend</div>
    </td>
</tr>



	
		<tr  style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px;">
            <th style="background-color: #4CAF50;color: white;"><?php echo $this->lang->line('xin_employee');?></th>
            <th style="background-color: #4CAF50;color: white;">Designation</th>
            <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
            <?php $i = str_pad($i, 2, 0, STR_PAD_LEFT); ?>
            <?php
						$tdate = $year.'-'.$month.'-'.$i;
						//Convert the date string into a unix timestamp.
						$unixTimestamp = strtotime($tdate);
						//Get the day of the week
						?>
            <th  style="background-color: #4CAF50;color: white;"><?php echo '<div>'.$i.' </div>';?></th>
            <?php endfor; ?>
            <th style="background-color: #d5b2b2; color: black;">P</th>
            <th style="background-color: #d5b2b2; color: black;">A</th>
            <th style="background-color: #d5b2b2; color: black;">W</th>
            <th style="background-color: #d5b2b2; color: black;">H</th>
            <th style="background-color: #d5b2b2; color: black;" >L</th>
            <th style="background-color: #d5b2b2; color: black;">T.D</th>
            
          </tr>
		  <?php $j=0;foreach($xin_employees as $r):?>
          <?php 
           $holiday=0;
           $weekend=0;
           $leave=0;
           $absent=0;
           $present=0;
           $totalday=0;
          	$full_name = $r->first_name.' '.$r->last_name;
						// get designation
						$designation = $this->Designation_model->read_designation_information($r->designation_id);
						if(!is_null($designation)){
							$designation_name = $designation[0]->designation_name;
						} else {
							$designation_name = '--';	
						}
						// department
						$department = $this->Department_model->read_department_information($r->department_id);
						if(!is_null($department)){
						$department_name = $department[0]->department_name;
						} else {
						$department_name = '--';	
						}
						$department_designation = $designation_name.' ('.$department_name.')';$pcount=0;
					?>
          <?php $employee_name = $full_name;
          ?>
          <tr>
            <td><?php echo $employee_name;?></td>
            <td><?php echo $designation_name;?></td>
            
            <?php for($i = 1; $i <= $daysInMonth; $i++):
							$i = str_pad($i, 2, 0, STR_PAD_LEFT);
							// get date <
							$attendance_date = $year.'-'.$month.'-'.$i;
							$get_day = strtotime($attendance_date);
							$day = date('l', $get_day);
							$user_id = $r->user_id;
							// office shift
							$office_shift = $this->Timesheet_model->read_office_shift_information($r->office_shift_id);
							// get holiday
							$h_date_chck = $this->Timesheet_model->holiday_date_check($attendance_date);
							$holiday_arr = array();
							if($h_date_chck->num_rows() == 1){
								$h_date = $this->Timesheet_model->holiday_date($attendance_date);
								$begin = new DateTime( $h_date[0]->start_date );
								$end = new DateTime( $h_date[0]->end_date);
								$end = $end->modify( '+1 day' ); 
								
								$interval = new DateInterval('P1D');
								$daterange = new DatePeriod($begin, $interval ,$end);
								
								foreach($daterange as $date){
									$holiday_arr[] =  $date->format("Y-m-d");
								}
							} else {
								$holiday_arr[] = '99-99-99';
							}
							//echo '<pre>'; print_r($holiday_arr);
							// get leave/employee
							$leave_date_chck = $this->Timesheet_model->leave_date_check($r->user_id,$attendance_date);
							$leave_arr = array();
							if($leave_date_chck->num_rows() == 1){
								$leave_date = $this->Timesheet_model->leave_date($r->user_id,$attendance_date);
								$begin1 = new DateTime( $leave_date[0]->from_date );
								$end1 = new DateTime( $leave_date[0]->to_date);
								$end1 = $end1->modify( '+1 day' ); 
								
								$interval1 = new DateInterval('P1D');
								$daterange1 = new DatePeriod($begin1, $interval1 ,$end1);
								
								foreach($daterange1 as $date1){
									$leave_arr[] =  $date1->format("Y-m-d");
								}	
							} else {
								$leave_arr[] = '99-99-99';
							}
							$attendance_status = '';
                            // $holiday=0;
                            // $weekend=0;
                            // $leave=0;
                            // $absent=0;
							$check = $this->Timesheet_model->attendance_first_in_check($r->user_id,$attendance_date);
							if($office_shift[0]->monday_in_time == '' && $day == 'Monday') {
								$status = 'H';
                                $holiday++;

							} else if($office_shift[0]->tuesday_in_time == '' && $day == 'Tuesday') {
								$status = 'H';
                                $holiday++;
							} else if($office_shift[0]->wednesday_in_time == '' && $day == 'Wednesday') {
								$status = 'H';
                                $holiday++;
							} else if($office_shift[0]->thursday_in_time == '' && $day == 'Thursday') {
								$status = 'H';
                                $holiday++;
							} else if($office_shift[0]->friday_in_time == '' && $day == 'Friday') {
								$status = 'W';
                                $weekend++;
							} else if($office_shift[0]->saturday_in_time == '' && $day == 'Saturday') {
								$status = 'W';
                                $weekend++;
							} else if($office_shift[0]->sunday_in_time == '' && $day == 'Sunday') {
								$status = 'H';
                                $holiday++;
							} else if(in_array($attendance_date,$holiday_arr)) { // holiday
								$status = 'H';
                                $holiday++;
							} else if(in_array($attendance_date,$leave_arr)) { // on leave
								$status = 'L';
                                $leave++;
							} else if($check->num_rows() > 0){
							$attendance = $this->Timesheet_model->attendance_first_in($r->user_id,$attendance_date);
							$status = 'P';//$attendance[0]->attendance_status;
                            $present++;
								
							} else {
								
								 
								$status = 'A';
                                $absent++;
								//$pcount += 0;
							}
                            
							$pcount += $check->num_rows();
							// set to present date
							$iattendance_date = strtotime($attendance_date);
							$icurrent_date = strtotime(date('Y-m-d'));
							if($iattendance_date <= $icurrent_date){
								$status = $status;
							} else {
								$status = '';
							}
							$idate_of_joining = strtotime($r->date_of_joining);
							if($idate_of_joining < $iattendance_date){
								$status = $status;
							} else {
								$status = '-';
							}
						?>
            <td><?php echo $status; ?></td>
            <?php endfor; ?>
            <?php $totalday=$present+$absent+$weekend+$holiday+$leave+$totalday;
             ?>
            <td style="background-color: #d5b2b2; color: black;"><?php echo $present;?></td>
            <td style="background-color: #d5b2b2; color: black;"><?php echo $absent;?></td>
            <td style="background-color: #d5b2b2; color: black;"><?php echo $weekend;?></td>
            <td style="background-color: #d5b2b2; color: black;"><?php echo $holiday;?></td>
            <td style="background-color: #d5b2b2; color: black;"><?php echo $leave;?></td>
            <td style="background-color: #d5b2b2; color: black;"><?php echo $totalday;?></td>

          </tr>
          <?php endforeach;?>




	</table>

</body>
</html>