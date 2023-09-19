<style>
.container {
    max-width: -webkit-fill-available;
}

.row1 {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-bottom: 20px;
}

.DivStatsInfo {
    flex-basis: calc(25% - 20px);
    height: 92px;
    position: relative;
    border-radius: 5px;
    border: 1px #E5E5E5 solid;
    margin-bottom: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 7px;
}

.Heading {
    text-align: center;
    color: #1F1F1F;
    font-size: 16px;
    font-weight: 400;
    margin-bottom: 10px;
}

.Amount {
    text-align: center;
    color: #1F1F1F;
    font-size: 17px;
    font-weight: 500;
}

.Frame32 {
    width: 100%;
    display: flex;
    align-items: center;
    margin-top: 20px;
    flex-direction: row;
}

.addbtn {
    color: black;
    font-size: 15px;
    font-weight: 400;
    line-height: 22.5px;
    margin-bottom: 10px;
}

.Link {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
    padding: 10px 20px;
    text-transform: uppercase;
}

.AddAmount {
    color: white;
    font-size: 15px;
    font-weight: 400;
    background: #599AE7;
    margin: 0;
    padding: 6px 13px;
    border-radius: 3px;
    cursor: pointer;
}

@media (max-width: 990px) {
    .row1 {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-direction: column;
        flex-wrap: wrap;
    }

    .Frame32 {
        width: 100%;
        display: flex;
        align-items: center;
        margin-top: 20px;
        flex-direction: column;
    }

}

@media (max-width: 768px) {
    .DivStatsInfo {
        flex-basis: calc(50% - 20px);
    }
}

.btn-primary .badge {
    color: #ffffff;
    background-color: #f00;
    border-radius: 40%;
    display: inline;
}

.listd {
    box-shadow: 0px 0px 0px 1px #c1c1c1;
    margin: 5px;
}

.listd:hover {
    box-shadow: 0px 0px 5px 2px #c1c1c1;
}

td,
th {
    padding: 6px !important;
}
</style>
<div class="container">
    <div class="row1">
        <div class="DivStatsInfo" style="background: #D1ECF1;">
            <div class="Heading">June Month Total Due</div>
            <div class="Amount">120,000</div>
        </div>
        <div class="DivStatsInfo" style="background: #F1CFEE;">
            <div class="Heading">June Month Total Payment</div>
            <div class="Amount">23,000</div>
        </div>
        <div class="DivStatsInfo" style="background: #FDDCDF;">
            <div class="Heading">2023 Year Total Due</div>
            <div class="Amount">4,000</div>
        </div>
        <div class="DivStatsInfo" style="background: #D2F9EE;">
            <div class="Heading">2023 Year Total Payment</div>
            <div class="Amount">5,000,000</div>
        </div>
    </div>
    <div class="Frame32">
        <div class="addbtn col-md-8">Want to add an amount? Please make sure to enter the amount and purpose.</div>
        <div class="Link col-md-4">
            <div class="dropdown">
                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                    Add Amount
                    <span
                        class="badge badge-danger"><?= count($soft_payment_data) + count($service_payment_data) ?></span>
                </a>
                <ul class="dropdown-menu" style="box-shadow: 0px 0px 6px 1px #959595;min-width: 136px !important;"">
                   <li class=" listd"><a href="<?= base_url('admin/project/get_service_payment') ?>">Service Payment
                        <span class="badge badge-danger"><?=count($service_payment_data) ?></span> </a></li>
                    <li class="listd"><a href="<?= base_url('admin/project/get_software_payment') ?>">Software Payment
                            <span class="badge badge-danger"><?= count($soft_payment_data)?></span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div>
    <script>
    $(document).ready(function() {
        $('#invoicesTable').DataTable();
    });
    </script>
    <div class="card">
        <div class="card-body">
                <table id="invoicesTable" class="col-md-12 table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Client Name</th>
                <th>Date</th>
                <th>Payment For</th>
                <th>Payment Type</th>
                <th>Payment Way</th>
                <th>Payment Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($invoice_data as $key => $row) {
                ?>
            <tr>
                <td><?= ($key + 1) ?></td>
                <td><?= $row->title ?></td>
                <td><?= $row->client_name ?></td>
                <td><?= $row->date ?></td>
                <td>
                    <?php
                        if ($row->payment_for == 1) {
                            echo "Software Payment";
                        } elseif ($row->payment_for == 2) {
                            echo "Service Payment";
                        }
                        ?>
                </td>
                <td>
                    <?php
                    // 'installment=1; weekly=2; monthly=3; yearly=4;
                    if ($row->payment_type == 1) {
                        echo "Installment Payment";
                    } elseif ($row->payment_type == 2) {
                        echo "Weekly Payment";
                    } elseif ($row->payment_type == 3) {
                        echo "Monthly Payment";
                    } elseif ($row->payment_type == 4) {
                        echo "Yearly payment";
                    }
                    ?>
                    
                </td>
                <td><?= $row->payment_way ?></td>
                <td><?= $row->pyment_amount ?></td>
                <td><a onclick="get_invoice_n(<?= $row->id ?>)" ><i class="fa fa-file-text" aria-hidden="true"></i></a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>

    </table>
        </div>
    </div>
</div>
<script>
    function get_invoice_n(params) {
        $.ajax({
            url: "<?= base_url('admin/project/get_invoice_n/')?>",
            type: "POST",
            data: {
                id: params
            },
            success: function(data) {
            
                
                var a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
                a.document.write(data);
            }
            
        });
    }
</script>