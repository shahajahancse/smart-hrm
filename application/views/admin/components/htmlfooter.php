<?php $session = $this->session->userdata('username'); ?>
<?php $company = $this->Xin_model->read_company_setting_info(1);?>
<?php $user = $this->Xin_model->read_user_info($session['user_id']); ?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php $theme = $this->Xin_model->read_theme_info(1);?>
<?php $this->load->view('admin/components/vendors/del_dialog');?>
<!-- jQuery 3 -->
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/jquery/jquery-3.2.1.min.js"></script> 
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
  
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/bootstrap-select/bootstrap-select.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/Trumbowyg/dist/trumbowyg.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/clockpicker/dist/jquery-clockpicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/toastr/toastr.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- App -->
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/dist/js/adminlte.min.js"></script>
<?php if($theme[0]->theme_option == 'template_1'):?>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/dist/js/demo.js"></script>
<?php else:?>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/dist/js/demo_template2.js"></script>
<?php endif;?>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script type="text/javascript">var user_role = '<?php //echo $user[0]->user_role_id;?>';</script>
<script type="text/javascript">var user_session_id = '<?php echo $session['user_id'];?>';</script>
<script type="text/javascript">var js_date_format = '<?php echo $this->Xin_model->set_date_format_js();?>';</script>
<script type="text/javascript">var site_url = '<?php echo site_url(); ?>admin/';</script>
<script type="text/javascript">var base_url = '<?php echo site_url().'admin/'.$this->router->fetch_class(); ?>';</script>
<script type="text/javascript">var processing_request = '<?php echo $this->lang->line('xin_processing_request');?>';</script>
<script type="text/javascript">var request_submitted = '<?php echo $this->lang->line('xin_hr_request_submitted');?>';</script>
<script src="<?php echo base_url();?>skin/hrsale_assets/js/bootstrap-checkbox.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	toastr.options.closeButton = <?php echo $system[0]->notification_close_btn;?>;
	toastr.options.progressBar = <?php echo $system[0]->notification_bar;?>;
	toastr.options.timeOut = 3000;
	toastr.options.showMethod = 'slideDown';
	toastr.options.hideMethod = 'slideUp';
	toastr.options.preventDuplicates = true;
	toastr.options.positionClass = "<?php echo $system[0]->notification_position;?>";
   // setTimeout(refreshChatMsgs, 5000);
   $('[data-toggle="popover"]').popover();
});
function escapeHtmlSecure(str)
{
	var map =
	{
		'alert': '&lt;',
		'313': '&lt;',
		'bzps': '&lt;',
		'<': '&lt;',
		'>': '&gt;',
		'script': '&lt;',
		'html': '&lt;',
		'php': '&lt;',
	};
	return str.replace(/[<>]/g, function(m) {return map[m];});
}	
</script>
<script type="text/javascript">
$(document).ready(function(){
	
	/*  Toggle Starts   */
	//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });
	$('.js-switch:checkbox').checkboxpicker();
	$('.date').datepicker({
	changeMonth: true,
	changeYear: true,
	dateFormat:'yy-mm-dd',
	yearRange: '1900:' + (new Date().getFullYear() + 15),
	beforeShow: function(input) {
		$(input).datepicker("widget").show();
	}
	});
});
</script>
<?php if($this->router->fetch_method() =='attendance' || $this->router->fetch_method() =='date_wise_attendance' || $this->router->fetch_method() =='update_attendance'){?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $system[0]->google_maps_api_key;?>&sensor=false"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'skin/hrsale_assets/hrsale_scripts/'.$path_url.'.js'; ?>"></script>
<?php if($this->router->fetch_class() =='dashboard') { ?>
	<?php if($system[0]->is_ssl_available=='yes'){?>
	<script src="<?php echo base_url();?>skin/hrsale_assets/hrsale_scripts/user/set_clocking_ssl.js"></script>
    <?php } else {?>
    <script src="<?php echo base_url();?>skin/hrsale_assets/hrsale_scripts/user/set_clocking_non_ssl.js"></script>
    <?php } ?>
<?php } ?>
<script src="<?php echo base_url();?>skin/hrsale_assets/hrsale_scripts/custom.js"></script>
<?php if($this->router->fetch_class() =='roles') { ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/kendo/kendo.all.min.js"></script>
<?php $this->load->view('admin/roles/role_values');?>
<?php } ?>
<?php if($this->router->fetch_class() =='organization'){?>
<?php $this->load->view('admin/components/vendors/organization_chart');?>
<?php } ?>
<?php if($this->router->fetch_class() =='goal_tracking' || $this->router->fetch_method() =='task_details' || $this->router->fetch_class() =='project' || $this->router->fetch_method() =='project_details'){?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/ion.rangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<?php }?>
<?php if($this->router->fetch_method() =='task_details' || $this->router->fetch_method() =='project_details' || ($this->router->fetch_class() =='project' && $this->router->fetch_method() !='projects_calendar')){?>
<script type="text/javascript">
$(document).ready(function(){	
	$("#range_grid").ionRangeSlider({
		type: "single",
		min: 0,
		max: 100,
		from: '<?php echo $progress;?>',
		grid: true,
		force_edges: true,
		onChange: function (data) {
			$('#progres_val').val(data.from);
		}
	});
});
</script>
<?php } ?>
<script src="<?php echo base_url();?>skin/hrsale_assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<?php if($this->router->fetch_class() =='invoices' || $this->router->fetch_class() =='quotes' && ($this->router->fetch_method() =='create' || $this->router->fetch_method() =='edit')) { ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#add-invoice-item').click(function () {
        var invoice_items = '<div class="row item-row">'
					+'<hr>'
					+'<div class="form-group mb-1 col-sm-12 col-md-3">'
					+'<label for="item_name"><?php echo $this->lang->line('xin_title_item');?></label>'
					+'<br>'
					+'<input type="text" class="form-control item_name" name="item_name[]" id="item_name" placeholder="Item Name">'
					+'</div>'
					+'<div class="form-group mb-1 col-sm-12 col-md-2">'
					+'<label for="tax_type"><?php echo $this->lang->line('xin_invoice_tax_type');?></label>'
					+'<br>'
					+'<select class="form-control tax_type" name="tax_type[]" id="tax_type">'
					<?php foreach($all_taxes as $_tax){?>
					<?php
						if($_tax->type=='percentage') {
							$_tax_type = $_tax->rate.'%';
						} else {
							$_tax_type = $this->Xin_model->currency_sign($_tax->rate);
						}
					?>
					+'<option tax-type="<?php echo $_tax->type;?>" tax-rate="<?php echo $_tax->rate;?>" value="<?php echo $_tax->tax_id;?>"> <?php echo $_tax->name;?> (<?php echo $_tax_type;?>)</option>'
					<?php } ?>
				  	+'</select>'
					+'</div>' 
					+'<div class="form-group mb-1 col-sm-12 col-md-1">'
					+'<label for="tax_type"><?php echo $this->lang->line('xin_title_tax_rate');?></label>'
					+'<br>'
					+'<input type="text" readonly="readonly" class="form-control tax-rate-item" name="tax_rate_item[]" value="0" />'
					+'</div>'
					+'<div class="form-group mb-1 col-sm-12 col-md-1">'
					+'<label for="qty_hrs" class="cursor-pointer"><?php echo $this->lang->line('xin_title_qty_hrs');?></label>'
					+'<br>'
					+'<input type="text" class="form-control qty_hrs" name="qty_hrs[]" id="qty_hrs" value="1">'
					+'</div>'
					+'<div class="skin skin-flat form-group mb-1 col-sm-12 col-md-2">'
					+'<label for="unit_price"><?php echo $this->lang->line('xin_title_unit_price');?></label>'
					+'<br>'
					+'<input class="form-control unit_price" type="text" name="unit_price[]" value="0" id="unit_price" />'
					+'</div>'
					+'<div class="form-group mb-1 col-sm-12 col-md-2">'
					+'<label for="profession"><?php echo $this->lang->line('xin_title_sub_total');?></label>'
					+'<input type="text" class="form-control sub-total-item" readonly="readonly" name="sub_total_item[]" value="0" />'
					+'<p style="display:none" class="form-control-static"><span class="amount-html">0</span></p>'
					+'</div>'
					+'<div class="form-group col-sm-12 col-md-1 text-xs-center mt-2">'
					+'<label for="profession">&nbsp;</label><br><button type="button" class="btn icon-btn btn-xs btn-danger waves-effect waves-light remove-invoice-item" data-repeater-delete=""> <span class="fa fa-trash"></span></button>'
					+'</div>'
				  	+'</div>'

        $('#item-list').append(invoice_items).fadeIn(500);

    });
});	

