<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="process_date">First Date</label>
                    <input class="form-control attendance_date"
                        placeholder="<?php echo $this->lang->line('xin_select_date');?>" id="process_date"
                        name="process_date" type="text" value="<?php echo date('Y-m-d');?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="process_date">Second Date</label>
                    <input class="form-control attendance_date" placeholder="Second Date" id="second_date"
                        name="second_date" type="text" autocomplete="off">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="upload_file">Status</label>
                    <select class="form-control select22" name="status" id="status" onchange="get_user()">
                        <option value="0" selected>Active</option>
                        <option value="1">Inactive</option>
                        <option value="All">All</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="upload_file">Floor</label>
                    <select class="form-control select22" name="floor" id="floor" onchange="get_user()">
                        <option value="" selected>All</option>
                        <option value="3">3rd Floor</option>
                        <option value="5">5th Floor</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Department</label>
                    <select class="form-control select22" name="department" id="department" onchange="get_user()">
                        <option value="" selected>All</option>
                        <?php
                        $all_department =$this->db->query("SELECT * from xin_departments")->result();
                        foreach ($all_department as $key => $value) { ?>
                        <option value="<?= $value->department_id ?>"><?= $value->department_name ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Designation</label>
                    <select class="form-control select22" name="designation" id="designation" onchange="get_user()">
                        <option value="" selected>All</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        get_user();
        $("#department").change(function () {
            var department_id = $(this).val();
            $("#designation").empty();
            if (department_id == "") {
                return false;
            }
            $.ajax({
                url: "<?php echo site_url("admin/reports/get_designations") ?>",
                type: "POST",
                data: {
                    department_id: department_id
                },
                success: function (data) {
                    $("#designation").append('<option value="" selected>All</option>');
                    data=JSON.parse(data);
                    for (var i = 0; i < data.length; i++) {
                        $("#designation").append('<option value="' + data[i].designation_id + '">' + data[i].designation_name + '</option>');
                    }
                },
                error: function () {
                    alert("Error");
                },
                complete: function () {
                    $("#designation").select2();
                } 
            });
        });
    });
</script>

<script>
    function get_user(){
        $('.removeTr').remove();
        $("#fileDiv").html('<tr class="removeTr"><td colspan="3">Loading...</td></tr>');

        var status = document.getElementById('status').value;
        var floor = document.getElementById('floor').value;
        var department = document.getElementById('department').value;
        var designation = document.getElementById('designation').value;



        var url = "<?php echo base_url('admin/reports/get_employeess_v2'); ?>";
        $.ajax({
        url: url,
        type: 'GET',
        data: { 
            "status": status,
            "floor": floor,
            "department": department,
            "designation": designation
        },
        contentType: "application/json",
        dataType: "json",
        success: function (response) {
          arr = response.employees;
          if (arr.length != 0) {
            var i = 1;
            var items = '';
            $.each(arr, function (index, value) {
              items += '<tr class="removeTr">';
              items += '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' + value.emp_id + '" ></td>';
              items += '<td class="success">' + (i++) + '</td>';
              items += '<td class="warning ">' + value.first_name + ' ' + value.last_name + " (" +value.emp_id + ")" + '</td>';
              items += '</tr>';
            });
            $('.removeTr').remove();
            $('#fileDiv').html(items);
          }else{
            $('.removeTr').remove();
            $('#fileDiv').html('<tr class="removeTr"><td colspan="3">No Employee Found</td></tr>');
          }
        }
      });

    }



    $("#status").change(function () {
      status = document.getElementById('status').value;
      var url = "<?php echo base_url('admin/reports/get_employeess'); ?>";
      $("#select_all").prop("checked", false);
      $('#fileDiv .removeTr').remove();

      $.ajax({
        url: url,
        type: 'GET',
        data: { "status": status },
        contentType: "application/json",
        dataType: "json",
        success: function (response) {
          arr = response.employees;
          if (arr.length != 0) {
            var i = 1;
            var items = '';
            $.each(arr, function (index, value) {
              items += '<tr class="removeTr">';
              items += '<td><input type="checkbox" class="checkbox" id="select_emp_id" name="select_emp_id[]" value="' + value.emp_id + '" ></td>';
              items += '<td class="success">' + (i++) + '</td>';
              items += '<td class="warning ">' + value.first_name + ' ' + value.last_name + " (" +value.emp_id + ")" + '</td>';
              items += '</tr>';
            });
            // Append the new rows
            $('#fileDiv tr:last').after(items);
          }
        }
      });
    });






</script>



