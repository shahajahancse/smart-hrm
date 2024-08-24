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
</style>
<div id="loading">

    <img src="<?php echo base_url()?>skin/hrsale_assets/img/loding.gif">

</div>

<div class="modal fade bd-example-modal-lg" id="latecommentm" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content" style="padding: 18px;border: 1px solid black;margin: 5px;overflow: auto;">
            <div class="col-md-12">
                <p class="col-md-6" style="font-weight: bold;font-size: 20px;text-align: left;">Late comment</p>
                <p class="col-md-6" style="font-weight: bold;font-size: 20px;text-align: right;">Date <span
                        id="date"></span></p>
            </div>

            <form id="lateform">
                <input type="hidden" id="datein" name="date" value="">
                <div id="latecommentform"></div>

                <div class="col-md-12" style="margin-top: 10px;text-align-last: right;">
                    <input class="btn btn-primary" type="submit" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>





<div class="col-lg-8">
    <div class="box mb-4 <?php echo $get_animate;?>">
        <div class="box-body">
            <?php   $this->load->view('admin/filter'); ?>

        </div>
    </div>

    <div id="loader" align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;">
        <img src="<?php echo base_url();?>/uploads/ajax-loader.gif" /></div>

    <div class="box <?php echo $get_animate;?>">
        <div class="box-header with-border" id="report_title">
            <h3 class="box-title" id="report"> Employee Report
                <!-- < ?php echo $this->lang->line('xin_daily_attendance_report');?> -->
            </h3>
        </div>

        <div class="box-body" id="emp_report">


            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab"
                    style="margin-top: 30px;">

                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="leave_monthly()">Monthly Leave</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="absent_monthly()">Monthly Absent</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="yerly_leave()">Yerly Leave</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="yerly_leave_earn_list()">Yerly Leave Earn list</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="leave_app()">Leave Application List</button>

                </div>

            </div>

        </div>

        <div class="box-body" id="entry_form">

        </div>

    </div>
</div>

<div class="col-lg-4">
<?php   $this->load->view('admin/filtered_data'); ?>

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
    // $("#status").change(function() {
    //     status = document.getElementById('status').value;
    //     var url = "<?php echo base_url('admin/attendance/get_employee_ajax_request'); ?>";
    //     $.ajax({
    //         url: url,
    //         type: 'GET',
    //         data: {
    //             "status": status
    //         },
    //         contentType: "application/json",
    //         dataType: "json",


    //         success: function(response) {
    //             arr = response.employees;
    //             if (arr.length != 0) {
    //                 var items = '';
    //                 $.each(arr, function(index, value) {
    //                     items += '<tr id="removeTr">';
    //                     items +=
    //                         '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' +
    //                         value.emp_id + '" ></td>';
    //                     items += '<td class="success">' + value.emp_id + '</td>';
    //                     items += '<td class="warning ">' + value.first_name + ' ' +
    //                         value.last_name + '</td>';
    //                     items += '</tr>';
    //                 });
    //                 // console.log(items);
    //                 $('#fileDiv tr:last').after(items);
    //             } else {
    //                 $('#fileDiv #removeTr').remove();
    //             }
    //         }
    //     });
    // });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
<script>
$(document).ready(function() {
    // Bind submit event of the form
    $('#lateform').submit(function(e) {
        e.preventDefault();
        $('#latecommentm').modal('hide');
        $('#loading').css({
            visibility: 'visible'
        });
        // Prevent form submission


        // Get the form data
        var formData = $(this).serialize();

        // Send AJAX request
        $.ajax({
            url: '<?php echo site_url("admin/attendance/add_latecomment"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('#loading').css({
                    visibility: 'hidden'
                });
                // Handle the response from the server
                Swal.fire({
                    title: 'Success!',
                    text: response,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});

function absent_monthly() {
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
    if (first_date == '') {
        alert('Please select first date');
        return;
    }
    var data = "first_date=" + first_date + '&second_date=' + second_date + '&sql=' + sql;
    url = base_url + "/absent_monthly";
    // alert(url); return ;
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

function leave_monthly() {
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
    if (first_date == '') {
        alert('Please select first date');
        return;
    }
    var data = "first_date=" + first_date + '&second_date=' + second_date + '&sql=' + sql;
    url = base_url + "/leave_report";
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

function yerly_leave() {
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
    if (first_date == '') {
        alert('Please select first date');
        return;
    }
    var data = "first_date=" + first_date + '&second_date=' + second_date + '&sql=' + sql;

    url = base_url + "/yerly_leave";
    // alert(url); return ;
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
function yerly_leave_earn_list() {
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
    if (first_date == '') {
        alert('Please select first date');
        return;
    }
    var data = "first_date=" + first_date + '&second_date=' + second_date + '&sql=' + sql;

    url = base_url + "/yerly_leave_earn_list";
    // alert(url); return ;
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

function leave_app() {
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
    var data = "first_date=" + first_date + '&second_date=' + second_date + '&sql=' + sql;
    url = base_url + "/leave_application";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            var resp = ajaxRequest.responseText;
            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
            a.document.write(resp);
        }
    }
}
</script>