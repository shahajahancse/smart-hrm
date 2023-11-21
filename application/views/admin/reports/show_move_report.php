<!-- < ?php  dd( $reports)?> -->
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
				<td>Employee Name</td>
				<td>Date</td>
				<td>Category</td>
				<td>Model</td>
				<td>Tag No</td>
				<td>Floor</td>
				<td>Status</td>
	        </thead>

              <!-- [id] => 10
                    [device_id] => 3
                    [user_id] => 10
                    [start_time] => 2023-11-21 10:30:14
                    [close_time] => 
                    [floor] => 3
                    [status] => 1
                    [purpose] => meeting
                    [remark] => office meeting
                    [created_by] => 6
                    [created_at] => 2023-11-21
                    [first_name] => Md. Imran Hosen
                    [last_name] => Tutul
                    [model_name] => Asus
                    [cat_name] => Laptop
                    [cat_short_name] => LP
                    [device_name_id] => 15 -->
        <tbody>
				<?php  $i=1; foreach($reports as $report){ ?>
				<tr>
					<td><?php echo $i++?></td>
					<td><?php echo $report->first_name.' '.$report->last_name?></td>
                    <td><?php echo date('d M Y',strtotime($report->created_at))?></td>
					<td><?php echo $report->cat_name?></td>
					<td><?php echo $report->model_name?></td>
					<td style=" text-transform: uppercase;"><?php echo 'MHL'.' '.$report->cat_short_name.'-'.$report->device_name_id?></td>
                    <td><?php echo $report->floor== 3 ? $report->floor.'rd' : $report->floor.'th'?></td>
					<td><?php echo $report->status=='2'?"<span class='label label-success'>On Movement</span>" : "<span class='label label-info'>out of Movement</span>";?></td>
				</tr>
				<?php }?>
            </tbody>
	      </table>
	    </div>
	  </div>
  </div>
</div>
