<?php  foreach($alldata as $key=>$data){ ?>
<tr>
    <td><?= $key+1 ?></td>
    <td><?= $data->attendance_date ?></td>
    <td><?= ($data->clock_in=='')?'--:--:--':date('h:s A',strtotime($data->clock_in)) ?></td>
    <td><?= ($data->clock_out=='')?'--:--:--':date('h:s A',strtotime($data->clock_out)) ?></td>
    <td><?= $data->late_time ?></td>
    <td><?= $data->production ?></td>
    <td><?= 1?> hrs</td>
</tr>
<?php  }?>