$(document).ready(function() {
   var xin_table = $('#xin_table').dataTable({
        "bDestroy": true,
		"ajax": {
            url : base_url+"/promotion_list/",
            type : 'GET'
        },
		"fnDrawCallback": function(settings){
		$('[data-toggle="tooltip"]').tooltip();          
		}
    });
	$('.view-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var promotion_id = button.data('promotion_id');
		var modal = $(this);
	$.ajax({
		url : base_url+"/promotion_read/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=view_promotion&promotion_id='+promotion_id,
		success: function (response) {
			if(response) {
				$("#ajax_modal_view").html(response);
			}
		}
		});
	});
});