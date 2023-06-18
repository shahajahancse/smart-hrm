<?php
/* Policy view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>

<div class="row m-b-1 <?php echo $get_animate;?>">
  <?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
  <?php if(in_array('258',$role_resources_ids)) {?>
  <?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
  <div class="col-md-12">
    
    <div class="box">
     
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
        <?php $attributes = array('name' => 'add_policy', 'id' => 'xin-form', 'autocomplete' => 'off');?>
        <?php $hidden = array('user_id' => $session['user_id']);?>
        <?php echo form_open('admin/policy/add_policy', $attributes, $hidden);?>
       <div class="row">
        <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                    <label for="title"><?php echo $this->lang->line('xin_title');?></label>
                    <input type="text" class="form-control" name="title" placeholder="<?php echo $this->lang->line('xin_title');?>">
                  </div>

                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="attachment"><?php echo $this->lang->line('xin_attachment');?></label>
                    <input type="file" class="form-control-file" id="attachment" name="attachment">
                    <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                  </fieldset>
                </div>
               
            </div>
           


        <div class="col-md-6">
            <div class="form-group">
                        <label for="message"><?php echo $this->lang->line('xin_description');?></label>
                        <textarea class="form-control" placeholder="<?php echo $this->lang->line('xin_description');?>" name="description" id="description"></textarea>
                      </div>
             </div>
        </div>
           

        </div>
         
       

       
       </div>

  
        <div class="form-actions box-footer">
          <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
  <?php $colmdval = 'col-md-12';?>
  <?php } else {?>
  <?php $colmdval = 'col-md-12';?>
  <?php } ?>
  <div class="<?php echo $colmdval;?>">
    <div class="box">
      <div class="box-header with-borsder">
        <h3 class="box-title"> <?php echo $this->lang->line('xin_list_all');?> <?php echo $this->lang->line('xin_policies');?> </h3>
      </div>
      <div class="box-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="xin_table">
            <thead>
              <tr>
                <th style="width:100px;"><?php echo $this->lang->line('xin_action');?></th>
                <th width="230"><?php echo $this->lang->line('xin_title');?></th>
                <th><i class="fa fa-user"></i> <?php echo $this->lang->line('xin_created_at');?></th>
                <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_added_by');?></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
.trumbowyg-editor { min-height:110px !important; }
</style>
