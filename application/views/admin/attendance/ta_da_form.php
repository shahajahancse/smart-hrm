<style>
.input {
    height: 34px;
    margin: 5px 6px;
    border-radius: 5px;
    border: 1px solid #896e6e;
}

.sideb {
    height: 26px;
    display: block;
    float: right;
    font-size: 32px;
    font-weight: bold;
    text-align-last: center;
    color: #27eaff;
    cursor: pointer;
}

.boxx {
    padding: 0px;
    border-radius: 5px;
    height: fit-content;
    box-shadow: 3px 4px 7px 4px rgb(0 0 0 / 10%);
    background: white;

}

.heading {
    color: #000;
    font-family: Roboto;
    font-size: 20px;
    font-style: normal;
    font-weight: bold;
    line-height: 22.5px;
    justify-content: center;
    background: #eeee;
    display: flex;
    text-transform: capitalize;
    border-radius: 5px 5px 0px 0px;
    padding: 5px;
    margin-bottom: 11px;
}

/* footer.footer-dark {
    display: none;
} */
</style>


<?php
// stdClass Object
// (
//     [id] => 1
//     [move_id] => 22
//     [travel_with] => []
//     [g_place] => ["agargao","savar"]
//     [g_transportation] => ["CNG","bus"]
//     [g_costing] => ["10","40"]
//     [c_place] => ["yui","ggg"]
//     [c_transportation] => ["CNG","bus"]
//     [c_costing] => ["34","34"]
//     [additional_cost] => 34
//     [costing_invoice] => http://localhost/smart-hrm/uploads/move_file/e5a190887682a27e67550000aef05a68.jpg
//     [remark] => fdgfhy
// )
if (isset($movedata)) {

    $g_place_array=json_decode($movedata->g_place);
    $g_transportation_array=json_decode($movedata->g_transportation);
    $g_costing_array=json_decode($movedata->g_costing);
    $get_animate = $this->Xin_model->get_content_animate();
    $c_place_array=json_decode($movedata->c_place);
    $c_transportation_array=json_decode($movedata->c_transportation);
    $c_costing_array=json_decode($movedata->c_costing);

}else{
    $g_place_array=[];
    $g_transportation_array=[];
    $g_costing_array=[];
    $get_animate =[];
    $c_place_array=[];
    $c_transportation_array=[];
    $c_costing_array=[];
}
// dd($movedata)
?>

