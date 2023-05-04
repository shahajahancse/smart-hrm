<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
      .colors1 {
               background-color: #a58b4373;
               color: black !important;
               }
    .colors2 {
            background-color: #a9a9a95e !important;
            color: black !important;
            }
    .colors3 {
             background-color: #1de1eb47 !important;
              color: black !important;
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
$total=0;
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
echo "<table>";


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
  <td> . ".$values[$i]->emp_id." . </td>
  <td> . ".$values[$i]->first_name." . </td>
  <td> . ".$values[$i]->basic_salary." . </td>
  <td>
      <table>
          <tr>
              <td class='colors1'> . ".$values[$i]->first_name." . </td>
              <td class='colors1'> . ".$values[$i]->first_name." . </td>
              <td class='colors1'> . ".$values[$i]->first_name." . </td>
              <td class='colors1'> . ".$values[$i]->first_name." . </td>
              <td class='colors1'> . ".$values[$i]->first_name." . </td>
          </tr>
      </table>
  </td>
  <td>
      <table>
          <tr>
              <td class='colors2'> . ".$values[$i]->first_name." . </td>
              <td class='colors2'> . ".$values[$i]->first_name." . </td>
          </tr>
      </table>
  </td>
  <td>
     2
  </td>
  <td>
      <table>
          <tr>
              <td  class='colors3'> . ".$values[$i]->first_name." . </td>
              <td  class='colors3'> . ".$values[$i]->first_name." . </td>
          </tr>
      </table>
  </td>
  <td> . ".$values[$i]->first_name." . </td>
  <td> . ".$values[$i]->first_name." . </td>
  <td> . ".$values[$i]->first_name." . </td>
  <td> . ".$values[$i]->first_name." . </td>
  <td> . ".$values[$i]->first_name." . </td>
";
    
  
    $total+=$values[$i]->emp_id;

    echo "</tr>";
   
    if (($i+1) % $rows_per_page == 0 && $i != count($values)-1) {
      
     
        echo "</table>";
        echo "<tr>";
        // echo "heloooooooooo $total";
        echo "</tr>";
       echo" <br>";
        
        echo "<table class='table' 'border='1'>";
        
        // add page number
        $page_number = ($i+1)/$rows_per_page + 1;
        echo "<tr><th>Name</th><th>Stock</th><th>Sold</th></tr>";
        // echo "Page $page_number";

        $total=0;
    }
    
}

// print the table footer
echo "</table>";
?>































    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  </body>
</html>