<style type="text/css">
.table {
    border-collapse: collapse;
    width: 100%;
    color: #5e5e5e;
    font-size: 14px;
    text-align: left;
}

th,
td {
    padding: 10px;
    text-align: center;
}

tr:nth-child(even) {
    background-color: #eee;
}

button[type=submit],
input[type=button] {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button[type=submit]:hover,
input[type=button]:hover {
    background-color: #45a049;
}



/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
/* Add your custom CSS for styling here */
.custom-input {
    border: 2px solid #3498db;
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
}

.custom-textarea {
    border: 2px solid #3498db;
    border-radius: 5px;

    
    padding: 10px;
    font-size: 16px;
}

.custom-select-input {
    border: 2px solid #3498db;
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
    background-color: #f5f5f5;
}

.form-label {
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
    font-size: 18px;
}

.custom-button {
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 15px 30px;
    cursor: pointer;
    font-size: 18px;
}

.custom-button:hover {
    background-color: #277ab6;
}

</style>

<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add New Record</a>
<div class="container mt-5">
    <table id="myTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title of Service/Project Name</th>
                <th scope="col">Ministry/Division</th>
                <th scope="col">EOI Ref No</th>
                <th scope="col">EOI Published Date</th>
                <th scope="col">Submission Date</th>
                <th scope="col">Submission Time</th>
                <th scope="col">Address JV</th>
                <th scope="col">JV/Support Company Name</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Add New Record Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('crud/create'); ?>" method="post">
            <div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title" class="form-label">Title of Service/Project Name</label>
                <input type="text" class="form-control custom-input" name="title" placeholder="Enter Title of Service/Project Name">
            </div>
            <div class="form-group">
                <label for="refno" class="form-label">EOI Ref No</label>
                <input type="number" class="form-control custom-input" name="refno" placeholder="Enter EOI Ref No">
            </div>
            <div class="form-group">
                <label for="pubdate" class="form-label">EOI Published Date</label>
                <input type="date" class="form-control custom-input" name="pubdate" placeholder="Enter EOI Published Date">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="ministry" class="form-label">Ministry/Division</label>
                <select class="form-select custom-select-input" name="ministry">
                    <option selected disabled>Select Ministry/Division</option>
                    <?php foreach ($ministries as $key => $value) : ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="subdate" class="form-label">Submission Date</label>
                <input type="date" class="form-control custom-input" name="subdate" placeholder="Enter Submission Date">
            </div>
            <div class="form-group">
                <label for="subtime" class="form-label">Submission Time</label>
                <input type="time" class="form-control custom-input" name="subtime" placeholder="Enter Submission Time">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="addressjv" class="form-label">Address JV</label>
        <textarea rows="3" class="form-control custom-textarea" name="addressjv"></textarea>
    </div>
    <div class="form-group">
        <label for="companyname" class="form-label">JV/Support Company Name</label>
        <input type="text" class="form-control custom-input" name="companyname" placeholder="Enter JV/Support Company Name">
    </div>
    <div class="form-group">
        <label for="status" class="form-label">Status</label>
        <select class="form-select custom-select-input" name="status">
            <option selected disabled>Select Status</option>
            <?php foreach ($statuses as $key => $value) : ?>
                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary custom-button">Save changes</button>
    <button type="button" class="btn btn-secondary custom-button" data-dismiss="modal">Close</button>
</div>


            </form>
        </div>
    </div>
</div>

<!-- Edit Record Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url('crud/update'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" value="" />
                    <div class="form-group row">
                        <label for="title" class="col-form-label">Title of Service/Project Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="title"
                                placeholder="Enter Title of Service/Project Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ministry" class="col-form-label">Ministry/Division</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="ministry">
                                <option selected disabled>Select Ministry/Division</option>
                                <?php foreach ($ministries as $key => $value) : ?>
                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="refno" class="col-form-label">E [/INST] OI Ref No</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="refno" placeholder="Enter EOI Ref No">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pubdate" class="col-form-label">EOI Published Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="pubdate"
                                placeholder="Enter EOI Published Date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subdate" class="col-form-label">Submission Date</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="subdate" placeholder="Enter Submission Date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subtime" class="col-form-label">Submission Time</label>
                        <div class="col-sm-10">
                            <input type="time" class="form

form-control" name="subtime" placeholder="Enter Submission Time">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="client" class="col-form-label">Client</label>
                        <div class="col-sm-10">
                            <textarea rows="3" cols="40" class="form-control" name="client"
                                placeholder="Enter Client"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="location" class="col-form-label">Location</label>
                        <div class="col-sm-10">
                            <textarea rows="3" cols="40" class="form-control" name="location"
                                placeholder="Enter Location"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea rows="3" cols="40" class="form-control" name="description"
                                placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="eligibility" class="col-form-label">Eligibility Criteria</label>
                        <div class="col-sm-10">
                            <textarea rows="3" cols="40" class="form-control" name="eligibility"
                                placeholder="Enter Eligibility Criteria"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="selection" class="col-form-label">Selection Process Details and
                            Schedule</label>
                        <div class="col-sm-10">
                            <textarea rows="3" cols="40" class="form-control" name="selection"
                                placeholder="Enter Selection Process Details and Schedule"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="evaluation" class="col-form-label">Evaluation Criteria</label>
                        <div class="col-sm-10">
                            <textarea rows="3" cols="40" class="form-control" name="evaluation"
                                placeholder="Enter Evaluation Criteria"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="note" class="col-form-label">Note</label>
                        <div class="col-sm-10">
                            <textarea rows="3" cols="40" class="form-control" name="note"
                                placeholder="Enter Note"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contactperson" class="col-form-label">Contact Person</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="contactperson"
                                placeholder="Enter Contact Person">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-form-label">Email Address</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" placeholder="Enter Email Address">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-form-label">Phone Number</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control" name="phone" placeholder="Enter Phone Number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="website" class="col-form-label">Website URL</label>
                        <div class="col-sm-10">
                            <input type="url" class="form-control" name="website" placeholder="Enter Website URL">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="filepath" class="col-form-label">File Path</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="filepath" placeholder="Enter File Path">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="filename" class="col-form-label">File Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="filename" placeholder="Enter File Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="remarks" class="col-form-label">Remarks</label>
                        <div class="col-sm-10">
                            <textarea rows="3" cols="40" class="form-control" name="remarks"
                                placeholder="Enter Remarks"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="status">
                                <option selected disabled>Select Status</option>
                                <?php foreach ($statuses as $key => $value) : ?>
                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Find the button by its ID
    var openAddModalButton = document.getElementById("openAddModalButton");

    // Find the "Add New Record" modal by its ID
    var addModal = document.getElementById("addModal");

    // Add an event listener to the button
    openAddModalButton.addEventListener("click", function() {
        // Open the modal when the button is clicked
        addModal.style.display = "block";
    });
});
</script>