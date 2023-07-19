<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="row m-b-1 <?php echo $get_animate;?>">
    <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
    <?php if(in_array('269',$role_resources_ids)) {?>
    <?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"> <?php echo $this->lang->line('xin_add_new');?>
                    <?php echo $this->lang->line('xin_hr_event');?> </h3>
            </div>
            <div class="box-body">
                <?php $attributes = array('name' => 'add_event',  'autocomplete' => 'off');?>
                <?php $hidden = array('user_id' => $session['user_id']);?>
                <?php echo form_open('admin/events/add_event', $attributes, $hidden);?>
                <input type="hidden" name="employee_id" id="employee_id" value="1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="event_title"><?php echo $this->lang->line('xin_hr_event_title');?></label>
                            <input type="text" class="form-control" name="event_title"
                                placeholder="<?php echo $this->lang->line('xin_hr_event_title');?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input class="form-control date"
                                placeholder="<?php echo $this->lang->line('xin_hr_event_date');?>"
                                name="start_event_date" type="text" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_time">Start Time</label>
                            <input class="form-control timepicker"
                                placeholder="<?php echo $this->lang->line('xin_hr_event_time');?>"
                                name="start_event_time" type="text" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">End Date</label>
                            <input class="form-control date" placeholder="End Date" name="end_event_date" type="text"
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="event_time">End Time</label>
                            <input class="form-control timepicker" placeholder="End Time" name="end_event_time"
                                type="text" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="event_title">Event Location</label>
                            <input type="text" class="form-control" name="location" placeholder="Location" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="event_note">Event Description</label>
                            <textarea class="form-control textarea" placeholder="Event Description" name="event_note"
                                id="event_note" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-actions box-footer">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i>
                        <?php echo $this->lang->line('xin_save');?> </button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <?php $colmdval = 'col-md-8';?>
    <?php } else {?>
    <?php $colmdval = 'col-md-12';?>
    <?php } ?>
    <div class="<?php echo $colmdval;?>">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?>
                    <?php echo $this->lang->line('xin_hr_events');?> </h3>
            </div>
            <div class="box-body">
                <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="dtable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Start Date </th>
                                <th>End Date</th>
                                <th>Duration</th>
                                <th>Details</th>
                                <th>Place Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($allevent as $kay=>$data){ 
              $enddatetime=date('d-M-Y H:i:s' , strtotime($data->end_event_date.' '. $data->end_event_time))
              ?>
                            <tr>
                                <td><?= $kay+1 ?></td>
                                <td><?= date('d-M-Y H:i:s' , strtotime($data->start_event_date.' '. $data->start_event_time))?>
                                </td>
                                <td><?= date('d-M-Y H:i:s' , strtotime($data->end_event_date.' '. $data->end_event_time))?>
                                </td>
                                <td><?= $data->event_duration ?></td>
                                <td>Details</td>
                                <td><?= $data->location ?></td>
                                <td><?= ($enddatetime > date('d-M-Y H:i:s'))? 'Pending': 'Complete' ?></td>
                                <td><a href="<?= base_url('admin/events/delete_event/').$data->event_id ?>"
                                        class="btn btn-sm-danger"
                                        style="padding: 2px;margin: 0;background: red;color: white;">Delete</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.trumbowyg-editor {
    min-height: 110px !important;
}
</style>