<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
  <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_hr_view_event');?></h4>
</div>
<form class="m-b-1">
  <div class="modal-body">
    <table class="footable-details table table-striped table-hover toggle-circle">
      <tbody>
        <tr>
          <th><?php echo $this->lang->line('xin_hr_event_title');?></th>
          <td style="display: table-cell;"><?php echo $title;?></td>
        <tr>
        </tr>
          <th><?php echo $this->lang->line('xin_hr_event_date');?></th>
          <td style="display: table-cell;"><?php echo $description;?></td>
        </tr>
        <?php $event_time = new DateTime($updated_at);?>
        <tr>
          <th><?php echo $this->lang->line('xin_hr_event_time');?></th>
          <td style="display: table-cell;"><?php echo $event_time->format('h:i a');?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
  </div>
<?php echo form_close(); ?>