<?php
/* Attendance view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('id' => 'attn_file_upload', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/timesheet/attendance_process', $attributes, $hidden);?>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="upload_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
                <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="upload_date" name="upload_date" type="text" value="<?php echo date('Y-m-d');?>" required>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="upload_file">upload file</label>
                <input class="form-control" required placeholder="upload file"  id="upload_file" name="upload_file" type="file">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group"> &nbsp;
                <label for="first_name">&nbsp;</label><br />
                <input type="submit" name="submit" class="btn btn-primary" value="Insert"/>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

<div id="loader"  align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;"><img src="<?php echo base_url();?>/uploads/ajax-loader.gif" /></div>

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('xin_daily_attendance_report');?></h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead>
          <tr>
            <th style="width:120px;">No.</th>
            <th style="width:100px;">Upload</th>
            <th style="width:100px;">file Name</th>
            <th style="width:100px;">Status</th>
            <th style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($files as $key => $row) { ?>
            <tr>
              <td><?php echo $key + 1; ?></td>
              <td><?php echo $row->upload_date; ?></td>
              <td><a href="<?php echo base_url('attn_data/'.$row->upload_file); ?>"><?php echo $row->upload_file; ?></a></td>
              <td><?php echo ($row->status == 1)? "active":"Inactive"; ?></td>
              <td><a href="<?php echo base_url('admin/timesheet/delete_attn_file/'.$row->id); ?>" class="btn btn-danger btn-sm">Delete</a></td>
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
