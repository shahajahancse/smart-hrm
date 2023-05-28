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
<?php


?>
<div class="box" id="print_area">
  <div style="text-align: center;">
<?php  $this->load->view('admin/head_bangla'); ?>
  </div>

  <div class="container">
  	<div class="box-body">
	    <div class="box-datatable table-responsive">
	      <table class="table table-striped table-bordered">
	        <thead>
                <td>Sl. No.</td>
                <td>Employee Name</td>
                <td>From</td>
                <td>to</td>
                <td>Type</td>
                <td>Qty</td>
                <td>Status</td>
	        </thead>
            <?php foreach($xin_employees as $key=>$row){
                
                $user_info = $this->Xin_model->read_employee_info($row->employee_id);
                
                ?>

            
                <td><?php echo $key+1;?></td>
                <td><?php echo $user_info[0]->first_name.' '.$user_info[0]->last_name?></td>
                <td><?php echo $row->from_date?></td>
                <td><?php echo $row->to_date?></td>
                <td><?php echo $row->leave_type?></td>
                <td><?php echo $row->qty?></td>
                <?php
                if ($row->status==1) {
                    echo "<td class='text text-info' >Pending</td>";
                }elseif ($row->status==2) {
                    echo "<td class='text text-success' >Approved</td>";
                }elseif ($row->status==3) {
                    echo "<td class='text text-danger' >Rejected</td>";
                }
                ?>
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
