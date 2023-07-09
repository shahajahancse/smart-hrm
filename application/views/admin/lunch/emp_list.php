<?php $this->load->view('admin/head_bangla');?>
<span style="justify-content: center;display: flex;">Payment Report of <?= $first_date?> to <?= $second_date?></span>
<br>
<table class="table table-striped table-hover table-bordered" id="tabledata">
    <thead>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Collection.M</th>
            <th>Amount</th>
            <th>Take.M</th>
            <th>Take.A</th>
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
                <?= ($data->status == 1) ? 'paid' : 'unpaid' ?>
            </td>

        </tr>
        <?php } ?>

    </tbody>
</table>
<script>
$(document).ready(function() {
    //Load First row

    $('#tabledata').DataTable();
});
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