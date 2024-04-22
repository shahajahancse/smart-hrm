<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

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

/* Customize the label (the checkbox-btn) */
.checkbox-btn {
    display: block;
    position: relative;
    padding-left: 30px;
    margin-bottom: 10px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.checkbox-btn input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkbox-btn label {
    cursor: pointer;
    font-size: 14px;
}

/* Create a custom checkbox */
.checkmark {
    content: 'zfdsdf';
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    border: 2.5px solid #000000;
    transition: .2s linear;
}

.checkbox-btn input:checked~.checkmark {
    background-color: transparent;
    color: #0ea021;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    visibility: hidden;
    opacity: 0;
    left: 50%;
    top: 40%;
    width: 10px;
    height: 14px;
    border: 2px solid #0ea021;
    filter: drop-shadow(0px 0px 10px #0ea021);
    border-width: 0 2.5px 2.5px 0;
    transition: .2s linear;
    transform: translate(-50%, -50%) rotate(-90deg) scale(0.2);
}

/* Show the checkmark when checked */
.checkbox-btn input:checked~.checkmark:after {
    visibility: visible;
    opacity: 1;
    transform: translate(-50%, -50%) rotate(0deg) scale(1);
    animation: pulse 1s ease-in;
}

.checkbox-btn input:checked~.checkmark {
    transform: rotate(45deg);
    border: none;
}

@keyframes pulse {

    0%,
    100% {
        transform: translate(-50%, -50%) rotate(0deg) scale(1);
    }

    50% {
        transform: translate(-50%, -50%) rotate(0deg) scale(1.6);
    }
}
</style>
<div id="loading">

    <img src="<?php echo base_url()?>skin/hrsale_assets/img/loding.gif">

</div>



<div class="col-lg-8">
    <div class="box mb-4 <?php echo $get_animate;?>">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="process_date">First Date</label>
                                <input class="form-control attendance_date"
                                    placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date"
                                    name="process_date" type="text" value="<?php echo date('Y-m-d');?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="process_date">Second Date</label>
                                <input class="form-control attendance_date"
                                    placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="second_date"
                                    name="second_date" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="upload_file">status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Select one</option>
                                    <option value="1">regular</option>
                                    <option value="2">left</option>
                                    <option value="3">resign</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loader" align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;">
        <img src="<?php echo base_url();?>/uploads/ajax-loader.gif" />
    </div>

    <div class="box <?php echo $get_animate;?>">
        <div class="box-body" id="emp_report">
            <ul class="nav nav-tabs " id="myTab" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link " id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily"
                        aria-selected="true">Daily</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab"
                        aria-controls="monthly" aria-selected="false">Monthly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="continuously-tab" data-toggle="tab" href="#continuously" role="tab"
                        aria-controls="continuously" aria-selected="false">Continuously</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab"
                    style="margin-top: 30px;">
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('daily','all')">Daily Time log report All</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('daily',0)">Daily Time log report pending</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('daily',1)">Daily Time log report approved</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('daily',2)">Daily Time log report rejected</button>
                </div>

                <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab"
                    style="margin-top: 30px;">
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('monthly','all')">Monthly Time log report All</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('monthly',0)">Monthly Time log report pending</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('monthly',1)">Monthly Time log report pending</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('monthly',2)">Monthly Time log report pending</button>
                </div>
                <div class="tab-pane fade" id="continuously" role="tabpanel" aria-labelledby="continuously-tab"
                    style="margin-top: 30px;">
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('continuously','all')">Time log report All</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('continuously',0)">Time log report pending</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('continuously',1)">Time log report approved</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="logreport('continuously',2)">Time log report rejected</button>
                </div>
            </div>
        </div>
        <div class="box-body" id="entry_form">
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="box" style="height: 74vh;overflow-y: scroll;">
        <table class="table table-striped table-hover" id="fileDiv">
            <tr style="position: sticky;top: 0;z-index:1">
                <th class="active" style="width:10%"><input type="checkbox" id="select_all" class="select-all checkbox"
                        name="select-all" /></th>
                <th class="" style="width:10%;background:#0177bcc2;color:white">Id</th>
                <th class=" text-center" style="background:#0177bc;color:white">Name</th>
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script>
$(document).ready(function() {

    // $('#manu_form').hide();
    $("#manually_entry").click(function() {
        $('#emp_report').hide();
        $('#report_title').hide();
        $("#entry_form").load("<?php echo base_url()?>" + "admin/attendance/manually");
    });

    // select all item or deselect all item
    $("#select_all").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    // on load employee
    $("#status").change(function() {
        status = document.getElementById('status').value;
        var url = "<?php echo base_url('admin/attendance/get_employee_ajax_request'); ?>";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                "status": status
            },
            contentType: "application/json",
            dataType: "json",


            success: function(response) {
                arr = response.employees;
                if (arr.length != 0) {
                    var items = '';
                    $.each(arr, function(index, value) {
                        items += '<tr id="removeTr">';
                        items +=
                            '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' +
                            value.emp_id + '" ></td>';
                        items += '<td class="success">' + value.emp_id + '</td>';
                        items += '<td class="warning ">' + value.first_name + ' ' +
                            value.last_name + '</td>';
                        items += '</tr>';
                    });
                    // console.log(items);
                    $('#fileDiv tr:last').after(items);
                } else {
                    $('#fileDiv #removeTr').remove();
                }
            }
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
<script>
function logreport(type,status) {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();

    first_date = document.getElementById('process_date').value;
    second_date = document.getElementById('second_date').value;
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);
    if (sql == '') {
        alert('Please select employee Id');
        return;
    }

    if (type == 'daily') {
        if (first_date == '') {
            alert('Please select first date');
            return;
        }
    }

    if (type == 'monthly') {
        if (first_date == '') {
            alert('Please select first date');
            return;
        }
    }

    if (type == 'continuously') {
        if (first_date == '') {
            alert('Please select first date');
            return;
        }

        if (second_date == '') {
        alert('Please select second date');
        return;
        }
    }

    var data = "first_date=" + first_date + '&second_date=' + second_date + '&sql=' + sql + '&type=' + type + '&status=' + status;

    url = base_url + "/logreport";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    // alert(url); return;

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