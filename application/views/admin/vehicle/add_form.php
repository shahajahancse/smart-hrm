<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Vehicle List</h3>
        <a href="<?= site_url('admin/vehicle') ?>" class="btn btn-primary mb-3 float-right">Vehicle List</a>
    </div>
    <div class="box-body">



        <form action="<?= site_url('admin/vehicle/add') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group col-md-3">
                <label>Vehicle Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group col-md-3">
                <label>Model</label>
                <input type="text" name="model" class="form-control" required>
            </div>

            <div class="form-group col-md-3">
                <label>Tax Paid</label>
                <select name="tax_paid" class="form-control">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label>Tax Paid Date</label>
                <input type="date" name="tax_paid_date" class="form-control">
            </div>

            <div class="form-group col-md-3">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control">
            </div>

            <div class="form-group col-md-3">
                <label>Fitness Description</label>
                <textarea name="fitness_description" class="form-control"></textarea>
            </div>

            <div class="form-group col-md-3">
                <label>Driver</label>
                <select name="driver_id" class="form-control">
                    <?php foreach($all_employees as $emp): ?>
                    <option value="<?= $emp->user_id ?>"><?= $emp->first_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success" style="float: right;">Add Vehicle</button>
        </form>

    </div>
</div>