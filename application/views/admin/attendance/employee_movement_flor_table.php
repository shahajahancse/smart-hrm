<table class="table table-striped" style="border-top: 1px solid #d6d2d2;">
    <thead>
        <tr>
            <th class="p0">Sl</th>
            <th class="p0">Date</th>
            <th class="p0">Out Time</th>
            <th class="p0">In Time</th>
            <th class="p0">Location</th>
            <th class="p0">Reason</th>
            <th class="p0">Meet With</th>

        </tr>
    </thead>
    <tbody>
        <?php  $i=1; foreach ($alldata as $key => $value) { 
            $out_time_array = json_decode($value->out_time);
            $in_time_array = json_decode($value->in_time);
            $location_array = json_decode($value->location);
            $reason_array = json_decode($value->reason);
            $meet_with = json_decode($value->meet_with);
            foreach ($out_time_array as $k => $outtime) { ?>
        <tr>
            <td><?= $i?></td>
            <td><?= $value->date?></td>
            <td class="p0"><?= $outtime?></td>
            <td class="p0"><?= (isset($in_time_array[$k])) ? $in_time_array[$k] : ''?></td>
            <td class="p0">
                <?= ($location_array[$k]==5) ? '5th Floor' : (($location_array[$k]==3) ? '3rd Floor' :'');?>
            </td>
            <?php $resonedata = $this->db->where('id', $reason_array[$k])->get('xin_employee_move_reason')->result();
                ?>
            <td class="p0"><?= $resonedata[0]->title?></td>
            <?php
                    $this->db->select('
                xin_employees.first_name,
                xin_employees.last_name
            ');
                $this->db->from('xin_employees');
                $this->db->where("xin_employees.user_id", $meet_with [$k]);
                $empn = $this->db->get()->result();
                ?>
            <td class="p0"><?= $empn[0]->first_name?> <?= $empn[0]->last_name?></td>
        </tr>
        <?php $i++; } ?>

        <?php } ?>
    </tbody>
</table>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/alfrcr/paginathing/dist/paginathing.min.js"></script>
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