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
    text-align: left;
}
td {
    text-align: left;
}

p {
    margin: 0 0 0px;
}

.dropdown-item {

    overflow: hidden;
    padding: 4px;
    margin: 5px;
    width: 72px;
    height: 28px;
    text-align: center;
    border: 1px solid #0177bc;
    border-radius: 4px;
    /* New style for dropdown-item */
    background-color: #f8f9fa;
    color: #212529;
    transition: box-shadow 0.3s, color 0.3s;
}

.dropdown-item:hover {
    /* Hover effect */
    box-shadow: 0 0 5px #0177bc;
    color: #fff;
}

.dropdown-menu {
    margin-top: 28px;
    min-width: 85px !important;
}

.btn {
    padding: 3px !important;
}

.serchbox {
    padding: 18px;
    display: flex;
    flex-direction: row;
    margin-bottom: 13px;
    gap: 62px;
    border-radius: 6px;
    box-shadow: 0px 0px 5px 4px #e5e5e5;
}

.inputb {
    height: 34px;
    padding: 8px;
    width: 100%;
    border-radius: 6px;
    border: 0;
    box-shadow: inset 4px 2px 20px 3px #dcdcdc;
}
</style>

<!-- Modal -->
<div class="addbox" style="margin-bottom: 11px;min-height: 138px;font-size: 15px;width: 28%;">
    <?php $pass_data = $this->db->order_by('id', 'desc')->get('lunch_payment_vendor', 1)->row(); 
    ?>
    <table>
        <tr><th>Last Calculate Date : </th> <td><?= $pass_data->to_date?> </td> </tr>
        <tr><th>Previous Due: </th> <td><?= $pass_data->previous_due?> </td></tr>
        <tr><th>Total Meal : </th> <td><?= $pass_data->total_meal?> </td></tr>
        <tr><th>Total Amount : </th> <td> <?= $pass_data->net_payment?></td></tr>
        <tr><th>Paid:  </th> <td><?= $pass_data->paid_amount?></td></tr>
        <tr><th>Due: </th> <td> <?= $pass_data->due?></td></tr>
    </table>
</div>
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
    <div class="col-md-12 serchbox">
        <div>
            <label for="">First Date</label>
            <input class="inputb" onchange="calmeal()" type="date" name="" id="from_date"
                max="<?php echo date('Y-m-d'); ?>" value="<?= $pass_data->to_date?>">
        </div>
        <div>
            <label for=""> Last Date</label>
            <input class="inputb" type="date" onchange="calmeal()" name="" id="to_date"
                max="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div>
            <label for="">Total Meal</label>
            <input class="inputb" type="text" name="" id="total_meals" disabled>
        </div>
        <div>
            <label for="">Total Amount</label>
            <input class="inputb" type="text" name="" id="total_amounts" disabled>
        </div>
        <div>
            <label style=" visibility: hidden; ">.</label>
            <a class="btn btn-primary" onclick="print_vendor_data()">Print</a>
        </div>
    </div>
    <div id="tablebody">
        <?php echo $lunchtable  ?>
    </div>
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
function changemeal() {
    var inputData = $("#total_meal").val();
    $("#total_amount").val(inputData * 100);
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
            showSuccessAlert(response);

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
<script>
function calmeal() {
    document.getElementById('tablebody').innerHTML = '';
    // alert('hello');
    // return false;

    var first_date = $('#from_date').val();
    var second_date = $('#to_date').val();
    // Prepare the data object
    var data = {
        first_date: first_date,
        second_date: second_date
    };
    url = '<?= base_url('/admin/lunch/get_payment_data_list/')?>'
    // Send AJAX request
    $.ajax({
        url: url,
        method: 'POST',
        data: data,
        success: function(response) {
            console.log(response);
            document.getElementById('tablebody').innerHTML = response.table;
            document.getElementById('total_meals').value = response.total_m;
            document.getElementById('total_amounts').value = parseInt(response.total_am);
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.log(xhr.responseText);
        }
    });
}
</script>
<script>
    $(document).ready(function() {
        calmeal();
    });
</script>
<script>
    function print_vendor_data(){
        var from_date= $('#from_date').val();
        var to_date= $('#to_date').val();
        url = '<?= base_url('/admin/lunch/print_vendor_data/')?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                from_date: from_date,
                to_date: to_date,
            },
            success: function(response) {
                var newWindow = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
                newWindow.document.write(response);
            },
            error: function(xhr, status, error) {
                console.log('AJAX request error');
                console.log(xhr.responseText);
            }
        });
    }
</script>
