<?php
$userid  = $session[ 'user_id' ];

?>
<?php
    $this->db->where('user_id',$userid);
    $emp=$this->db->get('xin_employees')->row(); 

    $this->db->where('emp_id',$userid);
    $this->db->where('year',date('Y'));
    $emp_leave=$this->db->get('leave_balanace')->row(); 
   $earn=(empty($emp_leave))?0:$emp_leave->el_balanace;
   
   $sick=(empty($emp_leave))?0:$emp_leave->sl_balanace;
    $is_leave_on=$emp->is_leave_on;
?>
<?php
$leavecal=leave_cal($userid);
$leave_calel=get_cal_leave($userid, 1);
$leave_calsl=get_cal_leave($userid, 2);
?>
<style>
body {
    font-family: 'Fira Mono', monospace;
}

.list-group>li:nth-child(5n+1) {
    border-top: 1px solid rgba(0, 0, 0, .125);
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
}

.list-group>li:nth-child(5n+0) {
    border-bottom-left-radius: .25rem;
    border-bottom-right-radius: .25rem;
}

.pagination-container {
    justify-content: right !important;
    display: flex !important;
}

#customModal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: -webkit-fill-available;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    padding: 4px 35px;
    margin: 8% 0% 0% 23%;
    border: 1px solid #888;
    width: 65%;
    overflow: auto;
}
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.texta {
    padding: 18px;
}

.timediv {
    padding: 0;
    display: flex;
    flex-direction: row;
    gap: 11px;
}

@media screen and (max-width: 992px) {
    .timediv {
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 11px;
    }

    .modal-content {
        padding: 14px;
    }
}

@media screen and (max-width: 762px) {
    .modal-content {
        margin: 19% 0% 0% 26%;
    }

    .texta {
        padding: 0;
    }
}

@media screen and (max-width: 400px) {
    .modal-content {
        margin: 27% 0% 0% 12%;
        width: 256px;
    }
}

</style>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/emp_attandenc.css') ?>">


<div id="customModal">
    <?php $attributes = array('name' => 'add_leave', 'autocomplete' => 'off', 'enctype'=>'multipart/form-data');?>
    <?php $hidden = array('_user' => $session['user_id']);?>
    <?php echo form_open('admin/timesheet/add_leave', $attributes, $hidden);?>
    <input type="hidden" name="company_id" id="company_id" value="1" />
    <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $userid; ?>"> />
    <div class="modal-content">
        <div class="col-md-12" style="height: 30px;">
            <span id="close" class="close"><svg style="width: 20px;height: 20px;flex-shrink: 0;"
                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path
                        d="M18.0002 4H6.41453C6.15184 3.99995 5.89172 4.05167 5.64903 4.15221C5.40634 4.25275 5.18585 4.40013 5.00016 4.58594L0.292969 9.29281C-0.0976562 9.68344 -0.0976562 10.3166 0.292969 10.7069L5.00016 15.4141C5.37516 15.7891 5.88391 16 6.41422 16H18.0002C19.1048 16 20.0002 15.1047 20.0002 14V6C20.0002 4.89531 19.1048 4 18.0002 4ZM15.3536 11.9394C15.5489 12.1347 15.5489 12.4513 15.3536 12.6466L14.6467 13.3534C14.4514 13.5487 14.1348 13.5487 13.9395 13.3534L12.0002 11.4141L10.0608 13.3534C9.86547 13.5487 9.54891 13.5487 9.35359 13.3534L8.64672 12.6466C8.45141 12.4513 8.45141 12.1347 8.64672 11.9394L10.5861 10L8.64672 8.06063C8.45141 7.86531 8.45141 7.54875 8.64672 7.35344L9.35359 6.64656C9.54891 6.45125 9.86547 6.45125 10.0608 6.64656L12.0002 8.58594L13.9395 6.64656C14.1348 6.45125 14.4514 6.45125 14.6467 6.64656L15.3536 7.35344C15.5489 7.54875 15.5489 7.86531 15.3536 8.06063L13.4142 10L15.3536 11.9394Z"
                        fill="#858A8F" />
                </svg>
            </span>
        </div>
        <div class="col-md-12 timediv" style="padding: 0;">
            <div class="col-md-4" style="padding: 0;">
                <div class="input">
                    <div class="level">Select Leave Type **</div>
                    <div class="pseudo6">
                        <select id="leave_type" name="leave_type" style="width: 98%;border: none;cursor: pointer;"
                            required>
                            <option value="">Select Leave Type**</option>
                            <option value="1" <?=($earn == 0)?'disabled':'' ?>>Earn Leave (<?=$earn?>)</option>
                            <option value="2" <?=($sick == 0)?'disabled':'' ?>>Sick Leave (<?=$sick?>)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="padding: 0;">
                <div class="input">
                    <div class="level">Select Start Date**</div>
                    <div class="pseudo6">
                        <input name="start_date" value="<?= date('Y-m-d') ?>" 
                        class="col-md-12 "
                            style="width: 98%;border: none;cursor: pointer;" type="date"   name="" id="start_date"
                            required>
                    </div>
                </div>

            </div>
            <div class="col-md-3" style="padding: 0;">
                <div class="input">
                    <div class="level">Select End Date**</div>
                    <div class="pseudo6">
                        <input name="end_date" value="<?= date('Y-m-d') ?>" class="col-md-12"
                            style="width: 98%;border: none;cursor: pointer;" type="date" name=""  id="end_date" required>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <br />
                    <input type="checkbox" class="form-control minimal" value="1" id="leave_half_day"
                        name="leave_half_day">
                    <label><?php echo $this->lang->line('xin_hr_leave_half_day');?></span> </label>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group texta">
                <label for="summary"> Leave Reason** </label>
                <textarea class="form-control" placeholder="Describe your leave reason" name="reason" cols="30" rows="5"
                    id="reason" required></textarea>
            </div>
        </div>
        
        <div class="col-md-9" style="padding: 0;margin: 1%;">
                <div class="input">
                    <div class="level">Select A file **</div>
                    <div class="pseudo6">
                        <input name="attachment" value="<?= date('Y-m-d') ?>" class="col-md-12"
                            style="width: 98%;border: none;cursor: pointer;" type="file" name="" accept=".png, .jpg, .jpeg, .pdf" id="end_date">
                    </div>
                </div>
            </div>
        <div class="col-md-12">
            <div class="form-actions box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick= closeModal()>Close</button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>


