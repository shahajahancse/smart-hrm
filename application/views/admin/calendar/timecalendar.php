<?php
/* Attendance Calendar view > hrsale
*/
  // dd($company);
  $this->load->model('Job_card_model');
  $this->load->model('Salary_model');

  $get_animate = $this->Xin_model->get_content_animate();
  $session = $this->session->userdata('username');

  if ($session['role_id'] == 3) {
    $user_info = $this->Attendance_model->get_emp_info(array($session['user_id']));
  } else {
    $employee_id = $this->input->post('employee_id');
    if($employee_id == ''){
      $user_info = $this->Attendance_model->get_emp_info(array($session['user_id']));
    } else {
      $user_info = $this->Attendance_model->get_emp_info(array($employee_id));
    }
  }
  // dd($user_info);
  $month_year = $this->input->post('month_year');
  $month_year = ($month_year != null && $month_year != '')? date('F Y',strtotime($month_year)):date('F Y');

  // get total present, absent, leave
  $end_t = date('t', strtotime($month_year));
  $start_date = date('Y-m-01', strtotime($month_year));
  $end_date = date("Y-m-$end_t", strtotime($month_year));
  $attendance = $this->Salary_model->count_attendance_status_wise($user_info[0]->user_id, $start_date, $end_date);
  $leavs = $this->Salary_model->leave_count_status($user_info[0]->user_id, $start_date, $end_date, 2);
  // dd($attendance);
?>


  <div class="box mb-4 <?php echo $get_animate;?>">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <?php $attributes = array('name' => 'xin-form', 'id' => 'xin-form', 'autocomplete' => 'off');?>
          <?php $hidden = array('_user' => $session['user_id']);?>
          <?php echo form_open('admin/timesheet/timecalendar/', $attributes, $hidden);?>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('xin_e_details_date');?></label>
                  <input class="form-control d_month_year" id='date' value="<?php if(!isset($month_year)): echo date('Y-m'); else: echo date('Y-m',strtotime($month_year)); endif;?>" name="month_year" type="text">
                </div>
              </div>

              <?php if($session['role_id'] != 3) { 
                $this->db->select('user_id, first_name, last_name')->where_in('status', array(1,4));
                $result = $this->db->get('xin_employees')->result(); ?>

                <div class="col-md-3">
                  <div class="form-group" id="employee_ajax">
                    <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
                    <select name="employee_id" id="employee_id" class="form-control employee-data" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>" required>
                      <option value=""></option>
                      <?php foreach($result as $row) {?>
                        <option value="<?php echo $row->user_id;?>"> <?php echo $row->first_name.' '.$row->last_name;?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              <?php } else { ?>
                <div class="col-md-3">
                  <div class="form-group" id="employee_ajax">
                  
                    <label for="employee"><?php echo $this->lang->line('xin_employee');?></label>
                    <select name="employee_id" id="employee_id" class="form-control employee-data" required>
                      <option value="<?php echo $user_info[0]->user_id;?>"> <?php echo $user_info[0]->first_name.' '.$user_info[0]->last_name;?></option>
                    </select>
                  </div>
                </div>
              <?php } ?>

              <div class="col-md-3">
                <div class="form-group">
                  <label for="first_name">&nbsp;</label>
                  <br />
                  <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_get'))); ?> </div>
              </div>
            </div>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>


  <div class="row <?php echo $get_animate;?>">
    <div class="col-md-4">
      <div class="box">
      
        <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $user_info[0]->first_name.' '.$user_info[0]->last_name;?> - <?php echo $month_year;?></h3>
        </div>
        <div class="box-body">
          <div class="table-responsive" data-pattern="priority-columns">
            <table class="table table-striped m-md-b-0">
              <tbody>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('left_company');?></th>
                  <td class="text-right"><?php echo $company->name;?></td>
                </tr>
                <tr>
                  <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_department');?></th>
                  <td class="text-right"><?php echo $user_info[0]->department_name;?></td>
                </tr>
                <tr>
                  <th scope="row" style="border-top:0px;"><?php echo $this->lang->line('left_designation');?></th>
                  <td class="text-right"><?php echo  $user_info[0]->designation_name;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('dashboard_employee_id');?></th>
                  <td class="text-right"><?php echo  $user_info[0]->employee_id;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('xin_attendance_total_present');?></th>
                  <td class="text-right"><?php echo $attendance->attend + $attendance->HalfDay;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('xin_attendance_total_absent');?></th>
                  <td class="text-right"><?php echo $attendance->absent;?></td>
                </tr>
                <tr>
                  <th scope="row"><?php echo $this->lang->line('xin_attendance_total_leave');?></th>
                  <td class="text-right"><?php echo $leavs->el + $leavs->sl;?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="box">
     
        <div class="box-body">
        <a onclick=empjobCard() class="btn btn-primary" style="float: left;margin-top: 25px;">Job card</a>
          <div id='calendar_hr'></div>
        </div>
      </div>
    </div>
  </div>



<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    jQuery('[data-plugin="select_hrm"]').select2({ width:'100%' });
  });
