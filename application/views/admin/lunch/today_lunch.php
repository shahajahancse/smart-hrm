<a href="<?= base_url('admin/lunch/emp_pay_list') ?>" class="btn btn-primary float-right">Get Payment</a>

<h3>Today Lunch</h3>

<?= form_open(current_url()); ?>
    <input type="hidden" name="date" value="<?= date('d-m-Y'); ?>">
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
            <?php $st = true; //dd($results); ?>

            <?php foreach ($results as $key => $raw) { 
                if (($raw->p_stutus == 'Absent' && $st == true) || $raw->p_stutus == 'absent' && $st == true) { ?>
                    <tr>
                        <td colspan="5">
                            <p style="font-size: 18px; color: black; background-color: aquamarine;">Inactive</p>
                        </td>
                    </tr>
                <?php $st = false; } ?>
                <tr>
                    <input type="hidden" name="empid[]" value="<?= $raw->emp_id ?>">
                    <input type="hidden" name="p_status[]" value="<?= $raw->p_stutus ?>">

                    <th scope="row"><?= $key + 1 ?></th>
                    <td><?=  $raw->first_name .' '. $raw->last_name; ?></td>
                    <td><?= $raw->p_stutus ?></td>
                    <?php $set = (isset($raw->meal_amount) && $raw->meal_amount != null) ? $raw->meal_amount : 0 ?>
                    <td><input type="number" name="m_amount[]" value="<?= ($ps == 'no' && $raw->p_stutus == 'Present')? 1 : $set; ?>" style="width: 83px;"></td>
                    <td><input type="text" name="comment[]" value="<?= isset($raw->comment) ? $raw->comment : ''; ?>"></td>
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
                <td><input type="number" name="guest" value="<?= isset($guest->guest_m) ? $guest->guest_m : ''; ?>" style="width: 83px;"></td>
                <td><input type="text" name="guest_comment" value=""></td>
            </tr>
        </tbody>
    </table>

    <div class="form-group">
        <label>Comment</label>
        <textarea name="bigcomment" class="form-control" id="exampleFormControlTextarea1" rows="3"><?= isset($guest->bigcomment) ? $guest->bigcomment : ''; ?></textarea>
    </div>
    <input type="submit" value="Save" class="btn btn-primary">
<?= form_close(); ?>
