
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
    z-index: 1;
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

/* Change the background color of the dropdown button when the dropdown content is shown */

    .table-hover {
        font-size: 14px;
    }

    .table-hover thead th {
        background-color:#6f7c8b;
        color: #fff;
        font-weight: bold;
        padding: 10px;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .table-hover tbody td {
        border-top: 1px solid #dee2e6;
        padding: 10px;
        text-align: center;
    }

    .table-hover tbody td:first-child {
        font-weight: bold;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination li {
        display: inline;
        margin: 0 5px;
    }

    .pagination li a,
    .pagination li span {
        color: #007bff;
        padding: 5px 10px;
        text-decoration: none;
        border: 1px solid #007bff;
        border-radius: 5px;
    }

    .pagination li.active span {
        background-color: #007bff;
        color: #fff;
    }

    .pagination li a:hover {
        background-color: #f8f9fa;
    }
</style>

<div class="container-fluid">
    <?php if($this->session->flashdata('message')):?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('message');?>
        </div>
    <?php endif; ?>  

    <div class="table-responsive">
        <table class="table table-hover">
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
                                    <a class="">Action <i class="fa-regular fa-caret-down"></i> </a>
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

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?= $pagination ?>
        </ul>
    </nav>
</div>