</script>



<style type="text/css">
  .popoverTitleCalendar{
    width: 100%;
    height: 100%;
    padding: 15px 15px;
    font-family: Roboto;
    font-size: 13px;
    border-radius: 5px 5px 0 0;
  }
  .popoverInfoCalendar i{
    font-size: 14px;
      margin-right: 10px;
      line-height: inherit;
      color: #d3d4da;
  }
  .popoverInfoCalendar p{
    margin-bottom: 1px;
  }
  .popoverDescCalendar{
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #E3E3E3;
    overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
  }
  .popover-title {
      background: transparent;
      font-weight: 600;
      padding: 0 !important;
      border: none;
  }
  .popover-content {
      padding: 15px 15px;
      font-family: Roboto;
      font-size: 13px;
  }
  .fc-center h2{
     text-transform: uppercase;
    font-size: 18px;
    font-family: Roboto;
    font-weight: 500;
    color: #505363;
    line-height: 32px;
  }
  .fc-toolbar.fc-header-toolbar {
      margin-bottom: 22px;
      padding-top: 22px;
  }
  .fc-agenda-view .fc-day-grid .fc-row .fc-content-skeleton {
      padding-bottom: 1em;
      padding-top: 1em;
  }
  .fc-day{
    transition: all 0.2s linear;
  }
  .fc-day:hover{
    background:#EEF7FF;
    cursor: pointer;
    transition: all 0.2s linear;
  }
  .fc-highlight {
      background: #EEF7FF;
      opacity: 0.7;
  }
  .fc-time-grid-event.fc-short .fc-time:before {
      content: attr(data-start);
      display: none;
  }
  .fc-time-grid-event.fc-short .fc-time span {
      display: inline-block;
  }
  .fc-time-grid-event.fc-short .fc-avatar-image {
      display: none;
      transition: all 0.3s linear;
  }
  .fc-time-grid .fc-bgevent, .fc-time-grid .fc-event {
      border: 1px solid #fff !important;
  }
  .fc-time-grid-event.fc-short .fc-content {
      padding: 4px 20px 10px 22px !important;
  }
  .fc-time-grid-event .fc-avatar-image{
      top: 9px;
  }
  .fc-event-vert {
    min-height: 22px;
  }
  .fc .fc-axis {
      vertical-align: middle;
      padding: 0 4px;
      white-space: nowrap;
      font-size: 10px;
      color: #505362;
      text-transform: uppercase;
      text-align: center !important;
      background-color: #fafafa;
  }
  .fc-unthemed .fc-event .fc-content, .fc-unthemed .fc-event-dot .fc-content {
      padding: 10px 20px 10px 22px;
      font-family: 'Roboto', sans-serif;
      margin-left: -1px;
      height: 100%;
  }
  .fc-event{
      border: none !important;
  }
  .fc-day-grid-event .fc-time {
      font-weight: 700;
        text-transform: uppercase;
  }
  .fc-unthemed .fc-day-grid td:not(.fc-axis).fc-event-container {
      padding: 0.2rem 0.5rem;
  }
  .fc-unthemed .fc-content, .fc-unthemed .fc-divider, .fc-unthemed .fc-list-heading td, .fc-unthemed .fc-list-view, .fc-unthemed .fc-popover, .fc-unthemed .fc-row, .fc-unthemed tbody, .fc-unthemed td, .fc-unthemed th, .fc-unthemed thead {
      border-color: #DADFEA;
  }
  .fc-ltr .fc-h-event .fc-end-resizer, .fc-ltr .fc-h-event .fc-end-resizer:before, .fc-ltr .fc-h-event .fc-end-resizer:after, .fc-rtl .fc-h-event .fc-start-resizer, .fc-rtl .fc-h-event .fc-start-resizer:before, .fc-rtl .fc-h-event .fc-start-resizer:after {
      left: auto;
      cursor: e-resize;
      background: none;
  }
  .colorAppointment :before {
      background-color: #9F4AFF;
      border-right: 1px solid rgba(255, 255, 255, 0.6);
      display: block;
      content: " ";
      position: absolute;
      height: 100%;
      width: 8px;
      border-radius: 3px 0 0 3px;
      top: 0;
      left: -1px;
  }
  .colorCheck-in :before {
      background-color: #ff4747;
      border-right: 1px solid rgba(255, 255, 255, 0.6);
      display: block;
      content: " ";
      position: absolute;
      height: 100%;
      width: 8px;
      border-radius: 3px 0 0 3px;
      top: 0;
      left: -1px;
  }
  .colorCheckout :before {
      background-color: #FFC400;
      border-right: 1px solid rgba(255, 255, 255, 0.6);
      display: block;
      content: " ";
      position: absolute;
      height: 100%;
      width: 8px;
      border-radius: 3px 0 0 3px;
      top: 0;
      left: -1px;
  }
  .colorInventory :before {
      background-color: #FE56F2;
      border-right: 1px solid rgba(255, 255, 255, 0.6);
      display: block;
      content: " ";
      position: absolute;
      height: 100%;
      width: 8px;
      border-radius: 3px 0 0 3px;
      top: 0;
      left: -1px;
  }
  .colorValuation :before {
      background-color: #0DE882;
      border-right: 1px solid rgba(255, 255, 255, 0.6);
      display: block;
      content: " ";
      position: absolute;
      height: 100%;
      width: 8px;
      border-radius: 3px 0 0 3px;
      top: 0;
      left: -1px;
  }
  .colorViewing :before {
      background-color: #26CBFF;
      border-right: 1px solid rgba(255, 255, 255, 0.6);
      display: block;
      content: " ";
      position: absolute;
      height: 100%;
      width: 8px;
      border-radius: 3px 0 0 3px;
      top: 0;
      left: -1px;
  }
  select.filter{
    width: 500px !important;
  }

  .popover  {
    background: #fff !important;
    color: #2E2F34;
    border: none;
    margin-bottom: 10px;
  }

  /*popover header*/
  .popover-title{
      background: #F7F7FC;
      font-weight: 600;
      padding: 15px 15px 11px ;
      border: none;
  }

  /*popover arrows*/
  .popover.top .arrow:after {
    border-top-color: #fff;
  }

  .popover.right .arrow:after {
    border-right-color: #fff;
  }

  .popover.bottom .arrow:after {
    border-bottom-color: #fff;
  }

  .popover.left .arrow:after {
    border-left-color: #fff;
  }

  .popover.bottom .arrow:after {
    border-bottom-color: #fff;
  }
  .material-icons {
    font-family: 'Material Icons';
    font-weight: normal;
    font-style: normal;
    font-size: 24px;  /* Preferred icon size */
    display: inline-block;
    line-height: 1;
    text-transform: none;
    letter-spacing: normal;
    word-wrap: normal;
    white-space: nowrap;
    direction: ltr;

    /* Support for all WebKit browsers. */
    -webkit-font-smoothing: antialiased;
    /* Support for Safari and Chrome. */
    text-rendering: optimizeLegibility;

    /* Support for Firefox. */
    -moz-osx-font-smoothing: grayscale;

    /* Support for IE. */
    font-feature-settings: 'liga';
  }
  .fc-icon-print::before{
    font-family: 'Material Icons';
    content: "\e8ad";
    font-size: 24px;
  }
  .fc-printButton-button{
    padding: 0 3px !important;
  }

  @media print {
  .print-visible  { display: inherit !important; }
  .hidden-print   { display: none !important; }
  }
