    <div class="row equal-height-row " style="margin-top:10px">
        <div class="col-sm-4 col_style">
            <div class="card timeac" style="width: 250px;">
                <div class="card-body flex-container" style="margin-top: -8px;margin-bottom: -20px;">
                    <h5 class="card-title flex-item " style="font-weight: 600;">Timesheet</h5>
                    <h6 class="card-title flex-item " style="margin-left: 86px;"><?php echo date('d M Y')?></h6>
                </div>
                <div class="card-body">
                    <div style="border-radius: 4px;border: 1px solid #E3E3E3;background: #F9F9F9; padding: 5px 0px;">
                        <span style="padding: 11px 0px 16px 12px">Punch In At</span><br>
                        <?php if ($in_time == '00:00') {
                            $in_time = "<span class='text-danger' >00:00</span>";
                            $total_working_hour = '0.0';
                        } ?>
                        <span style="padding: 0px 0px 0px 12px"><?php echo date('D, jS M Y ').$in_time?><span>
                    </div>
                </div>

                <div class="containers">
                    <div class="circle">
                        <div class="text"><?= $total_working_hour." hrs"?></div>
                    </div>
                </div>
                <br>
            </div>
        </div>

        <!-- step bar -->
        <div class="col-sm-8 timeshet">
            <div class="col-sm-12 col_style">
                <div class="card todayac" style="margin-left: -82px;">
                    <div class="card-header" style="border-bottom: 0px !important;">
                        <h5 class="card-title flex-item " style="font-weight: 600;margin-left:10px;">Today Activity<i
                                class="fa icon-time"></i></h5>
                    </div>
                    <div class="card-body">
                        <?php
                            $lunch_end = date('h:i A', strtotime("$schedule->lunch_minute minutes", strtotime($schedule->lunch_time)));
                            $in_time_class = '';
                            $lunch_start_class = '';
                            $lunch_end_class = '';
                            $out_time_class = '';
                            if (date('H:i:s') > $schedule->in_start_time && date('H:i:s') < $schedule->in_time) {
                                $in_time_class = 'current-item';
                            } elseif (date('H:i:s') > $schedule->in_time && date('H:i:s') < $schedule->lunch_time) {
                                $lunch_start_class = 'current-item';
                            } elseif (date('H:i:s') > $schedule->lunch_time && date('H:i:s') < date("H:i:s", strtotime($lunch_end))) {
                                $lunch_end_class = 'current-item';
                            } elseif (date('H:i:s') > date("H:i:s", strtotime($lunch_end)) && date('H:i:s') < $schedule->ot_start_time) {
                                $out_time_class = 'current-item';
                            }
                            ?>
                        <section class="step-wizard" style="margin-top: -15px;">
                            <ul class="step-wizard-list" style="margin-left: -48px;">
                                <li class="step-wizard-item <?= $in_time_class?>">
                                    <span class="progress-label-top">Punch In</span>
                                    <span class="progress-count"><i class="icon-time"></i></span>
                                    <span class="progress-label"><?php echo !empty($punch_time->clock_in) ? $in_time : "Not punch yet"?></span>
                                </li>
                                <li class="step-wizard-item <?=$lunch_start_class?>">
                                    <span class="progress-label-top">Lunch Time</span>
                                    <span class="progress-count"><i class="fa fa-clock-o"  aria-hidden="true"></i></i></span>
                                    <span
                                        class="progress-label"><?php echo date('h:i A', strtotime($schedule->lunch_time)); ?></span>
                                </li>
                                <li class="step-wizard-item <?=$lunch_end_class?>">
                                    <span class="progress-label-top">Lunch End</span>
                                    <span class="progress-count"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                    <span class="progress-label"><?php echo $lunch_end; ?></span>
                                </li>
                                <li class="step-wizard-item <?=$out_time_class?>">
                                    <span class="progress-label-top">Punch Out</span>
                                    <span class="progress-count"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                    <span class="progress-label "><?php echo !empty($punch_time->clock_out)  ? $out_time : "Not punch yet"; ?></span>
                                </li>
                            </ul>
                        </section>

                        <div class="row" style="margin-left: -8px;margin-top: 45px;">
                            <div class="col-sm-3">
                                <p><span style="font-weight:600">Status : </span><span>On Time</span></p>
                            </div>
                            <div class="col-sm-4">
                                <p><span style="font-weight:600">Lunch Time : </span><span>1 Hour</span></p>
                            </div>
                            <div class="col-sm-5">
                                <?php $in = date("h:i A", strtotime($schedule->in_time));
                                $out = date("h:i A", strtotime($schedule->ot_start_time)); ?>
                                <p>
                                    <span style="font-weight:600">Working Time: </span>
                                    <span><?= $in .'  -  '. $out; ?></span>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>