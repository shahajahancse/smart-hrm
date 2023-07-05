<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<?php
// dd($result);
?>
<style>
.addbox {
    min-height: 49px;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    line-height: 1.5;
}

.panels {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.6s ease-out;
}

.payment_box {
    opacity: 0;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    transition: max-height 0.2s ease-out, opacity 0.2s ease-out;
}

.p {
    margin: 0 !important;
    padding: 0 !important;
}

.btn {
    float: right;
    padding: 5px;
    font-weight: bold;
}

.panels.open {
    max-height: 1000px;
    margin-top: 11px;
    margin-bottom: 13px;
    opacity: 1;
    transition: max-height .6s ease-out, opacity .6s ease-out;
}

.section_box {
    width: 100%;
    background: #fffcf9;
    height: fit-content;
    margin: 3px;
    padding: 13px;
    border-radius: 5px;
    box-shadow: inset 5px 3px 20px 7px rgb(0 0 0 / 10%);
    overflow: auto;
}

.section-heding {
    font-weight: bold;
    font-size: 19px;
}

.list_box {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    color: #333;
}

.levels {
    font-size: 13px;
    font-weight: bold;
}
</style>

<!-- Modal -->
<div class="modal fade" id="make_payment" tabindex="-1" role="dialog" aria-labelledby="make_payment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle" style="float: left">Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"style="float: right">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow: auto; padding:0px;">
                <input type="hidden" id="rawid" value="">
                <input type="hidden" id="prepaid" value="">
                <div class="form-group col-md-4" style="padding-top: 7px">
                    <label for="deu_amount">Deu Amount</label>
                    <input type="number" class="form-control" id="deu_amount" placeholder="Amount" style="border-radius: 5px" disabled >
                </div>
                <div class="form-group  col-md-4" style="padding-top: 7px">
                    <label for="paid_amount">Amount</label>
                    <input type="number" onchange=changpayment() class="form-control" id="paid_amount" placeholder="Amount" style="border-radius: 5px">
                </div>
                <div class="form-group  col-md-4" style="padding-top: 7px" >
                    <label for="present_deu">Deu</label>
                    <input type="number" class="form-control" id="present_deu" placeholder="Amount" disabled style="border-radius: 5px">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="mcloss" data-dismiss="modal" style="margin-right:3px;">Close</button>
                <button type="button" onclick="make_id_payment()" class="btn btn-primary" style="margin-right:3px;">Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="addbox">
    <p class="p" style="font-size: 25px; font-weight: bold; float: left;">Payment List</p>
    <a class="btn btn-primary accordion" onclick="togglePaymentBox()">Make Payment</a>
</div>

<div class="panels payment_box" id="paymentBox">
    <section class="section_box">
        <div class="col-md-12">
            <div class="form-group col-md-3">
                <p class="levels"> Date</p>
                <input type="date" class="form-control" style="border-radius: 6px;" value="<?= date('Y-m-d')?>" disabled>
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Total Meal</p>
                <input type="number" id="total_meal" class="form-control" style="border-radius: 6px;" >
            </div>     
            <div class="form-group col-md-2">
                <p class="levels">Total Amount</p>
                <input type="number" id="total_meal" class="form-control" style="border-radius: 6px;" >
            </div>
            <div class="form-group col-md-12">
                <p class="levels">Remarks</p>
                <textarea name="" id="remarks" style="width: 100%; height: 104px;"></textarea>
             
            </div>
            
        </div>
        <div class="col-md-12">
            <a onclick="submit()" class="btn btn-primary" style="float: right;margin-right: 19px;">Submit</a>
        </div>
    </section>


</div>
<div class="list_box">
    <table class="table" id="myTable" style="text-align: center;">
        <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>P.Due</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Total Meal</th>
                <th>Pay Amount</th>
                <th>Net Payment</th>
                <th>Paid Amount</th>
                <th>Due</th>
                
                <th>Remarks</th>

                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($payment_data as $key=>$row): ?>
            <tr>
                <td><?php echo $key+1 ?></td>
                <?php    $convert = date('d-m-Y', strtotime($row->date)); ?>
                <td><?php echo $convert; ?></td>
                <td><?php echo $row->previous_due; ?></td>
                <?php   
                $convertedDate = date('d-m-Y', strtotime($row->from_date));
                $convertedDate2 = date('d-m-Y', strtotime($row->to_date));
                ?>
                <td><?php echo $convertedDate  ?></td>
                <td><?php echo  $convertedDate2 ?></td>
                <td><?php echo $row->total_meal; ?></td>
                <td><?php echo $row->pay_amount; ?></td>
                <td><?php echo $row->net_payment; ?></td>
                <td><?php echo $row->paid_amount; ?></td>
                <td><?php echo $row->due; ?></td>
            
                <?php if($row->Remarks){  ?>
                  <td style="text-align: center;" title="<?php echo $row->Remarks; ?>"><?php echo implode(' ', array_slice(explode(' ', $row->Remarks ), 0, 4)); ?></td>
                 <?php }else{ ?>
                    <td style="text-align: center;" > ...</td>
                 <?php } ?>
                <td>
                    <?=($row->status==0)? '<a data-toggle="modal" data-target="#make_payment" onclick="giveid('.$row->id.','.$row->due .','.$row->paid_amount.')" class="btn btn-primary">Paid</a>': 'Paid'?>
                </td>
                
 

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
<script>
    function togglePaymentBox() {
    var paymentBox = document.getElementById('paymentBox');
    paymentBox.classList.toggle('open');
}

</script>