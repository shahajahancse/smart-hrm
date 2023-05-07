<!DOCTYPE html>
<html lang="en">

<head>
    <title>Salary Report</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <?php $this->load->view('admin/head_bangla');?>
        <div class="text-center mt-2">
            <h6>Monthly Salary Report</h6>
            <span>Salary Month : <b>February 2023.</b></span>
            <span>Report date  : <b>2023-02-12</b></span>
        </div>
        <table class="table table-hover table-bordered table-sm table-striped sal mt-2">
            <thead>
                <tr class="text-center">
                    <th>Sl No.</th>
                    <th>Emp Name</th>
                    <th>Designation</th>
                    <th>Worked Day</th>
                    <th>Total Present</th>
                    <th>Total Absent</th>
                    <th>Total leave</th>
                    <th>Total late</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td>1</td>
                    <td>Doe</td>
                    <td>Jr. Engg</td>
                    <td>30</td>
                    <td>23</td>
                    <td>5</td>
                    <td>2</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Doe</td>
                    <td>Jr. Engg</td>
                    <td>30</td>
                    <td>23</td>
                    <td>5</td>
                    <td>2</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Doe</td>
                    <td>Jr. Engg</td>
                    <td>30</td>
                    <td>23</td>
                    <td>5</td>
                    <td>2</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Doe</td>
                    <td>Jr. Engg</td>
                    <td>30</td>
                    <td>23</td>
                    <td>5</td>
                    <td>2</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Doe</td>
                    <td>Jr. Engg</td>
                    <td>30</td>
                    <td>23</td>
                    <td>5</td>
                    <td>2</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Doe</td>
                    <td>Jr. Engg</td>
                    <td>30</td>
                    <td>23</td>
                    <td>5</td>
                    <td>2</td>
                    <td>3</td>
                    <td>3</td>
                </tr>
            </tbody>
        </table>
</body>

</html>