<?php
/* Application > Update view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $system = $this->Xin_model->read_setting_info(1);?>

<div class="row">
  <div class="col-xs-12 mt-3 mb-1">
    <p>Your current version is v<?php echo $system[0]->hr_version;?></p>
    <p>Note: Please first take a backup of your files and database.</p>
  </div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Backup of files and database</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-body collapse in" aria-expanded="true" style="">
        <div class="card-block"> here... </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Update to new version</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-body collapse in" aria-expanded="true" style="">
        <div class="card-block">
          <form class="form" method="post" name="update_app" id="xin-form" enctype="multipart/form-data" action="<?php echo site_url('admin/application/file_upload');?>">
            <input type="hidden" name="user_id" value="<?php echo $session['user_id'];?>">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="file_zip"><?php echo $this->lang->line('xin_hr_update_archive_file_zip');?></label>
                    <input type="file" class="form-control-file" id="userfile" name="userfile">
                    <small>Allowed Formats : only .zip</small>
                  </fieldset>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <fieldset class="form-group">
                    <label for="file_sql"><?php echo $this->lang->line('xin_hr_update_mysql_file_sql');?></label>
                    <input type="file" class="form-control-file" id="file_sql" name="file_sql">
                    <small>Allowed Formats : only .sql</small>
                  </fieldset>
                </div>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
