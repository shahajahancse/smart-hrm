<table class="table table-responsive table-striped" style="border-top: 1px solid #d6d2d2;">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Date</th>
            <th>Punch In</th>
            <th>Punch Out</th>
            <th>Late</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($alldata as $key=>$data){ 

            $s=$data->status;
            if ($data->attendance_date==date('Y-m-d')) {
                $s='Continue';
            }
            ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= $data->attendance_date ?></td>
            <td><?= ($data->clock_in=='')? $s :date('h:i A',strtotime($data->clock_in)) ?></td>
            <td><?= ($data->clock_out=='')? $s :date('h:i A',strtotime($data->clock_out)) ?></td>
            <td><?= $data->late_time ?></td>
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