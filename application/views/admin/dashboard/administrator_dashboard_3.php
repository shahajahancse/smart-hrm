<?php
$session = $this->session->userdata('username');
$user = $this->Xin_model->read_employee_info($session['user_id']);

?>
<script src="https://kit.fontawesome.com/d23f82b51c.js" crossorigin="anonymous"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');


.p-0 {
    padding: 0 !important;
}

.d_card {
    border-radius: 10px;
    padding: 20px;
    margin: 9px 0px;
    box-shadow: 0px 0px 10px 2px darkgrey;
}
h5,h4 {
    color: #000000;
}


.c_card {
    border-radius: 10px;
    padding: 5px;
    display: flex;
    margin: 9px 0px;
    cursor: pointer;
    color: #0177bc;
    box-shadow: 0px 0px 8px 2px #bdbdbd;
    flex-direction: column;
}

.c_card:hover {
    box-shadow: 0px 0px 35px 4px #8f8f8f
}

.c_cardn {
    border-radius: 10px;
    padding: 5px;
    color: #0177bc;

    display: flex;
    margin: 9px 0px;
    cursor: pointer;
    box-shadow: 0px 0px 8px 2px #bdbdbd;
    flex-direction: column;
}

.c_cardn:hover {
    box-shadow: 0px 0px 35px 4px #8f8f8f
}

#floatingDiv {
    height: 247px;
    width: 200px;
    background-image: linear-gradient(141deg, #cdd0ff, #a9f1c3);
    border-radius: 10px;
    padding: 10px;
    z-index: 999;
    overflow-y: scroll;
}

.fli {
    list-style: none;
    border: 1px solid;
    width: 174px;
    padding: 6px;
    border-radius: 8px;
    margin-bottom: 4px;
}

#floatingDiv::-webkit-scrollbar {
    display: none;

}
</style>


<div style="display: none">
    <div id="all_employee_list">
    </div>
    <div id="all_present_list">
    </div>
    <div id="all_absent_list">
    </div>
    <div id="all_leave_list">
    </div>
    <div id="all_late_list">
    </div>
