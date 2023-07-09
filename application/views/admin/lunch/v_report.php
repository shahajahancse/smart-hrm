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

.container {
    width: 60%;
}

/* Custom styles for the table */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 10px;
    text-align: center;
}

.table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.table td {
    background-color: #ffffff;
}

/* Custom styles for the container */
.container {
    margin: 20px auto;
    max-width: 600px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.row {
    display: flex;
}

.column {
    flex: 50%;
    padding: 10px;
    height: 300px;
    /* Should be removed. Only for demonstration */
}

@media print {
    .btn {
        display: none;
    }
}
</style>


<div>

    <div style="float: right; margin-left:6px;">

        <button class="btn" onclick="window.print()">Print</button>
    </div>
    <div>
        <form style="float: right;" action="<?php echo base_url('admin/lunch/vendor_status_report/'.$exc); ?>"
            method="post">
            <input type="hidden" name="first_date" value="<?php echo $from_date; ?>">
            <input type="hidden" name="second_date" value="<?php echo $to_date ?>">

            <!-- <button class="btn" type="submit">Excel</button> -->
        </form>
    </div>
</div>
<div style="clear: both;"></div>

<div class="box" id="print-content">
    <div style="text-align: center;">
        <?php  $this->load->view('admin/head_bangla'); ?>
        <!-- <h5 class="box-title ti1">Daily Unpaid Report</h4> -->
        <h4 class="box-title  ti1">Payment Vendor Report</h4>
        <!-- < ?php echo $this->lang->line('xin_employees_monthly_timesheet');?> -->

        <?php $convert_f1=date('d-m-Y', strtotime($from_date));
                    $convert_f2=date('d-m-Y', strtotime($to_date));
                    $convert_ff=date('d-m-Y', strtotime($f_date))
                   
            
            ?>

        <span>Report Generate date: <?php echo $convert_ff; ?> </span>
        <p>Calculation date: <?php echo $convert_f1; ?> To <?php echo $convert_f2; ?> </p>
    </div>





    <style>
    /* Custom styles for the table */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ccc;
    }

    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .table td {
        background-color: #ffffff;
    }

    /* Custom styles for the container */
    .container {
        margin: 20px auto;
        max-width: 600px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Custom styles for the signature row */
    .signature-row {
        display: flex;
        justify-content: space-evenly;
        align-items: flex-end;
        padding-top: 20px;
        font-weight: bold;
    }

    .signature-row div+div {
        margin-left: 20px;
    }
    </style>

    <div class="container">
        <div class="box-body">
            <div class="box-datatable">
                <table class="table">
                    <tbody>
                        <!-- Row 1: Meal Quantity -->
                        <tr>
                            <th>Meal Quantity</th>
                            <?php foreach ($values as $row): ?>
                            <td><?= $row->total_meal ?></td>
                            <?php endforeach; ?>
                        </tr>

                        <!-- Row 2: Total Amount -->
                        <tr>
                            <th>Total Amount</th>
                            <?php foreach ($values as $row): ?>
                            <td><?= $row->pay_amount ?></td>
                            <?php endforeach; ?>
                        </tr>

                        <!-- Row 3: Previous Due -->
                        <tr>
                            <th>Previous Due</th>
                            <?php foreach ($values as $row): ?>
                            <td><?= $row->previous_due ?></td>
                            <?php endforeach; ?>
                        </tr>

                        <!-- Row 4: Net Amount -->
                        <tr>
                            <th>Net Amount</th>
                            <?php foreach ($values as $row): ?>
                            <td><?= $row->net_payment ?></td>
                            <?php endforeach; ?>
                        </tr>

                        <!-- Row 5: Payment -->
                        <tr>
                            <th>Payment</th>
                            <?php foreach ($values as $row): ?>
                            <td><?= $row->paid_amount ?></td>
                            <?php endforeach; ?>
                        </tr>

                        <!-- Row 6: Current Due -->
                        <tr>
                            <th>Current Due</th>
                            <?php foreach ($values as $row): ?>
                            <td><?= $row->due ?></td>
                            <?php endforeach; ?>
                        </tr>

                    </tbody>
                </table>
                <div>
                    <tr>
                        <th>Note :</th>
                        <?php foreach ($values as $row): ?>
                        <td><?= $row->Remarks ?></td>
                        <?php endforeach; ?>
                    </tr>
                </div>

            </div>
        </div>
    </div>



    <div class="signature-row">
        <div>Admin Signature</div>
        <div>Super Admin Signature</div>
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