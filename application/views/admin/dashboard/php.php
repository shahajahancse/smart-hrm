<?php 
$session = $this->session->userdata('username');
$get_animate = $this->Xin_model->get_content_animate();
$userid  = $session[ 'user_id' ];
$result = $this->db->order_by('id', 'desc')->get('lunch_payment', 1)->row();

$empdata = $this->db
    ->select('lunch_payment.*, xin_employees.first_name, xin_employees.last_name,
              xin_designations.designation_name')
    ->from('lunch_payment')
    ->join('xin_employees', 'lunch_payment.emp_id = xin_employees.user_id')
    ->join('xin_designations', 'xin_employees.designation_id = xin_designations.designation_id')
    ->where('lunch_payment.end_date', $result->end_date)
    ->where('lunch_payment.emp_id', $session['user_id'])
    ->order_by('lunch_payment.id', 'desc')
    ->get()
    ->result();

$data1 = isset($empdata[0]) ? $empdata[0] : 0;
$taken_meal = 0;

$this->load->model("Lunch_model");
$emp_data = $this->Lunch_model->get_data_date_wise($data1->end_date, $data1->next_date, $data1->emp_id);

foreach ($emp_data['emp_data'] as $r) {
    $taken_meal += $r->meal_amount;
}

$paymeal = isset($data1->pay_amount) ? $data1->pay_amount / 45 : 0;
$balanceMeal = $paymeal - $taken_meal;
    // get month january to current month
    $currentMonth = date('n');
$monthNames = array();
for ($i = 1; $i <= $currentMonth; $i++) {
    $monthNames[] = date('F', mktime(0, 0, 0, $i, 1));
}
// end

// get employee shift schedule information
$schedule = $this->db->get('xin_office_shift')->row();

// get employee salary from january to current month
$salarys = $this->db->select('salary_month,modify_salary,grand_net_salary')
                    ->where('employee_id', $userid)
                    ->get('xin_salary_payslips')
                    ->result();
$salary = array();
$salary_month = array();
foreach ($salarys as $salaryObj) {
    $salary[] = floor($salaryObj->grand_net_salary + $salaryObj->modify_salary);
    $salary_month[] = date('M', strtotime($salaryObj->salary_month));
}
// end
// dd($salary_month);
// punch time
$in_time = "00:00";
$out_time = "00:00";
$punch_time = $this->db->select('clock_in, clock_out')
                      ->where('employee_id', $userid)
                      ->where('attendance_date', date('Y-m-d'))
                      ->get('xin_attendance_time')
                      ->row();
// dd($punch_time);                      
if (!empty($punch_time)) {
    $in_time = date('h.i A', strtotime($punch_time->clock_in));
    $out_time = date('h.i A', strtotime($punch_time->clock_out));
}
// end punch time

//get employee name
$name = $this->db->select('first_name,last_name')
            ->where('user_id', $userid)
            ->get('xin_employees')
            ->row();
// dd($in_time);

// Get the current Unix timestamp
$currentTimestamp = time();

// Specify the other specific time
$inTime = strtotime($in_time);
$outTime = strtotime($out_time);
$out_Time = strtotime(date('h.i A', strtotime('6.30')));

// dd($outTime);

// Calculate the time difference in seconds
$workingHour = $currentTimestamp - $inTime;
$over_time   = $outTime - $out_Time;
// dd($over_time);

$hours = floor($workingHour / 3600);
$minutes = floor(($workingHour % 3600) / 60);


$hourss = floor($over_time / 3600);
$minutess = floor(($over_time % 3600) / 60);
// $seconds = $workingHour % 60;

// Output the time difference
$total_working_hour = $hours . "." . $minutes;
$total_over_time_hour = $hourss . "." . $minutess;
$first_date = date('Y-m-01');
$second_date = date('Y-m-d');

$count_p = $this->db->select('COUNT(status) AS count_p')
                ->where('employee_id', $userid)
                ->where('status', 'present')
                ->where("attendance_date BETWEEN '".$first_date."' AND '".$second_date."'")
                ->get('xin_attendance_time')
                ->row()->count_p;
$count_a = $this->db->select('COUNT(status) AS count_a')
          ->where('employee_id', $userid)
          ->where('status', 'absent')
          ->where("attendance_date BETWEEN '".$first_date."' AND '".$second_date."'")
          ->get('xin_attendance_time')
          ->row()->count_a;
$count_late = $this->db->select('COUNT(status) AS count_late')
          ->where('employee_id', $userid)
          ->where('late_status', '1')
          ->where("attendance_date BETWEEN '".$first_date."' AND '".$second_date."'")
          ->get('xin_attendance_time')
          ->row()->count_late;


$holidays= $this->db->select('*')->get('xin_holidays')->result();
$holidayss= $this->db->select('*')->limit(5)->where("start_date > '".date('Y-m-d')."'")->get('xin_holidays')->result();
// dd($this->db->last_query());
$leave_calel=get_cal_leave($userid, 1);
$leave_calsl=get_cal_leave($userid, 2);
$totaluseleave=$leave_calel+$leave_calsl;
$all_notice = $this->db->select('*')->get('xin_events')->result();

$leavemonth=$this->Salary_model->leave_count_status($userid,date('Y-m-01'),date('Y-m-t'), 2);
$totalleavem=$leavemonth->el+$leavemonth->sl;

?>