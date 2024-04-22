
<?php 
$session = $this->session->userdata('username');
$user_id=$session['user_id'];
$employee_ids = $this->db->select('user_id')
                        ->from('xin_employees')
                        ->where('lead_user_id', $user_id)
                        ->get()
                        ->result_array();
$employee_ids = array_column($employee_ids, 'user_id');


$this->db->select('xin_projects_timelogs.*, xin_employees.first_name, xin_employees.last_name, xin_projects.title');
$this->db->from('xin_projects_timelogs');
$this->db->join('xin_employees', 'xin_projects_timelogs.employee_id = xin_employees.user_id');
$this->db->join('xin_projects', 'xin_projects_timelogs.project_id = xin_projects.project_id');
$this->db->where_in('xin_projects_timelogs.employee_id', $employee_ids);
$this->db->order_by('xin_projects_timelogs.timelogs_id', 'DESC');
$log_data=$this->db->get()->result();
// dd($log_data);

// (
//   [timelogs_id] => 4
//   [project_id] => 2
//   [company_id] => 1
//   [employee_id] => 62
//   [movement] => YES
//   [start_time] => 01:15
//   [end_time] => 01:20
//   [start_date] => 2024-04-22
//   [end_date] => 2024-04-22
//   [total_hours] => 0:5
//   [timelogs_memo] => sdfsdf
//   [status] => 0
//   [created_at] => 2024-04-22 01:16:41
//   [first_name] => Raihan Mahmud
//   [last_name] => Himel
//   [title] => test
// )


?>


<div class="col-md-12">
    <div class="box box-block bg-white" style="padding: 17px;">

        <div class="table-responsive">

          <table class="table table-hover table-striped" id="logs_table">
            <thead>
              <tr>
                <th>Sl</th>
                <th>Employee Name</th>
                <th>Project Name</th>
                <th>Date</th>
                <th>Total Hours</th>
                <th>Details</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

              <?php $i=1; foreach($log_data as $log) { ?>
              <tr>
                <td><?= $i ?></td>
                <td><?= $log->first_name.' '.$log->last_name ?></td>
                <td><?= $log->title ?></td>
                <td><?= $log->start_date ?></td>
                <td><?= $log->total_hours ?></td>
                <td><?= $log->timelogs_memo ?></td>
                <td>
                  <?php if($log->status==0) { ?>
                  <span class="label label-warning">Pending</span>
                  <?php } else if($log->status==1) { ?>
                  <span class="label label-success">Approved</span>
                  <?php } else if($log->status==2) { ?>
                  <span class="label label-danger">Rejected</span>
                  <?php } ?>
                </td>
                <td>
                  <?php if ($log->status==0) {?>
                    <a class="btn btn-xs btn-success" href="<?= site_url('admin/project/approve_timelogs/'.$log->timelogs_id) ?>"><i class="fa fa-check"></i> Approve</a>
                    <a class="btn btn-xs btn-danger" href="<?= site_url('admin/project/reject_timelogs/'.$log->timelogs_id) ?>"><i class="fa fa-times"></i> Reject</a>
                  <?php } else {?>
                  <?php }?>
                  
                </td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
    </div>
</div>
<script>
  $(document).ready(function() {
    $('#logs_table').DataTable();
  });
</script>