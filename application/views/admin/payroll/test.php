<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      


<?php

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
echo "<table class='table' 'border='1'>";
$total=0;
echo "<p> page 1</p>";
echo "<tr><th>SL</th><th>Name</th><th>Stock</th><th>Sold</th></tr>";
   
// print the rows for all pages
for ($i = 0; $i < count($values); $i++) {
    
    echo "<tr>";
    
    echo "<td>" . $values[$i]->first_name . "</td>";
    echo "<td>" . $values[$i]->last_name . "</td>";
    echo "<td>" . $values[$i]->date_of_joining . "</td>";
    echo "<td>" . $values[$i]->emp_id . "</td>";
    $total+=$values[$i]->emp_id;

    echo "</tr>";
   
    if (($i+1) % $rows_per_page == 0 && $i != count($values)-1) {
      
     
        echo "</table>";
        echo "<tr>";
        echo "heloooooooooo $total";
        echo "</tr>";
       echo" <br>";
        
        echo "<table class='table' 'border='1'>";
        
        // add page number
        $page_number = ($i+1)/$rows_per_page + 1;
        echo "<tr><th>Name</th><th>Stock</th><th>Sold</th></tr>";
        echo "Page $page_number";

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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>