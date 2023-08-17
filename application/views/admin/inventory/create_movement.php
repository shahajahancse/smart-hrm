<?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
<?php $hidden = array('user_id' => $session['user_id'],'role_id' => $session['role_id']);?>
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
                        <option value="<?= $rows->device_model?>"><?= $rows->cat_name.' '.$rows->model_name.' MLH '.$rows->cat_short_name.'-'.$rows->device_name_id?></option>
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
                        <option  value="<?= $rows->user_id?>"><?= $rows->first_name.' '.$rows->last_name?></option>
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

        <div class="col-md-2">
            <div class="form-group">
                <label for="order_level">Floor<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                <select class="form-control" name="floor" id="floor" required value="<?php echo !empty($row->floor)? 'selected':''; ?>">
                        <option value="">Select Floor</option>
                        <option value="3">3rd Floor</option>
                        <option value="5">5th Floor</option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="order_level">Status<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                <select class="form-control" name="status" id="status" required value="<?php echo !empty($row->status)?  'Selected':''; ?>">
                    <option value="">Select Status</option>
                    <option value="1">Not Used</option>
                    <option value="2">Used</option>
                </select>        
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="order_level">Remark<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                <textarea class="form-control" placeholder="remark" name="remark" id="remark" type="text" required value="<?php echo !empty($row->order_level)? $row->order_level:''; ?>"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-primary" style="float:right;margin-right:17px">  Save </button>
    </div>

</div>

<?php echo form_close(); ?>