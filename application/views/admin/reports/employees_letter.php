
<style>
  .breadcrumb {
       margin-bottom: 0px !important; 
  }
  .dbtn {
    background: #0177bc !important;
    color: #fff !important;
  }
</style>
<div class="row m-b-1">
  <div class="col-md-8">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Employees Letter </h3>
      </div>
      <div class="box-body">
            <div class="col-md-12">
              <div class="form-group col-md-4">
                  <label for="">Select Employee</label>
                  <select class="form-control select22" name="employee_id" id="employee_id" onchange="get_employee_inc_pro(this.value)">
                      <option value="">Select Employee</option>
                      <?php foreach ($all_employees as $employee) { ?>
                          <option value="<?= $employee->user_id ?>"><?= $employee->first_name ?> <?= $employee->last_name ?></option>
                      <?php } ?>
                  </select>
              </div>
              <div class="form-group col-md-4">
                  <label for="">Select Increment</label>
                  <select class="form-control select2" name="employee_id" id="inc_id">
                      <option value="">Select Increment</option>
                      <?php foreach ($all_employees as $employee) { ?>
                          <option value="<?= $employee->user_id ?>"><?= $employee->first_name ?> <?= $employee->last_name ?></option>
                      <?php } ?>
                  </select>
              </div>
              <div class="form-group col-md-4">
                  <label for="">Select Promotion</label>
                  <select class="form-control select2" name="employee_id" id="pro_id">
                      <option value="">Select Promotion</option>
                      <?php foreach ($all_employees as $employee) { ?>
                          <option value="<?= $employee->user_id ?>"><?= $employee->first_name ?> <?= $employee->last_name ?></option>
                      <?php } ?>
                  </select>
              </div>
            </div>
      </div>
    </div>
    <div class="box">
      <div class="box-body">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#tab1">Employees Letter</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab1" class="tab-pane fade in active">
            <div class="form-group" style="margin-top:20px; margin-top: 20px; display: flex; flex-wrap: wrap; gap: 5px;">
              <button class="btn dbtn btn-sm " onclick="joining_letter()">Joining Letter</button>
              <button class="btn dbtn btn-sm " onclick="increment_letter()">Increment Letter</button>
              <button class="btn dbtn btn-sm " onclick="promotion_letter()">Promotion Letter</button>
              <button class="btn dbtn btn-sm " onclick="confirmation_letter()">Confirmation Letter</button>
              <button class="btn dbtn btn-sm " onclick="appointment_letter()">Appointment Letter</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  function get_employee_inc_pro(id) {
    $('#inc_id').html('<option value="">Select Increment</option>');
    $('#pro_id').html('<option value="">Select Promotion</option>');
    $.ajax({
      type: "POST",
      url: "<?= base_url() ?>admin/reports/get_employee_inc_pro",
      data: {
        id: id
      },
      success: function(resp) {
        var data=JSON.parse(resp);
        var increment_data=data.increment;
        var promotion_data=data.promotion;
        increment_html='<option value="">Select Increment</option>';
        promotion_html='<option value="">Select Promotion</option>';
        for(var i=0;i<increment_data.length;i++){
          increment_html+='<option value="'+increment_data[i].id+'">'+increment_data[i].effective_date+'</option>';
        }
        for(var i=0;i<promotion_data.length;i++){
          promotion_html+='<option value="'+promotion_data[i].id+'">'+promotion_data[i].effective_date+'</option>';
        }
        $('#inc_id').html(increment_html);
        $('#pro_id').html(promotion_html);
      },
      error: function(resp) {
        alert(resp);
      }
    });
  }
</script>
<script>
  function joining_letter() {
    var id = $('#employee_id').val();
    if (id == '') {
      alert('Please select employee');
      return false;
    }
    window.open("<?= base_url() ?>admin/reports/joining_letter/" + id, '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
  }
</script>
<script>
  function confirmation_letter() {
    var id = $('#employee_id').val();
    if (id == '') {
      alert('Please select employee');
      return false;
    }
    window.open("<?= base_url() ?>admin/reports/confirmation_letter/" + id, '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
  }
</script>
<script>
  function appointment_letter() {
    var id = $('#employee_id').val();
    if (id == '') {
      alert('Please select employee');
      return false;
    }
    window.open("<?= base_url() ?>admin/reports/appointment_letter/" + id, '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
  }
</script>

<script>
  function increment_letter() {
    var id = $('#employee_id').val();
    if (id == '') {
      alert('Please select employee');
      return false;
    }

    var inc_id = $('#inc_id').val();
    if (inc_id == '') {
      alert('Please select increment');
      return false;
    }
    window.open("<?= base_url() ?>admin/reports/increment_letter/" + id + "/" + inc_id, '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
  }
</script>

<script>
  function promotion_letter() {
    var id = $('#employee_id').val();
    if (id == '') {
      alert('Please select employee');
      return false;
    }

    var pro_id = $('#pro_id').val();
    if (pro_id == '') {
      alert('Please select promotion');
      return false;
    }
    window.open("<?= base_url() ?>admin/reports/promotion_letter/" + id + "/" + pro_id, '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
  }
</script>





<!-- a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
        a.document.write(resp); -->