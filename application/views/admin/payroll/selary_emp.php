<?php

$userid  = $session[ 'user_id' ];
$lastmonthsalarys  = $this->Salary_model->getpassedmonthsalary($userid);
//dd($lastmonthsalarys);
if(count($lastmonthsalarys)>0) {


    $lastmonthsalaryy =$lastmonthsalarys[0];

    $lastmont=$lastmonthsalarys[0]->salary_month;
    $date_object = DateTime::createFromFormat('Y-m', $lastmont);
    $monthName = $date_object->format('M-Y');

}
// dd($lastmonthsalaryy);
?>


<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">

<div class="monthname">
    <?= (isset($lastmonthsalaryy)) ? $monthName : '----' ?> Month Salary Summery
</div>
<div class="divrow col-md-12">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="heading">Total Salary</div>
        <div class="heading2"><?=(isset($lastmonthsalaryy)) ? $lastmonthsalaryy->basic_salary : '0'?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="heading">Deduction</div>
        <div class="heading2">
            <?=  (isset($lastmonthsalaryy)) ? $lastmonthsalaryy->late_deduct+$lastmonthsalaryy->absent_deduct+$lastmonthsalaryy->lunch_deduct : '0'?>
        </div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
        <div class="heading">Modify Salary</div>
        <div class="heading2"><?= (isset($lastmonthsalaryy)) ? $lastmonthsalaryy->modify_salary : '0' ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
        <div class="heading">Pay Salary </div>
        <div class="heading2"><?=  (isset($lastmonthsalaryy)) ? $lastmonthsalaryy->modify_salary+$lastmonthsalaryy->grand_net_salary : '0'?></div>
    </div>
</div>

<div class="titel_sec_head col-md-3">
    <div>Salary Information</div>

</div>
<div class="titel_sec_head2 col-md-4">
    <input type="month" class="datesec" id="monthYearInput" value="<?= date('Y-m')?>">
    <a class="btn btns">Submit</a>

</div>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">SL</th>
                <th scope="col">Month</th>
                <th scope="col">Amount</th>
                <th scope="col">Payroll Type</th>
                <th scope="col">Slip</th>
            </tr>
        </thead>
        <tbody>
            <?php
      foreach  ($result as $key=>$value) { ?>
            <tr>
                <td scope="row"><?= $key+1 ?></td>
                <td scope="row"><?= date('M-Y', strtotime($value->salary_month)) ?></td>
                <td scope="row"><?= $value->grand_net_salary ?></td>
                <td scope="row">Monthly</td>
                <td scope="row"><a onclick="payslip('<?= $value->salary_month ?>',<?= $userid ?>,'1')"><svg
                            style="width: 20px;height: 21px;" xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                            viewBox="0 0 24 25" fill="none">
                            <path
                                d="M20.3391 5.37695L16.4062 1.44414C15.9844 1.02227 15.4125 0.783203 14.8172 0.783203H5.25C4.00781 0.787891 3 1.7957 3 3.03789V22.5379C3 23.7801 4.00781 24.7879 5.25 24.7879H18.75C19.9922 24.7879 21 23.7801 21 22.5379V6.9707C21 6.37539 20.7609 5.79883 20.3391 5.37695ZM18.5672 6.78789H15V3.2207L18.5672 6.78789ZM5.25 22.5379V3.03789H12.75V7.91289C12.75 8.53633 13.2516 9.03789 13.875 9.03789H18.75V22.5379H5.25ZM16.9781 15.802C16.4063 15.2395 14.775 15.3941 13.9594 15.4973C13.1531 15.0051 12.6141 14.3254 12.2344 13.327C12.4172 12.5723 12.7078 11.4238 12.4875 10.702C12.2906 9.47383 10.7156 9.5957 10.4906 10.4254C10.2844 11.1801 10.4719 12.2301 10.8188 13.5707C10.35 14.691 9.65156 16.1957 9.15937 17.0582C8.22187 17.541 6.95625 18.2863 6.76875 19.2238C6.61406 19.9645 7.9875 21.8113 10.3359 17.7613C11.3859 17.4145 12.5297 16.9879 13.5422 16.8191C14.4281 17.2973 15.4641 17.616 16.1578 17.616C17.3531 17.616 17.4703 16.2941 16.9781 15.802ZM7.69219 19.4488C7.93125 18.8066 8.84062 18.066 9.11719 17.8082C8.22656 19.2285 7.69219 19.4816 7.69219 19.4488ZM11.5172 10.5145C11.8641 10.5145 11.8313 12.0191 11.6016 12.427C11.3953 11.7754 11.4 10.5145 11.5172 10.5145ZM10.3734 16.9176C10.8281 16.1254 11.2172 15.1832 11.5312 14.3535C11.9203 15.0613 12.4172 15.6285 12.9422 16.0176C11.9672 16.2191 11.1188 16.6316 10.3734 16.9176ZM16.5422 16.6832C16.5422 16.6832 16.3078 16.9645 14.7938 16.3176C16.4391 16.1957 16.7109 16.5707 16.5422 16.6832Z"
                                fill="black" />
                        </svg></a></td>

            </tr>
            <?php } ?>

        </tbody>
    </table>
</div>
<script>
function payslip(date, userid, s) {
    // alert(date)
    // alert(csrf_token); return;
    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();


    var salary_month = date;

    status = s;


    var sql = userid;

    var data = "salary_month=" + salary_month + "&status=" + status + '&sql=' + sql + "&excel=" + 0;

    // console.log(data); return;

    url = '<?= base_url('admin/dashboard/payslip')?>';

    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);

    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            // console.log(ajaxRequest);
            var resp = ajaxRequest.responseText;

            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1200,height=800');
            a.document.write(resp);
        }
    }
}
</script>