<div class="box" style="display: flex;">
    <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
    <?php echo form_open_multipart(base_url('admin/attendance/add_ta_da'), $attributes);?>

    <input type="hidden" name="move_id" value="<?= $move_id ?>">
    <div class="col-md-12" style="padding: 26px;display: flex;gap: 25px;">
        <div class="col-md-6 boxx">
            <span class="heading">Going Way</span>
            <div class="col-md-12" style="padding: 12px;">
                <?php if(count($g_place_array)>0){
                    foreach ($g_place_array as $key => $value) {
                    ?>

                <div class=" remove pway">
                    <input class=" col-md-3 input" placeholder="Place" name="gonig_way_place[]" value="<?= $value?>"
                        type="text" required>
                    <select class="col-md-4 input" name="gonig_way_transport[]" required>
                        <option value="">Select transportation method</option>
                        <option <?= ($g_transportation_array[$key]=='CNG')? 'selected': '' ?> value="CNG">CNG</option>
                        <option <?= ($g_transportation_array[$key]=='rickshaw')? 'selected': '' ?> value="rickshaw">
                            Rickshaw</option>
                        <option <?= ($g_transportation_array[$key]=='car')? 'selected': '' ?> value="car">Car</option>
                        <option <?= ($g_transportation_array[$key]=='bus')? 'selected': '' ?> value="bus">Bus</option>
                        <option <?= ($g_transportation_array[$key]=='train')? 'selected': '' ?> value="train">Train
                        </option>
                        <option <?= ($g_transportation_array[$key]=='plane')? 'selected': '' ?> value="plane">Plane
                        </option>
                        <option <?= ($g_transportation_array[$key]=='Others')? 'selected': '' ?> value="Others">Others
                        </option>
                    </select>
                    <input class=" col-md-3 input" placeholder="Cost" name="gonig_way_costing[]"
                        value="<?= $g_costing_array[$key]?>" type="number" required>
                    <a href="#" class="remove-field sideb col-md-1 btn-remove-gonig_way"> - </a>
                </div>
                <?php   };
                } ?>
                <div class="going_way pway">
                    <input class=" col-md-3 input" placeholder="Place" name="gonig_way_place[]" type="text"
                        <?= (count($g_place_array)>0)? '': 'required' ?>>
                    <select class="col-md-4 input" name="gonig_way_transport[]"
                        <?= (count($g_place_array)>0)? '': 'required' ?>>
                        <option value="">Select transportation method</option>
                        <option value="CNG">CNG</option>
                        <option value="rickshaw">Rickshaw</option>
                        <option value="car">Car</option>
                        <option value="bus">Bus</option>
                        <option value="train">Train</option>
                        <option value="plane">Plane</option>
                        <option value="Others">Others</option>
                    </select>
                    <input class=" col-md-3 input" placeholder="Cost" name="gonig_way_costing[]" type="number"
                        <?= (count($g_place_array)>0)? '': 'required' ?>>
                    <a class="extra-fields-gonig_way col-md-1 sideb" href="#">+</a>
                </div>
                <div class="going_way_dynamic pway"></div>
            </div>
        </div>
        <div class="col-md-6 boxx">
            <span class="heading">Coming Way</span>
            <div class="col-md-12" style="padding: 12px;">
                <?php if(count($c_place_array)>0){
                    foreach ($c_place_array as $k => $v) {
                    ?>
                <div class="remove pway">
                    <input class=" col-md-3 input" placeholder="Place" name="coming_way_place[]" value="<?= $v?>"
                        type="text" required>
                    <select class="col-md-4 input" name="coming_way_transport[]" required>
                        <option value="">Select transportation method</option>
                        <option <?= ($c_transportation_array[$k]=='CNG')? 'selected': '' ?> value="CNG">CNG</option>
                        <option <?= ($c_transportation_array[$k]=='rickshaw')? 'selected': '' ?> value="rickshaw">
                            Rickshaw</option>
                        <option <?= ($c_transportation_array[$k]=='car')? 'selected': '' ?> value="car">Car</option>
                        <option <?= ($c_transportation_array[$k]=='bus')? 'selected': '' ?> value="bus">Bus</option>
                        <option <?= ($c_transportation_array[$k]=='train')? 'selected': '' ?> value="train">Train
                        </option>
                        <option <?= ($c_transportation_array[$k]=='plane')? 'selected': '' ?> value="plane">Plane
                        </option>
                        <option <?= ($c_transportation_array[$k]=='Others')? 'selected': '' ?> value="Others">Others
                        </option>
                    </select>
                    <input class=" col-md-3 input" value="<?= $c_costing_array[$k]?>" placeholder="Cost"
                        name="coming_way_costing[]" type="number" required>
                    <a href="#" class="remove-field sideb col-md-1 btn-remove-gonig_way"> - </a>
                </div>
                <?php   };
                } ?>
                <div class="coming_way pway">
                    <input class=" col-md-3 input" placeholder="Place" name="coming_way_place[]" type="text"
                        <?= (count($c_place_array)>0)? '': 'required' ?>>
                    <select class="col-md-4 input" name="coming_way_transport[]"
                        <?= (count($c_place_array)>0)? '': 'required' ?>>
                        <option value="">Select transportation method</option>
                        <option value="CNG">CNG</option>
                        <option value="rickshaw">Rickshaw</option>
                        <option value="car">Car</option>
                        <option value="bus">Bus</option>
                        <option value="train">Train</option>
                        <option value="plane">Plane</option>
                        <option value="Others">Others</option>

                    </select>
                    <input class=" col-md-3 input" placeholder="Cost" name="coming_way_costing[]" type="number"
                        <?= (count($c_place_array)>0)? '': 'required' ?>>
                    <a class="extra-fields-coming_way col-md-1 sideb" href="#">+</a>
                </div>
                <div class="coming_way_dynamic pway"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12" style="padding: 4px 22px;display: flex;gap: 25px;">
        <div class="col-md-12 boxx">
            <span class="heading">Additional Cost </span>
            <div class="col-md-12" style="display: flex;padding: 19px;">
                <input class="input" style="width: 48%;"
                    value="<?= isset($movedata->additional_cost) ? $movedata->additional_cost : '' ?>"
                    placeholder="Additional Cost " name="additional_cost" type="number">
                <label for="" style="padding: 10px;"> Add File :</label>
                <input class="" style="width: 38%;display: inline-block;padding: 11px;" placeholder="Invoice"
                    name="additional_invoice" accept=".gif, .jpg, .png, .pdf" type="file">
            </div>
        </div>
    </div>
    <?php if($move->status==6):?>
    <span style="padding: 0px 29px;font-size: 17px;font-weight: bold;">Return Comment : </span><br>
    <div class="col-md-12" style="padding: 4px 22px;display: flex;gap: 25px;">
        <textarea name="return_comment"  id="" style="width: 100%;height: 116px;border-radius: 5px;"
     
             readonly><?= isset($move->return_comment) ? $move->return_comment : '' ?></textarea>
    </div>
    <?php endif?>
    <span style="padding: 0px 29px;font-size: 17px;font-weight: bold;">Remark : </span><br>
    <div class="col-md-12" style="padding: 4px 22px;display: flex;gap: 25px;">
        <textarea name="remark" id="" style="width: 100%;height: 116px;border-radius: 5px;"
     
            ><?= isset($movedata->remark) ? $movedata->remark : '' ?></textarea>
    </div>
   
    <div class="col-md-12" style="padding: 2px 26px; display: flex; justify-content: flex-end; gap: 25px;">
        <input type="submit" value="Submit" class="btn"
            style="width: 151px;margin: 5px;background: #27eaff;color: black;font-weight: bold;">
    </div>
    </form>
