<h3>Today Lunch</h3>
               
               <?php echo form_open('admin/lunch/add_lunch');?>
               <input type="hidden" name="date" value="<?=$date?>">
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
                            <input type="hidden" name="empid[]" value="<?= $raw->user_id?>">
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
                           <input type="hidden" name="empid[]" value="<?= $data->user_id?>">

                               <th scope="row"><?=$key+1?></th>
                               <td><?= $data->first_name?> <?= $data->last_name?></td>
                               <td>Absent</td>
                               <td><input type="number" name="m_amount[]" value=0 style="width: 83px;"></td>
                               <td><input type="text" name="comment[]"></td>
                           </tr>
                       <?php } ?>
                       <tr> <td colspan="5"><p style="font-size: 18px;color: black;background-color: aquamarine;">Guest</p></td></tr>
                           <tr>
                               <th scope="row">1</th>
                               <td>Guest</td>
                               <td>-</td>
                               <td><input type="number" name="guest" value=0 style="width: 83px;"></td>
                               <td><input type="text" name="guest_comment"></td>
                           </tr>
                       
                   </tbody>
               </table>
             
                <!-- <div class="form-group">
                    <label >Guest Meal</label>

                    <input type="number" class="form-control-file">
                </div> -->
                <div class="form-group">
                    <label >Comment</label>

                    <textarea name="bigcomment" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <input type="submit" value="Save"  class="btn btn-primary">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

               <?php echo form_close(); ?>