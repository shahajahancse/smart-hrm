<style>
.dropdown-item {
    padding: 4px;
    margin: 5px;
    width: 72px;
    height: 28px;
    text-align: center;
    border: 1px solid #0177bc;
    border-radius: 4px;
    /* New style for dropdown-item */
    background-color: #f8f9fa;
    color: #212529;
    transition: box-shadow 0.3s, color 0.3s;
}

.dropdown-item:hover {
    /* Hover effect */
    box-shadow: 0 0 5px #0177bc;
    color: #fff;
}

.dropdown-menu {
    min-width: 85px !important;
}

.btn {
    padding: 3px !important;
}
tr {
    border: 1px solid #e0e0e0;
}

th {}

td {}
.serchbox {
    padding: 18px;
    display: flex;
    background: white;
    flex-direction: row;
    margin-bottom: 13px;
    gap: 62px;
    border-radius: 6px;
    box-shadow: 0px 0px 13px 0px #dddddd;
}

.inputb {
    height: 34px;
    padding: 8px;
    width: 100%;
    border-radius: 6px;
    border: 0;
    box-shadow: inset 4px 2px 20px 3px #dcdcdc;
}
</style>


<div class="container-fluid" style="display: flex;flex-direction: column;">
    <?php if($this->session->flashdata('message')):?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('message');?>
    </div>
    <?php endif; ?>
    <div>
        <div class="col-md-6 card">
            <h4 class="card-title" style="text-align: center;margin: 7px 0px 0px 0px;">Summary Of
             <span style="color: blue;" id="f_date" ></span> to 
             <span style="color: blue;" id="l_date" ></span></h4>
            <div class="card-body" style="margin: 0;padding: 5px 0px 9px 0px;">

                <table class="col-md-6">
                    <tr>
                        <th style="padding: 3px;">Total Meal</th>
                        <td style="padding: 3px;">:</td>
                        <td style="padding: 3px;" id="t_m"></td>
                    </tr>
                    <tr>
                        <th style="padding: 3px;">Employee Meal</th>
                        <td style="padding: 3px;">:</td>
                        <td style="padding: 3px;" id="e_m"></td>
                    </tr>
                    <tr>
                        <th style="padding: 3px;">Guest Meal</th>
                        <td style="padding: 3px;">:</td>
                        <td style="padding: 3px;" id="g_m"></td>
                    </tr>
                </table>

                <table class="col-md-6">
                    <tr>
                        <th style="padding: 3px;">Total Amount</th>
                        <td style="padding: 3px;">:</td>
                        <td style="padding: 3px;" id="t_a"></td>
                    </tr>
                    <tr>
                        <th style="padding: 3px;">Employee Amount</th>
                        <td style="padding: 3px;">:</td>
                        <td style="padding: 3px;" id="e_a"></td>
                    </tr>
                    <tr>
                        <th style="padding: 3px;">Guest Amount</th>
                        <td style="padding: 3px;">:</td>
                        <td style="padding: 3px;" id="g_a"></td>
                    </tr>
                  
                </table>


            </div>
        </div>
    </div>

    <div class="table-responsive">
        <div class="col-md-12 serchbox">
            <div>
                <label for="">First Date</label>
                <input class="inputb" onchange="calmeal()" type="date" name="" id="from_date"
                    max="<?php echo date('Y-m-d'); ?>" value="<?= $first_date?>">
            </div>
            <div>
                <label for=""> Last Date</label>
                <input class="inputb" type="date" onchange="calmeal()" name="" id="to_date"
                    max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div>
                <label for="">Total Meal</label>
                <input class="inputb" type="text" name="" id="total_meals" disabled>
            </div>
            <div>
                <label for="">Employee Meal</label>
                <input class="inputb" type="text" name="" id="total_emp_m" disabled>
            </div>
            <div>
                <label for="">Guest Meal</label>
                <input class="inputb" type="text" name="" id="total_ge_m" disabled>
            </div>
            <div>
                <label for="">Total Amount</label>
                <input class="inputb" type="text" name="" id="total_amounts" disabled>
            </div>
        </div>
        
        <div class="card" id="add_table" style="padding: 14px;">

        </div>
    </div>
</div>

<script>
function hrp(id, status) {
    console.log(id, status);
    $.ajax({
        url: '<?= base_url('admin/lunch/sethrp') ?>', // Replace with the URL to send the request
        method: 'POST', // Replace with the desired HTTP method (POST, GET, etc.)
        data: {
            id: id,
            status: status,
        },
        success: function(response) {
            showSuccessAlert(response);         
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });

}
</script>
<script>
function calmeal() {
    var first_date = $('#from_date').val();
    var second_date = $('#to_date').val();
    var url = '<?= base_url('/admin/lunch/get_data_list/')?>';

    var data = {
        first_date: first_date,
        second_date: second_date
    };

    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function(response) {
            var total = response.total;
            $('#total_meals').val(total.total_m);
            $('#total_emp_m').val(total.total_emp_m);
            $('#total_ge_m').val(total.total_ge_m);
            $('#total_amounts').val(total.total_cost);
            $('#f_date').html(total.first_date);
            $('#l_date').html(total.second_date);
            $('#e_m').html(total.total_emp_m);
            $('#t_m').html(total.total_m);
            $('#g_m').html(total.total_ge_m);
            $('#t_a').html(total.total_cost);
            $('#e_a').html(total.total_emp_cost);
            $('#g_a').html(total.total_ge_cost);
            $('#add_table').html(response.tolunch_list_tabletal);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}
</script>
<script>
$(document).ready(function() {
    calmeal();
});
</script>