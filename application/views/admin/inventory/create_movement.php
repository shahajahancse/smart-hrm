<?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
<?php $hidden = array('user_id' => $session['user_id']);?>
<?php echo form_open('admin/inventory/move_create', $attributes,$hidden);?>
<div class="card">
    <div class="card-body">
        <h4 style="margin-left:15px">Creaeted Movement</h4>
        <div class="col-md-3">
            <div class="form-group">
                <label>Select Device<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                <select class="form-control" name="device_id" id="device_id" required>
                    <option value="">Select Device</option>
                    <?php foreach ($get as $rows) { ?>
                        <option <?php echo (!empty($row) && $row->cat_id == $rows->id)? 'selected':'' ?> value="<?= $rows->a_id?>"><?= $rows->model_name?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Employee<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                <select class="form-control" name="emp_id" id="emp_id" required>
                    <option value="">Select Employee</option>
                    <?php foreach ($users as $rows) { ?>
                        <option <?php echo (!empty($row) && $row->sub_cate_id == $rows->id)? 'selected':'' ?>  value="<?= $rows->user_id?>"><?= $rows->first_name.' '.$rows->last_name?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-5">
            <div class="form-group">
                <label for="order_level">Purpose<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                <textarea class="form-control" placeholder="Purpose" name="purpose" id="purpose" type="text" required value="<?php echo !empty($row->order_level)? $row->order_level:''; ?>"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary" style="float:right;margin-right:17px">  Save </button>
    </div>

</div>

<?php echo form_close(); ?>