<style>
    /* Custom styles for the table */
    .table-container {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .table-hover {
        font-size: 14px;
    }

    .table-hover thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #333;
        font-weight: bold;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }

    .table-hover tbody td {
        border-top: 1px solid #dee2e6;
    }

    .table-hover tbody td:first-child {
        font-weight: bold;
    }

    .pagination {
        display: inline-block;
        margin: 0;
        padding: 0;
    }

    .pagination li {
        display: inline;
    }

    .pagination li a,
    .pagination li span {
        color: #333;
        padding: 5px 10px;
        text-decoration: none;
        border: 1px solid #dee2e6;
        margin-left: -1px;
    }

    .pagination li.active span {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    .pagination li a:hover {
        background-color: #f8f9fa;
    }
</style>

<div class="container">
            <?php if($this->session->flashdata('message')):?>
                <div class="alert alert-success">
                  <?php echo $this->session->flashdata('message');?>
                </div>
            <?php endif; ?>  

    <div class="table-container">
        <h2>Lunch Records</h2>
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
                        <td><a href="<?= base_url('admin/lunch/details/'.$result->id.'/'.$result->date) ?>" class="btn btn-primary">Details</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?= $pagination ?>
            </ul>
        </nav>
    </div>
</div>
