<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="box mb-4 <?php echo $get_animate;?>">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <?php $attributes = array('id' => 'unit_insert', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/employees/set_leads', $attributes, $hidden);?>
          <div class="row">

            <div class="col-md-3">
              <label for="Status">Select Team Laad</label>
              <select name="lead_user_ids" class="form-control select2" data-plugin="select_hrm" id="mySelect" required  >  
                    <option>Select Team Lead</option>
                    <?php foreach($leads as $row){?>
                    <option value="<?php echo $row->user_id?>"><?php echo $row->first_name.' '. $row->last_name?></option>
                    <?php }?>
              </select>
                 <input type="hidden" name="is_emp_lead" value="2">
                <input type="hidden" name="lead_user_id" value="0">
            </div>

            <div class="col-md-2">
              <label ></label>
              <div class="form-group" style="margin-top:5px">
                <input type="submit" name="submit" class="btn btn-success" style="float:right" value="Add Team Leader"/>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>

<?php echo validation_errors(); ?>
<?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success" style="width: 250px;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo $this->session->flashdata('success');?>
    </div>
<?php endif; ?> 

<?php if($this->session->flashdata('warning')):?>
    <div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo $this->session->flashdata('warning');?>
    </div>
<?php endif; ?> 


<div class="box <?php echo $get_animate;?>">
    
  <div class="box-header with-border">
    <h3 class="box-title">Team Leader List</h3>
  </div>
  <div class="box-body">
    <div class="box-datatable table-responsive">
      <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead class="text-center">
          <tr>
            <th class="text-center" style="width:20px;">No.</th>
            <th class="text-center" style="width:100px;">Team Lead Name</th>
            <th class="text-center" style="width:100px;">Team Name</th>
            <th class="text-center" style="width:100px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $results = $this->db->select('xin_employees.user_id, xin_employees.first_name, xin_employees.last_name, xin_departments.department_name')
                            ->from('xin_employees')
                            ->join('xin_departments', 'xin_employees.department_id = xin_departments.department_id')
                            ->where('is_emp_lead',2)
                            ->where('lead_user_id',0)
                            ->get()
                            ->result();

                            // dd($results);
            $i= 1 ; 
            foreach ($results as $key => $row) { ?>
            <tr class="text-center">
                <td><?php echo $i++?></td>
                <td><?php echo $row->first_name.' '.$row->last_name?></td>
                <td><?php echo $row->department_name?></td>
                
                <td>    
                    <a href="<?php echo base_url('admin/employees/delete_leader/'.$row->user_id)?>" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

 
<script>

  $(document).ready(function() {
    $('#mySelect').select2();
    $('#example').DataTable();
  });
</script>  