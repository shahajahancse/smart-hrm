


<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
        @media print {
  .btn {
    display: none;
  }
  table {
    margin-top: 15px;}
}
  table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 15px;
 
  max-width: 100%; /* Set max-width to 100% */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
/* hh */

th {
	background-color: #4CAF50;
    color: white;
    font-size: 15px;
    font-weight: bold;
    text-align: center;
    /* border: 2px solid #4CAF50; */
}
th {
	
    font-size: 14px;
   
}
.im{
    background: #d5b2b2 !important;
    color: currentcolor !important;

}

td {
	font-size: 15px;
    text-align: center;
    border: 2px solid #ddd;
    width: 19px;
}

tr:hover {
  background-color: #f5f5f5;
}

.tdb {
  background-color: cadetblue;
}



.btn {
    background-color: #0890dd;
    height: 31px;
    width: 66px;
    font-size: 16px;
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



</style>
  </head>
  <body >





  
<div  style="float: right;">
<button class="btn" onclick="printPage()">Print</button></div>
<form style="float: right;"  action="<?php echo base_url('admin/Employees/excel_inc'); ?>" method="post">
  
  <input type="hidden" name="status" value="<?php echo $status; ?>">
  <button class="btn" type="submit">XLS</button>
</form>

  <div  class="box-header with-border">
  <div id="print-content"  class="box-header with-border">
   
	

 



  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
	 <tr><div style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px"><?php echo xin_company_info(1)->company_name; ?></div>
				<div style="font-size:20px; font-weight:bold; text-align:center;height:0px;"></div>
				<div style="font-size:20px; line-height:15px; font-weight:bold; text-align:center;"> <?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>

				
	<div style="font-size:12px; font-weight:bold; text-align:center;"></div>
	</tr> 
        <thead>

		
          <tr class="tdb">
            <th>No.</th>
            <th>Name</th>
            <th>Department</th>
            <th>Designation</th>
            <th>DOJ</th>
            <th>Old Salary</th>
            <th>New Salary</th>
            <th>G.Letter</th>
         </tr>
        </thead>
        <tbody>
          <?php foreach($results as $key => $row):?>
            <tr>
              <td><?php echo $key + 1; ?></td>
              <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
              <td><?php echo $row->department_name; ?></td>
              <td><?php echo $row->designation_name; ?></td>
              <td><?php echo $row->date_of_joining; ?></td>
              <td><?php echo $row->old_salary; ?></td>
              <td><?php echo $row->new_salary; ?></td>
              <td><?php echo $row->letter_status == 1 ? "Yes":"No"; ?></td>
            </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
</div>


 

<script>
function printPage() {
    // var printContents = document.getElementById("print-content").innerHTML;
    // var originalContents = document.body.innerHTML;

    // // set custom layout, page size, page margin, and page heading
    // var printCSS = '<style>@page { size: A4 landscape; margin: 1cm; @top-center</style>';
    
    // document.body.innerHTML = printCSS + '<div id="print-content">' + printContents + '</div>';

    window.print();

    // document.body.innerHTML = originalContents;
}


</script>


      



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>