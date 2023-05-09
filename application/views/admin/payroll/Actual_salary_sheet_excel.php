
<!doctype html>
<html lang="en">
  <head>
    <title><?php
      echo  xin_company_info(1)->company_name
        ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <style>
   .btn {
    background-color: #0890dd;
    height: 28px;
    width: 64px;
    font-size: 12px;
    border: none;
    border-radius: 11px;
    cursor: pointer;
    color: #fff;
    font-family: Arial, sans-serif;
    text-transform: uppercase;
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease-in-out;
    margin: 5px;
}
 .btn:hover {
     background-color: #0c69a5;
     box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.3);
     transform: translateY(-3px);
}
 .fullt{
     height: 500px;
     margin: 20px;
}
 .colors1 {
     background-color: #0177bc3b;
     color: black !important;
     width: 20%;
}
 .colors4 {
     background-color: #dff0d8bd;;
     color: black !important;
}

 .colors2 {
     background-color: #a9a9a95e !important;
     color: black !important;
     width: 50%;
}
 .colors3 {
     background-color: #97eff347 !important;
     color: black !important;
     width: 50%;
}
 .bnr{
     border-right: none;
}
 .bnl{
     border-left: none;
}
 .bnt{
     border-top: none;
}
 .bnb{
     border-bottom: none;
}
 table {
     border-collapse: collapse;
     width: 100%;
     text-align: center;
     font-family: Arial, Helvetica, sans-serif;
     margin: 0;
     padding: 0;
     height: -webkit-fill-available;
}
 th, td {
     text-align: left;
     padding: 10px;
     text-align: center;
     border: 1px solid #ddd;
     margin: 0;
     padding: 0;
}
 th {
     background-color: #f2f2f2;
     font-weight: bold;
     text-align: center;
     padding: 15px;
     margin: 0;
     border: 1px solid #ddd;
     margin: 0;
     padding: 0;
     
}
 td {
     text-align: center;
     border: 1px solid #ddd;
     margin: 0;
     padding: 0;
}
 td table {
     border: none;
     text-align: center;
     margin: 0;
     padding: 0;
}
 td table td {
     border: none;
     width: 30px;
     text-align: center;
     margin: 0;
     padding: 0;
     border-right: 1px solid black;
}
 td table th {
     border: none;
     text-align: center;
     margin: 0;
     padding: 0;
}
/* Style the rows alternating gray and white */
 tr:nth-child(even) {
     background-color: #f2f2f2;
}
/* Style the header row */
 thead th {
     background-color: #d7d4d4;
     color: black;
     margin: 0;
     padding: 0
}
 thead{
    font-size: 13px!important;
}
 tbody{
    font-size: 12px!important;
}

    </style>
  </head>
  <body>
    <div  style="float: right;">

  
            <div style="position:absolute;display: flex;right:0;">
                    <form action="<?php echo base_url();?>admin/payroll/salary_sheet_excel" method="post">
                        <input type="hidden" name="salary_month" value="<?php echo $salary_month; ?>"></input>
                        <input type="hidden" name="sql" value="<?php echo implode(",",$emp_id); ?>"></input>
                        <input type="hidden" name="excel" value="1"></input>
                        <input type="hidden" name="status" value="<?php echo $status; ?>"></input>
                        <button type="submit" class="btn btn-primary" style="border: 0; cursor:pointer;" alt="XLS Export">XLS</button>
                    </form>
                    <button class="btn" onclick="printPage()">Print</button></div>

            </div>
    </div>

  <div id="print-content">   

<?php
$total_basic_salary=0;
$total_grand_net_salary=0;
$total_net_salary=0;
$total_late_deduct=0;
$total_absent_deduct=0;
$total_extra_pay=0;
$total_modify_salary=0;

// dd($values);
  // define the number of rows per page
$rows_per_page = 7;

// calculate the total number of pages
$num_pages = ceil(count($values) / $rows_per_page);

// get the current page number from the query string
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// calculate the start and end index of the current page
$start_index = ($current_page - 1) * $rows_per_page;
$end_index = min($start_index + $rows_per_page - 1, count($values) - 1);

// print the table header
echo "<div>";
$total_grand_net_salary=0;
$total_basic_salary=0;
$total_net_salary=0;
$total_late_deduct=0;
$total_absent_deduct=0;
$total_extra_pay=0;
$total_modify_salary=0;

echo "
<div style='font-size:18px; font-weight:bold; text-align:center;margin-top:10px'>".xin_company_info(1)->company_name ."</div>
<div style='font-size:14px; font-weight:bold; text-align:center;margin-top:10px'>".xin_company_info(1)->address_1."</div>
<div style='font-size:12px;align-items: center;text-align: center;'>Salary Month : ". $salary_month ."</div>

