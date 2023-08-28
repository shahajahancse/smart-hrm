<?php
// dd( $project_data);
// [project_id] => 27
// [title] => demo
// [client_id] => 3
// [start_date] => 2023-08-27
// [end_date] => 2024-05-04
// [company_id] => 1
// [assigned_to] => 11
// [priority] => 2
// [project_no] => DJXWF
// [budget_hours] => 2008
// [summary] => 
// [description] => tfhdfh
// [added_by] => 1
// [project_progress] => 0
// [project_note] => 
// [status] => 0
// [is_notify] => 1
// [software_Budget] => 8000
// [instalment] => 9
// [hardware_Budget] => 4000
// [hardware_Summary] => 666
// [service_status] => 0
// [Service_type] => 0
// [Service_amount] => 0
// [Service_Increment_Date] => 0000-00-00
// [created_at] => 27-08-2023
// [client_name] => sdg sdg
// dd($project_payment)
// [id] => 8
// [project_id] => 38
// [clint_id] => 3
// [software_budget] => 60000
// [hardware_budget] => 50000
// [total_budget] => 110000
// [soft_total_installment] => 9
// [soft_intmnt_dates] => ["2023-08-27","2023-10-14","2023-12-01","2024-01-18","2024-03-06","2024-04-23","2024-06-10","2024-07-28","2024-09-14"]
// [soft_intmnt_prements] => ["6666","6666","6666","6666","6666","6666","6666","6666","6666"]
// [soft_intmnt_status] => ["0","0","0","0","0","0","0","0","0"]
// [soft_intmnt_takes] => 0
// [soft_prement_status] => 0
// [hardware_prement_status] => 0
// [if_notify] => 1
// [Payment_Received] => 0
// [Remaining_Payment] => 110000
// [Payment_Received_percent] => 0
// [Remaining_Payment_percent] => 100
// [notify_date_start] => 2023-08-24
// [update_at] => 2023-08-27
// [created_at] => 2023-08-27 15:58:50
?>
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
                   
                    <tr>
                        <th>End Date</th>
                        <td>:</td>
                        <td><?= $project_data->end_date ?></td>
                    </tr>
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