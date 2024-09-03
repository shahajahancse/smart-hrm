<table class="table table-striped" style="border-top: 1px solid #d6d2d2;">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Application Date</th>
            <th>Leave Type</th>
            <th>From</th>
            <th>To</th>
            <th>No of Days</th>
            <th>Reason</th>
            <th>Management Comment</th>
            <th>Status</th>
            <th>Approved by</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <!-- admin/timesheet/leave_details/id/$data->leave_id/ -->
        <?php foreach($alldata as $key => $data){ $leave_status = ''; ?>
        <?php 
            if ($data->status == '1') {
                $leave_status = 'Pending';
            } else if($data->status == '2'){
                $leave_status = 'Approved';
            } else if($data->status == '3'){
                $leave_status = 'Rejected';
            } else {
                $leave_status = 'First Level Approval';
            }
        ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td>
            <?php echo date('d-F-Y H:i', strtotime($data->applied_on)); ?> -
            (<?=date('l', strtotime($data->applied_on)) ?>)
            </td>
            <td><?= ($data->leave_type_id == 1)? 'Casual Leave':'Medical Leave' ?></td>
            <td><?= ($data->from_date=='')? '-----' :date('d-M-Y',strtotime($data->from_date)) ?></td>
            <td><?= ($data->to_date=='')? '-----' :date('d-M-Y',strtotime($data->to_date)) ?></td>
            <td><?= $data->qty ?></td>
            <td><?= $data->reason ?></td>
            <td><?= $data->remarks ?></td>
            <td><?= $leave_status ?></td>

            <td>Admin</td>
            <td>
                <div class="btn-group" >
                  <button type="button" class="dropdown-toggle" data-toggle="dropdown" style="border: none; background: transparent;">
                    <span><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span> 
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                      <a href="<?= base_url('admin/timesheet/leave_details/id/'.$data->leave_id.'/')?>">
                        <b class="text-success">Details</b> </a>
                    </li>
                    <?php if ($data->status == '1') { ?>
                    <li class="divider"></li>
                    <li class="">
                      <a href="<?= base_url('admin/leave/leave_delete/'.$data->leave_id);?>"><b class="text-danger">Delete</b>
                      </a>
                    </li>
                    <?php } ?>
                  </ul>
                </div>

            </td>
        </tr>
        <?php  }?>

    </tbody>
</table>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/alfrcr/paginathing/dist/paginathing.min.js"></script>
<!--  <script type="text/javascript" src="../src/test.js"></script>-->
<!-- <script type="text/javascript">
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
</script> -->