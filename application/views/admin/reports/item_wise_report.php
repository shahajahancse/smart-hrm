<?php
// Split results
// dd($results);
    $inReports = [];
    $outReports = [];
    foreach ($results as $item) {
        if (isset($item->purchase_status)) {
            $inReports[] = $item;
        } elseif (isset($item->requisition_status)) {
            $outReports[] = $item;
        }
    }
    $totalIn = 0;
    foreach ($inReports as $in) {
        if (isset($in->purchase_status) && $in->purchase_status == 3) {
            $totalIn += $in->ap_quantity;
        }
    }
    
    $totalOut = 0;
    foreach ($outReports as $out) {
        if (isset($out->requisition_status) && $out->requisition_status == 3) {
            $totalOut += $out->ap_quantity;
        }
    }

    $netQty = $totalIn - $totalOut;
    // dd($totalIn.'=='.$totalOut.'=='. $netQty);
    // Fetch product info
    $product_info = $this->db->select('products.quantity,product_unit.unit_name')
        ->from('products')
        ->join('product_unit', 'product_unit.id = products.unit_id')
        ->where('products.id', $results[0]->id ?? 0)
        ->get()->row();

    $product_name = $results[0]->product_name ?? '';
    $current_qty = $product_info->quantity ?? 0;
    $unit_name = $product_info->unit_name ?? '';
?>

<style>
    h5 {
        margin: 0;
        padding: 0;
    }
    .flex-container {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        justify-content: space-around;
    }
    .report-box {
        width: 48%;
    }
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        font-size: 12px;
    }
    th {
        background: #f2f2f2;
    }
</style>

<?php if (empty($results)) : ?>
    <h3 style='color:red;text-align:center'>No data found</h3>
<?php else: ?>
    <?php $this->load->view('admin/head_bangla'); ?>

    <?php if ($first_date && $second_date): ?>
        <h5 style='text-align:center;margin-top:10px'>Report on : <?= $first_date ?> to <?= $second_date ?></h5>
    <?php endif; ?>

    <h5 style="text-align:center;margin-top:10px">
        Product Name: <span style="color: #0073cd;font-weight: bold;"><?= $product_name ?></span>,
        Product Quantity from <?= $first_date ?> to <?= $second_date ?>  : <?= $netQty?> 
    </h5>
    <h5 style="text-align:center;margin-top:10px">
        Current Quantity: <span style="color: #0073cd;font-weight: bold;"><?= $current_qty ?> <?= $unit_name ?></span>
    </h5>

    <div class="flex-container">
        <!-- IN REPORT -->
        <div class="report-box">
            <h5 style="color:blue">In Report</h5>
            <table >
                <thead>
                    <tr>
                        <th style="font-size:10px">SL</th>
                        <th style="font-size:10px">Date</th>
                        <th style="font-size:10px">Req Person</th>
                        <th style="font-size:10px">Quantity</th>
                        <th style="font-size:10px">App Qty</th>
                        <!-- <th style="font-size:10px">Remarks</th> -->
                        <th style="font-size:10px">Prev Qty</th>
                        <th style="font-size:10px">Current Qty</th>
                        <th style="font-size:10px">Status</th>
                        <th style="font-size:10px">Accepted By</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // $totalIn = 0;
                foreach ($inReports as $key => $raw):
                    // $totalIn += $raw->ap_quantity;
                    $user = $this->db->select('first_name,last_name')->from('xin_employees')->where('user_id', @$raw->user_id)->get()->row();
                    $accepted_user = $this->db->select('first_name,last_name')->from('xin_employees')->where('user_id', @$raw->updated_by)->get()->row();
                ?>
                    <tr style="font-size:10px">
                        <td><?= $key + 1 ?></td>
                        <td><?= htmlspecialchars($raw->created_at) ?></td>
                        <td><?= @$user->first_name . ' ' . @$user->last_name ?></td>
                        <td><?= $raw->quantity ?></td>
                        <td><?= $raw->ap_quantity ?></td>
                        <!-- <td>< ?= htmlspecialchars(@$raw->note) ?></td> -->
                        <td><?= $raw->prev_quantity ?></td>
                        <td><?= $raw->current_quantity ?></td>
                        <td><b style="color:blue">In</b> (<?= ['Pending', 'Approved', 'Received', 'Rejected'][$raw->purchase_status - 1] ?? 'Unknown' ?>)</td>
                        <td><?= @$accepted_user->first_name . ' ' . @$accepted_user->last_name ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">Total In: <?= $totalIn ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- OUT REPORT -->
        <div class="report-box">
            <h5 style="color:red">Out Report</h5>
            <table>
                <thead>
                    <tr style="font-size:10px">
                        <th style="font-size:10px" >SL</th>
                        <th style="font-size:10px" >Date</th>
                        <th style="font-size:10px" >Req Person</th>
                        <th style="font-size:10px" >Quantity</th>
                        <th style="font-size:10px" >App Qty</th>
                        <th style="font-size:10px" >Remarks</th>
                        <th style="font-size:10px" >Prev Qty</th>
                        <th style="font-size:10px" >Current Qty</th>
                        <th style="font-size:10px" >Status</th>
                        <th style="font-size:10px" >Accepted By</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // $totalOut = 0;
                foreach ($outReports as $key => $raw):
                    // $totalOut += $raw->ap_quantity;
                    $user = $this->db->select('first_name,last_name')->from('xin_employees')->where('user_id', $raw->user_id)->get()->row();
                    $accepted_user = $this->db->select('first_name,last_name')->from('xin_employees')->where('user_id', $raw->updated_by)->get()->row();
                ?>
                    <tr style="font-size:10px">
                        <td><?= $key + 1 ?></td>
                        <td><?= htmlspecialchars($raw->created_at) ?></td>
                        <td><?= $user->first_name . ' ' . $user->last_name ?></td>
                        <td><?= $raw->quantity ?></td>
                        <td><?= $raw->ap_quantity ?></td>
                        <td><?= htmlspecialchars($raw->note) ?></td>
                        <td><?= $raw->prev_quantity ?></td>
                        <td><?= $raw->current_quantity ?></td>
                        <td><b style="color:red">Out</b> (<?= [
                            5 => 'First Step Approved',
                            1 => 'Pending',
                            2 => 'Approved',
                            3 => 'Delivered',
                            4 => 'Rejected'
                        ][$raw->requisition_status] ?? 'Unknown' ?>)</td>
                        <td><?= $accepted_user->first_name . ' ' . $accepted_user->last_name ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">Total Out: <?= $totalOut ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php endif; ?>
