<div class="col-md-12">
    <div class="box " style="padding: 8px;overflow: auto;">
        <h5>Project Information</h5>
        <div class="col-md-12">
            <table class="col-md-6">
                <tbody>
                    <tr>
                        <th>Project Name</th>
                        <td>:</td>
                        <td><?= $project_data->title ?></td>
                    </tr>
                    <tr>
                        <th>Start Date</th>
                        <td>:</td>
                        <td><?= $project_data->start_date ?></td>
                    </tr>
                    <tr>
                        <th>End Date</th>
                        <td>:</td>
                        <td><?= $project_data->end_date ?></td>
                    </tr>
                    <tr>
                        <th>Payment Status</th>
                        <td>:</td>
                        <td>
                            <?php if ($project_data->status == 1): ?>
                            <span style="color: green">Paid</span>
                            <?php else: ?>
                            <span style="color: red">Unpaid</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>On service</th>
                        <td>:</td>
                        <td> <?php 
                            if ($project_data->service_status == 1) {
                            echo '<span style="color: green;">Yes</span>';
                            } else {
                            echo '<span style="color: red;">No</span>';
                            }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Installment</th>
                        <td>:</td>
                        <td> <?= $project_payment->soft_total_installment?></td>
                    </tr>
                    <tr>
                        <th>Take Installment</th>
                        <td>:</td>
                        <td> <?= $project_payment->soft_intmnt_takes?></td>
                    </tr>
                </tbody>
            </table>
            <table class="col-md-6">
                <tbody>
                    <tr>
                        <th>Client Name</th>
                        <td>:</td>
                        <td><?= $project_data->client_name ?></td>
                    </tr>
                   
                    <!-- <tr>
                        <th>End Date</th>
                        <td>:</td>
                        <td>< ?= $project_data->end_date ?></td>
                    </tr> -->
                    <tr>
                        <th>Software Budget</th>
                        <td>:</td>
                        <td><?= $project_payment->software_budget ?></td>
                    </tr>
                    <tr>
                        <th>Hardware Budget</th>
                        <td>:</td>
                        <td><?= $project_payment->hardware_budget ?></td>
                    </tr>
                    <tr>
                        <th>Hardware Payment Status</th>
                        <td>:</td>
                        <td class="<?= $project_payment->hardware_prement_status ? 'text-success' : 'text-danger' ?>">
                        <?= $project_payment->hardware_prement_status ? 'Paid' : 'Unpaid' ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Budget</th>
                        <td>:</td>
                        <td><?= $project_payment->hardware_budget+ $project_payment->software_budget?></td>
                    </tr>
                    <tr>
                        <th>Payment Received</th>
                        <td>:</td>
                        <td><?= $project_payment->Payment_Received ?></td>
                    </tr>
                    <tr>
                        <th>Remaining Payment</th>
                        <td>:</td>
                        <td><?= $project_payment->Remaining_Payment ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="box" style="padding: 8px; overflow: auto;">
        <h5>Installment Section</h5>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">Sl</th>
                    <th style="border: 1px solid black; padding: 8px;">Date</th>
                    <th style="border: 1px solid black; padding: 8px;">Amount</th>
                    <th style="border: 1px solid black; padding: 8px;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $soft_intmnt_dates = json_decode($project_payment->soft_intmnt_dates);
                $soft_intmnt_prements = json_decode($project_payment->soft_intmnt_prements);
                $soft_intmnt_status = json_decode($project_payment->soft_intmnt_status);
                foreach ($soft_intmnt_dates as $key => $value) {?>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;"><?= $key+1 ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $soft_intmnt_dates[$key] ?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?= $soft_intmnt_prements[$key] ?></td>
                    <td style="border: 1px solid black; padding: 8px; color: <?= ($soft_intmnt_status[$key] == 1) ? 'green' : 'red'; ?>">
                        <?php echo ($soft_intmnt_status[$key] == 1) ? 'paid' : 'unpaid'; ?>
                    </td>
                </tr>
                <?php }  ?>      
            </tbody>
        </table>
    </div>
</div>
