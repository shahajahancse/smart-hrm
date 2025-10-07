<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Meeting Reports</h5>
    </div>

    <div class="panel-body">
        <form id="report-form" action="<?php echo site_url('admin/meeting_reports/generate_report'); ?>" method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Meeting Room:</label>
                        <select name="room_id" class="form-control">
                            <option value="">All Rooms</option>
                            <?php foreach ($all_meeting_rooms->result() as $room) { ?>
                                <option value="<?php echo $room->room_id; ?>"><?php echo $room->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Employee:</label>
                        <select name="employee_id" class="form-control">
                            <option value="">All Employees</option>
                            <?php foreach ($all_employees->result() as $employee) { ?>
                                <option value="<?php echo $employee->user_id; ?>"><?php echo $employee->first_name . ' ' . $employee->last_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Start Date:</label>
                        <input type="text" name="start_date" class="form-control date">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>End Date:</label>
                        <input type="text" name="end_date" class="form-control date">
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </div>
        </form>

        <div id="report-results"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#report-form').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(data) {
                    $('#report-results').html(data);
                }
            });
        });
    });
</script>
