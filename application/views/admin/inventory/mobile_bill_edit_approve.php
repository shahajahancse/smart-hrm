<?php 
$session = $this->session->userdata('username');
// dd($results);
$get_animate = $this->Xin_model->get_content_animate();
?>
<style>
  .table {
    width: 92%;
    margin-bottom: 14px;
}
</style>
<div class="box <?php echo $get_animate;?>" style="margin-top:20px">
  <div class="box-header with-border">
    <h3 class="box-title">MObile Bill Approval</h3>
    <button class="btn btn-sm btn-info pull-right" style="margin-right: 10px;" onclick="history.back()"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
    <br/>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
    <!-- <input type="text" value="1" id="count"> -->
      <table class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
              <th class="text-center" >No.</th>
              <th class="text-center" >Request Amount</th>
              <th class="text-center" >Approved Amount</th>
          </tr>
        </thead>
        <?php echo form_open('admin/inventory/mobile_bill_approved/'.$ids)?>
        <tbody>
            <?php  $i=1;?>
            <tr class="text-center">
                <td><?php echo $i++?></td>
                <td><?php echo $amount->amount?></td>
                <input type="hidden" name="h_id" value="<?php echo $amount->id?>">
                <td><input type="number" name="approved_amount" placeholder="Enter Amount"></td>
            </tr>         
        </tbody>
      </table>
      <?php if(!empty($results)){?>
      <?php if($session['role_id']!=3) {?>
      <input type="submit" class="btn btn-sm btn-success pull-right" style="margin-right: 10px;" value="Approved">
      <?php } }?>
      <button type="submit" class="btn btn-sm btn-success pull-right">Submit</button>
      <?php echo form_close()?>
    </div>
  </div>
</div>