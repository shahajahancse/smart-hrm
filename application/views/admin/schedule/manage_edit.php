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
                <h3 class="box-title">Update manage Schedule</h3>
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
                        <div class="col-md-4">
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

                        <?php $soms = $this->db->get('emp_shift_schedule')->result(); ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Schedule <span style="color:red">*</span></label>
                                <select required class="form-control" name="schedule_id" >
                                    <option value="">select one</option>
                                    <?php foreach ($soms as $key => $r) { ?>
                                        <option <?php if($row->schedule_id == $r->id):?> selected="selected"<?php endif;?> value="<?= $r->id ?>"><?= $r->sh_type ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label> Shift Name <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                <input required class="form-control" value="<?= $row->shift_name;?>" name="shift_name" >
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