</div>
<div class="row">
    <div class='col-md-12'>
        <h2><?php echo $this->lang->line('dashboard_title'); ?></h2>
        <h4 class="widget-user-username welcome-hrsale-user">
            <?php echo $this->lang->line('xin_title_wcb'); ?>,
            <span style="color: #1976D2"><?php echo $user[0]->first_name . ' ' . $user[0]->last_name; ?>!</span>
        </h4>
    </div>
    <div class='col-md-12 row'>
        <div class="col-md-6">
            <div class="d_card" style="background: aliceblue;">
                <div class="row" style="display: flex;flex-direction: row;align-items: center;">
                    <h4 class="col-md-6">Daily Attendance</h4>
                    <input class="col-md-3" type="date" onchange="get_data_count()" value="<?= date('Y-m-d') ?>"
                        name="date" id="date_first_card"
                        style="border: 1px solid #009cf5;background: transparent;padding: 3px;border-radius: 7px;">
                    <div class="col-md-3">
                        <a onclick="daily_report('all')" class="btn btn-primary btn-sm"
                            style="text-align: -webkit-center; cursor: pointer;">Get Report <i
                                class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_card" id="all-employees">
                            <h5>All Employees</h5>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count-all-employees">0</h3>
                                <i class="fa fa-user col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="c_card" id="present">
                            <h5>Present</h5>
                            <div class="col-md-12">
                                <h3 class="count-present col-md-6" id="count-present">0</h3>
                                <i class="fa fa-laptop col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_card" id="absent">
                            <h5>Absent</h5>
                            <div class="col-md-12">
                                <h3 class="count-absent col-md-6" id="count-absent">0</h3>
                                <i class="fa fa-home col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="c_card" id="late">
                            <h5>Late</h5>
                            <div class="col-md-12">
                                <h3 class="count-late col-md-6" id="count-late">0</h3>
                                <i class="fa fa-clock-o col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"
                                    class=" col-md-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d_card" style="background: aliceblue;">
                <div class="row" style="display: flex;flex-direction: row;align-items: center;">
                    <h4 class="col-md-6">Monthly</h4>
                    <input class="col-md-4" type="month" onchange="get_monthly_data()" value="<?= date('Y-m') ?>"
                        id="date_monthly"
                        style="border: 1px solid #009cf5;background: transparent;padding: 3px;border-radius: 7px;">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_cardn">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Leave</h5>
                                <a href="javascript:void(0)" onclick="get_leave_monthly(event)" class="col-md-6 p-0"
                                    style="text-align: -webkit-center;cursor: pointer;margin-top: 6px;">Get Report
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_leave_monthly">0</h3>
                                <i class="fa-solid fa-right-from-bracket col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="c_cardn">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Extra Present</h5>
                                <a href="javascript:void(0)" onclick="get_extra_present_monthly(event)"
                                    class="col-md-6 p-0"
                                    style="text-align: -webkit-center;cursor: pointer;margin-top: 6px;">Get Report
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_extra_present_monthly">0</h3>
                                <i class="fa-solid fa-user-plus col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_cardn">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Late</h5>
                                <a href="javascript:void(0)" onclick="get_late_monthly(event)" class="col-md-6 p-0"
                                    style="text-align: -webkit-center;cursor: pointer;margin-top: 6px;">Get Report
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_late_monthly">0</h3>
                                <i class="fa-solid fa-user-clock col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="c_cardn">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Meeting</h5>
                                <a href="javascript:void(0)" onclick="get_meeting_monthly(event)" class="col-md-6 p-0"
                                    style="text-align: -webkit-center;cursor: pointer;margin-top: 6px;">Get Report
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_meeting_monthly">0</h3>
                                <i class="fa-solid fa-handshake col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- store -->
    <div class='col-md-12 row'>
        <div class="col-md-6">
            <div class="d_card" style="background: aliceblue;">
                <div class="row">
                    <h4 class="col-md-12">Requisition</h4><br>
                    <div class="col-md-12">
                        <input class="col-md-4" type="date" onchange="get_data_requisition_count()"
                            value="<?= date('Y-m-d',strtotime('-1 month')) ?>" name="date" id="date_1_requisition"
                            style="border: 1px solid #009cf5;background: transparent;padding: 3px;border-radius: 7px;">
                        <span class="col-md-1" style="margin-top: 5px;">to</span>
                        <input class="col-md-4" type="date" onchange="get_data_requisition_count()"
                            value="<?= date('Y-m-d') ?>" name="date" id="date_2_requisition"
                            style="border: 1px solid #009cf5;background: transparent;padding: 3px;border-radius: 7px;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a class="c_cardn" href="<?php echo site_url('admin/inventory/index');?>">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">All Requisition</h5>
                             
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_requisition_all">0</h3>
                                <i class="fa-solid fa-truck col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a class="c_cardn" href="<?php echo site_url('admin/inventory/pending_list');?>">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Pending</h5>
                                
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_requisition_pending">0</h3>
                                <i class="fa-solid fa-hourglass col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a class="c_cardn" href="<?php echo site_url('admin/inventory/aproved_list');?>">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Approved</h5>
                                
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_requisition_approved">0</h3>
                                <i class="fa-solid fa-check col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">

                        <a class="c_cardn" href="<?php echo site_url('admin/inventory/delivery_list');?>">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Handover</h5>
                              
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_requisition_handover">0</h3>
                                <i class="fa-solid fa-handshake col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d_card" style="background: aliceblue;">
                <div class="row">
                    <h4 class="col-md-12">Purchase</h4> <br>
                    <div class="col-md-12">
                        <input class="col-md-4" type="date" onchange="get_data_purchase_count()"
                            value="<?= date('Y-m-d',strtotime('-1 month')) ?>" name="date" id="date_1_purchase"
                            style="border: 1px solid #009cf5;background: transparent;padding: 3px;border-radius: 7px;">
                        <span class="col-md-1" style="margin-top: 5px;">to</span>
                        <input class="col-md-4" type="date" onchange="get_data_purchase_count()"
                            value="<?= date('Y-m-d') ?>" name="date" id="date_2_purchase"
                            style="border: 1px solid #009cf5;background: transparent;padding: 3px;border-radius: 7px;">
                        <!-- <div class="col-md-3" style="margin-top: 3px;">
                            <a onclick="daily_report('all')" class="btn btn-primary btn-sm"
                                style="text-align: -webkit-center; cursor: pointer;">Get Report <i
                                    class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                        </div> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a class="c_cardn" href="<?php echo site_url('admin/inventory/purchase');?>" >
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">All Purchase</h5>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_purchase_all">0</h3>
                                <i class="fa-solid fa-mobile-retro col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a class="c_cardn" href="<?php echo site_url('admin/inventory/purchase_panding_list');?>" >
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Pending</h5>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_purchase_pending">0</h3>
                                <i class="fa-solid fa-car-side col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a class="c_cardn" href="<?php echo site_url('admin/inventory/purchase_aproved_list');?>" >
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Approved</h5>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_purchase_approved">0</h3>
                                <i class="fa-solid fa-money-bills col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">

                        <a class="c_cardn" href="<?php echo site_url('admin/inventory/purchase_order_received_list');?>" >
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Received</h5>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_purchase_received">0</h3>
                               
                                <i class="fa-solid fa-money-bills col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        

    </div>

    <div class='col-md-12 row'>
        <div class="col-md-6">
            <div class="d_card" style="background: aliceblue;">
                <div class="row">
                    <h4 class="col-md-12">Payroll</h4> <br>
                    <div class="col-md-12">
                        <input class="col-md-4" type="date" onchange="get_data_payroll_count()"
                            value="<?= date('Y-m-d',strtotime('-1 month')) ?>" name="date" id="date_1_payroll"
                            style="border: 1px solid #009cf5;background: transparent;padding: 3px;border-radius: 7px;">
                        <span class="col-md-1" style="margin-top: 5px;">to</span>
                        <input class="col-md-4" type="date" onchange="get_data_payroll_count()"
                            value="<?= date('Y-m-d') ?>" name="date" id="date_2_payroll"
                            style="border: 1px solid #009cf5;background: transparent;padding: 3px;border-radius: 7px;">
                        <!-- <div class="col-md-3" style="margin-top: 3px;">
                            <a onclick="daily_report('all')" class="btn btn-primary btn-sm"
                                style="text-align: -webkit-center; cursor: pointer;">Get Report <i
                                    class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                        </div> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_cardn">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Mobile Bill</h5>
                                <a href="javascript:void(0)" onclick="get_mobile_bill(event)" class="col-md-6 p-0"
                                    style="text-align: -webkit-center;cursor: pointer;margin-top: 6px;">Get Report
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_mobile_bill">0</h3>
                                <i class="fa-solid fa-mobile-retro col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="c_cardn">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Ta Da Bill</h5>
                                <a href="javascript:void(0)" onclick="get_ta_da(event)" class="col-md-6 p-0"
                                    style="text-align: -webkit-center;cursor: pointer;margin-top: 6px;">Get Report
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_ta_da">0</h3>
                                <i class="fa-solid fa-car-side col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="c_cardn">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Lunch Paid</h5>
                                <a href="javascript:void(0)" onclick="get_lunch_paid(event)" class="col-md-6 p-0"
                                    style="text-align: -webkit-center;cursor: pointer;margin-top: 6px;">Get Report
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_lunch_paid">0</h3>
                                <i class="fa-solid fa-money-bills col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="c_cardn">
                            <div class="col-md-12 p-0">
                                <h5 class="col-md-6 p-0">Lunch Unpaid</h5>
                                <a href="javascript:void(0)" onclick="get_lunch_unpaid(event)" class="col-md-6 p-0"
                                    style="text-align: -webkit-center;cursor: pointer;margin-top: 6px;">Get Report
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="col-md-12">
                                <h3 class="count-all-employees col-md-6" id="count_lunch_unpaid">0</h3>
                               
                                <i class="fa-solid fa-money-bills col-md-6 fa-3x"
                                    style="height: -webkit-fill-available;text-align: -webkit-center;margin: 6px -3px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d_card" style="background: aliceblue;">
                <div class="row" style="display: flex;flex-direction: row;align-items: center;">
                    <h4 class="col-md-6">Report Shortcut</h4>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?=base_url('admin/attendance/')?>">
                            <div class="c_cardn" style="padding: 7px 19px;margin: 7px 0px;">
                                <div class="col-md-12 p-0" style="display: flex;align-items: center;gap: 25px;">
                                    <h4 class="col-md-6 p-0">Attendance</h4>
                                    <i class="fa-solid fa-book fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?=base_url('admin/reports/store_report')?>">
                            <div class="c_cardn" style="padding: 7px 19px;margin: 7px 0px;">
                                <div class="col-md-12 p-0" style="display: flex;align-items: center;gap: 25px;">
                                    <h4 class="col-md-6 p-0">Store</h4>
                                    <i class="fa-solid fa-store fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?=base_url('admin/reports/inventory')?>">
                            <div class="c_cardn" style="padding: 7px 19px;margin: 7px 0px;">
                                <div class="col-md-12 p-0" style="display: flex;align-items: center;gap: 25px;">
                                    <h4 class="col-md-6 p-0">Inventory</h4>
                                    <i class="fa-solid fa-warehouse fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?=base_url('admin/payroll/index')?>">
                            <div class="c_cardn" style="padding: 7px 19px;margin: 7px 0px;">
                                <div class="col-md-12 p-0" style="display: flex;align-items: center;gap: 25px;">
                                    <h4 class="col-md-6 p-0">Payroll</h4>
                                    <i class="fa-solid fa-dollar fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?=base_url('admin/reports/employees')?>">
                            <div class="c_cardn" style="padding: 7px 19px;margin: 7px 0px;">
                                <div class="col-md-12 p-0" style="display: flex;align-items: center;gap: 25px;">
                                    <h4 class="col-md-6 p-0">Employee</h4>
                                    <i class="fa-solid fa-user fa-2x"></i>
                                </div>
                            </div>
                        </a> 
                    </div>
                    <div class="col-md-6">
                        <a href="<?=base_url('admin/reports/employee_leave_report')?>">
                            <div class="c_cardn" style="padding: 7px 19px;margin: 7px 0px;">
                                <div class="col-md-12 p-0" style="display: flex;align-items: center;gap: 25px;">
                                    <h4 class="col-md-6 p-0">Leave</h4>
                                    <i class="fa-solid fa-user fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?=base_url('admin/reports/lunch_report_all')?>">
                            <div class="c_cardn" style="padding: 7px 19px;margin: 7px 0px;">
                                <div class="col-md-12 p-0" style="display: flex;align-items: center;gap: 25px;">
                                    <h4 class="col-md-6 p-0">Lunch</h4>
                                    <i class="fa-solid fa-cutlery fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo site_url('admin/employees/increment_pro_list'); ?>">
                            <div class="c_cardn" style="padding: 7px 19px;margin: 7px 0px;">
                                <div class="col-md-12 p-0" style="display: flex;align-items: center;gap: 25px;">
                                    <h4 class="col-md-6 p-0" style="width: 130px;overflow: hidden;white-space: nowrap;">All Increment/Probotion List</h4>
                                    <i class="fa-solid fa-dollar fa-2x"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// $(document).ready(function() {
