<?php
 //dd($results)

?>
<style>
    h5{
        margin:0;
        padding:0;
    }
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  align:center;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
  font-size: 12px;
}
</style>
<!-- < ?php dd($first);?> -->
<?php   if(empty($results)){ 
            echo "<h3 style='color:red;text-align:center'>No data found</h3>"; 
        } else{ $this->load->view('admin/head_bangla'); 
    if($first_date !='' && $second_date != ''){
        echo "<h5 style='text-align:center;margin-top:10px'>Report on : ".$first_date.' to '.$second_date.'</h5>'; 
    }        
?>

 <h5 style="text-align:center;margin-top:10px">Product Name : <?php if(count($results) > 0) {
    $product_qty = $this->db->select('products.quantity,product_unit.unit_name')
                            ->from('products')
                            ->join('product_unit','product_unit.id = products.unit_id')
                            ->where('products.id',$results[0]->id)->get()->row();
    echo '<span style="color: #0073cd;font-weight: bold;">'.$results[0]->product_name.'</span>' ;
 }?>, Current Quantity : <?php echo '<span style="color: #0073cd;font-weight: bold;">'.$product_qty->quantity.'</span>'.' <span  style="color: #0073cd;font-weight: bold">'.$product_qty->unit_name.'</span>'?> </h5>

<table id="datatbale" style="width: 96%;margin:0 auto;margin-top:10px" border="1">
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Requested person</th>
            <!-- <th>Days</th> -->
            <th>Quantity</th>
            <th>Approved Qty</th>
            <th>Remarks</th>
            <th>Status</th>
            <th>Accepted By</th>
        </tr>
    </thead>
    <tbody>
        <?php
         $totalIn = 0; 
         $totalOut = 0;
        foreach($results as $key=>$raw){
           
            if (isset($raw->purchase_status) && $raw->purchase_status == 3) {
                $totalIn += $raw->ap_quantity;
            } 
            if (isset($raw->requisition_status) && $raw->requisition_status == 3) {
                $totalOut += $raw->ap_quantity;
            }
        ?>
        <tr>
            <td><?= $key+1 ?></td>
            <td><?= $raw->created_at ?></td>
            <td><?php
            $user_id= @$raw->user_id;
            $user = $this->db->select('first_name,last_name')->from('xin_employees')->where('user_id',$user_id)->get()->row();
            if(isset($user->first_name)){
                echo $user->first_name.' '.$user->last_name;
            }
            ?></td>

            <?php $dateStr = $raw->created_at;
                            $date = strtotime($dateStr);
                            $dayName = date("l", $date); ?>
            <!-- <td>< ?= $dayName ?></td> -->
            <td><?= $raw->quantity ?></td>
            <td><?= $raw->ap_quantity ?></td>
            <td><?= @$raw->note ?></td>

            <td><?php
                if(isset($raw->purchase_status)){
                    $type='In';
                    $class='style="color: blue;font-width:bold"';
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
              <span <?= $class ?> >  <b><?=$type?></b></span>
              <span> <b>(<?= $status ?>)</b></span>
              <span><td><?php
            $user_id= @$raw->updated_by;
            $user = $this->db->select('first_name,last_name')->from('xin_employees')->where('user_id',$user_id)->get()->row();
            if(isset($user->first_name)){
                echo $user->first_name.' '.$user->last_name;
            }
            ?></td></span>
            </td>
        </tr>
        <?php 


        } ?>

    </tbody>
     <tfoot>
        <tr>
            <?php
            $totalColumns = 5; // Set the total number of columns in your table
            $colspan1 = ceil($totalColumns / 2);
            $colspan2 = $totalColumns - $colspan1;
            ?>
            <td colspan="<?php echo $colspan1; ?>">Total In: <?php echo @$totalIn; ?></td>
            <td colspan="<?php echo $colspan2; ?>">Total Out: <?php echo @$totalOut; ?></td>
        </tr>
    </tfoot>
</table>
<?php }?>
