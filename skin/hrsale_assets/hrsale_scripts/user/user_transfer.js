$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/transfer_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	$('.view-modal-data').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var transfer_id = button.data('transfer_id');
	var modal = $(this);
$.ajax({
	url : base_url+"/transfer_read/",
	type: "GET",
	data: 'jd=1&is_ajax=1&mode=modal&data=view_transfer&transfer_id='+transfer_id,
	success: function (response) {
		if(response) {
			$("#ajax_modal_view").html(response);
		}
	}
	});
});
});