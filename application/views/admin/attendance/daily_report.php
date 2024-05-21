<!-- < ?php dd($late_status);?> -->

<link rel="stylesheet"
    href="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>skin/hrsale_assets/css/hrsale/xin_hrsale_custom.css">

<style type="text/css">
.box-tools {
    margin-right: -5px !important;
}

table thead tr th {
    font-size: 12px;
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
        <h4 class="box-title">Daily <?php echo $status=="Present" && $late_status==1 ? "Late":$status ?> Report</h4>
        <!-- < ?php echo $this->lang->line('xin_employees_monthly_timesheet');?> -->

        <p>Report date: <?php echo $attendance_date; ?> </p>
        <span class="box-tools"> A: Absent, P: Present, H: Holiday, L: Leave, HP: HalfDay</span><br><br>
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
                        <td>In Time</td>
                        <td>Out Time</td>
                        <td>Status</td>
                        <td>Comment</td>
                    </thead>
                    <?php
                    
                    $i=1; foreach($values as $row){?>
                    <tbody>
                        <?php 
					
            			// $status = $row->attendance_status == "Present" && $row->late_status == 0 && ( $row->clock_in == "" || $row->clock_out =="") ? "P(ERROR)":
                  //           (  $row->attendance_status == "Absent"  ? "A" :
                  //           (  $row->attendance_status == "Leave"   ? "L" : ( $row->attendance_status == "Present" && $row->late_status == 1 ? "P(Late)":($row->attendance_status == "Present" && $row->late_status == 0  ? "P"  : ($row->attendance_status == "Meeting" && $row->late_status == 0  ? "M":"H") ))))

                  if ($row->status == "Absent") {
                  	$status = "A";
                  } else if (($row->status == "Present" && $row->late_status == 0) && ($row->clock_in == "" || $row->clock_out == "")) {
                  	$status = "P(ERROR)";
                  }else if ($row->status == "Off Day"){
					$status = "Off Day";
				 } else if ($row->status == "Present" && $row->late_status == 1) {
                  	$status = "P(Late)";
                  } else if ($row->status == "Present" && $row->late_status == 0) {
                  	$status = "P";
                  } else if ($row->attendance_status == "Meeting" && $row->late_status == 0) {
                  	$status = "M";
                  } else if ($row->status == "HalfDay" && $row->late_status == 0) {
                  	$status = "P(H)";
                  }else if ($row->status == "HalfDay" && $row->late_status == 1) {
					$status = "P(H)(Late)";
					} else {
						$status = "HL";
					}
            		?>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $row->first_name.' '.$row->last_name?></td>
                        <td><?php echo $row->department_name?></td>
                        <td><?php echo $row->designation_name?></td>
                        <td><?php echo $row->clock_in==""? "": date('H:i:s a',strtotime($row->clock_in))?></td>
                        <td><?php echo $row->clock_out==""? "": date('h:i:s a',strtotime($row->clock_out))?></td>
                        <td><?php echo $status;?></td>
                        <td><?php echo $row->comment;?></td>
                    </tbody>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- jQuery 3 -->
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js">
</script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js">
</script>

<script
    src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js">
</script>
<!-- Morris.js charts -->