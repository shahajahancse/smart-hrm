<style>
    .row-gap{
        display: flex;
        flex-direction: row;
        gap: 10px;
    }
    @media screen and (max-width: 991px) {
        .row-gap{
            flex-direction: column;
        }
    }
    .card{
        padding: 10px;
    }
</style>
<div class="col-md-12">
    <div class="row row-gap">
        <div class="col-md-6 card">
            <div class="form-group">
                <label for="">Select Employee</label><br>
                <select name="employee_id" id="employee_id" class="form-control">
                    <option value="">Select Employee</option>
                    <?php
                      $employees = $this->db->where('user_role_id', 3)->where('is_active', 1)->get('xin_employees')->result();
                      foreach ($employees as $key => $value) { ?>
                        <option value="<?= $value->user_id ?>"><?= $value->first_name.' '.$value->last_name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-6 card">
            hello
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#employee_id').select2()
        $('#employee_id').on('change', function(){
            
            var employee_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?= site_url('admin/accessories/employee_using_device_list') ?>",
                data: {employee_id: employee_id},
                success: function(data){
                    console.log(data);
                }
            })
            
        })
    })
</script>