
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
	}

</style>

<div class="box" id="print_area">
  <div style="text-align: center;">
	  <h3 class="box-title"> <?php echo $this->lang->line('xin_employees_monthly_timesheet');?></h3>
	  <p>For the month of <?php echo $attendance_date; ?> </p>
    <span class="box-tools"> A: Absent, P: Present, H: Holiday, L: Leave</span><br><br>
  </div>

  <div class="container">
  	<div class="box-body">
	    <div class="box-datatable table-responsive">
	      <table class="table table-striped table-bordered">
	        <thead>
	        </thead>
	        <tbody>
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
