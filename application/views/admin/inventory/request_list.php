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
          <th class="text-center">Tag No</th>
          <th class="text-center">User Name</th>
          <th class="text-center">Status</th>
          <th class="text-center">Purpose</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($requests as $key => $row) { ?>
          <tr>
            <td class="text-center"><?= $key + 1 ?></td>
            <td class="text-center"><?= $row->cat_name ?></td>
            <td class="text-center"><?= $row->model_name ?></td>
            <td class="text-center"><?= "MHL ".$row->cat_short_name.'-'.$row->device_name_id ?></td>
            <td class="text-center"><?= $row->first_name.' '.$row->last_name?></td>
            <td class="text-center">
              <span class="using">
                <?= $row->status==1 ?"<i class='fa fa-dot-circle-o' style='color:#ffda00'></i> Pending": "<i class='fa fa-dot-circle-o' style='color:green'></i> Active"?>
              </span>
            </td>
            <td class="text-center"><?= $row->purpose?></td>
            <td class="text-center">
              <div class="dropdown" >
                <i class="fa fa-ellipsis-v dropdown-toggle btn" style="border:none;color:black; background: transparent;box-shadow:none !important" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu" style=" min-width: 100px !important;border-radius:0;line-height: 1.7;  "  aria-labelledby="dropdownMenuButton">
                  <a class='req_id text-info'  data-toggle="modal" data-target="#requested_listt" style="padding-left:5px; cursor: pointer"  data-id="<?php echo $row->id?>" data-status="<?php echo $row->status?>"  ><b>Approved</b></a><br>
                  <a class="text-danger"style="padding-left:5px;" href="<?= base_url('admin/inventory/delete_request/'.$row->id);?>"><b>Delete</b></a>
                </div>
              </div>
          </tr>
        <?php }?>
      </tbody>
    </table>
  </div>
</div>


<div class="modal fade" id="requested_listt" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Requested List</h4>
      </div>
      <div class="modal-body">      
        <table class="table table-bordered" style="width:100%">
          <thead>
            <tr>
              <th class="text-left" style="">Status</th>
              <th class="text-left" >Floor</th>
              <th class="text-left" >Remark</th>
            </tr>
          </thead>
          <tbody>
              <tr>
                <input type="hidden" id="item_hid" value="">
                <td>
                    <select class="form-control status_id" id="statuss">
                        <option value="2">Active</option>
                        <option value="1">Pending</option>
                    </select>
                </td>
                <td>
                    <select class="form-control"  id="floor_id">
                        <option value="3">3rd Floor</option>
                        <option value="5">5th Floor</option>
                    </select>
                </td>
                <td>
                    <textarea name="remark" id="remark" class="form-control"></textarea>
                </td>
              </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
        <button id="submit" type="submit" class="btn btn-sm btn-success">Update</button>
      </div>
    </div>
  </div>
</div>

 <script type="text/javascript">
    $(document).ready(function () {
      $('#requested').DataTable();
      $('.req_id').on('click', function (e) {
        var val = $(this).attr("data-id");
        var status = $(this).attr("data-status");
        $('#item_hid').val(val);
        if(status == 1){
            $('#statuss option[value="' + status + '"]').prop('selected', true);
        }
      });
      $('#submit').on('click', function () {
        var item_id = $('#item_hid').val();
        var status  = $('.status_id').val();
        var floor   = $('#floor_id').val();
        var remark  = $('#remark').val();
        url = "<?php echo base_url('admin/inventory/request_edit/');?>";
        $.ajax({
          type: "POST",
          data: { 'status': status ,'floor': floor ,'remark': remark, 'item_id': item_id },
          url:  url + item_id,
          success: function (response) {
            if(response){
              $('#requested_listt').modal('hide');
              showSuccessAlert(response);
            }
          }
        });
      });
    });
  </script>
