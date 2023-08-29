<?php
// dd($all_clients)
?>
<style>
.switch {
    position: relative;
    display: inline-block;
    width: 68px;
    height: 19px;
    margin: 7px;
}

.switch input {
    display: none;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #3C3C3C;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 13px;
    width: 13px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 50%;
}

input:checked+.slider {
    background-color: #0E6EB8;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(47px);
}

/*------ ADDED CSS ---------*/
.slider:after {
    content: 'No';
    color: white;
    display: block;
    position: absolute;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    font-size: 10px;
    font-family: Verdana, sans-serif;
}

input:checked+.slider:after {
    content: 'Yes';
}

/*--------- END --------*/
</style>
<input type="hidden" name="projecttype" value=2>
<div style="display: flex;flex-direction: column;gap: 21px;">
    <div class="row">
        <h5>Software Section</h5>
        <div class="col-md-3">
            <div class="inputBox">
                <input required type="number" name="software_Budget" id="software_Budget" value=0 onkeyup="setinstallmentdate()">
                <strong>Software Budget<span style="color: red;">*</span></strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="inputBox">
                <input required type="number" name="instalment" id="instalment" value=1 onkeyup="setinstallmentdate()">
                <strong>Instalment<span style="color: red;">*</span></strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="inputBox">
                <input required type="date" value="<?= date('Y-m-d') ?>" name="start_date" id="start_date">
                <strong>Start Date<span style="color: red;">*</span></strong>
            </div>
        </div>
        <div class="col-md-3">
            <div class="inputBox">
                <input required="required" type="date" value="<?= date('Y-m-d') ?>" name="end_date" id="end_date"
                    onchange="getinstallmentfrom()">
                <strong>End Date<span style="color: red;">*</span></strong>
            </div>
        </div>
    </div>
    <div class="row">
        <h5>Installment Section</h5>
        <div id="installmentform" style="padding: 1px 22px;">
            <!-- <div class="col-md-6">
                <div class="inputBox">
                    <input required type="number" name="software_Budget">
                    <strong>Software Budget<span style="color: red;">*</span></strong>
                </div>
            </div> -->
        </div>
    </div>
    <div class="row">
        <h5>Hardware Section</h5>
        <div class="col-md-3">
            <div class="inputBox">
                <input required type="number" name="hardware_Budget" >
                <strong>Hardware Budget<span style="color: red;">*</span></strong>
            </div>
        </div>
        <div class="col-md-9">
            <div class="inputBox">
                <input required type="text" name="hardware_Summary">
                <strong>Hardware Summary<span style="color: red;">*</span></strong>
            </div>
        </div>
    </div>
    <div class="row">
        <h5 style="float: left;margin-right: 10px;">Service</h5>
        <label class="switch">
            <input type="checkbox" onchange="serviceEn(this)" name="serviceEnabled">
            <span class="slider"></span>
        </label>
        <div class="col-md-12" >
            <div class="row" id="service_section" style="padding: 6px;display: none;">
                <div class="col-md-3">
                    <div class="inputBox">
                        <select name="Service_type" id="Service_type" class="col-md-12">
                            <option>Select Service type</option>
                            <option value="1">Weekly</option>
                            <option value="2">Monthly</option>
                            <option value="3">Yarely</option>
                        </select>
                        <strong>Service type<b style="color: red;">*</b></strong>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="inputBox">
                        <div class="inputBox">
                            <input type="number" name="Service_amount" id="Service_amount">
                            <strong>Service Amount<span style="color: red;">*</span></strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="inputBox">
                        <div class="inputBox">
                            <input type="date" value="<?= date('Y-m-d') ?>" name="Service_Increment_Date"
                                id="Service_Increment_Date">
                            <strong>Next Increment Date<span style="color: red;">*</span></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h5>Description</h5>
        <div class="col-md-12">
            <div class="inputBox">
                <input required type="text" style="height: 85px;" name="description">
                <strong>Project Description<span style="color: red;">*</span></strong>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12" style="margin-top: 16px;" style="padding: 0;">
    <button type="submit" class="btn btn-primary" style="float: right;"> <i class="fa fa-check-square-o"></i>
        <?php echo $this->lang->line('xin_save');?> </button>
</div>
<script>
    setinstallmentdate()
</script>
<script>
function serviceEn(element) {
    if (element.checked) {
        console.log("Checkbox is checked");
        $('#service_section').animate({
            opacity: "show",
            height: "show",
            display: "inline-block"
        });
        $('#Service_type').attr('required', true);
        $('#Service_amount').attr('required', true);
        $('#Service_Increment_Date').attr('required', true);
    } else {
        $('#service_section').animate({
            opacity: "hide",
            height: "hide"
        });
        $('#Service_type').removeAttr('required');
        $('#Service_amount').removeAttr('required');
        $('#Service_Increment_Date').removeAttr('required');
    }
}
</script>