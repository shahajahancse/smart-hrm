<table class="table datatable-basic">
    <thead>
        <tr>
            <th>Room Name</th>
            <th>Employee</th>
            <th>Meeting Title</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Attendees</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($meetings as $meeting) { ?>
            <tr>
                <td><?php echo $meeting->room_name; ?></td>
                <td><?php echo $meeting->first_name . ' ' . $meeting->last_name; ?></td>
                <td><?php echo $meeting->meeting_title; ?></td>
                <td><?php echo $meeting->start_time; ?></td>
                <td><?php echo $meeting->end_time; ?></td>
                <td><?php echo $meeting->attendees; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
