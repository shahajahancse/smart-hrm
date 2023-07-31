
<?php 
// dd($results);
$session = $this->session->userdata('username');
$eid = $this->uri->segment(4);
$get_animate = $this->Xin_model->get_content_animate();
$role_resources_ids = $this->Xin_model->user_role_resource(); 
?>

<?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success" style="width: 250px;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
      <?php echo $this->session->flashdata('success');?>
    </div>
<?php endif; ?> 


<style>
  .dropup .dropdown-menu{
    top: 20px;
    bottom: inherit;
    right: 15px !important;
    left: auto !important;
    min-width: 100px !important;
  }

</style>


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title">Desk list</h3>
    <a class="btn btn-sm btn-info modalbuttons" style="float:right" href="#" type="button" data-toggle="modal" data-target="#myModals">Add Desk</a>
  </div>

  <div class="card <?php echo $get_animate?>">
    <div class="card-body">
      <table class="datatables-demo table table-striped table-bordered" id="myTables">
        <thead>
          <tr>
            <!-- <th  style="width:60px;" class="text-center">Sl.</th> -->
            <th  style="width:60px;" class="text-center">Sl. No.</th>
            <th  style="width:60px;" class="text-center">Employee Name</th>
            <th  style="width:60px;" class="text-center">Desk No.</th>
            <th  style="width:60px;" class="text-center">Floor</th>
            <th  style="width:60px;" class="text-center">Status</th>
            <th  style="width:60px;" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
            
        </tbody>
      </table>
    </div>
  </div>

</div>


<!-- The Modal -->
<div class="modal fade" id="myModals" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="myForm" enctype="multipart/form-data" autocomplete="off" class="add form-hrm">
        <!-- <input type="hidden" value=""> -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Desk</h4>
        </div>
        <div class="modal-body">
          <!-- Input fields in the modal body -->
          <div class="form-group" id="desk_noo">
            <label for="desk_no">Desk No:</label>
            <input type="text" class="form-control" id="desk_no" name="desk_no" placeholder="Enter desk no.">
            <input type="hidden" id="recordId" name="recordId" value="">
          </div>

          <div class="form-group">
            <label for="user_id">Status</label>
            <select class="form-control" id="status" name="status">
              <option value="">Select</option>
              <option value="1">Used</option>
              <option value="0">Not Used</option>
              <option value="2">External Used</option>
            </select>
          </div>

          <div class="form-group">
            <label for="user_id">Select Floor</label>
            <select class="form-control" id="floor" name="floor">
              <option value="">Select</option>
              <option value="3">3rd Floor</option>
              <option value="5">5th Floor</option>
            </select>
          </div>

          <div class="form-group">
            <label for="user_id">Select User Name</label>
            <select class="form-control" id="user_id" name="user_id">
              <option value="">Select</option>
              <?php 
                $rows = $this->db->select('user_id, first_name, last_name')->where_in('status', [1, 4, 5])->where('floor_status',null)->get('xin_employees')->result();
                foreach ($rows as $row) {
              ?>
              <option value="<?= $row->user_id ?>"><?= $row->first_name.' '.$row->last_name ?></option>
              <?php }?>
            </select>
          </div>
          <div id="description" style="display:none">
            <textarea name="description"  cols="82" rows="3"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm" id="saveButton">Save</button>
          <button type="submit" class="btn btn-primary btn-sm" id="updateButton" style="display:none">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  loadTableData();
  
$('#user_id').change(function() {
  var selectedUserId = $(this).val();
  $('#hidden_user_id').val(selectedUserId);
});

