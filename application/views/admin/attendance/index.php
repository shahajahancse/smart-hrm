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
    <h3 class="box-title"> Attendence Report
      <!-- < ?php echo $this->lang->line('xin_daily_attendance_report');?> -->
   </h3>
  </div>
  <div class="box-body">
      <ul class="nav nav-tabs " id="myTab" role="tablist">
      <li class="nav-item active">
        <a class="nav-link " id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Daily</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Monthly</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="continuously-tab" data-toggle="tab" href="#continuously" role="tab" aria-controls="continuously" aria-selected="false">Continuously</a>
      </li>
    </ul>
    
    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade active in" id="daily" role="tabpanel" aria-labelledby="daily-tab" style="margin-top: 30px;">
          <button class="btn btn-sm btn-danger"> Button one</button>
          <button class="btn btn-sm btn-danger"> Button two</button>
          <button class="btn btn-sm btn-danger"> Button three</button>
          <button class="btn btn-sm btn-danger"> Button four</button>
          <button class="btn btn-sm btn-danger"> Button five</button>
          <button class="btn btn-sm btn-danger"> Button six</button>
          <button class="btn btn-sm btn-danger"> Button seven</button>
          <button class="btn btn-sm btn-danger"> Button eight</button>
      </div>

      <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab" style="margin-top: 30px;">
        <button class="btn btn-sm btn-danger"> Button one</button>
        <button class="btn btn-sm btn-danger"> Button two</button>
        <button class="btn btn-sm btn-danger"> Button three</button>
        <button class="btn btn-sm btn-danger"> Button four</button>
        <button class="btn btn-sm btn-danger"> Button five</button>
        <button class="btn btn-sm btn-danger"> Button six</button>
        <button class="btn btn-sm btn-danger"> Button seven</button>
        <button class="btn btn-sm btn-danger"> Button eight</button>
      </div>

      <div class="tab-pane fade" id="continuously" role="tabpanel" aria-labelledby="continuously-tab" style="margin-top: 30px;">
        <button class="btn btn-sm btn-info"> Button one</button>
        <button class="btn btn-sm btn-info"> Button two</button>
        <button class="btn btn-sm btn-info"> Button three</button>
        <button class="btn btn-sm btn-info"> Button four</button>
        <button class="btn btn-sm btn-info"> Button five</button>
        <button class="btn btn-sm btn-info"> Button six</button>
        <button class="btn btn-sm btn-info"> Button seven</button>
        <button class="btn btn-sm btn-info"> Button eight</button>
      </div>

    </div>
  </div>



</div>
</div>

<div class="col-lg-4">
<div class="box" style="height: 74vh;overflow-y: scroll;">
<table class="table table-striped">
    <tr>
        <th class="active" style="width:10%">
            <input type="checkbox" class="select-all checkbox" name="select-all" />
        </th>
        <th class="success" style="width:10%">Id</th>
        <th class="warning text-center">Name</th>
       
    </tr>
    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">01</td>
        <td class="warning text-center">Md. Mafizur Rahman </td>
       
    </tr>

    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">02</td>
        <td class="warning text-center">Md. Imdadul Haque</td>
       
    </tr>

    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">03</td>
        <td class="warning text-center">Md Juel Ali</td>
       
    </tr>

    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">04</td>
        <td class="warning text-center">Md manjur Morshed</td>
       
    </tr>

    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">05</td>
        <td class="warning text-center">Md Shahajahan Ali</td>
       
    </tr>

    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">06</td>
        <td class="warning text-center">Khalid Bin Walid</td>
       
    </tr>

    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">07</td>
        <td class="warning text-center">Md Shakil Hossain</td>
       
    </tr>

    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">08</td>
        <td class="warning text-center">Md Tahid</td>
       
    </tr>

    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">09</td>
        <td class="warning text-center">Md Mijanur Rahman</td>
       
    </tr>

    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>
    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>    <tr>
        <td class="active">
            <input type="checkbox" class="select-item checkbox" 	
            name="select-item" value="1000" />
        </td>
        <td class="success">10</td>
        <td class="warning text-center">Md Khorshed Alom</td>
       
    </tr>


 
</table>
</div>
</div>
<script>
    $(function(){

        //button select all or cancel
        $("#select-all").click(function () {
            var all = $("input.select-all")[0];
            all.checked = !all.checked
            var checked = all.checked;
            $("input.select-item").each(function (index,item) {
                item.checked = checked;
            });
        });




        //column checkbox select all or cancel
        $("input.select-all").click(function () {
            var checked = this.checked;
            $("input.select-item").each(function (index,item) {
                item.checked = checked;
            });
        });


    });
</script>
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
