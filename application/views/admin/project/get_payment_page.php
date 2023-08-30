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

.listd{
    box-shadow: 0px 0px 0px 1px #c1c1c1;
    margin: 5px;
}

.listd:hover {
    box-shadow: 0px 0px 5px 2px #c1c1c1;
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
                   <li class="listd"><a href="<?= base_url('admin/project/get_service_payment') ?>">Service Payment <span
                        class="badge badge-danger"><?=count($service_payment_data) ?></span> </a></li>
                    <li class="listd"><a href="<?= base_url('admin/project/get_software_payment') ?>">Software Payment <span
                                class="badge badge-danger"><?= count($soft_payment_data)?></span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>