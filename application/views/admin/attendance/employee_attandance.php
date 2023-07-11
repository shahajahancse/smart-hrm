<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/emp_attandenc.css') ?>">
<div class="col-md-12 topbar">
    <div class="col-md-4 box">
        <div class="col-md-12 box_heding">
            <span class="col-md-6 box_heding_text">Timesheet</span>
            <span class="col-md-6 box_heding_date">11 Mar 2019</span>
        </div>
        <div class="col-md-11 box_heding2">
            <span class="col-md-6 box_heding2_text">Punch In at</span>
            <span class="col-md-12 box_heding_text2">Wed, 11th Mar 2019 10.00 AM</span>
        </div>
        <div class="col-md-11 box_heding3" style="display: contents;">
            <div class=" col-md-5 pans">
                <span
                    style="color: #1F1F1F;font-family: Roboto;font-size: 18px;font-style: normal;font-weight: 400;top: 46px;position: absolute;">3.45
                    hrs</span>

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
                <input style="width: 98%;border: none;cursor: pointer;" type="date" name="" value="<?= date('Y-m-d') ?>" id="">
            </div>
        </div>

    </div>
    <div class="col-md-3 divform-group">
        <div class="input">
            <div class="level">Select Month</div>
            <div class="pseudo6">
                <input style="width: 98%;border: none;cursor: pointer;" type="month" value="<?= date('Y-m') ?>" name="" id="">
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