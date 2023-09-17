<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="col-lg-8">
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="process_date">First Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date" name="process_date" type="text" autocomplete="off">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="process_date">Second Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="second_date" name="second_date" type="text" autocomplete="off">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border" id="report_title">
    <h3 class="box-title" id="report">  Report</h3>
  </div>

  <div class="box-body" id="emp_report">
    <ul class="nav nav-tabs " id="myTab" role="tablist">
      <li class="nav-item active">
        <a class="nav-link " id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Requsition</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Purchase</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" id="mobile-tab" data-toggle="tab" href="#mobile" role="tab" aria-controls="mobile" aria-selected="false">Mobile Bill</a>
      </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab" style="margin-top: 30px;">
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(1)">Pending</button>
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(2)">Approved</button>
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(4)">Reject</button>
        <button class="btn btn-info btn-sm"  onclick="Inv_Report(3)">Delivered Item</button>
      </div>
      <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab" style="margin-top: 30px;">
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(1)">Pending</button>
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(2)">Approved</button>
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(4)">Reject</button>
        <button class="btn btn-info btn-sm"  onclick="Per1_Report(3)">Receive</button>
        <button class="btn btn-info btn-sm"  onclick="LP_AlP_Report(7)">Low inventory</button>
        <button class="btn btn-info btn-sm"  onclick="LP_AlP_Report(8)">All Products</button>
      </div>

      <div class="tab-pane fade" id="mobile" role="tabpanel" aria-labelledby="mobile-tab" style="margin-top: 30px;">
        <button class="btn btn-info btn-sm"  onclick="mobile_bill(1)"> Pending </button>
        <button class="btn btn-info btn-sm"  onclick="mobile_bill(2)"> Approved </button>
        <button class="btn btn-info btn-sm"  onclick="mobile_bill(3)"> Reject </button>
        <button class="btn btn-info btn-sm"  onclick="mobile_bill(4)"> Payment </button>
      </div>
    </div>
  </div>

  <div  class="box-body" id="entry_form"></div>

</div>
</div>



<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>