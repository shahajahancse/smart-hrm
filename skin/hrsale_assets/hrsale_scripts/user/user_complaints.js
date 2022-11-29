$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/complaint_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var complaint_id = button.data('complaint_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/complaints_read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_complaint&complaint_id='+complaint_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
});