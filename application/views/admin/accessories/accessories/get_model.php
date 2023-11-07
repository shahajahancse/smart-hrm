<?php
    if(!empty($models)) { ?>
        <option value="" >Select</option>
        <?php foreach($models as $model) {?>
            <option value="<?php echo $model->id; ?>" <?php echo $model->id == $deivice_id ? 'selected':'' ?> > <?php echo $model->model_name?> </option>
        <?php  }
    } else { ?>
        <option value="" >Select</option>
<?php } ?>
