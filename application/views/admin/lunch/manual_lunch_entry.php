    <!-- <a href="<?= base_url('admin/lunch/emp_pay_list') ?>" class="btn btn-primary float-right">Get Payment</a> -->

    <h4 style="padding:3px; margin-bottom:5px;"> Manually entry</h3>


        <?= form_open(current_url()); ?>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="from_date">From Date:</label>
                    <input type="date" class="form-control" name="from_date" value="<?= date('Y-05-14')?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" class="form-control" name="end_date" value="<?= date('Y-06-14')?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="end_date">Prev. Meal</label>
                    <input type="number" class="form-control" id="prev_meal" value="21">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="end_date">Probability Meal</label>
                    <input type="number" class="form-control" name="probability_meal" value="18">
                </div>
            </div>
        </div>

        <input type="hidden" name="date" value="<?= date('d-m-Y'); ?>">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">SL</th>
                    <th scope="col">Employee</th>
                    <th scope="col">Pay Meal</th>
                    <th scope="col">Pay Amount</th>
                    <th scope="col">Cost Meal</th>
                    <th scope="col">Cost Amount</th>
                    <th scope="col">Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php $sql = $this->db->select('user_id,first_name,last_name')->where_in('status', array(1,4,5))->get('xin_employees');
                $results = $sql->result(); ?>

                <?php foreach ($results as $key => $raw) { ?>

                <tr>
                    <input type="hidden" name="empid[]" value="<?= $raw->user_id ?>">


                    <th scope="row"><?= $key + 1 ?></th>
                    <td style="text-align: left !important;"><?=  $raw->first_name .' '. $raw->last_name; ?></td>

                    <td> <input type="number" class="form-control pay_meal" id="pm<?= $raw->user_id ?>"
                            onchange="changeFun(<?= $raw->user_id ?>)" name="pay_meal[]" value="21"></td>
                    <td> <input type="number" class="form-control pay_amount" id="pa<?= $raw->user_id ?>"
                            name="pay_amount[]" readonly value="<?=(21*45)?>"> </td>
                    <td> <input type="number" class="form-control cost_meal" id="cm<?= $raw->user_id ?>"
                            onchange="changeCos(<?= $raw->user_id ?>)" name="cost_meal[]"></td>
                    <td> <input type="number" class="form-control cost_amount" id="ca<?= $raw->user_id ?>"
                            name="cost_amount[]" readonly></td>
                    <td> <input type="number" class="form-control balance" id="bl<?= $raw->user_id ?>" name="balance[]">
                    </td>

                </tr>
                <?php } ?>
            </tbody> requird
        </table>


        <div class="row">
            <div class="col-md-12">
                <input type="submit" value="Save" class="btn btn-primary pull-right">
            </div>
        </div>

        <?= form_close(); ?>

        <script type="text/javascript">
        $(document).ready(function() {
            $("#prev_meal").on("change", function() {
                $(".pay_meal").val(Number($(this).val()));
                $(".pay_amount").val(Number($(this).val() * 45));
            });
        });

        function changeFun(id) {
            pm = 'pm' + id;
            pa = 'pa' + id;
            var pay_meal = document.getElementById(pm).value;
            var pay_amount = Number(pay_meal * 45);
            document.getElementById(pa).value = pay_amount;

            ca = 'ca' + id;
            bl = 'bl' + id;
            var cost_amount = document.getElementById(ca).value;
            var balance = Number(pay_amount - cost_amount);
            document.getElementById(bl).value = balance;
        }

        function changeCos(id) {
            cm = 'cm' + id;
            ca = 'ca' + id;
            var cost_meal = document.getElementById(cm).value;
            var cost_amount = Number(cost_meal * 45);
            document.getElementById(ca).value = cost_amount;


            pa = 'pa' + id;
            bl = 'bl' + id;
            var pay_amount = document.getElementById(pa).value;
            var balance = Number(pay_amount - cost_amount);
            document.getElementById(bl).value = balance;

        }
        </script>