<?php
$session = $this->session->userdata('username');
$user = $this->Xin_model->read_employee_info($session['user_id']);

$this->load->model('Timesheet_model');
$date=date('Y-m-d');
$present=$this->Timesheet_model->get_today_present(0,'Present',$date);
// Present end
// absent
$absent=$this->Timesheet_model->get_today_present(0,'Absent',$date);
// absent end

// late
$late=$this->Timesheet_model->get_today_present(1,'Present',$date);
// late end

// Leave
$leave=$this->Timesheet_model->get_today_leave($date);
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

:root {
    --light: #f6f6f9;
    --primary: #1976D2;
    --light-primary: #CFE8FF;
    --grey: #eee;
    --dark-grey: #AAAAAA;
    --dark: #363949;
    --danger: #D32F2F;
    --light-danger: #FECDD3;
    --warning: #FBC02D;
    --light-warning: #FFF2C6;
    --success: #388E3C;
    --light-success: #BBF7D0;
}

.d_card {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    margin: 9px 0px;
}

.c_card {
    border-radius: 10px;
    padding: 5px;
    display: flex;
    margin: 9px 0px;
    cursor: pointer;
    background: linear-gradient(156deg, transparent, transparent);
    box-shadow: 0px 0px 2px 2px #8f8f8f;
    flex-direction: column;
}

.c_card:hover {
    box-shadow: 0px 0px 35px 4px #8f8f8f
}

.c_cardn {
    border-radius: 10px;
    padding: 5px;
    display: flex;
    margin: 9px 0px;
    cursor: pointer;
    background: linear-gradient(156deg, transparent, transparent);
    box-shadow: 0px 0px 2px 2px #8f8f8f;
    flex-direction: column;
}

.c_cardn:hover {
    box-shadow: 0px 0px 35px 4px #8f8f8f
}

#floatingDiv {
    height: 247px;
    width: 200px;
    background-image: linear-gradient(141deg, #cdd0ff, #a9f1c3);
    border-radius: 10px;
    padding: 10px;
    z-index: 999;
    overflow-y: scroll;
}

.fli {
    list-style: none;
    border: 1px solid;
    width: 174px;
    padding: 6px;
    border-radius: 8px;
    margin-bottom: 4px;
}

#floatingDiv::-webkit-scrollbar {
    display: none;

}
</style>


<div style="display: none">
    <div id="all_employee_list">
        <?php
           if (!empty($present)) {

        foreach($present as $all_employee){
            echo '<li class="fli">'.$all_employee->first_name.' '.$all_employee->last_name.'<br> <span class="badge badge-success" >Present</span></li>';
        }
    }
       ?>
        <?php
        if (!empty($absent)) {
        foreach($absent as $all_employee){
            echo '<li class="fli">'.$all_employee->first_name.' '.$all_employee->last_name.' <br> <span class="badge badge-danger" >Absent</span></li>';
        }
    }
       ?>
        <?php
      if (!empty($leave)) {
          foreach($leave as $all_employee){
              echo '<li class="fli">'.$all_employee->first_name.' '.$all_employee->last_name.'<br> <span class="badge badge-danger">Leave</span></li>';
          }
      }
      ?>
    </div>
    <div id="all_present_list">
        <?php
        if (!empty($present)) {

            foreach($present as $all_employee){
                echo '<li class="fli">'.$all_employee->first_name.' '.$all_employee->last_name.'<br> <span class="badge badge-success" >Present</span></li>';
            }
        }
       ?>
    </div>
    <div id="all_absent_list">
        <?php
         if (!empty($absent)) {
            foreach($absent as $all_employee){
                echo '<li class="fli">'.$all_employee->first_name.' '.$all_employee->last_name.' <br> <span class="badge badge-danger" >Absent</span></li>';
            }
        }
       ?>
    </div>
    <div id="all_leave_list">
        <?php
             if (!empty($leave)) {

        foreach($leave as $all_employee){
            echo '<li class="fli">'.$all_employee->first_name.' '.$all_employee->last_name.' <br> <span class="badge badge-danger" >Leave</span></li>';
        }
    }
       ?>
    </div>
    <div id="all_late_list">
        <?php
        if (!empty($late)) {
            foreach($late as $all_employee){
                echo '<li class="fli">'.$all_employee->first_name.' '.$all_employee->last_name.' <br> <span class="badge badge-danger" >Late</span></li>';
            }
        }
       ?>
    </div>

</div>





