<!-- < ?php  dd( $reports)?> -->
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<style>
	thead td {font-size :12px;font-weight:bold;text-align:center;}
	tbody td{font-size:12px;text-align:center;}
</style>	
<div class="box" id="print_area">
  <div style="text-align: center;">
	<?php  $this->load->view('admin/head_bangla'); 
		if($status == 1){
			echo '<h5>Pending Report</h5>';
			echo '<h5>Report on : '. date('d M Y',strtotime($first_date)).'</h5>';
		} else if($status == 2){
			echo '<h5>Approved Report</h5>';
			echo '<h5>Report on : '. date('d M Y',strtotime($first_date)).' to '.date('d M Y',strtotime('+6 days'.$first_date)).'</h5>';
		} else{
			echo '<h5>Reject Report</h5>';
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
				<td>Mobile Number</td>
				<td>Request Amount</td>
				<?php
				$check = false;
				foreach ($reports as $report) {
					if ($report->status == 2 && !$check) {
						echo '<td>Approved Amount</td>';
						$check = true;
					}
				}
				?>
	        </thead>

        <tbody>
				<?php  $i=1; foreach($reports as $report){ ?>
				<tr>
					<td><?php echo $i++?></td>
					<td><?php echo $report->first_name.' '.$report->last_name?></td>
                    <td><?php echo date('d M Y',strtotime($report->created_at))?></td>
					<td><?php echo $report->department_name?></td>
					<td><?php echo $report->designation_name?></td>
					<td><?php echo $report->phone_number?></td>
					<td><?php echo $report->amount?></td>
					<?php if($report->status==2){?>
					<td><?php echo $report->approved_amount?></td>
					<?php }?>
					<!-- <td>< ?php echo $report->status=='1'?"<span class='label label-warning'>Pending</span>" : "<span class='label label-success'>Aproved</span>";?></td> -->
				</tr>
				<?php }?>
            </tbody>
	      </table>
	    </div>
	  </div>
  </div>
</div>