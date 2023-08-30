<style>
.listprimari {
    border: 1px solid #009312;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
    width: 100%;
    display: inline-block;
}

.column {
    border-radius: 12px;
    background-color: #f5f5f5;
    padding: 20px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.listdanger {
    border: 1px solid #f00;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
    color: red;
    width: 100%;
    display: inline-block;
    cursor: pointer;
}

ul {
    padding: 10px;
    overflow: auto;
}
</style>
<div style="display: flex;flex-direction: column;gap: 19px;">
    <div class="col-md-12" style="padding:4px;display: flex;gap: 24px;">
        <div class="col-md-6 column" style="padding:0px;height: 218px;overflow: auto;">
            <span
                style="width: 100%;background: #adadad;display: block;text-align: center;font-size: 19px;position: sticky;top: 0;color: black;height: 34px;">Unpaid
                Project</span>
            <ul style="list-style: none;background: #e7e7e7;padding: 11px">
                <?php if (count($soft_payment_data)>0){
             foreach ($soft_payment_data as $key => $value) { ?>
                <li class="listdanger" onclick="get_instdata(<?=$value->project_id?>)">
                    <span><b>Client Name : </b><?= $value->client_name ?></span><br>
                    <span><b>Project Name : </b><?= $value->title ?></span><br>
                    <span><b>Instalment Date:</b><?= $value->next_installment_date ?></span><br>
                </li>
                <?php  } }else{ ?>
                <span> There Is No Data</span>
                <?php } ?>

            </ul>
        </div>
        <div class="col-md-6 column" style="padding:0px;height: 218px;overflow: auto;">
            <span
                style="width: 100%;background: #adadad;display: block;text-align: center;font-size: 19px;position: sticky;top: 0;color: black;height: 34px;">Installment</span>

            <div id="listdata"> <span> Please Select A Project</span>
            </div>
        </div>
    </div>

    <div class="box" style="padding:6px;">
        hello
    </div>
</div>
<script>
function get_instdata(project_id) {
    $.ajax({
        url: '<?php echo base_url('admin/project/get_instalment_data/');?>',
        type: 'POST',
        data: {
            project_id: project_id
        },
        success: function(data) {
            try {
                var parsedData = JSON.parse(data); // Parse the JSON response

                if (parsedData && parsedData.instdata && Array.isArray(parsedData.instdata)) {
                    var listdataElement = document.getElementById("listdata");
                    var ul = document.createElement("ul");

                    // Loop through the installment data and create list items
                    for (var i = 0; i < parsedData.instdata.length; i++) {
                        var item = parsedData.instdata[i];
                        var li = document.createElement("li");
                        if (item.intmnt_status === "1") {
                            li.className = "listprimari"; // Add the listprimari class
                        } else {
                            li.className = "listdanger"; // Add the listdanger class
                            li.onclick = function() {
                                getpaymentofinstallments(i, parsedData.project_id);
                            }
                        }
                        li.innerHTML = "<b>Date:</b> " + item.intmnt_dates + "<br><b>Payment:</b> " + item
                            .intmnt_payments + "<br><b>Status:</b> " + (item.intmnt_status == 1 ? "Paid" :
                                "Unpaid");
                        ul.appendChild(li);
                        if (item.intmnt_status !== "1") {
                            break;
                        }
                    }
                    // Clear previous content and append the new list
                    listdataElement.innerHTML = "";
                    listdataElement.appendChild(ul);
                } else {
                    console.error("Invalid or missing instdata in the response.");
                }
            } catch (error) {
                console.error("Error parsing JSON response:", error);
            }
        }


    });
}
</script>
<script>
function getpaymentofinstallments(number, project_id) {
    $.ajax({
        url: '<?php echo base_url('admin/project/get_instalment_data/');?>',
        type: 'POST',
        data: {
            number: number,
            project_id: project_id
        },
        success: function(data) {}
    });
}
</script>