<style>
  .using {
    display: inline-flex;
    padding: 4.5px 14.3px 5.5px 9px;
    align-items: center;
    gap: 9px;
    border-radius: 50px;
    border: 1px solid #CCC;
    background: #FFF;
   
}
</style>
<?php  $get_animate = $this->Xin_model->get_content_animate();?>
<div class="<?= $get_animate?>" style="margin-left:15px;margin-top:15px;margin-right: 15px;border-radius: 0px;">
  <div class="">
    <table class="datatables-demo table table-striped table-bordered" id="requested" style="width: 100%;background: white;margin-left: 0px;">
      <thead>
        <tr>
          <th class="text-center" style="width: 50px;">No.</th>
          <th class="text-center">Category</th>
          <th class="text-center">Device Name</th>
          <th class="text-center">Tag No</th>
          <th class="text-center">Status</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($requests as $key => $row) {  ?>
          <tr>
            <td class="text-center"><?= $key + 1 ?></td>
            <td class="text-center"><?= $row->cat_name ?></td>
            <td class="text-center"><?= $row->model_name ?></td>
            <td class="text-center"><?= "MHL ".$row->cat_short_name.'-'.$row->device_name_id ?></td>
            <td class="text-center">
              <span class="using">
                <?= $row->status == 5 && $row->move_status == 1 ? "<i class='fa fa-dot-circle-o' style='color:red'></i> Not Used": "<i class='fa fa-dot-circle-o' style='color:green'></i> Used"?>
              </span>
            </td>
            <td class="text-center">
                <div class="dropdown" >
                  <?php if($row->status == 5 && $row->move_status == 1){?>
                  <i class="fa fa-ellipsis-v dropdown-toggle btn" style="border:none; background: transparent;box-shadow:none !important;color:black" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                  <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                    <a class='req_id text-info'  data-toggle="modal" data-target="#requested_listt" style="padding-left:5px; cursor: pointer"  data-id="<?php echo $row->id?>" data-status="<?php echo $row->status?>"  ><b>Edit</b></a><br>
                    <a class="text-danger"style="padding-left:5px;" href="<?= base_url('admin/inventory/delete_request/'.$row->id);?>"><b>Delete</b></a>
                  </div>
                  <?php }?>
                </div>
            </td>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
      $('#requested').DataTable();
    });
</script>