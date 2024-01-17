
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">
<?php
$filename = "Vendor_$first_date+to+$second_date.xls";
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
?>

<body>
    <div style="clear: both;"></div>
    <?php $this->load->view('admin/head_bangla')?>
    <?php 
    $convert_f1=date('d-m-Y', strtotime($first_date));
    $convert_f2=date('d-m-Y', strtotime($second_date));     
    ?>
    <div style="font-size:14px;  text-align:center; margin-bottom:3px">Lunch Report </div>
    <div style="font-size:14px;  text-align:center; margin-bottom:7px"> Date :
        <?php echo $convert_f1; ?> To <?php echo  $convert_f2; ?></div>
    <div style="border: 1px solid black;padding: 0px;margin: 16px;">
        <?php if($status==1){?>
        <table class="table table-hover table-striped" id="myTable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th style="text-align:left">Name</th>
                    <th style="text-align:left">Designation</th>
                    <th>Active.M</th>
                    <th>Inactive.M</th>
                    <th>Employee.C</th>
                    <th>Office.C</th>
                    <th>T.Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $grand_active_meal = 0;
            $grand_inactive_meal  = 0;
            $grand_total_emp_cost  = 0;
            $grand_total_offic_cost   = 0;
            $grand_total_cost    = 0;
            ?>
                <?php foreach ($all_employees as $key=>$employee): ?>
                <tr>
                    <td style="text-align:center"><?= $key+1 ?></td>
                    <td><?= $employee->first_name ?> <?= $employee->last_name ?></td>
                    <td><?= $employee->designation_name?></td>
                    <?php     
                        $this->load->model("Lunch_model"); 
                    $emp_data = $this->Lunch_model->get_data_date_wise($first_date,$second_date, $employee->user_id);
                    $active_meal = 0;
                    $inactive_meal  = 0;
                    $total_emp_cost  = 0;
                    $total_offic_cost   = 0;
                    $total_cost    = 0;

                    foreach ($emp_data['emp_data'] as $key => $row) {
                        if($row->meal_amount>0){
                            $active_meal+=$row->meal_amount;
                        }else{
                            $inactive_meal+=1;
                        };
                        $lunch_package=lunch_package($row->date);
                        $total_emp_cost+=$row->meal_amount*$lunch_package->stuf_give_tk;
                        $total_offic_cost+=$row->meal_amount*$lunch_package->office_give_tk;
                        $total_cost+=$row->meal_amount*$lunch_package->permeal;
                    } ?>
                    <td style="text-align:center"><?= $active_meal ?></td>
                    <td style="text-align:center"><?= $inactive_meal ?></td>
                    <td style="text-align:center"><?= $total_emp_cost ?></td>
                    <td style="text-align:center"><?= $total_offic_cost ?></td>
                    <td style="text-align:center"><?= $total_cost ?></td>
                </tr>
                <?php 
                $grand_active_meal += $active_meal;
                $grand_inactive_meal += $inactive_meal;
                $grand_total_emp_cost  += $total_emp_cost;
                $grand_total_offic_cost   += $total_offic_cost;
                $grand_total_cost    += $total_cost;
            ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan=3 style="text-align: center;font-weight: bold;">Total</td>
                    <td style="text-align:center"><?=  $grand_active_meal?></td>
                    <td style="text-align:center"><?=  $grand_inactive_meal?></td>
                    <td style="text-align:center"><?=  $grand_total_emp_cost?></td>
                    <td style="text-align:center"><?=  $grand_total_offic_cost?></td>
                    <td style="text-align:center"><?=  $grand_total_cost?></td>
                </tr>
            </tfoot>
        </table>
        <?php }else{?>
        <table class="table table-hover table-striped" id="myTable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Meal</th>
                    <th>T.Amount</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $grand_active_meal = 0;
            $grand_total_cost    = 0;  
            $this->load->model("Lunch_model"); 
             $emp_data = $this->Lunch_model->get_data_date_wise_geust($first_date,$second_date);
             $data=$emp_data['emp_data'];
            foreach ($data as $key => $row){
                    $lunch_package=lunch_package($row->date);
                    $grand_active_meal+=$row->guest_m;
                    $grand_total_cost+=$row->guest_m*$lunch_package->permeal;
                ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $row->date ?></td>
                    <td><?= $row->guest_m ?></td>
                    <td><?= $row->guest_cost ?></td>
                    <td><?= $row->guest_ref_comment ?></td>
                </tr>
                <?php } ?>


            </tbody>
            <tfoot>
                <tr>
                    <td colspan=2 style="text-align: center;font-weight: bold;">Total</td>
                    <td><?=  $grand_active_meal?></td>
                    <td><?=  $grand_total_cost?></td>
                </tr>
            </tfoot>
        </table>

        <?php } ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>

    </script>
</body>

</html>