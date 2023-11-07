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
    width: 100%;
}

.inputBox input {
    padding: 6px 20px;
    outline: none;
    background: transparent;
    border-radius: 5px;
    color: #000;
    border: 1px solid #7a7a7a;
    font-size: 1em;
    width: 100%;
}

.inputBox select {
    padding: 6px 20px;
    outline: none;
    background: transparent;
    border-radius: 5px;
    color: #000;
    border: 1px solid #7a7a7a;
    font-size: 1em;
    width: 100%;
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

.box {
    box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.03), 0 1px 4px 0 rgba(0, 0, 0, 0.04), 0 3px 1px -2px rgba(0, 0, 0, 0.04) !important;
}

.loader {
    position: relative;
    width: 100%;
    height: 130px;
    margin-bottom: 10px;
    border: 1px solid #d3d3d3;
    padding: 8px;
    background-color: #e3e3e3;
    overflow: hidden;
}

.loader:after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: linear-gradient(110deg, rgba(227, 227, 227, 0) 0%, rgba(227, 227, 227, 0) 40%, rgba(227, 227, 227, 0.5) 50%, rgba(227, 227, 227, 0) 60%, rgba(227, 227, 227, 0) 100%);
    animation: gradient-animation_2 1.2s linear infinite;
}

.loader .wrapper {
    width: 100%;
    height: 100%;
    position: relative;
}

.loader .wrapper>div {
    background-color: #cacaca;
}

.loader .circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.loader .button {
    display: inline-block;
    height: 32px;
    width: 75px;
}

.loader .line-1 {
    position: absolute;
    top: 11px;
    left: 58px;
    height: 10px;
    width: 100px;
}

.loader .line-2 {
    position: absolute;
    top: 34px;
    left: 58px;
    height: 10px;
    width: 150px;
}

.loader .line-3 {
    position: absolute;
    top: 57px;
    left: 0px;
    height: 10px;
    width: 100%;
}

.loader .line-4 {
    position: absolute;
    top: 80px;
    left: 0px;
    height: 10px;
    width: 92%;
}

@keyframes gradient-animation_2 {
    0% {
        transform: translateX(-100%);
    }

    100% {
        transform: translateX(100%);
    }
}

.swal2-container {
    z-index: 11111;
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
    transform: translate(-50%, -50%);
}

.sbtn {
    background: #2393e3eb;
    color: white;
    margin-right: 10px;
    padding: 6px 10px !important;
    margin-top: 13px;
}

#loading {

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

<div class="box col-md-12 p-5 m-0">
    <h4>Project Add Form</h4>
    <div class="col-md-12" style="margin-top: 13px;">
        <?php $attributes = array('name' => 'add_project', 'id' => 'add_project_form', 'autocomplete' => 'off');?>
        <?php echo form_open('', $attributes);?>
        <div class="col-md-12 bg-white">
            <div class="col-md-3">
                <div class="inputBox">
                    <input required type="text" name="title">
                    <strong>Project name <b style="color: red;">*</b></strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inputBox">
                    <select name="client_id" id="client-select" class="col-md-12">
                        <option>Select A Client</option>
                        <?php foreach ($all_clients as $client): ?>
                        <option value="<?= $client->client_id ?>"><?= $client->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <strong>Client<b style="color: red;">*</b></strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inputBox">
                    <select name="assigned_to" id="emp-select" class="col-md-12">
                        <option>Select A Employee</option>
                        <?php foreach ($all_employees as $emp): ?>
                        <option value="<?= $emp->user_id ?>"><?= $emp->first_name ?> <?= $emp->last_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <strong>Responsible persons<b style="color: red;">*</b></strong>
                </div>
            </div>
            <div class="col-md-3">
                <div class="inputBox">
                    <select name="priority" id="Priority-select" class="col-md-12">
                        <option>Select Priority Level</option>
                        <option value="1"><?php echo $this->lang->line('xin_highest');?></option>
                        <option value="2"><?php echo $this->lang->line('xin_high');?></option>
                        <option value="3"><?php echo $this->lang->line('xin_normal');?></option>
                        <option value="4"><?php echo $this->lang->line('xin_low');?></option>
                    </select>
                    <strong>Priority Level<b style="color: red;">*</b></strong>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 16px;" style="padding: 0;">
            <ul class="nav nav-tabs col-md-12" style="padding: 0;">
                <li class="col-md-6" style="padding: 0;"><a style="text-align: center;" onclick="getFromClient(1)"
                        data-toggle="tab" href="#gov">Government Project</a></li>
                <li class="col-md-6" style="padding: 0;"><a style="text-align: center;" onclick="getFromClient(2)"
                        data-toggle="tab" href="#nongov">Private Project</a></li>
            </ul>
            <div class="tab-content">
                <div id="gov" class="box tab-pane fade" style="overflow: hidden;padding: 0px 6px 12px 6px;">
                    <div id="govfrom" style="margin:0px;padding: 13px 14px 14px 15px;background: #ffffff;">
                        <div class="loader">
                            <div class="wrapper">
                                <div class="circle"></div>
                                <div class="line-1"></div>
                                <div class="line-2"></div>
                                <div class="line-3"></div>
                                <div class="line-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="nongov" class="box tab-pane fade" style="overflow: hidden;padding: 0px 6px 12px 6px;">
                    <div id="nongovfrom"
                        style="margin: 5px 0px 0px 0px;padding: 13px 14px 14px 15px;background: #ffffff;">
                        <div class="loader">
                            <div class="wrapper">
                                <div class="circle"></div>
                                <div class="line-1"></div>
                                <div class="line-2"></div>
                                <div class="line-3"></div>
                                <div class="line-4"></div>
                            </div>
                        </div>
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
        type: 'POST',
        data: {
            type: type
        },
        success: function(response) {
            $('#govfrom').empty();
            $('#nongovfrom').empty();
            if (type === 1) {
                $('#govfrom').fadeOut('fast', function() {
                    $('#govfrom').html(response).fadeIn('fast');
                });
            } else if (type === 2) {
                $('#nongovfrom').slideUp('fast', function() {
                    $('#nongovfrom').html(response).slideDown('fast');
                });
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
    $('#emp-select').select2();
});
</script>
<script>
$('#add_project_form').submit(function(event) {
    event.preventDefault(); // Prevent the default form submission
    document.getElementById("loading").style.visibility = "visible";

    var formData = $(this).serialize(); // Serialize the form data

    $.ajax({
        url: '<?= base_url('admin/project/add_project_n') ?>', // Replace with your actual API endpoint
        type: 'POST',
        data: formData,
        success: function(response) {
            document.getElementById("loading").style.visibility = "hidden";

            console.log(response);
            if (response) {
                var urlgo = '<?= base_url('admin/project') ?>';
                showSuccessAlert('Success', urlgo)
            } else {
                showErrorAlert('Error')
            };
        },
        error: function(xhr, status, error) {
            // Handle any errors here
            console.error(error);
        }
    });
});
</script>

<script>
function setinstallmentdate() {
    var instalment = parseInt($('#instalment').val()); // Convert to a number
    var start_date = $('#start_date').val();

    if (!isNaN(instalment) && start_date) {
        var startDateObj = new Date(start_date);
        startDateObj.setDate(startDateObj.getDate() + instalment);
        var formattedEndDate = formatDate(startDateObj);
        $('#end_date').val(formattedEndDate);
    }
}
</script>