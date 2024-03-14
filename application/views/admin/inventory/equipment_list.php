<?php 
// dd($equipments); 
?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<div class="card <?php echo $get_animate;?>" style="margin-left:15px;margin-top:15px;margin-right: 15px;border-radius: 0px;">
  <div class="card-body">
    <h4>Coming Soon</h4>
<!-- <table class="datatables-demo table table-striped table-bordered" id="equipment_list" style="width: 100%;background: white;margin-left: 0px;">
    <thead>
        <tr>
        <th class="text-center" style="width: 50px;">No.</th>
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
            <td class="text-center"><?php echo $rows->cat_name ?></td>
            <td class="text-center"><?php echo "MHL-".$rows->device_name_id ?></td>
            <td class="text-center"><?php echo date('d M Y')?></td>
            <?php
                    $startDate = $rows->provide_date; 
                    $endDate = date('Y-m-d'); 
                    $start = new DateTime($startDate);
                    $end = new DateTime($endDate);
                    $interval = $start->diff($end);
                    $differenceInDays = $interval->days;
            ?>
            <td class="text-center"><?php echo $differenceInDays; ?></td>
            <td class="text-center"><?php echo $rows->first_name.' '.$rows->last_name ; ?></td>
            <td class="text-center">
                <?php echo ($rows->status == 1 ? "<span class='using'><i class='fa fa-dot-circle-o' style='color:green'></i>Using</span>" : "<span class='return'><i class='fa fa-dot-circle-o' style='color:#FF715B'></i>Return</span>"  );  ?>
            </td>
            </tr>
        <?php  }}?>
    </tbody>
</table> -->
    </div>
</div>

<script>
    $('#equipment_list').DataTable();
</script>    


