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

    <!-- <img src="<?php echo base_url()?>skin/hrsale_assets/img/loding.gif"> -->

</div>

<div class="col-lg-8">
    <div class="box mb-4 <?php echo $get_animate;?>">
        <div class="box-body">
        <?php   $this->load->view('admin/filter'); ?>

        </div>
    </div>

    <!-- <div id="loader" align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;">
        <img src="< ?php echo base_url();?>/uploads/ajax-loader.gif" />
    </div> -->

    <div class="box <?php echo $get_animate;?>">
        <div class="box-header with-border" id="report_title">
            <h3 class="box-title" id="report"> Lunch Report
            </h3>
        </div>

        <div class="box-body" id="emp_report">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab"
                    style="margin-top: 0px;">
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="perday(1)">Daily Ordering Report </button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="perday(3)">Continue Ordering Report</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="perday(5)">Lunch Issues Report</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="paymentreport(1)">Paid Employees</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="paymentreport(0)">Unpaid Employees</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="paymentreport(2)">Employees Collection Sheets</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="prever_report()">Previous Report</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="lunch_jobcard()">Employee wise Lunch Report</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="conempmeal(1)">Employee Meal</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="conempmeal(2)">Gest Meal</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="print_vendor_data(1)">Vendor Lunch Daily</button>
                    <button class="btn btn-sm mr-5 sbtn mt-2" onclick="print_vendor_data(2)">Vendor Data Continue</button>
                </div>
            </div>
        </div>

        <!-- <div class="box-body" id="entry_form">

        </div> -->

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
    //                 $.each(arr, function (index, value) {
    //                 items += '<tr id="removeTr">';
    //                 items += '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' + value.emp_id + '" ></td>';
    //                 items += '<td class="success">' + (i++) + '</td>';
    //                 items += '<td class="warning ">' + value.first_name + ' ' + value.last_name + " (" +value.emp_id + ")" + '</td>';
    //                 items += '</tr>';
    //                 });
    //                 // console.log(items);
    //                 $('#fileDiv tr:last').after(items);
    //             } 
                    
               
    //         }
    //     });
    // });
});
</script>