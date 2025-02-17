<?php
 $userid  = $session[ 'user_id' ];
  $datep        = date( "Y-m-d");
  $date        = date( "Y-m-01");
  $present_stutas  = $this->Salary_model->count_attendance_status_wise($userid, $date , $datep);
  $leave_stutas  = $this->Salary_model->leave_count_status($userid, $date , $datep, 2);

?>
<style>
body {
    font-family: 'Fira Mono', monospace;
}

.list-group>li:nth-child(5n+1) {
    border-top: 1px solid rgba(0, 0, 0, .125);
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
}

.modal-dialog {
    width: 600px;
    margin: 95px auto;
}

.list-group>li:nth-child(5n+0) {
    border-bottom-left-radius: .25rem;
    border-bottom-right-radius: .25rem;
}

.pagination-container {
    justify-content: right !important;
    display: flex !important;
}
</style>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/emp_attandenc.css') ?>">

<div class="modal fade" id="jobcardinput" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Job Card Form</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Start Date</label>
                        <input type="Date" class="form-control" id="emp_j_from_date">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">To Date</label>
                        <input type="Date" class="form-control" id="emp_j_to_date">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="get_job_card()" class="btn btn-primary">Get</button>

            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="punch_request" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Job Card Form</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Type</label>
                        <select  id="punch_type" class="form-control select2">
                            <option value="in">Punch In</option>
                            <option value="out">Punch Out</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Date</label>
                        <input type="date"  max="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" class="form-control" id="p_date">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Time</label>
                        <input type="time" class="form-control" id="p_time">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" onclick="punch_request()" data-dismiss="modal" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </div>
</div>




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
                <input onchange=getdata(this) style="width: 98%;border: none;cursor: pointer;" type="date" name=""
                    value="<?= date('Y-m-d') ?>" id="datef">
            </div>
        </div>

    </div>
    <div class="col-md-3 divform-group">
        <div class="input">
            <div class="level">Select Month</div>
            <div class="pseudo6">
                <input onchange=getdata(this) id="month" style="width: 98%;border: none;cursor: pointer;" type="month"
                    value="<?= date('Y-m') ?>" name="" id="">
            </div>
        </div>

    </div>
    <div class="col-md-2 divform-group">
        <div class="input">
            <?php $years = range(1900, strftime("%Y", time())); ?>

            <div class="level">Select Year</div>
            <div class="pseudo6">
                <select onchange=getdata(this) id="year" style="width: 98%;border: none;cursor: pointer;">
                    <option>Select Year</option>
                    <?php foreach($years as $year) : ?>
                    <option <?= ($year==date('Y'))?'selected':'' ?> value="<?php echo $year; ?>"><?php echo $year; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

    </div>
    <div class="col-md-2 divform-group">
        <a data-toggle="modal" data-target="#jobcardinput">
            <div class="input serceb">
                Get Job Card
            </div>
        </a>
    </div>
    <div class="col-md-2 divform-group">
        <a data-toggle="modal" data-target="#punch_request">
            <div class="input serceb">
                Punch Request
            </div>
        </a>
    </div>
</div>
<div id="datatable" class="table-responsive">
    <?php echo $tablebody;?>
</div>
<script>
function getdata(status) {
    if (status.id == 'datef') {
        var firstdate = document.getElementById('datef').value
        var seconddate = document.getElementById('datef').value
    } else if (status.id == 'month') {
        var date = new Date(document.getElementById('month').value);


        var firstDate = new Date(date.getFullYear(), date.getMonth(), 2);

        // Get the last date of the month by setting the day to 0 (which gives the last day of the previous month) and adding 1 day
        var lastDate = new Date(date.getFullYear(), date.getMonth() + 1, 1);

        // Format the dates as strings in the format 'YYYY-MM-DD'
        var firstdate = firstDate.toISOString().slice(0, 10);
        var seconddate = lastDate.toISOString().slice(0, 10);

    } else if (status.id == 'year') {
        var date = document.getElementById('year').value;
        var firstDate = new Date(date, 0, 1); // Month is zero-based, so 0 represents January
        var lastDate = new Date(date, 11, 31); // Month is zero-based, so 11 represents December

        // Format the dates as strings
        var firstdate = firstDate.toDateString();
        var seconddate = lastDate.toDateString();
    }
    $.ajax({
        url: '<?php echo base_url('admin/attendance/employee_attendance'); ?>',
        method: 'GET',
        data: {
            firstdate: firstdate,
            seconddate: seconddate
        },
        success: function(resp) {
            $('#datatable').empty();
            $('#datatable').html(resp);
        }
    });
}
</script>
<script>
    function get_job_card() {
        var ajaxRequest; // The variable that makes Ajax possible!
        ajaxRequest = new XMLHttpRequest();

        first_date = document.getElementById('emp_j_from_date').value;
        second_date = document.getElementById('emp_j_to_date').value;

        if (first_date == '') {
            alert('Please select first date');
            return;
        }
        if (second_date == '') {
            alert('Please select second date');
            return;
        }

        var data = "first_date=" + first_date + '&second_date=' + second_date;

        url = '<?php echo base_url('admin/attendance/get_job_card_emp'); ?>';
        ajaxRequest.open("POST", url, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
        ajaxRequest.send(data);
        // alert(url); return;

        ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4) {
                // console.log(ajaxRequest.responseText); return;
                var resp = ajaxRequest.responseText;
                a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
                a.document.write(resp);
                // a.close();
            }
        }
    }
</script>
<script>
    function punch_request() {
        var ajaxRequest; // The variable that makes Ajax possible!
        ajaxRequest = new XMLHttpRequest();

        punch_type = document.getElementById('punch_type').value;
        p_date = document.getElementById('p_date').value;
        p_time = document.getElementById('p_time').value;

        if (punch_type == '') {
            alert('Please select punch type');
            return;
        }
        if (p_date == '') {
            alert('Please select date');
            return;
        }
        if (p_time == '') {
            alert('Please select time');
            return;
        }
       

        var data = "punch_type=" + punch_type + '&p_date=' + p_date + '&p_time=' + p_time;

        url = '<?php echo base_url('admin/attendance/punch_request'); ?>';
        ajaxRequest.open("POST", url, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
        ajaxRequest.send(data);
        ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4) {
               alert(ajaxRequest.responseText);
            }
        }
    }
</script>