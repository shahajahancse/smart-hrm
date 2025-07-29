<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <style>
          td, th {
              padding: 3px !important;
          }
        </style>
</head>

<body>

    <div class="">
        <?php $this->load->view('admin/head_bangla') ?>
        <div class="col-md-12">
            <?php foreach ($employeeLunchDetails as $employeeLunch) {
                $employee_details = $employeeLunch['employee_details'];
                $emp_lunch_payment_data = $employeeLunch['emp_lunch_payment_data'];
            ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="13" style="background: cornflowerblue;"><?php echo $employee_details->first_name . ' ' . $employee_details->last_name; ?></th>
                        </tr>
                        <tr>
                            <th>SN</th>
                            <th>From Date</th>
                            <th>End Date</th>
                            <th>Previous Meal</th>
                            <th>Previous Cost</th>
                            <th>Previous Pay</th>
                            <th>Previous Balance</th>
                            <th>From Date</th>
                            <th>Next Probable Date</th>
                            <th>Probable Meal</th>
                            <th>Pay Amount</th>
                            <th>Collection Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($emp_lunch_payment_data as $key => $payment_data) { ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td style="white-space: nowrap;"><?php echo $payment_data->from_date; ?></td>
                                <td style="white-space: nowrap;"><?php echo $payment_data->end_date; ?></td>
                                <td><?php echo $payment_data->prev_meal; ?></td>
                                <td><?php echo $payment_data->prev_cost; ?></td>
                                <td><?php echo $payment_data->prev_pay; ?></td>
                                <td><?php echo $payment_data->prev_amount; ?></td>
                                <td style="white-space: nowrap;"><?php echo date('Y-m-d', strtotime($payment_data->end_date . ' +1 day')); ?></td>
                                <td style="white-space: nowrap;"><?php echo $payment_data->next_date; ?></td>
                                <td><?php echo $payment_data->probable_meal; ?></td>
                                <td><?php echo $payment_data->pay_amount; ?></td>
                                <td><?php echo $payment_data->collection_amount; ?></td>
                                <td><?= ($payment_data->status==1)?'Paid':'Unpaid' ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>

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

    <?php exit() ?>

</body>

</html>

