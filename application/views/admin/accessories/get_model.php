<?php
    $rows = $this->db->select('*')->where('cat_id',$_POST["cat_id"])->get('product_accessories_model')->result();
    if(!empty($_POST["cat_id"])) { ?>
        <option value="" disabled>Select</option>
            <?php foreach($rows as $row) {?>
                <option value="<?php echo $row->id; ?>"> <?php echo $row->model_name?> </option>
                <option value="<?php echo $row->id; ?>"  <?php echo (isset($row->model_name) && $row->user_id == $user->user_id)? 'selected':''; ?> ><?php echo $row->model_name ?></option>

            <?php
        }
    }
?>
