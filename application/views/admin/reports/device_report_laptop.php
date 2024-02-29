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
  <h5 class="text-center">Device Report : Laptop</h5>
  <div class="container" style="margin-top:15px">
  	<div class="">
	    <div class=" table-responsive table-striped">
	      <table class="table table-bordered bg-light">
	        <thead >
               	<td>Sl. No.</td>
				<td>User Name</td>
				<td>Desk No</td>
				<td>Laptop No</td>
				<td>Extra Monitor No</td>
				<td>Configuration</td>
				<td>Hard Disk</td>
				<td>SSD</td>
				<td>RAM</td>
				<td>Keyboard</td>
				<td>Mouse</td>
				<td>Charger</td>
	        </thead>
        <tbody>
				<?php   $i=1; foreach($laptop as $report){ ?>
				<tr>
					<td><?php echo $i++?></td>
                    <td><?php echo $report->first_name.' '.$report->last_name?></td>
                    <td><?php echo $report->desk_no?></td>
                    <td><?php echo 'MHL-LP-'.$report->laptop_no?></td>
                    <td><?php echo $report->ex_monitor_no == 'null' ||$report->ex_monitor_no ==NULL? '-': 'MHL-MT-'.$report->ex_monitor_no?></td>
                    <td><?php $config = explode('_',$report->configuration); echo $report->configuration == 'null' ||$report->configuration ==NULL?'-': 'core i'.$config[0] .','.$config[0].'th gen'?></td>
                    <td><?php echo $report->harddisk == 1? $report->harddisk.'TB' : $report->harddisk.'GB' ?></td>
                    <td><?php echo $report->ssd =='null' ||$report->ssd ==NULL ? '-' : $report->ssd.'GB' ?></td>
                    <td><?php echo $report->ram.'GB'?></td>
                    <td><?php echo $report->keyboard =='null' ||$report->keyboard ==NULL ? '-':'MHL-KB-'.$report->keyboard?></td>
                    <td><?php echo $report->mouse =='null' ||$report->mouse ==NULL ? '-':'MHL-MOU-'.$report->mouse?></td>
                    <td><?php echo $report->charger =='null'||$report->charger ==NULL ? '-' : 'MHL-LP-Charger-'.$report->charger ?></td>
				</tr>
				<?php }?>
            </tbody>
	      </table>
	    </div>
	  </div>
  </div>
</div>