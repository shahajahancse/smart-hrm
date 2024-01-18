<?php
// dd($empdataall);
if (count($empdata)>0){


$data1=$empdata[0];
$taken_meal=0;
$taken_amount=0;
$first_date = date('Y-m-d', strtotime($data1->end_date . ' +1 day'));
$second_date = date('Y-m-d', strtotime($data1->next_date . ' +1 day'));

$this->load->model("Lunch_model");
$emp_data = $this->Lunch_model->get_data_date_wise($first_date, $second_date, $data1->emp_id);

foreach ($emp_data['emp_data'] as $r) {
    $lunch_package=lunch_package($r->date);
    $taken_meal+=$r->meal_amount;
    $taken_amount+=$r->meal_amount*$lunch_package->stuf_give_tk;
}
$paymeal=$data1->probable_meal;
$balanceMeal= $paymeal-$taken_meal;
}
?>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">

<div class="monthname">
    <?php
if (count($empdata)>0){
?>
    <?= date('d-M-Y', strtotime($first_date)) ?> to <?= date('d-M-Y', strtotime($second_date)) ?> Lunch Bill
    Summery
    <?php } ?>
</div>
<div class="divrow col-md-12">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="heading">Total Lunch</div>
        <div class="heading2"><?= (isset($data1->pay_amount))? $data1->probable_meal:'0' ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="heading">Total Payment</div>
        <div class="heading2"><?= (isset($paymeal))? $data1->pay_amount:'0' ?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
        <div class="heading">Taken Lunch</div>
        <div class="heading2"><?= (isset($paymeal))? $taken_meal:'0'?></div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
        <div class="heading">Taken Amount</div>
        <div class="heading2"><?= (isset($paymeal))? $taken_amount :'0'?></div>
    </div>
</div>

<div class="titel_sec_head col-md-3">
    <div>Lunch Bill Information</div>

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
            <th scope="col">Pay Date</th>
            <th scope="col">Total Meal</th>
            <th scope="col">Pay Amount</th>
            <th scope="col">Previous Balance</th>
            <th scope="col">Net Amount</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
                <?php
        foreach ($empdataall as $key=>$value){ ?>
        <tr>
            <td scope="row"><?= $key+1 ?></td>
            <td scope="row"><?= date('d-M-Y', strtotime($value->end_date)) ?> to
                <?= date('d-M-Y', strtotime($value->next_date)) ?></td>
            <td scope="row"><?= $value->probable_meal ?></td>
            <td scope="row"><?= $value->pay_amount ?></td>
            <td scope="row"><?= $value->prev_amount?></td>
            <td scope="row"><?= $value->collection_amount ?></td>
            <td scope="row">
                <?= ($value->status != 1) ? '<span class="danger">Unpaid</span>' : '<span class="suncces">Paid</span>' ?>
            </td>
            <td scope="row"><svg style="width: 24px;height: 24px;transform: rotate(-90deg);flex-shrink: 0;"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M12 18C12.3978 18 12.7794 18.158 13.0607 18.4393C13.342 18.7206 13.5 19.1022 13.5 19.5C13.5 19.8978 13.342 20.2794 13.0607 20.5607C12.7794 20.842 12.3978 21 12 21C11.6022 21 11.2206 20.842 10.9393 20.5607C10.658 20.2794 10.5 19.8978 10.5 19.5C10.5 19.1022 10.658 18.7206 10.9393 18.4393C11.2206 18.158 11.6022 18 12 18ZM12 10.5C12.3978 10.5 12.7794 10.658 13.0607 10.9393C13.342 11.2206 13.5 11.6022 13.5 12C13.5 12.3978 13.342 12.7794 13.0607 13.0607C12.7794 13.342 12.3978 13.5 12 13.5C11.6022 13.5 11.2206 13.342 10.9393 13.0607C10.658 12.7794 10.5 12.3978 10.5 12C10.5 11.6022 10.658 11.2206 10.9393 10.9393C11.2206 10.658 11.6022 10.5 12 10.5ZM12 3C12.3978 3 12.7794 3.15804 13.0607 3.43934C13.342 3.72064 13.5 4.10217 13.5 4.5C13.5 4.89783 13.342 5.27936 13.0607 5.56066C12.7794 5.84196 12.3978 6 12 6C11.6022 6 11.2206 5.84196 10.9393 5.56066C10.658 5.27936 10.5 4.89783 10.5 4.5C10.5 4.10217 10.658 3.72064 10.9393 3.43934C11.2206 3.15804 11.6022 3 12 3Z"
                        fill="black" />
                </svg></td>
        </tr>
        <?php } ?>

    </tbody>
</table>
</div>