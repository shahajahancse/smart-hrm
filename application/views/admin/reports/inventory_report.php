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
	    <div class=" table-responsive table-striped">
	      <table class="table table-bordered bg-light">
	        <thead >
               	<td >Sl. No.</td>
				<td>Item Name</td>
				<td>Category</td>
				<td>Model</td>
				<td>Details</td>
				<td>Purpose</td>
				<td>Status</td>
				<td>User</td>
	        </thead>
        <tbody>
				<?php  $i=1; foreach($reports as $report){ ?>
				<tr>
					<td><?php echo $i++?></td>
					<td style=" text-transform: uppercase;"><?php echo 'MHL'.' '.$report->cat_short_name.'-'.$report->device_name_id?></td>
					<td><?php echo $report->cat_name?></td>
					<td><?php echo $report->model_name?></td>
					<td><?php echo $report->description?></td>
					<td><?php echo $report->remark?></td>
					<td><?php echo $report->status=='1'?"<span class='label label-success'>On Working</span>" : ($report->status==2?"<span class='label label-warning'>Store</span>":($report->status==3?"<span class='label label-warning'>Servicing</span>":($report->status == 4 ?"<span class='label label-danger'>Damage</span>" :"<span class='label label-info'>Movement</span>")));?></td>
					<td><?php echo $report->first_name.' 	'.$report->last_name?></td>
					<?php if (isset($type) == 1) { ?>
					<!-- <td><img style="height:60px;width:60px" src="< ?php echo (empty($report->image)) ? base_url("uploads/no_image.png"): base_url("uploads/accessory_images/".$report->image)?>"></td> -->
					<?php } ?>
				</tr>
				<?php }?>
            </tbody>
	      </table>
	    </div>
	  </div>
  </div>
</div>
