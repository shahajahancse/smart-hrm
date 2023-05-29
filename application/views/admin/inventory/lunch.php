<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3" >
      <h3>Today Lunch</h3>
               
                <?php echo form_open('admin/lunch/add_lunch/');?>
                <table class="table table-hover" style="text-align-last: center;">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">P.Status</th>
                            <th scope="col">M.Amount</th>
                            <th scope="col">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($active as $key=>$raw){?>
                            <tr>
                                <th scope="row"><?=$key+1?></th>
                                <td><?= $raw->first_name?> <?= $raw->last_name?></td>
                                <td>Present</td>
                                <td><input type="number" name="m_amount[]" value=1 style="width: 83px;"></td>
                                <td><input type="text" name="comment[]"></td>
                            </tr>
                        <?php } ?>

                        <tr> <td colspan="5"><p style="font-size: 18px;color: black;background-color: aquamarine;">Inactive</p></td></tr>

                        <?php foreach ($inactive as $key=>$data){?>
                            <tr>
                                <th scope="row"><?=$key+1?></th>
                                <td><?= $data->first_name?> <?= $data->last_name?></td>
                                <td>Absent</td>
                                <td><input type="number" name="m_amount[]" value=1 style="width: 83px;"></td>
                                <td><input type="text" name="comment[]"></td>
                            </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
                    <input type="submit" value="Save" class="btn btn-primary">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <?php echo form_close(); ?>
    </div>
  </div>
</div>