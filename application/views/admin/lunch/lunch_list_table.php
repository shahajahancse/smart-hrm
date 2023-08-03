
    <table class="table table-hover" id="Lunch_table">
        <thead>
            <tr>
                <th style="text-align:center">Sl</th>
                <th style="text-align:center">Date</th>
                <th style="text-align:center">Days</th>
                <th style="text-align:center">Emp.Meal</th>
                <th style="text-align:center">G.Meal</th>
                <th style="text-align:center">Total Meal</th>
                <th style="text-align:center">Emp.Cost</th>
                <th style="text-align:center">G.Cost</th>
                <th style="text-align:center">Office.Cost</th>
                <th style="text-align:center">Total Cost</th>
                <th style="text-align:center">Remarks</th>
                <?php if( $session['role_id']==1): ?>
                <th style="text-align:center">Edit</th>
                <?php endif; ?>

                <th style="text-align:center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $key => $result) { ?>
            <tr>
                <td style="text-align:center"><?= $key + 1 ?></td>

                <?php   $dateStr = $result->date;
                        $date = strtotime($dateStr);
                        $dayName = date("l", $date);
                        $convertedDate = date('d-m-Y', strtotime($dateStr));
                        ?>
                <td style="text-align:center"><?= $convertedDate ?></td>

                <td style="text-align:center"> <?= $dayName?></td>
                <td style="text-align:center"><?= $result->emp_m ?></td>
                <td style="text-align:center"><?= $result->guest_m ?></td>
                <td style="text-align:center"><?= $result->total_m ?></td>
                <td style="text-align:center"><?= $result->emp_cost ?></td>
                <td style="text-align:center"><?= $result->guest_cost ?></td>
                <td style="text-align:center"><?= $result->emp_cost+ $result->guest_cost ?></td>
                <td style="text-align:center"><?= $result->total_cost * 2 ?></td>
                <?php if ($result->bigcomment != null) : ?>
                <td title="<?php echo $result->bigcomment; ?> " style="text-align:center">
                    <?php echo implode(' ', array_slice(explode(' ', $result->bigcomment), 0, 3)); ?>
                </td>
                <?php else : ?>
                <td style="text-align:center">
                    <?php echo "...." ?>
                </td>
                <?php endif; ?>
                <?php if( $session['role_id']==1): ?>
                <td style="text-align: center;">
                    <input type="checkbox" name="" class="chkbox"
                        onchange='hrp(<?=$result->id?>,<?=$result->if_eidit?>)'
                        <?= ($result->if_eidit==0)? '':'checked' ?>>
                </td>
                <?php endif; ?>
                <td>
                    <?php if ($result->date == date('Y-m-d')) : ?>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="actionButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu dropdown-menu-right list-group" aria-labelledby="actionButton">
                            <a class="dropdown-item list-group-item"
                                href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
                            <a class="dropdown-item list-group-item"
                                href="<?= base_url('admin/lunch/today_lunch/'.$result->id) ?>">Edit</a>
                        </div>
                    </div>
                    <?php else : ?>
                    <?php if ($result->if_eidit == 1 && $session['role_id'] == 4) : ?>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="actionButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu dropdown-menu-right list-group" aria-labelledby="actionButton">
                            <a class="dropdown-item list-group-item"
                                href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
                            <a class="dropdown-item list-group-item"
                                href="<?= base_url('admin/lunch/today_lunch/'.$result->id) ?>">Edit</a>
                        </div>
                    </div>
                    <?php elseif($session['role_id'] == 1 || $session['role_id'] == 2) : ?>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="actionButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu dropdown-menu-right list-group" aria-labelledby="actionButton">
                            <a class="dropdown-item list-group-item"
                                href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
                            <a class="dropdown-item list-group-item"
                                href="<?= base_url('admin/lunch/today_lunch/'.$result->id) ?>">Edit</a>
                        </div>
                    </div>
                    <?php else : ?>
                    <a href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
                    <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

<!-- <script>
$(document).ready(function() {
    $('#Lunch_table').DataTable();
});
</script> -->