<div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="heading">Total Earn Leave</div>
        <div class="heading2"><?=(empty($emp_leave))?0:$emp_leave->el_total?></div>
    </div>

    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="heading">Total Sick Leave</div>
        <div class="heading2"><?= (empty($emp_leave))?0:$emp_leave->sl_total?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
        <div class="heading">Remaining Earn Leave</div>
        <div class="heading2"><?=  (empty($emp_leave))?0:$emp_leave->el_balanace ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
        <div class="heading">Remaining Sick Leave</div>
        <div class="heading2"><?= (empty($emp_leave))?0:$emp_leave->sl_balanace ?></div>
    </div>
</div>
<div class="col-md-12 medelbar">
    <div class="col-md-10"
        style="color: #000;font-family: Roboto;font-size: 15px;font-style: normal;line-height: 43.5px;text-transform: capitalize;font-weight: bold;">
        Are you want to take a leave? Please make sure to leave the request form to HR/ Admin. </div>
   <?php if($is_leave_on == 1){?>
        <a class="col-md-2" id="openModal"
        style="text-align-last: right;color: white;display: flex;height: 41px;padding: 4px 17px;cursor: pointer;justify-content: center;align-items: center;gap: 10px;border-radius: 4px;border: 1px solid var(--b, #599AE7);background: var(--b, #599AE7);">
        Leave Request
    </a>
    <?php }?>

