
    <div class="box" style="height: 74vh;overflow-y: scroll;">
    <input type="text" id="searchi" class="form-control" style="margin: 6px 8px;width: 96%;" placeholder="Search">
      <table class="table table-striped table-hover">
        <thead>
          <tr style="position: sticky;top: 0;z-index:1">
              <th class="active" style="width:10%"><input type="checkbox" id="select_all" class="select-all checkbox" name="select-all" /></th>
              <th class="" style="width:10%;background:#0177bcc2;color:white">Id</th>
              <th class=" text-center" style="background:#0177bc;color:white">Name</th>
          </tr>
        </thead>
        <tbody id="fileDiv">

        </tbody>
      </table>
    </div>
    <script>
		$(document).ready(function() {
			$("#searchi").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#fileDiv tr").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
		});
	</script>
