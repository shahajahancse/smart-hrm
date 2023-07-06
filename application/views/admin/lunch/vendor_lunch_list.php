<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<?php
// dd($result);
?>
<style>
#ve {
    display: none;
}

#dw {
    display: none;
}

.addbox {
    min-height: 49px;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    line-height: 1.5;
}

.panels {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.6s ease-out;
}

.payment_box {
    opacity: 0;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    transition: max-height 0.2s ease-out, opacity 0.2s ease-out;
}

.p {
    margin: 0 !important;
    padding: 0 !important;
}

.btn {
    float: right;
    padding: 5px;
    font-weight: bold;
}

.panels.open {
    max-height: 1000px;
    margin-top: 11px;
    margin-bottom: 13px;
    opacity: 1;
    transition: max-height .6s ease-out, opacity .6s ease-out;
}

.section_box {
    width: 100%;
    background: #fffcf9;
    height: fit-content;
    margin: 3px;
    padding: 13px;
    border-radius: 5px;
    box-shadow: inset 5px 3px 20px 7px rgb(0 0 0 / 10%);
    overflow: auto;
}

.section-heding {
    font-weight: bold;
    font-size: 19px;
}

.list_box {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    color: #333;
}

.levels {
    font-size: 13px;
    font-weight: bold;
}

th {
    text-align: center;
}

p {
    margin: 0 0 0px;
}
</style>

<!-- Modal -->

<div class="addbox">
    <p class="p" style="font-size: 25px; font-weight: bold; float: left;">Vendor Meal List</p>
    <a class="btn btn-primary accordion" onclick="togglePaymentBox()">Add Meal</a>
</div>
<div class="panels payment_box" id="paymentBox">
    <section class="section_box">
        <div class="col-md-12">
            <div class="form-group col-md-2">
                <p class="levels"> Date</p>
                <input type="date" class="form-control" id="date" style="border-radius: 6px;"
                    value="<?= date('Y-m-d')?>">
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Total Meal</p>
                <input type="number" id="total_meal" onchange=changemeal() class="form-control"
                    style="border-radius: 6px;">
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Total Amount</p>
                <input type="number" id="total_amount" class="form-control" style="border-radius: 6px;" disabled>
            </div>
            <div class="col-md-3">
                <input type="hidden" name="" id="prefile" value="">
                <p class="levels" style="float: left;margin-right: 5px;">Upload File</p>
                <a href="" id="ve" class="pre">View</a>
                <a href="" id="dw" class="pre" download>Download</a>
                <input type="file" id="file" accept=".pdf, image/*">
            </div>
            <div class="form-group col-md-12">
                <p class="levels">Remarks</p>
                <textarea name="" id="remarks" style="width: 100%;height: 104px;border-radius: 6px;"
                    required></textarea>

            </div>

        </div>
        <div class="col-md-12">
            <a onclick="submit()" class="btn btn-primary" style="float: right;margin-right: 19px;">Submit</a>
        </div>
    </section>


</div>
<div class="list_box">
    <table class="table" id="myTable" style="text-align: center;">
        <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Meal Qty</th>
                <th>Amount</th>
                <th>File</th>
                <th>Remarks</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($payment_data as $key=>$row): ?>
            <tr>
                <td><?php echo $key+1 ?></td>
                <td><?php echo $row->date; ?></td>
                <td><?php echo $row->meal_qty; ?></td>
                <td><?php echo $row->amount;?></td>
                <td>
                    <a href="<?php echo base_url($row->file);?>">View</a>
                    <a href="<?php echo base_url($row->file);?>" download>Download</a>
                </td>
                <?php if($row->remarks){ ?>
                <td style="text-align: center;" title="<?php echo $row->remarks; ?>">
                    <?php echo implode(' ', array_slice(explode(' ', $row->remarks ), 0, 4)); ?></td>
                <?php }else{ ?>
                <td style="text-align: center;">...</td>
                <?php } ?>
                <td><a onclick="edit_vendor_data(<?php echo $row->id;?>)" class="btn btn-primary">Edit</a></td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
<script>
function togglePaymentBox() {
    var paymentBox = document.getElementById('paymentBox');
    paymentBox.classList.toggle('open');

    var currentDate = new Date().toISOString().split('T')[0];
    $('#date').val(currentDate);
    $('#total_meal').val(0);
    $('#remarks').val('');
    $('#total_amount').val(0);
    $('#ve').css({
        'display': 'none',
    });

    $('#dw').css({
        'display': 'none',
    });
}
</script>
<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        "order": [
            [2, "desc"]
        ]
    });

});
</script>
<script>
function changemeal() {
    var inputData = $("#total_meal").val();
    $("#total_amount").val(inputData * 90);
}
</script>
<script>
$(document).ready(function() {
    $("#submitBtn").click(function() {


        // All fields are valid, submit the form
        $("form").submit();
    });
});
</script>
<script>
function submit() {

    // Get form values
    var date = $('#date').val();
    var totalMeal = $('#total_meal').val();
    var remarks = $('#remarks').val();
    var total_amount = $('#total_amount').val();
    var filess = $('#file').val();
    var prefile = $('#prefile').val();
    if (date === "") {
        alert("Please enter remarks");
        return false;
    }
    if (date === "") {
        alert("Please enter date");
        return false;
    }
    if (totalMeal === "") {
        alert("Please enter totalMeal");
        return false;
    }
    if (remarks === "") {
        alert("Please enter remarks");
        return false;
    }
    if (filess === "") {
        if (prefile === '') {
            alert("Please enter file");
            return false;
        }
    }


    // Prepare form data
    var formData = new FormData();
    formData.append('date', date);
    formData.append('total_meal', totalMeal);
    formData.append('remarks', remarks);
    formData.append('total_amount', total_amount);
    formData.append('prefile', prefile);
    formData.append('file', $('#file')[0].files[0]);

    url = '<?= base_url('/admin/lunch/vendor_data/')?>'
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                title: 'Success!',
                text: response,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        },
        error: function(xhr, status, error) {
            // Handle the error
            console.log('AJAX request error');
            console.log(xhr.responseText);
        }
    });
}
</script>
<script>
function edit_vendor_data(id) {
    url = '<?= base_url('/admin/lunch/edit_vendor_data/')?>';
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            id: id,
        },
        success: function(response) {
            togglePaymentBox();
            var parsedData = JSON.parse(response);
            console.log(parsedData.date);

            // Assigning values to fields
            $('#date').val(parsedData.date);
            $('#total_meal').val(parsedData.meal_qty);
            $('#remarks').val(parsedData.remarks);
            $('#total_amount').val(parsedData.amount);
            $('#prefile').val(parsedData.file);

            $('#ve').attr('href', '<?= base_url() ?>' + parsedData.file).css({
                'display': 'inline-block',
                'color': 'red',
                'font-size': '16px'
            });

            $('#dw').attr('href', '<?= base_url() ?>' + parsedData.file).css({
                'display': 'inline-block',
                'color': 'blue',
                'font-size': '14px'
            });
        },
        error: function(xhr, status, error) {
            // Handle the error
            console.log('AJAX request error');
            console.log(xhr.responseText);
        }
    });
}
</script>