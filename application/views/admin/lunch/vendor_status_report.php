<!-- < ?php dd($values);?> -->
<?php
    $exc=1;
?>

<link rel="stylesheet"
    href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<style type="text/css">
.box-tools {
    margin-right: -5px !important;
}

table thead tr th {
    font-size: 12px;
    color: blue;
    padding: 3px !important;
}

table tbody tr td {
    font-size: 11px;
    padding: 3px !important;
}

th,
td {
    text-align: center;
}

.btn {
    background-color: #0890dd;
    height: 30px;
    width: 60px;
    font-size: 15px;
    padding-right: 5px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    color: #fff;
    font-family: Arial, sans-serif;
    /* text-transform: uppercase; */
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease-in-out;
    margin: 5px;
}

.ti1 {
    margin-top: 3px;
    margin-bottom: 0px;
    font-size: 15px;
}


@media print {
    .box-tools {
        margin-right: -5px !important;
    }

    table thead tr th {
        font-size: 12px;
        padding: 3px !important;
    }

    table tbody tr td {
        font-size: 14px;
        padding: 3px !important;
    }
}
</style>


<div>

    <div style="float: right;">

        <button class="btn" onclick="printPageMove()">Print</button>
    </div>
    <div>
        <form style="float: right;" action="<?php echo base_url('admin/lunch/vendor_status_report/'.$exc); ?>"
            method="post">
            <input type="hidden" name="first_date" value="<?php echo $first_date; ?>">
            <input type="hidden" name="second_date" value="<?php echo $second_date; ?>">

            <button class="btn" type="submit">Excel</button>
        </form>
    </div>
</div>
<div style="clear: both;"></div>

<div class="box" id="print-content">
    <div style="text-align: center;">
        <?php  $this->load->view('admin/head_bangla'); ?>
        <!-- <h5 class="box-title ti1">Daily Unpaid Report</h4> -->
        <h4 class="box-title  ti1">Daily Vendor Report</h4>
        <!-- < ?php echo $this->lang->line('xin_employees_monthly_timesheet');?> -->

        <?php $convert_f1=date('d-m-Y', strtotime($first_date));
                    $convert_f2=date('d-m-Y', strtotime($second_date));
            
            ?>


        <p>Report date: <?php echo $convert_f1; ?> To <?php echo $convert_f2; ?> </p>
    </div>


    <div class="container">
        <div class="box-body">
            <div class="box-datatable ">
                <table class="table table-striped table-responsive  table-bordered table-sm">
                    <thead>
                        <th>Sl</th>
                        <th>Date</th>
                        <th>Days</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Total Meal</th>
                        <th>Amount</th>
                        <th>P.Due</th>
                        <th>Net.Amount</th>
                        <th>Paid Amount</th>
                        <th>Due </th>
                        <th>Remarks</th>
                        <th>Status</th>
                    </thead>
                    <?php if (!empty($values)): ?>
                    <?php $total_meal=0;
                           $t_amount=0;
                           $t_pay_amount=0;
                           $t_net_amount=0;
                           $t_paid_amount=0;
                           $st_pv=0;
   
                      ?>
                    <?php $i = 1; foreach ($values as $row): ?>
                    <tbody>
                        <tr>
                            <?php if($i==1){
                                                $st_pv=$row->previous_due;
                                       } ?>
                            <td><?php echo $i++; ?></td>
                            <?php $convert_date=date('d-m-Y', strtotime($row->date)) ?>


                            <td><?php echo $convert_date ?></td>
                            <?php   $dateStr = $row->date;
                                            $date = strtotime($dateStr);
                                            $dayName = date("l", $date); 
                                            $convert_date1=date('d-m-Y', strtotime($row->from_date));
                                            $convert_date2=date('d-m-Y', strtotime($row->to_date));
                                            
                                            ?>
                            <td><?php echo $dayName ?></td>
                            <td><?php echo $convert_date1 ?></td>
                            <td><?php echo $convert_date2 ?></td>
                            <?php 
                                     
                                        $total_meal=$total_meal+$row->total_meal;
                                        $t_amount=$t_amount+$row->pay_amount;
                                        $t_net_amount=$t_net_amount+$row->net_payment;
                                        $t_paid_amount=$t_paid_amount+$row->paid_amount;

                                 ?>
                            <td><?php echo $row->total_meal ?></td>
                            <td><?php echo $row->pay_amount ?></td>
                            <td> <?php echo $row->previous_due ?> </td>
                            <td><?php echo $row->net_payment ?></td>
                            <td><?php echo $row->paid_amount ?> </td>
                            <td><?php echo $row->due ?></td>
                            <td style="text-align: center;" title="<?php echo $row->Remarks; ?>">
                                <?php echo implode(' ', array_slice(explode(' ', $row->Remarks ), 0, 4)); ?></td>

                            <td><?= $row->status != 1 ? 'unpaid' : 'paid' ?></td>


                        </tr>

                        <?php endforeach; ?>

                    </tbody>


                    <?php else: ?>
                    <tbody>
                        <tr>
                            <td colspan="9">No data found.</td>
                        </tr>
                    </tbody>
                    <?php endif; ?>


                </table>
                <br>
                <br>
                <table class="table table-striped table-responsive  table-bordered table-sm">
                    <tr>
                        <td style="text-align:center; font-weight: bold">Total Meals</td>
                        <td style="text-align:center; font-weight: bold">Total Amount</td>
                        <td style="text-align:center; font-weight: bold">Paid Amount</td>
                        <td style="text-align:center; font-weight: bold">Due</td>
                        <td style="text-align:center;font-weight: bold">Previous Due</td>
                        <td style="text-align:center; font-weight: bold">Total Due</td>

                    </tr>

                    <tr>

                        <td style="text-align: center;"><strong><?= $total_meal ?></strong></td>
                        <td style="text-align: center;"><strong><?=  $t_amount?></strong></td>
                        <td style="text-align: center;"><strong><?= $t_paid_amount ?></strong></td>
                        <td style="text-align: center;"><strong><?= $t_amount- $t_paid_amount ?></strong></td>
                        <td style="text-align: center;"><strong><?=  $st_pv ?></strong></td>
                        <?php $_due=$t_amount- $t_paid_amount ?>
                        <td style="text-align: center;"><strong><?= $_due +$st_pv ?></strong></td>

                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- jQuery 3 -->
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js">
</script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js">
</script>

<script
    src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js">
</script>
<!-- Morris.js charts -->
<script>
function printPageMove() {
    var printContents = document.getElementById("print-content").innerHTML;
    var originalContents = document.body.innerHTML;

    // set custom layout, page size, page margin, and page heading
    var printCSS = '<style>@page { size: A4 landscape; margin: 1cm; @top-center { content: "My Custom Page Header"; } } \
                    body { -webkit-print-color-adjust: exact; color-adjust: exact; } \
                    table { border-collapse: collapse; width: 100%; margin: 0 auto; max-width: 100%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); } \
                    th { background-color: #0177BC; color: white; font-size: 18px; font-weight: bold; text-align: center; padding: .5px} \
                    .im { background: #d5b2b2 !important; color: currentcolor !important; } \
                    td { font-size: 15px; text-align: center; border: 2px solid #ddd; width: 19px; } \
                    tr:hover { background-color: #f5f5f5; } \
                    .tdb { background-color: cadetblue; }</style>';

    document.body.innerHTML = printCSS + '<div id="print-content">' + printContents + '</div>';

    window.print();

    document.body.innerHTML = originalContents;
}
</script>