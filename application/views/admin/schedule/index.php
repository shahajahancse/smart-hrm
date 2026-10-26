<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $session = $this->session->userdata('username');?>

<div class="row">
    <div class="col-md-12">
        <?php if($this->session->flashdata('success')):?>
            <div class="alert alert-success">
                <?=$this->session->flashdata('success');;?>
            </div>
        <?php endif; ?>

        <div class="box mb-4 <?php echo $get_animate;?>">
            <div id="accordion">
                <div class="box-header  with-border">
                    <h3 class="box-title">Create Schedule</h3>
                    <div class="box-tools pull-right">
                        <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
                            <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span>
                                <?php echo $this->lang->line('xin_add_new');?>
                            </button>
                        </a>
                    </div>
                </div>

                <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
                    <div class="box-body">
                        <?php $attributes = array('name' => 'add_schedule', 'id' => 'xin-form', 'autocomplete' => 'off');?>
                        <?php $hidden = array('_user' => $session['user_id']);?>
                        <?php echo form_open_multipart(current_url(), $attributes, $hidden);?>

                        <div class="form-body">
                            <div class="row">
                                <?php $coms = $this->db->get('xin_companies')->result(); ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label> Organization <span style="color:red">*</span></label>
                                        <select required class="form-control" name="unit_id" >
                                            <option value="">select one</option>
                                            <?php foreach ($coms as $key => $r) { ?>
                                                <option value="<?= $r->company_id ?>"><?= $r->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label> Name <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" placeholder="schedule name" name="sh_type" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> In Start <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" type="time" name="in_start" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> In Time <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" type="time" name="in_time" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> Late Start <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" type="time" name="late_start" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> In End <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" type="time" name="in_end" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> Lunch Start <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" type="time" name="lunch_time" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> Lunch Minute <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" type="number" name="lunch_minute" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> Out Start <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" type="time" name="out_start" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> Out Time <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" type="time" name="out_time" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label> Out End <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" type="time" name="out_end" >
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button name="hrsale_form" type="submit" class="btn btn-primary"><i class="fa fa fa-check-square-o"></i>Submit</button>
                            </div>
                        </div>
                        <br>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="box mb-4 <?php echo $get_animate;?>">
            <div class="box-header with-border">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Company</th>
                            <th>Schedule</th>
                            <th>In Start</th>
                            <th>In Time</th>
                            <th>Late Start</th>
                            <th>In End</th>
                            <th>Lunch Start</th>
                            <th>Lunch Minute</th>
                            <th>Out Start</th>
                            <th>Out Time</th>
                            <th>Out End</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach($results as $k => $res) { ?>
                        <tr>
                            <td><?php echo $k++; ?></td>
                            <td><?php echo $res->name;?></td>
                            <td><?php echo $res->sh_type;?></td>
                            <td><?php echo $res->in_start;?></td>
                            <td><?php echo $res->in_time;?></td>
                            <td><?php echo $res->late_start;?></td>
                            <td><?php echo $res->in_end;?></td>
                            <td><?php echo $res->lunch_time;?></td>
                            <td><?php echo $res->lunch_minute;?></td>
                            <td><?php echo $res->out_start;?></td>
                            <td><?php echo $res->out_time;?></td>
                            <td><?php echo $res->out_end;?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="<?php echo base_url();?>admin/schedules/edit/<?php echo $res->id;?>"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // get designations
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({
        width: '80%'
    });
});
</script>
