<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
    <?php
        $filename = "Salary_$salary_month.xls";
        header('Content-Type: application/vnd.ms-excel'); // Mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); // Tell the browser the file name
        header('Cache-Control: max-age=0'); // No cache
    ?>
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
              ' Lac ' . numToWordsRec($number % 100000);
      }
      
        return numToWordsRec(floor($number / 10000000)) .
              ' Cor ' . numToWordsRec($number % 10000000);
      
  }

?>


    <?php $salary_month=date("M-Y",strtotime($salary_month)) ?>

    <!-- <table style="width: 100%; margin-top: 20px;">
        <tr height="85px">
            <td colspan="5" style="text-align:left;">
                <div style="font-size:12px;margin-top:12.8px;display: flex;justify-content: space-between;">
                    <div>Date : <?=date("Y M d")?></div>
                    <div>Ref: MHL-D/REF/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                </div>
                <div style="font-size:12px; font-weight:bold; text-align:left;">To</div>
                <div style="font-size:12px; text-align:left;">Manager</div>
                <div style="font-size:12px; text-align:left;">Rupali Bank Ltd</div>
                <div style="font-size:12px; text-align:left;">Adabor, Ring Road, Dhaka</div>
                <div style="font-size:12px; text-align:left; font-weight:bold;">Subject: - Transfer
                    <?php echo $salary_month; ?> salary from company account to employee's salary account.</div>
                <div style="font-size:12px; text-align:left; font-weight:bold;">Dear concern,</div>
                <div style="font-size:12px; text-align:left;">Greetings from Mysoft Heaven (BD) Ltd.</div>
                <div style="font-size:12px; text-align:left;">We have been maintaining a current account in your bank
                    (Account name: - Mysoft Heaven (BD) Ltd,<br>Account No: - 5991020000012). We would like to transfer
                    =<?=$grand_total_emni?>/- (Taka : <?php echo numToWordsRec($grand_total_emni); ?> Only) from our
                    company account to our employee's salary account. The list of employee's accounts where need to
                    transfer the fund within today. </div>
                <br>
                <div style="text-align: center;text-decoration: underline;">Salary Of <?php echo $salary_month; ?></div>
            </td>
        </tr>
    </table> -->
    <table border="1" width="100%" style="border-collapse: collapse;font-size:12px;">
        <tr>
            <th style="font-size:12px;" class="text-center">SL</th>
            <th style="font-size:12px;" class="text-center">Employee Name</th>
            <th style="font-size:12px;" class="text-center">Designation Name</th>
            <th style="font-size:12px;" class="text-center">Grand Net Salary</th>
            <th style="font-size:12px;" class="text-center">Bank Account &nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        </tr>

        <?php
      $grand_total = 0;
      foreach ($values as $key => $row) {
        $grand_total = $grand_total + $row->grand_net_salary + ($row->modify_salary) - $row->aba_deduct;
    ?>
        <tr>
            <td class="text-center"><?= ($key + 1) ?>.</td>
            <td class="text-center"><?= $row->first_name . ' ' . $row->last_name ?></td>
            <td class="text-center"><?= $row->designation_name ?></td>
            <td class="text-right"><?= ceil($row->grand_net_salary + ($row->modify_salary) - $row->aba_deduct) ?></td>
            <td class="text-center"><?php echo (string) $row->account_number ?></td>
        </tr>
        <?php } ?>

        <tr>
            <th colspan="3" class="text-center">Total: Taka : <?php echo numToWordsRec($grand_total); ?> Only</th>
            <th class="text-right"><?= ceil($grand_total) ?></th>
            <th class="text-center"></th>
        </tr>
    </table>
    <table style="width: 100%;margin-bottom: 20px font-size:12px;">
        <tr>
            <td colspan="5" style="text-align:left;">
                <!-- <div style="font-size:12px;  text-align:left;">Therefore, please transfer the amount to the listed
                    employee's account within today.</div> -->
                <br>
                <div style="font-size:12px; font-weight:bold; text-align:left;">Regards</div>
                <br>
                <br>
                <div style="font-size:12px; font-weight:bold; text-align:left;">Managing Director</div>
                <div style="font-size:12px; font-weight:bold; text-align:left;">Mysoft Heaven (BD) Ltd.</div>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
</body>

</html>