</div>
<div class='fullt'>
<table   >";


echo " <thead>
<tr>
<th class='bnb'>SL</th>
<th  class='bnb'>Name</th>
<th  class='bnb'>Degi  </th>
<th  class='bnb'>Join.d</th>
<th  class='bnb'>B.Salary</th>
<th style='width: 160px;'>Status</th>
<th style='width: 92px;'>Leave</th>
<th  class='bnb'>Late</th>
<th style='width: 139px;'>Deduction</th>
<th  class='bnb'>Extra Pay</th>
<th  class='bnb'>Modify Salary</th>
<th  class='bnb'>Net Salary</th>
<th  class='bnb '>Grand Net Salary</th>
<th  class='bnb'>Account Number</th>
</tr>
<tr>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
    
    <th>
        <table>
            <tr>
                <th class=''>P</th>
                <th class=''>A</th>
                <th class=''>W</th>
                <th class=''>H</th>
                <th class=''>E</th>
            </tr>
        </table>
    </th>
    <th>
        <table >
            <tr >
                <th class=''>Earn</th>
                <th class=''>Sick</th>
            </tr>
        </table>
    </th>
    <th  class='bnt'> </th>
    <th>
        <table>
            <tr>
                <th  class=''>Late</th>
                <th  class=''>Abse</th>
            </tr>
        </table>
    </th>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
</tr>
</thead>
<tbody>";
$j=1;
// print the rows for all pages
for ($i = 0; $i < count($values); $i++) {
    
   
  echo"<tr>
  <td>".($j)."</td>
  <td>".$values[$i]->first_name."</td>
  <td>".$values[$i]->designation_name."</td>
  <td>".$values[$i]->date_of_joining."</td>
  <td>".intval($values[$i]->basic_salary)."</td>
  <td>
      <table>
          <tr>
              <td class='colors1'>".intval($values[$i]->present)."</td>
              <td class='colors1'>".intval($values[$i]->absent)."</td>
              <td class='colors1'>".intval($values[$i]->weekend)."</td>
              <td class='colors1'>".intval($values[$i]->holiday)."</td>
              <td class='colors1'>".intval($values[$i]->extra_p)."</td>
          </tr>
      </table>
  </td>
  <td>
      <table>
          <tr>
              <td class='colors2'>".intval($values[$i]->earn_leave)."</td>
              <td class='colors2'>".intval($values[$i]->sick_leave)."</td>
          </tr>
      </table>
  </td>
  <td>
  ".$values[$i]->late_count."
  </td>
  <td>
      <table>
          <tr>
              <td  class='colors3'>".$values[$i]->late_deduct."</td>
              <td  class='colors3'>".$values[$i]->absent_deduct."</td>
          </tr>
      </table>
  </td>
  <td>".$values[$i]->extra_pay."</td>
  <td>".$values[$i]->modify_salary."</td>
  <td>".$values[$i]->net_salary."</td>
  <td class='colors4'>".$values[$i]->grand_net_salary."</td>";

  $total_grand_net_salary+=$values[$i]->grand_net_salary;
  $total_basic_salary+=$values[$i]->basic_salary;
  $total_net_salary+=$values[$i]->net_salary;
  $total_late_deduct+=$values[$i]->late_deduct;
  $total_absent_deduct+=$values[$i]->absent_deduct;
  $total_extra_pay+=$values[$i]->extra_pay;
  $total_modify_salary+=$values[$i]->modify_salary;
  echo"
  <td>".$values[$i]->account_number."</td>
";


    echo "</tr>";
    $j=$j+1;
    if (($i+1) % $rows_per_page == 0 && $i != count($values)-1) {
        $j=1;
echo "</tbody>
<tfoot style='font-size: 12px;'>
<tr>
  <td colspan='4'>Total:</td>
  <td  colspan='1'>".$total_basic_salary."</td>
  <td colspan='3'></td>
  <td colspan='1'>
    <table>
        <tr>
        <td style='width: 50%' colspan='1'>".$total_late_deduct."</td>
        <td style='width: 50%' colspan='1'>".$total_absent_deduct."</td>
        </tr>
    </table>
 </td>
  <td  colspan='1'>".$total_extra_pay."</td>
  <td colspan='1'>".$total_modify_salary."</td>
  <td colspan='1'>".$total_net_salary."</td>
  <td class='colors4' colspan='1'>".$total_grand_net_salary."</td>
  <td colspan='1'></td> 
</tr>
</tfoot>";
$total_grand_net_salary=0;
$total_basic_salary=0;
$total_net_salary=0;
$total_late_deduct=0;
$total_absent_deduct=0;
$total_extra_pay=0;
$total_modify_salary=0;

echo"</table>
<div style='
display: flex;
text-align: center;
align-items: center;
margin-top: 78px;
font-size: 14px;
font-weight: bold;
'>
<section style='width: 33%;'>Prepared By</section>
<section style='width: 33%;'>Confirmed By</section>
<section style='width: 33%;'>Aproved By(Managing Director)</section>
      </div>
</div>";
echo "<div style='
margin-top: 132px;
'>
<div style='font-size:18px; font-weight:bold; text-align:center;margin-top:10px'>".xin_company_info(1)->company_name ."</div>
<div style='font-size:14px; font-weight:bold; text-align:center;margin-top:10px'>".xin_company_info(1)->address_1."</div>
<div style='font-size:12px;align-items: center;text-align: center;'>Salary Month : ". $salary_month ."</div>

       </div>
       <div class='fullt'>
       <table>";
        
        // add page number
        $page_number = ($i+1)/$rows_per_page + 1;
 echo " <thead>
 <tr>
 <th class='bnb'>SL</th>
 <th  class='bnb'>Name</th>
 <th  class='bnb'>Degi  </th>
 <th  class='bnb'>Join.d</th>
 <th  class='bnb'>B.Salary</th>
 <th style='width: 160px;'>Status</th>
 <th style='width: 92px;'>Leave</th>
 <th  class='bnb'>Late</th>
 <th style='width: 139px;'>Deduction</th>
 <th  class='bnb'>Extra Pay</th>
 <th  class='bnb'>Modify Salary</th>
 <th  class='bnb'>Net Salary</th>
 <th  class='bnb '>Grand Net Salary</th>
 <th  class='bnb'>Account Number</th>
 </tr>
 <tr>
     <th  class='bnt'></th>
     <th  class='bnt'></th>
     <th  class='bnt'></th>
     <th  class='bnt'></th>
     <th  class='bnt'></th>
     
     <th>
         <table>
             <tr>
                 <th class='r5'>P</th>
                 <th class='r5'>A</th>
                 <th class='r5'>W</th>
                 <th class='r5'>H</th>
                 <th class='r5'>E</th>
             </tr>
         </table>
     </th>
     <th>
         <table >
             <tr >
                 <th class=''>Earn</th>
                 <th class=''>Sick</th>
             </tr>
         </table>
     </th>
     <th  class='bnt'> </th>
     <th>
         <table>
             <tr>
                 <th  class=''>Late</th>
                 <th  class=''>Abse</th>
             </tr>
         </table>
     </th>
     <th  class='bnt'></th>
     <th  class='bnt'></th>
     <th  class='bnt'></th>
     <th  class='bnt'></th>
     <th  class='bnt'></th>
 </tr>
 </thead>
        <tbody> ";        // echo "Page $page_number";
    }



    
}


