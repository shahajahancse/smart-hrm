<!-- < ?php dd($late_status);?> -->

<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<style type="text/css">
	.box-tools {
	    margin-right: -5px !important;
	}

	table thead tr th {
		font-size:12px;
		padding: 3px !important;
	}

	table tbody tr td {
		font-size: 12px;
		padding: 3px !important;
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
		body {
			zoom: 80% !important;
		}
	}

</style>

<div class="box" id="print_area">
  <div style="text-align: center;">
<?php  $this->load->view('admin/head_bangla'); ?>
  <h4 class="box-title">Overall Performance Report <?=$first_date?> to <?=$second_date?></h4>
	  <br><br>
  </div>

  <div class="container">
  	<div class="box-body">
	    <div class="box-datatable table-responsive">
	      <table class="table table-striped table-bordered">
	        <thead>
                <td>Sl. No.</td>
                <td>Employee Name</td>
                <td>Total Day</td>
                <td>Present</td>
                <td>Absent</td>
                <td>Late</td>
                <td>Overtime</td>
                <td>Leave</td>
	        </thead>
            <tbody >
            <?php  $i=1; foreach($data as $row){?>
                <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row['first_name'].' '.$row['last_name']?></td>  
                <td><?php echo $row['total_day']?><br>
                  
                </td>  
                <td>
                    <?php echo $row['total_present']?><br>
                    <?php echo $row['total_percent_present']?>%<br>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $row['total_percent_present']?>%" aria-valuenow="<?php echo $row['total_percent_present']?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>  
                <td>
                    <?php echo $row['total_absent']?><br>
                    <?php echo $row['total_percent_absent']?>%<br>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $row['total_percent_absent']?>%" aria-valuenow="<?php echo $row['total_percent_absent']?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>  
                <td>
                    <?php echo $row['total_late']?><br>
                    <?php echo $row['total_percent_late']?>%<br>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $row['total_percent_late']?>%" aria-valuenow="<?php echo $row['total_percent_late']?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>  
                <td>
                    <?php echo $row['total_overtime']?><br>
                    <?php echo $row['total_percent_overtime']?>%<br>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $row['total_percent_overtime']?>%" aria-valuenow="<?php echo $row['total_percent_overtime']?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>  
                <td>
                    <?php echo $row['total_leave']?><br>
                    <?php echo $row['total_percent_leave']?>%<br>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $row['total_percent_leave']?>%" aria-valuenow="<?php echo $row['total_percent_leave']?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </td>  
                </tr>
                <?php }?>
            </tbody>
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
