<?php

// dd($all_clients)

?>

<style>
.p-5 {
    padding: 5px;
}

.m-0 {
    margin: 0;
}

.inputBox {
    position: relative;
}

.inputBox input {
    padding: 6px 20px;
    outline: none;
    background: transparent;
    border-radius: 5px;
    color: #000;
    border: 1px solid #7a7a7a;
    font-size: 1em;
}

.inputBox select {
    padding: 6px 20px;
    outline: none;
    background: transparent;
    border-radius: 5px;
    color: #000;
    border: 1px solid #7a7a7a;
    font-size: 1em;
}


.inputBox strong {
    position: absolute;
    left: 0;
    padding: 9px 14px;
    pointer-events: none;
    font-size: 1em;
    transition: 0.4s cubic-bezier(0.05, 0.81, 0, 0.93);
    color: #000000;
    letter-spacing: 0.1em;
    font-weight: 400 !important;
    z-index: 11111;

}



.inputBox input:focus~strong,
.inputBox input:valid~strong {
    font-size: 0.8em;
    transform: translateX(9px) translateY(-10.5px);
    padding: 0 5px;
    border-radius: 2px;
    background: #fff;
    letter-spacing: 0em;

}

.inputBox select:focus~strong,
.inputBox select:valid~strong {
    font-size: 0.8em;
    transform: translateX(9px) translateY(-10.5px);
    padding: 0 5px;
    border-radius: 2px;
    background: #fff;
    letter-spacing: 0em;

}

.nav-tabs>li.active>a,
.nav-tabs>li.active>a:focus,
.nav-tabs>li.active>a:hover {
    color: #000;
    cursor: default;
    background-color: #cbcbcb;
    border: 1px solid #ddd;
    border-bottom-color: transparent;

}
</style>
<div class="box col-md-12 p-5 m-0">
    <h4>Project Add Form</h4>
    <div class="col-md-12" style="margin-top: 13px;">
        <?php $attributes = array('name' => 'add_project', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php echo form_open('admin/project/add_project', $attributes);?>
        <div class="col-md-12 bg-white">
            <div class="col-md-3">
                <div class="inputBox">
                    <input required type="text">
                    <strong>Project name <b style="color: red;">*</b></strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inputBox">
                    <input required type="text">
                    <strong>Project Id<b style="color: red;">*</b></strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inputBox">
                    <select name="" id="client-select" class="col-md-12">
                        <option>Select A Client</option>
                        <?php foreach ($all_clients as $client): ?>
                        <option value="<?= $client->client_id ?>"><?= $client->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <strong>Project Id<b style="color: red;">*</b></strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inputBox">
                    <select name="" id="client-select" class="col-md-12">
                        <option>Select A Employee</option>
                        <?php foreach ($all_employees as $emp): ?>
                        <option value="<?= $emp->user_id ?>"><?= $emp->first_name ?> <?= $emp->last_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <strong>Project Id<b style="color: red;">*</b></strong>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 16px;" style="padding: 0;">
            <ul class="nav nav-tabs col-md-12" style="padding: 0;">
                <li class="col-md-6" style="padding: 0;"><a style="text-align: center;" onclick="getFromClient(1)"
                        data-toggle="tab" href="#gov">Government Project</a></li>
                <li class="col-md-6" style="padding: 0;"><a style="text-align: center;" onclick="getFromClient(2)"
                        data-toggle="tab" href="#nongov">Non Government Project</a></li>
            </ul>

            <div class="tab-content">
                <div id="gov" class="tab-pane fade">
                    <div id="govfrom"
                        style="margin: 41px 0px 0px 0px;padding: 13px 14px 14px 15px;background: #f4f4f4;">
                    </div>
                </div>
                <div id="nongov" class="tab-pane fade">
                    <div id="nongovfrom"
                        style="margin: 41px 0px 0px 0px;padding: 13px 14px 14px 15px;background: #f4f4f4;">
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>
<script>
function getFromClient(type) {
    $.ajax({
        url: '<?= base_url('admin/project/getFromClient') ?>',
        type: 'POST', // or 'GET' depending on your API
        data: {
            type: type
        },
        success: function(response) {
            console.log(response);
            if (type === 1) {
                $('#govfrom').html(response)
            } else if(type === 2) {
                $('#nongovfrom').html(response)
            }
        },
        error: function(error) {
            // Handle error response
        }
    });
}
</script>

<script>
$(document).ready(function() {
    $('#client-select').select2();
});
</script>