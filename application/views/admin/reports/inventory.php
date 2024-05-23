<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<style>
option {
    background-color: white;
    color: black;
    /* Replace with your desired color */
    text-align: left;
}
</style>
<div class="row m-b-1 <?php echo $get_animate;?>">
    <div class="col-md-8">

        <div class="box">
            <div class="box-body">
            <?php   $this->load->view('admin/filter'); ?>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab1">Device Report</a></li>
                    <li><a data-toggle="tab" href="#tab2">Movement Report</a></li>
                    <li><a data-toggle="tab" href="#tab3">Mobile Bill Report</a></li>
                </ul>

                <div class="tab-content">
                    <div id="tab1" class="tab-pane fade in active" style="margin-top:20px">
                        <button class="btn btn-sm btn-success" onclick="device_report()">Desktop</button>
                        <button class="btn btn-sm btn-success" onclick="device_report_laptop()">Laptop</button>
                        <select class="btn btn-sm btn-success" style="" id="mySelect">
                            <option value="">Category Wise report </option>
                            <?php
                $categories =$this->db->select('id,cat_name')->get('product_accessory_categories')->result(); 
                foreach($categories as $category){
              ?>
                            <option value="<?php echo $category->id?>" onclick="show_report(2)">
                                <?php echo $category->cat_name?></option>
                            <?php }?>
                        </select>
                        <button class="btn btn-sm btn-success" style="margin-left:"
                            onclick="show_report('using')">Employee using device</button><br><br>
                        <button class="btn btn-sm btn-success" onclick="show_store_report('store')">Stored
                            Report</button>
                        <button class="btn btn-sm btn-success" style="margin-left:"
                            onclick="show_report('damage')">Damaged Report</button>
                        <button class="btn btn-success btn-sm" onclick="show_report2(5)">Using Device</button>

                    </div>
                    <div id="tab2" class="tab-pane fade" style="margin-top:20px">
                        <button class="btn btn-sm btn-success" onclick="move_report('daily')">Daily Report</button>
                        <button class="btn btn-sm btn-success" style="margin-left:10px"
                            onclick="move_report('weekly')">Weekly Report</button>
                        <button class="btn btn-sm btn-success" style="margin-left:10px"
                            onclick="move_report('monthly')">Continuous Report</button>
                    </div>
                    <div id="tab3" class="tab-pane fade" style="margin-top:20px">
                        <button class="btn btn-sm btn-success" onclick="mobile_bill_report(1)">Pending Report</button>
                        <button class="btn btn-sm btn-success" style="margin-left:10px"
                            onclick="mobile_bill_report(2)">Approved Report</button>
                        <button class="btn btn-sm btn-success" style="margin-left:10px"
                            onclick="mobile_bill_report(3)">Reject Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
    <?php   $this->load->view('admin/filtered_data'); ?>

    </div>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script>
$(document).ready(function() {
    $("#select_all").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    // on load employee
    // $("#status").change(function() {
    //     status = document.getElementById('status').value;
    //     var url = "<?php echo base_url('admin/reports/get_employeess'); ?>";
    //     $("#select_all").prop("checked", false);
    //     $('#fileDiv #removeTr').remove();
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
    //                 var i = 1;
    //                 var items = '';
    //                 $.each(arr, function(index, value) {
    //                     items += '<tr id="removeTr">';
    //                     items +=
    //                         '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' +
    //                         value.emp_id + '" ></td>';
    //                     items += '<td class="success">' + (i++) + '</td>';
    //                     items += '<td class="warning ">' + value.first_name + ' ' +
    //                         value.last_name + " (" + value.emp_id + ")" + '</td>';
    //                     items += '</tr>';
    //                 });
    //                 $('#fileDiv tr:last').after(items);
    //             }
    //         }
    //     });
    // });
});
$("#mySelect").on("change", function() {
    var selectedValue = $(this).val();
    show_report(selectedValue);
});

function show_report(r) {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    var status = $('#status').val();
    var first_date = $('#process_date').val();
    var second_date = $('#second_date').val();
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);

    if (status == '' && r == 'using') {
        alert('Please select status');
        return;
    }
    if (status != '' && r == 'using' && sql == '') {
        alert('Please select employee id');
        return;
    }

    var data = "first_date=" + first_date + "&second_date=" + second_date + "&status=" + r + '&sql=' + sql;
    url = base_url + "/show_inventory_report";
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

function move_report(r) {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    var status = $('#status').val();
    var first_date = $('#process_date').val();
    var second_date = $('#second_date').val();
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);

    if (status == '' && (r == 'daily' || r == 'monthly' || r == 'weekly')) {
        alert('Please select status');
        return;
    }
    if (status != '' && (r == 'daily' || r == 'monthly' || r == 'weekly') && sql == '') {
        alert('Please select employee id');
        return;
    }
    if (r == 'monthly' && second_date == '') {
        alert('Please select second date');
        return;
    }


    var data = "first_date=" + first_date + "&second_date=" + second_date + "&status=" + r + '&sql=' + sql;
    url = base_url + "/show_move_report";
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



function mobile_bill_report(r) {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    var status = $('#status').val();
    var first_date = $('#process_date').val();
    var second_date = $('#second_date').val();
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);

    if (status == '' && (r == 1 || r == 2 || r == 3)) {
        alert('Please select status');
        return;
    }
    if (status != '' && (r == 1 || r == 2 || r == 3) && sql == '') {
        alert('Please select employee id');
        return;
    }
    if (second_date == '' && (r == 1 || r == 2 || r == 3)) {
        alert('Please select second date');
        return;
    }


    var data = "first_date=" + first_date + "&second_date=" + second_date + "&status=" + r + '&sql=' + sql;
    url = base_url + "/show_mobile_bill_report";
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

function device_report() {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    var status = $('#status').val();
    var first_date = $('#process_date').val();
    var second_date = $('#second_date').val();
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);


    var data = "";
    url = base_url + "/show_device_report";
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


function device_report_laptop() {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    var status = $('#status').val();
    var first_date = $('#process_date').val();
    var second_date = $('#second_date').val();
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);


    var data = "";
    url = base_url + "/show_device_report_laptop";
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

function show_store_report() {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    var status = $('#status').val();
    var first_date = $('#process_date').val();
    var second_date = $('#second_date').val();
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);


    var data = "";
    url = base_url + "/show_store_report";
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


<script>
$(document).ready(function() {
    $("#mySelect").on("change", function() {
        $(this).prop("selectedIndex", "");
    });
});

function show_report2(r, done) {
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    status = document.getElementById('status').value;
    first_date = document.getElementById('process_date').value;
    second_date = document.getElementById('second_date').value;
    if (status == '') {
        alert('Please select status');
        return;
    }

    if (r == 2) {
        if (first_date == '') {
            alert('Please select first date');
            return;
        }
        if (second_date == '') {
            alert('Please select second date');
            return;
        }
    }

    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);
    if (sql == '') {
        alert('Please select employee Id');
        return;
    }
    var data = "first_date=" + first_date + "&second_date=" + second_date + "&status=" + r + '&sql=' + sql + '&done=' +
        done;
    url = base_url + "/show_report";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            // console.log(ajaxRequest);
            var resp = ajaxRequest.responseText;
            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
            a.document.write(resp);
        }
    }
}
</script>