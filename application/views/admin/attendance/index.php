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
.checkbox-btn input:checked ~ .checkmark {
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
.checkbox-btn input:checked ~ .checkmark:after {
  visibility: visible;
  opacity: 1;
  transform: translate(-50%, -50%) rotate(0deg) scale(1);
  animation: pulse 1s ease-in;
}

.checkbox-btn input:checked ~ .checkmark {
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

<div class="modal fade bd-example-modal-lg" id="extra_present_approval_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin-top: 65px;">
        <div class="modal-content" style="padding: 18px;border: 1px solid black;margin: 5px;overflow: auto;">
            <div class="col-md-12">
                <p class="col-md-6" style="font-weight: bold;font-size: 20px;text-align: left;">Extra Present Approval
                </p>
            </div>
            <form id="extra_present_approval_form">
                <div class="col-md-12" style="display: flex;flex-direction: column;gap: 9px;">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Status</th>
                                <th>Approve status</th>
                            </tr>
                        </thead>
                        <tbody id="extra_present_approval_data">

                        </tbody>
                    </table>
                    <div class="col-md-12" style="margin-top: 10px;text-align-last: right;">
                        <a class="btn btn-primary"  href="#" data-dismiss="modal">Close</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>





<div class="col-lg-8">
    <div class="box mb-4 <?php echo $get_animate;?>">
        <div class="box-body">
        <?php   $this->load->view('admin/filter'); ?>
            <div class="col-md-12 text-right">
                <div class="form-group"> &nbsp;
                    <button class="btn btn-success" onclick="attn_process()">Process</button>
                    <button class="btn btn-success" onclick="date_between_attn_process()">Date between Process</button>
                </div>
            </div>
        </div>
    </div>
    <div id="loader" align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;">
        <img src="<?php echo base_url();?>/uploads/ajax-loader.gif" />
    </div>

    <div class="box <?php echo $get_animate;?>">
        <div class="box-header with-border" id="report_title">
            <h3 class="box-title" id="report"> Employee Report
            </h3>
            <div class="box-tools pull-right">
                <button id="manually_entry" class="btn btn-sm btn-primary"
                    style="padding: 6px 10px !important;">Manually Entry</button>
                    <?php
                    $this->db->where('status', 0);
                    $count = $this->db->get('xin_employee_punch_request')->num_rows();
                    ?>

                    <a  class="btn btn-sm btn-primary" href="<?= base_url('admin/attendance/punch_request_list') ?>" style="padding: 6px 10px !important;">Punch Request <span class="badge badge-danger" style="background-color: red !important; color: white !important;"><?= $count ?></span></a>
                
                <button onclick="extra_present_approval()" class="btn btn-sm btn-primary"
                    style="padding: 6px 10px !important;">Extra Present Approval</button>
            </div>
        </div>
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
                <li class="nav-item">
                    <a class="nav-link" id="performance-tab" data-toggle="tab" href="#performance" role="tab"
                        aria-controls="continuously" aria-selected="false"> Attendance Performance </a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab"
                    style="margin-top: 30px;">
                    <button class="btn btn-sm mr-5 sbtn" onclick="latecomment('latecomment')">Daily Late
                        comment</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="daily_report('all')">All</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="daily_report('Present')">Present</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="daily_report('Absent')">Absent</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="daily_report('Present',1)">Late</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="early_out_report('Early Out')">Early Out</button>
                    <br>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="lunch_report('Lunch in/out')">Lunch
                        In/Out</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="lunch_report('Lunch Late',1)">Lunch Late</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="movement_report('Movement')">Movement</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="leavecal(1,[1,2,3,4])">Leave Applyed</button>
                    <button class="btn btn-sm mr-5 sbtn" onclick="floor_movement()">Floor Movement</button>

                </div>

                <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab"
                    style="margin-top: 30px;">
                    <!-- <button class="btn btn-sm btn-danger"> Button one</button>-->
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="monthly_report()">Monthly Register
                        Report</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" data-toggle="modal" data-target="#requisitionModal">Open
                        Requisition Modal</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="leavecal(2,[1,4])">Leave Panding</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="leavecal(2,[2])">Leave Approved</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="leavecal(2,[3])">Leave Rejected</button>




                </div>
                <div class="tab-pane fade" id="continuously" role="tabpanel" aria-labelledby="continuously-tab"
                    style="margin-top: 30px;">
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="jobCard()">Job Card</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="extra_present()">Extra Present</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="movReport('all')">All Movement</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="movReport(0)">Unpaid Movement</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="movReport(1)">Process Movement</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="movReport(3)">Reject Movement</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="movReport(4)">Paid Movement</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="leavecal(3,[1,4])">Leave Panding</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="leavecal(3,[2])">Leave Approved</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="leavecal(3,[3])">Leave Rejected</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="absent()">Absent</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="latecount(0)">No Late</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="overtime()">Overtime</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="nda_report()">NDA Report</button>
                </div>
                <div class="tab-pane fade" id="performance" role="tabpanel" aria-labelledby="performance-tab"
                    style="margin-top: 30px;">
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="latecount(1)">Late</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="latecount(0)">No Late</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="overtime()">Overtime</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="absent()">Absent</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="extra_present()">Extra Present</button>
                    <button class="btn  btn-sm mr-5 sbtn mt-2" onclick="overall_performance()">Over All Performance</button>
                    <button class="btn  btn-sm mr-5 sbtn mt-2" onclick="overall_performance_yearly()">Get Yearly report</button>
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
</script>
<script>
function extra_present_approval() {
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
    if (second_date == '') {
        alert('Please select second date');
        return;
    }
    console.log(sql);
    var url = "<?php echo base_url('admin/attendance/extra_present_approval'); ?>";
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            "sql": sql,
            "first_date": first_date,
            "second_date": second_date
        },
        success: function(response) {
            $('#extra_present_approval_modal').modal('show');
            var item = ''
            arr = JSON.parse(response);
            if (arr.length != 0) {
                $.each(arr, function(index, value) {
                    item += '<tr>';
                    item += '<td class="">' + value.first_name + ' ' + value.last_name +'</td>';
                    item += '<td class="">' + value.attendance_date+'</td>';
                    item += '<td class="">' + value.clock_in+'</td>';
                    item += '<td class="">' + value.clock_out+'</td>';
                    item += '<td class="">Extra Present</td>';
                    item += `<td class="">
                        <label class="checkbox-btn">
                                <label for="checkbox"></label>
                                <input id="checkbox"  onchange="extra_present_approval_press(this,${value.time_attendance_id})" type="checkbox" ${value.extra_ap == 1 ? 'checked' : ''}>
                                <span class="checkmark"></span>
                        </label>
                        </td>`;
                    item += '</tr>';
                });
            }
            $('#extra_present_approval_data').html(item);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    })
}
</script>
<script>
function extra_present_approval_press(data, time_attendance_id) {
    if (data.checked) {
        data=1
    } else {
        data=0
    } 
    var url = "<?php echo base_url('admin/attendance/extra_present_approval_press'); ?>";
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            "data": data,
            "time_attendance_id": time_attendance_id
        },
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    })
}
</script>

    