</div>

<script>
$('.extra-fields-gonig_way').click(function() {
    $('.going_way').clone().appendTo('.going_way_dynamic');
    $('.going_way_dynamic .going_way').addClass('single remove');
    $('.single .extra-fields-gonig_way').remove();
    $('.single').append('<a href="#" class="remove-field sideb col-md-1 btn-remove-gonig_way"> - </a>');
    $('.going_way_dynamic > .single').attr("class", "remove");

    $('.going_way_dynamic input').each(function() {
        var count = 0;
        var fieldname = $(this).attr("name");
        $(this).attr('name', fieldname + count);
        count++;
    });

});

$(document).on('click', '.remove-field', function(e) {
    $(this).parent('.remove').remove();
    e.preventDefault();
});
</script>
<script>
$('.extra-fields-coming_way').click(function() {
    $('.coming_way').clone().appendTo('.coming_way_dynamic');
    $('.coming_way_dynamic .coming_way').addClass('single remove');
    $('.single .extra-fields-coming_way').remove();
    $('.single').append('<a href="#" class="remove-field sideb col-md-1 btn-remove-gonig_way"> - </a>');
    $('.coming_way_dynamic > .single').attr("class", "remove");

    $('.coming_way_dynamic input').each(function() {
        var count = 0;
        var fieldname = $(this).attr("name");
        $(this).attr('name', fieldname + count);
        count++;
    });

});

$(document).on('click', '.remove-field', function(e) {
    $(this).parent('.remove').remove();
    e.preventDefault();
});
</script>