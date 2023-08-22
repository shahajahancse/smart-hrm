<style>
.table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ddd;
}

.table th,
.table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    font-weight: bold;
    background-color: #f2f2f2;
}

.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table input[type="checkbox"] {
    transform: scale(1.5);
    margin-left: 5px;
}
</style>
<div class="box">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Active Lunch</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $key => $row) { ?>
            <?php if ($row->active_lunch == 1) { ?>
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
                <td>
                    <input onclick="setlunch(this)" id="<?=$row->user_id?>"
                        data-status="<?php echo $row->active_lunch ? 1 : 0; ?> " type="checkbox" checked>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
            <tr>
                <th colspan="3" class="text-danger text-center">In Active</th>
            </tr>
            <?php foreach ($result as $key => $row) { ?>
            <?php if (!$row->active_lunch == 1) { ?>
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $row->first_name . ' ' . $row->last_name; ?></td>
                <td>
                    <input onclick="setlunch(this)" id="<?=$row->user_id?>"
                        data-status="<?php echo $row->active_lunch ? 1 : 0; ?> " type="checkbox">
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>

</div>
<script>
function setlunch(e) {
    status = e.dataset.status;
    let replace_status = (status == 1) ? 0 : 1;
    e.dataset.status = replace_status;

    var dataToSend = {
        replace_status: replace_status,
        id: e.id
    };

    var url = "<?= base_url('admin/lunch/change_lunch_status') ?>";

    // Make the AJAX request
    $.ajax({
        url: url,
        type: "POST",
        data: dataToSend,
        success: function(response) {
            console.log(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle any errors that occurred during the request
            console.error("Error:", textStatus, errorThrown);
        }
    });
}
</script>