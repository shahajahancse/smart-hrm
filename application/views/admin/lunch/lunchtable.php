<table class="table" id="myTable" >
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Meal Qty</th>
            <th>Amount</th>
            <th>Remarks</th>
            <th style="text-align: right;">Action</th>

        </tr>
    </thead>
    <tbody>
        <?php  foreach ($payment_data as $key=>$row): ?>
        <tr>
            <td><?php echo $key+1; ?></td>
            <td><?php echo $row->date; ?></td>
            <td><?php echo $row->meal_qty; ?></td>
            <td><?php echo $row->amount;?></td>

            <?php if($row->remarks){ ?>
            <td  title="<?php echo $row->remarks; ?>">
                <?php echo implode(' ', array_slice(explode(' ', $row->remarks ), 0, 4)); ?></td>
            <?php }else{ ?>
            <td >...</td>
            <?php } ?>
            <td>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="actionButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu dropdown-menu-right list-group" aria-labelledby="actionButton">
                        <a class="dropdown-item list-group-item" onclick="edit_vendor_data(<?php echo $row->id;?>)"
                            class="btn btn-primary">Edit</a>
                        <a class="dropdown-item list-group-item" href="<?php echo base_url($row->file);?>"
                            class="btn btn-primary">View File </a>
                        <a class="dropdown-item list-group-item" href="<?php echo base_url($row->file);?>"
                            class="btn btn-primary" download>Download</a>
                    </div>
                </div>




            </td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/alfrcr/paginathing/dist/paginathing.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
    const listElement = $('.list-group');
    $('#myTable tbody').paginathing({
        perPage: 31,
        insertAfter: '.table',
        pageNumbers: true,
        limitPagination: 4,
        ulClass: 'pagination flex-wrap justify-content-center'
    });
});
</script>