<style>
.dropdown-item {
    padding: 4px;
    margin: 5px;
    width: 72px;
    height: 28px;
    text-align: center;
    border: 1px solid #0177bc;
    border-radius: 4px;
    /* New style for dropdown-item */
    background-color: #f8f9fa;
    color: #212529;
    transition: box-shadow 0.3s, color 0.3s;
}

.dropdown-item:hover {
    /* Hover effect */
    box-shadow: 0 0 5px #0177bc;
    color: #fff;
}

.dropdown-menu {
    min-width: 85px !important;
}

.btn {
    padding: 3px !important;
}
</style>


<div class="container-fluid">
    <?php if($this->session->flashdata('message')):?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('message');?>
    </div>
    <?php endif; ?>

    <div class="table-responsive">
      <?= $lunch_list_table ?>
    </div>
</div>

<script>
function hrp(id, status) {
    console.log(id, status);
    $.ajax({
        url: '<?= base_url('admin/lunch/sethrp') ?>', // Replace with the URL to send the request
        method: 'POST', // Replace with the desired HTTP method (POST, GET, etc.)
        data: {
            id: id,
            status: status,
        },
        success: function(response) {
            showSuccessAlert(response);
        },
        error: function(xhr, status, error) {
            console.log(error);


        }
    });

}
</script>