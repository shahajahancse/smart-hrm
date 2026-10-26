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
                    <h3 class="box-title">Leave Setup</h3>
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label> Leave Type <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" placeholder="leave name" name="name" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label> Leave Amount <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <input required class="form-control" placeholder="balance" name="balance" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label> Status <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
                                        <select name="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
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

        <div class="box mb-4 <?php echo $get_animate;?>">
            <div class="box-header with-border">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Type</th>
                            <th>Balance</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach($results as $k => $res) { ?>
                        <tr>
                            <td><?php echo $k+1; ?></td>
                            <td><?php echo $res->name;?></td>
                            <td><?php echo $res->balance;?></td>
                            <td><?= $res->status == 1 ? 'Active' : 'Inactive'; ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="<?php echo base_url();?>admin/schedules/leave_type_edit/<?php echo $res->id;?>"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
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
        width: '100%'
    });
});
</script>
