<?php 
$get_animate = $this->Xin_model->get_content_animate();
$get_user_number = '';
if($session['role_id'] == 3){


$get_user_number = $this->db->select('mobile_numbers.number')
                        ->from('mobile_numbers')
                        ->join('product_accessories','product_accessories.number = mobile_numbers.id')
                        ->where('product_accessories.user_id',$session['user_id'])
                        ->get()->row();
}                        
// dd($get_user_number);
$data = $this->db->select('id,phone_number,amount,approved_amount,status,created_at')->where('user_id',$session['user_id'])->get('mobile_bill_requisition')->result(); 
// dd($data);
?>


<style>
    .custom-sm-input {
        width: 150px; /* Adjust the width as needed */
    }
</style>

<div class="card  animated fadeInLeft">
    <div class="card-body form-inline">
        <h4>Mobile Bill Requisition Form</h4><hr>
        <?php $attributes = array('id' => 'product-form', 'autocomplete' => 'off', 'class' => 'm-b-1 add');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/inventory/mobile_bill', $attributes, $hidden);?>
            <div class="form-group ">
                <label for="exampleInputEmail1">Mobile Number</label><br>
                <input type="tel" name="phone_number" class="form-control form-control-sm custom-sm-input" id="exampleInputEmail1" aria-describedby="emailHelp" pattern="[0-9]{11}" placeholder="e.g., 012345678911" value="<?php echo $session['role_id'] == 3 ? $get_user_number->number : '' ?>"  >
            </div>
            <div class="form-group mx-2">
                <label for="exampleInputPassword1">Amount</label><br>
                <input type="number" name="amount" class="form-control form-control-sm custom-sm-input" id="exampleInputPassword1" placeholder="Enter Amount" required>
            </div>
            <div class="form-group mx-2">
                <button type="submit" class="btn btn-primary" style="margin-top:23px">Submit</button>
            </div>
        <?php echo form_close(); ?> 
    </div><br>
</div>


<div class=" <?php echo $get_animate;?>" style="width:300px">
    <?php if($this->session->flashdata('success')):?>
    <div class="alert alert-success flash_message" style="text-align: center;padding: 10px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo $this->session->flashdata('success');?>
    </div>
    <?php endif; ?> 
    <?php if($this->session->flashdata('delete')):?>
        <div class="alert alert-danger flash_message" style="text-align: center;padding: 10px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php echo $this->session->flashdata('delete');?>
        </div>
    <?php endif; ?> 
    <?php if($this->session->flashdata('error')):?>
        <div class="alert alert-error flash_message"  style="text-align: center;padding: 10px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php echo $this->session->flashdata('error');?>
        </div>
    <?php endif; ?> 
</div>


<?php if($session['role_id'] == 3){?>
<div class="card  <?php echo $get_animate;?>">
    <div class="card-body form-inline">
        <h4>Mobile Bill Requisition History</h4>    
        <table class="table table-bordered table-striped" id="phone_bill">
            <thead>
                <tr>
                <th class="text-center" scope="col">Sl. No.</th>
                <th class="text-center" scope="col">Request Date</th>
                <th class="text-center" scope="col">Amount</th>
                <th class="text-center" scope="col">Approved Amount</th>
                <th class="text-center" scope="col">Status</th>
                <th class="text-center" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($data as $row){?>
                    <tr class="text-center">
                        <td><?= $i++?></td>
                        <td><?= date("d M Y",strtotime($row->created_at))?></td>
                        <td><?= $row->amount?></td>
                        <td><?= $row->approved_amount=='' ? 0 : $row->approved_amount ?></td>
                        <td><?= $row->status== 1 ? '<span class="badge" style="background-color:#bebc00">Pending</span>': '<span class="badge" style="background-color:#078d07d1">Approved</span>'?></td>
                        <td>
                            <?php if($row->status== 1){?>
                            <a class="btn btn-sm btn-info"  href="<?php echo base_url('admin/inventory/mobile_edit/').$row->id?>"><i class="fa fa-edit"></i></a>
                            <?php }?>
                            <a class="btn btn-sm btn-danger " href="<?php echo base_url('admin/inventory/mobile_delete/').$row->id?>"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
<?php }?>



<script>
    $(document).ready(function(){
        $('#phone_bill').DataTable();

         function hideFlashMessages() {
            $(".flash_message").hide("slow");
        }
         setTimeout(hideFlashMessages, 1000);
    });
</script>