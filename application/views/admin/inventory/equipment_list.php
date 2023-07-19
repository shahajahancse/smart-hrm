<table class="datatables-demo table table-striped table-bordered" id="equipment_list" style="width:100%;">
<thead>
    <tr>
    <th class="text-center">No.</th>
    <th class="text-center">Equipment Name</th>
    <th class="text-center">MHL Code</th>
    <th class="text-center">Provide Date</th>
    <th class="text-center">Using Days</th>
    <th class="text-center">Provide By</th>
    <th class="text-center">Status</th>
    </tr>
</thead>

<tbody>
    <?php  if($session['role_id']==3){ foreach ($equipments as $key => $rows){ ?>
        <tr>  
        <td class="text-center"><?php echo ($key+1)."."; ?></td>
        <td class="text-center"><?php echo $rows->model_name ?></td>
        <td class="text-center"><?php echo "MHL-".$rows->device_name_id ?></td>
        <td class="text-center"><?php echo ($key+1)."."; ?></td>
        <td class="text-center"><?php echo ($key+1)."."; ?></td>
        <td class="text-center"><?php echo $rows->status ; ?></td>
        <td class="text-center">
            <?php echo ($rows->status == 1 ? "<span class='using'><i class='fa fa-dot-circle-o' style='color:green'></i>Using</span>" : "<span class='return'><i class='fa fa-dot-circle-o' style='color:#FF715B'></i>Return</span>"  );  ?>
        </td>
        </tr>
    <?php  }}?>
</tbody>


</table>