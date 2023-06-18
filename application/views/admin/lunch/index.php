
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
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
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
.dropdown-content a:hover {background-color: #f1f1f1}

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
                    <th>Sl</th>
                    <th>Total Meal</th>
                    <th>Employee Meal</th>
                    <th>Guest Meal</th>
                    <th>Total Cost</th>
                    <th>Employee Cost</th> 
                    <th>Guest Cost</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $key => $result) { ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $result->total_m ?></td>
                        <td><?= $result->emp_m ?></td>
                        <td><?= $result->guest_m ?></td>
                        <td><?= $result->total_cost ?></td>
                        <td><?= $result->emp_cost ?></td>
                        <td><?= $result->guest_cost ?></td>
                        <td><?= $result->date ?></td>
                        <td>
                            <?php if ($result->date == date('Y-m-d')) : ?>
                               <div class="dropdown">
                                    <a class="">Action <span><i class="fa fa-sort-desc" aria-hidden="true"></i></span> </a>
                                    <div class="dropdown-content">
                                       <a href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
                                        <a href="<?=  base_url('admin/lunch/today_lunch/'.$result->id)?>">Edit</a>
                                       
                                    </div>
                                </div>
                            <?php else : ?>
                                <a href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>">Details</a>
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