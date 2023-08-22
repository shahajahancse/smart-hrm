
<style>
.table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ddd;
}

.table th,
.table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    font-weight: bold;
    background-color: #f2f2f2;
}

.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.table input[type="checkbox"] {
    transform: scale(1.5);
    margin-left: 5px;
}

/* Add transition for animation */
.table tbody tr {
    transition: all 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
</style>
<div class="box">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Active Lunch</th>
            </tr>
        </thead>
        <tbody id="activeList">
            <tr><td colspan="3" class="text-center text-primary">Active</td></tr>
            <!-- Active users rows will be appended here -->
        </tbody>
        <tbody id="inactiveList">
            <tr><td colspan="3" class="text-center text-danger">In Active</td></tr>
            <!-- Inactive users rows will be appended here -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function setlunch(e) {
    var status = e.dataset.status;
    var replace_status = (status == 1) ? 0 : 1;
    e.dataset.status = replace_status;

    var dataToSend = {
        replace_status: replace_status,
        id: e.id
    };
    var url = "<?= base_url('admin/lunch/change_lunch_status') ?>";
    
    var row = $(e).closest('tr');
    var isActive = replace_status == 1;

    if (isActive) {
        var destinationList = '#activeList';
        var destinationOffset = parseInt($('#activeList').offset().top + $('#activeList').outerHeight());
        console.log(destinationOffset);
    } else {
        var destinationList = '#inactiveList';
        var destinationOffset = $(destinationList).offset().top;
    }

    // Animate the row flying to its new position
    var originalOffset = row.offset().top;  
    var flyingRow = row.clone();
    flyingRow.css({
        'position': 'absolute',
        'top': originalOffset,
        'left': 300,
    });
    $('body').append(flyingRow);
    
    flyingRow.animate({
        'top': destinationOffset,
        'left': 300
    }, 300, function() {
        flyingRow.remove();
        row.remove();

        // Make the AJAX request
        $.ajax({
            url: url,
            type: "POST",
            data: dataToSend,
            success: function(response) {
                console.log(response);

                // Append the row to the new list
                $(destinationList).append(row);
                row.hide().slideDown();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
        });
    });
}

// Fetch user data from the server
$(document).ready(function() {
    $.ajax({
        url: "<?= base_url('admin/lunch/get_lunch_status') ?>",
        type: "GET",
        dataType: "json",
        success: function(data) {
            var activeCounter = 0;
            var inactiveCounter = 0;
            data.forEach(function(user) {
                var sl = '';
                if (user.active_lunch == 1) {
                    activeCounter++;
                    sl = activeCounter;
                } else {
                    inactiveCounter++;
                    sl = inactiveCounter;
                }
                var row = '<tr>' +
                          '<td>'+sl+'</td>' +
                          '<td>' + user.first_name + ' ' + user.last_name + '</td>' +
                          '<td><input onclick="setlunch(this)" id="' + user.user_id + '" data-status="' + (user.active_lunch==1 ? 1 : 0) + '" type="checkbox" ' + (user.active_lunch==1 ? 'checked' : '') + '></td>' +
                          '</tr>';

                if (user.active_lunch==1) {
                    $('#activeList').append(row);
                } else {
                    $('#inactiveList').append(row);
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error:", textStatus, errorThrown);
        }
    });
});
</script>
