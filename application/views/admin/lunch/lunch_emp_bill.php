
<?php
dd($empdata);
?>


<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">
<div class="monthname">
    June-2023 Month Lunch Bill Summery
</div>
<div class="divrow col-md-12">
    <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="heading">Total Lunch</div>
        <div class="heading2">22</div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="heading">Total Payment</div>
        <div class="heading2">945</div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
        <div class="heading">Saved Lunch</div>
        <div class="heading2">4</div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
        <div class="heading">Previous Saved Amount</div>
        <div class="heading2">589</div>
    </div>
</div>

<div class="titel_sec_head col-md-3">
    <div>Lunch Bill Information</div>

</div>
<div class="titel_sec_head2 col-md-4">
    <input type="month" class="datesec" id="monthYearInput" value="<?= date('Y-m')?>">
    <a class="btn btns">Submit</a>

</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>
