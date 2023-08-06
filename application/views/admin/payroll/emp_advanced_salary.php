<!-- < ?php dd( $results)?> -->
<style>
    .using {
    display: inline-flex;
    padding: 4.5px 14.3px 5.5px 9px;
    align-items: center;
    gap: 9px;
    border-radius: 50px;
    border: 1px solid #CCC;
    background: #FFF;
}
</style>
<div class="box mb-4 animated fadeInRight">
  <div id="accordion">
    <div class="box-header  with-border">
      <h3 class="box-title">Advanced Salary </h3>
        <div class="box-tools pull-right"> 
            <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
                <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span>Add New</button>
            </a>
        </div>
    </div>
    <div id="add_form" class="add-form animated fadeInRight collapse" data-parent="#accordion" style="height: 0px;" aria-expanded="false">
      <div class="box-body">
        <?php $attributes = array('id' => 'unit_insert', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
        <?php $hidden = array('user_id' => $session['user_id'],'user_id' => $session['user_id']);?>
        <?php echo form_open_multipart('admin/payroll/advanced_salary_add', $attributes, $hidden);?>
        <div class="row">
            <div class="form-group col-md-2">
                <label for="formGroupExampleInput">Amount</label>
                <input type="text" class="form-control form-control-sm" id="formGroupExampleInput" name="requested_amonut"placeholder="Set Amount" required>
            </div>
            <div class="form-group col-md-2">
                <label for="formGroupExampleInput2">Effective Month</label>
                <input class="form-control attendance_date" placeholder="Select Date" id="e_m_date" name="effective_month" type="text" autocomplete="off" required>
            </div>
            <div class="form-group col-md-8">
                <label for="formGroupExampleInput2">Reason</label>
                <input type="text" class="form-control form-control-sm" id="formGroupExampleInput2" name="reason" placeholder="Enter reason" required>
            </div>
        </div>
        <button type="submit" class="btn btn-sm btn-success" name="btn_advanced" style="float:right">Submit</button>
    <?php echo form_close(); ?>
        
      </div>
    </div>

  </div>
</div>


<?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success" style="width:230px;padding: 10px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
        <?php echo $this->session->flashdata('success');?>
    </div>
<?php endif; ?> 

<?php if($this->session->flashdata('delete')):?>
    <div class="alert alert-danger" style="width:230px;padding: 10px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
        <?php echo $this->session->flashdata('delete');?>
    </div>
<?php endif; ?> 

<div class="card">
    <div class="card-body">
        <p class="h4">Requested List</p>
        <table class="table table-striped table-bordered" id="table_id">
            <thead>
                <tr>
                <th scope="col" class="text-center">Sl. No.</th>
                <!-- <th scope="col" class="text-center">Name</th>
                <th scope="col" class="text-center">Dept</th>
                <th scope="col" class="text-center">Desig</th> -->
                <th scope="col" class="text-center">Req. Amount</th>
                <th scope="col" class="text-center">App. Amount</th>
                <th scope="col" class="text-center">Effective Month</th>
                <th scope="col" class="text-center">Reason</th>
                <th scope="col" class="text-center">Status</th>
                <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($results as $row){ ?>
                    <tr class="text-center">
                        <td><?php echo $i++?></td>
                        <!-- <td><?= $row->first_name.' '.$row->last_name?></td>
                        <td><?= $row->department_name?></td>
                        <td><?= $row->designation_name?></td> -->
                        <td><?= $row->requested_amonut?></td>
                        <td><?= $row->approved_amount?></td>
                        <td><?= date("d M Y",strtotime($row->effective_month))?></td>
                        <td><?= $row->reason?></td>
                        <td>            
                            <span class="using">
                                <?php echo $row->status==1 ? "<i class='fa fa-dot-circle-o' style='color:#cd9a0f'></i> Pending":"<i class='fa fa-dot-circle-o' style='color:green'></i> Accepted";?>
                            </span>
                        </td>
                        <td>
                            <a href="" class="btn btn-sm btn-info">Edit</a>
                            <a href="<?php echo base_url('admin/payroll/delete_list/'.$row->id)?>" onclick="return confirm('Are you sure to delete')" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>




<script>
    $(document).ready(function(){
        $('#table_id').DataTable();
        // $("#e_m_date").datepicker();
    });  
</script>    