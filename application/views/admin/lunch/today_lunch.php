<style>
.error-border {
    border: 2px solid red;
}

td {
    text-transform: capitalize;
}

#loading {
    visibility: hidden;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 3;
    /* set z-index higher than other elements */
    background-color: rgba(255, 255, 255, 0.8);
    /* semi-transparent background */
}

#loading img {
    position: absolute;
    top: 50%;
    left: 50%;
}
</style>
<div id="loading">

    <img src="<?php echo base_url()?>skin/hrsale_assets/img/loding.gif">

</div>
<!--  -->
<!-- Modal -->
<div id="lunchoffmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Lunch Off</h4>
            </div>
            <div class="modal-body">
                <form id="lunch-form">
                    <span style="font-size: 16px;font-weight: bold;">Reason</span>
                    <textarea name="reason" id="reason" cols="70" style="width: 100%; border-radius: 5px;" rows="4"
                        required></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" id="submit-btn">Submit</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>


    </div>
</div>
<?= form_open(current_url(), array('id' => 'dateForm')); ?>
<h3 style="float: left;">Today Lunch</h3>
<?php $session = $this->session->userdata('username');
if($session['role_id']==1 || $session['role_id']==2 ){?>
<div style="float: left;margin-left: 29px;margin-top: 22px;">
    <label for="date"> Enter Date</label>
    <input type="date" id="dateoff" onchange="submitForm()" name="date" value="<?= isset($date) ? $date : date('Y-m-d'); ?>" style="border-radius: 5px;" max="<?php echo date('Y-m-d');?>" >
    <input type='hidden' id="ischange" name="change" value=0>
</div>
<?php }else{?>

<input type="hidden" id="dateoff" name="date" value="<?= isset($date) ? $date : date('Y-m-d'); ?>">
<?php } ?>
<p style="margin: 25px -23px 0px 14px;padding: 0;display: inline-block;float: left;font-weight: bold;">Total Meal</p>
<input style="float: left;margin-left: 29px;margin-top: 22px;width: 61px;text-align: center;border-radius: 3px;"
    type="number" id="summeale" value="0">
<button type="button" class="btn btn-info" data-toggle="modal" style="float: right;" data-target="#lunchoffmodal">Lunch
    Off</button>

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
        <?php $st = true; ?>
        <?php foreach ($results as $key => $raw) { 
                if (($raw->p_stutus == 'Absent' && $st == true) || $raw->p_stutus == 'absent' && $st == true) { ?>
        <tr>
            <td colspan="5">
                <p style="font-size: 18px; color: black; background-color: aquamarine;">Absent</p>
            </td>
        </tr>
        <?php $st = false; }  ?>
        <?php $ss=$this->db->where('employee_id',$raw->emp_id)->where('date',$date)->get('xin_employee_move_register')->row();?>
        <tr>
            <input type="hidden" name="empid[]" value="<?= $raw->emp_id ?>">
            <input type="hidden" name="p_status[]" value="<?= $raw->p_stutus ?>">
            <th scope="row"><?= $key + 1 ?></th>
            <td><?=  $raw->first_name .' '. $raw->last_name; ?></td>
            <td><?= $raw->p_stutus ?> <?= !empty($ss)?'<span style="color:red;">(Meeting)</span>':'' ?></td>

                <?php 
                 $pay_status=''; 
                if (isset($raw->meal_amount) && $raw->meal_amount != null) {
                    $set = $raw->meal_amount;
                    $this->load->model("Lunch_model");
                    $emp_data = $this->Lunch_model->get_payment_status($raw->emp_id, $date);
                    if ($emp_data == 0) {
                        $pay_status='<span style="color:red;">Not Paid</span>';
                    }
                } else {
                    if ($raw->p_stutus == 'Present' && !isset($raw->meal_amount)) {
                        $set = 1;
                    } else {
                        $set = 0;
                    }
                    $this->load->model("Lunch_model");
                    $emp_data = $this->Lunch_model->get_payment_status($raw->emp_id, $date);
                    if ($emp_data == 0) {
                        $set = 0;
                        $pay_status='<span style="color:red;">Not Paid</span>';
                    }
                }





                ?>         
                   <td>
                    <?= $pay_status ?>
                <input
                 max="1"
                 min="0"
                 type="number"
                 onchange="summeal()"
                 <?= ($raw->p_stutus == 'Present')? 'class="all_meal activmeal"'  : 'class="activmeal"'; ?>
                 name="m_amount[]"
                    value="<?= $set; ?>" style="width: 83px;">
                </td>
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

            <td>
                <input type="number" name="guest" min="0" id="guest-input" onchange="summeal()" class="activmeal"
                    value="<?= isset($guest->guest_m) ? $guest->guest_m : '0'; ?>" style="width: 83px;">
            </td>
            <td>
                <input type="text" name="guest_comment" id="guest-comment" value="<?= isset($guest->guest_ref_comment) ? $guest->guest_ref_comment : ''; ?>">
            </td>
        </tr>
    </tbody>
</table>

<div class="form-group">
    <label>Comment</label><br>
    <span id="is_requard" style="color: red;display: none;"> Comment is required</span>
    <textarea name="bigcomment" class="form-control" id="bigcomment"
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
    $('#ischange').val(1);
    $('#dateForm').submit();
}
$(document).ready(function() {
    $('#submit-btn').click(function() {
        var reason = $('#reason').val();
        if (reason !== '') {
            $('#lunchoffmodal').hide();
            document.getElementById("loading").style.visibility = "visible";
            var reasonValue = document.getElementById('reason').value;
            var dateoffValue = document.getElementById('dateoff').value;
            var url = '<?= base_url('admin/lunch/lunch_off') ?>';
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    reason: reasonValue,
                    dateoff: dateoffValue
                },
                success: function(response) {
                    // Hide the modal
                    document.getElementById("loading").style.visibility = "hidden";
                    showSuccessAlert('Success')
                    window.location.href = "<?= base_url('admin/lunch/') ?>"
                },
                error: function(xhr, status, error) {
                    // Handle the error response from the server
                    console.error(error);
                    document.getElementById("loading").style.visibility = "hidden";
                }
            });
        } else {
            // Add red border to the textarea
            $('#reason').addClass('error-border');
        }
    });

    // Remove red border when the textarea is focused
    $('#reason').focus(function() {
        $(this).removeClass('error-border');
    });
});
</script>
<script>
const guestInput = document.getElementById('guest-input');
const guestCommentInput = document.getElementById('guest-comment');

guestInput.addEventListener('input', () => {
    if (guestInput.value > 0) {
        guestCommentInput.required = true;
    } else {
        guestCommentInput.required = false;
    }
});
</script>
<script>
function summeal() {
    var elements = document.getElementsByClassName("activmeal");
    var all_meal = 0;

    for (var i = 0; i < elements.length; i++) {
        var elementData = parseFloat(elements[i].value);
        all_meal += elementData;
    }

    console.log(all_meal);
    document.getElementById('summeale').value = all_meal;

}
</script>

<script>
summeal()
</script>