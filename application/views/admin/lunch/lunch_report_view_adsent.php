

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
        <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
				<div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
				<div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;"> <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
				<div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;" >Lunch Date: <?php echo $lunch_data[0]->date ; ?></div>
			
				<div style="font-size:18px; font-weight:bold; text-align:center;">Daily Inactive Lunch Report</div>
            
        </div>
        <?php $data=$lunch_data[0]  ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Lunch Details</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Employee ID</th>
                                        <th>Meal Amount</th>
                                        <th>Present Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lunch_details_inactive as $detail) : ?>
                                        <tr>
                                            <td><?= $detail->id ?></td>
                                            <td><?= $detail->first_name ?> <?= $detail->last_name ?></td>
                                            <td><?= $detail->meal_amount ?></td>
                                            <td><?= $detail->p_stutus ?></td>
                                            <td><?= $detail->date ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>