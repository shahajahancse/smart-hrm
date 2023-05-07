<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
        .fullt{
            height: 600px;
            margin: 30px;
            margin-bottom: 50px;
        }
      .colors1 {
               background-color: #a58b4373;
               color: black !important;
               width: 20%;
               }
    .colors2 {
            background-color: #a9a9a95e !important;
            color: black !important;
            width: 50%;
            }
    .colors3 {
             background-color: #1de1eb47 !important;
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
            background-color: #4CAF50;
            color: white;
            margin: 0;
            padding: 0;
        }
    </style>
  </head>
  <body>
     
  
     

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
echo "
<div>

";
$total_grand_net_salary=0;
$total_basic_salary=0;
$total_net_salary=0;
$total_late_deduct=0;
$total_absent_deduct=0;
$total_extra_pay=0;
$total_modify_salary=0;

echo "

<div style='font-size:20px; font-weight:bold; text-align:center;margin-top:10px'>".xin_company_info(1)->company_name ."</div>
<div style='font-size:12px; font-weight:bold; text-align:center;height:0px;'></div>
<div style='font-size:20px; font-weight:bold; text-align:center;margin-top:10px'>".xin_company_info(1)->address_1."</div>

<div style='align-items: center;text-align: center;'>Salary Month : ". $salary_month ."</div>

<div style='font-size:12px; font-weight:bold; text-align:center;'><br></div>
<div style='font-size:12px; font-weight:bold; text-align:center;'><br></div>
</div>


<div class='fullt'>


<table class='fullt'>";


echo " <thead>
<tr>
    <th class='bnb'>Id</th>
    <th  class='bnb'>Name Degi Join.d </th>
    <th  class='bnb'>Basic Salary</th>
    <th>Present Status</th>
    <th >Leave</th>
    <th  class='bnb'>Late</th>
    <th >Deduction</th>
    <th  class='bnb'>Extra Pay</th>
    <th  class='bnb'>Modify Salary</th>
    <th  class='bnb'>Net Salary</th>
    <th  class='bnb'>Grand Net Salary</th>
    <th  class='bnb'>account Number</th>
</tr>
<tr>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
    <th  class='bnt'></th>
    
    <th>
        <table>
            <tr>
                <th class='colors1'>Present</th>
                <th class='colors1'>Absent</th>
                <th class='colors1'>Weekend</th>
                <th class='colors1'>Holiday</th>
                <th class='colors1'>Extra.p</th>
            </tr>
        </table>
    </th>
    <th>
        <table >
            <tr >
                <th class='colors2'>Earn Leave</th>
                <th class='colors2'>Sick Leave</th>
            </tr>
        </table>
    </th>
    <th  class='bnt'> </th>
    <th>
        <table>
            <tr>
                <th  class='colors3'>Late Deduction</th>
                <th  class='colors3'>Absent Deduction</th>
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
   
// print the rows for all pages
for ($i = 0; $i < count($values); $i++) {
    
   
  echo"<tr>
  <td>".$values[$i]->emp_id."</td>
  <td>".$values[$i]->first_name."</td>
  <td>".$values[$i]->basic_salary."</td>
  <td>
      <table>
          <tr>
              <td class='colors1'>".$values[$i]->present."</td>
              <td class='colors1'>".$values[$i]->absent."</td>
              <td class='colors1'>".$values[$i]->weekend."</td>
              <td class='colors1'>".$values[$i]->holiday."</td>
              <td class='colors1'>".$values[$i]->extra_p."</td>
          </tr>
      </table>
  </td>
  <td>
      <table>
          <tr>
              <td class='colors2'>".$values[$i]->earn_leave."</td>
              <td class='colors2'>".$values[$i]->sick_leave."</td>
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
  <td>".$values[$i]->grand_net_salary."</td>";

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
   
    if (($i+1) % $rows_per_page == 0 && $i != count($values)-1) {
      
     
        echo "
        </tbody>
        <tfoot>
<tr>
  <td colspan='2'>Total:</td>
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
$total_grand_net_salary=0;
$total_basic_salary=0;
$total_net_salary=0;
$total_late_deduct=0;
$total_absent_deduct=0;
$total_extra_pay=0;
$total_modify_salary=0;

echo"

        </table>
         </div>";

     
        
       echo "
       <div>
       
       
   
       
       <div style='font-size:20px; font-weight:bold; text-align:center;margin-top:10px'>".xin_company_info(1)->company_name ."</div>
       <div style='font-size:12px; font-weight:bold; text-align:center;height:0px;'></div>
       <div style='font-size:20px; font-weight:bold; text-align:center;margin-top:10px'>".xin_company_info(1)->address_1."</div>
       
       <div style='align-items: center;text-align: center;'>Salary Month : ". $salary_month ."</div>
       
       <div style='font-size:12px; font-weight:bold; text-align:center;'><br></div>
       <div style='font-size:12px; font-weight:bold; text-align:center;'><br></div>
       </div>

       <div class='fullt'>
       
       
       <table>";
        
        // add page number
        $page_number = ($i+1)/$rows_per_page + 1;
        echo " <thead>
        <tr>
            <th class='bnb'>Id</th>
            <th  class='bnb'>Name Degi Join.d </th>
            <th  class='bnb'>Basic Salary</th>
            <th>Present Status</th>
            <th >Leave</th>
            <th  class='bnb'>Late</th>
            <th >Deduction</th>
            <th  class='bnb'>Extra Pay</th>
            <th  class='bnb'>Modify Salary</th>
            <th  class='bnb'>Net Salary</th>
            <th  class='bnb'>Grand Net Salary</th>
            <th  class='bnb'>account Number</th>
        </tr>
        <tr>
            <th  class='bnt'></th>
            <th  class='bnt'></th>
            <th  class='bnt'></th>
            
            <th>
                <table>
                    <tr>
                        <th class='colors1'>Present</th>
                        <th class='colors1'>Absent</th>
                        <th class='colors1'>Weekend</th>
                        <th class='colors1'>Holiday</th>
                        <th class='colors1'>Extra.p</th>
                    </tr>
                </table>
            </th>
            <th>
                <table >
                    <tr >
                        <th class='colors2'>Earn Leave</th>
                        <th class='colors2'>Sick Leave</th>
                    </tr>
                </table>
            </th>
            <th  class='bnt'> </th>
            <th>
                <table>
                    <tr>
                        <th  class='colors3'>Late Deduction</th>
                        <th  class='colors3'>Absent Deduction</th>
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

echo"   <tfoot>
<tr>
  <td colspan='2'>Total:</td>
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
echo "</table>";
?>































    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  </body>
</html>