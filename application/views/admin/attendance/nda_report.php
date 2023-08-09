<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NDA Report</title>

    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f3f4f6;
        }

        .report-container {
            width: 100%;
            border-radius: 10px;
            padding: 20px;
            max-width: 80%;
        }

        .report-header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 28px;
            color: #333;
            margin: 0;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 1px solid #e0e4eb;
        }

        th, td {
            padding: 5px;
            text-align: center;
            border-bottom: 1px solid #e0e4eb;
            font-weight: 400;
            border-right: 1px solid #e0e4eb;
        }

        th:last-child, td:last-child {
            border-right: none;
        }

        th {
            background-color: #f5f7fa;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9fafc;
        }

        .no {
            color: #FF6B6B;
            font-weight: 600;
        }

        .yes {
            color: #48BB78;
            font-weight: 600;
        }

      @media print {
        /* CSS styles for printing */
        button {
         display: none;
        }
      }
      

    </style>
</head>

<body>

    <div class="report-container">
    <button onclick="window.print()" style="float: right;background: #68b9ff;border: none;">Print</button>

        <div class="report-header">
        <?php $this->load->view('admin/head_bangla')?>
            <p style="text-align: -webkit-center;padding: 0;margin: 4px;">Non-Disclosure Agreement Report</p>
        </div>
        <table class="report-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>NDA</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($emp_data as $key=>$data){?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $data->first_name ?> <?= $data->last_name ?></td>
                    <td><?= $data->designation_name ?></td>
                    <td><?= $data->department_name ?></td>
                    <td class="<?= $data->nda_status == 0 ? 'no' : 'yes' ?>">
                        <?= $data->nda_status == 0 ? '<span>&#10008;</span> No' : '<span>&#10004;</span> Yes' ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
