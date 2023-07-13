<table class="table table-striped" style="border-top: 1px solid #d6d2d2;">
    <thead>
        <tr>
            <th class="p0">Sl</th>
            <th class="p0">Date</th>
            <th class="p0">Out Time</th>
            <th class="p0">In Time</th>
            <th class="p0">Location</th>
            <th class="p0">Meet With</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alldata as $key => $value) { 
          $out_time_array = json_decode($value->out_time);
          $in_time_array = json_decode($value->in_time);
          $location_array = json_decode($value->location);
          $reason_array = json_decode($value->reason);
          foreach ($out_time_array as $k => $outtime) { ?>
           <tr>
            <td><?= $k+1?></td>
            <td><?= $value->date?></td>
            <td class="p0"><?= $outtime?></td>
            <td class="p0"><?= $in_time_array[$k]?></td>
            <td class="p0"><?= ($location_array[$k]==1) ? '5th Floor' : (($location_array[$k]==2) ? '3rd Floor' : 'Out Side');?></td>
            <td class="p0"><?= $reason_array[$k]?></td>
            </tr>
        <?php } ?>
    
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