<style>
/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: fixed;
    background-color: #f9f9f9;
    min-width: 120px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 999909;
    right: 25px;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
    background-color: #f1f1f1
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
    display: block;
}


</style>

<div class="container-fluid">
    <?php if($this->session->flashdata('message')):?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('message');?>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover" id="Lunch_table">
            <thead>
                <tr>
                    <th style="text-align:center">Sl</th>
                    <th style="text-align:center">Date</th>
                    <th style="text-align:center">Days</th>
                    <th style="text-align:center">Emp.Meal</th>
                    <th style="text-align:center">G.Meal</th>
                    <th style="text-align:center">Total Meal</th>
                    <th style="text-align:center">Emp.Cost</th>
                    <th style="text-align:center">G.Cost</th>
                    <th style="text-align:center">Office.Cost</th>
                    <th style="text-align:center">Total Cost</th>
                    <th style="text-align:center">Remarks</th>
                    <?php if( $session['role_id']==1): ?>
                    <th style="text-align:center">HR Edit</th>
                    <?php endif; ?>
              
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $key => $result) { ?>
                <tr>
                    <td style="text-align:center"><?= $key + 1 ?></td>
                    
                    <?php   $dateStr = $result->date;
                        $date = strtotime($dateStr);
                        $dayName = date("l", $date);
                        $convertedDate = date('d-m-Y', strtotime($dateStr));
                        ?>
                    <td style="text-align:center"><?= $convertedDate ?></td>

                    <td style="text-align:center"> <?= $dayName?></td>
                    <td style="text-align:center"><?= $result->emp_m ?></td>
                    <td style="text-align:center"><?= $result->guest_m ?></td>
                    <td style="text-align:center"><?= $result->total_m ?></td>
                    <td style="text-align:center"><?= $result->emp_cost ?></td>
                    <td style="text-align:center"><?= $result->guest_cost ?></td>
                    <td style="text-align:center"><?= $result->emp_cost+ $result->guest_cost ?></td>
                    <td style="text-align:center"><?= $result->total_cost * 2 ?></td>
                    <?php if ($result->bigcomment != null) : ?>
                    <td title="<?php echo $result->bigcomment; ?> " style="text-align:center">
                       <?php echo implode(' ', array_slice(explode(' ', $result->bigcomment), 0, 3)); ?>
                   </td>
                 <?php else : ?>
                    <td style="text-align:center">
                       <?php echo "...." ?>
                    </td>
                <?php endif; ?>
                <?php if( $session['role_id']==1): ?>
                <td>
                    <input type="checkbox" name="" class="chkbox" onchange='hrp(<?=$result->id?>,<?=$result->if_eidit?>)' <?= ($result->if_eidit==0)? '':'checked' ?> >
                </td>
                <?php endif; ?>

                

                   

               
                   
                    <td>
                        <?php  if ($result->date == date('Y-m-d')) : ?>
                        <div class="dropdown">
                            <a class="">Action <span><i class="fa fa-sort-desc" aria-hidden="true"></i></span> </a>
                            <div class="dropdown-content">
                                <a href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
                                <a href="<?=  base_url('admin/lunch/today_lunch/'.$result->id)?>">Edit</a>

                            </div>
                        </div>
                        <?php else : ?>
                                <?php if ($result->if_eidit==1 && $session['role_id']==4) : ?>
                                    <a href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
                                    <a href="<?=  base_url('admin/lunch/today_lunch/'.$result->id)?>">Edit</a>
                             
                                
                                <?php elseif($session['role_id']==1 || $session['role_id']==2) : ?>
                                    <a href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
                                    <a href="<?=  base_url('admin/lunch/today_lunch/'.$result->id)?>">Edit</a>
                                <?php else : ?>
                                    <a href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
                                <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    //Load First row

    $('#Lunch_table').DataTable();
});
</script>
<script>
  function hrp(id,status) {
   console.log(id,status);
   $.ajax({
            url: '<?= base_url('admin/lunch/sethrp') ?>', // Replace with the URL to send the request
            method: 'POST', // Replace with the desired HTTP method (POST, GET, etc.)
            data: {
                id: id,
                status: status,
            },
            success: function(response) {
                console.log(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log(error);
           

            }
        });
    
  }
</script>