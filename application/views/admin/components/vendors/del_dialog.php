<style type="text/css">
.select2-container--default, .select2-container--open { z-index:1100 !important; }
#ui-datepicker-div { z-index:1100 !important; }
.modal-backdrop { z-index: 1091 !important; }
.modal { z-index: 1100 !important; }
.popover { z-index: 1100 !important; }
</style>
<div class="modal fadeInLeft delete-modal animated " role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-danger">
        <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong>
      </div>
      <?php $attributes = array('name' => 'delete_record', 'id' => 'delete_record', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>
        <?php echo form_open('', $attributes, $hidden);?> 
      	<div class="modal-footer">
        
		<?php
		$del_token = array(
			'type'  => 'hidden',
			'id'  => 'token_type',
			'name'  => 'token_type',
			'value' => 0,
		);
		echo form_input($del_token);
		?>
        
		<?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> 
		<?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="modal fadeInRight edit-modal-data animated " id="edit-modal-data" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="ajax_modal"></div>
  </div>
</div>
<div class="modal fadeInRight edit-modal-variation-data animated " id="edit-modal-variation-data" role="dialog" aria-labelledby="edit-modal-variation-data" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="ajax_variation_modal"></div>
  </div>
</div>
<div class="modal fadeInRight edit-modal-timelog-data animated " id="edit-modal-timelog-data" role="dialog" aria-labelledby="edit-modal-timelog-data" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="ajax_timelog_modal"></div>
  </div>
</div>
<div class="modal fadeInUp view-modal-data-bg animated " id="edit-modal-data" role="dialog" aria-labelledby="edit-modal-data" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="pajax_modal_view"></div>
  </div>
</div>
<div class="modal fadeInUp view-modal-data animated " id="view-modal-data" role="dialog" aria-labelledby="view-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_view"></div>
  </div>
</div>
<div class="modal fadeInUp view-modal-annoucement animated " id="view-modal-data" role="dialog" aria-labelledby="view-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_announcement"></div>
  </div>
</div>

<div class="modal fadeInUp payroll_template_modal default-modal animated " id="payroll_template_modal" role="dialog" aria-labelledby="detail-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_payroll"></div>
  </div>
</div>
<div class="modal fadeInRight hourlywages_template_modal default-modal animated " id="hourlywages_template_modal" role="dialog" aria-labelledby="detail-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_hourlywages"></div>
  </div>
</div>
<div class="modal fadeInUp detail_modal_data default-modal animated " id="detail_modal_data" role="dialog" aria-labelledby="detail-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="ajax_modal_details"></div>
  </div>
</div>
<div class="modal fadeInRight emo_monthly_pay animated " id="emo_monthly_pay" role="dialog" aria-labelledby="emo_monthly_pay" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="emo_monthly_pay_aj"></div>
  </div>
</div>
<div class="modal fadeInRight emo_hourly_pay animated " id="emo_hourly_pay" role="dialog" aria-labelledby="emo_hourly_pay" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="emo_hourly_pay_aj"></div>
  </div>
</div>
<div class="modal fadeInUp policy animated pulse" id="policy" role="dialog" aria-labelledby="policy" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="policy_modal"></div>
  </div>
</div>
<div class="modal fadeInLeft delete-modal-file animated " role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-danger">
        <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong>
      </div>
      <div class="modal-footer">
        <?php $attributes = array('name' => 'delete_record_f', 'id' => 'delete_record_f', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token_del_file' => '000', 'token_type' => '000');?>
        <?php echo form_open('', $attributes, $hidden);?> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="modal fadeInUp abouthr" id="abouthr" role="dialog" aria-labelledby="abouthr" aria-hidden="true">
  <div class="modal-dialog modal-xs">
    <div class="modal-content" id="abouthr_modal"></div>
  </div>
</div>
<div class="modal fadeInRight add-modal-data animated " id="add-modal-data" role="dialog" aria-labelledby="add-modal-data" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="add_ajax_modal"></div>
  </div>
</div>
<div class="modal fadeInLeft delete-modal-task animated " role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-danger">
        <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong>
      </div>
      <div class="modal-footer">
        <?php $attributes = array('name' => 'delete_record_t', 'id' => 'delete_record_t', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token_del_file' => '00', 'token_type' => '00');?>
        <?php echo form_open('', $attributes, $hidden);?> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="modal fadeInLeft delete-modal-variation animated " role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-danger">
        <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong>
      </div>
      <div class="modal-footer">
        <?php $attributes = array('name' => 'delete_record_v', 'id' => 'delete_record_v', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token_del_file' => '00', 'token_type' => '00');?>
        <?php echo form_open('', $attributes, $hidden);?> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="modal fadeInLeft delete-modal-timelogs animated " role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-danger">
        <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong>
      </div>
      <div class="modal-footer">
        <?php $attributes = array('class' => 'redelete_timelog', 'name' => 'redelete_timelog', 'id' => 'redelete_timelog', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token_timelog' => '00', 'token_type' => '00');?>
        <?php echo form_open('', $attributes, $hidden);?> <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php if($this->router->fetch_class() =='performance_maingoals'):?>
<div class="modal fadeInLeft delete-modal-maingoals animated " role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>
      <div class="alert alert-danger alert-dismissible fade in m-b-0" role="alert"> <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong> </div>
      <div class="modal-footer">
        <?php $attributes = array('name' => 'delete_record_maingoals', 'id' => 'delete_record_maingoals', 'autocomplete' => 'off', 'role'=>'form');?>
        <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>
        <?php echo form_open('', $attributes, $hidden);?>
    <?php
    $del_token = array(
      'type'  => 'hidden',
      'id'  => 'token_type',
      'name'  => 'token_type',
      'value' => 0,
    );
    echo form_input($del_token);
    ?>
    <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> 
    <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="modal fadeInLeft delete-modal-variable animated " tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>

      <div class="alert alert-danger alert-dismissible fade in m-b-0" role="alert"> <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong> </div>

      <div class="modal-footer">

        <?php $attributes = array('name' => 'delete_record_variable', 'id' => 'delete_record_variable', 'autocomplete' => 'off', 'role'=>'form');?>

        <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>

        <?php echo form_open('', $attributes, $hidden);?> 

    <?php

    $del_token = array(

      'type'  => 'hidden',

      'id'  => 'token_type',

      'name'  => 'token_type',

      'value' => 0,

    );

    echo form_input($del_token);

    ?>

    <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> 

    <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>

    </div>

  </div>

</div>

<!-- Incidental delete modal -->

<div class="modal fadeInLeft delete-modal-incidental animated " tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('xin_delete_confirm');?></strong> </div>

      <div class="alert alert-danger alert-dismissible fade in m-b-0" role="alert"> <strong><?php echo $this->lang->line('xin_d_not_restored');?></strong> </div>

      <div class="modal-footer">

        <?php $attributes = array('name' => 'delete_record_incidental', 'id' => 'delete_record_incidental', 'autocomplete' => 'off', 'role'=>'form');?>

        <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>

        <?php echo form_open('', $attributes, $hidden);?> 

    <?php

    $del_token = array(

      'type'  => 'hidden',

      'id'  => 'token_type',

      'name'  => 'token_type',

      'value' => 0,

    );

    echo form_input($del_token);

    ?>

    <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> 

    <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>

    </div>

  </div>

</div>



<!-- Approve modal for maingoals kpi -->

<div class="modal fadeInUp approve-modal-maingoals-kpi animated " tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('kpi_confirm_approve_maingoals');?></strong> </div>

      <div class="modal-footer">

        <?php $attributes = array('name' => 'approve_maingoals_kpi', 'id' => 'approve_maingoals_kpi', 'autocomplete' => 'off', 'role'=>'form');?>

        <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>

        <?php echo form_open('', $attributes, $hidden);?> 

    <?php

    $del_token = array(

      'type'  => 'hidden',

      'id'  => 'token_type',

      'name'  => 'token_type',

      'value' => 0,

    );

    echo form_input($del_token);

    ?>

    <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> 

    <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>

    </div>

  </div>

</div>



<!-- Approve modal for variable kpi -->

<div class="modal fadeInUp approve-modal-variable-kpi animated " tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-header"> <?php echo form_button(array('aria-label' => 'Close', 'data-dismiss' => 'modal', 'type' => 'button', 'class' => 'close', 'content' => '<span aria-hidden="true">×</span>')); ?> <strong class="modal-title"><?php echo $this->lang->line('kpi_confirm_approve_variable');?></strong> </div>

      <div class="modal-footer">

        <?php $attributes = array('name' => 'approve_variable_kpi', 'id' => 'approve_variable_kpi', 'autocomplete' => 'off', 'role'=>'form');?>

        <?php $hidden = array('_method' => 'DELETE', '_token' => '000');?>

        <?php echo form_open('', $attributes, $hidden);?> 

    <?php

    $del_token = array(

      'type'  => 'hidden',

      'id'  => 'token_type',

      'name'  => 'token_type',

      'value' => 0,

    );

    echo form_input($del_token);

    ?>

    <?php echo form_button(array('data-dismiss' => 'modal', 'type' => 'button', 'class' => 'btn btn-secondary', 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_close'))); ?> 

    <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => $this->Xin_model->form_button_class(), 'content' => '<i class="fa fa fa-check-square-o"></i> '.$this->lang->line('xin_confirm_del'))); ?> <?php echo form_close(); ?> </div>

    </div>

  </div>

</div>





<!-- Maingoals edit modal-->

<div class="modal fadeInRight edit-modal-maingoals-data animated " id="edit-modal-maingoals-data" tabindex="-1" role="dialog" aria-labelledby="edit-modal-maingoals-data" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content" id="ajax_modal_maingoals"></div>

  </div>

</div>



<!-- Variable edit modal-->

<div class="modal fadeInRight edit-modal-variable-data animated " id="edit-modal-variable-data" tabindex="-1" role="dialog" aria-labelledby="edit-modal-variable-data" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content" id="ajax_modal_variable"></div>

  </div>

</div>



<!-- Incidental edit modal-->

<div class="modal fadeInRight edit-modal-incidental-data animated " id="edit-modal-incidental-data" tabindex="-1" role="dialog" aria-labelledby="edit-modal-incidental-data" aria-hidden="true">

  <div class="modal-dialog">

    <div class="modal-content" id="ajax_modal_incidental"></div>

  </div>

</div>
<?php endif;?>