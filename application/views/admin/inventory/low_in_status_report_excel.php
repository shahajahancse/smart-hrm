<?php
$statusText = "";
if ($statusC == 7) {
    $statusText = "Low Inventory";
}elseif ($statusC == 2) {
    $statusText = "All Products";
}
?>


<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">

<body style="width:800px;">
<head>
    <style>
        th,td{
            text-align: center;
        }
    </style>
</head>

  
<?php

if($statusC == 7){
    $filename = "Low_inventory.xls";
}elseif ($statusC == 8) {
    $filename = "All_products.xls";
}

header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
?>


<table width="900"width="900" align="center" height="auto" class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">
<tr width="900" align="center" style="height:100px;">
    <td colspan="9" style="text-align:center;">
        <div style="font-size:30px; font-weight:bold; text-align:center;margin-top:3px;"><?php echo xin_company_info(1)->company_name; ?></div>
        <div style="font-size:20px; font-weight:bold; text-align:center;"><?php echo xin_company_info(1)->address_1 ." ". xin_company_info(1)->address_2; ?></div> 
        <div style="font-size:18px; font-weight:bold; text-align:center; margin-bottom:3px"> <?php echo $statusText; ?> Report </div>

    </td>
</tr>
		<tr  style="font-size:20px; font-weight:bold; text-align:center;margin-top:10px;">
            <th style="background-color: #4CAF50;color: white;">Sl. No.</th>
            <th style="background-color: #4CAF50;color: white;">Product Name</th>
            <th style="background-color: #4CAF50;color: white;">Category</th>
            <th style="background-color: #d5b2b2; color: black;">Sub Category</th>
            <th style="background-color: #d5b2b2; color: black;">Unit</th>
            <th style="background-color: #d5b2b2; color: black;">Available Quantity</th>
            <th style="background-color: #d5b2b2; color: black;">Oder Level</th>

            
          </tr>
          <?php if (!empty($values)): ?>
                    <?php $i = 1; foreach ($values as $row): ?>
                        <tbody>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row->product_name?></td>
                                <td><?php echo $row->category_name ?></td>
                                <td><?php echo $row->sub_cate_name ?></td>
                                 <td><?php echo $row->unit_name ?></td>
                                <td><?php echo $row->quantity ?></td>
                                <td><?php echo $row->order_level ?></td>
                               
                            </tr>
                        </tbody>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tbody>
                        <tr>
                            <td colspan="9">No data found.</td>
                        </tr>
                    </tbody>
                <?php endif; ?>
          </tbody>


<!-- e2 -->



	</table>

</body>
</html>