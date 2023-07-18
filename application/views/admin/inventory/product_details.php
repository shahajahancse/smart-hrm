<?php
// dd($results)

?>
<style>
    th, td {
        text-align: center !important;
    }
</style>

<table id="datatbale" style="width: 100%;" class="table">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Days</th>
            <th>Name</th>
            <th>quantity</th>
            <th>Approved Qty</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($results as $key=>$raw){?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= $raw->created_at ?></td>
            <?php $dateStr = $raw->created_at;
                            $date = strtotime($dateStr);
                            $dayName = date("l", $date); ?>
            <td><?= $dayName ?></td>
            <td><?= $raw->product_name ?></td>
            <td><?= $raw->quantity ?></td>
            <td><?= $raw->ap_quantity ?></td>

            <td><?php
                if(isset($raw->purchase_status)){
                    $type='in';
                    $class='style="color: blue;"';
                    $stat=$raw->purchase_status;
                   if($stat==1){
                    $status='Pending';
                }elseif($stat==2){
                    $status='Approved';
                }elseif($stat==3){
                    $status='Received';
                }else{
                    $status='Rejected';
                }
                }elseif(isset($raw->requisition_status)){
                    $class='style="color: red;"';
                    $type='out';
                    $stat=$raw->requisition_status;
                    if($stat==5){
                    $status='Fist Step Approved';
                }elseif($stat==1){
                    $status='Pending';
                }elseif($stat==2){
                    $status='Approved';
                }elseif($stat==3){
                    $status='Delivered';
                }else{
                    $status='Rejected';
                }
            }
                ?>
              <span <?= $class ?> >  <?=$type?></span>
              <span> (<?= $status ?>)</span>
            </td>
        </tr>
        <?php } ?>

    </tbody>
</table>
<script type="text/javascript">
$(document).ready(function() {

    $('#datatbale').DataTable();
});
</script>