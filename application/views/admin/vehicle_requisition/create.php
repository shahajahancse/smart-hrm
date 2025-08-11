<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Vehicle List</h3>
        <a href="<?= site_url('admin/vehicle/add') ?>" class="btn btn-primary mb-3 float-right">Add Vehicle</a>
    </div>
    <div class="box-body">
        <form action="<?= site_url('admin/vehicle_requisition/store') ?>" method="post">
            <div class="row">
                <div class="col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Select Vehicle</label>
                    <select name="vehicle_id" id="vehicle_id" class="form-control" required>
                        <option value="">-- Select a free vehicle --</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Requested Person</label>
                    <input type="text" name="req_person" class="form-control" required>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <label>Purpose</label>
                    <input type="text" name="purpose" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Organisation</label>
                    <input type="text" name="organisation" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-success">Submit Request</button>
        </form>

        <script>
        document.getElementById('from_date').addEventListener('change', loadFreeVehicles);
        document.getElementById('to_date').addEventListener('change', loadFreeVehicles);

        function loadFreeVehicles() {
            let fromDate = document.getElementById('from_date').value;
            let toDate = document.getElementById('to_date').value;

            if (fromDate && toDate) {
                fetch(
                        `<?= site_url('admin/vehicle_requisition/get_free_vehicles') ?>?from_date=${fromDate}&to_date=${toDate}`)
                    .then(response => response.json())
                    .then(data => {
                        let vehicleSelect = document.getElementById('vehicle_id');
                        vehicleSelect.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(vehicle => {
                                let option = document.createElement('option');
                                option.value = vehicle.id;
                                option.text = `${vehicle.name} (${vehicle.model})`;
                                vehicleSelect.appendChild(option);
                            });
                        } else {
                            let option = document.createElement('option');
                            option.value = '';
                            option.text = 'No vehicle available';
                            vehicleSelect.appendChild(option);
                        }
                    });
            }
        }
        </script>

    </div>
</div>
