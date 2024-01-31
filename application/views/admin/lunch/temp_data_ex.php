
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
   
</body>

</html>