$("#myForm").submit(function(event) {
  event.preventDefault();
  var formData = $(this).serialize();
  var recordId = $('#recordId').val();
  if (recordId === '') {
    var url = "<?php echo base_url('admin/accessories/add_desk')?>";
  } else {
    var url = "<?php echo base_url('admin/accessories/update_desk')?>";
  }

  $.ajax({
    type: "POST",
    url: url,
    data: formData,
    success: function(response) {
      if (recordId === '') {
        alert('Added Successfully');
      } else {
        alert('Updated Successfully');
      }
      $('#myModals').modal('hide');
      loadTableData();
    },
    error: function(xhr, status, error) {
      alert("Error submitting the form. Please try again.");
    }
  });
});

function loadTableData() {
    $.ajax({
      url: '<?php echo base_url('admin/accessories/get_desk_list')?>', // Replace with your server-side endpoint URL
      type: 'GET',
      dataType: 'json',
      success: function(data) {
      var tableHtml = '';
      var serialCounter = 1;
      $.each(data, function(index, row) {
        var firstName = row.first_name ? row.first_name : '..';
        var lastName  = row.last_name ? row.last_name : '...';
        var floor     = row.floor == 3 ? '3rd Floor' : '5th Floor';
        var id        = row.id;

        var statusIconHtml = getStatusIcon(row.status);
        // var editButtonHtml = '<a href="#" class="btn btn-sm btn-info" >Edit</a>';

        tableHtml += '<tr>';
        tableHtml += '<td class="text-center">' + serialCounter + '</td>';
        tableHtml += '<td class="text-center">' + firstName + ' ' + lastName + '</td>';
        tableHtml += '<td class="text-center">' + row.desk_no + '</td>';
        tableHtml += '<td class="text-center">' + floor + '</td>';
        tableHtml += '<td class="text-center using">' + statusIconHtml + '</td>';
        tableHtml += '<td class="text-center"><button class="btn btn-sm btn-info editButton" data-record-id="' + id + '">Edit</button></td>';
        tableHtml += '</tr>';
        serialCounter++;
      });
      $('#myTables tbody').html(tableHtml);
      $('#myTables').DataTable();

      },
      error: function(xhr, status, error) {
        console.log('Error fetching table data:', error);
      }
    });
  }

  function getStatusIcon(status) {
    if (status == 1) {
      return '<span style="padding: 4.5px 14.3px 5.5px 9px; border-radius: 50px;border: 1px solid #CCC;background: #FFF;"> <b> <i class=" fa fa-dot-circle-o" style="color:green"></i> Using</b></span>';
    } else {
      return '<span style="padding: 4.5px 14.3px 5.5px 9px; border-radius: 50px;border: 1px solid #CCC;background: #FFF;"> <b> <i class=" fa fa-dot-circle-o" style="color:red"></i> Not Using</b></span>';
    }
  }
  
  $('.modalbuttons').on('click', function () {
      $('#myForm')[0].reset();
  });
});

$(document).on('click', '.editButton', function() {
  var recordId = $(this).attr('data-record-id');
  $('#recordId').val(recordId); // Set the recordId in the form
  fetchRowData(recordId);
});

function fetchRowData(recordId) {
  $.ajax({
    url: '<?php echo base_url('admin/accessories/get_single_desk')?>', // Replace with your server-side endpoint URL to get single record data
    type: 'GET',
    data: { recordId: recordId },
    dataType: 'json',
    success: function(data) {
      // Populate the modal form with data
      $('#desk_no').val(data.desk_no);
      $('#status').val(data.status);
      $('#floor').val(data.floor);
      $('#user_id').val(data.user_id);
      // Show the modal
      $('#myModals').modal('show');
      // alert(recordId);
      if (recordId === '') {
        $("#saveButton").show();
        $("#updateButton").hide();
      } else {
        $("#saveButton").hide();
        $("#updateButton").show();
      }
        
    },
    error: function(xhr, status, error) {
      console.log('Error fetching row data:', error);
    }
  });
}

$(".modalbuttons").click(function() {
  $("#updateButton").hide();
  $("#saveButton").show();
  $('#recordId').val(''); // Clear the recordId when the modal is opened for adding new data
}); 

</script>