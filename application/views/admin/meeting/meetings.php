<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Meetings</h5>
        
    </div>

    <div class="panel-body">
        <div class="text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_meeting">
                Add Meeting <i class="icon-plus-circle2 position-right"></i>
            </button>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Employee</th>
                    <th>Meeting Title</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Attendees</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_meetings->result() as $meeting) { ?>
                    <tr>
                        <td><?php echo $meeting->room_name; ?></td>
                        <td><?php echo $meeting->first_name . ' ' . $meeting->last_name; ?></td>
                        <td><?php echo $meeting->meeting_title; ?></td>
                        <td><?php echo $meeting->date; ?></td>
                        <td><?php echo $meeting->start_time; ?></td>
                        <td><?php echo $meeting->end_time; ?></td>
                        <td><?php echo $meeting->attendees; ?></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="actionButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right list-group" aria-labelledby="actionButton">
                                    <a class="dropdown-item list-group-item"
                                        href="<?php echo site_url('admin/meetings/edit_meeting/' . $meeting->meeting_id); ?>">Edit</a>
                                    <a class="dropdown-item list-group-item"
                                        href="<?php echo site_url('admin/meetings/delete_meeting/' . $meeting->meeting_id); ?>" onclick="return confirm('Are you sure you want to delete this meeting?')">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Meeting Modal -->
<div id="add_meeting" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Add Meeting</h5>
            </div>

            <form action="<?php echo site_url('admin/meetings/add_meeting'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="add_type" value="meeting">
                    <div class="form-group">
                        <label>Meeting Room:</label>
                        <select name="room_id" class="form-control" required>
                            <option value="">Select Room</option>
                            <?php foreach ($all_meeting_rooms->result() as $room) { ?>
                                <option value="<?php echo $room->room_id; ?>"><?php echo $room->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>



                    <div class="form-group">
                        <label>Employee:</label>
                        <select name="employee_id" class="form-control" required>
                           
                            <?php foreach ($all_employees->result() as $employee) { ?>
                                <option <?php if ($employee->user_id == $this->session->userdata('user_id')) echo 'selected'; ?> value="<?php echo $employee->user_id; ?>"><?php echo $employee->first_name . ' ' . $employee->last_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Meeting Title:</label>
                        <input type="text" name="meeting_title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Date:</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Start Time:</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>End Time:</label>
                        <input type="time" name="end_time" class="form-control datetimepicker" required>
                    </div>

                    <div class="form-group">
                        <label>Attendees:</label>
                        <select name="attendees[]" class="select22 form-control" multiple="multiple" data-placeholder="Select Employee">
                             <option value="0" selected>Select Employee</option>
                        <?php foreach ($all_employees->result() as $employee) { ?>
                                <option  value="<?php echo $employee->user_id; ?>"><?php echo $employee->first_name . ' ' . $employee->last_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /add meeting modal -->
