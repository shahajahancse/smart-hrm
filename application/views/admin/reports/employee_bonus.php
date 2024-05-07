<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    

  <table class="table">
    <thead>
        <tr><th colspan="4"><h1>With out Intern 1 Year Employee</h1></th></tr>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Date of Joining</th>
            <th>Salary</th>
        </tr>
    </thead>
    <tbody>

        <?php
        		$employee=$this->db->where_in('user_id',$no_intern_one_year)->get('xin_employees')->result();
        		foreach ($employee as $key => $value) {
        			?>
        			<tr>
        				<td><?= $key+1 ?></td>
        				<td><?= $value->first_name." ".$value->last_name ?></td>
        				<td><?= $value->date_of_joining ?></td>
        				<td><?= $value->salary ?></td>
        			</tr>
      <?php }
      ?>

    </tbody>

  </table>
  <br><br>
  <h1></h1>
  <table class="table">
    <thead>
    <tr><th colspan="4"><h1>With Intern 1 Year Employee</h1></th></tr>

        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Date of Joining</th>
            <th>Salary</th>
        </tr>
    </thead>
    <tbody>

        <?php
        		$employee=$this->db->where_in('user_id',$joining_one_year)->get('xin_employees')->result();
        		foreach ($employee as $key => $value) {
        			?>
        			<tr>
        				<td><?= $key+1 ?></td>
        				<td><?= $value->first_name." ".$value->last_name ?></td>
        				<td><?= $value->date_of_joining ?></td>
        				<td><?= $value->salary ?></td>
        			</tr>
      <?php }?>

    </tbody>

  </table>

  <br><br>
  <h1>Non 1 Year Employee</h1>

  <table class="table">
    <thead>
    <tr><th colspan="4"><h1>Non 1 Year Employee</h1></th></tr>

        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Date of Joining</th>
            <th>Salary</th>
        </tr>
    </thead>
    <tbody>

        <?php
        		$employee=$this->db->where_in('user_id',$no_year)->get('xin_employees')->result();
        		foreach ($employee as $key => $value) {
        			?>
        			<tr>
        				<td><?= $key+1 ?></td>
        				<td><?= $value->first_name." ".$value->last_name ?></td>
        				<td><?= $value->date_of_joining ?></td>
        				<td><?= $value->salary ?></td>
        			</tr>
      <?php }  ?>

    </tbody>

  </table>






















    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>