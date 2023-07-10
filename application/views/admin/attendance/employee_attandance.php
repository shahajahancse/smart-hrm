<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&amp;display=swap">
<link rel="stylesheet" href="<?= base_url('skin/hrsale_assets/css/lunch_emp_bill.css') ?>">
<style>
    .equal-height {
  display: flex;
}

.equal-height-column {
  flex: 1;
  display: flex;
  flex-direction: column;
}
/* .circle {
  width: 100px;
  height: 100px;
  background: #F9F9F9;
  border: 5px solid var(--b, #599AE7);
  border-radius: 50%;
  display: inline-block;
} */
.circle {
  width: 100px;
  height: 100px;
  background: #F9F9F9;
  border: 5px solid var(--b, #599AE7);
  border-radius: 50%;
  display: inline-block;
  align-items: center;
  justify-content: center;
}
.circle-text {
  
  display: inline-block;
  align-items: center;
  justify-content: center;
  top: 38px;
  left: 136px;
  position: absolute;
  color: #1F1F1F;
font-family: Roboto;
font-size: 18px;
font-style: normal;
font-weight: 400;
line-height: 27px
}
.d1{
display: flex;
padding: 18px 9px;
align-items: flex-start;
gap: 9px;
}
.brak{
border-radius: 4px;
padding:5px;  display: flex;
padding: 6px 48.34px 14.39px 47.16px;
flex-direction: column;
align-items: center;
gap: -1px; border: 1px solid #E3E3E3;
background: #F9F9F9;"

}
.lunch{
padding:5px; display: flex;
border-radius: 4px;
padding: 6px 46.14px 14.39px 45.36px;
flex-direction: column;
align-items: center;

gap: -1px; border: 1px solid #E3E3E3;
background: #F9F9F9;"
}


</style>
<div class="monthname">
    June-2023 Month Lunch Bill Summery
</div>
<div class="divrow col-md-12" style="flex-direction: column;">

        <div class="row equal-height">
        <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-6" style="padding-left: 0px;">
                                    <h4>Timesheet</h4>
                                    </div>
                                    <div class="col-xs-6" style="padding-right: 0px;">
                                    <h4>2023-05-22</h4>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12" style="text-align: left; margin-left: 27px; border-radius: 4px;border: 1px solid #E3E3E3; width:86%;background: #F9F9F9;">
                                            <span >Pancehing in date</span> <br>
                                            <span >date and time</span>
                                        </div>

                                        
                                     </div>
                                  </div>
                                    <div class="row" style=" margin-top: 15px; ">
                                         <div class="col-md-12" >
                                         <div class="row">
                                                <div class="col-xs-12 text-center" style="padding-top=5px;">
                                                    <div class="circle"> <span class="circle-text">3.45 hrs</span></div>
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="d1">
                                            <div class="brak"> break <br> 3 hours</div>
                                           <div class="lunch">overtime <br>3 hours</div>
                                            </div>
                                           

                                        </div>

                                             
                                        </div>
                                    </div>
                              
                            </div>
                        </div>
             </div>
             <!-- //2nd card -->
             <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-xs-6" style="padding-left: 0px;">
                            <h4>Timesheet</h4>
                            </div>
                        </div>
                        <div class="heading2">
                            <div style="display: flex;padding: 16px;flex-direction: column;align-items: flex-start;gap: 5px;">

                            </div>

                            
                        </div>
                        </div>
                    </div>
                </div>
<!-- //3rd card -->

             <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-6">
                                    <h4>Timesheet</h4>
                                    </div>
                                    <div class="col-xs-6">
                                    <h4>2023-05-22</h4>
                                    </div>
                                </div>
                              <div class="heading2">22</div>
                            </div>
                        </div>
             </div>


               
               
                
        </div>
        


    <!-- <div class="divstats-info col-md-3" style="background-color: #d1ecf1;">
        <div class="heading">Total Lunch</div>
        <div class="heading2">22</div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #F1CFEE;">
        <div class="heading">Total Payment</div>
        <div class="heading2">945</div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #E5E5E5;">
        <div class="heading">Saved Lunch</div>
        <div class="heading2">4</div>
    </div>
    <div class="divstats-info col-md-3" style="background-color: #D2F9EE;">
        <div class="heading">Previous Saved Amount</div>
        <div class="heading2">589</div>
    </div> -->
</div>

<div class="titel_sec_head col-md-3">
    <div>Lunch Bill Information</div>

</div>
<div class="titel_sec_head2 col-md-4">
    <input type="month" class="datesec" id="monthYearInput" value="<?= date('Y-m')?>">
    <a class="btn btns">Submit</a>

</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>
