<?php
// dd($shift->lunch_time);
// $currentTimef = date('H:i:s');
// dd($shift->lunch_time.'    '.$currentTimef );

?>


<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/emp_attandenc.css') ?>">
<div class="col-md-12 topbar">
    <?php if(count($todaylog)>0){?>
    <div class="col-md-4 box">
        <div class="col-md-12 box_heding">
            <span class="col-md-6 box_heding_text">Timesheet</span>
            <span class="col-md-6 box_heding_date"><?= date('d-M-Y')?></span>
        </div>
        <div class="col-md-11 box_heding2">
            <span class="col-md-6 box_heding2_text">Punch In at</span>
            <?php
            $datetime = new DateTime($todaylog->clock_in);
            $formattedDatetime = $datetime->format("h:i A, l, F j, Y");
            function gettime($datetime){
                $specificTime = $datetime->format("H:i:s");
                // || $currentTimef < strtotime('14:30:00')
                    $currentTimes =  date('H:i:s');
                    if(strtotime('13:30:00') > $currentTimes){
                        $currentTime = new DateTime();
                        $currentTime->setTime(13, 30, 00); 
                       
                        $cTDateTime = new DateTime();
                        $timeDiffhj = $cTDateTime->diff($currentTime);
                        $brecktime = $timeDiffhj->format('%H:%I:%S');
                    }
                    if($currentTimes < strtotime('14:30:00')){
                        $currentTime=  new DateTime();
                        $currentTime->modify('-1 hour');
                        $brecktime = '01:00:00';
                    }
                    // Create DateTime objects for the specific time and current time
                    $specificDateTime = DateTime::createFromFormat('H:i:s', $specificTime);

                    // Calculate the time difference
                    $timeDifference = $currentTime->diff($specificDateTime);

                    // Output the time difference
                    echo $timeDifference->format('%H:%I:%S');
            }
            ?>


            <span class="col-md-12 box_heding_text2"> <?php   $currentTimes =  date('H:i:s');
                    if(strtotime('13:30:00') > $currentTimes){
                        $currentTime = new DateTime();
                        $currentTime->setTime(13, 30, 00); 
                       
                        $cTDateTime = new DateTime();
                        $timeDiffhj = $cTDateTime->diff($currentTime);
                        $brecktime = $timeDiffhj->format('%H:%I:%S');
                    }
                    if($currentTimes < strtotime('14:30:00')){
                        $currentTime=  new DateTime();
                        $currentTime->modify('-1 hour');
                        $brecktime = '01:00:00';
                    } ?><?= $formattedDatetime ?></span>
        </div>
        <div class="col-md-11 box_heding3" style="display: contents;">
            <div class=" col-md-5 pans">
                <span id="settimes"
                    style="color: #1F1F1F;font-family: Roboto;font-size: 18px;font-style: normal;font-weight: 400;top: 55px;position: absolute;">
                    <?php gettime($datetime) ?></span>

            </div>

        </div>
        <div class="col-md-12 box_heding4">
            <div class=" col-md-6 box_heding_footer">
                <span
                    style="color: #1F1F1F;text-align: center;font-family: Roboto;font-size: 11px;font-style: normal;font-weight: 400;line-height: 18px;">Break</span>
                <span
                    style="color: rgba(0, 0, 0, 0.85);text-align: center;font-family: Roboto;font-size: 15px;font-style: normal;font-weight: 500;line-height: 14.4px;"><?= $brecktime ?></span>
            </div>
            <div class=" col-md-6 box_heding_footer">
                <span
                    style="color: #1F1F1F;text-align: center;font-family: Roboto;font-size: 11px;font-style: normal;font-weight: 400;line-height: 18px;">Overtime</span>
                <span
                    style="color: rgba(0, 0, 0, 0.85);text-align: center;font-family: Roboto;font-size: 15px;font-style: normal;font-weight: 500;line-height: 14.4px;">1.00hrs</span>
            </div>

        </div>

    </div>
    <?php }else{?>
    <div class="col-md-4 box">
        <div class="col-md-12 box_heding">
            <span class="col-md-6 box_heding_text">Timesheet</span>
            <span class="col-md-6 box_heding_date"><?= date('d-M-Y')?></span>
        </div>
        <div class="col-md-11 box_heding2">
            <span class="col-md-6 box_heding2_text">Punch In at</span>
            <span class="col-md-12 box_heding_text2">Not Punch </span>
        </div>
        <div class="col-md-11 box_heding3" style="display: contents;">
            <div class=" col-md-5 pans">
                <span id="settimes"
                    style="color: #1F1F1F;font-family: Roboto;font-size: 18px;font-style: normal;font-weight: 400;top: 55px;position: absolute;">
                    00:00:00</span>

            </div>

        </div>
        <div class="col-md-12 box_heding4">
            <div class=" col-md-6 box_heding_footer">
                <span
                    style="color: #1F1F1F;text-align: center;font-family: Roboto;font-size: 11px;font-style: normal;font-weight: 400;line-height: 18px;">Break</span>
                <span
                    style="color: rgba(0, 0, 0, 0.85);text-align: center;font-family: Roboto;font-size: 15px;font-style: normal;font-weight: 500;line-height: 14.4px;">1.00hrs</span>
            </div>
            <div class=" col-md-6 box_heding_footer">
                <span
                    style="color: #1F1F1F;text-align: center;font-family: Roboto;font-size: 11px;font-style: normal;font-weight: 400;line-height: 18px;">Overtime</span>
                <span
                    style="color: rgba(0, 0, 0, 0.85);text-align: center;font-family: Roboto;font-size: 15px;font-style: normal;font-weight: 500;line-height: 14.4px;">1.00hrs</span>
            </div>

        </div>

    </div>

    <?php } ?>
    <div class="col-md-3 box">
        <div class="col-md-12 box_heding">
            <span class="col-md-6 box_heding_text">Statistics</span>
        </div>
        <div class="col-md-11 box2_heding2">
            <div class="col-md-12">
                <span class="col-md-6 box2_heding2_text1">Today</span>
                <span class="col-md-6 box2_heding2_text2">3.45 / 8 hrs</span>
            </div>
            <div class="progress col-md-12" style="height: 4px;">
                <div class="progress-bar progress1" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                    aria-valuemax="100" style="width:40%">
                </div>
            </div>
        </div>
        <div class="col-md-11 box2_heding2">
            <div class="col-md-12">
                <span class="col-md-6 box2_heding2_text1">This Week</span>
                <span class="col-md-6 box2_heding2_text2">28 / 40 hrs</span>
            </div>
            <div class="progress col-md-12" style="height: 4px;">
                <div class="progress-bar progress2" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                    aria-valuemax="100" style="width:50%">
                </div>
            </div>
        </div>
        <div class="col-md-11 box2_heding2">
            <div class="col-md-12">
                <span class="col-md-6 box2_heding2_text1">This Month</span>
                <span class="col-md-6 box2_heding2_text2">90 / 160 hrs</span>
            </div>
            <div class="progress col-md-12" style="height: 4px;">
                <div class="progress-bar progress3" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                    aria-valuemax="100" style="width:80%">
                </div>
            </div>
        </div>
        <div class="col-md-11 box2_heding2">
            <div class="col-md-12">
                <span class="col-md-6 box2_heding2_text1">Remaining</span>
                <span class="col-md-6 box2_heding2_text2">90 / 160 hrs</span>
            </div>
            <div class="progress col-md-12" style="height: 4px;">
                <div class="progress-bar progress4" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                    aria-valuemax="100" style="width:60%">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 box">
        <div class="col-md-12 box3_heding">
            <span class="col-md-12 box3_heding_text">Attendance Reports</span>
        </div>
        <div class="col-md-12" style="display: flex;flex-wrap: wrap;gap: 17px;">
            <div class="box3_heding2" style="background: #d1ecf1;">
                <span class="col-md-12 box3_heding2_text1">Working Day</span>
                <span class="col-md-12 box3_heding2_text2">30</span>
            </div>
            <div class="box3_heding2" style="background: #d2f9ee;">
                <span class="col-md-12 box3_heding2_text1">Active Day</span>
                <span class="col-md-12 box3_heding2_text2">22</span>
            </div>
            <div class=" box3_heding2" style="background: #d6d8d9;">
                <span class="col-md-12 box3_heding2_text1">Absent</span>
                <span class="col-md-12 box3_heding2_text2">01</span>
            </div>
            <div class="box3_heding2" style="background: #fddcdf;">
                <span class="col-md-12 box3_heding2_text1">Late Days</span>
                <span class="col-md-12 box3_heding2_text2">22</span>
            </div>
            <div class=" box3_heding2" style="background: #f1cfee;">
                <span class="col-md-12 box3_heding2_text1">Paid Leave</span>
                <span class="col-md-12 box3_heding2_text2">12</span>
            </div>
            <div class="box3_heding2" style="background: #fff2d8;">
                <span class="col-md-12 box3_heding2_text1">Unpaid Leave</span>
                <span class="col-md-12 box3_heding2_text2">01</span>
            </div>
        </div>
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
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
        <tr>
            <td>1</td>
            <td>19 Feb 2019</td>
            <td>10 : 00 AM</td>
            <td>7 : 00 PM</td>
            <td>00:00</td>
            <td>9 hrs</td>
            <td>1 hrs</td>
        </tr>
    </tbody>
</table>
<?php $currentTimef = date('H:i:s');

if (count($todaylog) > 0 && ($shift->lunch_time > $currentTimef || $currentTimef < strtotime('14:30:00'))){?>
<script>
var time = '<?= gettime($datetime) ?>'

function incrementTime() {
    // Step 1: Parse the time string
    var [hours, minutes, seconds] = time.split(":").map(Number);

    // Step 2: Convert to total seconds
    var totalSeconds = hours * 3600 + minutes * 60 + seconds;

    // Step 3: Increment by one
    totalSeconds++;

    // Step 4: Convert back to hours, minutes, and seconds
    hours = Math.floor(totalSeconds / 3600);
    minutes = Math.floor((totalSeconds % 3600) / 60);
    seconds = totalSeconds % 60;

    // Step 5: Format the updated time
    var updatedTime =
        `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
    document.getElementById("settimes").innerHTML = updatedTime;
    // Update the time variable
    time = updatedTime;
}

// Increment the time every second (1000 milliseconds)
setInterval(incrementTime, 1000);
</script>
<?php }?>