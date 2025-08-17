<?php
$meeting = $meeting[0];
?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Edit Meeting</h5>
        
    </div>

    <div class="panel-body">
        <form action="<?php echo site_url('admin/meetings/update_meeting/' . $meeting->meeting_id); ?>" method="post">
            <input type="hidden" name="edit_type" value="meeting">
            <div class="form-group">
                <label>Meeting Room:</label>
                <select name="room_id" class="form-control" required>
                    <option value="">Select Room</option>
                    <?php foreach ($all_meeting_rooms->result() as $room) { ?>
                        <option value="<?php echo $room->room_id; ?>" <?php if ($room->room_id == $meeting->room_id) echo 'selected'; ?>><?php echo $room->name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Employee:</label>
                <select name="employee_id" class="form-control" required>
                    <option value="">Select Employee</option>
                    <?php foreach ($all_employees->result() as $employee) { ?>
                        <option value="<?php echo $employee->user_id; ?>" <?php if ($employee->user_id == $meeting->employee_id) echo 'selected'; ?>><?php echo $employee->first_name . ' ' . $employee->last_name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Meeting Title:</label>
                <input type="text" name="meeting_title" class="form-control" value="<?php echo $meeting->meeting_title; ?>" required>
            </div>

            <div class="form-group">
                <label>Date:</label>
                <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($meeting->date)); ?>" required>
            </div>

            <div class="form-group">
                <label>Start Time:</label>
                <input type="time" name="start_time" class="form-control datetimepicker" value="<?php echo date('H:i:s', strtotime($meeting->start_time)); ?>" required>
            </div>

            <label>End Time:</label>
                <input type="time" name="end_time" class="form-control datetimepicker" value="<?php echo date('H:i:s', strtotime($meeting->end_time)); ?>" required>
            </div>

            <div class="form-group">
                <label>Attendees:</label>
                <select name="attendees[]" class="form-control select22" multiple="multiple" data-plugin="select_hrm">
                    <?php 
                    $attendee_ids = array_column($attendees, 'employee_id');
                    foreach ($all_employees->result() as $employee) { 
                        $selected = in_array($employee->user_id, $attendee_ids) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $employee->user_id; ?>" <?php echo $selected; ?>><?php echo $employee->first_name . ' ' . $employee->last_name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="text-right">
                <a href="<?php echo site_url('admin/meetings'); ?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
