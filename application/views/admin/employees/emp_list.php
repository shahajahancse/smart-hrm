<?php /* Leave Application view */ ?> 
<?php $session = $this->session->userdata('username');

$error = $this->session->flashdata('error');
$success = $this->session->flashdata('success');
?> 
<?php 
      $user = $this->Xin_model->read_employee_info($session['user_id']);
      $user_info = $this->Xin_model->read_user_info($session['user_id']);
      $get_animate = $this->Xin_model->get_content_animate();
      $role_resources_ids = $this->Xin_model->user_role_resource();
      // dd($user);
?> 


<div class="box <?php echo $get_animate;?>">
  <div class="box-header with-border">
    <h3 class="box-title"> Employee List </h3> 
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="xin_table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Contact Number</th>
            <th>Email</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
	console.log('hello');
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"employees/emp_list_read/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
});
</script>











