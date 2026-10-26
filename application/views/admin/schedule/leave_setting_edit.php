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
                <h3 class="box-title">Update Leave Setting</h3>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Leave Replace <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" value="<?= $row->replace_leave ?>" name="replace_leave" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Leave Deduct (Late) <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" value="<?= $row->deduct_leave ?>" name="deduct_leave" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Leave More (Late) <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" value="<?= $row->more_deduct ?>" name="more_deduct" >
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Status <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <select name="status" class="form-control">
                                    <option <?= $row->status==1? 'selected':'' ?> value="1">Active</option>
                                    <option <?= $row->status==2? 'selected':'' ?> value="2">Inactive</option>
                                </select>
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
