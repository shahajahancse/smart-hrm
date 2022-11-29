$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : site_url+"user/employee_payslip_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	
	$('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
	$('[data-plugin="select_hrm"]').select2({ width:'100%' }); 	
	
	// detail modal data
	$('.detail_modal_data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var employee_id = button.data('employee_id');
		var pay_id = button.data('pay_id');
		var modal = $(this);
		$.ajax({
			url: site_url+'payroll/make_payment_view/',
			type: "GET",
			data: 'jd=1&is_ajax=11&mode=modal&data=pay_payment&type=pay_payment&emp_id='+employee_id+'&pay_id='+pay_id,
			success: function (response) {
				if(response) {
					$("#ajax_modal_details").html(response);
				}
			}
		});
	});
});