<div class="row">
    <div class='col-md-12'>
        <h2><?php echo $this->lang->line('dashboard_title'); ?></h2>
        <h4 class="widget-user-username welcome-hrsale-user">
            <?php echo $this->lang->line('xin_title_wcb'); ?>,
            <span style="color: #1976D2"><?php echo $user[0]->first_name . ' ' . $user[0]->last_name; ?>!</span>
        </h4>
    </div>
    <div class='col-md-12 row'>
        <div class="col-md-6">
            <div class="d_card" style="background-image: linear-gradient(114deg, #85d2ff, #dbede9);">
                <h4>Today <?=date('l, j F Y')?></h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_card" id="all-employees">
                            <h5>All Employees</h5>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6">0</h3>
                                <i class="fa fa-user col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="c_card" id="present">
                            <h5>Present</h5>
                            <div class="col-md-12">
                                <h3 class="count-present col-md-6">0</h3>
                                <i class="fa fa-laptop col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_card" id="absent">
                            <h5>Absent</h5>
                            <div class="col-md-12">
                                <h3 class="count-absent col-md-6">0</h3>
                                <i class="fa fa-home col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="c_card" id="late">
                            <h5>Late</h5>
                            <div class="col-md-12">
                                <h3 class="count-late col-md-6">0</h3>
                                <i class="fa fa-clock-o col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"
                                    class=" col-md-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d_card" style="background-image: linear-gradient(114deg, #85d2ff, #dbede9);">
                <h4>This Month, <?=date('F Y')?></h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_cardn" onclick="window.location.href = '<?php echo site_url('admin/timesheet/leave')?>';">
                            <h5>Total Leave</h5>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6"><?php
                                $first_date=date('Y-m-01');
                                $last_date=date('Y-m-t');
                                $this->load->model('Timesheet_model');
                                $t_leave=$this->Timesheet_model->get_leaves_with_info_with_date($first_date, $last_date, $status=null) ;
                               echo count($t_leave);
                               ?></h3>
                                <i class="fa fa-user col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="c_cardn">
                            <h5>Extra Present</h5>
                            <div class="col-md-12">
                                <h3 class="count-present col-md-6">
                                    <?php
                                    $t_extra=$this->Timesheet_model->extra_present_approval($first_date, $last_date);
                                    echo count($t_extra);
                                    ?>
                                </h3>
                                <i class="fa fa-laptop col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_cardn">
                            <h5>Increment</h5>
                            <div class="col-md-12">
                                <h3 class="count-absent col-md-6"><?php
                                $upcoming_increment=$this->Timesheet_model->upcomming_intrn_prob_promo($first_date,$last_date,1);
                                echo count($upcoming_increment);
                                ?></h3>
                                <i class="fa fa-home col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="c_cardn" id="late">
                            <h5>New Join</h5>
                            <div class="col-md-12">
                                <h3 class="count-late col-md-6"><?php echo count($this->db->where('date_of_joining BETWEEN "'.$first_date.'" AND "'.$last_date.'"')->get('xin_employees')->result()); ?></h3>
                                <i class="fa fa-clock-o col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"
                                    class=" col-md-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row col-md-12">
        <div class="col-md-6">
            <div class="box d_card"  style="background-image: linear-gradient(114deg, #85d2ff, #dbede9);">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $this->lang->line('xin_employee_department_txt'); ?>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="box-block">
                        <div class="col-md-7">
                            <div class="overflow-scrolls" style="overflow:auto; height:200px;">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-dashboard">
                                        <tbody>
                                            <?php $c_color = array('#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC', '#00A5A8', '#FF4558', '#16D39A', '#8A2BE2', '#D2691E', '#6495ED', '#DC143C', '#006400', '#556B2F', '#9932CC'); ?>
                                            <?php $j = 0;
                    foreach ($this->Department_model->all_departments() as $department) { ?>
                                            <?php
                      $condition = "department_id =" . "'" . $department->department_id . "'";
                      $this->db->select('*');
                      $this->db->from('xin_employees');
                      $this->db->where($condition);
                      $query = $this->db->get();
                      // check if department available
                      if ($query->num_rows() > 0) {
                    ?>
                                            <tr>
                                                <td>
                                                    <div
                                                        style="width:4px;border:5px solid <?php echo $c_color[$j]; ?>;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars_decode($department->department_name); ?>
                                                    (
                                                    <?php echo $query->num_rows(); ?>)
                                                </td>
                                            </tr>
                                            <?php $j++;
                      } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <canvas id="employee_department" height="200" width=""
                                style="display: block;  height: 200px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box d_card"  style="background-image: linear-gradient(114deg, #85d2ff, #dbede9);">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php echo $this->lang->line('xin_employee_designation_txt'); ?>
                    </h3>
                </div>
                <div class="box-body">
                    <div class="box-block">
                        <div class="col-md-7">
                            <div class="overflow-scrolls" style="overflow:auto; height:200px;">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-dashboard">
                                        <tbody>
                                            <?php $c_color2 = array('#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED', '#9932CC', '#556B2F', '#16D39A', '#DC143C', '#D2691E', '#8A2BE2', '#FF976A', '#FF4558', '#00A5A8', '#6495ED'); ?>
                                            <?php $k = 0;
                    foreach ($this->Designation_model->all_designations() as $designation) { ?>
                                            <?php
                      $condition1 = "designation_id =" . "'" . $designation->designation_id . "'";
                      $this->db->select('*');
                      $this->db->from('xin_employees');
                      $this->db->where($condition1);
                      $query1 = $this->db->get();
                      // check if department available
                      if ($query1->num_rows() > 0) {
                    ?>
                                            <tr>
                                                <td>
                                                    <div
                                                        style="width:4px;border:5px solid <?php echo $c_color2[$k]; ?>;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars_decode($designation->designation_name); ?>
                                                    (
                                                    <?php echo $query1->num_rows(); ?>)
                                                </td>
                                            </tr>
                                            <?php $k++;
                      } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <canvas id="employee_designation" height="200" width=""
                                style="display: block; height: 200px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt--2 col-md-12">
        <div class="col-md-12">
            <div class="card full-height d_card"  style="background-image: linear-gradient(114deg, #85d2ff, #dbede9);">
                <div class="card-body">
                    <div class="card-title">
                        <?php echo $this->lang->line('xin_hrsale_paid_salaries_account_balances'); ?>
                    </div>
                    <?php $exp_am = $this->Expense_model->get_total_expenses(); ?>
                    <?php $all_sal = total_salaries_paid(); ?>
                    <div class="row py-3">
                        <div class="col-md-3 d-flex flex-column justify-content-around">
                            <h6 class="fw-bold text-uppercase text-success op-8">
                                <?php echo $this->lang->line('dashboard_total_expenses'); ?>
                            </h6>
                            <h3 class="fw-bold">
                                <?php echo $this->Xin_model->currency_sign($exp_am[0]->exp_amount); ?>
                            </h3>
                        </div>
                        <div class="col-md-3 d-flex flex-column justify-content-around">
                            <h6 class="fw-bold text-uppercase text-danger op-8">
                                <?php echo $this->lang->line('dashboard_total_salaries'); ?>
                            </h6>
                            <h3 class="fw-bold">
                                <?php echo $this->Xin_model->currency_sign($all_sal); ?>
                            </h3>
                        </div>
                        <div class="col-md-3 d-flex flex-column justify-content-around">
                            <h6 class="fw-bold text-uppercase text-info op-8">
                                <?php echo $this->lang->line('xin_acc_account_balances'); ?>
                            </h6>
                            <h3 class="fw-bold">
                                <?php echo $this->Xin_model->currency_sign(total_account_balances()); ?>
                            </h3>
                        </div>
                        <div class="col-md-3 d-flex flex-column justify-content-around">
                            <h6 class="fw-bold text-uppercase text-warning op-8">
                                <?php echo $this->lang->line('xin_hrsale_travel_expenses'); ?>
                            </h6>
                            <h3 class="fw-bold">
                                <?php echo $this->Xin_model->currency_sign(total_travel_expense()); ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    animateCount('.count-all-employees', <?php echo count($present)+count($absent)+count($leave) ?>);
    animateCount('.count-present', <?php echo count($present) ?>);
    animateCount('.count-absent', <?php echo count($absent) ?>);
    animateCount('.count-late', <?php echo count($late) ?>);
});

