<?php

$total_event=count($allevent);

$this->db->select("*");
$this->db->where("start_date >=", date('Y-m-d'));
$this->db->order_by("holiday_id", "desc");
$upcomming_event = $this->db->get('xin_holidays')->result();
$total_upcomming_event=count($upcomming_event);
if($total_upcomming_event!=0){
    $lastEvent = end($upcomming_event);
}
?>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/emp_attandenc.css') ?>">

<style>
    
.cboton {
    color: #000;
    /* font-family: Roboto; */
    font-size: 14px;
    font-weight: 600;
    display: flex;
    height: 42px;
    justify-content: center;
    align-items: center;
    gap: 10px;
    border-radius: 2px;
    border: 1px solid #9d9797;
 
}
.cactive{
    color: #FFF;
    background: #2DCA8C;
}
</style>

<div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="h4">Total Holyday</div>
        <div class="h4"><?= $total_event ?></div>
    </div>

    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="h4">Total Upcoming </div>
        <div class="h4"><?= $total_upcomming_event ?></div>
    </div>
    <div class="divstats-info col-md-6" style="background-color: #D2F9EE;display: flex;">
    <div class='col-md-5' style="display: flex;flex-direction: column;">
        <span class="h4">Upcoming  Event</span>
        <span style="color: #1F1F1F;font-size: 16px;font-style: normal;font-weight: 600;/* 143% */"><?= (isset($lastEvent->start_date))? date('d-M-Y',strtotime($lastEvent->start_date)) : 'none'?></span>

    </div>
    <div class='col-md-7'>
        <div class="h4"><?= (isset($lastEvent->event_name))? $lastEvent->event_name: '' ?></div>
    </div>

       
    </div>

</div>
<div class="col-md-12 medelbar" style="gap: 4px;margin: 2px;align-items: end;">
    <div class="col-md-2 divform-group " style="padding: 0;">
        <a href="<?= base_url('admin/events/epm_event')?>" class="cboton ">Event List</a>
    </div>
    <div class="col-md-2 divform-group" style="padding: 0;">
        <a href="<?= base_url('admin/leave/emp_holyday')?>" class="cboton cactive">Yearly Holiday  </a>
    </div>
    <div class="col-md-2 divform-group" style="padding: 0;">
        <a  href="<?= base_url('admin/events/alle')?>" class="cboton">Calendar</a>
    </div>
    <div class="col-md-2 divform-group">
    </div>
    <div class="col-md-3 divform-group" style="padding: 0;">
        <div class="input">
            <div class="level">Select Date</div>
            <div class="pseudo6">
                <input onchange=getdata(this) style="width: 98%;border: none;cursor: pointer;" type="date" name=""
                    value="<?= date('Y-m-d') ?>" id="datef">
            </div>
        </div>
    </div>

</div>
<div id="datatable">
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
        url: '<?php echo base_url('admin/leave/emp_holyday'); ?>',
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

