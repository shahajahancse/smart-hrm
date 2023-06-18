<!-- <a href="<?= base_url('admin/lunch/emp_pay_list') ?>" class="btn btn-primary float-right">Get Payment</a> -->
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div id="page_load">
    <div class="box mb-4 <?php echo $get_animate;?>">
        <div id="accordion">
            <?php if($this->session->flashdata('success')):?>
            <div class="alert alert-success" id="flash_message">
                <?php echo $this->session->flashdata('success');?>
                <script>
                    setTimeout(function(){
                        $('#flash_message').hide();
                    },3000);
                </script>
            </div>
            <?php endif; ?> 
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo 'Add Company Policy';?></h3>
                <div class="box-tools pull-right">
                    <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
                        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span>
                            <?php echo $this->lang->line('xin_add_new');?></button>
                    </a>
                </div>
            </div>


            <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
                <div class="box-body">
                    <?php $attributes = array('id' => 'move_register', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
                    <!-- < ?php $hidden = array('user_id' => $session['user_id']);?> -->
                    <?php echo form_open('admin/events/company_policy',$attributes); ?>
                    <div class="bg-white">
                        <div class="box-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="container">  
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                                                </div>
                                                <div class="form-group">
                                                    <label for="editableTextarea">Policy List</label>
                                                    <textarea name="editor" id="myTextarea" value=""></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <?php $all_policies = $this->db->select('*')->from('xin_company_policy')->order_by('policy_id', 'DESC')->get()->result();?>
         

        </div>
    </div>
</div>

<div class="box <?php echo $get_animate;?>">
        <div class="box-header with-border">
            <h3 class="box-title">Policy  list</h3>
        </div>
        <div class="box-body">
        <div class="box-datatable">
    <table class="datatables-demo table table-striped table-bordered" id="example">
        <thead>
            <tr>
                <th style="width: 50px;" class="text-center">No.</th>
                <th style="width: 200px;" class="text-center">Title</th>
                <th style="width: 120px;" class="text-center">Time</th>
                <th style="width: 120px;" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($all_policies as $key => $policy): ?>
            <tr>
                <td class="text-center"><?= $key + 1 ?></td>
                <td class="text-center"><?= $policy->title ?></td>
                <td class="text-center"><?= $policy->created_at ?></td>
                <td class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu" style="min-width: 100px !important; border-radius: 0; line-height: 1.7;"
                            aria-labelledby="dropdownMenuButton">
                            <a style="padding-left: 5px;" onclick="view()" class="text-dark collapsed" data-toggle="collapse"
                                href="#" aria-expanded="false">View</a><br>
                            <a style="padding-left: 5px;" onclick="edit(<?php echo $policy->policy_id;?>)" class="text-dark collapsed" data-toggle="collapse"
                                href="<?php echo $policy->policy_id; ?>#add_form" aria-expanded="false">Edit</a><br>
                            <a style="padding-left: 5px;" href="#">Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

        </div>
    </div>

<
<script>
   
   function edit(id) {
    $.ajax({
        url: "<?php echo base_url('admin/events/get_policy/'); ?>" + id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#title').val(data[0].title);
            $('#myTextarea').val(data[0].description);
        }
    });
}

</script>

<script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#myTextarea'))
        .catch(error => {
            console.error(error);
        });
</script>
