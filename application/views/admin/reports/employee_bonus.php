<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <link rel="stylesheet"
        href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

    <style type="text/css">
    .box-tools {
        margin-right: -5px !important;
    }
    .mymorji{
        display: flex;
        flex-direction: column;
        gap: 11px;
    }

    table thead tr th {
        font-size: 12px;
        padding: 3px !important;
    }

    table tbody tr td {
        font-size: 12px;
        padding: 3px !important;
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

        body {
            zoom: 80% !important;
        }
    }
    </style>
    <div style="text-align: center;">
        <?php  $this->load->view('admin/head_bangla'); ?>
    </div>
    <div class="container mymorji">
        <table class="col-md-12" border="1" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="6">
                        <h3> 1 Year complete Employee</h3>
                    </th>
                </tr>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Department Name</th>
                    <th>Designation Name</th>
                    <th>Date of Joining</th>
                    <th>Job Duration</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $this->db->select('
                 xin_employees.*,
                 xin_departments.department_name,
                 xin_designations.designation_name,
                 ');
                 $this->db->from('xin_employees');
                 $this->db->join('xin_designations','xin_designations.designation_id = xin_employees.designation_id','left');
                 $this->db->join('xin_departments','xin_departments.department_id = xin_employees.department_id','left');
                 $this->db->where_in('user_id',$no_intern_one_year);
                 $employee=$this->db->get()->result();
                foreach ($employee as $key => $value) {
                        ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $value->first_name." ".$value->last_name ?></td>
                    <td><?= $value->department_name ?></td>
                    <td><?= $value->designation_name ?></td>
                    <td><?= $value->date_of_joining ?></td>
                    <?php
                    $date1 = date('Y-06-16');
                    $date2 = $value->date_of_joining;
                    $diff = date_diff(date_create($date2), date_create($date1));
                    $duration = $diff->format("%y years %m months %d days");
                    ?>
                    <td><?= $duration ?></td>
                    <td><?= $value->salary ?></td>
                </tr>
                <?php }
          ?>
            </tbody>
        </table>
        <table class="col-md-12" border="1" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="6">
                        <h3>With Intern 1 Year Employee</h3>
                    </th>
                </tr>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Department Name</th>
                    <th>Designation Name</th>
                    <th>Date of Joining</th>
                    <th>Job Duration</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $this->db->select('
                    xin_employees.*,
                    xin_departments.department_name,
                    xin_designations.designation_name,
                    ');
                    $this->db->from('xin_employees');
                    $this->db->join('xin_designations','xin_designations.designation_id = xin_employees.designation_id','left');
                    $this->db->join('xin_departments','xin_departments.department_id = xin_employees.department_id','left');
                    $this->db->where_in('user_id',$joining_one_year);
                    $employee=$this->db->get()->result();
    
                    foreach ($employee as $key => $value) {
                    ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $value->first_name." ".$value->last_name ?></td>
                    <td><?= $value->department_name ?></td>
                    <td><?= $value->designation_name ?></td>
                    <td><?= $value->date_of_joining ?></td>
                    <?php
                    $date1 = date('Y-06-16');
                    $date2 = $value->date_of_joining;
                    $diff = date_diff(date_create($date2), date_create($date1));
                    $duration = $diff->format("%y years %m months %d days");
                    ?>
                    <td><?= $duration ?></td>
                    <td><?= $value->salary ?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        <table class="col-md-12" border="1" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="6">
                        <h3>Non 1 Year Employee</h3>
                    </th>
                </tr>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Department Name</th>
                    <th>Designation Name</th>
                    <th>Date of Joining</th>
                    <th>Job Duration</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <?php
    
                    $this->db->select('
                    xin_employees.*,
                    xin_departments.department_name,
                    xin_designations.designation_name,
                    ');
                    $this->db->from('xin_employees');
                    $this->db->join('xin_designations','xin_designations.designation_id = xin_employees.designation_id','left');
                    $this->db->join('xin_departments','xin_departments.department_id = xin_employees.department_id','left');
                    $this->db->where_in('user_id',$no_year);
                    $employee=$this->db->get()->result();
    
                    foreach ($employee as $key => $value) {
                        ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $value->first_name." ".$value->last_name ?></td>
                    <td><?= $value->department_name ?></td>
                    <td><?= $value->designation_name ?></td>
                    <td><?= $value->date_of_joining ?></td>
                    <?php
                    $date1 = date('Y-06-17');
                    $date2 = $value->date_of_joining;
                    $diff = date_diff(date_create($date2), date_create($date1));
                    $duration = $diff->format("%y years %m months %d days");
                    ?>
                    <td><?= $duration ?></td>
                    <td><?= $value->salary ?></td>
                </tr>
                <?php }  ?>
            </tbody>
        </table>
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
</body>

</html>