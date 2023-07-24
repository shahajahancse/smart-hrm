<?php 
$total_amount=0;
$paid_amount=0;
$total_emp=0;
$paid_total_emp=0;

foreach ($empdata as $i => $value) {
    $total_amount+=$value->pay_amount;
    $total_emp+=1;
    if($value->status == 1){
        $paid_amount+=$value->pay_amount;
        $paid_total_emp+=1;
    }
}
$un_paid_amount=$total_amount-$paid_amount;
$un_paid_emp=$total_emp-$paid_total_emp;
?>
<style>
tr {
    border: 1px solid #e0e0e0;
}

th {}

td {}
</style>
<div style="display: flex;flex-direction: column;">
    <div class="col-md-12">
        <div class="col-md-4 card">
            <h5 class="card-title" style="text-align: center;">Summary Of <span
                    style="color: blue;"><?= $first_date ?></span> to <span style="color: blue;"><?= $second_date?>
                </span></h5>
            <div class="card-body">
                <table class="col-md-12">
                    <tr>
                        <th>Total Meal</th>
                        <td>:</td>
                        <td><?= $total_amount ?></td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td>:</td>
                        <td><?= $total_amount ?></td>
                    </tr>
                    <tr>
                        <th>Collected Amount</th>
                        <td>:</td>
                        <td><?= $paid_amount ?></td>
                    </tr>
                    <tr>
                        <th>Unpaid Amount</th>
                        <td>:</td>
                        <td><?= $un_paid_amount ?></td>
                    </tr>
                    <tr>
                        <th>Total Employee</th>
                        <td>:</td>
                        <td><?= $total_emp ?></td>
                    </tr>
                    <tr>
                        <th>Paid Employee</th>
                        <td>:</td>
                        <td><?= $paid_total_emp ?></td>
                    </tr>
                    <tr>
                        <th>Unpaid Employee</th>
                        <td>:</td>
                        <td><?= $un_paid_emp ?></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <span style="font-size: 16px;font-weight: bold;">
                    Payment Data Of <span style="color: blue;"><?= $first_date ?></span> to <span
                        style="color: blue;"><?= $second_date?> </span>
                </span>
                <div style="float: right;padding: 5px;">
                    <label for=""> Select Status</label>
                    <select id="myInput" onchange="filterFunction()">
                        <option value="all">All</option>
                        <option value="Colected">Colected</option>
                        <option value="Unpaid">Unpaid</option>
                    </select>
                </div>
                <table class="table table-striped table-hover table-bordered" id="tabledata">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Collection.M</th>
                            <th>Amount</th>
                            <th>Taken.M</th>
                            <th>Taken.A</th>
                            <th>Balance.M</th>
                            <th>B.Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($empdata as $key => $data) { 
                            $taken_meal=0;
                            $this->load->model("Lunch_model");
                            $emp_data = $this->Lunch_model->get_data_date_wise($first_date,$second_date, $data->emp_id);
                        
                            foreach ($emp_data['emp_data'] as $r) {
                            
                                $taken_meal+=$r->meal_amount;
                            }
                            $paymeal=$data->pay_amount/45;
                            $balanceMeal= $paymeal-$taken_meal;

                            
                            
                            ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td>
                                <h5 style="cursor: pointer; color: blue" data-firstdate="<?= $first_date ?>"
                                    data-secenddate="<?= $second_date ?>" data-empid="<?= $data->emp_id ?>">
                                    <?= $data->first_name ?> <?= $data->last_name ?>
                                </h5>
                            </td>
                            <td><?= $data->designation_name ?></td>
                            <td><?= $data->pay_amount/45?></td>
                            <td><?= $data->pay_amount?></td>

                            <td><?= $taken_meal ?></td>
                            <td><?= $taken_meal*45 ?></td>
                            <td><?= $balanceMeal?></td>
                            <td><?= $balanceMeal*45 ?></td>
                            <td class="<?= ($data->status == 1) ? 'success' : 'info' ?>">
                                <?= ($data->status == 1) ? 'Colected' : 'Unpaid' ?>
                            </td>

                        </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
function filterFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toLowerCase(); // Convert the filter value to lowercase for case-insensitive comparison
    table = document.getElementById("tabledata");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) { // Start from index 1 to skip the header row
        td = tr[i].getElementsByTagName("td")[9]; // Get the second column (index 1) which contains the payment status
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (filter === "all" || txtValue.toLowerCase().indexOf(filter) > -
                1) { // Check for partial match or if "all" is selected
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>

<script>
const links = document.querySelectorAll('h5'); // Select all anchor elements

links.forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior

        // Remove 'clicked' class from all links
        links.forEach(function(link) {
            link.classList.remove('clicked');
        });
        // Add 'clicked' class to the clicked link
        link.classList.add('clicked');
        const firstDate = link.getAttribute(
            'data-firstdate'); // Retrieve the value of data-firstdate attribute
        const secondDate = link.getAttribute(
            'data-secenddate'); // Retrieve the value of data-secenddate attribute
        const empId = link.getAttribute('data-empid'); // Retrieve the value of data-empid attribute
        var ajaxRequest; // The variable that makes Ajax possible!
        ajaxRequest = new XMLHttpRequest();

        var data = "first_date=" + firstDate + '&second_date=' + secondDate + '&sql=' + empId;

        url = base_url + "/lunch_jobcard";
        // alert(url); return ;
        ajaxRequest.open("POST", url, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
        ajaxRequest.send(data);
        // alert(url); return;

        ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4) {
                // console.log(ajaxRequest.responseText); return;
                var resp = ajaxRequest.responseText;
                a = window.open('', '_blank',
                    'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
                a.document.write(resp);
                // a.close();
            }
        }
    });
});
</script>