<?php

$userid  = $session[ 'user_id' ];
$totalmove_out_array = 0;
$totalmove_in_array = 0;
$inout=0;
if (!empty($todaylog)) {
    $totalmove_out_array=json_decode($todaylog[0]->out_time);
    $totalmove_in_array=json_decode($todaylog[0]->in_time);
    $inout=$todaylog[0]->inout;
    $lastRow = end($totalmove_out_array); // Get the last element of the array
// dd($lastRow);
    $currentDateTime = new DateTime(); // Get the current date and time
    $lastRowDateTime = DateTime::createFromFormat('H:i:s', $lastRow); // Convert the last row value to DateTime object
    $timeDifference = $currentDateTime->diff($lastRowDateTime); // Calculate the difference between current time and last row time
    $h = $timeDifference->h; // Get the hours from the time difference
    $m = $timeDifference->i; // Get the minutes from the time difference
    $timeDifferenceFormatted = sprintf('%02d:%02d', $h, $m); // Format the time difference
}
$totalmove=count($totalmove_out_array);
$totalSpendingTime = array(
   'hours' => 0,
   'minutes' => 0,
   'seconds' => 0
);
$count = count($totalmove_out_array);
for ($i = 0; $i < $count; $i++) {
    if(isset($totalmove_in_array[$i])) {
        $outDateTime = new DateTime($totalmove_out_array[$i]);
        $inDateTime = new DateTime($totalmove_in_array[$i]);
        $timeDiff = $inDateTime->diff($outDateTime);
        $totalSpendingTime['hours'] += $timeDiff->h;
        $totalSpendingTime['minutes'] += $timeDiff->i;
        $totalSpendingTime['seconds'] += $timeDiff->s;
    }
}

// Adjust minutes and seconds if necessary
$totalSpendingTime['minutes'] += floor($totalSpendingTime['seconds'] / 60);
$totalSpendingTime['seconds'] %= 60;

// Adjust hours and minutes if necessary
$totalSpendingTime['hours'] += floor($totalSpendingTime['minutes'] / 60);
$totalSpendingTime['minutes'] %= 60;
$totaltime=$totalSpendingTime['hours'].':'.$totalSpendingTime['minutes'].':'.$totalSpendingTime['seconds'];


?>
<style>
.list-group>li:nth-child(5n+1) {
    border-top: 1px solid rgba(0, 0, 0, .125);
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
}

.list-group>li:nth-child(5n+0) {
    border-bottom-left-radius: .25rem;
    border-bottom-right-radius: .25rem;
}

.pagination-container {
    justify-content: right !important;
    display: flex !important;
}

#customModal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

#customModal2 {

    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

#customModal3 {

    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 9% 26%;
    padding: 20px;
    border: 1px solid #888;
    width: 60%;
    overflow: hidden;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    position: inherit;
    z-index: 9999;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.texta {
    padding: 18px;
}

.cboton {
    color: #000;
    font-family: Roboto;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    height: 42px;
    justify-content: center;
    align-items: center;
    gap: 10px;
    border-radius: 2px;
    border: 1px solid #9d9797;

}

.cactive {
    color: #FFF;
    background: #2DCA8C;
}

@media screen and (max-width: 934px) {
    .modal-content {
        margin: 14% 33%;
    }
}

@media screen and (max-width: 762px) {
    .modal-content {
        margin: 31% 14%;
    }
}

@media screen and (max-width: 400px) {
    .modal-content {
        margin: 44% 14%;
        padding: 13px 0px 11px 0px;
        width: 250px;
    }
}
</style>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/emp_attandenc.css') ?>">


<div id="customModal">
    <div class="modal-content">
        <span id="close" class="close"><svg style="width: 20px;height: 20px;flex-shrink: 0;"
                xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path
                    d="M18.0002 4H6.41453C6.15184 3.99995 5.89172 4.05167 5.64903 4.15221C5.40634 4.25275 5.18585 4.40013 5.00016 4.58594L0.292969 9.29281C-0.0976562 9.68344 -0.0976562 10.3166 0.292969 10.7069L5.00016 15.4141C5.37516 15.7891 5.88391 16 6.41422 16H18.0002C19.1048 16 20.0002 15.1047 20.0002 14V6C20.0002 4.89531 19.1048 4 18.0002 4ZM15.3536 11.9394C15.5489 12.1347 15.5489 12.4513 15.3536 12.6466L14.6467 13.3534C14.4514 13.5487 14.1348 13.5487 13.9395 13.3534L12.0002 11.4141L10.0608 13.3534C9.86547 13.5487 9.54891 13.5487 9.35359 13.3534L8.64672 12.6466C8.45141 12.4513 8.45141 12.1347 8.64672 11.9394L10.5861 10L8.64672 8.06063C8.45141 7.86531 8.45141 7.54875 8.64672 7.35344L9.35359 6.64656C9.54891 6.45125 9.86547 6.45125 10.0608 6.64656L12.0002 8.58594L13.9395 6.64656C14.1348 6.45125 14.4514 6.45125 14.6467 6.64656L15.3536 7.35344C15.5489 7.54875 15.5489 7.86531 15.3536 8.06063L13.4142 10L15.3536 11.9394Z"
                    fill="#858A8F" />
            </svg></span>
        <?php $attributes = array('id' => 'movementform1');?>
        <?php echo form_open('', $attributes);?>
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="input" style="border: none;height: 66px;">
                    <div class="level">Select Reason of move**</div>
                    <div class="pseudo6">
                        <select id="reason" onchange="changetother(this)" name="reason"
                            style="width: 98%;border: none;cursor: pointer;" required>
                            <?php $resonedata = $this->db->order_by('id', 'desc')->get('xin_employee_move_reason')->result();?>
                            <option> Select Reason of move</option>
                            <?php $resonedata = $this->db->get('xin_employee_move_reason')->result();
