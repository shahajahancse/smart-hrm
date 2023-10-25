
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Inventory Report</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-7">
                <div class="form-group">
                  <label for="upload_file">Select</label>
                  <select class="form-control" name="status" id="status">
                    <option value="">Select one</option>
                    <option value="11">All Report</option>
                    <option value="12">Category Wise Report</option>
                    <!-- <option value="13">Sub Category Wise Report</option> -->
                    <option value="14">Induvisual Item Report</option>
                    <optgroup label="Device Movement Report">
                        <option value="15">Daily</option>
                        <option value="16">Weekly</option>
                        <option value="17">Monthly</option>
                    </optgroup>
                    <option value="18">Employee Using Device</option>
                    <option value="19">Stock/Stored Device Report</option>
                    <option value="20">Stock/Stored Item Report</option>
                    <option value="21">Damage Device Report</option>
                    <option value="22">Damage Item Report</option>
                  </select>
                </div>
              </div>
              <div class="col-md-5" id="div_category_id">
                <div class="form-group">
                  <label for="upload_file">Select Category</label>
                  <select class="form-control" name="category" id="category_id">
                    <option value="">Select one</option>
                    <?php
                      $categories =$this->db->select('id,cat_name')->get('product_accessory_categories')->result(); 
                      foreach($categories as $category){
                    ?>
                    <option value="<?php echo $category->id?>"><?php echo $category->cat_name?></option>
                    <?php }?>
                  </select>
                </div>
              </div>
              
              <div class="col-md-5" id="div_sub_category_id">
                  <div class="form-group">
                    <label for="upload_file">Select Sub Category</label>
                    <select class="form-control" name="sub_category" id="sub_category_id">
                     <option value="">Select one</option>
                    <?php
                      $sub_categories =$this->db->select('id,sub_cate_name')->get('products_sub_categories')->result(); 
                      foreach($sub_categories as $sub_category){
                    ?>
                    <option value="<?php echo $sub_category->id ?>"><?php echo $sub_category->sub_cate_name ?></option>
                    <?php }?>
                    </select>
                  </div>
              </div>
            </div>
              <!-- <div class="form-group"> -->
                <button class="btn btn-success" onclick="show_report()">Show Report</button>
              <!-- </div> -->
          </div>
        </div>
      </div>
      
    </div>


  </div>
  <div class="col-lg-4">
    <div class="box" style="height: 74vh;overflow-y: scroll;">
      <table class="table table-striped table-hover" id="fileDiv">
        <tr style="position: sticky;top: 0;z-index:1">
            <th class="active" style="width:10%"><input type="checkbox" id="select_all" class="select-all checkbox" name="select-all" /></th>
            <th class="" style="width:10%;background:#0177bcc2;color:white">Id</th>
            <th class=" text-center" style="background:#0177bc;color:white">Name</th>
        </tr>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>skin/hrsale_assets/js/hrm.js"></script>
<script>
    $(document).ready(function(){
        $("#select_all").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
        });
        // on load employee
        $("#status").change(function () {
            status = document.getElementById('status').value;
            var url = "<?php echo base_url('admin/reports/get_employeess'); ?>";
            $("#select_all").prop("checked", false);
            $('#fileDiv #removeTr').remove();
            $.ajax({
                url: url,
                type: 'GET',
                data: { "status": status },
                contentType: "application/json",
                dataType: "json",
                success: function (response) {
                    arr = response.employees;
                    if (arr.length != 0) {
                    var items = '';
                    $.each(arr, function (index, value) {
                        items += '<tr id="removeTr">';
                        items += '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' + value.emp_id + '" ></td>';
                        items += '<td class="success">' + value.emp_id + '</td>';
                        items += '<td class="warning ">' + value.first_name + ' ' + value.last_name + '</td>';
                        items += '</tr>';
                    });
                    $('#fileDiv tr:last').after(items);
                    }
                }
            });
        });
      });
      $('#div_category_id').hide();
      $('#div_sub_category_id').hide();

      $("#status").change(function () {
        status = $('#status').val();
        if(status == 12){
            $('#div_category_id').show(1000);
            $('#div_sub_category_id').hide(1000);
        } else if(status == 13){
          $('#div_category_id').hide(1000);
          $('#div_sub_category_id').show(1000);
        }else{
          $('#div_category_id').hide(1000);
          $('#div_sub_category_id').hide(1000);
        }
      });


    function show_report(){
        var ajaxRequest;  // The variable that makes Ajax possible!
        ajaxRequest = new XMLHttpRequest();
        var status = $('#status').val();
        var category = $('#category_id').val();
        var sub_category = $('#sub_category_id').val();

        $('#status').on('change', function() {
          if ($(this).val() != 12) {
            $('#category_id').val('');
          }
        });

        if(status ==''){
            alert('Please select status');
            return ;
        }
        var checkboxes = document.getElementsByName('select_emp_id[]');
        var sql = get_checked_value(checkboxes);
        if(sql =='' && status == 18){
            alert('Please select employee Id');
            return ;
        }
        var data = "status="+status+"&category="+category+"&sub_category="+sub_category+'&sql='+sql;
        url = base_url + "/show_inventory_report";
        ajaxRequest.open("POST", url, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
        ajaxRequest.send(data);
        ajaxRequest.onreadystatechange = function(){
            if(ajaxRequest.readyState == 4){
            // console.log(ajaxRequest);
            var resp = ajaxRequest.responseText;
            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
            a.document.write(resp);
            }
        }
    }


</script>

    