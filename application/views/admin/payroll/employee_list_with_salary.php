<div class="card <?php echo $get_animate;?>"> >
<table>
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
        $this->db->from('xin_employees');
        $employee_list = $this->db->get()->result();
        dd($employee_list);
        foreach($employee_list as $employee) { ?>
            <tr>
                <td>
                    <a href="javascript:void(0);"> <?php echo $employee->first_name.' '.$employee->last_name; ?> </a>
                </td>
                <td>
                    <a href="javascript:void(0);"> <?php echo $employee->salary; ?> </a>
                </td>
                <td>
                    <a href="javascript:void(0);"> <?php echo $employee->image; ?> </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>