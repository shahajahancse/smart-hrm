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
  <h4 class="box-title">Extra Present Report from <?=$first_date?> to <?=$second_date?></h4>
	  <br><br>
  </div>

  <div class="container">
  	<div class="box-body">
	    <div class="box-datatable table-responsive">
	      <table class="table table-striped table-bordered">
	        <thead>
                <td>Sl. No.</td>
                <td>Employee Name</td>
                <td>Department Name</td>
                <td>Designation Name</td>
                <td>Date</td>
                <td>Day</td>
                <td>In Time</td>
                <td>Out Time</td>
                <td>Status</td>
                <td>Comment</td>
	        </thead>
            <?php $i=1; foreach($values as $row){?>
            <tbody >
            		<?php 
            			

                
            		?>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->first_name.' '.$row->last_name?></td>
                <td><?php echo $row->department_name?></td>
                <td><?php echo $row->designation_name?></td>
				<td><?php echo $row->attendance_date?></td>
				<td><?php echo date('D',strtotime($row->attendance_date))?></td>
                <td><?php echo $row->clock_in==""? "": date('H:i:s a',strtotime($row->clock_in))?></td>
                <td><?php echo $row->clock_out==""? "": date('h:i:s a',strtotime($row->clock_out))?></td>
                <td><?php echo $row->attendance_status;?></td>
                <td><?php echo $row->comment;?></td>
            </tbody>
            <?php }?>
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
