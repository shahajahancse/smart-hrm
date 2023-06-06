<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .panel {
            border-radius: 10px;
            margin-right: 30px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .panel-heading {
            background-color: #c2c8ce;
            padding: 6px;
            border-radius: 10px 10px 0 0;
        }

        .panel-title {
            color: #333333;
            font-size: 24px;
            font-weight: bold;
            margin-top: 0;
        }

        .panel-body {
            padding: 20px;
        }

        .panel-body strong {
            color: #333333;
            font-weight: bold;
        }

        .comment-section {
            width: 100%;
            border: 1px solid #333333;
            padding: 10px;
            border-radius: 7px;
            margin-top: 10px;
            background-color: #f8f9fa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #dddddd;
        }

        table th {
            background-color: #f8f9fa;
            color: #333333;
            font-weight: bold;
            text-align: left;
        }

        table td {
            vertical-align: middle;
        }

        .alert {
            margin-top: 20px;
            border-radius: 10px;
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
        <div class="container">
        <div style="font-size:18px; font-weight:bold; text-align:center; margin-top:10px">
            <?= xin_company_info(1)->company_name; ?>
        </div>
        <div style="font-size:16px; font-weight:bold; text-align:center; height:0px;"></div>
        <div style="font-size:16px; line-height:15px; font-weight:bold; text-align:center;">
            <?= xin_company_info(1)->address_1 . " " . xin_company_info(1)->address_2; ?>
        </div>
            <div class="table-responsive" style="margin-top: 17px;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                           
                            <th>Emp M</th>
                            <th>Guest M</th>
                            <th>Total M</th>
                           
                            <th>Emp Cost</th>
                            <th>Guest Cost</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lunch_data as $item) : ?>
                            <tr>
                                <td><?php echo $item->date; ?></td>
                               
                                <td><?php echo $item->emp_m; ?></td>
                                <td><?php echo $item->guest_m; ?></td>
                                <td><?php echo $item->total_m; ?></td>
                                
                                <td><?php echo $item->emp_cost; ?></td>
                                <td><?php echo $item->guest_cost; ?></td>
                                <td><?php echo $item->total_cost; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>
