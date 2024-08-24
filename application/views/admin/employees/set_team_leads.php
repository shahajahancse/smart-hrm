
<?php
  $this->db->where_in('status', [1,4,5]);
  $this->db->order_by('is_emp_lead', 'DESC');
  $employees = $this->db->get('xin_employees')->result();
?>
<style>
.content {
    display: flex;
}
th td{
  text-align: center;
}
</style>

<div class="col-md-12">
  <table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th class="text-center">SL</th>
      <th >Employee Name</th>
      <th class="text-center">Is Team Lead</th>
      <th>Set Leader</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($employees as $key => $e) { ?>

    <tr>
      <td  class="text-center"><?= $key+1 ?></td>
      <td ><?= $e->first_name.' '.$e->last_name ?></td>
      <td  class="text-center">
          <input onchange="setTeamLead(<?= $e->user_id ?>,this)" type="checkbox" <?= $e->is_emp_lead==2 ? 'checked' : ''?> >
      </td>
      <td>
        <select name="team_lead" id="team_lead" class="team_lead" onchange="changeTeamLead(<?= $e->user_id?>,this.value)">
          <option >Select Team Lead</option>
          <?php
            
            $this->db->where('is_emp_lead', 2);
            $this->db->where_not_in('user_id',$e->user_id);
            $employ = $this->db->get('xin_employees')->result();
           foreach($employ as $employee) { ?>
            <option <?= $e->lead_user_id==$employee->user_id ? 'selected' : ''?> value="<?=$employee->user_id ?>"><?= $employee->first_name.' '.$employee->last_name ?></option>
          <?php } ?>
        </select>
      </td>
    </tr>
    <?php } ?>
  </tbody>
  </table>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    $('.team_lead').select2();
  })
  function setTeamLead(user_id,el){ 
    var d
    el.checked ? d = 2 : d = 1
   
    $.ajax({
      type: 'POST',
      url: '<?= base_url('admin/employees/set_team_lead_ajax') ?>',
      data: {user_id:user_id, d:d},
      success: function(response){
        console.log(response);
      }
    })
    
  }
  function changeTeamLead(user_id,team_lead){ 

    $.ajax({
      type: 'POST',
      url: '<?= base_url('admin/employees/changeTeamLead') ?>',
      data: {user_id:user_id, team_lead:team_lead},
      success: function(response){
        console.log(response);
      }
    })
    
  }
</script>