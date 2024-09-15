<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<style>
  *{
    font-size: 14px;
  }
.container {
  padding: 0;
  width: 80%;
  margin: 0 auto;
  
}

@media print {
    .btn{
        display: none;
    }
 }
</style>
<?php
    $grand_total_emni = 0;
    foreach ($values as $key => $row) {
      $grand_total_emni = $grand_total_emni + $row->grand_net_salary + ($row->modify_salary) - $row->aba_deduct;
    }

    $grand_total_emni=ceil($grand_total_emni);
    function numToWordsRec($number) {
      $words = array(
          0 => '', 1 => 'one', 2 => 'two',
          3 => 'three', 4 => 'four', 5 => 'five',
          6 => 'six', 7 => 'seven', 8 => 'eight',
          9 => 'nine', 10 => 'ten', 11 => 'eleven',
          12 => 'twelve', 13 => 'thirteen', 
          14 => 'fourteen', 15 => 'fifteen',
          16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
          19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
          40 => 'forty', 50 => 'fifty', 60 => 'sixty',
          70 => 'seventy', 80 => 'eighty',
          90 => 'ninety'
      );
  
      if ($number < 20) {
        if ($number == 0) {
          return '';
        }else{
          return $words[$number];
        }
      }
  
      if ($number < 100) {
          return $words[10 * floor($number / 10)] .
                 ' ' . $words[$number % 10];
      }
  
      if ($number < 1000) {
          return $words[floor($number / 100)] . ' hundred ' 
                 . numToWordsRec($number % 100);
      }
  
      if ($number < 100000) {
          return numToWordsRec(floor($number / 1000)) .
                 ' thousand ' . numToWordsRec($number % 1000);
      }
      if ($number < 10000000) {
        return numToWordsRec(floor($number / 100000)) .
              ' lac ' . numToWordsRec($number % 100000);
      }
      
        return numToWordsRec(floor($number / 10000000)) .
              ' cor ' . numToWordsRec($number % 10000000);
      
  }

?>

<div class="export-button">
    <form action="<?php echo base_url();?>admin/payroll/Actual_salary_sheet_excel_bank" method="post">
      <input type="hidden" name="salary_month" value="<?php echo $salary_month; ?>"></input>
      <input type="hidden" name="sql" value="<?php echo implode(",",$emp_id); ?>"></input>
      <input type="hidden" name="excel" value="1"></input>
      <input type="hidden" name="status" value="<?php echo $status; ?>"></input>
      <button type="submit" class="btn btn-primary" style="border: 0; cursor:pointer;" alt="XLS Export">XLS Export</button>
    </form>
</div>
<?php $salary_month=date("M-Y",strtotime($salary_month)) ?>

<div class="container">
  <table style="width: 100%; margin-top: 50px;">
    <tr height="85px">
      <td colspan="5" style="text-align:left;">
        <div style="margin-top:12.8px;display: flex;justify-content: space-between;">
          <div>Date : <?=date("d M Y")?></div>
          <div>Ref: MHL-D/REF/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        </div>
        <div style=" font-weight:bold; text-align:left;">To</div>
        <div style=" text-align:left;">Manager</div>
        <div style=" text-align:left;">Rupali Bank Ltd</div>
        <div style=" text-align:left;">Adabor, Ring Road, Dhaka</div>
        <div style=" text-align:left; font-weight:bold;">Subject: - Transfer <?php echo $salary_month; ?> salary from company account to employee's salary account.</div>
        <div style=" text-align:left; font-weight:bold;">Dear Sir,</div>
        <div style=" text-align:left;">Greetings from Mysoft Heaven (BD) Ltd.</div>
        <div style=" text-align:left;">We have been maintaining a current account in your bank (Account name: - Mysoft Heaven (BD) Ltd,<br>Account No: - 5991020000012). We would like to transfer =<?=$grand_total_emni?>/- (Taka : <?php echo numToWordsRec($grand_total_emni); ?> Only) from our company account to our employee's salary account. The list of employee's accounts where need to transfer the fund within today. </div>
        <br>
        <div style="text-align: center;text-decoration: underline;">Salary Of <?php echo date("M-Y",strtotime($salary_month)); ?></div>
      </td>
    </tr>
  </table>
  <table border="1" width="100%" style="border-collapse: collapse;">
    <tr>
      <th class="text-center">SL</th>
      <th class="text-center">Employee Name</th>
      <th class="text-center">Designation Name</th> 
      <th class="text-center">Grand Net Salary</th>
      <th class="text-center">Bank Account</th>
    </tr>
  
    <?php
      $grand_total = 0;
      foreach ($values as $key => $row) {
        $grand_total = $grand_total + $row->grand_net_salary + ($row->modify_salary) - $row->aba_deduct;
    ?>
    <tr >
      <td class="text-center"><?= ($key + 1) ?>.</td>
      <td class="text-center"><?= $row->first_name . ' ' . $row->last_name ?></td>
      <td class="text-center"><?= $row->designation_name ?></td>
      <td class="text-right"><?= number_format(ceil($row->grand_net_salary + ($row->modify_salary) - $row->aba_deduct)) ?></td>
      <td class="text-center"><?= $row->account_number ?></td>
    </tr>
    <?php } ?>
    
    <tr>
      <th colspan="3" class="text-center">Total: Taka : <?php echo numToWordsRec($grand_total); ?> Only</th>
      <th class="text-right"><?= number_format(ceil($grand_total)) ?></th>
      <th class="text-center"></th>
    </tr>
  </table>
  <table style="width: 100%;margin-bottom: 20px">
    <tr>
      <td colspan="5" style="text-align:left;">
        <div style="  text-align:left;">Therefore, please transfer the amount to the listed employee's account within today.</div>
        <br>
        <div style=" font-weight:bold; text-align:left;">Regards</div>
        <br>
        <br>
        <div style=" font-weight:bold; text-align:left;">Managing Director</div>
        <div style=" font-weight:bold; text-align:left;">Mysoft Heaven (BD) Ltd.</div>
      </td>
    </tr>
  </table>
</div>
<?php exit() ?>