</style>


<style type="text/css">
.calendar-options { padding: .3rem 0.4rem !important;}
.hide-calendar .ui-datepicker-calendar { display:none !important; }
.hide-calendar .ui-priority-secondary { display:none !important; }
</style>
<script>
  
  function empjobCard()
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
      var month = document.getElementById('date').value;  // Extract the year and month from the input string
      var [year, monthNumber] = month.split('-');

      // Create the first and last dates of the month
      var firstDate = new Date(year, monthNumber - 1, 2);
      var lastDate = new Date(year, monthNumber, 1);

      // Format the first and last dates as 'YYYY-MM-DD'
      var first_date = `${year}-${monthNumber}-01`;
      var second_date = lastDate.toISOString().split('T')[0];
      var sql = <?= $session['user_id'] ?>;
      if(first_date =='')
      {
        alert('Please select first date');
        return ;
      }
      if(second_date =='')
      {
        alert('Please select second date');
        return ;
      }
      
      var data = "first_date="+first_date+'&second_date='+second_date+'&sql='+sql;
      var url= '<?=base_url('admin/attendance/job_card')?>'

      // url = base_url + "/job_card";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
       ajaxRequest.send(data);
        // alert(url); return;

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest.responseText); return;
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
          a.document.write(resp);
          // a.close();
        }
      }
  }

</script>
