<!doctype html>
<html lang="en">

<head>
    <title> Log Report</title>

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
        .label{
            padding: 1px 10px;
            margin: 2px 5px; 
            font-size: 15px;
            font-weight: 500;
            color: #000000;
        }
        .label-warning{
            background-color: #ffc107;
            color: #000000;
            border-radius: 5px;
        }
        .label-success{
            background-color: #28a745;
            color: #ffffff;
            border-radius: 5px;

        }
        .label-danger{
            background-color: #dc3545;
            color: #ffffff;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php $this->load->view('admin/head_bangla')?>
    <span style="width: 100%;display: block;text-align: center;margin-bottom: 7px;"><?= $type==1?'':'No' ?> Late Report Of   <?= date('d M Y',strtotime($first_date)) ?>   to  <?= date('d M Y',strtotime($second_date)) ?> </span>
    <?php 
    foreach ($emp_id as $id) {

        $this->db->select('xin_projects_timelogs.*, xin_employees.first_name, xin_employees.last_name, xin_projects.title');
        $this->db->from('xin_projects_timelogs');
        $this->db->join('xin_employees', 'xin_projects_timelogs.employee_id = xin_employees.user_id');
        $this->db->join('xin_projects', 'xin_projects_timelogs.project_id = xin_projects.project_id');
        $this->db->where('xin_projects_timelogs.employee_id', $id);


        if ($status!='all') {
            $this->db->where('xin_projects_timelogs.status', $status);
        }


        if($type=='daily'){
            $this->db->where('xin_projects_timelogs.start_date', $first_date);
        }
        if($type=='monthly'){
            $this->db->where('xin_projects_timelogs.start_date >=', date('Y-m-01',strtotime($first_date)));
            $this->db->where('xin_projects_timelogs.start_date <=', date('Y-m-t',strtotime($first_date)));
        }
        if($type=='continuously'){
            $this->db->where('xin_projects_timelogs.start_date >=', $first_date);
            $this->db->where('xin_projects_timelogs.start_date <=', $second_date);
        }

        $this->db->order_by('xin_projects_timelogs.timelogs_id', 'DESC');
        $log_data=$this->db->get()->result();
        // (
        //     [timelogs_id] => 4
        //     [project_id] => 2
        //     [company_id] => 1
        //     [employee_id] => 62
        //     [movement] => YES
        //     [start_time] => 01:15
        //     [end_time] => 01:20
        //     [start_date] => 2024-04-22
        //     [end_date] => 2024-04-22
        //     [total_hours] => 0:5
        //     [timelogs_memo] => sdfsdf
        //     [status] => 1
        //     [created_at] => 2024-04-22 01:16:41
        //     [first_name] => Raihan Mahmud
        //     [last_name] => Himel
        //     [title] => test
        // )


        if (!empty($log_data)) {
            ?>
            <span class="employee-name"><?= $log_data[0]->first_name ?> <?= $log_data[0]->last_name ?></span>
            <table>
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Project Name</th>
                        <th>Movement</th>
                        <th>Date</th>
                        <th>Total Hours</th>
                        <th>Details</th>
                        <th>Status</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php $i = 0; $t=0; foreach ($log_data as $key => $d) { $i++; $t+=$d->total_hours?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $d->title ?></td>
                        <td><?= $d->movement ?></td>
                        <td><?= $d->start_date ?></td>
                        <td> <?=$d->total_hours; ?> </td>
                        <td><?= $d->timelogs_memo ?></td>
                        <td>
                            <?php if($d->status==0) { ?>
                            <span class="label label-warning">Pending</span>
                            <?php } else if($d->status==1) { ?>
                            <span class="label label-success">Approved</span>
                            <?php } else if($d->status==2) { ?>
                            <span class="label label-danger">Rejected</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php
        }
    }
    ?>
</body>

</html>
