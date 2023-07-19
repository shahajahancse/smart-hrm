<table class="table table-striped" style="border-top: 1px solid #d6d2d2;">
    <thead>
        <tr>
            <th class="p0">Sl</th>
            <th class="p0">Purpose Of Move</th>
            <th class="p0">Date</th>
            <th class="p0">Out Time</th>
            <th class="p0">In Time</th>
            <th class="p0">Total Time</th>
            <th class="p0">Place Address</th>
            <th class="p0">TA Bill Details</th>
        </tr>
    </thead>
    <tbody>
        <!-- [id] => 20
            [employee_id] => 2
            [date] => 2023-07-18
            [out_time] => 2023-07-18 14:37:26
            [in_time] => 2023-07-18 14:37:31
            [duration] => 0 day, 00:0:5
            [request_amount] => 0
            [payable_amount] => 0
            [status] => 1
            [astatus] => 1
            [reason] => option3
            [location_status] => 1
            [in_out] => 0
            [place_adress] => gb
            [updated_at] => 2023-07-18 14:37:31
            [created_at] => 2023-07-18 14:37:26 -->
        <?php foreach($alldata as $k=>$data){?>
        <tr>
            <td><?php echo $k+1; ?></td>
            <td><?php echo $data->reason; ?></td>
            <td><?php echo $data->date; ?></td>
            <td><?php echo $data->out_time; ?></td>
            <td><?php echo $data->in_time; ?></td>
            <td><?php echo $data->duration; ?></td>
            <td><?php echo $data->place_adress; ?></td>
            <td>
                <?php if($data->in_out==0){?>
                <a href="<?= base_url('admin/attendance/ta_da_form/').$data->id?>"> Details </a>
                <?php }else{ echo "Not Avalable";} ?>


            </td>
        </tr>
        <?php } ?>

    </tbody>
</table>

<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/alfrcr/paginathing/dist/paginathing.min.js"></script>
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