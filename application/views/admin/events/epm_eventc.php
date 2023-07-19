<?php

$total_event=count($allevent);

$this->db->select("*");
$this->db->where("start_event_date >=", date('Y-m-d'));
$this->db->order_by("event_id", "desc");
$upcomming_event = $this->db->get('xin_events')->result();
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

.cactive {
    color: #FFF;
    background: #2DCA8C;
}
</style>

<div class="divrow col-md-12" style="margin-bottom: 27px;margin-top: -15px!important;">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="h4">Total Event</div>
        <div class="h4"><?= $total_event ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="h4">Total Upcoming </div>
        <div class="h4"><?= $total_upcomming_event ?></div>
    </div>
    <div class="divstats-info col-md-6" style="background-color: #D2F9EE;display: flex;">
        <div class='col-md-6' style="display: flex;flex-direction: column;">
            <span class="h4">Upcoming Event</span>
            <span style="color: #1F1F1F;font-weight: 600;/* 143% */">
                <?= (isset($lastEvent->start_event_date))? date('d-M-Y H:i',strtotime($lastEvent->start_event_date.' '.$lastEvent->start_event_time)) : 'none'?>
            </span>
        </div>
        <div class='col-md-6'>
            <div class="h4"><?= (isset($lastEvent->event_title))? $lastEvent->event_title: '' ?></div>
        </div>
    </div>
</div>

<div class="col-md-12 medelbar" style="gap: 4px;align-items: end;margin-top:-10px;">
    <div class="col-md-2 divform-group " style="padding: 0;">
        <a href="<?= base_url('admin/events/epm_event')?>" class="cboton ">Event List</a>
    </div>
    <div class="col-md-2 divform-group" style="padding: 0;">
        <a href="<?= base_url('admin/leave/emp_holyday')?>" class="cboton">Yearly Holiday </a>
    </div>
    <div class="col-md-2 divform-group" style="padding: 0;">
        <a href="#" class="cboton cactive">Calendar</a>
    </div>
        <div >
        <!-- Year and month selection -->
        <div style="display:flex;    margin-left: 200px;">
            <button id="prevBtn" class=" btn btn-primary"><</button>
            <select id="month" class="form-control"></select>
            <select id="year" class="form-control"></select>
            <button id="nextBtn" class=" btn btn-primary">></button>
        </div>
    </div>
</div>
<div id="datatable" style="margin-top:100px"> 
    <!-- TOAST UI Calendar CSS -->
    <link rel="stylesheet" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />
    <!-- TOAST UI Calendar JavaScript dependencies -->
    <!-- Calendar container -->
    <div id="calendar" style="padding: 60px 10px 10px 15px"></div>
    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js"></script>
    <!-- TOAST UI Calendar JavaScript -->
    <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get current year and month
        const currentDate = new Date();
        let currentYear = currentDate.getFullYear();
        let currentMonth = currentDate.getMonth() + 1; // January is month 0

        // Function to update the calendar based on the selected year and month
        function updateCalendar() {
            const selectedYear = parseInt(document.getElementById("year").value);
            const selectedMonth = parseInt(document.getElementById("month").value);

            calendar.setDate(new Date(selectedYear, selectedMonth - 1, 1));
            calendar.changeView("month", true);
        }

        // Populate year dropdown with options
        const yearDropdown = document.getElementById("year");
        for (let year = currentYear - 5; year <= currentYear + 5; year++) {
            const option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            if (year === currentYear) {
                option.selected = true;
            }
            yearDropdown.appendChild(option);
        }

        // Populate month dropdown with options
        const monthDropdown = document.getElementById("month");
        for (let month = 1; month <= 12; month++) {
            const option = document.createElement("option");
            option.value = month;
            option.textContent = new Date(currentYear, month - 1, 1).toLocaleString('default', {
                month: 'long'
            });
            if (month === currentMonth) {
                option.selected = true;
            }
            monthDropdown.appendChild(option);
        }

        // Initialize the calendar with the current year and month
        const calendar = new tui.Calendar("#calendar", {
            defaultView: "month",
            useDetailPopup: true,
        });

        // Update the calendar when a new year or month is selected
        yearDropdown.addEventListener("change", updateCalendar);
        monthDropdown.addEventListener("change", updateCalendar);

        // Handle navigation with arrow buttons
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");

        prevBtn.addEventListener("click", function() {
            const prevDate = new Date(calendar.getDate().getTime());
            prevDate.setMonth(prevDate.getMonth() - 1);
            const prevYear = prevDate.getFullYear();
            const prevMonth = prevDate.getMonth() + 1;
            yearDropdown.value = prevYear;
            monthDropdown.value = prevMonth;
            updateCalendar();
        });

        nextBtn.addEventListener("click", function() {
            const nextDate = new Date(calendar.getDate().getTime());
            nextDate.setMonth(nextDate.getMonth() + 1);
            const nextYear = nextDate.getFullYear();
            const nextMonth = nextDate.getMonth() + 1;
            yearDropdown.value = nextYear;
            monthDropdown.value = nextMonth;
            updateCalendar();
        });

        // Fetch holidays and events from CI controller using AJAX
        fetchHolidaysAndEvents();

        function fetchHolidaysAndEvents() {
            // Make an AJAX request to your CI controller to get the data
            // Adjust the URL to the actual URL of your CI controller that provides the data
            fetch("<?= base_url( 'admin/events/data')?>")
                .then(response => response.json())
                .then(data => {
                    // Add the fetched holidays and events to the calendar
                    console.log(data);
                    calendar.createSchedules(data);
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                });
        }
    });
    </script>


</div>