<!doctype html>
<html lang="en">
<?php


$exc=1;
?>

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
</head>

<body>
    <?php if (count($lunch_data) == 0) : ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-danger text-center" role="alert">
                    <strong>There are no data</strong>
                </div>
            </div>
        </div>
    </div>
    <?php else : ?>
    <div style="float: right;">

        <button class="btn" onclick="printPageMove()">Print</button>
    </div>
    <div>
        <form style="float: right;" action="<?php echo base_url('admin/lunch/lunch_reports/'.$exc); ?>" method="post">
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
            <h4 class="box-title  ti1">Lunch Report</h4>
            <!-- < ?php echo $this->lang->line('xin_employees_monthly_timesheet');?> -->

            <?php $convert_f1=date('d-m-Y', strtotime($first_date));
                                $convert_f2=date('d-m-Y', strtotime($second_date));
                        
                        ?>


            <p>Date: <?php echo $convert_f1; ?> To <?php echo $convert_f2; ?> </p>
        </div>
        <div class="table-responsive" style="margin-top: 17px; padding:10px;">
            <table class="table table-bordered" style="text-align:center">
                <thead>
                    <tr>
                        <th style="text-align:center">Sl</th>
                        <th style="text-align:center">Date</th>
                        <th style="text-align:center">Days</th>
                        <th style="text-align:center">Emp M</th>
                        <th style="text-align:center">Guest M</th>
                        <th style="text-align:center">Total M</th>
                        <!-- <th style="text-align:center">Emp Cost</th>
                        <th style="text-align:center">Guest Cost</th>
                        <th style="text-align:center">Total Cost</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total_emp_meal = 0;
                    $total_guest_meal = 0;
                    $total_meal = 0;
                    // $total_empoloyee_cost = 0;
                    // $total_guest_cost = 0;
                    // $total_cost = 0;
                    
                
                
                ?>
                    <?php $i = 1; foreach ($lunch_data as $item) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <?php $convertedDate2 = date('d-m-Y', strtotime($item->date));  ?>
                        <td><?php echo $convertedDate2 ; ?></td>
                        <?php  
                            $dateStr = $item->date;
                            $date = strtotime($dateStr);
                            $dayName = date("l", $date);

                            $total_emp_meal += $item->emp_m;
                            $total_guest_meal += $item->guest_m;
                            $total_meal += $item->total_m;
                            // $total_empoloyee_cost += $item->emp_cost;
                            // $total_guest_cost += $item->guest_cost;
                            // $total_cost += $item->total_cost;


                
                      ?>
                        <td><?=   $dayName ?> </td>
                        <td><?php echo $item->emp_m; ?></td>
                        <td><?php echo $item->guest_m; ?></td>
                        <td><?php echo $item->total_m; ?></td>
                        <!-- <td><?php echo $item->emp_cost; ?></td>
                        <td><?php echo $item->guest_cost; ?></td>
                        <td><?php echo $item->total_cost; ?></td> -->
                    </tr>
                    <?php endforeach; ?>

                </tbody>
                <tfoot style="text-align: center;font-weight: bold;">
                    <tr>
                        <td colspan="3">Total</td>
                        <td><?=  $total_emp_meal ?></td>
                        <td><?=  $total_guest_meal ?></td>
                        <td><?=  $total_meal  ?></td>
                        <!-- <td><?=  $total_empoloyee_cost?></td>
                        <td><?=   $total_guest_cost  ?></td>
                        <td><?=  $total_cost ?></td> -->
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    </div>
    <?php endif; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
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
</body>

</html>