<?php
/* Projects List view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row animated <?php echo $get_animate;?>">
    <div class="col-xl-3 col-md-3">
        <div class="card mini-stat bg-yellow">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon"> <i class="fa fa-life-bouy float-right"></i> </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3"><?php echo $this->lang->line('xin_not_started');?></h6>
                    <h4 class="mb-4"><?php echo $this->Project_model->not_started_projects();?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="card mini-stat bg-aqua">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon"> <i class="fa fa-server float-right"></i> </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3"><?php echo $this->lang->line('xin_in_progress');?></h6>
                    <h4 class="mb-4"><?php echo $this->Project_model->inprogress_projects();?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="card mini-stat bg-green">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon"> <i class="ion ion-thumbsup float-right"></i> </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3"><?php echo $this->lang->line('xin_completed');?></h6>
                    <h4 class="mb-4"><?php echo $this->Project_model->complete_projects();?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="card mini-stat bg-red">
            <div class="card-body mini-stat-img">
                <div class="mini-stat-icon"> <i class="fa fa-cube float-right"></i> </div>
                <div class="text-white">
                    <h6 class="text-uppercase mb-3"><?php echo $this->lang->line('xin_deffered');?></h6>
                    <h4 class="mb-4"><span class="badge bg-red">
                            <?php echo $this->lang->line('xin_project_cancelled');?>
                            <?php echo $this->Project_model->cancelled_projects();?> </span>
                        <span class="ml-2"> <span class="badge badge-info">
                                <?php echo $this->lang->line('xin_project_hold');?>
                                <?php echo $this->Project_model->hold_projects();?> </span></span>
                    </h4>

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