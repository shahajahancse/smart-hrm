<!-- < ? php  dd( $reports)?> -->
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
  	<div class="">
        <h5 class="text-center">Device Report : Desktop</h5>
	    <div class=" table-responsive table-striped">
	      <table class="table table-bordered bg-light">
	        <thead >
               	<td>Sl. No.</td>
				<td>User Name</td>
				<td>Desk No</td>
				<td>Pc No</td>
				<td>Monitor No</td>
				<td>Configuration</td>
				<td>Hard Disk</td>
				<td>SSD</td>
				<td>RAM</td>
				<td>Keyboard</td>
				<td>Mouse</td>
				<td>Ups</td>
				<!-- <td>Status</td> -->
	        </thead>
        <tbody>
				<?php   $i=1; foreach($desktop as $report){ ?>
				<tr>
					<td><?php echo $i++?></td>
                    <td><?php echo $report->first_name.' '.$report->last_name?></td>
                    <td><?php echo $report->desk_no?></td>
                    <td><?php echo 'MHL-PC-'.$report->pc_no?></td>
                    <td><?php echo 'MHL-MT-'.$report->monitor_no?></td>
                    <td><?php $config = explode('_',$report->configuration); echo 'core i'.$config[0] .','.$config[0].'th gen'?></td>
                    <td><?php echo $report->harddisk == 1? $report->harddisk.'TB' : $report->harddisk.'GB' ?></td>
                    <td><?php echo ($report->ssd ==NULL || $report->ssd =='null') ? '-' : $report->ssd.'GB' ?></td>
                    <td><?php echo $report->ram.'GB'?></td>
                    <td><?php echo ($report->keyboard ==NULL || $report->keyboard =='null') ? '-' :'MHL-KB-'.$report->keyboard?></td>
                    <td><?php echo ($report->mouse ==NULL || $report->mouse =='null') ? '-' :'MHL-KB-'.$report->mouse?></td>
                    <td><?php echo ($report->usp ==NULL || $report->usp =='null') ? '-' : 'MHL-UPS-'.$report->usp ?></td>
                    <!-- <td style="background:seagreen;color:white;font-weight:bold"><?php echo $report->status == 1 ? 'Using Device' : ($report->status == 2 ? 'Stored Device' : 'Damaged Deviced') ?></td> -->
				</tr>
				<?php }?>
            </tbody>
	      </table>
	    </div>
	  </div>
  </div>
</div>
