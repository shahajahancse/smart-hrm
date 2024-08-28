
<!doctype html>
<html lang="en">
  <head>
  
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo base_url() ?>skin/hrsale_assets/css/ac_s.css">
    <script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"> 
        </script> 

        <script src="https://cdn.jsdelivr.net/npm/table2excel@1.0.4/dist/table2excel.min.js"></script> 
    <style>
        .colors1 {
     background-color: #0177bc3b;
     color: black !important;
     width: 15%;
     border-left: 1px solid black;
}
.colors3 {
    background-color: #97eff347 !important;
    color: black !important;
    width: 50%;
}
.col-md-3{
    width: 24%;
}
.cat4{
    background-color: #dd8b8c47 !important;
    color: black !important;
    width: 20%;

}
thead{
    font-size: 12px!important;
}
tbody{
    font-size: 10px!important;
}
.pagenumber{
        display: none;
    }
@media print {
    .btn{

        display: none;
    }
    .pagenumber{
        display: contents;
    }
 }
 .fullt{
     height: 540px;
     margin: 0px;
}
</style>

  </head>
    <body id="record">
                <div  style="float: right;">
                        <div style="position:absolute;display: flex;right:0;">
                                <form action="<?php echo base_url();?>admin/payroll/salary_sheet_excel" method="post">
                                    <input type="hidden" name="salary_month" value="<?php echo $salary_month; ?>"></input>
                                    <input type="hidden" name="sql" value="<?php echo implode(",",$emp_id); ?>"></input>
                                    <input type="hidden" name="excel" value="1"></input>
                                    <input type="hidden" name="status" value="<?php echo $status; ?>"></input>
                                    <button type="submit" class="btn btn-primary" style="border: 0; cursor:pointer;" alt="XLS Export">XLS</button>
                                </form>
                                <button class="btn" onclick="printPage()">Print</button></div>
                        </div>
                </div>

            <div id="print-content">  


                <?php
                    $total_basic_salary=0;
                    $total_grand_net_salary=0;
                    $total_net_salary=0;
                    $total_late_deduct=0;
                    $total_absent_deduct=0;
                    $total_aba_deduct=0;
                    $total_adv_deduct=0;
                    $total_lunch_deduct=0;

                    $total_extra_pay=0;
                    $total_modify_salary=0;
                    // grand total
                    $grand_total_basic_salary=0;
                    $grand_total_grand_net_salary=0;
                    $grand_total_net_salary=0;
                    $grand_total_late_deduct=0;
                    $grand_total_absent_deduct=0;
                    $grand_total_aba_deduct=0;
                    $grand_total_adv_deduct=0;
                    $grand_total_lunch_deduct=0;
                    $grand_total_extra_pay=0;
                    $grand_total_modify_salary=0;


                    // dd($values);
                    // define the number of rows per page
                    $rows_per_page = 7;

                    // calculate the total number of pages
                    $num_pages = ceil(count($values) / $rows_per_page);

                    // get the current page number from the query string
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                    // calculate the start and end index of the current page
                    $start_index = ($current_page - 1) * $rows_per_page;
                    $end_index = min($start_index + $rows_per_page - 1, count($values) - 1);

                    // print the table header
                    echo "<div>";
                    $total_grand_net_salary=0;
                    $total_basic_salary=0;
                    $total_net_salary=0;
                    $total_late_deduct=0;
                    $total_absent_deduct=0;
                    $total_aba_deduct=0;
                    $total_adv_deduct=0;
                    $total_lunch_deduct=0;
                    $total_extra_pay=0;
                    $total_modify_salary=0;
                   
                ?>
              

                <div style='font-size:18px; font-weight:bold; text-align:center;margin-top:10px'><?=xin_company_info(1)->company_name ?></div>
                <div style='font-size:14px; font-weight:bold; text-align:center;margin-top:10px'><?=xin_company_info(1)->address_1 ?></div>
                <div style='font-size:12px;align-items: center;text-align: center;'>Salary Month :<?=$salary_month ?></div>
                <div style='font-size:12px;align-items: center;text-align: center;'>P=Present, A=Absent, L=Late, E=Extra Pay,W=Weekend, H=Holyday,ABA=Before After Absent</div>

                </div>
                

                <div class='fullt'>
                    <table id="myTable">

                        <thead>
                        <tr>
                        <th class='bnb' style="width: 17px;">SL</th>
                        <th  class='bnb' style="width: 67px;">Name</th>
                        <th  class='bnb' style="width: 70px;">Degi  </th>
                        <th  class='bnb' style='width: 70px;'>Join.d</th>
                        <th  class='bnb' style="width: 60px;">Salary</th>
                        <th style='width: 190px;'>Status</th>
                        <th style='width: 55px;'>Leave</th>
                        <th  style='width:55px;'>Late</th>
                        <th style='width: 200px;'>Deduction</th>
                        <th  class='bnb' style="width: 37px;">Net Salary</th>
                        <th  class='bnb' style="width: 37px;">Extra Pay</th>
                         <th  class='bnb' style="width: 28px;">D.A Day</th>
                         <th  class='bnb' style="width: 42px;">D.A Salary</th>
                         <th  class='bnb ' style="width: 60px;">Grand Net Salary</th>
                           <th  class='bnb' style="width: 37px;">Account Number</th>
                        </tr>
                        <tr>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            
                            <th>
                                <table>
                                    <tr>
                                        <th class=''>P</th>
                                        <th class=''>A</th>
                                        <th class=''>W</th>
                                        <th class=''>H</th>
                                        <th class=''><p style="width: 9px;">E.P</p></th>
                                        <th class=''><p style="width: 9px;">ABA</p></th>
                                        
                                    </tr>
                                </table>
                            </th>
                            <th>
                                <table >
                                    <tr >
                                        <th class=''>E</th>
                                        <th class=''>S</th>
                                    </tr>
                                </table>
                            </th>
                            <th> 
                               <table>
                                    <tr>
                                        <th  class=''>Day</th>
                                        <th  class=''>D.Day</th>
                                    </tr>
                                </table>
                            </th>
                            
                            <th>
                                <table>
                                    <tr>
                                        <th  class=''>Late</th>
                                        <th  class=''>Abse</th>
                                        <th  class=''>BA</th>
                                        <th  class=''>Adv</th>
                                        <th  class=''>Lunch</th>
                                    </tr>
                                </table>
                            </th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                            <th  class='bnt'></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                

                        $j=1;
                        // print the rows for all pages
                        for ($i = 0; $i < count($values); $i++) {
                        ?>  
                        
                        <tr>
                        <td><?= $j ?></td>
                        <td><?=$values[$i]->first_name ."<br>". $values[$i]->last_name ?></td>
                        <td><?=$values[$i]->designation_name?></td>
                        <td><?=$values[$i]->date_of_joining?></td>
                        <td><?=$values[$i]->basic_salary?></td>
                        <td>
                            <table>
                                <tr>
                                    <td class='colors1'><?=$values[$i]->present?></td>
                                    <td class='colors1'><?=$values[$i]->absent?></td>
                                    <td class='colors1'><?=$values[$i]->weekend?></td>
                                    <td class='colors1'><?=$values[$i]->holiday?></td>
                                    <td class='colors1'><?=$values[$i]->extra_p?></td>
                                    <td class='colors1'><?=$values[$i]->ba_absent?></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td class='colors2'><?=$values[$i]->earn_leave?></td>
                                    <td class='colors2'><?=$values[$i]->sick_leave?></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                           <table>
                                <tr>
                                    <td  class='colors3'><?=$values[$i]->late_count?></td>
                                    <td  class='colors3'><?=$values[$i]->d_day ?></td>
                                </tr>
                            </table>

                        <!--  -->
                        </td>
                       
                        <td>
                            <table>
                                <tr>
                                    <td  class='cat4'><?=$values[$i]->late_deduct?></td>
                                    <td  class='cat4'><?=$values[$i]->absent_deduct?></td>
                                    <td  class='cat4'><?=$values[$i]->aba_deduct?></td>
                                    <td class='cat4'><?=$values[$i]->advanced_salary?></td>
                                    <td class='cat4'><?=$values[$i]->lunch_deduct?></td>
                                </tr>
                            </table>
                        </td>
                        <td><?=($values[$i]->net_salary)-($values[$i]->aba_deduct+$values[$i]->advanced_salary)?></td>
                        <td><?=$values[$i]->extra_pay?></td>
                        <td><?=$values[$i]->m_pay_day?></td>
                        <td><?=$values[$i]->modify_salary?></td>
                        
                        <td class='colors4'><?=ceil($values[$i]->grand_net_salary+$values[$i]->modify_salary-$values[$i]->aba_deduct)?></td>
                        <?php
                        $total_grand_net_salary+=$values[$i]->grand_net_salary+$values[$i]->modify_salary-$values[$i]->aba_deduct;
                        $total_basic_salary+=$values[$i]->basic_salary;
                        $total_net_salary+=($values[$i]->net_salary)-($values[$i]->aba_deduct+$values[$i]->advanced_salary);
                        $total_late_deduct+=$values[$i]->late_deduct;
                        $total_absent_deduct+=$values[$i]->absent_deduct;
                        $total_aba_deduct+=$values[$i]->aba_deduct;
                        $total_adv_deduct+=$values[$i]->advanced_salary;
                        $total_lunch_deduct+=$values[$i]->lunch_deduct;
                        $total_extra_pay+=$values[$i]->extra_pay;
                        $total_modify_salary+=$values[$i]->modify_salary;
                        // granttotal
                        $grand_total_grand_net_salary+=$values[$i]->grand_net_salary+$values[$i]->modify_salary-$values[$i]->aba_deduct;
                        $grand_total_basic_salary+=$values[$i]->basic_salary;
                        $grand_total_net_salary+=($values[$i]->net_salary)-($values[$i]->aba_deduct+$values[$i]->advanced_salary);
                        $grand_total_late_deduct+=$values[$i]->late_deduct;
                        $grand_total_absent_deduct+=$values[$i]->absent_deduct;
                        $grand_total_aba_deduct+=$values[$i]->aba_deduct;
                        $grand_total_adv_deduct+=$values[$i]->advanced_salary;
                        $grand_total_lunch_deduct+=$values[$i]->lunch_deduct;
                        $grand_total_extra_pay+=$values[$i]->extra_pay;
                        $grand_total_modify_salary+=$values[$i]->modify_salary;
                        ?>
                        <td><?=$values[$i]->account_number?></td>

                        </tr>
                                <?php
                                    $j=$j+1;
                                    if (($i+1) % $rows_per_page == 0 && $i != count($values)-1) {
                                        
                                ?>
                        </tbody>
                            <tfoot style="font-size: 12px;font-weight: bold;">
                                <tr>
                                <td colspan='4'>Total:</td>
                                <td  colspan='1'><?=$total_basic_salary?></td>
                                <td colspan='3'></td>
                                <td colspan='1'>
                                    <table>
                                        <tr>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_late_deduct)?></td>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_absent_deduct)?></td>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_aba_deduct)?></td>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_adv_deduct)?></td>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_lunch_deduct)?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td colspan='1'><?=$total_net_salary?></td>
                                <td  colspan='1'><?=$total_extra_pay?></td>
                                <td  colspan='1'></td>
                                <td colspan='1'><?=$total_modify_salary?></td>
                                
                                <td class='colors4' colspan='1'><?=ceil($total_grand_net_salary)?></td>
                                <td colspan='1'></td> 
                                </tr>
                            </tfoot>
                            <?php
                                $total_grand_net_salary=0;
                                $total_basic_salary=0;
                                $total_net_salary=0;
                                $total_late_deduct=0;
                                $total_absent_deduct=0;
                                $total_aba_deduct=0;
                                $total_adv_deduct=0;
                                $total_lunch_deduct=0;
                                $total_extra_pay=0;
                                $total_modify_salary=0;
                            ?>
                    </table>
                        <div class="ndive">
                            <section style='width: 33%;'>Prepared By</section>
                            <section style='width: 33%;'>Confirmed By</section>
                            <section style='width: 33%;'>Aproved By(Managing Director)</section>
                    </div>
                </div>
           
                <?php
                        
                        // add page number
                        $page_number = ($i+1)/$rows_per_page + 1 ?>
                        

            <div style='margin-top: 132px;'>
                <div style='font-size:18px; font-weight:bold; text-align:center;margin-top:10px'><?=xin_company_info(1)->company_name ?></div>
                <p style="margin: 0;padding: 0;float: right;">Page: <?=  $page_number  ?></p>

                <div style='font-size:14px; font-weight:bold; text-align:center;margin-top:10px'><?=xin_company_info(1)->address_1 ?></div>
                <div style='font-size:12px;align-items: center;text-align: center;'>Salary Month :<?=$salary_month ?></div>

                    </div>
                <div class='fullt'>
                    <table>
                      
                        <thead>
                        <tr>
                            <th class='bnb' style="width: 17px;">SL</th>
                            <th  class='bnb' style="width: 67px;">Name</th>
                            <th  class='bnb' style="width: 70px;">Degi  </th>
                            <th  class='bnb' style='width: 70px;'>Join.d</th>
                            <th  class='bnb' style="width: 60px;">Salary</th>
                            <th style='width: 190px;'>Status</th>
                            <th style='width: 55px;'>Leave</th>
                            <th  style='width:55px;'>Late</th>
                            <th style='width: 200px;'>Deduction</th>
                            <th  class='bnb' style="width: 37px;">Net Salary</th>
                            <th  class='bnb' style="width: 37px;">Extra Pay</th>
                            <th  class='bnb' style="width: 28px;">D.A Day</th>
                            <th  class='bnb' style="width: 42px;">D.A Salary</th>
                            <th  class='bnb ' style="width: 60px;">Grand Net Salary</th>
                            <th  class='bnb' style="width: 37px;">Account Number</th>
                        </tr>
                            <tr>
                                <th  class='bnt'></th>
                                <th  class='bnt'></th>
                                <th  class='bnt'></th>
                                <th  class='bnt'></th>
                                <th  class='bnt'></th>
                                
                                <th>
                                    <table>
                                        <tr>
                                            <th class='r5'>P</th>
                                            <th class='r5'>A</th>
                                            <th class='r5'>W</th>
                                            <th class='r5'>H</th>
                                            <th class='r5'><p style="width: 9px;">E.P</p></th>
                                            <th class='r5'><p style="width: 9px;">ABA</p></th>


                                        </tr>
                                    </table>
                                </th>
                                <th>
                                    <table >
                                        <tr >
                                            <th class=''>E</th>
                                            <th class=''>S</th>
                                        </tr>
                                    </table>
                                </th>
                                <th>
                                    <table>
                                        <tr>
                                            <th  class=''>Day</th>
                                            <th  class=''>D.Day</th>
                                        </tr>
                                    </table>
                                        
                                </th>
                                <th>
                                    <table>
                                        <tr>
                                            <th  class=''>Late</th>
                                            <th  class=''>Abse</th>
                                            <th  class=''>BA</th>
                                            <th  class=''>Adv</th>
                                            <th  class=''>Lunch</th>

                                        </tr>
                                    </table>
                                </th>
                                <th  class='bnt'></th>
                                <th  class='bnt'></th>
                                <th  class='bnt'></th>
                                <th  class='bnt'></th>
                                <th  class='bnt'></th>
                                <th  class='bnt'></th>
                            </tr>
                        </thead>
                    <tbody>
                <?php }
                }
                ?>
                <tfoot style="font-size: 12px;font-weight: bold;">
                    <tr>
                        <td colspan='4'>Total:</td>
                        <td  colspan='1'><?=$total_basic_salary?></td>
                        <td colspan='3'></td>
                        <td colspan='1'>
                            <table>
                                <tr>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_late_deduct)?></td>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_absent_deduct)?></td>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_aba_deduct)?></td>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_adv_deduct)?></td>
                                    <td class="col-md-2" style="font-weight: bold;font-size: 12px;" colspan='1'><?=intval($total_lunch_deduct)?></td>
                                </tr>
                            </table>
                        </td>
                        <td colspan='1'><?=$total_net_salary?></td>
                        <td  colspan='1'><?=$total_extra_pay?></td>
                        <td  colspan='1'></td>
                        <td colspan='1'><?=$total_modify_salary?></td>
                        
                        <td colspan='1'><?=$total_grand_net_salary?></td>
                        <td colspan='1'></td>
                    </tr>
                    <!-- grand total -->
                    <tr>
                        <td colspan='4'>Grand Total:</td>
                        <td  colspan='1'><?=ceil($grand_total_basic_salary)?></td>
                        <td colspan='3'></td>
                        <td colspan='1'>
                            <table>
                                <tr>
                                <td style="width: 20%;font-weight: bold;font-size: 12px;" colspan='1'><?=intval($grand_total_late_deduct)?></td>
                                <td style="width: 20%;font-weight: bold;font-size: 12px;" colspan='1'><?=intval($grand_total_absent_deduct)?></td>
                                <td style="width: 20%;font-weight: bold;font-size: 12px;" colspan='1'><?=intval($grand_total_aba_deduct)?></td>
                                <td style="width: 20%;font-weight: bold;font-size: 12px;" colspan='1'><?=intval($grand_total_adv_deduct)?></td>
                                <td style="width: 20%;font-weight: bold;font-size: 12px;" colspan='1'><?=intval($grand_total_lunch_deduct)?></td>
                                </tr>
                            </table>
                        </td>
                        <td colspan='1'><?=$grand_total_net_salary?></td>
                        <td  colspan='1'><?=$grand_total_extra_pay?></td>
                        <td  colspan='1'></td>
                    
                        <td colspan='1'><?=$grand_total_modify_salary?></td>
                        
                        <td colspan='1'><?=ceil($grand_total_grand_net_salary)?></td>
                        <td colspan='1'></td>
                    </tr>
                </tfoot>


                </table>
                        <div class="ndive">
                            <section style='width: 33%;'>Prepared By</section>
                            <section style='width: 33%;'>Confirmed By</section>
                            <section style='width: 33%;'>Aproved By(Managing Director)</section>
                        </div>
                </div>


            </div>
                <!-- Optional JavaScript -->
                    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                
                    <script>function printPage() {
                    
                  

                    window.print();

                  
                }
                $(document).ready(function(){
    $("#export").click(function(){
        var workbook = XLSX.utils.book_new();
        
        //var worksheet_data  =  [['hello','world']];
        //var worksheet = XLSX.utils.aoa_to_sheet(worksheet_data);
      
        var worksheet_data  = document.getElementById("myTable");
        var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
        
        workbook.SheetNames.push("Test");
        workbook.Sheets["Test"] = worksheet;
      
         exportExcelFile(workbook);
      
     
    });
})

function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "bookName.xlsx");
}










                </script>



    </body>
</html>
