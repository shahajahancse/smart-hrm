<?php $session = $this->session->userdata('username');?>
<?php $leaves = leave_cal($employee_id);?>
	<div class="form-group">
	   <label for="employee"><?php echo $this->lang->line('xin_leave_type');?></label>
	   <select class="form-control" id="leave_type" name="leave_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_leave_type');?>">
	    	<option value=""></option>
	      <?php foreach($leaves['leaves'] as $key => $row) {  ?>
	      <option value="<?php echo $row['id'];?>"><?php echo $row['leave_name'] .' ('.$row['qty'].' '.$this->lang->line('xin_remaining').')';?></option>
	     <?php } ?> 
	   </select>  
	  <span id="remaining_leave" style="display:none; font-weight:600; color:#F00;">&nbsp;</span>           
	</div>
<?php
//}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	jQuery('[data-plugin="select_hrm"]').select2({ width:'100%' });
	
	/*jQuery("#leave_type").change(function(){
		var employee_id = jQuery('#employee_id').val();
		var leave_type_id = jQuery(this).val();
		if(leave_type_id == '' || leave_type_id == 0) {
			jQuery('#remaining_leave').show();
			jQuery('#remaining_leave').html('<?php echo $this->lang->line('xin_error_leave_type_field');?>');
		} else {
			jQuery.get(base_url+"/get_employees_leave/"+leave_type_id+"/"+employee_id, function(data, status){
				jQuery('#remaining_leave').show();
				jQuery('#remaining_leave').html(data);
			});
		}
		alert(employee_id + ' - - '+leave_type_id);
		
	});*/
});
</script>