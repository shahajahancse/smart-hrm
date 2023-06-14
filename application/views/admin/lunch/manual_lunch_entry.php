<!-- <a href="<?= base_url('admin/lunch/emp_pay_list') ?>" class="btn btn-primary float-right">Get Payment</a> -->

<h4 style="padding:3px; margin-bottom:5px;"> Manually entry</h3>


<?= form_open(current_url()); ?>
     <div class="row">
     <div class="col-md-4">
      <div class="form-group">
        <label for="from_date">From Date:</label>
        <input type="date" class="form-control" id="from_date" name="from_date" required>
      </div>
      
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" class="form-control" id="end_date" name="end_date" required>
      </div>
    </div>
     </div>
    
    <input type="hidden" name="date" value="<?= date('d-m-Y'); ?>">
    <table class="table table-hover" style="text-align-last: center;">
        <thead>
            <tr>
                <th scope="col">SL</th>
                <th scope="col">Employee</th>
                <th scope="col">Previous Meal</th>
                <th scope="col">Previous Cost</th>
                <th scope="col">Previous Pay</th>
                <th scope="col">Previous Amount</th>
                <th scope="col">Pay Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php   $sql= 'SELECT user_id,first_name,last_name FROM xin_employees';
            $employees = $this->db->query($sql);
            $results=$employees->result(); ?>
             
            <?php foreach ($results as $key => $raw) { ?>
               
                <tr>
                    <input type="hidden" name="empid[]" value="<?= $raw->user_id ?>">
                   

                    <th scope="row"><?= $key + 1 ?></th>
                    <td><?=  $raw->first_name .' '. $raw->last_name; ?></td>
    
                    <td> <input type="number" class="form-control" id="prev_meal" name="prev_meal[]" style="width: 83px;" required ></td>
                    <td> <input type="number" class="form-control" id="prev_cost" name="prev_cost[]" required> </td>
                    <td> <input type="number" class="form-control" id="prev_pay" name="prev_pay[]" required></td>
                    <td> <input type="number" class="form-control" id="prev_amount" name="prev_amount[]" required></td>
                    <td>  <input type="number" class="form-control" id="pay_amount" name="pay_amount[]" required></td>
                   
                </tr>
            <?php } ?>

           
        </tbody>
    </table>

   
    <div class="row">
        <div class="col-md-12">
        <input type="submit" value="Save" class="btn btn-primary pull-right">
        </div>
    </div>
   
<?= form_close(); ?>




