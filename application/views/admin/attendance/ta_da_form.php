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
    .boxx{
        padding: 0px;
    border-radius: 5px;
    height: fit-content;
    box-shadow: 3px 4px 7px 4px rgb(0 0 0 / 10%);
    background: white;

    }
    .heading{
        color: #000;
        font-family: Roboto;
        font-size: 20px;
        font-style: normal;
        font-weight: bold;
        line-height: 22.5px;
        justify-content: center;
        background: #eeeeee;
        display: flex;
        text-transform: capitalize;
        border-radius: 5px 5px 0px 0px;
        padding: 9px;
        margin-bottom: 11px;
    }
</style>

<form action="<?= base_url('admin/attendance/add_ta_da') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="move_id" value="<?= $move_id ?>">
    <div class="col-md-12" style="padding: 26px;display: flex;gap: 25px;">
        <div class="col-md-6 boxx" >
            <span class="heading">Going Way</span>
            <div class="col-md-12">
                <div class="going_way pway">
                    <input class=" col-md-3 input" placeholder="Place" name="gonig_way_place[]" type="text" required>
                    <select class="col-md-4 input" name="gonig_way_transport[]" required>
                        <option value="">Select transportation method</option>
                        <option value="car">Car</option>
                        <option value="bus">Bus</option>
                        <option value="train">Train</option>
                        <option value="plane">Plane</option>
                    </select>
                    <input class=" col-md-3 input" placeholder="Cost" name="gonig_way_costing[]" type="number" required>
                    <a class="extra-fields-gonig_way col-md-1 sideb" href="#">+</a>
                </div>
                <div class="going_way_dynamic pway"></div>
            </div>
        </div>
        <div class="col-md-6 boxx" >
            <span class="heading">Coming Way</span>
            <div class="col-md-12">
                <div class="coming_way pway">
                    <input class=" col-md-3 input" placeholder="Place" name="coming_way_place[]" type="text" required>
                    <select class="col-md-4 input" name="coming_way_transport[]" required>
                        <option value="">Select transportation method</option>
                        <option value="car">Car</option>
                        <option value="bus">Bus</option>
                        <option value="train">Train</option>
                        <option value="plane">Plane</option>
                    </select>
                    <input class=" col-md-3 input" placeholder="Cost" name="coming_way_costing[]" type="number"
                        required>
                    <a class="extra-fields-coming_way col-md-1 sideb" href="#">+</a>
                </div>
                <div class="coming_way_dynamic pway"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12" style="padding: 26px;display: flex;gap: 25px;">
        <div class="col-md-12 boxx">
            <span class="heading">Additional Cost </span>
            <div class="col-md-12" style="display: flex;">
                <input class="input" style="width: 48%;" placeholder="Cost" name="additional_cost" type="number">
                <label for="" style="padding: 10px;"> Add File :</label>
                <input class="" style="width: 38%;display: inline-block;padding: 11px;" placeholder="Invoice"
                    name="additional_invoice" accept=".gif, .jpg, .png, .pdf" type="file">
            </div>
        </div>
    </div>
    <span style="padding: 0px 29px;font-size: 17px;font-weight: bold;">Remark : </span><br>
    <div class="col-md-12" style="padding: 2px 26px;display: flex;gap: 25px;">
        <textarea name="remark" id="" style="width: 100%;height: 116px;border-radius: 5px;"></textarea>
    </div>
    <div class="col-md-12" style="padding: 2px 26px; display: flex; justify-content: flex-end; gap: 25px;">
        <input type="submit" value="Submit" class="btn"
            style="width: 151px;margin: 5px;background: #27eaff;color: black;font-weight: bold;">
    </div>
</form>
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