<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
<?php

 $all_policies = $this->db->select('*')->from('xin_company_policy')->order_by('policy_id', 'DESC')->get()->result_array();

$session = $this->session->userdata('username');

$system = $this->Xin_model->read_setting_info(1);
$company_info = $this->Xin_model->read_company_setting_info(1);
$user = $this->Xin_model->read_employee_info($session['user_id']);
$theme = $this->Xin_model->read_theme_info(1);

?>

<?php $site_lang = $this->load->helper('language');?>
<?php $wz_lang = $site_lang->session->userdata('site_lang');?>
<?php
if(!empty($wz_lang)):
    $lang_code = $this->Xin_model->get_language_info($wz_lang);
    $flg_icn = $lang_code[0]->language_flag;
    $flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
elseif($system[0]->default_language!=''):
    $lang_code = $this->Xin_model->get_language_info($system[0]->default_language);
    $flg_icn = $lang_code[0]->language_flag;
    $flg_icn = '<img src="'.base_url().'uploads/languages_flag/'.$flg_icn.'">';
else:
    $flg_icn = '<img src="'.base_url().'uploads/languages_flag/gb.gif">';
endif;
?>

<?php
  $role_user = $this->Xin_model->read_user_role_info($user[0]->user_role_id);
if(!is_null($role_user)) {
    $role_resources_ids = explode(',', $role_user[0]->role_resources);
} else {
    $role_resources_ids = explode(',', 0);
}
//$designation_info = $this->Xin_model->read_designation_info($user_info[0]->designation_id);
// set color
if($theme[0]->is_semi_dark==1):
    $light_cls = 'navbar-semi-dark navbar-shadow';
    $ext_clr = '';
else:
    $light_cls = 'navbar-dark';
    $ext_clr = $theme[0]->top_nav_dark_color;
endif;
// set layout / fixed or static
if($theme[0]->boxed_layout=='true') {
    $lay_fixed = 'container boxed-layout';
} else {
    $lay_fixed = '';
}
if($theme[0]->animation_style == '') {
    $animated = 'animated flipInY';
} else {
    $animated = 'animated '.$theme[0]->animation_style;
}
?>

<style type="text/css">
.main-header .sidebar-toggle-hrsale-chat:before {
    content: "\f0e6";
}

.main-header .sidebar-toggle-hrsale-quicklinks:before {
    content: "\f00a";
}
</style>

<style>
.loaderss {
    --c1: #673b14;
    --c2: #0177bc;
    width: 40px;
    height: 80px;
    border-top: 4px solid var(--c1);
    border-bottom: 4px solid var(--c1);
    background: linear-gradient(90deg, var(--c1) 2px, var(--c2) 0 5px, var(--c1) 0) 50%/7px 8px no-repeat;
    display: grid;
    overflow: hidden;
    animation: l5-0 2s infinite linear;
}