</script>
<?php } ?>
<?php if($this->router->fetch_class() =='invoices' || $this->router->fetch_class() =='quotes' && $this->router->fetch_method() =='view') { ?>
<script type="text/javascript" src="<?php echo base_url();?>skin/hrsale_assets/vendor/printThis.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.print-invoice').click(function () {
		$("#print_invoice_hr").printThis();
	});	
});
</script>
<?php } ?>
<?php if($this->router->fetch_class() =='calendar' || $this->router->fetch_class() =='dashboard' || $this->router->fetch_method() =='timecalendar' || $this->router->fetch_method() =='projects_calendar' || $this->router->fetch_method() =='tasks_calendar'){?>
	<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/moment/moment.js"></script>
	<script src="<?php echo base_url();?>skin/hrsale_assets/theme_assets/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<?php } ?>
<?php if($this->router->fetch_method() =='projects_calendar'){?>
	<?php $this->load->view('admin/components/vendors/project_calendar');?>
<?php }?>
<?php if($this->router->fetch_method() =='tasks_calendar'){?>
	<?php $this->load->view('admin/components/vendors/tasks_calendar');?>
<?php }?>
<?php if($this->router->fetch_method() =='timecalendar'){?>
	<?php $this->load->view('admin/components/vendors/calendar_time');?>
<?php }?>
<?php if($this->router->fetch_class() =='calendar' || $this->router->fetch_class() =='dashboard'){?>
	<?php if($user[0]->user_role_id==1): ?>
		<?php $this->load->view('admin/components/vendors/full_calendar');?>
    <?php else:?>
    	<?php //$this->load->view('admin/components/vendors/half_calendar');?>
        <?php $this->load->view('admin/components/vendors/full_calendar');?>
    <?php endif; ?>
    <?php if($user[0]->user_role_id==1 && $this->router->fetch_class() =='dashboard'):?>
    <script src="<?php echo base_url();?>skin/hrsale_assets/vendor/charts/chart.min.js" type="text/javascript"></script>    
    <script src="<?php echo base_url();?>skin/hrsale_assets/hrsale_scripts/xchart/employee_department.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>skin/hrsale_assets/hrsale_scripts/xchart/employee_designation.js" type="text/javascript"></script>
    <?php endif; ?>
<?php }?>
<?php if($system[0]->module_chat_box=='true'){?>
<?php if($this->router->fetch_class() =='chat'){?>
<script>  
  $('#chat-app, #chat-contact').slimScroll({
	height: '420px'
  });
</script>
<?php } ?>
 <script type="text/javascript">
 $(document).ready(function(){
   setTimeout(refreshChatMsgs, 5000);
});
function refreshChatMsgs() {
	  $.ajax({
		url: site_url + "chat/refresh_chat_users_msg/",
		type: 'GET',
		dataType: 'html',
		success: function(data) {
			setTimeout(refreshChatMsgs, 5000);
		  	jQuery('#msgs_count').html(data);
		},
		error: function() {
		  
		}
	  });
}
</script>
<?php } ?>
<?php if($this->router->fetch_class() =='theme'){?>
<script>
  function testAnim(x) {
    $('#animationSandbox').removeClass().addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      $(this).removeClass();
    });
  };

  $(document).ready(function(){
    $('.js--triggerAnimation').click(function(e){
      e.preventDefault();
      var anim = $('.js--animations').val();
      testAnim(anim);
    });

    $('.js--animations').change(function(){
      var anim = $(this).val();
      testAnim(anim);
    });
  });
</script>
<?php } ?>