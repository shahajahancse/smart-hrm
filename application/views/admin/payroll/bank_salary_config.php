
<?php
$this->db->select('xin_employees.first_name,xin_employees.last_name,xin_employees.user_id,xin_employees.if_salary_bank,xin_employee_bankaccount.*');
$this->db->from('xin_employees');
$this->db->join('xin_employee_bankaccount', 'xin_employees.user_id = xin_employee_bankaccount.employee_id', 'left');
$this->db->where_in('xin_employees.status',[1,4,5]);
$query = $this->db->get();
$result = $query->result();
?>
<div class="col-md-12"style="display: contents;">
  <table class="table table-bordered table-striped">
    <tr>
      <th>Sl</th>
      <th>Employee Name</th>
      <th>Salary On Bank</th>
      <th>Account Title</th>
      <th>Account Number</th>
      <th>Bank Name</th>
      <th>Bank Branch</th>
      <th>Created At</th>
    </tr>
    <?php $i = 1; foreach($result as $res): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td><?= $res->first_name.' '.$res->last_name ?></td>
      <td>
      <input type="checkbox" name="" 
      onchange="salary_on_bank(<?= $res->user_id ?>,this.checked)"
       id="bank_check" 
       <?= $res->if_salary_bank == 1 && $res->account_number != '' ? 'checked' : ''?> 
       <?= 
       $res->account_number == '' ? 'disabled' : ''?>>
      </td>
      <td><?= $res->account_title ?></td>
      <td><?= $res->account_number ?></td>
      <td><?= $res->bank_name ?></td>
      <td><?= $res->bank_branch ?></td>
      <td><?= date('d-m-Y',strtotime($res->created_at)) ?></td>
    </tr>
    <?php endforeach; ?>
  <table>

  </table>
</div>
<script>
function salary_on_bank(id,checked){
  $.ajax({
    type:'POST',
    url:'<?= base_url('admin/payroll/salary_on_bank') ?>',
    data:{'user_id':id,'checked':checked},
    success:function(data){
      //console.log(data);
    }
  });
}
</script>