//     $('.c_card').hover(function() {
//         var $this = $(this);
//         // setTimeout(function() {
//         $('#floatingDiv').remove();
//         $('<div id="floatingDiv"></div>').css({
//             position: 'absolute',
//             top: $this.offset().top / 10,
//             left: $this.offset().left / 3,
//             backgroundColor: 'lightgray'
//         }).appendTo($this);
//         get_data($this);
//         //},300); // 1000 milliseconds = 1 second
//     }, function() {
//         $('#floatingDiv').remove();
//     });
// });

// function get_data($element) {
//     var who = $element.attr('id');
//     if (who === 'all-employees') {
//         // Copy the content of 'all_employee_list'
//         var allEmployeeListContent = $('#all_employee_list').html();

//         // Append the content to 'floatingDiv'
//         $('#floatingDiv').empty();
//         $('#floatingDiv').append(allEmployeeListContent);
//     }
//     if (who === 'present') {
//         // Copy the content of 'all_employee_list'
//         var allEmployeeListContent = $('#all_present_list').html();
//         $('#floatingDiv').empty();
//         $('#floatingDiv').append(allEmployeeListContent);
//     }
//     if (who === 'absent') {
//         // Copy the content of 'all_employee_list'
//         var allEmployeeListContent = $('#all_absent_list').html();
//         $('#floatingDiv').empty();
//         $('#floatingDiv').append(allEmployeeListContent);
//     }
//     if (who === 'leave') {
//         // Copy the content of 'all_employee_list'
//         var allEmployeeListContent = $('#all_leave_list').html();
//         $('#floatingDiv').empty();
//         $('#floatingDiv').append(allEmployeeListContent);
//     }
//     if (who === 'late') {
//         // Copy the content of 'all_employee_list'
//         var allEmployeeListContent = $('#all_late_list').html();
//         $('#floatingDiv').empty();
//         $('#floatingDiv').append(allEmployeeListContent);
//     }
// }
</script>

