<style>
.pending {
    display: inline-block;
    height: 24px;
    color: white;
    width: 67px;
    padding: 2px 4px 5px 5px;
    background: #ff2d2d;
    border-radius: 10px;
    font-weight: bold;
}

.complet {
    display: inline-block;
    height: 24px;
    color: white;
    width: 86px;
    padding: 2px 4px 5px 5px;
    background: #0dae06;
    border-radius: 10px;
    font-weight: bold;
}

#deteils {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 108%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
}

.detailsc {
    background-color: #fefefe;
    margin: 11% auto;
    border: 1px solid #888;
    width: 80%;
    max-width: 406px;
}

.hedingt {
    width: 100%;
    height: 19px;
    background: var(--sea, #02A5AF);
}
.kitt{
    width: 22%;
    height: 21px;
    padding: 2px 3px;
    border-radius: 15px;
    background: var(--sea, #02A5AF);
    display: flex;
    align-items: center;
    justify-content: center;
}
.kispan{
    color: var(--white, #FFF);
    font-family: Roboto;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: 100%;
    text-transform: capitalize;
}
</style>


<div id="deteils" class="mmm">
    <div class="detailsc">
        <div class="col-md-12" style="background: aliceblue;padding: 0px;width: 147%;">
            <div class="col-md-12 hedingt"></div>


            <div class="col-md-12" style="text-align-last: right;">
                <svg class="close"  xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path id='close'
                        d="M13.7015 0.975099C14.0919 0.58441 14.7251 0.584143 15.1157 0.974502L17.0511 2.90822C17.4418 3.29858 17.4421 3.93175 17.0517 4.32244L4.32914 17.0557C3.93878 17.4464 3.30562 17.4467 2.91493 17.0563L0.979574 15.1226C0.588885 14.7322 0.588619 14.0991 0.978978 13.7084L13.7015 0.975099ZM3.30181 0.839251C3.69217 0.448563 4.32534 0.448296 4.71603 0.838655L17.4493 13.5612C17.84 13.9516 17.8403 14.5847 17.4499 14.9754L14.9966 17.4308C14.6063 17.8215 13.9731 17.8217 13.5824 17.4314L0.849117 4.70883C0.458428 4.31847 0.458161 3.6853 0.84852 3.29461L3.30181 0.839251Z"
                        fill="#858A8F" />
                </svg>
            </div>
            <div class="col-md-12" style="padding: 25px;">
                <div class="col-md-12"
                    style="padding: 0;color: var(--text-color-1, #333);text-align: center;font-family: Roboto;font-size: 19px;font-style: normal;font-weight: 600;line-height: 150.5%; /* 35.88px */">
                    <span id="titel"></span>
                </div>
                <div class="col-md-12" style="padding: 0;display: flex;justify-content: center;gap: 17px;">
                    <div class="kitt"><span class="kispan" id="location"></i></span></div>
                    <div class="kitt"><span class="kispan" id="duration"></span></div>
                </div>
                <div class="col-md-12" style="padding: 0;display: flex;justify-content: center;">
                <div id="descrption" style="padding: 12px;display: flex;text-align: center;color: #000;font-family: Roboto;font-size: 15px;font-style: normal;font-weight: 400;line-height: 22.5px; /* 150% */text-transform: capitalize;">
                </div>
                
                </div>

            </div>
        </div>

    </div>

</div>

<table class="datatables-demo table table-striped table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Start Date </th>
            <th>End Date</th>
            <th>Duration</th>
            <th>Details</th>
            <th>Place Name</th>
            <th>Status</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach($allevent as $kay=>$data){ 
              $enddatetime=date('d-M-Y H:i:s' , strtotime($data->end_event_date.' '. $data->end_event_time))
              ?>
        <tr>
            <td><?= $kay+1 ?></td>
            <td><?= date('d-M-Y H:i:s' , strtotime($data->start_event_date.' '. $data->start_event_time))?></td>
            <td><?= date('d-M-Y H:i:s' , strtotime($data->end_event_date.' '. $data->end_event_time))?></td>
            <td><?= $data->event_duration ?></td>
            <td><a class="btn" onclick=opm(this) data-titel="<?= $data->event_title ?>" data-location="<?= $data->location ?>" data-duration="<?= $data->event_duration ?>" data-description="<?= $data->event_note ?>"  style="padding: 2px;margin: 0;color: #ffffff;background: #006bc8;">Details</a></td>
            <td><?= $data->location ?></td>
            <td><?= ($enddatetime > date('d-M-Y H:i:s'))? '<span class="pending">Pending</span>': '<span class="complet">Complete</span>' ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<script>
   function opm(element){
    const title = element.dataset.titel;
    const location = element.dataset.location;
    const duration = element.dataset.duration;
    const description = element.dataset.description;
    document.getElementById('deteils').style.display = "block";
    document.getElementById('titel').innerHTML=title;
    document.getElementById('location').innerHTML=location;
    document.getElementById('duration').innerHTML=duration;
    document.getElementById('descrption').innerHTML=description;
    }

    
</script>
<script>
window.addEventListener("click", (event) => {
  if (event.target.className === 'mmm' || event.target.id === 'close') {
    document.getElementById('deteils').style.display = "none";
  }})   
</script>


