<?php
$this->db->select('xin_projects.*, xin_clients.name as client_name');
$this->db->from('xin_projects');
$this->db->join('xin_clients', 'xin_projects.client_id = xin_clients.client_id');
$project_data = $this->db->get()->result();
$project_data_paid=$this->db->where('status',1)->get('xin_projects')->result();
$project_data_unpaid=$this->db->where('status',0)->get('xin_projects')->result();
$project_data_onservice=$this->db->where('service_status',1)->get('xin_projects')->result();
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<style>
.dropdown-item {
    padding: 4px;
    margin: 5px;
    width: 137px;
    height: 28px;
    text-align: center;
    border: 1px solid #0177bc;
    border-radius: 4px;
    /* New style for dropdown-item */
    background-color: #f8f9fa;
    color: #212529;
    transition: box-shadow 0.3s, color 0.3s;
}

.dropdown-item:hover {
    /* Hover effect */
    box-shadow: 0 0 5px #0177bc;
    color: #fff;
}

.dropdown-menu {
    min-width: fit-content !important;
}
td {
    padding: 6px;
}

</style>
<div class="row animated <?php echo $get_animate;?>">
    <div class="col-xl-3 col-md-3">
        <div class="card mini-stat bg-yellow">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon"> <i class="fa fa-life-bouy float-right"></i> </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3">Total Project</h6>
                    <h4 class="mb-4"><?php echo count($project_data)?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="card mini-stat bg-aqua">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon"> <i class="fa fa-server float-right"></i> </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3">Paid Project</h6>
                    <h4 class="mb-4"><?php echo count($project_data_paid)?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="card mini-stat bg-green">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon"> <i class="ion ion-thumbsup float-right"></i> </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3">Unpaid Project</h6>
                    <h4 class="mb-4"><?php echo count($project_data_unpaid)?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="card mini-stat bg-red">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon"> <i class="fa fa-cube float-right"></i> </div>
                <div class="text-white">
                <h6 class="text-uppercase mb-3">Project On Service</h6>
                <h4 class="mb-4"><?php echo count($project_data_onservice)?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box <?php echo $get_animate;?>">
    <div class="box-header with-border">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?>
            <?php echo $this->lang->line('xin_projects');?> </h3>
            <a href="<?= base_url('admin/project/add_project_form') ?>" style="float: right;" class="btn btn-primary btn-sm">Add New</a>
    </div>
</div>
<div class="box <?php echo $get_animate;?>" style="padding: 12px;">
<table id="myTable" class="col-md-12" >
    <thead>
        <tr>
            <th>Sl</th>
            <th>Project Name</th>
            <th>Client Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>On Service</th>
            <th>Payment Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($project_data as $key=>$project) {
    ?>
        <tr>
            <td><?php echo $key+1 ?></td>
            <td><?php echo $project->title; ?></td>
            <td><?php echo $project->client_name; ?></td>
            <td><?php echo $project->start_date; ?></td>
            <td><?php echo $project->end_date; ?></td>
            <td>
            <?php 
                if ($project->service_status == 1) {
                echo '<span style="color: green;">Yes</span>';
                } else {
                echo '<span style="color: red;">No</span>';
                }
            ?>
            </td>
            <td style="color: <?php echo $project->status == 1 ? 'green' : 'red'; ?>">
                <?php echo $project->status == 1 ? 'Paid' : 'Unpaid'; ?>
            </td>
            <td>
            <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="actionButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu dropdown-menu-right list-group" aria-labelledby="actionButton">
                            <a class="dropdown-item list-group-item"
                                href="<?= base_url('admin/project/Payment_details/'.$project->project_id) ?>">Payment Details</a>
                            <a class="dropdown-item list-group-item"
                                href="<?= base_url('admin/project/Project_details/'.$project->project_id) ?>">Project Details</a>
                            <!-- <a class="dropdown-item list-group-item"
                                href="<?= base_url('admin/project/edit/') ?>">Edit</a> -->
                        </div>
                    </div>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
</div>
<script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>
