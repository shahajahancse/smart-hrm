<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Meeting Rooms</h5>
    </div>

    <div class="panel-body">
        <div class="text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_meeting_room">
                Add Meeting Room <i class="icon-plus-circle2 position-right"></i>
            </button>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Capacity</th>
                    <th>Description</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_meeting_rooms->result() as $room) { ?>
                    <tr>
                        <td><?php echo $room->name; ?></td>
                        <td><?php echo $room->capacity; ?></td>
                        <td><?php echo $room->description; ?></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="actionButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-right list-group" aria-labelledby="actionButton">
                                    <a class="dropdown-item list-group-item"
                                        href="<?php echo site_url('admin/meeting_rooms/edit_meeting_room/' . $room->room_id); ?>">Edit</a>
                                    <a class="dropdown-item list-group-item"
                                        href="<?php echo site_url('admin/meeting_rooms/delete_meeting_room/' . $room->room_id); ?>" onclick="return confirm('Are you sure you want to delete this meeting room?')">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Meeting Room Modal -->
<div id="add_meeting_room" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Add Meeting Room</h5>
            </div>

            <form action="<?php echo site_url('admin/meeting_rooms/add_meeting_room'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="add_type" value="meeting_room">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Capacity:</label>
                        <input type="number" name="capacity" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Description:</label>
                        <textarea name="description" class="form-control"></textarea>
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
<!-- /add meeting room modal -->
