<style>
    body {
        background-color: #fff;
        font-family: 'Arial', sans-serif;
        color: #000;
    }

    .emp-summary {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    justify-content: center;
}

.emp-summary .emp-item {
    width: 90%;
    max-width: 246px;
    padding: 20px;
    border-radius: 12px;
    background-color: #fff;
    border: 1px solid #000;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    text-align: left;
    transition: transform 0.3s, box-shadow 0.3s;
}

    /* .emp-summary .emp-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    } */

    .emp-summary .emp-item .emp-title {
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 18px;
    }

    .emp-summary .emp-item .emp-content {
        font-size: 14px;
    }

    .emp-summary .emp-item .emp-content .emp-label {
        font-weight: bold;
        margin-right: 10px;
    }

    .emp-summary .emp-item .emp-content div {
        margin-bottom: 8px;
    }

    .emp-summary .emp-item img {
    width: 249;
    height: 200;
    border-radius: 8px;
    margin-bottom: 10px;
}
</style>

<div class="emp-summary">
    <?php
    $page_brack=4;

    $item=0;
    
    foreach($all_employees as $emp): 
    $item=$item+1;
    ?>
    <div class="emp-item">
        <div class="emp-title"><?php echo $emp->first_name.' '.$emp->last_name; ?></div>
        <div class="emp-content">
            <div><img src="<?php echo (file_exists(FCPATH . 'uploads/profile/' . $emp->profile_picture) ? base_url('uploads/profile/') . $emp->profile_picture : base_url('uploads/profile/default_male.jpg')); ?>" alt=""></div>
            <div><span class="emp-label">Employee ID:</span> <?php echo $emp->employee_id; ?></div>
            <div><span class="emp-label">Designation:</span> <?php echo $emp->designation_name; ?></div>
            <div><span class="emp-label">Department:</span> <?php echo $emp->department_name; ?></div>
            <div><span class="emp-label">Date of Joining:</span> <?php echo date('d-m-Y', strtotime($emp->date_of_joining)); ?></div>
            <div><span class="emp-label">Date of Birth:</span> <?php echo date('d-m-Y', strtotime($emp->date_of_birth)); ?></div>
            <div><span class="emp-label">Marital Status:</span> <?php echo $emp->marital_status; ?></div>
            <div><span class="emp-label">Salary:</span> <?php echo $emp->salary; ?></div>
            <!-- <div><span class="emp-label">Shift:</span> <?php echo $emp->shift_id; ?></div> -->
            <!-- <div><span class="emp-label">Notify Increment/Probation:</span> <?php echo date('d-m-Y', strtotime($emp->notify_incre_prob)); ?></div> -->
            <!-- <div><span class="emp-label">Leave Effective:</span> <?php echo date('d-m-Y', strtotime($emp->leave_effective)); ?></div> -->
        </div>
    </div>
    <?php

    if ($item==$page_brack) {
        $item=0;
       echo '<div style="page-break-after: always;"></div>';
    }


endforeach; ?>
</div>
