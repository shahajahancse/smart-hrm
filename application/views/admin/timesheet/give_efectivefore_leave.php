

<table class="table table-striped table-bordered">
    <tr>
        <th>sl</th>
        <th>name</th>
        <th>Joining date</th>
        <th>active</th>
        <th>date</th>
    </tr>

    <form action="<?= base_url('admin/timesheet/give_efectivefore_leave_add') ?>" method="post">

    
        <?php foreach ($all_employee as $key => $value) { ?>
        <tr>
            <td><?= $key+1 ?> <input type="hidden" name="employee_id[]" value="<?= $value->user_id ?>"></td>
            <td><?= $value->first_name.' '.$value->last_name ?></td>
            <td><?= $value->date_of_joining?></td>
            <td><select name="is_leave_on[]">
                    <option value="0">Not Active</option>
                    <option value="1">Active</option>
                </select>
            </td>
            <td><input type="date" name="leave_effective[]"></td>
        </tr>
        <?php } ?>
    <tfoot>
        <tr>
            <td>
                <input type="submit" value="Submit">
            </td>
        </tr>
    </tfoot>
    </form>
</table>