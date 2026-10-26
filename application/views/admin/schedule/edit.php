<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $session = $this->session->userdata('username');?>

<div class="row">
    <div class="col-md-12">
        <?php if($this->session->flashdata('success')):?>
            <div class="alert alert-success">
                <?=$this->session->flashdata('success');;?>
            </div>
        <?php endif; ?>

        <div class="box <?php echo $get_animate;?>">
            <div class="box-header  with-border">
                <h3 class="box-title">Update Schedule</h3>
                <div class="box-tools pull-right">
                    <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
                        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span>
                            <?php echo $this->lang->line('xin_add_new');?>
                        </button>
                    </a>
                </div>
            </div>

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
                                        <option <?php if($row->unit_id == $r->company_id):?> selected="selected"<?php endif;?> value="<?= $r->company_id ?>"><?= $r->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Name <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" value="<?= $row->sh_type;?>" name="sh_type" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> In Start <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" type="time" value="<?= $row->in_start;?>" name="in_start" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> In Time <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" type="time" value="<?= $row->in_time;?>" name="in_time" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Late Start <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" type="time" value="<?= $row->late_start;?>" name="late_start" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> In End <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" type="time" value="<?= $row->in_end;?>" name="in_end" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Lunch Start <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" type="time" value="<?= $row->lunch_time;?>" name="lunch_time" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Lunch Minute <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" type="number" value="<?= $row->lunch_minute;?>" name="lunch_minute" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Out Start <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" type="time" value="<?= $row->out_start;?>" name="out_start" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Out Time <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" type="time" value="<?= $row->out_time;?>" name="out_time" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label> Out End <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" type="time" value="<?= $row->out_end;?>" name="out_end" >
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

<script type="text/javascript">
$(document).ready(function() {
    // get designations
    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({
        width: '100%'
    });
});
</script>