</div>
<div class="col-md-12 medelbar">
    <div class="col-md-3 divform-group">
        <div class="input">
            <div class="level">Select Date</div>
            <div class="pseudo6">
                <input onchange=getdata(this) style="width: 98%;border: none;cursor: pointer;" type="date" name=""
                    value="<?= date('Y-m-d') ?>" id="datef">
            </div>
        </div>

    </div>
    <div class="col-md-3 divform-group">
        <div class="input">
            <div class="level">Select Month</div>
            <div class="pseudo6">
                <input onchange=getdata(this) id="month" style="width: 98%;border: none;cursor: pointer;" type="month"
                    value="<?= date('Y-m') ?>" name="" id="">
            </div>
        </div>

    </div>
    <div class="col-md-3 divform-group">
        <div class="input">
            <?php $years = range(1900, strftime("%Y", time())); 
            $years = array_reverse($years);
            
            ?>
            <div class="level">Select Year</div>
            <div class="pseudo6">
                <select onchange=getdata(this) id="year" style="width: 98%;border: none;cursor: pointer;">
                    <option>Select Year</option>
                    <?php foreach($years as $year) : ?>
                    <option <?= ($year==date('Y')) ? 'selected' : '' ?> value="<?php echo $year; ?>">
                        <?php echo $year; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

    </div>
    <div class="col-md-3 divform-group">
      
        <button onclick="getyarly_data()" value="" class="input serceb">
            Get yearly report  <span class="label label-danger">New</span>
       </button>
    </div>

</div>


<div style="clear: both;">
    <?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success" id="flash_message" style="text-align: center;padding: 6px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo $this->session->flashdata('success');?>
    </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')):?>
    <div class="alert alert-danger" id="flash_message" style="text-align: center;padding: 6px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo $this->session->flashdata('error');?>
    </div>
    <?php endif; ?>
</div>

<div id="datatable" class="table-responsive">
    <?php echo $tablebody;?>
</div>


<script>
function getdata(status) {

    // console.log(status.id);
    if (status.id == 'datef') {
        var firstdate = document.getElementById('datef').value
        var seconddate = document.getElementById('datef').value
    } else if (status.id == 'month') {
        var date = new Date(document.getElementById('month').value);


        var firstDate = new Date(date.getFullYear(), date.getMonth(), 2);

        // Get the last date of the month by setting the day to 0 (which gives the last day of the previous month) and adding 1 day
        var lastDate = new Date(date.getFullYear(), date.getMonth() + 1, 1);

        // Format the dates as strings in the format 'YYYY-MM-DD'
        var firstdate = firstDate.toISOString().slice(0, 10);
        var seconddate = lastDate.toISOString().slice(0, 10);

    } else if (status.id == 'year') {
        var date = document.getElementById('year').value;
        var firstDate = new Date(date, 0, 1); // Month is zero-based, so 0 represents January
        var lastDate = new Date(date, 11, 31); // Month is zero-based, so 11 represents December

        // Format the dates as strings
        var firstdate = firstDate.toDateString();
        var seconddate = lastDate.toDateString();
    }
    $.ajax({
        url: '<?php echo base_url('admin/leave/emp_leave'); ?>',
        method: 'POST',
        data: {
            firstdate: firstdate,
            seconddate: seconddate
        },
        success: function(resp) {
            $('#datatable').empty();
            $('#datatable').html(resp);
        }
    });
}
</script>

<script>
function openModal() {

    document.getElementById("customModal").style.display = "block";
}

function closeModal() {
    document.getElementById("customModal").style.display = "none";
}

document.getElementById("openModal").addEventListener("click", openModal);
document.getElementById("close").addEventListener("click", closeModal);
</script>

<script>
function calculateDays() {
    var startDate = new Date(document.getElementById('start_date').value);
    var endDate = new Date(document.getElementById('end_date').value);
    var checkpoint = document.getElementById('leave_half_day');



    // Calculate the time difference in milliseconds
    var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());

    // Calculate the number of days
    var days = Math.ceil(timeDiff / (1000 * 3600 * 24));
    if (days + 1 > 1) {
        checkpoint.setAttribute('disabled', 'disabled');
    } else {
        checkpoint.removeAttribute('disabled');
    }
}
// Event listeners for date input changes
document.getElementById('start_date').addEventListener('change', calculateDays);
document.getElementById('end_date').addEventListener('change', calculateDays);
</script>

<script>
    function getyarly_data() {
        var year = document.getElementById('year').value;
        Swal.fire({
            title: 'You Selected ' + year,
            text: 'If not please select another year',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Generate it!'
        }).then((result) => {
            if (result.value) {
                var url = '<?php echo base_url('admin/reports/getyarly_data'); ?>';
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: { year: year },
                    success: function(resp) {
                        var a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
                        a.document.write(resp);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an error generating the report'
                        });
                    }
                });
            } 
        });
    }
</script>

