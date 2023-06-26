<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        th, td {
            padding: 0!important;
            margin: 0!important;
        }
        table{
            margin: 0px 4px !important;
        }
   </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php $this->load->view('admin/head_bangla')?>
    <span style="justify-content: center;display: flex;">Lunch Report of <?= $first_date?> to <?= $second_date?></span>

    <div style="border: 1px solid black;padding: 0px;margin: 16px;">
  <table class="table table-hover table-striped" id="myTable" >
    <thead>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Active.M</th>
            <th>Inactive.M</th>
            <th>Employee.C</th>
            <th>Office.C</th>
            <th>T.Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($all_employees as $key=>$employee): ?>
        <tr>
            <td><?= $key+1 ?></td>
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
                    $total_emp_cost+=$row->meal_amount*45;
                    $total_offic_cost+=$row->meal_amount*45;
                    $total_cost+=$row->meal_amount*90;






                }

            
            ?>
            <td><?= $active_meal ?></td>
            <td><?= $inactive_meal ?></td>
            <td><?= $total_emp_cost ?></td>
            <td><?= $total_offic_cost ?></td>
            <td><?= $total_cost ?></td> 
        </tr>
        <?php endforeach; ?>

    </tbody>
</table>
</div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script>

  </script>


</body>
</html>