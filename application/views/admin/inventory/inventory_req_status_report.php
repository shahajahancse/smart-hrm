<!-- </?php dd($values);?> -->
<?php
$statusText = "";
if ($statusC == 1) {
    $statusText = "Pending";
} elseif ($statusC == 2) {
    $statusText = "Approved";
} elseif ($statusC == 3) {
    $statusText = "Handover";
} elseif ($statusC == 4) {
    $statusText = "Rejected";
}
    $exc=1;
?>

<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<style type="text/css">
	.box-tools {
	    margin-right: -5px !important;
	}

	table thead tr th {
		font-size:12px;
        /* color: blue; */
		padding: 3px !important;
	}

	table tbody tr td {
		font-size: 11px;
		padding: 3px !important;
	}
    th,td{
        text-align: center;
    }
    
.ti1{
    margin-top: 3px;
    margin-bottom: 0px;
    font-size: 15px;
}

	@media print {
		.box-tools {
	    margin-right: -5px !important;
		}
		table thead tr th {
			font-size: 12px;
			padding: 3px !important;
		}
		table tbody tr td {
			font-size: 14px;
			padding: 3px !important;
		}
	}

</style>


<div style="float: right;margin-left:10px;margin-top:30px">
    <button class="btn btn-sm btn-primary" onclick="printPageMove()">Print</button>   

    <form style="float: right;"  action="<?php echo base_url('admin/inventory/inventory_status_report/'.$exc); ?>" method="post">
    <input type="hidden" name="first_date" value="<?php echo $first_date; ?>">
    <input type="hidden" name="second_date" value="<?php echo $second_date; ?>">
    <input type="hidden" name="statusC" value="<?php echo $statusC; ?>">
    <button class="btn btn-sm btn-info" type="submit">Excel</button>
    </form>

</div>

<div style="clear: both;"></div>

<div class="box" id="print-content" style="margin-top:-50px">
  <div style="text-align: center;">
  <?php  $this->load->view('admin/head_bangla'); ?>
      <h4 class="box-title  ti1"><?php echo $statusText; ?> Report</h4>
        <?php 
            if($first_date !=null && $second_date !=null){
             echo "Report date: " .date("d M Y",strtotime($first_date))." to ".date("d M Y",strtotime($second_date)); 
            }
        ?>
  </div>
  

  <div class="container" style="margin-top:15px">
  	<div class="box-body" >
	    <div class="box-datatable ">
	      <table class="table table-striped table-responsive  table-bordered table-sm">
            <thead>
                <th>Sl. No.</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Catagory</th>
                <th>Sub Catagory</th>
                <th>Product Name</th>
                <th>Request Quantity</th>
                <th>Approved Quantity</th>
                <th>Remark</th>
                <th>Date </th>
            </thead>
            <?php if (!empty($values)): ?>
                    <?php $i = 1; foreach ($values as $row): ?>
                        <tbody>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row->first_name . ' ' . $row->last_name ?></td>
                                <td><?php echo $row->department_name ?></td>
                                <td><?php echo $row->designation_name ?></td>
                                <td><?php echo $row->category_name ?></td>
                                <td><?php echo $row->sub_cate_name ?></td>
                                <td><?php echo $row->product_name ?></td>
                                <td><?php echo $row->quantity ?></td>
                                <td><?php echo $row->approved_qty ?></td>
                                <td><?php echo $row->note ?></td>
                                <td><?php echo !empty($row->created_at) ? date('d-m-Y', strtotime($row->created_at)) : ''; ?></td>
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

            
	      </table>
	    </div>
	  </div>
  </div>
</div>

<!-- jQuery 3 -->
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js"></script>

<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script>function printPageMove() {
    var printContents = document.getElementById("print-content").innerHTML;
    var originalContents = document.body.innerHTML;

    // set custom layout, page size, page margin, and page heading
    var printCSS = '<style>@page { size: A4 landscape; margin: 1cm; @top-center { content: "My Custom Page Header"; } } \
                    body { -webkit-print-color-adjust: exact; color-adjust: exact; } \
                    table { border-collapse: collapse; width: 100%; margin: 0 auto; max-width: 100%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); } \
                    th { background-color: #0177BC; color: white; font-size: 18px; font-weight: bold; text-align: center; padding: .5px} \
                    .im { background: #d5b2b2 !important; color: currentcolor !important; } \
                    td { font-size: 15px; text-align: center; border: 2px solid #ddd; width: 19px; } \
                    tr:hover { background-color: #f5f5f5; } \
                    .tdb { background-color: cadetblue; }</style>';
    
    document.body.innerHTML = printCSS + '<div id="print-content">' + printContents + '</div>';

    window.print();

    document.body.innerHTML = originalContents;
}
</script>