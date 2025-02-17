<?php $session = $this->session->userdata('username');?>

<div class="table-responsive" style="padding: 25px;box-shadow: 0px 0px 8px 1px #d0d0d0;border-radius: 7px;">
    <table id="table_data" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee Name</th>
                <th>Request Date</th>
                <th>Request Time</th>
                <th>Request Status</th>
                <th>Request Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($alldata as $key => $request) { 
//                 dd($request);
//                 stdClass Object
// (
//     [id] => 2
//     [employee_id] => 58
//     [proxi_id] => 50
//     [punch_type] => in
//     [p_date] => 2024-07-08
//     [p_time] => 09:40:00
//     [status] => 0
//     [first_name] => Md.
//     [last_name] => Ahaduzzaman
// )
                
                ?>
            <tr>
                <td><?= $key+1 ?></td>
                <td><?= $request->first_name.' '.$request->last_name ?></td>
                <td><?= $request->p_date ?></td>
                <td><?= $request->p_time ?></td>
                <td><?= $request->status == 0 ? 'Pending' : 'Approved' ?></td>
                <td><?= $request->punch_type == 'in' ? 'In' : 'Out' ?></td>
                <td class="status_action">
                    <?php if($request->status == 0) { ?>
                        <?php if ($session['role_id']==1) {?>
                            <a href="javascript:void(0)" onclick="accept_request('<?= $request->id ?>',this)" class="btn btn-primary btn-sm">Approve</a>
                        <?php } ?>
                    <a href="javascript:void(0)" onclick="reject_request('<?= $request->id ?>',this)" class="btn btn-danger btn-sm">Reject</a>
                    <?php }elseif($request->status == 1){ echo '<span class="badge badge-success">Approved </span>'; }elseif($request->status == 2){ echo '<span class="badge badge-danger">Rejected </span>'; }?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
   
</div>

<script>
    $(document).ready(function() {
        $('#table_data').DataTable();
    });

    function accept_request(id, el) {
        $.ajax({
            url: '<?= base_url("admin/attendance/accept_request") ?>',
            type: 'POST',
            data: {
                id: id
            },
            success: function(data) {
                $(el).closest('.status_action').html('<span class="badge badge-success">Approved </span>');
                alert('Request Accepted');
            }
        });
    }

    function reject_request(id, el) {
        $.ajax({
            url: '<?= base_url("admin/attendance/reject_request") ?>',
            type: 'POST',
            data: {
                id: id
            },
            success: function(data) {
                $(el).closest('.status_action').html('<span class="badge badge-danger">Rejected </span>');
                alert('Request Rejected');
            }
        });
    }
</script>
