<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Vehicle List</h3>
        <a href="<?= site_url('admin/vehicle/add') ?>" class="btn btn-primary mb-3 float-right">Add Vehicle</a>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Model</th>
                    <th>Tax Paid</th>
                    <th>Tax Paid Date</th>
                    <th>End Date</th>
                    <th>Fitness Description</th>
                    <th>Image</th>
                    <th>Driver</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vehicles as $key => $vehicle): ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $vehicle->name ?></td>
                    <td><?= $vehicle->model ?></td>
                    <td><?= $vehicle->tax_paid ?></td>
                    <td><?= $vehicle->tax_paid_date ?></td>
                    <td><?= $vehicle->end_date ?></td>
                    <td><?= $vehicle->fitness_description ?></td>
                    <td>
                        <?php if($vehicle->image): ?>
                        <img src="<?= base_url('uploads/vehicles/'.$vehicle->image) ?>" width="80">
                        <?php endif; ?>
                    </td>
                    <td><?= $vehicle->driver_id ?></td>
                    <td>
                        <a href="<?= site_url('admin/vehicle/edit/'.$vehicle->id) ?>"
                            class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('admin/vehicle/delete/'.$vehicle->id) ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this vehicle?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>