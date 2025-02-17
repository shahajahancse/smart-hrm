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


<!-- < ?php dd($requests);?> -->
<?php  $get_animate = $this->Xin_model->get_content_animate();?>
<div class="<?= $get_animate?>" style="margin-left:15px;margin-top:15px;margin-right: 15px;border-radius: 0px;">
  <div class="">
    <table class="datatables-demo table table-striped table-bordered" id="requested" style="width: 100%;background: white;margin-left: 0px;">
      <thead>
        <tr>
          <th class="text-center" style="width: 50px;">No.</th>
          <th class="text-center">Category</th>
          <th class="text-center">Device Name</th>
          <th class="text-center">Tag</th>
          <th class="text-center">User Name</th>
          <th class="text-center">Status</th>
          <th class="text-center">Floor</th>
          <th class="text-center">Purpose</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($requests as $key => $row) {?>
          <tr>
            <td class="text-center"><?= $key + 1 ?></td>
            <td class="text-center"><?= $row->cat_name ?></td>
            <td class="text-center"><?= $row->model_name ?></td>
            <td class="text-center"><?= "MHL ".$row->cat_short_name.'-'.$row->device_name_id ?></td>
            <td class="text-center"><?= $row->first_name.' '.$row->last_name?></td>
            <td class="text-center">
              <span class="using">
                <?= $row->status== 2?"<i class='fa fa-dot-circle-o' style='color:green'></i> Used": ""?>
              </span>
            </td>
            <td class="text-center"><?= $row->floor == 3 ? "3rd Floor" : ($row->floor == 5 ? "5th Floor" : "Out Side")?></td>
            <td class="text-center"><?= $row->purpose?></td>

            <td class="text-center">
                <div class="dropdown" >
                  <i class="fa fa-ellipsis-v dropdown-toggle btn" style="border:none; background: transparent;box-shadow:none !important;color:black;" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                  <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                    <a class='req_id text-info' style="padding-left:5px; cursor: pointer" href="<?= base_url('admin/inventory/free_device/'.$row->id);?>" ><b>Free Device</b></a><br>
                    </div>
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
