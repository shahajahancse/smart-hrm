<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        // alert('sa');
        $('#emp_ids').select2();
    });
</script>

<?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
<?php $hidden = $session?>
<?php echo form_open('admin/inventory/move_create', $attributes,$hidden);?>
<div class="card">
    <div class="card-body">
    <div class="row">
        <h4 style="margin-left:15px">Creaeted Movement</h4>

    </div>
    <div class="row">
         <div class="col-md-4">
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
        <?php if($session['role_id'] != 3){?>
        <div class="col-md-5">
            <div class="form-group">
                <label>Employee<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                <select class="select2 form-control " name="emp_id" id="emp_ids" required>
                    <option value="">Select Employee</option>
                    <?php foreach ($users as $rows) { 
                          $data = $this->db->select('user_id')->where('status',2)->get('move_list')->row();
                          if($rows->user_id == $data->user_id){
                                continue;
                          }
                    ?>
                        <option  value="<?= $rows->user_id?>"><?= $rows->first_name.' '.$rows->last_name?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <?php }?>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="order_level">Place<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                <select class="form-control" name="floor" id="floor" required value="<?php echo !empty($row->floor)? 'selected':''; ?>">
                        <option value="">Select Place</option>
                        <option value="3">3rd Floor</option>
                        <option value="5">5th Floor</option>
                        <option value="1">Outside Office</option>
                </select>
            </div>
        </div>
        <?php if($session['role_id']==3){?>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="order_level">Purpose<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                    <textarea class="form-control" placeholder="Purpose" name="purpose" id="purpose" type="text" required value="<?php echo !empty($row->order_level)? $row->order_level:''; ?>"></textarea>
                </div>
            </div>
         <?php }?>   
       </div>

        <div class="row">
        <?php if($session['role_id']!=3){?>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="order_level">Purpose<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                    <textarea class="form-control" placeholder="Purpose" name="purpose" id="purpose" type="text" required value="<?php echo !empty($row->order_level)? $row->order_level:''; ?>"></textarea>
                </div>
            </div>
         <?php }?>   


            <?php if($session['role_id']!=3){?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="order_level">Remark<i class="hrsale-asterisk" style="color:red !important">*</i></label>
                        <textarea class="form-control" placeholder="remark" name="remark" id="remark" type="text" required value="<?php echo !empty($row->order_level)? $row->order_level:''; ?>"></textarea>
                    </div>
                </div>
            <?php }?>
            </div>

            <!-- <div class="row"> -->
                <button type="submit" class="btn  btn-primary" style="float:right;"> Save </button>
            <!-- </div> -->
    </div>

</div>

<?php echo form_close(); ?>