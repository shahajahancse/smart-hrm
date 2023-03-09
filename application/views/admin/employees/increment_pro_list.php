<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Increment List</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead>
          <tr>
            <th style="width:120px;">No.</th>
            <th style="width:100px;">Name</th>
            <th style="width:100px;">Department</th>
            <th style="width:100px;">Designation</th>
            <th style="width:100px;">DOJ</th>
            <th style="width:100px;">Old Salary</th>
            <th style="width:100px;">New Salary</th>
            <th style="width:100px;">G.Letter</th>
            <th style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $key => $row) { ?>
            <tr>
              <td><?php echo $key + 1; ?></td>
              <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
              <td><?php echo $row->department_name; ?></td>
              <td><?php echo $row->designation_name; ?></td>
              <td><?php echo $row->date_of_joining; ?></td>
              <td><?php echo $row->old_salary; ?></td>
              <td><?php echo $row->new_salary; ?></td>
              <td><?php echo $row->letter_status == 1 ? "Yes":"No"; ?></td>
              <td><a href="<?php //echo base_url('admin/employees/pip_letter_pdf/'.$row->id); ?>" class="btn btn-info btn-sm">Print PDF</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

 
<script>

  $(document).ready(function() {
    // file upload
    $("#attn_file_upload").on('submit', function(e) {
      var url = "<?php echo base_url('admin/timesheet/attn_file_upload'); ?>";
      e.preventDefault();

      var okyes;
      okyes=confirm('Are you sure you want to upload file?');
      if(okyes==false) return;

      $.ajax({
          url: url,
          type: 'POST',
          dataType: "json",
          data: new FormData(this),
          processData: false,
          contentType: false,
          cache : false,


          success: function(response){

            if(response.status == 'success') {
              alert(response.message)
            } else {
              alert(response.message)
            }
          },
          error: function(response) { 
            alert(response.message)
          }
      });
      return false;
    });


    $('#example').DataTable();


  });

</script>
