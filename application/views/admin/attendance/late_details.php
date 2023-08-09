<!doctype html>
<html lang="en">

<head>
    <title>Late</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffff;
            margin: 0;
            padding: 0px 103px;        
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .employee-name {
            background: #0073a33d;
            width: 99.4%;
            display: block;
            padding: 4px;
            color: #000000;
            font-size: 18px;

        }

        table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin-bottom:30px ;
        }

        th,
        td {
            border: 1px solid #acacac;
            padding: 1px;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tfoot th {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <?php $this->load->view('admin/head_bangla')?>
    <span style="width: 100%;display: block;text-align: center;margin-bottom: 7px;"><?= $type==1?'':'No' ?> Late Report Of   <?= date('d M Y',strtotime($first_date)) ?>   to  <?= date('d M Y',strtotime($second_date)) ?> </span>
    <?php 
    foreach ($late_id as $id) {
        $this->db->select('xin_attendance_time.attendance_date, xin_attendance_time.clock_in, xin_attendance_time.clock_out, xin_attendance_time.late_time, xin_employees.first_name, xin_employees.last_name');
        $this->db->from('xin_attendance_time');
        $this->db->join('xin_employees', 'xin_attendance_time.employee_id = xin_employees.user_id');
        $this->db->where([
            'xin_attendance_time.late_status' => $type,
            'xin_attendance_time.employee_id' => $id,
            'xin_attendance_time.status' => 'Present'
        ]);
        $this->db->where("xin_attendance_time.attendance_date BETWEEN '$first_date' AND '$second_date'");
        $data = $this->db->get()->result();
        if (!empty($data)) {
            ?>
            <span class="employee-name"><?= $data[0]->first_name ?> <?= $data[0]->last_name ?></span>
            <table>
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>In Time</th>
                        <th>Out Time</th>
                        <th>Time</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php $i = 0; $t=0; foreach ($data as $key => $d) { $i++; $t+=$d->late_time?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $d->attendance_date ?></td>
                        <td><?= date('h:i:s A',strtotime($d->clock_in)) ?></td>
                        <td><?= date('h:i:s A',strtotime($d->clock_out ))?></td>
                        <?php if ($d->late_time >= 59) { ?>
                            <td>
                                <?php $minutes = $d->late_time;
                                    $hours = floor($minutes / 60);
                                    $minutes %= 60;
                                    echo $hours . ':' . sprintf("%02s",$minutes); ?>
                            </td>
                        <?php } else { ?>
                            <td><?= $d->late_time ?></td>
                        <?php } ?>
                      
                    </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    
                    <tr>
                        <th colspan="3">Total</th>
                        <td colspan="1"><?= $i ?></th>
                            <?php if ($t >= 60) { ?>
                                <td>
                                    <?php 
                                    $minutes = $t;
                                    $hours = floor($minutes / 60);
                                    $minutes %= 60;
                                    echo $hours . ':' . sprintf("%02d", $minutes); ?>
                                </td>
                            <?php } else { ?>
                                <td><?= $t?></td>
                            <?php } ?>
                    </tr>
                </tfoot>
            </table>
        <?php
        }
    }
    ?>
</body>

</html>
