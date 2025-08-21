<?php $session = $this->session->userdata('username');?>
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Yearly Reports & Interest Calculation</h4>
        
      </div>
      <div class="card-body collapse in">
        <div class="card-block">
          <form class="form" method="post" name="calculate_interest_form" id="calculate_interest_form" action="<?php echo site_url('admin/provident_fund/yearly_reports');?>">
            <input type="hidden" name="type" value="calculate_interest">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="year">Select Year</label>
                  <select class="form-control" name="year" id="year" required>
                    <?php for($i = date('Y'); $i >= 2000; $i--):?>
                      <option value="<?php echo $i;?>" <?php echo ($i == date('Y')) ? 'selected' : '';?>><?php echo $i;?></option>
                    <?php endfor;?>
                  </select>
                </div>
              </div>
              <div class="col-md-4 d-flex align-items-end">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Calculate & Post Interest</button>
                </div>
              </div>
            </div>
          </form>
          <hr>
          <h4>Yearly Interest Reports</h4>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>Interest Year</th>
                  <th>Balance Before Interest</th>
                  <th>Interest Amount</th>
                  <th>Balance After Interest</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($yearly_interests)):?>
                <?php foreach($yearly_interests as $interest):?>
                <tr>
                  <td><?php echo $interest->first_name . ' ' . $interest->last_name;?></td>
                  <td><?php echo $interest->interest_year;?></td>
                  <td><?php echo $interest->balance_before_interest;?></td>
                  <td><?php echo $interest->interest_amount;?></td>
                  <td><?php echo $interest->balance_after_interest;?></td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                  <td colspan="5">No yearly interest records found for this year.</td>
                </tr>
                <?php endif;?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    // Form submission for Calculate Interest
    $("#calculate_interest_form").submit(function(e){
        e.preventDefault();
        var obj = $(this), action = obj.attr('action');
        $.ajax({
            type: "POST",
            url: action,
            data: obj.serialize(),
            cache: false,
            dataType: 'json',
            success: function (JSON) {
              console.log('JSON');
              
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                } else {
                    toastr.success(JSON.success);
                    $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                }
              location.reload(); 
            },
            error: function (xhr, status, error) {
               location.reload(); // Reload page on error
              
            }
        });
    });
});
</script>