.loaderss::before,
.loaderss::after {
    content: "";
    grid-area: 1/1;
    width: 75%;
    height: calc(50% - 4px);
    margin: 0 auto;
    border: 2px solid var(--c1);
    border-top: 0;
    box-sizing: content-box;
    border-radius: 0 0 40% 40%;
    -webkit-mask: linear-gradient(#000 0 0) bottom/4px 2px no-repeat,
        linear-gradient(#000 0 0);
    -webkit-mask-composite: destination-out;
    mask-composite: exclude;
    background: linear-gradient(var(--d, 0deg), var(--c2) 50%, #0000 0) bottom /100% 205%,
        linear-gradient(var(--c2) 0 0) center/0 100%;
    background-repeat: no-repeat;
    animation: inherit;
    animation-name: l5-1;
}

.loaderss::after {
    transform-origin: 50% calc(100% + 2px);
    transform: scaleY(-1);
    --s: 3px;
    --d: 180deg;
}

@keyframes l5-0 {
    80% {
        transform: rotate(0)
    }

    100% {
        transform: rotate(0.5turn)
    }
}

@keyframes l5-1 {

    10%,
    70% {
        background-size: 100% 205%, var(--s, 0) 100%
    }

    70%,
    100% {
        background-position: top, center
    }
}
</style>
<div id="inn_loader" style="display: block;position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 99999999999999999999900000000000000000000;background: #ffffffcf;">
  <div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
    <img src="<?php echo base_url('innlode.gif') ?>" alt="">
  </div>
</div>






<style>
marquee {
    /*      font-size: 30px;*/
    font-weight: 800;
    color: #fff;
    font-family: sans-serif;
}

.switch {
    position: relative;
    display: inline-block;
    width: 120px;
    height: 34px;
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
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
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
    transform: translateX(85px);
}

/*------ ADDED CSS ---------*/
.slider:after {
    content: 'Floor';
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
    content: 'Meeting';
}

/*--------- END --------*/
</style>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Notification Details</h4>
            </div>
            <div class="modal-body">
                <p>Name : <span id="emname"></span> </p>
                <p>Leave Type : <span id="leaveType"></span></p>
                <p>Applyed day : <span id="qty"></span></p>
                <p>From Date : <span id="fromDate"></span></p>
                <p>To date : <span id="toDate"></span></p>
                <p>status : <span id="statuss"></span></p>

                <a href="" class="btn btn-primary" id="details">Details</a>
            </div>
        </div>
    </div>
</div>
<div id="warning_add_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Details</h4>
            </div>
            <div class="modal-body">
                <form id="warning_add_form">
                    <input type="hidden" name="user_id" id="warning_user_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="warning_date" id="warning_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Warning</label>
                                <textarea name="warning_remarks" id="warning_remarks"
                                    style="height: 71px; width: -webkit-fill-available;"></textarea>
                            </div>
                        </div>
                        <div class="float-right mr-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="salary_review_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Salary Review</h4>
            </div>
            <div class="modal-body">
                <form id="salary_review_form">
                    <input type="hidden" name="user_id" id="salary_review_user_id">
                    <div class="row">

                        <div class="col-md-12">
                            <h4>Employee Name: <span id="salary_review_emp_name"></span></h4>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-6">
                                <label for=""> Old Salary</label>
                                <input class="form-control" type="number" id="salary_review_old_amount" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""> New Salary</label>
                                <input type="number" class="form-control" id="salary_review_new_amount" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="">Remarks</label>
                            <textarea name="salary_review_remark" style="width:-webkit-fill-available; height: 64px;"
                                id="salary_review_remark"></textarea>
                        </div>
                        <div class="float-right mr-3">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
.boxm {
    padding: 20px;
    border: 2px solid #3F51B5;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    background-color: #F5F5F5;
    margin: 18px;
}

p {
    margin: 0;
    font-size: 18px;
    color: #333;
}

#location {
    font-weight: bold;
    color: #3F51B5;
}

#outtime,
#outreason {
    font-style: italic;
}
</style>
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('admin/dashboard/');?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><img alt="<?php echo $system[0]->application_name;?>"
                    src="<?php echo base_url();?>uploads/logo/<?php echo $company_info[0]->logo;?>" class="brand-logo"
                    style="width:32px;"></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img alt="<?php echo $system[0]->application_name;?>"
                src="<?php echo base_url();?>uploads/logo/<?php echo $company_info[0]->logo;?>" class="brand-logo"
                style="width:32px;"> <b><?php echo $system[0]->application_name;?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"
            title="<?php echo $this->lang->line('xin_sidebar_title');?>">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <?php if($system[0]->module_chat_box=='true') {?>
        <a href="<?php echo site_url('admin/chat');?>" class="sidebar-toggle sidebar-toggle-hrsale-chat" role="button"
            title="<?php echo $this->lang->line('xin_hr_chat_box');?>">
            <?php $unread_msgs = $this->Xin_model->get_single_unread_message($session['user_id']);?>
            <?php if($unread_msgs > 0) {?><span class="chat-badge label label-aqua"
                id="msgs_count"><?php echo $unread_msgs;?></span><?php } ?>
        </a>
        <?php } ?>
        <style>
        .notli {
            padding: 1px;
            margin: 10px;
            border-radius: 11px;
            box-shadow: 0px 0px 1px 3px #c3c3c3;
        }

        .menu::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        .menu::-webkit-scrollbar {
            width: 7px;
            background-color: #F5F5F5;
        }

        .menu::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #555;
        }
        </style>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a data-toggle="modal" data-target="#companyPolicyModal">
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                        <span class="label" style="font-size: 12px !important; background: #fb0202 !important">nt</span>
                    </a>
                </li>

                <?php
                $fcount = 0;
                if(in_array($user[0]->user_role_id, array(1,2,4))) {
                    $leaveapp = $this->Xin_model->get_notify_leave_applications();
                    $start_date = date('Y-m-d', strtotime('-6 month', strtotime(date("Y-m-01"))));
                    $end_date = date('Y-m-d', strtotime('+3 month', strtotime(date("Y-m-t"))));
                    $incrementapp = $this->Xin_model->get_notify_incr_prob_applications($start_date, $end_date, 1);
                    $probationapp = $this->Xin_model->get_notify_incr_prob_applications($start_date, $end_date, 5);
                    $internapp = $this->Xin_model->get_notify_incr_prob_applications($start_date, $end_date, 4);
                    $fcount = count($leaveapp) + count($incrementapp) + count($probationapp) + count($internapp);
                    ?>


                <?php } elseif ($user[0]->user_role_id == 3) {
                    $leaveapp = $this->Xin_model->get_notify_leave_applications_by_userid($user[0]->user_id);
                    $incrementapp =[];
                    $probationapp =[];
                    $internapp=[];
                    $fcount = count($leaveapp) + count($incrementapp) + count($probationapp);
                }  ?>
                <style>
                .lir {
                    cursor: pointer !important;
                }

                .menu>li>a>.nrcolor {
                    color: #ff0101 !important;
                }

                .menu>li>a>.ngcolor {
                    color: #037c29 !important;
                }

                .navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a {
                    margin: 0;
                    padding: 3px 1px;
                }

                .navbar-custom-menu>.navbar-nav>li>.dropdown-menu {
                    position: absolute;
                    right: 0;
                    left: auto;
                    box-shadow: 0px 0px 11px 4px #686868;
                }
                </style>
                <?php if (in_array($user[0]->user_role_id, array(1,2,3,4))) { ?>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"
                        title="<?php echo $this->lang->line('header_notifications');?>">
                        <i class="fa fa-bell-o"></i>
                        <span class="label"
                            style="font-size: 12px !important; background: #fb0202 !important"><?php echo $fcount;?></span>
                    </a>
                    <?php if($fcount > 0) {?>
                    <ul class="dropdown-menu menu <?php echo $animated;?>">
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <?php if(count($leaveapp) > 0) {?>
                            <ul class="menu">
                                <div class="callout callout-hrsale-bg-leave callout-hrsale">
                                    <p><?php echo $this->lang->line('xin_leave_notifications');?><span
                                            style="color: #d30505; padding: 4px; font-weight: bolder;"><?=count($leaveapp) ?>
                                    </p>
                                </div>
                                <?php foreach($leaveapp as $row) {?>
                                <?php
                              $emp_info = $this->Xin_model->read_user_info($row->employee_id);?>
                                <?php
                            if(!is_null($emp_info)) {
                                $emp_name = $emp_info[0]->first_name. ' '.$emp_info[0]->last_name;
                            } else {
                                $emp_name = '--';
                            }
                            if($row->status==1) {
                                $statuss="Pending. Please wait";
                            } elseif ($row->status==2) {
                                $statuss="Approved";
                            } elseif ($row->status==3) {
                                $statuss="Rejected";
                            } elseif ($row->status==4) {
                                $statuss="First Stage Approval.";
                            } else {
                                $statuss="--";
                            }
                                    ?>
                                <li class="notli">
                                    <!-- start message -->
                                    <?php
                                    $roolid=$session['role_id'];
                                    if($roolid==3) {
                                        ?>
                                    <a onclick='modal_leave_data_ajax(<?php echo $row->leave_id ?>)'
                                        data-target="#edit-leave-modal-data" data-toggle="modal"
                                        style="cursor: pointer;" data-leave_id="<?php echo $row->leave_id ?>"
                                        data-emname="<?php echo $emp_name ?>"
                                        data-company_id="<?php echo $row->company_id ?>"
                                        data-employee_id="<?php echo $row->employee_id ?>"
                                        data-department_id="<?php echo $row->department_id ?>"
                                        data-leave_type_id="<?php echo $row->leave_type_id ?>"
                                        data-leave_type="<?php echo $row->leave_type ?>"
                                        data-qty="<?php echo $row->qty ?>"
                                        data-from_date="<?php echo $row->from_date ?>"
                                        data-to_date="<?php echo $row->to_date ?>"
                                        data-applied_on="<?php echo $row->applied_on ?>"
                                        data-reason="<?php echo $row->reason ?>"
                                        data-remarks="<?php echo $row->remarks ?>"
                                        data-status="<?php echo $row->status ?>"
                                        data-is_half_day="<?php echo $row->is_half_day ?>"
                                        data-notify_leave="<?php echo $row->notify_leave ?>"
                                        data-leave_attachment="<?php echo $row->leave_attachment ?>"
                                        data-created_at="<?php echo $row->created_at ?>"
                                        data-current_year="<?php echo $row->current_year ?>">
                                        <?php
                                    } else {
                                        ?>
                                        <a
                                            href="<?php echo site_url('admin/timesheet/leave_details/id')?>/<?php echo $row->leave_id;?>/">
                                            <?php } ?>
                                            <div class="pull-left">
                                                <?php  if($emp_info[0]->profile_picture!='' && $emp_info[0]->profile_picture!='no file') {?>
                                                <img src="<?php  echo base_url().'uploads/profile/'.$emp_info[0]->profile_picture;?>"
                                                    alt="" id="user_avatar" class="img-circle user_profile_avatar">
                                                <?php } else {?>
                                                <?php  if($emp_info[0]->gender=='Male') { ?>
                                                <?php 	$de_file = base_url().'uploads/profile/default_male.jpg';?>
                                                <?php } else { ?>
                                                <?php 	$de_file = base_url().'uploads/profile/default_female.jpg';?>
                                                <?php } ?>
                                                <img src="<?php  echo $de_file;?>" alt="" id="user_avatar"
                                                    class="img-circle user_profile_avatar">
                                                <?php  } ?>
                                            </div>
                                            <h4> <?php echo $emp_name;?> </h4>
                                            <p>applied for leave
                                                <?php echo $this->Xin_model->set_date_format($row->applied_on);?></p>
                                            <p><?= $statuss ?></p>
                                        </a>
                                </li>
                                <?php } ?>
                            </ul>
                            <br>
                            <?php } ?>
                            <?php if(count($incrementapp) > 0) {?>
                            <ul class="menu">
                                <div class="callout callout-hrsale" style="background: #0691d3; color: white;">
                                    <p>Increment notifications <span
                                            style="color: #d30505; padding: 4px; font-weight: bolder;"><?=count($incrementapp) ?>
                                    </p>
                                </div>
                                <?php foreach($incrementapp as $row) {?>
                                <?php
                                        $ipdate = $row->notify_incre_prob;
                                        $red_zone = date('Y-m-d', strtotime('-20 days', strtotime(date($ipdate))));
                                    ?>
                                <li class="lir notli">
                                    <!-- start message -->
                                    <a onclick="incrementFun(<?php echo $row->user_id; ?>)">
                                        <div class="pull-left">
                                            <?php  if($row->profile_picture!='' && $row->profile_picture!='no file') {?>
                                            <img src="<?php  echo base_url('uploads/profile/'.$row->profile_picture);?>"
                                                alt="" id="user_avatar" class="img-circle user_profile_avatar">
                                            <?php } else {?>
                                            <?php  if($row->gender=='Male') { ?>
                                            <?php   $de_file = base_url().'uploads/profile/default_male.jpg';?>
                                            <?php } else { ?>
                                            <?php   $de_file = base_url().'uploads/profile/default_female.jpg';?>
                                            <?php } ?>
                                            <img src="<?php  echo $de_file;?>" alt="" id="user_avatar"
                                                class="img-circle user_profile_avatar">
                                            <?php  } ?>
                                        </div>
                                        <h4 class="<?php echo ($red_zone < date('Y-m-d')) ? 'nrcolor' : 'ngcolor' ?>">
                                            <?php echo $row->first_name. ' '.$row->last_name;?> </h4>
                                        <p class="<?php echo ($red_zone < date('Y-m-d')) ? 'nrcolor' : 'ngcolor' ?>">
                                            Increment on <?php echo date("d-M-Y", strtotime($ipdate));?> </p>
                                    </a>
                                </li>
                                <?php } ?>

                                <?php
                                $this->db->select('*');
                                $this->db->from('xin_employees');
                                $this->db->where('salary_review_is',1);
                                $this->db->where('salary_review_date between "'.date('Y-m-d', strtotime('-1 month')).'" and "'.date('Y-m-d', strtotime('+2 month')).'"');
                                $review_list= $this->db->get()->result();
                                foreach( $review_list as $row){?>

                                <li class="lir notli">
                                    <!-- start message -->
                                    <a onclick="salary_review_modal_a(<?php echo $row->user_id; ?>)">
                                        <div class="pull-left">
                                            <?php  if($row->profile_picture!='' && $row->profile_picture!='no file') {?>
                                            <img src="<?php  echo base_url('uploads/profile/'.$row->profile_picture);?>"
                                                alt="" id="user_avatar" class="img-circle user_profile_avatar">
                                            <?php } else {?>
                                            <?php  if($row->gender=='Male') { ?>
                                            <?php   $de_file = base_url().'uploads/profile/default_male.jpg';?>
                                            <?php } else { ?>
                                            <?php   $de_file = base_url().'uploads/profile/default_female.jpg';?>
                                            <?php } ?>
                                            <img src="<?php  echo $de_file;?>" alt="" id="user_avatar"
                                                class="img-circle user_profile_avatar">
                                            <?php  } ?>
                                        </div>
                                        <h4 class="">
                                            <?php echo $row->first_name. ' '.$row->last_name;?> </h4>
                                        <p class="">
                                            Review on <?php echo date("d-M-Y", strtotime($row->salary_review_date));?>
                                        </p>
                                    </a>
                                </li>
                                <?php }

                                ?>




                            </ul>
                            <br>
                            <?php } ?>
                            <?php if(count($internapp) > 0) {?>
                            <ul class="menu">
                                <div class="callout callout-hrsale" style="background: #0691d3; color: white;">
                                    <p>Intern notifications <span
                                            style="color: #d30505; padding: 4px; font-weight: bolder;"><?=count($internapp) ?>
                                    </p>
                                </div>
                                <?php foreach($internapp as $row) {?>
                                <?php
                                        $ipdate = $row->notify_incre_prob;
                                    $red_zone = date('Y-m-d', strtotime('-20 days', strtotime(date($ipdate))));
                                    ?>
                                <li class="lir notli">
                                    <!-- start message -->
                                    <a onclick="incrementFun(<?php echo $row->user_id; ?>)">
                                        <div class="pull-left">
                                            <?php  if($row->profile_picture!='' && $row->profile_picture!='no file') {?>
                                            <img src="<?php  echo base_url('uploads/profile/'.$row->profile_picture);?>"
                                                alt="" id="user_avatar" class="img-circle user_profile_avatar">
                                            <?php } else {?>
                                            <?php  if($row->gender=='Male') { ?>
                                            <?php   $de_file = base_url().'uploads/profile/default_male.jpg';?>
                                            <?php } else { ?>
                                            <?php   $de_file = base_url().'uploads/profile/default_female.jpg';?>
                                            <?php } ?>
                                            <img src="<?php  echo $de_file;?>" alt="" id="user_avatar"
                                                class="img-circle user_profile_avatar">
                                            <?php  } ?>
                                        </div>
                                        <h4 class="<?php echo ($red_zone < date('Y-m-d')) ? 'nrcolor' : 'ngcolor' ?>">
                                            <?php echo $row->first_name. ' '.$row->last_name;?> </h4>
                                        <p class="<?php echo ($red_zone < date('Y-m-d')) ? 'nrcolor' : 'ngcolor' ?>">
                                            Intern on <?php echo date("d-M-Y", strtotime($ipdate));?> </p>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                            <br>
                            <?php } ?>
                            <?php if(count($probationapp) > 0) {?>
                            <ul class="menu">
                                <div class="callout callout-hrsale" style="background: #6266df; color: white;">
                                    <p>Probation notifications <span
                                            style="color: #d30505; padding: 4px; font-weight: bolder;"><?=count($probationapp) ?></span>
                                    </p>
                                </div>
                                <?php foreach($probationapp as $row) {?>
                                <?php
                                      $ipdate = $row->notify_incre_prob;
                                    $red_zone = date('Y-m-d', strtotime('-20 days', strtotime(date($ipdate))));
                                    ?>
                                <li class="lir notli">
                                    <!-- start message -->
                                    <a onclick="incrementFun(<?php echo $row->user_id; ?>)">
                                        <div class="pull-left">
                                            <?php  if($row->profile_picture!='' && $row->profile_picture!='no file') {?>
                                            <img src="<?php  echo base_url('uploads/profile/'.$row->profile_picture);?>"
                                                alt="" id="user_avatar" class="img-circle user_profile_avatar">
                                            <?php } else {?>
                                            <?php  if($row->gender=='Male') { ?>
                                            <?php   $de_file = base_url().'uploads/profile/default_male.jpg';?>
                                            <?php } else { ?>
                                            <?php   $de_file = base_url().'uploads/profile/default_female.jpg';?>
                                            <?php } ?>
                                            <img src="<?php  echo $de_file;?>" alt="" id="user_avatar"
                                                class="img-circle user_profile_avatar">
                                            <?php  } ?>
                                        </div>
                                        <h4 class="<?php echo ($red_zone < date('Y-m-d')) ? 'nrcolor' : 'ngcolor' ?>">
                                            <?php echo $row->first_name. ' '.$row->last_name;?> </h4>
                                        <p class="<?php echo ($red_zone < date('Y-m-d')) ? 'nrcolor' : 'ngcolor' ?>">
                                            Probation on <?php echo date("d-M-Y", strtotime($ipdate));?> </p>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                    </ul>
                    <?php } ?>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <!-- User Account: style can be found in dropdown.less -->
                <?php }  if($user[0]->user_role_id == 1) { ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true"
                        title="<?php echo $this->lang->line('header_configuration');?>">
                        <i class="fa fa-qrcode"></i>
                    </a>
                    <ul class="dropdown-menu <?php echo $animated;?>">
                        <?php if($system[0]->module_recruitment=='true') {?>
                        <?php if($system[0]->enable_job_application_candidates=='1') {?>
                        <?php  if(in_array('50', $role_resources_ids)) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" target="_blank" href="<?php echo site_url('jobs');?>"><i
                                    class="fa fa-newspaper-o"></i><?php echo $this->lang->line('left_jobs_listing');?>
                            </a>
                        </li>
                        <?php  } ?>
                        <?php  } ?>
                        <?php  } ?>
                        <?php  if($user[0]->user_role_id == 1) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/constants');?>">
                                <i class="fa fa-align-justify"></i><?php echo $this->lang->line('left_constants');?></a>
                        </li>
                        <?php } ?>
                        <?php  if($user[0]->user_role_id == 1) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/custom_fields');?>"> <i
                                    class="fa fa-sliders"></i><?php echo $this->lang->line('xin_hrsale_custom_fields');?></a>
                        </li>
                        <?php } ?>
                        <?php  if($user[0]->user_role_id==1) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/roles');?>"> <i
                                    class="fa fa-unlock-alt"></i><?php echo $this->lang->line('xin_role_urole');?></a>
                        </li>
                        <?php } ?>
                        <?php  if(in_array('93', $role_resources_ids)) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings/modules');?>"> <i
                                    class="fa fa-life-ring"></i><?php echo $this->lang->line('xin_setup_modules');?></a>
                        </li>
                        <?php } ?>
                        <?php  if(in_array('63', $role_resources_ids)) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1"
                                href="<?php echo site_url('admin/settings/email_template');?>"> <i
                                    class="fa fa-envelope"></i><?php echo $this->lang->line('left_email_templates');?></a>
                        </li>
                        <?php } ?>
                        <?php  if(in_array('92', $role_resources_ids)) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/employees/import');?>"> <i
                                    class="fa fa-users"></i><?php echo $this->lang->line('xin_import_employees');?></a>
                        </li>
                        <?php } ?>
                        <?php  if(in_array('62', $role_resources_ids)) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1"
                                href="<?php echo site_url('admin/settings/database_backup');?>"> <i
                                    class="fa fa-database"></i><?php echo $this->lang->line('header_db_log');?></a>
                        </li>
                        <?php } ?>
                        <?php  if(in_array('94', $role_resources_ids)) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/theme');?>"> <i
                                    class="fa fa-columns"></i><?php echo $this->lang->line('xin_theme_settings');?></a>
                        </li>
                        <?php } ?>
                        <?php if(in_array('118', $role_resources_ids)) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1"
                                href="<?php echo site_url('admin/settings/payment_gateway');?>"> <i
                                    class="fa fa-cc-visa"></i><?php echo $this->lang->line('xin_acc_payment_gateway');?></a>
                        </li>
                        <?php } ?>
                        <?php if($system[0]->module_orgchart=='true') {?>
                        <?php if(in_array('96', $role_resources_ids)) { ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/organization/chart');?>">
                                <i class="fa fa-sitemap"></i><?php echo $this->lang->line('xin_org_chart_title');?></a>
                        </li>
                        <?php } ?>
                        <?php } ?>
                        <?php if(in_array('60', $role_resources_ids)) { ?>
                        <li class="divider"></li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings');?>"> <i
                                    class="fa fa-cog text-aqua"></i><?php echo $this->lang->line('header_configuration');?></a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <?php if($user[0]->user_role_id == 1) {?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true"
                        title="<?php echo $this->lang->line('xin_languages');?>">
                        <?php echo $flg_icn;?>
                    </a>
                    <ul class="dropdown-menu <?php echo $animated;?>">
                        <?php $languages = $this->Xin_model->all_languages();?>
                        <?php foreach($languages as $lang):?>
                        <?php $flag = '<img src="'.base_url().'uploads/languages_flag/'.$lang->language_flag.'">';?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1"
                                href="<?php echo site_url('admin/dashboard/set_language/').$lang->language_code;?>"><?php echo $flag;?>
                                &nbsp; <?php echo $lang->language_name;?></a>
                        </li>
                        <?php endforeach;?>
                        <?php if($system[0]->module_language=='true') {?>
                        <?php  if(in_array('89', $role_resources_ids)) { ?>
                        <li class="divider"></li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/languages');?>"> <i
                                    class="fa fa-cog text-aqua"></i><?php echo $this->lang->line('left_settings');?></a>
                        </li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                </li>
                <?php } ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true"
                        title="<?php echo $this->lang->line('header_my_profile');?>">
                        <i class="glyphicon glyphicon-user"></i>
                    </a>
                    <ul class="dropdown-menu <?php echo $animated;?>">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/profile');?>"> <i
                                    class="ion ion-person"></i><?php echo $this->lang->line('header_my_profile');?></a>
                        </li>
                        <?php if($user[0]->user_role_id == 1) { ?>
                        <li role="presentation">
                            <a data-toggle="modal" data-target=".policy" href="#"> <i
                                    class="fa fa-flag-o"></i><?php echo $this->lang->line('header_policies');?></a>
                        </li>

                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/settings');?>"> <i
                                    class="ion ion-settings"></i><?php echo $this->lang->line('left_settings');?></a>
                        </li>


                        <li role="presentation">
                            <a role="menuitem" tabindex="-1"
                                href="<?php echo site_url('admin/profile?change_password=true');?>"> <i
                                    class="fa fa-key"></i><?php echo $this->lang->line('header_change_password');?></a>
                        </li>
                        <li class="divider"></li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/auth/lock');?>"> <i
                                    class="fa fa-lock"></i><?php echo $this->lang->line('xin_lock_user');?></a>
                        </li>
                        <?php } ?>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="<?php echo site_url('admin/logout');?>"> <i
                                    class="fa fa-power-off text-red"></i><?php echo $this->lang->line('header_sign_out');?></a>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <?php if ($user[0]->user_role_id == 1) {?>

                <!-- <li>
                    <a href="#" data-toggle="control-sidebar"
                        title="<?php echo $this->lang->line('xin_role_layout_settings');?>"><i
                            class="fa fa-cog fa-spin"></i></a>
                </li> -->

                <?php }
                ?>

            </ul>
        </div>
    </nav>
</header>
<style>
.myboxx {
    display: flex;
    padding: 0;
    margin: 0;
    border-radius: 5px;
    box-shadow: 0px 0px 2px 2px #e5e5e5;
    flex-direction: column;
}

.myboxx_header {
    background: #dddddd;
    color: black;
    font-size: 17px;
    width: -webkit-fill-available;
    border-bottom: 1px solid #979797;
    text-align: center;
}

.myboxx_body {
    color: black;
    font-size: 15px;
    padding: 5px;
    width: -webkit-fill-available;
}

td,
th {
    padding: 0 !important;
}
</style>
<div id="edit-leave-modal-data" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <form action="<?= base_url('admin/timesheet/modal_leave_update') ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Leave Application</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding: 7px 0px;display: flex;gap: 16px;">
                        <div class="col-md-6 myboxx">
                            <div class="myboxx_header">
                                Employee Information
                            </div>
                            <div class="myboxx_body">
                                <table class="table table-bordered col-md-12" style="margin: 0;">
                                    <tr>
                                        <th style="padding: 3px 8px!important;">Employee Name</th>
                                        <td style="padding: 3px 8px!important;" id="employee_name_m"></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 3px 8px!important;">Department</th>
                                        <td style="padding: 3px 8px!important;" id="department_name_m"></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 3px 8px!important;">Designation</th>
                                        <td style="padding: 3px 8px!important;" id="designation_name_m"></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 3px 8px!important;">Basic Salary</th>
                                        <td style="padding: 3px 8px!important;" id="basic_salary_m"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6 myboxx">
                            <div class="myboxx_header">
                                Leave Status
                            </div>
                            <div class="myboxx_body">
                                <div class="box-block card-dashboard">
                                    <div id="leave-statistics">
                                        <p><strong>Earn leave (<span id="leave_count_el_p"></span>/<span
                                                    id="leave_count_el_total"></span>)</strong></p>
                                        <div class="progress" style="margin: 7px;height: 19px;background: aqua;">
                                            <div class="progress-bar" id="leave_count_el_prog"
                                                style="background: #ff8484;width: 100%;"></div>
                                        </div>
                                        <div id="leave-statistics">
                                            <p><strong>Sick leave (<span id="leave_count_sl_p"></span>/<span
                                                        id="leave_count_sl_total"></span>)</strong></p>
                                            <div class="progress" style="margin: 7px;height: 19px;background: aqua;">
                                                <div class="progress-bar" id="leave_count_sl_prog"
                                                    style="background: #ff8484;width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding: 7px 0px;display: flex;gap: 16px;">
                        <div class="col-md-12 myboxx">
                            <div class="myboxx_header">
                                Leave Information
                            </div>
                            <div class="myboxx_body">
                                <div class="col-md-6"
                                    style="padding: 5px;border: 1px solid #cfcfcf;border-radius: 4px;">
                                    <table class="table table-bordered col-md-12" style="margin: 0;">
                                        <tr>
                                            <th style="padding: 3px 8px!important;">Leave Type</th>
                                            <td style="padding: 3px 8px!important;" id="leave_type_m"></td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 3px 8px!important;">Application Date</th>
                                            <td style="padding: 3px 8px!important;" id="application_date_m"></td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 3px 8px!important;">Attachment</th>
                                            <td style="padding: 3px 8px!important;"><a href="" id="attachment_m"
                                                    target="_blank" class="btn btn-primary btn-sm"><i
                                                        class="fa fa-download"></i> Download</a></td>
                                        </tr>

                                    </table>
                                    <label for=""> Reason</label>
                                    <textarea style="width: 412px; height: 64px;" id="reason_m" readonly></textarea>
                                </div>
                                <div class="col-md-6"
                                    style="padding: 5px;border: 1px solid #cfcfcf;border-radius: 4px;">
                                    <table class="table table-bordered col-md-12" style="margin: 0;">
                                        <tr>
                                            <th style="padding: 3px 8px!important;">From Date</th>
                                            <td style="padding: 3px 8px!important;" colspan="2"><input type="date"
                                                    id="from_date_m" name="from_date" value="<?=date('Y-m-d')?>"></td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 3px 8px!important;">To Date</th>
                                            <td style="padding: 3px 8px!important;" colspan="2"><input type="date"
                                                    id="to_date_m" name="to_date" value="<?=date('Y-m-d')?>"></td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 3px 8px!important;">Total Days</th>
                                            <td style="padding: 3px 8px!important;"><input onchange=checkhulf()
                                                    type="text" name="total_days" id="total_days_m" value="1"></td>
                                            <td> <input type="checkbox" onchange=checkhulf() id="Half_Day_m"
                                                    name="Half_Day"> Halfday </td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 3px 8px!important;">Status</th>
                                            <td style="padding: 3px 8px!important;">
                                                <select class="form-control" id="status_m" name="status"
                                                    <?=$user[0]->user_role_id==3 ? $user[0]->is_emp_lead != 2 ? 'disabled' : '' : ''?>>
                                                    <option value="1">Pending</option>
                                                    <option value="4">First Level Approval</option>
                                                    <?php if (in_array($user[0]->user_role_id, array(1,2))) { ?>
                                                    <option value="2">Approved</option>
                                                    <?php } ?>
                                                    <option value="3">Rejected</option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th style="padding: 3px 8px!important;">Team Lead Comment</th>
                                            <td style="padding: 3px 8px!important;" colspan="2">
                                                <textarea type="text" name="team_lead_comment" id="team_lead_comment"
                                                    <?= $user[0]->is_emp_lead != 2 ? 'disabled' : ''?>> </textarea>
                                                <input type="hidden" name="team_lead_approved" id="team_lead_approved"
                                                    value='<?= $user[0]->is_emp_lead != 2 ? 0 : 1?>'>

                                            </td>
                                        </tr>
                                        <?php  if($user[0]->user_role_id !=3 ): ?>
                                        <tr>
                                            <th style="padding: 3px 8px!important;">Remark</th>
                                            <td style="padding: 3px 8px!important;" colspan="2">
                                                <input type="text" name="remark" id="remark_m">
                                            </td>
                                        </tr>
                                        <?php endif; ?>


                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="leave_id" id="leave_id_m" />
                    <input type="hidden" name="emp_id" id="emp_id_m" />
                    <?php if ($user[0]->is_emp_lead == 2 || $user[0]->user_role_id !=3)  { ?>
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    <?php } ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- policy modal -->

<div class="modal fade" id="companyPolicyModal" tabindex="-1" role="dialog" aria-labelledby="companyPolicyModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="companyPolicyModalLabel">Company Policy</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <?php foreach($all_policies as $key => $policy) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <h3 class="card-title"><?= $policy['title']?></h2>
                                    <p class="card-text">
                                        <?= $policy['description']?>
                                    </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Increment modal -->
<div class="modal fade " id="increment-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card" style="padding:10px">
                <h3 style="margin-left:15px">Employee Form</h3>
                <?php $attributes = array('id' => 'modal_form', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
                <?php $hidden = array('user_id' => $session['user_id']);?>
                <?php echo form_open('admin/employees/manual_attendance', $attributes, $hidden);?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label> Employee Name </label>
                        <input disabled class="form-control" id="emp_id" name="emp_id" value="">
                    </div>
                </div>
                <input type="hidden" id="hidden_emp_id">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Current Department</label>
                        <input disabled class="form-control" id="old_dept_id" name="old_dept_id" value="">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Current Designation</label>
                        <input disabled class="form-control" id="old_desig_id" name="old_desig_id" value="">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Joining Date</label>
                        <input disabled class="form-control" id="joining_date" name="joining_date" value="" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label> Select Status</label>
                        <select class="form-control" id="emp_status" name="status">
                            <option value="" disabled selected>Select Status</option>
                            <option value="1">Probation to Regular</option>
                            <option value="2">Increment</option>
                            <option value="3">Promotion</option>
                            <option value="4">Intern to Probation</option>
                            <option value="5">Intern to Regular</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6" id="new_dept">
                    <div class="form-group">
                        <label>New Department</label>
                        <select class="form-control" id="new_dept_id" name="new_dept_id">
                            <option value="" disabled selected>Select Department</option>
                            <?php $results = $this->db->get('xin_departments')->result(); ?>
                            <?php foreach ($results as $key => $row) { ?>
                            <option value="<?= $row->department_id ?>"><?= $row->department_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6" id="new_desig">
                    <div class="form-group">
                        <label>New Designation</label>
                        <select class="form-control" id="new_desig_id" name="new_desig_id">
                            <option value="" disabled selected>Select Designation</option>
                            <?php $results = $this->db->get('xin_designations')->result(); ?>
                            <?php foreach ($results as $key => $row) { ?>
                            <option value="<?= $row->designation_id ?>"><?= $row->designation_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Current Salary</label>
                        <input class="form-control" id="old_salary" name="old_salary" value="" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>New Salary</label>
                        <input class="form-control" type="number" id="new_salary" name="new_salary" value="" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Effective Date</label>
                        <input class="form-control attendance_date" id="effective_date" name="effective_date"
                            value="" />
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>End Date</label>
                        <input class="form-control attendance_date" id="notify_incre_prob" name="notify_incre_prob"
                            value="" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea name="remarks" style="width: 853px; height: 75px;"></textarea>
                    </div>
                </div>

                <button id="button" class="btn btn-sm btn-primary pull-right "
                    style="margin-right:16px;margin-bottom:20px">Submit</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#movementform').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the form data
        var formData = $(this).serialize();

        // Make an AJAX post request to the controller
        $.ajax({
            url: '<?= base_url('admin/movement_floor/outformsub') ?>', // Replace 'controller/method' with your actual controller and method
            method: 'POST',
            data: formData,
            success: function(response) {
                // Handle the success response

                alert(response);
                location.reload();
                // Process the response data returned from the controller
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the request

                alert(error);
                location.reload();
            }
        });
    });
    $('#movementinform').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get the form data
        var formData = $(this).serialize();

        // Make an AJAX post request to the controller
        $.ajax({
            url: '<?= base_url('admin/movement_floor/informsub') ?>', // Replace 'controller/method' with your actual controller and method
            method: 'POST',
            data: formData,
            success: function(response) {
                // Handle the success response

                alert(response);
                location.reload();
                // Process the response data returned from the controller
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the request

                alert(error);
                location.reload();
            }
        });
    });








    // Month & Year
    $('.attendance_date').datepicker({
        changeMonth: true,
        changeYear: true,
        // maxDate: '0',
        dateFormat: 'yy-mm-dd',
        altField: "#date_format",
        altFormat: js_date_format,
        yearRange: '1970:' + addOneYear(),
        beforeShow: function(input) {
            $(input).datepicker("widget").show();
        }
    });

    // form submit to insert participant list
    $("#modal_form").on("submit", function(e) {
        e.preventDefault();

        // validation here
        if ($('#emp_status').val() === null) {
            $('#emp_status').focus();
            $('#emp_status').attr('style', 'border: 1px solid red !important');
            return false;
        } else {
            $("#emp_status").attr('style', 'border: 1px solid #ccd6e6 !important');
            if ($('#emp_status').val() != 2) {
                if ($('#new_dept_id').val() === null) {
                    $('#new_dept_id').focus();
                    $('#new_dept_id').attr('style', 'border: 1px solid red !important');
                    return false;
                } else {
                    $("#new_dept_id").attr('style', 'border: 1px solid #ccd6e6 !important');
                }

                if ($('#new_desig_id').val() === null) {
                    $('#new_desig_id').focus();
                    $('#new_desig_id').attr('style', 'border: 1px solid red !important');
                    return false;
                } else {
                    $("#new_desig_id").attr('style', 'border: 1px solid #ccd6e6 !important');
                }
            }
        }

        if ($('#new_salary').val() == '') {
            $('#new_salary').focus();
            $('#new_salary').attr('style', 'border: 1px solid red !important');
            return false;
        } else {
            $("#new_salary").attr('style', 'border: 1px solid #ccd6e6 !important');
        }

        if ($('#effective_date').val() == '') {
            $('#effective_date').focus();
            $('#effective_date').attr('style', 'border: 1px solid red !important');
            return false;
        } else {
            $("#effective_date").attr('style', 'border: 1px solid #ccd6e6 !important');
        }

        if ($('#notify_incre_prob').val() == '') {
            $('#notify_incre_prob').focus();
            $('#notify_incre_prob').attr('style', 'border: 1px solid red !important');
            return false;
        } else {
            $("#notify_incre_prob").attr('style', 'border: 1px solid #ccd6e6 !important');
        }
        // end validation

        // ajax request on form submit
        var emp_id = $('#hidden_emp_id').val();
        var sendData = $(this).serialize();
        var targetUrl = "<?=base_url('admin/employees/incre_prob_prom_add/')?>" + emp_id;
        $.ajax({
            url: targetUrl,
            type: "POST",
            data: sendData,
            dataType: "json",
            success: function(response) {
                if (response.success == true) {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
                location.reload();
            },
        });

    });

    // reset modal value
    $('#modal_form').on('hidden.bs.modal', function() {
        $('#new_salary').val('');
        $('#effective_date').val('');
        $('#notify_incre_prob').val('');
        $("#new_salary").attr('style', 'border: 1px solid #ccd6e6 !important');
        $("#effective_date").attr('style', 'border: 1px solid #ccd6e6 !important');
        $("#notify_incre_prob").attr('style', 'border: 1px solid #ccd6e6 !important');
    });
});


function addOneYear() {
    date = new Date().getFullYear();
    return date + 2;
}
</script>

<script>
function incrementFun(id) {
    $('#new_dept').hide();
    $('#new_desig').hide();

    var url = "<?php echo base_url('admin/employees/fetch_user_info_ajax/');?>" + id;
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            // console.log(response);
            $('#hidden_emp_id').val(id);
            $('#emp_id').val(response[0].first_name + ' ' + response[0].last_name);
            $('#old_dept_id').val(response[0].department_name);
            $('#old_desig_id').val(response[0].designation_name);
            $('#joining_date').val(response[0].date_of_joining);
            $('#old_salary').val(response[0].basic_salary);


            $('#designation_id').val(response[0].designation_id);
            $('#designation').val(response[0].designation_name);
        }
    });
    $("#increment-modal").modal("show");
}

