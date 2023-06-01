<h3>Today Lunch</h3>

<?= form_open('admin/lunch/add_lunch'); ?>
<input type="hidden" name="date" value="<?= $date ?>">
<table class="table table-hover" style="text-align-last: center;">
    <thead>
        <tr>
            <th scope="col">SL</th>
            <th scope="col">Name</th>
            <th scope="col">P.Status</th>
            <th scope="col">M.Amount</th>
            <th scope="col">Comment</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($active as $key => $raw) { ?>
            <tr>
                <input type="hidden" name="empid[]" value="<?= isset($raw->emp_id) ? $raw->emp_id : (isset($raw->user_id) ? $raw->user_id : null); ?>">
                <th scope="row"><?= $key + 1 ?></th>
                <?php
                if (!isset($raw->emp_id)) {
                ?>
                    <td><?= isset($raw->first_name) ? $raw->first_name : '' ?> <?= isset($raw->last_name) ? $raw->last_name : '' ?></td>
                <?php
                } else {
                    $empd = $this->Attendance_model->get_employee($raw->emp_id);
                    if (isset($empd[0]->first_name) && isset($empd[0]->last_name)) {
                ?>
                        <td><?= $empd[0]->first_name ?> <?= $empd[0]->last_name ?></td>
                    <?php
                    } else {
                    ?>
                        <td>No Employee Data Available</td>
                <?php
                    }
                }
                ?>
                <td>Present</td>
                <input type="hidden" name="p_status[]" value="present">
                <td><input type="number" name="m_amount[]" value="<?= isset($raw->meal_amount) ? $raw->meal_amount : '1' ?>" style="width: 83px;"></td>
                <td><input type="text" name="comment[]" value="<?= isset($raw->comment) ? $raw->comment : ''; ?>"></td>
            </tr>
        <?php } ?>

        <tr>
            <td colspan="5">
                <p style="font-size: 18px; color: black; background-color: aquamarine;">Inactive</p>
            </td>
        </tr>

        <?php foreach ($inactive as $key => $data) { ?>
            <tr>
                <input type="hidden" name="empid[]" value="<?= isset($data->emp_id) ? $data->emp_id : (isset($data->user_id) ? $data->user_id : '') ?>">
                <th scope="row"><?= $key + 1 ?></th>
                <?php
                if (!isset($data->emp_id)) {
                ?>
                       <td><?= isset($data->first_name) ? $data->first_name : '' ?> <?= isset($data->last_name) ? $data->last_name : '' ?></td>
                <?php
                } else {
                    $empd = $this->Attendance_model->get_employee($data->emp_id);
                    if (isset($empd[0]->first_name) && isset($empd[0]->last_name)) {
                ?>
                        <td><?= $empd[0]->first_name ?> <?= $empd[0]->last_name ?></td>
                    <?php
                    } else {
                    ?>
                        <td>No Employee Data Available</td>
                <?php
                    }
                }
                ?>
                <td>Absent</td>
                <input type="hidden" name="p_status[]" value="absent">
                <td><input type="number" name="m_amount[]" value="<?= isset($data->meal_amount) ? $data->meal_amount : '0' ?>" style="width: 83px;"></td>
                <td><input type="text" name="comment[]" value="<?= isset($data->comment) ? $data->comment : '' ?>"></td>
            </tr>
        <?php } ?>

        <tr>
            <td colspan="5">
                <p style="font-size: 18px; color: black; background-color: aquamarine;">Guest</p>
            </td>
        </tr>
        <tr>
            <th scope="row">1</th>
            <td>Guest</td>
            <td>-</td>
            <td><input type="number" name="guest" value="<?= isset($guest[0]->meal_amount) ? $guest[0]->meal_amount : '0' ?>" style="width: 83px;"></td>
            <td><input type="text" name="guest_comment" value="<?= isset($guest[0]->comment) ? $guest[0]->comment : '0' ?>"></td>
        </tr>
    </tbody>
</table>

<div class="form-group">
    <label>Comment</label>
    <textarea name="bigcomment" class="form-control" id="exampleFormControlTextarea1" rows="3"><?= isset($bigcom) ? $bigcom : '0' ?></textarea>
</div>
<input type="submit" value="Save" class="btn btn-primary">
<?= form_close(); ?>
