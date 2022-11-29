//Init
init();

//Button Functions------------------------------------------
function init() {
  $(".button-notstarted").on("click", function() {
    if (!($(this).closest(".notstarted").length > 0)) {
      $(this).parents(".input-group").appendTo(".notstarted").css({
        "background-color": "",
        "border": ""
      });
		var project_id = $(this).data('project-id');
		var project_status = $(this).data('project-status');
		jQuery.get(site_url+"project/update_project_scrum_board_status/"+project_id+"/"+project_status, function(data, status){
		});
    }
  });
  $(".button-progress").on("click", function() {
    if (!($(this).closest(".in-progress").length > 0)) {
      $(this).parents(".input-group").appendTo(".in-progress").css({
        "background-color": "#bbe9ff",
        "border": "none"
      });
		var project_id = $(this).data('project-id');
		var project_status = $(this).data('project-status');
		jQuery.get(site_url+"project/update_project_scrum_board_status/"+project_id+"/"+project_status, function(data, status){
		});
    }
  });
  $(".button-complete").on("click", function() {
    if (!($(this).closest(".complete").length > 0)) {
      $(this).parents(".input-group").appendTo(".complete").css({
        "background-color": "#cfffd0",
        "border": "none"
      });
	  	var project_id = $(this).data('project-id');
		var project_status = $(this).data('project-status');
		jQuery.get(site_url+"project/update_project_scrum_board_status/"+project_id+"/"+project_status, function(data, status){
		});
    }
  });
  $(".button-cancelled").on("click", function() {
    if (!($(this).closest(".cancelled").length > 0)) {
      $(this).parents(".input-group").appendTo(".cancelled").css({
        "background-color": "#ffd8d8",
        "border": "none"
      });
	  	var project_id = $(this).data('project-id');
		var project_status = $(this).data('project-status');
		jQuery.get(site_url+"project/update_project_scrum_board_status/"+project_id+"/"+project_status, function(data, status){
		});
    }
  });
  $(".button-hold").on("click", function() {
    if (!($(this).closest(".hold").length > 0)) {
      $(this).parents(".input-group").appendTo(".hold").css({
        "background-color": "#fbffa2",
        "border": "none"
      });
	  	var project_id = $(this).data('project-id');
		var project_status = $(this).data('project-status');
		jQuery.get(site_url+"project/update_project_scrum_board_status/"+project_id+"/"+project_status, function(data, status){
		});
    }
  });
  
  $(".button-delete").on("click", function() {
    $(this).parents(".input-group").remove();
  });

  var placeholderDiv = document.createElement("div");
  var placeholderAtt = document.createAttribute("class");
  var taskDivAttVal = placeholderAtt.value = "placeholder";
  placeholderDiv.setAttributeNode(placeholderAtt);

}
$(document).ready(function() {
	// add
	$('.edit-modal-data').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var project_status = button.data('project_status');
		var modal = $(this);
	$.ajax({
		url : site_url+"project/get_scrumboard_project/",
		type: "GET",
		data: 'jd=1&is_ajax=1&mode=modal&data=scrum_board&project_status='+project_status,
		success: function (response) {
			if(response) {
				$("#ajax_modal").html(response);
			}
		}
		});
	});
});