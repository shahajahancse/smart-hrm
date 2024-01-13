<?php

if(count($alld)>0){
$dataall=$alld[0];
// dd($dataall);
}else{
    echo"there are no records";
    exit();
}
$g_place=json_decode($dataall->g_place);
$g_transportation=json_decode($dataall->g_transportation);
$g_costing=json_decode($dataall->g_costing);
$c_place=json_decode($dataall->c_place);
$c_transportation=json_decode($dataall->c_transportation);
$c_costing=json_decode($dataall->c_costing);
// [additional_cost] => 067
// [costing_invoice] => http://localhost/smart-hrm/uploads/move_file/06c611e9ee3f2330bb7eea8e91265f69.jpg
// [request_amount] => 1559
// [payable_amount] => 0

// [remark] => ftgh
    $status = $dataall->status;
    $statusMessage = '';
    switch ($status) {
        case 0:
            $statusMessage = '<span class="pending"><i class="fa fa-dot-circle-o" style="color:black"></i> Not Applied</span>';
            break;
        case 1:
            $statusMessage = '<span class="complet"><i class="fa fa-dot-circle-o" style="color:green"></i>In Process</span>';
            break;
        case 2:
            $statusMessage = '<span class="complet"><i class="fa fa-dot-circle-o" style="color:green"></i>Approved</span>';
            break;
        case 3:
            $statusMessage = '<span class="pending"><i class="fa fa-dot-circle-o" style="color:red"></i>Reject</span>';
            break;
        case 4:
            $statusMessage = '<span class="pending"><i class="fa fa-dot-circle-o" style="color:green"></i>Pay</span>';
            break;
        case 5:
            $statusMessage = '<span class="pending"><i class="fa fa-dot-circle-o" style="color:green"></i>First Step Approved </span>';
            break;
    }
?>
<style>
.basic_information {
    padding: 11px;
    border-radius: 5px;
    margin-top: 15px;
    box-shadow: 2px 2px 11px 0px #b3b0b0;
}

.tt {
    font-size: 16px;
    font-weight: bold;
    width: 117px;
}

.heder {
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    font-family: sans-serif;
    border-bottom: 2px solid #9c9999;
}

thead {
    background: #f3f3f3;
}
th{
    text-align: center;
}
td{
    text-align: center;
}
</style>
<div class="col-md-12">
    <div class="col-md-12 basic_information">
        <table class="col-md-6">
            <tbody>
                <tr>
                    <td class="tt">Full Name :</td>
                    <td><?=$dataall->first_name?> <?=$dataall->last_name?></td>
                </tr>
                <tr>
                    <td class="tt">Out Time :</td>
                    <td><?=$dataall->out_time?></td>
                </tr>
                <tr>
                    <td class="tt">Duration : </td>
                    <td><?=$dataall->duration?></td>
                </tr>
                <tr>
                    <td class="tt">Reason : </td>
                    <td><?=$dataall->reason?></td>
                </tr>
            </tbody>
        </table>
        <table class="col-md-6">
            <tbody>
                <tr>
                    <td class="tt">Date : </td>
                    <td><?=$dataall->date?></td>
                </tr>
                <tr>
                    <td class="tt">In Time :</td>
                    <td><?=$dataall->in_time?></td>
                </tr>
                <tr>
                    <td class="tt">Status :</td>
                    <td><?=$statusMessage?></td>
                </tr>
                <tr>
                    <td class="tt">Status :</td>
                    <td><?=($dataall->location_status==1)?'Outside Office' : 'Outside Dhaka' ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" name="" id="moveid" value="<?= $dataall->move_id ?>">
    <?php if($dataall->in_out==0){?>
    <div class="col-md-12" style=" padding: 0;gap: 16px;display: flex;">
        <div class="col-md-6 basic_information">
            <div class="heder">
                <span>Going Way</span>
            </div>
            <div class="col-md-12" style="padding: 0;">
                <table class="col-md-12">
                    <thead>
                        <tr>
                            <th>
                                Place
                            </th>
                            <th>
                                Transportation
                            </th>
                            <th>
                                Cost
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($g_place as $key => $value){ ?>
                        <tr>
                            <td><?= $value ?></td>
                            <td><?= $g_transportation[$key] ?></td>
                            <td><?= $g_costing[$key] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6 basic_information">
            <div class="heder">
                <span>Coming Way</span>
            </div>
            <div class="col-md-12" style="padding: 0;">
                <table class="col-md-12">
                    <thead>
                        <tr>
                            <th>
                                Place
                            </th>
                            <th>
                                Transportation
                            </th>
                            <th>
                                Cost
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($c_place as $k => $v){ ?>
                        <tr>
                            <td><?= $v ?></td>
                            <td><?= $c_transportation[$k] ?></td>
                            <td><?= $c_costing[$k] ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12" style="padding: 0;gap: 16px;display: flex;margin-bottom: 14px;">
        <div class="col-md-6 basic_information">
            <div class="heder">
                <span>Additional</span>
            </div>
            <div class="col-md-12" style="padding: 10px;">
                <div class="col-md-6" style="padding: 0;">
                    <span style="font-size: 15px;font-weight: bold;">Additional Cost : </span>
                    <span><?= $dataall->additional_cost ?></span>
                </div>
                <div class="col-md-6" style="padding: 0;">
                    <span style="font-size: 15px;font-weight: bold;">File : </span>
                    <a class="btn" style="padding: 0px 7px !important;" href="<?= $dataall->costing_invoice ?>"
                        target="_blank">View</a>
                    <a class="btn" style="padding: 0px 7px !important;" href="<?= $dataall->costing_invoice ?>"
                        download>Download</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 basic_information">
            <div class="heder">
                <span>Total</span>
            </div>
            <div class="col-md-12" style="padding: 8px;">
                <table  class="col-md-12" style="padding: 8px;">
                    <thead>
                        <tr>
                            <th>
                                Requested
                            </th>
                            <th>
                                Payable
                            </th>
                            <th>
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?= $dataall->request_amount ?>
                            </td>
                            <td>
                                <input type="number" id="payam" value="<?= $dataall->payable_amount ?>" style="border-radius: 4px;text-align: center;width: 118px;" <?= ($st=='e')? '':'readonly' ?> >
                            </td>
                            <td>
                                <select  id="sta" style="border-radius: 4px;text-align: center;width: 118px;" onchange="return_change()">
                                    <option  value="1"  <?= ($dataall->status==1)? 'selected':''?> >Pending</option>
                                    <option value="3"  <?= ($dataall->status==3)? 'selected':'' ?> >Rejected</option>
                                    <option  value="5"  <?= ($dataall->status==5)? 'selected':'' ?> >First Step Approved</option>
                                    <option  value="2"  <?= ($dataall->status==2)? 'selected':'' ?> >Approved</option>
                                    <option value="4"   <?= ($dataall->status==4)? 'selected':'' ?> >Pay</option>
                                    <option value="6"   <?= ($dataall->status==6)? 'selected':'' ?> >Return for Correction</option>
                                </select>
                                <textarea type="text" id="return_comment" style="display: none" >  <?= $dataall->return_comment ?> </textarea>
                            </td>
                            <script>
                                function return_change(){
                                    var staValue = document.getElementById("sta").value;
                                    if (staValue==6){
                                        document.getElementById("return_comment").style.display = "block";
                                    }else{
                                        document.getElementById("return_comment").style.display = "none";
                                    }
                                }
                            </script>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>

</div>