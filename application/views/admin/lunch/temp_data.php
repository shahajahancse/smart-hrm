
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">

  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>


  <div class=""> 
  <?php $this->load->view('admin/head_bangla')?>
  <a class="btn btn-primary" style="float: right;" href="<?= base_url() ?>admin/lunch/temp_data_ex">Xml</a>
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>sl</th>
                    <th>Employee name</th>
                    <th> December  / <?= $first_date ?> to <?= $madal_date_f ?> Meal</th>
                    <th> December  Amount</th>
                    <th> January / <?= $madal_date_s ?> to <?= $second_date ?> Meal</th>
                    <th> January Amount</th>
                    <th> Total Meal</th>
                    <th>Balance</th>
                    <th> Total Amount</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $j_am=0;
                $d_am=0;
                $t_am=0;

                
                
                foreach($employee_id as $key => $id):
                    $this->db->select('first_name, last_name'); 
                    $this->db->where('user_id', $id);
                    $emp = $this->db->get('xin_employees')->row();
                    ?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td><?= $emp->first_name.' '.$emp->last_name ?></td>


                            <?php
                                $this->db->select('sum(case when meal_amount=1 then 1 else 0 end) as count');
                                $this->db->where('date BETWEEN "'.$first_date.'" AND "'.$madal_date_f.'"');
                                $this->db->where('emp_id', $id);
                                $december=$this->db->get('lunch_details')->row();

                                $this->db->select('sum(case when meal_amount=1 then 1 else 0 end) as count');
                                $this->db->where('date BETWEEN "'.$madal_date_s.'" AND "'.$second_date.'"');
                                $this->db->where('emp_id', $id);
                                $january=$this->db->get('lunch_details')->row();
                             ?>
                        <td><?= $december->count ?></td> 
                        <td><?= $december->count*45 ?></td> 

                        <?php  
                         $j_am += $january->count;
                         $d_am += $december->count;
                         $t_am += $december->count + $january->count;
                        ?>
                        <td><?= $january->count ?></td>  
                        <td><?= $january->count*50 ?></td>  
                        <td><?= $december->count + $january->count ?></td>
                        <td><?= 22-($december->count + $january->count)?></td>

                        <td><?= $december->count*45 + $january->count*50?></td>
                    </tr>
               <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td><?= $d_am ?></td>
                    <td></td>
                    <td><?= $j_am ?></td>
                    <td></td>
                    <td><?= $t_am ?></td> 
                    <td></td> 
                </tr>
            </tfoot>
        </table>
    </div>
  </div>
      
























    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
