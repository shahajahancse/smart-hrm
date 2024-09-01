<!DOCTYPE>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Yerly Leave</title>
    <style>

    </style>


</head>

<body>
    <div class="container" align="center">
		<?php $this->load->view('admin/head_bangla'); ?>
		<span>Earn Leave List of <?php echo date('Y', strtotime($date)); ?></span>
		<br>
		<br>
        <table style="width: 90%; border-collapse: collapse;" border=1 >
            <thead>
                <tr>
                    <th>Sl</th>
                    <th>Name</th>
                    <th>Join date</th>
                    <th>Designation</th>
                    <th>Salary</th>
                    <th>Total Leave</th>
                    <th>Obtained Leave</th>
                    <th>Balance Leave</th>
                    <th>Net Payable Amount</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
                <?php
					$absent_count  = 0;
					$total=0;
					$i=1;
					foreach ($all_employees as $key => $value) {  
						$year = date('Y', strtotime($date));
						$total_leave=cals_leave($value->user_id,$year);						
						$user_id = $value->user_id;
						$this->db->where('emp_id', $user_id);
						$this->db->where('effective_date >=' , date('Y-12-t', strtotime($date)));
						$this->db->order_by('id', 'DESC');
						$s_data=$this->db->get('xin_employee_incre_prob')->row();
						if (!empty($s_data)){
							$salary = $s_data->old_salary;
						}else {
							$salary = $value->salary;
						}
						if (empty($total_leave) || $total_leave->el_balanace <= 0) {
							continue;
						}

						if ($value->date_of_joining > date('Y-01-01', strtotime($date))) {
							continue;
						}

						if ($value->user_id == 46) {
							continue;
						}

						$total+=!empty($total_leave)?ceil(($salary/30)*$total_leave->el_balanace):0;
						?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $value->first_name ?> <?= $value->last_name ?></td>
                    <td><?= $value->date_of_joining ?></td>
                    <td><?= $value->designation_name ?></td>
                    <td style="text-align:right"><?= $salary ?></td>
					<td style="text-align:right"><?= !empty($total_leave)?$total_leave->el_total: 'Not Active' ?></td>
					<td style="text-align:right"><?= !empty($total_leave)?($total_leave->el_total-$total_leave->el_balanace):'Not Active' ?></td>
					<td style="text-align:right"><?= !empty($total_leave)?$total_leave->el_balanace:'Not Active' ?></td>
					<td style="text-align:right"><?= !empty($total_leave)?ceil(($salary/30)*$total_leave->el_balanace):'0'  ?></td>
					<td></td>
                </tr>
                <?php
				$i++;	
					
					}
				?>
				<tr>
			
					<th colspan=8>
						Total
					</th>
					<th style="text-align:right">
						<?= $total?>
					</th>

				
				</tr>
            </tbody>
        </table>
		<br><br>
		<div class="col-md-12" style="display: flex;flex-direction: row;justify-content: space-evenly;margin-top: 50px;">
			<div class="col-md-4">Prepared By</div>
			<div class="col-md-4">Check By</div>
			<div class="col-md-4">Director</div>
			<div class="col-md-4">Managing Director</div>
		</div>
    </div>
</body>

</html>