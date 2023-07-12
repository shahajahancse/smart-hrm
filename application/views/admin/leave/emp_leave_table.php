<table class="table table-striped" style="border-top: 1px solid #d6d2d2;">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Leave Type</th>
            <th>From</th>
            <th>To</th>
            <th>No of Days</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Approved by</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <!-- admin/timesheet/leave_details/id/$data->leave_id/ -->
        <?php dd($alldata);  foreach($alldata as $key=>$data){ ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= ($data->leave_type_id == 1)? 'Casual Leave':'Medical Leave' ?></td>
            <td><?= ($data->from_date=='')? '-----' :date('d-M-Y',strtotime($data->from_date)) ?></td>
            <td><?= ($data->to_date=='')? '-----' :date('d-M-Y',strtotime($data->to_date)) ?></td>
            <td><?= $data->qty ?></td>
            <td><?= $data->reason ?></td>
            <td><?= ($data->status == 1) ? 'Pending' :
          ($data->status == 2) ? 'Approved' :
          ($data->status == 3) ? 'Rejected' :
          ($data->status == 4) ? 'First Level Approval' :
          ''; ?></td>

            <td>Admin</td>
            <td>
                <a href="<?= base_url('admin/timesheet/leave_details/id/'.$data->leave_id.'/')?>">
                Details
                </a>
            </td>
        </tr>
        <?php  }?>

    </tbody>
</table>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/alfrcr/paginathing/dist/paginathing.min.js"></script>
<!--  <script type="text/javascript" src="../src/test.js"></script>-->
<script type="text/javascript">
jQuery(document).ready(function($) {
    const listElement = $('.list-group');
    $('.table tbody').paginathing({
        perPage: 31,
        insertAfter: '.table',
        pageNumbers: true,
        limitPagination: 4,
        ulClass: 'pagination flex-wrap justify-content-center'
    });
});
</script>