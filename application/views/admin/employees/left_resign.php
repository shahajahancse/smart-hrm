
<div class="card" style="padding:10px">
  <form>
    <div class="form-group col-md-6">
      <level>Employee Name</label>
      <input disabled class="form-control" id="emp_name" value="<?php echo  $data[0]->first_name.' '.$data[0]->last_name?>">
    </div>
    <div class="form-group col-md-6">
      <level>Department Name</label>
      <input disabled class="form-control" id="department" value="<?php echo  $data[0]->department_name?>">
    </div>
    <div class="form-group col-md-6">
      <level>Designation Name</label>
      <input disabled class="form-control" id="designation" value="<?php echo  $data[0]->designation_name?>">
    </div>
    <div class="form-group col-md-6">
      <level>Joining Date</label>
      <input disabled class="form-control" id="joining_date" value="<?php echo  $data[0]->date_of_joining?>">
    </div>

    <div class="form-group col-md-6">
      <level>Employee Status</label>
      <select class="form-control" id="status">
        <option value="" disabled selected>Select Status</option>
        <option value="1">Left</option>
        <option value="2">Resign</option>
      </select>
    </div>

    <div class="form-group col-md-6">
      <level>Effective Date</label>
      <input type="date" class="form-control" id="effective_date">
    </div>

    <button type="submit" class="btn btn-sm btn-primary pull-right" style="margin-right:16px">Submit</button>
  </form>
</div>


<script>
  $('button').on('click',function(e){
    // alert("ok"); return;
    e.preventDefault();
      var id= <?php echo $id?>; 
      var department_id= <?php echo  $data[0]->department_id?>;
      var designation_id= <?php echo  $data[0]->designation_id?>;
      var joining_date= $('#joining_date').val();
      var status= $('#status').val();
      var effective_date= $('#effective_date').val();

      var url = "<?php echo base_url('admin/employees/left_resign_apply');?>";
      // return false;
        $.ajax({
        url: url,
        type: 'POST',
        data: {
                id:id,
                department_id:department_id,
                designation_id:designation_id,
                joining_date:joining_date,
                status:status,
                effective_date:effective_date,
              },
        success: function(response){
					alert('Data Insert Successfully !');
          window.location.replace("<?php echo base_url('admin/employees')?>");
        }
      });

  });
</script>

