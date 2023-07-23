<?php
    if(!empty($rows)) { ?>
        <option value="" >Select</option>
        <?php foreach($rows as $row) {?>
            <option value="<?php echo $row->id; ?>"> <?php echo $row->model_name?> </option>
        <?php  }
    } else { ?>
        <option value="" >Select</option>
<?php } ?>