<script>
$(document).ready(function() {
    get_data_count()
    get_monthly_data()
    get_data_payroll_count()
    get_data_requisition_count()
    get_data_purchase_count()


})

function get_data_count() {
    var loader =
        '<img src="<?php echo base_url() ?>skin/img/loader.gif" alt="loader" style="height: 24px;width: 24px;">';
    $('#count-all-employees').html(loader);
    $('#count-present').html(loader);
    $('#count-absent').html(loader);
    $('#count-late').html(loader);

    const date = $('#date_first_card').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url("admin/dashboard/get_count") ?>',
        data: {
            date: date
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#count-all-employees').html(data.all_employees.length);
            $('#count-present').html(data.present.length);
            $('#count-absent').html(data.absent.length);
            $('#count-late').html(data.late.length);
            $('#all_present_list').empty();
            $('#all_employee_list').empty();
            $('#all_absent_list').empty();
            $('#all_late_list').empty();
            $.each(data.present, function(key, value) {
                $('#all_present_list').append('<li class="fli">' + value.first_name + ' ' +
                    value.last_name +
                    ' <br> <span class="badge badge-success" >Present</span></li>');
                $('#all_employee_list').append('<li class="fli">' + value.first_name + ' ' +
                    value.last_name +
                    ' <br> <span class="badge badge-success" >Present</span></li>');
            })
            $.each(data.absent, function(key, value) {
                $('#all_absent_list').append('<li class="fli">' + value.first_name + ' ' + value
                    .last_name +
                    ' <br> <span class="badge badge-danger" >Absent</span></li>');
                $('#all_employee_list').append('<li class="fli">' + value.first_name + ' ' +
                    value.last_name +
                    ' <br> <span class="badge badge-danger" >Absent</span></li>');

            })
            $.each(data.late, function(key, value) {
                $('#all_late_list').append('<li class="fli">' + value.first_name + ' ' + value
                    .last_name + ' <br> <span class="badge badge-danger" >Late</span></li>');
                $('#all_employee_list').append('<li class="fli">' + value.first_name + ' ' +
                    value.last_name +
                    ' <br> <span class="badge badge-danger" >Late</span></li>');
            })
        }
    })
}
</script>
<script>
function daily_report(status, late_status = null) {
    var ajaxRequest;
    ajaxRequest = new XMLHttpRequest();
    attendance_date = document.getElementById('date_first_card').value;
    var data = "attendance_date=" + attendance_date + "&status=" + status + "&late_status=" + late_status;
    url = '<?php echo site_url("admin/dashboard/daily_report") ?>';
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);

    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            // console.log(ajaxRequest);
            var resp = ajaxRequest.responseText;
            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
            a.document.write(resp);
        }
    }
}
</script>
<script>
function get_monthly_data() {
    var loader =
        '<img src="<?php echo base_url() ?>skin/img/loader.gif" alt="loader" style="height: 24px;width: 24px;">';
    $('#count_leave_monthly').html(loader);
    $('#count_extra_present_monthly').html(loader);
    $('#count_late_monthly').html(loader);
    $('#count_meeting_monthly').html(loader);

    const date = $('#date_monthly').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url("admin/dashboard/get_monthly_count") ?>',
        data: {
            date: date
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#count_leave_monthly').html(data.leave.length);
            $('#count_extra_present_monthly').html(data.extra_present.length);
            $('#count_late_monthly').html(data.late.length);
            $('#count_meeting_monthly').html(data.meeting.length);
        }
    })

}
</script>
<script>
function get_monthly_data() {
    var loader =
        '<img src="<?php echo base_url() ?>skin/img/loader.gif" alt="loader" style="height: 24px;width: 24px;">';
    $('#count_leave_monthly').html(loader);
    $('#count_extra_present_monthly').html(loader);
    $('#count_late_monthly').html(loader);
    $('#count_meeting_monthly').html(loader);

    const date = $('#date_monthly').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url("admin/dashboard/get_monthly_count") ?>',
        data: {
            date: date
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#count_leave_monthly').html(data.leave.length);
            $('#count_extra_present_monthly').html(data.extra_present.length);
            $('#count_late_monthly').html(data.late.length);
            $('#count_meeting_monthly').html(data.meeting.length);
        }
    })

}
</script>
<script>
function get_data_payroll_count() {
    var loader =
        '<img src="<?php echo base_url() ?>skin/img/loader.gif" alt="loader" style="height: 24px;width: 24px;">';
    $('#count_mobile_bill').html(loader);
    $('#count_ta_da').html(loader);
    $('#count_lunch_paid').html(loader);
    $('#count_lunch_unpaid').html(loader);

    const date1 = $('#date_1_payroll').val();
    const date2 = $('#date_2_payroll').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url("admin/dashboard/get_payroll_count") ?>',
        data: {
            date1: date1,
            date2: date2
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#count_mobile_bill').html(data.mobile_bill.length);
            $('#count_ta_da').html(data.ta_da.length);
            $('#count_lunch_paid').html(data.lunch_paid.length);
            $('#count_lunch_unpaid').html(data.lunch_unpaid.length);
        }
    })

}
</script>
<script>
function get_data_requisition_count() {
    var loader =
        '<img src="<?php echo base_url() ?>skin/img/loader.gif" alt="loader" style="height: 24px;width: 24px;">';
    $('#count_requisition_all').html(loader);
    $('#count_requisition_pending').html(loader);
    $('#count_requisition_approved').html(loader);
    $('#count_requisition_handover').html(loader);

    const date1 = $('#date_1_requisition').val();
    const date2 = $('#date_2_requisition').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url("admin/dashboard/get_requisition_count") ?>',
        data: {
            date1: date1,
            date2: date2
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#count_requisition_all').html(data.all_requisition);
            $('#count_requisition_pending').html(data.pending);
            $('#count_requisition_approved').html(data.approved);
            $('#count_requisition_handover').html(data.handover);
        }
    })

}
</script>
<script>
function get_data_purchase_count() {
    var loader =
        '<img src="<?php echo base_url() ?>skin/img/loader.gif" alt="loader" style="height: 24px;width: 24px;">';
    $('#count_purchase_all').html(loader);
    $('#count_purchase_pending').html(loader);
    $('#count_purchase_approved').html(loader);
    $('#count_purchase_received').html(loader);

    const date1 = $('#date_1_purchase').val();
    const date2 = $('#date_2_purchase').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url("admin/dashboard/get_purchase_count") ?>',
        data: {
            date1: date1,
            date2: date2
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#count_purchase_all').html(data.all_purchase);
            $('#count_purchase_pending').html(data.pending);
            $('#count_purchase_approved').html(data.approved);
            $('#count_purchase_received').html(data.received);
        }
    })

}
</script>
<script>
function get_leave_monthly(e) {
    e.preventDefault();
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();

    first_date = document.getElementById('date_monthly').value;

    var data = "first_date=" + first_date;
    url = '<?= base_url("admin/dashboard/get_leave_monthly")?>';
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

function get_extra_present_monthly(e) {
    e.preventDefault();
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();

    first_date = document.getElementById('date_monthly').value;

    var data = "first_date=" + first_date;
    url = '<?= base_url("admin/dashboard/get_extra_present_monthly")?>';
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

function get_late_monthly(e) {
    e.preventDefault();
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();

    first_date = document.getElementById('date_monthly').value;

    var data = "first_date=" + first_date;
    url = '<?= base_url("admin/dashboard/get_late_monthly")?>';
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

function get_meeting_monthly(e) {
    e.preventDefault();
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();

    first_date = document.getElementById('date_monthly').value;

    var data = "first_date=" + first_date;
    url = '<?= base_url("admin/dashboard/get_movment_monthly")?>';
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

function get_mobile_bill(e) {
    e.preventDefault();
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    const date1 = $('#date_1_payroll').val();
    const date2 = $('#date_2_payroll').val();
    first_date = document.getElementById('date_1_payroll').value;
    second_date = document.getElementById('date_2_payroll').value;

    var data = "first_date=" + first_date + "&second_date=" + second_date;
    url = '<?= base_url("admin/dashboard/get_mobile_bill")?>';
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
function get_ta_da(e) {
    e.preventDefault();
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    const date1 = $('#date_1_payroll').val();
    const date2 = $('#date_2_payroll').val();
    first_date = document.getElementById('date_1_payroll').value;
    second_date = document.getElementById('date_2_payroll').value;

    var data = "first_date=" + first_date + "&second_date=" + second_date;
    url = '<?= base_url("admin/dashboard/get_ta_da")?>';
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
function get_lunch_paid(e) {
    e.preventDefault();
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    const date1 = $('#date_1_payroll').val();
    const date2 = $('#date_2_payroll').val();
    first_date = document.getElementById('date_1_payroll').value;
    second_date = document.getElementById('date_2_payroll').value;

    var data = "first_date=" + first_date + "&second_date=" + second_date;
    url = '<?= base_url("admin/dashboard/get_lunch_paid")?>';
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
function get_lunch_unpaid(e) {
    e.preventDefault();
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    const date1 = $('#date_1_payroll').val();
    const date2 = $('#date_2_payroll').val();
    first_date = document.getElementById('date_1_payroll').value;
    second_date = document.getElementById('date_2_payroll').value;

    var data = "first_date=" + first_date + "&second_date=" + second_date;
    url = '<?= base_url("admin/dashboard/get_lunch_unpaid")?>';
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
</script>
<script>
    function counter() {
        $(".counter").each(function () {
        var $this = $(this),
            countTo = $this.attr("data-countto");
        countDuration = parseInt($this.attr("data-duration"));
        $({ counter: $this.text() }).animate(
            {
            counter: countTo
            },
            {
            duration: countDuration,
            easing: "linear",
            step: function () {
                $this.text(Math.floor(this.counter));
            },
            complete: function () {
                $this.text(this.counter);
            }
            }
        );
        });
        
    }
</script>