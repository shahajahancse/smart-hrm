<?php
$room = $meeting_room[0];
?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Edit Meeting Room</h5>
        
    </div>

    <div class="panel-body">
        <form action="<?php echo site_url('admin/meeting_rooms/update_meeting_room/' . $room->room_id); ?>" method="post">
            <input type="hidden" name="edit_type" value="meeting_room">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" value="<?php echo $room->name; ?>" required>
            </div>

            <div class="form-group">
                <label>Capacity:</label>
                <input type="number" name="capacity" class="form-control" value="<?php echo $room->capacity; ?>" required>
            </div>

            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" class="form-control"><?php echo $room->description; ?></textarea>
            </div>

            <div class="text-right">
                <a href="<?php echo site_url('admin/meeting_rooms'); ?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
