
<?php 
$session = $this->session->userdata('username');
$get_animate = $this->Xin_model->get_content_animate();
$role_resources_ids = $this->Xin_model->user_role_resource(); 
?>

<div class="box <?php echo $get_animate;?>">
<div class="col-lg-12">

<div id="loader" align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;"><img src="http://localhost/smart-hrm//uploads/ajax-loader.gif"></div>

<div class="box animated fadeInRight">
  <div class="box-header with-border" id="report_title">
    <h3 class="box-title" id="report">Report</h3>
</div>
  <div class="box-body" id="emp_report">
    <div class="tab-content" id="">
          <div class="col-md-3">
            <div class="form-group">
              <label for="process_date">First Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="first_date" name="first_date" type="text" value="<?php echo date('Y-m-d');?>">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="process_date">Second Date</label>
              <input class="form-control attendance_date" placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="second_date" name="second_date" type="text" autocomplete="off">
            </div>
          </div>
            <div class="col-md-3"  >
              <label for="Status">Select Status</label>
              <select class="form-control" id='status'>  
                <option value="" disabled selected>Select Status</option>
                <option value="1" >On Working</option>
                <option value="2" >Store</option>
                <option value="3" >Servicing</option>
                <option value="4" >Destroy</option>
              </select>
            </div>
            <div class="col-md-3"  >
              <label for="Status">Select Category</label>
              <select class="form-control" id='category'>  
                <option value="" disabled selected>Select Category</option>
            <?php $category = $this->db->select('*')->get('product_accessory_categories')->result(); foreach($category as $row){?>
                <option value="<?= $row->id?>" ><?= $row->cat_name?></option>
            <?php }?>
              </select>
            </div> 
            <button class="btn btn-info"  style="float:right;margin-right:15px;margin-top:20px" onclick="inventory_report()">Report</button>
          </div>
        </div>
</div>
</div>

</div>

 
<script>

$(document).ready(function() {
$('process_date').datepicker();

  $('#example').DataTable();
});



function inventory_report(status)
{
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest     = new XMLHttpRequest();
  var first_date  = $('#first_date').val();
  var second_date = $('#second_date').val();

  var status      = $('#status').val();
  var category    = $('#category').val();

  if(status==null){
    alert('Please select status');return;
  }
  if(category==null){
    alert('Please select categroy');return;
  }


  // var statuss = $('#status').find(":selected").text();  
  // var servicing = statuss.search(/servicing/i); 
  // var destroy = statuss.search(/destroy/i); 
  // if(servicing !== -1 || destroy!=-1){
  //   if(first_date ==null || second_date ==null){
  //      alert('Please select first date and second date');
  //   }else{ alert('ok')}
  // }

    
      // console.log(data); return;
      var data = "status="+status+'&category='+category;
      url = base_url + "/inventory_report";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1400,height=800');
          a.document.write(resp);
        }
      }
    }

    

</script>
