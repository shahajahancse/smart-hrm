<?php
/* Attendance view
 */
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<style>
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
    <img src="<?php echo base_url() ?>skin/hrsale_assets/img/loding.gif">
</div>
<div class="col-lg-12">
    <div class="box mb-4 <?php echo $get_animate; ?>">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="process_date">First Date</label>
                                <input class="form-control attendance_date"
                                    placeholder="<?php echo $this->lang->line('xin_select_date'); ?>" id="process_date"
                                    name="process_date" type="text" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="process_date">Second Date</label>
                                <input class="form-control attendance_date"
                                    placeholder="<?php echo $this->lang->line('xin_select_date'); ?>" id="second_date"
                                    name="second_date" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="upload_file">Payment For</label>
                                <select class="form-control" name="payment_for" id="payment_for">
                                    <option value="">Select one</option>
                                    <option value="1">Software Payment</option>
                                    <option value="2">Service Payment</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="upload_file">Payment Type</label>
                                <select class="form-control" name="payment_type" id="payment_type">
                                    <option value="">Select one</option>
                                    <option value="1">Installment</option>
                                    <option value="2">Weekly</option>
                                    <option value="3">Monthly</option>
                                    <option value="4">Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box <?php echo $get_animate; ?>">
        <div class="box-header with-border" id="report_title">
            <h3 class="box-title" id="report"> Account Report
            </h3>
        </div>
        <div class="box-body" id="emp_report">
            <ul class="nav nav-tabs " id="myTab" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link " id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily"
                        aria-selected="true">Payment In </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="continue-tab" data-toggle="tab" href="#continue" role="tab"
                        aria-controls="payment" aria-selected="false">Payment Out</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab"
                    style="margin-top: 30px;">
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="payment_in(1)">Daily</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="payment_in(2)">continuously</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="client_list()">Client List</button>
                </div>
                <div class="tab-pane fade" id="continue" role="tabpanel" aria-labelledby="continue-tab"
                    style="margin-top: 30px;">
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="payment_out(1)">Daily</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="payment_out(2)">continuously</button>
                </div>
            </div>
        </div>
        <div class="box-body" id="entry_form">
        </div>
    </div>
</div>
<script>

// var url=base_url;
// var parts = url.split('/');
// var lastUri = parts[parts.length - 1];
// var firstUri = parts[2];
// if (lastUri == 'reports') {
//   if (firstUri == 'localhost') { 
//     base_url = 'http://localhost/smart-hrm/admin/accounting/';
//   } else {
//     base_url = 'http://173.212.223.213/smarthr/admin/accounting/';
//   }
// }


function payment_in(s) {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    first_date = document.getElementById('process_date').value;
    second_date = document.getElementById('second_date').value;
    payment_for = document.getElementById('payment_for').value;
    payment_type = document.getElementById('payment_type').value;

    if (first_date==''){
        alert('Please select first date');
        return;
    }
    if (s == 2 && second_date==''){
        alert('Please select second date');
        return;
    }
    if (s==1) {
        second_date=first_date
    }
    var data = "first_date=" + first_date + '&second_date=' + second_date+'&payment_for=' + payment_for+'&payment_type=' + payment_type;
    url =  "<?php echo base_url('admin/accounting/payment_in_report')?>";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            // console.log(ajaxRequest.responseText); return;
            var resp = ajaxRequest.responseText;
            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
            a.document.write(resp);
            // a.close();
        }
    }
}
function payment_out(s) {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    first_date = document.getElementById('process_date').value;
    second_date = document.getElementById('second_date').value;
    payment_type = document.getElementById('payment_type').value;
    if (payment_type=='1') {
        alert('Installment is Not For Payment Out');
        return;
    }
    if (first_date==''){
        alert('Please select first date');
        return;
    }
    if (s == 2 && second_date==''){
        alert('Please select second date');
        return;
    }
    if (s==1) {
        second_date=first_date
    }
    var data = "first_date=" + first_date + '&second_date=' + second_date+'&payment_type=' + payment_type;
    url = "<?php echo base_url('admin/accounting/payment_out_report')?>";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            // console.log(ajaxRequest.responseText); return;
            var resp = ajaxRequest.responseText;
            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
            a.document.write(resp);
            // a.close();
        }
    }
    }

    function client_list(){
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
   
  
    url = base_url + '/client_list';
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send();
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            // console.log(ajaxRequest.responseText); return;
            var resp = ajaxRequest.responseText;
            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
            a.document.write(resp);
            // a.close();
        }
    }
}
</script>