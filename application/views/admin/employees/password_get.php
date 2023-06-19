

<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
<?php $filename = "user.xls";
    header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
    header('Cache-Control: max-age=0'); //no cache
?>


    <table width="900"width="900" align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">

    	<tr  style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px;">
            <th style="background-color: #4CAF50;color: white;font-size: 14px;">No.</th>
            <th style="background-color: #4CAF50;color: white;font-size: 14px;">Name</th>
            <th style="background-color: #4CAF50;color: white;font-size: 14px;">Employee Id</th>
            <th style="background-color: #4CAF50;color: white;font-size: 14px;">Username</th>
            <th style="background-color: #4CAF50;color: white;font-size: 14px;">Password</th>
        </tr>
    		 
        <?php foreach($results as $key => $row) { ?>
            <tr>
              <td style="font-size: 13px;" ><?php echo $key + 1; ?></td>
              <td style="font-size: 13px;" ><?php echo $row->first_name .' '. $row->last_name; ?></td>
              <td style="font-size: 13px;" ><?php echo $row->employee_id; ?></td>
              <td style="font-size: 13px;" ><?php echo $row->username; ?></td>
              <td style="font-size: 13px;" ><?php echo $row->password; ?></td>
            </tr>
        <?php  } exit; ?>
	</table>

</body>
</html>