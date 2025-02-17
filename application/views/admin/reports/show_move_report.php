<!-- < ?php  dd( $reports)?> -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<style>
	thead td {font-size :12px;font-weight:bold;text-align:center;}
	tbody td{font-size:12px;text-align:center;}
</style>	
<div class="box" id="print_area">
  <div style="text-align: center;">
	<?php  $this->load->view('admin/head_bangla'); 
		if($status == 'daily'){
			echo '<h5>Report on : '. date('d M Y',strtotime($first_date)).'</h5>';
		} else if($status == 'weekly'){
			echo '<h5>Report on : '. date('d M Y',strtotime($first_date)).' to '.date('d M Y',strtotime('+6 days'.$first_date)).'</h5>';
		} else{
			echo '<h5>Report on : '. date('d M Y',strtotime($first_date)).' to '.date('d M Y',strtotime($second_date)).'</h5>';
		}
	?>


  </div>
  <div class="container" style="margin-top:15px">
  	<div class="">
	    <div class=" table-responsive table-striped">
	      <table class="table table-bordered bg-light">
	        <thead >
               	<td >Sl. No.</td>
				<td>Employee Name</td>
				<td>Date</td>
				<td>Department Name</td>
				<td>Designation Name</td>
				<td>Start Time</td>
				<td>End Time</td>
				<td>Category</td>
				<td>Model</td>
				<td>Tag No</td>
				<td>Place</td>
				<td>Status</td>
	        </thead>

        <tbody>
				<?php  $i=1; foreach($reports as $report){ ?>
				<tr>
					<td><?php echo $i++?></td>
					<td><?php echo $report->first_name.' '.$report->last_name?></td>
                    <td><?php echo date('d M Y',strtotime($report->created_at))?></td>
					<td><?php echo $report->department_name?></td>
					<td><?php echo $report->designation_name?></td>
					<td><?php echo date('h:i:s a',strtotime($report->start_time))?></td>
					<td><?php echo $report->close_time==''? "<span class='label label-success h5'><b>On Going</b></span>": date('h:i:s a',strtotime($report->close_time)) ?></td>
					<td><?php echo $report->cat_name?></td>
					<td><?php echo $report->model_name?></td>
					<td style=" text-transform: uppercase;"><?php echo 'MHL'.' '.$report->cat_short_name.'-'.$report->device_name_id?></td>
                    <td><?php echo $report->floor== 3 ? $report->floor.'rd' :($report->floor== 5? $report->floor.'th': "Out Side")?></td>
					<td><?php echo $report->status=='2'?"<span class='label label-success'>On Movement</span>" : "<span class='label label-info'>out of Movement</span>";?></td>
				</tr>
				<?php }?>
            </tbody>
	      </table>
	    </div>
	  </div>
  </div>
</div>