<a href="<?= base_url('admin/lunch/emp_pay_list') ?>" class="btn btn-primary float-right">Get Payment</a>
<?= form_open(current_url(), array('id' => 'dateForm')); ?>
<h3 style="float: left;">Today Lunch</h3>
<?php $session = $this->session->userdata('username');
if($session['role_id']==1){?>
<div style="float: left;margin-left: 29px;margin-top: 22px;">
    <label for="date"> Enter Date</label>
    <input type="date" onchange="submitForm()" name="date" value="<?= isset($date) ? $date : date('Y-m-d'); ?>" style="border-radius: 5px;">
    <input type='hidden' id="ischange" name="change" value= 0>
</div>
<?php }else{?>

<input type="hidden" name="date" value="<?= date('d-m-Y'); ?>">
<?php } ?>
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
            <td><input type="number" name="m_amount[]"
                    value="<?= ($ps == 'no' && $raw->p_stutus == 'Present')? 1 : $set; ?>" style="width: 83px;"></td>
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
            <td><input type="number" name="guest" value="<?= isset($guest->guest_m) ? $guest->guest_m : ''; ?>"
                    style="width: 83px;"></td>
            <td><input type="text" name="guest_comment" value=""></td>
        </tr>
    </tbody>
</table>

<div class="form-group">
    <label>Comment</label>
    <textarea name="bigcomment" class="form-control" id="exampleFormControlTextarea1"
        rows="3"><?= isset($guest->bigcomment) ? $guest->bigcomment : ''; ?></textarea>
</div>
<div class="row">
    <div class="col-md-12">
        <input type="submit" value="Save" class="btn btn-primary pull-right">
    </div>
</div>

<?= form_close(); ?>

<script>
  function submitForm() {
    document.getElementById('ischange').value=1;
    document.getElementById('dateForm').submit();
  }
</script>
