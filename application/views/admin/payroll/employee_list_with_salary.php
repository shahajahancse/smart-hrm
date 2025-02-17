

<div>
<table class="table">
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Salary</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $this->db->select('*');
        $this->db->where('company_id', 1);
        $this->db->where_in('status', [1,4,5]);
        $this->db->order_by('salary', 'desc');
        $this->db->from('xin_employees');
        $employee_list = $this->db->get()->result();
        foreach($employee_list as $employee) { 
            ?>
            <tr>
                <td>
                   <?php echo $employee->first_name.' '.$employee->last_name; ?> 
                </td>
                <td>
                   <?php echo $employee->salary; ?>
                </td>
                <td>
                    <img style="height: 100px;width: 100px;" src="<?php echo base_url().'uploads/profile/'.$employee->profile_picture; ?>" alt=""> 
                    <a href="<?php echo base_url().'uploads/profile/'.$employee->profile_picture; ?>" download="<?php echo $employee->first_name.' '.$employee->last_name; ?>.png">
                        <button class="btn btn-primary">Download</button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>

    <!-- Bootstrap CSS -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
