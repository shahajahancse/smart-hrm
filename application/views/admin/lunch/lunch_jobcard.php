<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Job Card</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container" align="center">

        <?php
// dd($all_employees);

$active_meal = 0;
$inactive_meal  = 0;
$total_emp_cost  = 0;
$total_emp_cost   = 0;
$total_cost    = 0;
$this->load->model('lunch_model');

foreach ($all_employees as $key => $value) { 
?>

        <div style='min-height:700px; overflow:hidden;'>
            <?php
    $active_meal = 0;
    $inactive_meal  = 0;
    $total_emp_cost  = 0;
    $total_offic_cost   = 0;
    $total_cost    = 0;

	$this->load->view('admin/head_bangla');
	?>

            <span style='font-size:13px; font-weight:bold;'>
                <?php echo "lunch Report from  $first_date -TO- $second_date"; ?>
            </span>
            <br /><br />

            <table border='0' style='font-size:13px;' width='480'>
                <tr>
                    <td width='70'>
                        <strong>Emp ID:</strong>
                    </td>
                    <td width='200'>
                        <?php echo $value->employee_id; ?>
                    </td>

                    <td width='55'>
                        <strong>Name :</strong>
                    </td>
                    <td width='150'>
                        <?php echo $value->first_name ." ". $value->last_name; ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>Dept :</strong>
                    </td>
                    <td>
                        <?php echo $value->department_name; ?>
                    </td>
                    <td>
                        <strong>Desig :</strong>
                    </td>
                    <td>
                        <?php echo $value->designation_name; ?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>DOJ :</strong>
                    </td>
                    <td>
                        <?php echo date("d-M-Y", strtotime($value->date_of_joining)); ?>
                    </td>

                    <td>
                        <strong>DOB :</strong>
                    </td>
                    <td>
                        <?php echo date("d-M-Y", strtotime($value->date_of_birth)); ?>
                    </td>
                </tr>
            </table>

            <?php
	$emp_data = $this->lunch_model->get_data_date_wise($first_date,$second_date, $value->user_id);
	//  dd($emp_data['emp_data'] );
	?>

            <table class='table table-bordered table-sm   table-striped sal mt-2'
                style='text-align:center; font-size:13px; '>
                <th>Date</th>
                <th>Day</th>
                <th>Quantity</th>
                <th>Employee-Cost</th>
                <th>Office-Cost</th>
                <th>Total</th>
                <th>Remarks</th>

                <?php foreach ($emp_data['emp_data'] as $key => $row) { 
                    if(!$row->meal_amount>0){
                        continue;
                    }
                   $lunch_package=lunch_package($row->date);

                    
                    ?>
                <tr>
                    <td>&nbsp;
                        <?php echo $row->date; ?>
                    </td>

                    <td>&nbsp;
                        <?php
					if($row->date == "")
					{
						echo "&nbsp;";
					}
					else
					{
						echo date('l',strtotime($row->date));
					}
					?>
                    </td>

                    <td>&nbsp;
                        <?php echo $row->meal_amount;
					if($row->meal_amount>0){
						$active_meal+=$row->meal_amount;
					}else{
						$inactive_meal+=1;
					};
					?>
                    </td>

                    <td>&nbsp;
                        <?php echo $row->meal_amount*$lunch_package->stuf_give_tk;
					$total_emp_cost+=$row->meal_amount*$lunch_package->stuf_give_tk;
					?>
                    </td>

                    <td>&nbsp;
                        <?php echo $row->meal_amount*$lunch_package->office_give_tk;
					$total_offic_cost+=$row->meal_amount*$lunch_package->office_give_tk;
					?>
                    </td>

                    <td>&nbsp;
                        <?php echo $row->meal_amount*$lunch_package->permeal;
					$total_cost+=$row->meal_amount*$lunch_package->permeal;
					?>
                    </td>

                    <td>&nbsp;
                        <?php echo $row->comment; ?>
                    </td>
                </tr>
                <?php } ?>

            </table>

            <br>
            <table class='table table-bordered table-sm' style='font-size:13px;'>
                <tr align='center'>
                    <td>
                        ACTIVE MEAL
                    </td>
                    <!-- <td>
                        INACTIVE MEAL
                    </td> -->
                    <td>
                        TOTAL EMPLOYEE COST
                    </td>
                    <td>
                        TOTAL OFFICE COST
                    </td>
                    <td>
                        TOTAL COST
                    </td>
                </tr>

                <tr align='center'>
                    <td>
                        <?php echo $active_meal; ?>
                    </td>
                    <!-- <td>
                        <?php //echo $inactive_meal; ?>
                    </td> -->
                    <td>
                        <?php echo $total_emp_cost; ?>
                    </td>
                    <td>
                        <?php echo $total_offic_cost; ?>
                    </td>
                    <td>
                        <?php echo $total_cost; ?>
                    </td>
                </tr>
            </table>
            <br /><br />

        </div>
        <br>
        <?php } ?>

    </div>
</body>

</html>