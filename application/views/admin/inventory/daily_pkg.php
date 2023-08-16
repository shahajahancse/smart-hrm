<div class="container">
    <div class="row">
    <img src="<?= base_url('skin/img/loader.gif')?>" alt="loading" id="loader" style="height: 25px;width: 25px;display: none;">

        <div class="col-md-4">
            <div class="form-group">
                <select class="form-control" id="select_item" name="select_item" data-plugin="select_hrm"
                    placeholder="Search Item">
                    <option>
                        <-- Search Item -->
                    </option>
                    <?php foreach ($results as $key => $row) { ?>
                    <option value="<?= $row->id ?>">
                        <?= $row->category_name .' >> '. $row->sub_cate_name .' >> '. $row->product_name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-11">
            <div class="box" style="padding:10px;">
                <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
                <?php echo form_open(current_url(),$attributes);?>
                <table class="table table-bordered table-sm table-striped " id="appRowDiv">
                    <tr>
                        <th class="text-left" style="background: #bfedde;">Category Name</th>
                        <th class="text-left" style="background: #bfedde;">Sub Category Name</th>
                        <th class="text-left" style="background: #bfedde;">Product Name</th>
                        <th class="text-left" style="background: #bfedde;">Unit</th>
                        <th class="text-left" style="background: #bfedde;">Quantity</th>
                        <th class="text-left" style="background: #bfedde;">Action</th>
                    </tr>
                    <?php if(count($productdata)>0){
                    foreach($productdata as $d) {
                        ?>
                    <tr>
                        <input name="product_id[]" value="<?= $d->product_id ?>" type="hidden" required>
                        <input name="sub_cate_id[]" value="<?= $d->sub_cate_id ?>" type="hidden" required>
                        <input name="cat_id[]" value="<?= $d->cat_id ?>" type="hidden" required>
                        <input name="unit_name[]" value="<?= $d->unit_name ?>" type="hidden" required>
                        <td> <?= $d->category_name ?></td>
                        <td> <?= $d->sub_cate_name ?></td>
                        <td><?= $d->product_name ?></td>
                        <td> <?= $d->unit_name ?></td>
                        <td><input name="quantity[]" onchange="subfrom()" value="<?= $d->quantity ?>" class="form-control input-sm"
                                required /></td>

                        <td> <a class="label label-important text-danger" onclick="removeRow(this)"><span
                                    style="color:#a94442;font-size:12px">Remove</span> </a></td>
                    </tr>
                    <?php }} ?>
                </table>
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

    $('#select_item').change(function(e) {
        product_id = $(this).val();
        // console.log($(this).find('option[value="' +$(this).val() + '"]').text());
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/inventory/get_product_by_ajax/');?>" + product_id,
            success: function(response) {
                product_name = response.product_name;
                unit_name = response.unit_name;
                category_name = response.category_name;
                cat_id = response.cat_id;
                sub_cat_name = response.sub_cate_name;
                sub_cat_id = response.sub_cate_id;

                let items = '';
                items += '<tr>';
                items += '<input name="product_id[]" value="' + product_id +
                    '" type="hidden" required>';
                items += '<input name="sub_cate_id[]" value="' + sub_cat_id +
                    '" type="hidden" required>';
                items += '<input name="cat_id[]" value="' + cat_id +
                    '" type="hidden" required>';
                items += '<input name="unit_name[]" value="' + unit_name +
                    '" type="hidden" required>';

                items += '<td>' + category_name + '</td>';
                items += '<td>' + sub_cat_name + '</td>';
                items += '<td>' + product_name + '</td>';
                items += '<td>' + unit_name + '</td>';

                items +=
                    '<td><input name="quantity[]"  class="form-control input-sm " onchange="subfrom()" required /></td>';

                items +=
                    '<td> <a class="label label-important text-danger" onclick="removeRow(this)"><span style="color:#a94442;font-size:12px">Remove</span> </a></td>';
                items += '</tr>';
                $('#appRowDiv tr:last').after(items);
                subfrom();
            }
        });
    })
});

function removeRow(id) {
    $(id).closest("tr").remove();
    subfrom();
}

</script>
<script>
   function subfrom(){
        $('#loader').fadeIn();
        $.ajax({
            url: "<?php echo base_url('admin/inventory/add_daily_package/');?>", // Specify your API endpoint URL
            method: 'POST',
            data: $('#product-form').serialize(), // Send the form data
            success: function(response) {
                $('#loader').fadeOut();
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle any errors that occurred during the request
                console.error(errorThrown);
            }
        });
    };
</script>