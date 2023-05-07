<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
        table{
            border: 2px black solid;
    border-collapse: collapse;
    width: -webkit-fill-available;
}
th{
    border: 2px black solid;
    border-collapse: collapse;
    font-size: 20px;


}

td {
    border: 2px black solid;
    border-collapse: collapse;
    font-size: 15px;
    text-align: center;



}
.tdb{
    background-color: cadetblue;

}
</style>
    <!-- Bootstrap CSS -->
  </head>
  <body>



  
<?php
$month_year=$first_date;

$date = strtotime(date("Y-m-d"));

$imonth_year = explode('-',$month_year);
		$day = date('d', $date);
		$month = date($imonth_year[1], $date);
		$year = date($imonth_year[0], $date);

/* Set the date */
// $date = strtotime(date("Y-m-d"));
// get month and year



    // $day = date('d', $date);
    // $month = date('m', $date);
    // $year = date('Y', $date);

    // $emp_id = [2, 9, 10];

    // $xin_employees= $this->Attendance_model->get_employee($emp_id);


    // $xin_employees = $this->Timesheet_model->get_xin_employees();
    // dd($xin_employees);

    // $xin_employees = $this->Xin_model->read_user_info(2);


// total days in month
$daysInMonth = cal_days_in_month(0, $month, $year);
$imonth = date('F', $date);
?>




  <div class="box-header with-border">
  <div class="box-header with-border">
    <div style="
    text-align: center;
">
    <h3 class="box-title">Monthly Report</h3>
    <h5>For the month of
      <?php if(isset($month_year)): echo date('F Y', strtotime($month_year)); else: echo date('F Y'); endif;?>
    </h5>
    </div>
    <div class="box-tools pull-right"> A: Absent, P: Present, H: Holiday, L: Leave, W=Weekend</div>
 



  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr class="tdb">
            <th class="mastering"><?php echo $this->lang->line('xin_employee');?></th>
            <th class="mastering">Designation</th>
            <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
            <?php $i = str_pad($i, 2, 0, STR_PAD_LEFT); ?>
            <?php
						$tdate = $year.'-'.$month.'-'.$i;
						//Convert the date string into a unix timestamp.
						$unixTimestamp = strtotime($tdate);
						//Get the day of the week
						?>
            <th><strong><?php echo '<div>'.$i.' </div>';?></strong></th>
            <?php endfor; ?>
            <th width="100px">P</th>
            <th width="100px">A</th>
            <th width="100px">W</th>
            <th width="100px">H</th>
            <th width="100px">L</th>
            <th width="100px">T.D</th>
            
          </tr>
        </thead>
        <tbody>
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
								$status = '';
							}
						?>
            <td><?php echo $status; ?></td>
            <?php endfor; ?>
            <?php $totalday=$present+$absent+$weekend+$holiday+$leave+$totalday;
             ?>
            <td><?php echo $present;?></td>
            <td><?php echo $absent;?></td>
            <td><?php echo $weekend;?></td>
            <td><?php echo $holiday;?></td>
            <td><?php echo $leave;?></td>
            <td><?php echo $totalday;?></td>

          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<style type="text/css">
	.box-tools {
	    margin-right: -5px !important;
	}
	.col-md-8 {
		padding-left:0px !important;
		padding-right: 0px !important;
	}
	.dataTables_length {
		float:left;
	}
	.dt-buttons {
	    position: relative;
	    float: right;
	    margin-left: 10px;
	}
	.hide-calendar .ui-datepicker-calendar { display:none !important; }
	.hide-calendar .ui-priority-secondary { display:none !important; }
</style>

  <script>

		function printDiv()
		{
			var ajaxRequest;  // The variable that makes Ajax possible!
	    ajaxRequest = new XMLHttpRequest();
			
		  url = "<?php echo base_url() ?>admin/timesheet/monthly_attn_sheet_print";
		  ajaxRequest.open("GET", url, true);
		  ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
		  ajaxRequest.send();
				// alert(url); return;

			ajaxRequest.onreadystatechange = function(){
				if(ajaxRequest.readyState == 4){
					// console.log(ajaxRequest.responseText); return;
					var resp = ajaxRequest.responseText;
		      var a = window.open('', '', 'height=500, width=1400');
		      // a.document.write('<html><body>');
		      a.document.write(resp);
		      // a.document.write('</body></html>');
		      a.print();
		      a.close();	
				}
			}
		}



		function jobCard()
		{
			var ajaxRequest;  // The variable that makes Ajax possible!
		  ajaxRequest = new XMLHttpRequest();

		  var month_year = document.getElementById('d_month_year').value;
			var company = document.getElementById('aj_company').value
			var employee_id = document.getElementById('employee_id').value;
			// var csrf_hrsale = document.querySelector('[name="csrf_hrsale"]').value;
			// console.log(csrf_hrsale); return

			if(month_year =='')	{
				alert('Please select date');
				return ;
			}
			if(company =='Select' || company == '')
			{
				alert("Please select Company option");
				return;
			}
			
			var queryString="month_year="+month_year+"&company="+company+"&employee_id="+employee_id;

		  url = "<?php echo base_url() ?>admin/timesheet/job_card/"+month_year+"/"+company+"/"+employee_id;
		  ajaxRequest.open("GET", url, true);
		  ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
		   ajaxRequest.send();
				// alert(url); return;

			ajaxRequest.onreadystatechange = function(){
				if(ajaxRequest.readyState == 4){
					// console.log(ajaxRequest.responseText); return;
					var resp = ajaxRequest.responseText;
					a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
					a.document.write(resp);
					// a.close();
				}
			}
		}

  </script>



      




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>