function animateCount(selector, targetValue) {
    const countElement = document.querySelector(selector);
    countElement.textContent = 0;

    let startTimestamp;

    function animate(timestamp) {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = timestamp - startTimestamp;

        const increment = Math.ceil(targetValue / (animationDuration / 16));
        const currentValue = Math.min(Math.ceil(progress * increment), targetValue);

        countElement.textContent = currentValue.toLocaleString(); // Format the number

        if (progress < animationDuration) {
            requestAnimationFrame(animate);
        }
    }

    const animationDuration = 1000;
    requestAnimationFrame(animate);
}
</script>
<script>
$(document).ready(function() {
    $('.c_card').hover(function() {
        var $this = $(this);
        // setTimeout(function() {
        $('#floatingDiv').remove();
        $('<div id="floatingDiv"></div>').css({
            position: 'absolute',
            top: $this.offset().top / 10,
            left: $this.offset().left / 3,
            backgroundColor: 'lightgray'
        }).appendTo($this);
        get_data($this);
        //},300); // 1000 milliseconds = 1 second
    }, function() {
        $('#floatingDiv').remove();
    });
});

function get_data($element) {
    var who = $element.attr('id');
    if (who === 'all-employees') {
        // Copy the content of 'all_employee_list'
        var allEmployeeListContent = $('#all_employee_list').html();

        // Append the content to 'floatingDiv'
        $('#floatingDiv').empty();
        $('#floatingDiv').append(allEmployeeListContent);
    }
    if (who === 'present') {
        // Copy the content of 'all_employee_list'
        var allEmployeeListContent = $('#all_present_list').html();
        $('#floatingDiv').empty();
        $('#floatingDiv').append(allEmployeeListContent);
    }
    if (who === 'absent') {
        // Copy the content of 'all_employee_list'
        var allEmployeeListContent = $('#all_absent_list').html();
        $('#floatingDiv').empty();
        $('#floatingDiv').append(allEmployeeListContent);
    }
    if (who === 'leave') {
        // Copy the content of 'all_employee_list'
        var allEmployeeListContent = $('#all_leave_list').html();
        $('#floatingDiv').empty();
        $('#floatingDiv').append(allEmployeeListContent);
    }
    if (who === 'late') {
        // Copy the content of 'all_employee_list'
        var allEmployeeListContent = $('#all_late_list').html();
        $('#floatingDiv').empty();
        $('#floatingDiv').append(allEmployeeListContent);
    }
}
</script>