<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<style>
	thead td {font-size :12px;font-weight:bold;text-align:center;}
	tbody td{font-size:12px;text-align:center;}
</style>	
<div class="box" id="print_area">
  <div style="text-align: center;">
<?php  $this->load->view('admin/head_bangla'); ?>
  </div>
  <div class="container" style="margin-top:15px">
  	<div class="box-body">
	    <div class=" table-responsive table-striped">
	      <table class="table table-bordered bg-light">
	        <thead >
                <td >Sl. No.</td>
                <td colspan="1">User Name</td>
                <td colspan=""><?php echo @$reports[0]->cat_name?></td>
	        </thead>
            <tbody>
				<tr>
					<td></td>
					<td></td>
				</tr>

				<?php  $i=1; foreach($reports as $report){ ?>
				<tr>
					<td><?php echo $i++?></td>
					<td><?php echo $report->first_name.' 	'.$report->last_name?></td>
					<?php if($report->cat_name == "Sim"){?>
						<td><?php echo $report->number?></td>
						<td><?php echo $report->model_name ?></td>
					<?php } else{?>
					<td><?php echo $report->model_name?></td>
					<td><?php echo $report->model_name?></td>
					<td style=" text-transform: uppercase;"><?php echo 'MHL'.' '.$report->cat_short_name.'-'.$report->device_name_id?></td>
					<td><?php echo $report->remark?></td>
				</tr>
				<?php }}?>
            </tbody>
	      </table>
	    </div>
	  </div>
  </div>
</div>
