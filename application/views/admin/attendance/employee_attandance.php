<?php
 $userid  = $session[ 'user_id' ];
  $datep        = date( "Y-m-d");
  $date        = date( "Y-m-01");
  $present_stutas  = $this->Salary_model->count_attendance_status_wise($userid, $date , $datep);
  $leave_stutas  = $this->Salary_model->leave_count_status($userid, $date , $datep, 2);
//   dd($present_stutas);
//   stdClass Object
// (
//     [attend] => 6
//     [absent] => 0
//     [weekend] => 2
//     [holiday] => 3
//     [HalfDay] => 0.0
//     [extra_p] => 0
//     [late_status] => 0
// )
// dd($leave_stutas)
$this->db->select("*");
$this->db->where("employee_id", $userid);
$this->db->order_by("time_attendance_id", "desc");
$this->db->limit(20); // Replace 10 with the desired limit
$alldata = $this->db->get('xin_attendance_time')->result();


?>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/emp_attandenc.css') ?>">


<div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="heading">Active Days</div>
        <div class="heading2"><?= $present_stutas->attend ?></div>
    </div>
    
    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="heading">Late Days</div>
        <div class="heading2"><?= $present_stutas->late_status  ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
        <div class="heading">Absent</div>
        <div class="heading2"><?=  $present_stutas->absent ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
        <div class="heading">Taking Leave</div>
        <div class="heading2"><?=$leave_stutas->el+$leave_stutas->sl?></div>
    </div>
</div>

<div class="col-md-12 medelbar">
    <div class="col-md-3 divform-group">
        <div class="input">
            <div class="level">Select Date</div>
            <div class="pseudo6">
                <input style="width: 98%;border: none;cursor: pointer;" type="date" name="" value="<?= date('Y-m-d') ?>"
                    id="">
            </div>
        </div>

    </div>
    <div class="col-md-3 divform-group">
        <div class="input">
            <div class="level">Select Month</div>
            <div class="pseudo6">
                <input style="width: 98%;border: none;cursor: pointer;" type="month" value="<?= date('Y-m') ?>" name=""
                    id="">
            </div>
        </div>

    </div>
    <div class="col-md-3 divform-group">
        <div class="input">
            <?php $years = range(1900, strftime("%Y", time())); ?>

            <div class="level">Select Year</div>
            <div class="pseudo6">
                <select style="width: 98%;border: none;cursor: pointer;">
                    <option>Select Year</option>
                    <?php foreach($years as $year) : ?>
                    <option <?= ($year=date('Y'))?'selected':'' ?> value="<?php echo $year; ?>"><?php echo $year; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

    </div>
    <div class="col-md-3 divform-group">
        <a>
            <div class="input serceb">
                Search
            </div>
        </a>

    </div>
</div>
<table class="table table-striped" style="border-top: 1px solid #d6d2d2;">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Date</th>
            <th>Punch In</th>
            <th>Punch Out</th>
            <th>Late</th>
            <th>Production</th>
            <th>Break</th>
        </tr>
    </thead>
    <tbody>
        <?php  foreach($alldata as $key=>$data){ ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= $data->attendance_date ?></td>
            <td><?= ($data->clock_in=='')?'--:--:--':date('h:s A',strtotime($data->clock_in)) ?></td>
            <td><?= ($data->clock_out=='')?'--:--:--':date('h:s A',strtotime($data->clock_out)) ?></td>
            <td><?= $data->late_time ?></td>
            <td><?= $data->production ?></td>
            <td><?= 1?> hrs</td>
        </tr>
        <?php  }?>
    </tbody>
</table>