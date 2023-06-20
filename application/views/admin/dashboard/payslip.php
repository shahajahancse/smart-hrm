<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style>


.table td, .table th {
    padding:0;
    
}
  </style>
</head>
  <body>
  <div class="container" style="height: 143px;padding: 21px 574px 0px 48px;margin: 27px;margin-left: 346px;">
    <div class="row" style="border: 1px solid black;padding: 16px;">
        <div class="col-md-12">
            <div class="text-center lh-1" style="font-weight: bold;">
                <h5 style="font-weight: bold;" >Payslip</h5> <span class="fw-normal">Payment slip for the month of <?= $salary_month ?></span>
            </div>
            <div class="row" style="font-size: 14px;">
                <div class="col-md-12" >
                    <div class="row">
                        <div class="col-md-6" style="padding:0;margin:0;overflow: hidden;">
                            <div> <span  style="font-weight: bold;"> EMP ID :</span> <?= $values[0]->employee_id?></div>
                        </div>
                        <div class="col-md-6" style="padding:0;margin:0;overflow: hidden;">
                            <div> <span  style="font-weight: bold;">EMP Name :</span> <?= $values[0]->first_name?> <?= $values[0]->last_name?>   </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-6" style="padding:0;margin:0;overflow: hidden;">
                            <div> <span  style="font-weight: bold;">Desg : </span> <?= $values[0]->designation_name?></div>
                        </div>
                        <div class="col-md-6" style="padding:0;margin:0;overflow: hidden;">
                            <div> <span  style="font-weight: bold;">Ac No:</span>  <?= $values[0]->account_number?></div>
                        </div>
                    </div>
                </div>
                <p style="margin: 0;font-weight: bold;">Working Status :</p>
                <table class="mt-1 table table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">Present Status</th>
                            <th scope="col">Day</th>
                            <th scope="col">Leave Status</th>
                            <th scope="col">Day</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Present</th>
                            <td> <?= $values[0]->present?></td>
                            <td style="font-weight: bold;">Earn</td>
                            <td> <?= $values[0]->earn_leave?></td>
                        </tr>
                        <tr>
                            <th scope="row">Absent</th>
                            <td> <?= $values[0]->absent?></td>
                            <td style="font-weight: bold;">Sick</td>
                            <td> <?= $values[0]->sick_leave?></td>
                        </tr>
                        <tr>
                            <th scope="row">Holiday</th>
                            <td> <?= $values[0]->holiday?></td>
                            <td  colspan="2"></td>
                            
                        </tr>
                        
                        <tr>
                            <th scope="row">Weekend</th>
                            <td> <?= $values[0]->weekend?> </td>
                            <td  colspan="2"></td>
                            
                        </tr>
                        
                        <tr>
                            <th scope="row">Extra P</th>
                            <td> <?= $values[0]->extra_p?> </td>
                            <td  colspan="2"></td>
                            
                        </tr>
                        
                    </tbody>
                </table>
                <p style="margin: 0;font-weight: bold;">Pay Status :</p>

                <table class="mt-1 table table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">Earnings</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Deductions</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Basic</th>
                            <td> <?= $values[0]->basic_salary?></td>
                            <td style="font-weight: bold;">Late</td>
                            <td> <?= $values[0]->late_deduct?></td>
                        </tr>
                        <tr>
                            <th scope="row">Modify Salary</th>
                            <td> <?= $values[0]->modify_salary?></td>
                            <td style="font-weight: bold;">Absent</td>
                            <td> <?= $values[0]->absent_deduct?></td>
                        </tr>
                        <tr>
                            <th scope="row">Extra Pay</th>
                            <td> <?= $values[0]->extra_pay?> </td>
                            <td  colspan="2"></td>
                            
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-4"><span class="fw-bold"  style="font-weight: bold;">Net Pay :  <?= ($values[0]->grand_net_salary)+($values[0]->modify_salary)?></span> </div>
               
            </div>
            <div class="d-flex justify-content-end">
                <div class="d-flex flex-column mt-2"> <span class="fw-bolder"></span> <span class="mt-4"></span> </div>
            </div>
        </div>
    </div>
</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>