<!-- < ?php dd($values);?> -->

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
    th,td{
        text-align: center;
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
  <?php  $this->load->view('admin/head_bangla'); ?>
	  <h4 class="box-title">Daily Unpaid Report</h4>
        <!-- < ?php echo $this->lang->line('xin_employees_monthly_timesheet');?> -->
	  <p>Report date: <?php echo $first_date; ?> To <?php echo $second_date; ?> </p>
  </div>

  <div class="container">
  	<div class="box-body">
	    <div class="box-datatable ">
	      <table class="table table-striped table-responsive  table-bordered table-sm">
	        <thead>
                <td>Sl. No.</td>
                <td>Employee Name</td>
                <td>Department</td>
                <td>Designation</td>
                <td>Request Amount</td>
                <td>Payable Amount</td>
                <td>Out Time</td>
                <td>In Time</td>
                <td>Reason</td>
	        </thead>
            <?php if (!empty($values)): ?>
                    <?php $i = 1; foreach ($values as $row): ?>
                        <tbody>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row->first_name . ' ' . $row->last_name ?></td>
                                <td><?php echo $row->department_name ?></td>
                                <td><?php echo $row->designation_name ?></td>
                                <td><?php echo $row->request_amount ?></td>
                                <td><?php echo $row->payable_amount ?></td>
                                <td><?php echo !empty($row->out_time) ? date('h:i:s a', strtotime($row->out_time)) : '' ?></td>
                                <td><?php echo !empty($row->in_time) ? date('h:i:s a', strtotime($row->in_time)) : '' ?></td>
                                <td><?php echo $row->reason ?></td>
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