echo"<tfoot style='font-size: 12px;'>
<tr>
  <td colspan='4'>Total:</td>
  <td  colspan='1'>".$total_basic_salary."</td>
  <td colspan='3'></td>
   <td colspan='1'>
    <table>
        <tr>
        <td style='width: 50%' colspan='1'>".$total_late_deduct."</td>
        <td style='width: 50%' colspan='1'>".$total_absent_deduct."</td>
        </tr>
    </table>
 </td>
  <td  colspan='1'>".$total_extra_pay."</td>
  <td colspan='1'>".$total_modify_salary."</td>
  <td colspan='1'>".$total_net_salary."</td>
  <td colspan='1'>".$total_grand_net_salary."</td>
  <td colspan='1'></td>
  </tr>
</tfoot>";

// print the table footer
echo "</table>
<div style='
display: flex;
text-align: center;
align-items: center;
margin-top: 78px;
font-size: 14px;
font-weight: bold;
'>
<section style='width: 33%;'>Prepared By</section>
<section style='width: 33%;'>Confirmed By</section>
<section style='width: 33%;'>Aproved By(Managing Director)</section>
      </div>
</div>";
?>

</div>
  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  
    <script>function printPage() {
    var printContents = document.getElementById("print-content").innerHTML;
    var originalContents = document.body.innerHTML;

    // set custom layout, page size, page margin, and page heading
    var printCSS = '<style>@page { size: A4 landscape; margin: 1cm;}</style>';
                  
    
    document.body.innerHTML = printCSS + '<div id="print-content">' + printContents + '</div>';

    window.print();

    document.body.innerHTML = originalContents;
}


</script>



</body>
</html>