foreach ($resonedata  as $k => $v) {?>
                            <option value="<?=$v->id ?>"><?= $v->title ?></option>
                            <?php } ?>
                            <option value="other">Other</option>
                        </select>
                        <div class="col-md-12" id="otherInput" style="display: none;">
                            <div class="level">Select Reason of move**</div>
                            <input type="text" id="inputt" name="otherInput" class="col-md-12">
                        </div>
                    </div>
                </div>
            </div>
            <script>
            function changetother(raw) {
                var selectedOption = raw.value;
                if (selectedOption === "other") {
                    document.getElementById("otherInput").style.display = "block";
                    document.getElementById("inputt").focus();
                    document.getElementById("inputt").required = true;
                } else {
                    document.getElementById("otherInput").style.display = "none";
                    document.getElementById("inputt").required = false;
                }
            };
            </script>
            <input type="hidden" name="area" value="<?= ($empinfo->floor_status==3) ? 5 : 3?>">
            <div class="col-md-6">
                <div class="input" style="border: none;height: 66px;">
                    <div class="level">Select Meeting People**</div>
                    <div class="pseudo6">
                        <select id="leave_type" name="meet_with" style="width: 98%;border: none;cursor: pointer;"
                            required>
                            <option>Select Meeting People**</option>
                            <?php foreach($emp_floor as $emp) {?>
                            <option value="<?= $emp->user_id ?>"><?= $emp->first_name .' '. $emp->last_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primar">
                    <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="heading">Today Move</div>
        <div class="heading2"><?= $totalmove ?></div>
    </div>

    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="heading">Total Spending time</div>
        <div class="heading2"><?= $totaltime ?></div>
    </div>
    <?php if($inout==0) { ?>
    <div class="divstats-info col-md-6" style="background-color:#FFF;">
        <div class="heading" style="font-size: 12px!important;">Are you want to go to the <span
                style="color: #599AE7;"><?= ($empinfo->floor_status!=3) ? '3rd floor?' : '5th floor?'?></span> Please
            Make Sure your Check In & entry Purpose </div>
        <div class="heading2"><a class="btn" id="openModal"
                style="width: 146px;height: 32px;border-radius: 2px;border: 1px solid var(--b, #599AE7);background: var(--b, #599AE7);color: white;font-weight: bold;">Check
                In</a></div>
    </div>
    <?php } else { ?>

    <div class="divstats-info col-md-6" style="background-color:#FFF;">
        <div class="heading" style="font-size: 12px!important;color: red;">Your Check In time <span
                style="color: #599AE7;"><?= (isset($timeDifferenceFormatted)) ? $timeDifferenceFormatted : ''?> m</span>
            on
            <span style="color: #599AE7;"><?= ($empinfo->floor_status!=3) ? '5rd floor' : '3th floor'?></span> Make Sure
            when You Come back Check out
        </div>
        <div class="heading2"><a class="btn" href="<?= base_url('admin/movement_floor/informsub') ?>"
                style="width: 146px;height: 32px;border-radius: 2px;border: 1px solid var(--b, #599AE7);background: var(--b, #599AE7);color: white;font-weight: bold;">Check
                Out</a></div>
    </div>
    <?php } ?>
</div>
<div class="col-md-12 medelbar" style="gap: 4px;margin: 2px;align-items: end;">
    <div class="col-md-2 divform-group " style="padding: 0;">
        <a href="<?= base_url('admin/attendance/employee_movement') ?>" class="cboton cactive">Floor wise Movement</a>
    </div>
    <div class="col-md-2 divform-group" style="padding: 0;">
        <a href="<?= base_url('admin/attendance/employee_movement/1') ?>" class="cboton">Outside office </a>
    </div>
    <div class="col-md-2 divform-group" style="padding: 0;">
        <a href="<?= base_url('admin/attendance/employee_movement/2') ?>" class="cboton">Outside Dhaka</a>
    </div>
    <div class="col-md-2 divform-group">
    </div>
    <div class="col-md-3 divform-group" style="padding: 0;">
        <div class="input">
            <div class="level">Select Date</div>
            <div class="pseudo6">
                <input onchange=getdata(this) style="width: 98%;border: none;cursor: pointer;" type="date" name=""
                    value="<?= date('Y-m-d') ?>" id="datef">
            </div>
        </div>
    </div>

</div>
<div id="datatable" class="table-responsive">
    <?php echo $tablebody;?>
</div>

<script>
function getdata(status) {
    $('#datatable').empty();
    // console.log(status.id);
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
        url: '<?php echo base_url('admin/attendance/employee_movement_flor'); ?>',
        method: 'POST',
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
document.getElementById("openModal").addEventListener("click", function() {
    document.getElementById("customModal").style.display = "block";
});
document.getElementById("close").addEventListener("click", function() {
    document.getElementById("customModal").style.display = "none";
});
</script>'
<script>
$('#movementform1').on('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
    document.getElementById("customModal").style.display = "none";
    // Get the form data
    var formData = $(this).serialize();


    // Make an AJAX post request to the controller
    $.ajax({
        url: '<?= base_url('admin/movement_floor/outformsub') ?>', // Replace 'controller/method' with your actual controller and method
        method: 'POST',
        data: formData,
        success: function(response) {
            console.log(response);
            showSuccessAlert(response)
        },


        error: function(xhr, status, error) {
            showErrorAlert(error)
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $('#reason').select2();
    $('#leave_type').select2();
});
</script>