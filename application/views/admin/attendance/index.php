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
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="process_date"><?php echo $this->lang->line('xin_e_details_date');?></label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date" name="process_date" type="text" value="<?php echo date('Y-m-d');?>" required>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="upload_file">status</label>
              <select class="form-control" name="status" id="status">
                <option value="">Select one</option>
                <option value="1">regular</option>
                <option value="2">left</option>
                <option value="3">resign</option>
              </select>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group"> &nbsp;
              <label for="first_name">&nbsp;</label><br />
              <button class="btn btn-success" onclick="attn_process()">Process</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="loader"  align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;"><img src="<?php echo base_url();?>/uploads/ajax-loader.gif" /></div>

<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"><?php echo $this->lang->line('xin_daily_attendance_report');?></h3>
  </div>
  <div class="box-body">
    <table>
      <tr>
        <td id="daily_present"><button class="btn btn-primary">Daily Present</button></td>
        <td></td>
        <td></td>
      </tr>
    </table>
  </div>
</div>

 
<script>

    // attendance process
    function attn_process()
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();


      process_date = document.getElementById('process_date').value;
      
      if(process_date =='')
      {
        alert('Please select process date');
        return ;
      }

      status = document.getElementById('status').value;
      
      if(status =='')
      {
        alert('Please select status');
        return ;
      }
 
      var okyes;
      okyes=confirm('Are you sure you want to start process?');
      if(okyes==false) return;

      $("#loader").show();
      

      url = "<?php echo base_url() ?>admin/attendance/attendance_process/"+process_date+"/"+status;
      ajaxRequest.open("GET", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send();

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          $("#loader").hide();
          alert(resp);
        }
      }
    }



</script>
