<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<style>
  /* Custom table styles */
  .sal {
    border-collapse: collapse;
    width: 750px;
    margin: 0 auto;
    font-size: 12px;
  }

  .sal th,
  .sal td {
    padding: 8px;
    border: 1px solid #ddd;
  }

  .sal th {
    background-color: #f8f9fa;
    font-weight: bold;
  }

  .sal tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  .sal tr:hover {
    background-color: #e2e6ea;
    cursor: pointer;
  }

  /* Center align text in the table */
  .sal th.text-center,
  .sal td.text-center {
    text-align: center;
  }

  /* Add some margin to the export button */
  .export-button {
    position: absolute;
    right: 0;
    margin-right: 25px;
    margin-top: 25px;
    font-size: 20px;
  }
@media print {
    .btn{

        display: none;
    }
 }
</style>

<div class="export-button">
	<form action="<?php echo base_url();?>admin/payroll/Actual_salary_sheet_excel_bank" method="post">
		<input type="hidden" name="salary_month" value="<?php echo $salary_month; ?>"></input>
		<input type="hidden" name="sql" value="<?php echo implode(",",$emp_id); ?>"></input>
		<input type="hidden" name="excel" value="1"></input>
		<input type="hidden" name="status" value="<?php echo $status; ?>"></input>
		<button type="submit" class="btn btn-primary" style="border: 0; cursor:pointer;" alt="XLS Export">XLS Export</button>
	</form>
    <button  class="btn btn-primary" style="border: 0; cursor:pointer;"  onclick="window.print();" alt="XLS Export">Print</button>
</div>

<table align="center" class="sal">
  <tr height="85px">
    <td colspan="23" style="text-align:center;">
      <div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
      <div style="font-size:12px; font-weight:bold; text-align:center;height:0px;"></div>
      <div style="font-size:12px; line-height:15px; font-weight:bold; text-align:center;"><?php echo xin_company_info(1)->address_1 . " " . xin_company_info(1)->address_2; ?></div>
      <div>Salary Month: <?php echo $salary_month; ?></div>
      <div style="font-size:12px; font-weight:bold; text-align:center;"></div>
      <div style="font-size:12px; font-weight:bold; text-align:center;"></div>
    </td>
  </tr>

  <tr>
    <th class="text-center">SL</th>
    <th class="text-center">Employee Name</th>
    <th class="text-center">Designation Name</th>
    <th class="text-center">Date Of Joining</th>
 
    <th class="text-center">Salary</th>
    <th class="text-center">Grand Net Salary</th>
       <th class="text-center">Bank Account</th>
  </tr>

  <?php
    $grand_total = $basic_salary = 0;
    foreach ($values as $key => $row) {
      $grand_total = $grand_total + $row->grand_net_salary + ($row->modify_salary) - $row->aba_deduct;
      $basic_salary = $basic_salary + $row->basic_salary;
  ?>
  <tr>
    <td class="text-center"><?= ($key + 1) ?>.</td>
    <td class="text-center"><?= $row->first_name . ' ' . $row->last_name ?></td>
    <td class="text-center"><?= $row->designation_name ?></td>
    <td class="text-center"><?= $row->date_of_joining ?></td>
  
    <td class="text-center"><?= $row->basic_salary ?></td>
    <td class="text-center"><?= $row->grand_net_salary + ($row->modify_salary) - $row->aba_deduct ?></td>
      <td class="text-center"><?= $row->account_number ?></td>
  </tr>
  <?php } ?>
  
  <tr>
    <th colspan="4" class="text-left">Total:</th>
    <th class="text-center"><?= $basic_salary ?></th>
    <th class="text-center"><?= $grand_total ?></th>
  </tr>
</table>
<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/salary.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
