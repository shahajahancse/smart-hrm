


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
<?php

$filename = "xls.xls";
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
?>


<table width="900"width="900" align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">
<tr width="900" align="center" style="height:50px;">
    <td colspan="8" style="text-align:center;">
        <div style="font-size:25px; font-weight:bold; text-align:center;"><?php echo xin_company_info(1)->company_name; ?></div>
        <div style="font-size:20px; font-weight:bold; text-align:center;"><?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div>
        
        </td>
</tr>



	
		<tr  style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px;">
            
            <th style="background-color: #4CAF50;color: white;">No.</th>
            <th style="background-color: #4CAF50;color: white;">Name</th>
            <th style="background-color: #4CAF50;color: white;">Department</th>
            <th style="background-color: #4CAF50;color: white;">Designation</th>
            <th style="background-color: #4CAF50;color: white;">DOJ</th>
            <th style="background-color: #4CAF50;color: white;">Old Salary</th>
            <th style="background-color: #4CAF50;color: white;">New Salary</th>
            <th style="background-color: #4CAF50;color: white;">G.Letter</th>
           
        </tr>
		 
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
         
<!-- jj -->



	</table>

</body>
</html>