$("#emp_status").change(function() {
    if ($("#emp_status").val() == 2) {
        $('#new_dept').hide();
        $('#new_desig').hide();
    } else {
        $('#new_dept').show();
        $('#new_desig').show();
    }
})
</script>
<script>
$(document).ready(function() {
    $('#myModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var leaveId = button.data('leave_id');
        var emname = button.data('emname');
        var companyId = button.data('company_id');
        var employeeId = button.data('employee_id');
        var departmentId = button.data('department_id');
        var leaveTypeId = button.data('leave_type_id');
        var leaveType = button.data('leave_type');
        var qty = button.data('qty');
        var fromDate = button.data('from_date');
        var toDate = button.data('to_date');
        var appliedOn = button.data('applied_on');
        var reason = button.data('reason');
        var remarks = button.data('remarks');
        var status = button.data('status');
        var isHalfDay = button.data('is_half_day');
        var notifyLeave = button.data('notify_leave');
        var leaveAttachment = button.data('leave_attachment');
        var createdAt = button.data('created_at');
        var currentYear = button.data('current_year');
        if (status == 1) {
            statuss = "Pending";
        } else if (status == 2) {
            statuss = "First Stage Approval";
        } else if (status == 3) {
            statuss = "Rejected";
        } else if (status == 4) {
            statuss = "Approved";
        } else {
            statuss = "--";
        }

        $('#emname').text(emname);
        $('#leaveType').text(leaveType);
        $('#qty').text(qty);
        $('#fromDate').text(fromDate);
        $('#toDate').text(toDate);
        $('#appliedOn').text(appliedOn);
        $('#reason').text(reason);
        $('#remarks').text(remarks);
        $('#statuss').text(statuss);
        var url = "<?php echo site_url('admin/timesheet/leave_details/id')?>/" + leaveId + "/";
        var button = document.getElementById("details");
        button.href = url;
    });
});
</script>
<script>
function movetype() {
    $("#floorform").toggle();
    $("#meetingform").toggle();
    $("#sub").toggle();

}
</script>
<script>
function modal_leave_data_ajax(id) {
    $.ajax({
        type: 'get',
        url: '<?= base_url("admin/timesheet/modal_leave_data_ajax/") ?>' + id,
        success: function(response) {
            if (response) {
                var result = JSON.parse(response).result;

                var leave_calel = JSON.parse(response).leave_calel;
                var leave_calel_percent = JSON.parse(response).leave_calel_percent;
                var leave_calsl = JSON.parse(response).leave_calsl;
                var leave_calsl_percent = JSON.parse(response).leave_calls_percent;

                var leave_totalsl = JSON.parse(response).leave_totalsl;
                var leave_totalel = JSON.parse(response).leave_totalel;

                $('#employee_name_m').html(result.first_name + ' ' + result.last_name);
                $('#leave_id_m').val(result.leave_id);
                $('#department_name_m').html(result.department_name);
                $('#designation_name_m').html(result.designation_name);
                $('#basic_salary_m').html(result.basic_salary);
                $('#team_lead_comment').html(result.team_lead_comment);
                if (result.team_lead_approved == 1) {
                    $('#team_lead_approved').val(1);
                }

                $('#leave_count_el_p').html(leave_calel);
                $('#leave_count_sl_p').html(leave_calsl);

                $('#leave_count_sl_total').html(leave_totalsl);
                $('#leave_count_el_total').html(leave_totalel);

                $('#leave_count_el_prog').css('width', `${leave_calel_percent}%`);
                $('#leave_count_sl_prog').css('width', `${leave_calsl_percent}%`);
                console.log(result.leave_type_id);
                if (result.leave_type === 'el') {
                    $('#leave_type_m').html('Earn Leave');
                } else {
                    $('#leave_type_m').html('Sick Leave');
                }

                $('#application_date_m').html(result.applied_on);
                if (result.leave_attachment == '') {
                    $('#attachment_m').css("display", "none");

                }
                $('#attachment_m').attr('href', '<?= base_url('uploads/leave') ?>' + result
                    .leave_attachment);
                $('#from_date_m').val(result.from_date);
                $('#to_date_m').val(result.to_date);
                $('#total_days_m').val(result.qty);
                $('#reason_m').val(result.reason);
                if (result.is_half_day == 1) {
                    $('#Half_Day_m').attr('checked', 'checked');
                } else {
                    $('#Half_Day_m').removeAttr('checked');
                }

                $('#status_m').val(result.status);

                $('#remark_m').val(result.remarks);
                $('#emp_id_m').val(result.employee_id);
            }
        },
        error: function(response) {

        }
    })
}
</script>
<script>
function employee_warning(id) {
    $('#warning_user_id').val(id);
    $('#warning_add_modal').modal('show');
}
</script>
<script>
function salary_review_modal_a(id) {
    $('#salary_review_user_id').val(id);
    $('#salary_review_emp_name').empty();
    $('#salary_review_old_amount').empty();
    $('#salary_review_new_amount').empty();
    $('#salary_review_remark').empty();
    $('#salary_review_modal').modal('show');
    $.ajax({
        type: 'post',
        url: '<?= base_url('admin/employees/get_imployee_info') ?>',
        data: {
            id: id
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#salary_review_emp_name').text(data.first_name + ' ' + data.last_name);
            $('#salary_review_old_amount').val(data.salary);
        }


    })

}
</script>
<script>
$('#salary_review_form').submit(function(e) {
    e.preventDefault();
    var salary_review_user_id = $('#salary_review_user_id').val();
    var salary_review_new_amount = $('#salary_review_new_amount').val();
    var salary_review_remark = $('#salary_review_remark').val();
    var targetUrl = "<?=base_url('admin/employees/salary_review_form/')?>"
    $.ajax({
        url: targetUrl,
        type: "POST",
        data: {
            salary_review_user_id: salary_review_user_id,
            salary_review_new_amount: salary_review_new_amount,
            salary_review_remark: salary_review_remark
        },
        success: function(response) {
            showSuccessAlert('Update Success');
        }
    })
})
</script>
<script>
$('#salary_review_form').submit(function(e) {
    e.preventDefault();
    var warning_user_id = $('#warning_user_id').val();
    var warning_date = $('#warning_date').val();
    var warning_remarks = $('#warning_remarks').val();
    var targetUrl = "<?=base_url('admin/employees/add_employee_warning/')?>"
    $.ajax({
        url: targetUrl,
        type: "POST",
        data: {
            warning_user_id: warning_user_id,
            warning_date: warning_date,
            warning_remarks: warning_remarks
        },
        success: function(response) {
            showSuccessAlert('Successfully added');
        }

    })


})
</script>
