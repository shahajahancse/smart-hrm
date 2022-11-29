$(document).ready(function() {
var xin_table = $('#xin_table').dataTable({
	"bDestroy": true,
	"ajax": {
		url : site_url+"reports/payslip_report_list/"+$('#aj_company').val()+"/"+$('#employee_id').val()+"/"+$('#month_year').val(),
		type : 'GET'
	},
	dom: 'lBfrtip',
	"buttons": [{
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            }, {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            }, {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            }, {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }
            },], // colvis > if needed
	"fnDrawCallback": function(settings){
	$('[data-toggle="tooltip"]').tooltip();          
	},
});

$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
$('[data-plugin="select_hrm"]').select2({ width:'100%' });
jQuery("#aj_company").change(function(){
	jQuery.get(base_url+"/get_employees/"+jQuery(this).val(), function(data, status){
		jQuery('#employee_ajax').html(data);
	});
});

$('.r_month_year').datepicker({
	changeMonth: true,
	changeYear: true,
	showButtonPanel: true,
	dateFormat:'yy-mm',
	yearRange: '1900:' + (new Date().getFullYear() + 15),
	beforeShow: function(input) {
		$(input).datepicker("widget").addClass('hide-calendar');
	},
	onClose: function(dateText, inst) {
		var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
		var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
		$(this).datepicker('setDate', new Date(year, month, 1));
		$(this).datepicker('widget').removeClass('hide-calendar');
		$(this).datepicker('widget').hide();
	}
});

/* Add data */ /*Form Submit*/
$("#xin-form").submit(function(e){
e.preventDefault();
	var obj = $(this), action = obj.attr('name');
	$('.save').prop('disabled', true);
	$('.icon-spinner3').show();
	$.ajax({
		type: "POST",
		url: e.target.action,
		data: obj.serialize()+"&is_ajax=1&type=payslip_report&form="+action,
		cache: false,
		success: function (JSON) {
			if (JSON.error != '') {
				toastr.error(JSON.error);
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
				$('.icon-spinner3').hide();
			} else {
				var aj_company = $('#aj_company').val();
				var employee_id = $('#employee_id').val();
				var month_year = $('#month_year').val();
				var xin_table2 = $('#xin_table').dataTable({
					"bDestroy": true,
					"ajax": {
						url : site_url+"reports/payslip_report_list/"+aj_company+"/"+employee_id+"/"+month_year,
						type : 'GET'
					},
					dom: 'lBfrtip',
					"buttons": [{
								extend: 'csv',
								exportOptions: {
									columns: [ 0, 1, 2, 3]
								}
							}, {
								extend: 'excel',
								exportOptions: {
									columns: [ 0, 1, 2, 3]
								}
							}, {
								extend: 'pdfHtml5',
								exportOptions: {
									columns: [ 0, 1, 2, 3]
								}
							}, {
								extend: 'print',
								exportOptions: {
									columns: [ 0, 1, 2, 3]
								}
							},], // colvis > if needed
					"fnDrawCallback": function(settings){
					$('[data-toggle="tooltip"]').tooltip();          
					},
				});
				toastr.success(JSON.result);
				xin_table2.api().ajax.reload(function(){ }, true);
				$('.icon-spinner3').hide();
				$('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
				$('.save').prop('disabled', false);
			}
		}
	});
});
});
