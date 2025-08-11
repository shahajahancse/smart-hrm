<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Vehicle List</h3>
        <a href="<?= site_url('admin/vehicle') ?>" class="btn btn-primary mb-3 float-right">Vehicle List</a>
    </div>
    <div class="box-body">



        <form action="<?= site_url('admin/vehicle/update/'.$vehicle->id) ?>" method="post"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Vehicle Name</label>
                        <input type="text" name="name" value="<?= $vehicle->name ?>" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Model</label>
                        <input type="text" name="model" value="<?= $vehicle->model ?>" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tax Paid</label>
                        <select name="tax_paid" class="form-control">
                            <option value="Yes" <?= $vehicle->tax_paid == 'Yes' ? 'selected' : '' ?>>Yes</option>
                            <option value="No" <?= $vehicle->tax_paid == 'No' ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tax Paid Date</label>
                        <input type="date" name="tax_paid_date" value="<?= $vehicle->tax_paid_date ?>" class="form-control">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" value="<?= $vehicle->end_date ?>" class="form-control">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Fitness Description</label>
                        <textarea name="fitness_description"
                            class="form-control"><?= $vehicle->fitness_description ?></textarea>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Driver</label>
                        <select name="driver_id" class="form-control">
                            <?php foreach($all_employees as $emp): ?>
                            <option value="<?= $emp->user_id ?>" <?= $vehicle->driver_id == $emp->user_id ? 'selected' : '' ?>>
                                <?= $emp->first_name ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Current Image</label><br>
                        <?php if($vehicle->image): ?>
                        <img src="<?= base_url('uploads/vehicles/'.$vehicle->image) ?>" width="100">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Change Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Vehicle</button>
        </form>

    </div>
</div>