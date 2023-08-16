<?php



?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>


<!-- <a  style="position: relative;z-index: 1;margin: 5px;" class="btn btn-success float-right" href="">Print</a> -->



<input type="hidden" id="status" name="status" value="1"></input>
<button onclick=monthly_report() style="position: relative;z-index: 1;margin: 5px;" class="float-right btn btn-primary"
    style="cursor:pointer;">Print</button>


<div class="box <?php echo $get_animate;?>">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="true">Probation to Regular list</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false">Increment List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages"
                aria-selected="false">Promotion List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="InternToRegularList-tab" data-toggle="tab" href="#InternToRegularList" role="tab"
                aria-controls="messages" aria-selected="false">Intern To Regular List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="InternToProbationList-tab" data-toggle="tab" href="#InternToProbationList"
                role="tab" aria-controls="messages" aria-selected="false">Intern To Probation List</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active in" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="box-body">


                <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="example">
                        <thead>
                            <tr>
                                <th style="width:120px;">No.</th>
                                <th style="width:100px;">Name</th>
                                <th style="width:100px;">Department</th>
                                <th style="width:100px;">Designation</th>
                                <th style="width:100px;">DOJ</th>
                                <th style="width:100px;">Old Salary</th>
                                <th style="width:100px;">New Salary</th>
                                <th style="width:100px;">G.Letter</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $key => $row) {
                                if($row->status==1) {?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
                                <td><?php echo $row->department_name; ?></td>
                                <td><?php echo $row->designation_name; ?></td>
                                <td><?php echo $row->date_of_joining; ?></td>
                                <td><?php echo $row->old_salary; ?></td>
                                <td><?php echo $row->new_salary; ?></td>
                                <td><?php echo $row->letter_status == 1 ? "Yes" : "No"; ?></td>
                            </tr>
                            <?php }
                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="box-body">
                <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="examples">
                        <thead>
                            <tr>
                                <th style="width:120px;">No.</th>
                                <th style="width:100px;">Name</th>
                                <th style="width:100px;">Department</th>
                                <th style="width:100px;">Designation</th>
                                <th style="width:100px;">DOJ</th>
                                <th style="width:100px;">Old Salary</th>
                                <th style="width:100px;">New Salary</th>
                                <th style="width:100px;">G.Letter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $key => $row) {
                                if($row->status==2) {?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
                                <td><?php echo $row->department_name; ?></td>
                                <td><?php echo $row->designation_name; ?></td>
                                <td><?php echo $row->date_of_joining; ?></td>
                                <td><?php echo $row->old_salary; ?></td>
                                <td><?php echo $row->new_salary; ?></td>
                                <td><?php echo $row->letter_status == 1 ? "Yes" : "No"; ?></td>
                            </tr>
                            <?php }
                                } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
            <div class="box-body">
                <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="exampless">
                        <thead>
                            <tr>
                                <th style="width:120px;">No.</th>
                                <th style="width:100px;">Name</th>
                                <th style="width:100px;">Department</th>
                                <th style="width:100px;">Designation</th>
                                <th style="width:100px;">DOJ</th>
                                <th style="width:100px;">Old Salary</th>
                                <th style="width:100px;">New Salary</th>
                                <th style="width:100px;">G.Letter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $key => $row) {
                                if($row->status==3) {?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
                                <td><?php echo $row->department_name; ?></td>
                                <td><?php echo $row->designation_name; ?></td>
                                <td><?php echo $row->date_of_joining; ?></td>
                                <td><?php echo $row->old_salary; ?></td>
                                <td><?php echo $row->new_salary; ?></td>
                                <td><?php echo $row->letter_status == 1 ? "Yes" : "No"; ?></td>
                                <!-- <td><a href="<?php echo base_url('admin/employees/pip_letter_pdf/'.$row->id); ?>" class="btn btn-info btn-sm">Print PDF</a></td> -->
                            </tr>
                            <?php }
                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="InternToRegularList" role="tabpanel" aria-labelledby="InternToRegularList-tab">
            <div class="box-body">
                <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="exampless">
                        <thead>
                            <tr>
                                <th style="width:120px;">No.</th>
                                <th style="width:100px;">Name</th>
                                <th style="width:100px;">Department</th>
                                <th style="width:100px;">Designation</th>
                                <th style="width:100px;">DOJ</th>
                                <th style="width:100px;">Old Salary</th>
                                <th style="width:100px;">New Salary</th>
                                <th style="width:100px;">G.Letter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $key => $row) {
                                if($row->status==5) {?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
                                <td><?php echo $row->department_name; ?></td>
                                <td><?php echo $row->designation_name; ?></td>
                                <td><?php echo $row->date_of_joining; ?></td>
                                <td><?php echo $row->old_salary; ?></td>
                                <td><?php echo $row->new_salary; ?></td>
                                <td><?php echo $row->letter_status == 1 ? "Yes" : "No"; ?></td>
                                <!-- <td><a href="<?php echo base_url('admin/employees/pip_letter_pdf/'.$row->id); ?>" class="btn btn-info btn-sm">Print PDF</a></td> -->
                            </tr>
                            <?php }
                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="InternToProbationList" role="tabpanel" aria-labelledby="InternToProbationList-tab">
            <div class="box-body">
                <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="exampless">
                        <thead>
                            <tr>
                                <th style="width:120px;">No.</th>
                                <th style="width:100px;">Name</th>
                                <th style="width:100px;">Department</th>
                                <th style="width:100px;">Designation</th>
                                <th style="width:100px;">DOJ</th>
                                <th style="width:100px;">Old Salary</th>
                                <th style="width:100px;">New Salary</th>
                                <th style="width:100px;">G.Letter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $key => $row) {
                                if($row->status==4) {?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $row->first_name .' '. $row->last_name; ?></td>
                                <td><?php echo $row->department_name; ?></td>
                                <td><?php echo $row->designation_name; ?></td>
                                <td><?php echo $row->date_of_joining; ?></td>
                                <td><?php echo $row->old_salary; ?></td>
                                <td><?php echo $row->new_salary; ?></td>
                                <td><?php echo $row->letter_status == 1 ? "Yes" : "No"; ?></td>
                                <!-- <td><a href="<?php echo base_url('admin/employees/pip_letter_pdf/'.$row->id); ?>" class="btn btn-info btn-sm">Print PDF</a></td> -->
                            </tr>
                            <?php }
                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {


    // Get the button and input elements
    const button1 = document.getElementById("home-tab");
    const button2 = document.getElementById("profile-tab");
    const button3 = document.getElementById("messages-tab");
    const input = document.getElementById("status");
    // Add an event listener to the button
    button1.addEventListener("click", function() {
        input.value = "1";
    });
    button2.addEventListener("click", function() {
        input.value = "2";
    });
    button3.addEventListener("click", function() {
        input.value = "3";
    });
});
</script>
<script>
function monthly_report() {

    var ajaxRequest; // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    status = document.getElementById('status').value;
    // if(status)
    // {

    //   document.getElementById("loading").style.visibility = "visible";


    // }

    console.log("hello")



    var data = "status=" + status;

    url = base_url + "/print_inc";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    // alert(url); return;

    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4) {
            // console.log(ajaxRequest.responseText); return;
            // document.getElementById("loading").style.visibility = "hidden";

            var resp = ajaxRequest.responseText;
            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
            a.document.write(resp);
            // a.close();
        }
    }

}
</script>