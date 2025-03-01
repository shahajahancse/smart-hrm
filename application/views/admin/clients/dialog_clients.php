<?php
defined('BASEPATH') or exit('No direct script access allowed');
if(isset($_GET['jd']) && isset($_GET['client_id']) && $_GET['data'] == 'client') {
    ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title" id="edit-modal-data"><i class="icon-pencil7"></i>
        <?php echo $this->lang->line('xin_project_edit_client');?></h4>
</div>
<?php $attributes = array('name' => 'edit_client', 'id' => 'edit_client', 'autocomplete' => 'off', 'class' => 'm-b-1');?>
<?php $hidden = array('_method' => 'EDIT', '_token' => $client_id, 'ext_name' => $name);?>
<?php echo form_open('admin/clients/update/'.$client_id, $attributes, $hidden);?>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="company_name"><?php echo $this->lang->line('xin_client_name');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_client_name');?>" name="name"
                    type="text" value="<?php echo $name;?>">
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="company_name"><?php echo $this->lang->line('xin_company_name');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_company_name');?>"
                            name="company_name" type="text" value="<?php echo $company_name;?>">
                    </div>
                    <div class="col-md-6">
                        <label for="contact_number"><?php echo $this->lang->line('xin_contact_number');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_contact_number');?>"
                            name="contact_number" type="text" value="<?php echo $contact_number;?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="email"><?php echo $this->lang->line('xin_email');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_email');?>"
                            name="email" type="email" value="<?php echo $email;?>">
                    </div>
                    <div class="col-md-6">
                        <label for="website"><?php echo $this->lang->line('xin_website');?></label>
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_website_url');?>"
                            name="website" value="<?php echo $website_url;?>" type="text">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="address"><?php echo $this->lang->line('xin_address');?></label>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_1');?>"
                    name="address_1" type="text" value="<?php echo $address_1;?>">
                <br>
                <input class="form-control" placeholder="<?php echo $this->lang->line('xin_address_2');?>"
                    name="address_2" type="text" value="<?php echo $address_2;?>">
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_city');?>"
                            name="city" type="text" value="<?php echo $city;?>">
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_state');?>"
                            name="state" type="text" value="<?php echo $state;?>">
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" placeholder="<?php echo $this->lang->line('xin_zipcode');?>"
                            name="zipcode" type="text" value="<?php echo $zipcode;?>">
                    </div>
                </div>
                <br>
                <select class="form-control" name="country" data-plugin="select_hrm"
                    data-placeholder="<?php echo $this->lang->line('xin_country');?>">
                    <option value=""><?php echo $this->lang->line('xin_select_one');?></option>
                    <?php foreach($all_countries as $country) {?>
                    <option value="<?php echo $country->country_id;?>" <?php if($countryid == $country->country_id):?>
                        selected="selected" <?php endif;?>> <?php echo $country->country_name;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <!--<div class="col-md-3">
        <label for="email"><?php echo $this->lang->line('dashboard_username');?></label>
        <input class="form-control" placeholder="<?php echo $this->lang->line('dashboard_username');?>" name="username" type="text" value="<?php echo $client_username;?>">
      </div>-->
        <div class="col-md-3">
            <label for="status" class="control-label"><?php echo $this->lang->line('dashboard_xin_status');?></label>
            <select class="form-control" name="status" data-plugin="select_hrm"
                data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                <option value="0" <?php if($is_active == '0'):?> selected <?php endif; ?>>
                    <?php echo $this->lang->line('xin_employees_inactive');?></option>
                <option value="1" <?php if($is_active == '1'):?> selected <?php endif; ?>>
                    <?php echo $this->lang->line('xin_employees_active');?></option>
            </select>
        </div>
        <div class="col-md-3">
            <fieldset class="form-group">
                <label for="logo"><?php echo $this->lang->line('xin_project_client_photo');?></label>
                <small><?php echo $this->lang->line('xin_company_file_type');?></small>
                <input type="file" class="form-control-file" id="client_photo" name="client_photo">
            </fieldset>
            <?php if($client_profile != '' || $client_profile != 'no-file') {?>
            <span class="avatar box-48 mr-0-5"> <img class="user-image-hr46 ui-w-100 rounded-circle"
                    src="<?php echo base_url();?>uploads/clients/<?php echo $client_profile;?>" alt=""> </span>
            <?php } ?>
        </div>
    </div>
    <h4>Contact Details</h4>

    <h5>Person 1</h5>
    <div class="col-md-12 p-0 m-0">
        <div class="col-md-3">
            <label for="website">Name</label>
            <input class="form-control" placeholder="Name" name="person_name_a" type="text"
                value="<?php echo $person_name_a;?>" required>
        </div>
        <div class="col-md-3">
            <label for="website">Number</label>
            <input class="form-control" placeholder="Number" name="person_phn_a" type="number"
                value="<?php echo $person_phn_a;?>" required>
        </div>
        <div class="col-md-3">
            <label for="website">Email</label>
            <input class="form-control" placeholder="Email" name="person_email_a" type="email"
                value="<?php echo $person_email_a;?>" required>
        </div>
    </div>
    <h5>Person 2</h5>
    <div class="col-md-12 p-0 m-0">
        <div class="col-md-3">
            <label for="website">Name</label>
            <input class="form-control" placeholder="Name" name="person_name_b" type="text"
                value="<?php echo $person_name_b;?>">
        </div>
        <div class="col-md-3">
            <label for="website">Number</label>
            <input class="form-control" placeholder="Number" name="person_phn_b" type="number"
                value="<?php echo $person_phn_b;?>">
        </div>
        <div class="col-md-3">
            <label for="website">Email</label>
            <input class="form-control" placeholder="Email" name="person_email_b" type="email"
                value="<?php echo $person_email_b;?>">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary"
        data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    <button type="submit" class="btn btn-primary save"><?php echo $this->lang->line('xin_update');?></button>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function() {

    $('[data-plugin="select_hrm"]').select2($(this).attr('data-options'));
    $('[data-plugin="select_hrm"]').select2({
        width: '100%'
    });

    /* Edit data */
    $("#edit_client").submit(function(e) {
        var fd = new FormData(this);
        var obj = $(this),
            action = obj.attr('name');
        fd.append("is_ajax", 2);
        fd.append("edit_type", 'client');
        fd.append("form", action);
        e.preventDefault();
        $('.save').prop('disabled', true);
        $.ajax({
            url: e.target.action,
            type: "POST",
            data: fd,
            contentType: false,
            cache: false,
            processData: false,
            success: function(JSON) {
                console.log(JSON);
                return false;
                if (JSON.error != '') {
                    toastr.error(JSON.error);
                    $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                    $('.save').prop('disabled', false);
                } else {
                    // On page load: datatable
                    var xin_table = $('#xin_table').dataTable({
                        "bDestroy": true,
                        "ajax": {
                            url: "<?php echo site_url("admin/clients/clients_list") ?>",
                            type: 'GET'
                        },
                        dom: 'lBfrtip',
                        "buttons": ['csv', 'excel', 'pdf',
                            'print'
                        ], // colvis > if needed
                        "fnDrawCallback": function(settings) {
                            $('[data-toggle="tooltip"]').tooltip();
                        }
                    });
                    xin_table.api().ajax.reload(function() {
                        toastr.success(JSON.result);
                    }, true);
                    $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                    $('.edit-modal-data').modal('toggle');
                    $('.save').prop('disabled', false);
                }
            },
            error: function() {
                toastr.error(JSON.error);
                $('input[name="csrf_hrsale"]').val(JSON.csrf_hash);
                $('.save').prop('disabled', false);
            }
        });
    });
});
</script>
<?php } elseif(isset($_GET['jd']) && $_GET['data'] == 'view_client' && isset($_GET['client_id'])) {
    ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title" id="edit-modal-data"><i class="icon-eye4"></i>
        <?php echo $this->lang->line('xin_project_view_client');?></h4>
</div>
<form class="m-b-1">
    <div class="modal-body">
        <div class="table-responsive" data-pattern="priority-columns">
            <table class="footable-details table table-striped table-hover toggle-circle">
                <tbody>
                    <tr>
                        <th><?php echo $this->lang->line('xin_client_name');?></th>
                        <td style="display: table-cell;"><?php echo $name;?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('xin_company_name');?></th>
                        <td style="display: table-cell;"><?php echo $company_name;?></td>
                    </tr>
                    <!--<tr>
          <th><?php echo $this->lang->line('dashboard_username');?></th>
          <td style="display: table-cell;"><?php echo $client_username;?></span></td>
        </tr>-->
                    <tr>
                        <th><?php echo $this->lang->line('xin_contact_number');?></th>
                        <td style="display: table-cell;"><?php echo $contact_number;?></span></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('xin_email');?></th>
                        <td style="display: table-cell;"><?php echo $email;?></span></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('xin_website');?></th>
                        <td style="display: table-cell;"><?php echo $website_url;?></span></td>
                    </tr>

                    <tr>
                        <th><?php echo $this->lang->line('xin_address');?></th>
                        <td style="display: table-cell;"><?php echo $address_1;?></span></td>
                    </tr>
                    <?php if($address_2 != '') { ?>
                    <tr>
                        <th>&nbsp;</th>
                        <td style="display: table-cell;"><?php echo $address_2;?></span></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th><?php echo $this->lang->line('xin_city');?></th>
                        <td style="display: table-cell;"><?php echo $city;?></span></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('xin_state');?></th>
                        <td style="display: table-cell;"><?php echo $state;?></span></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('xin_zipcode');?></th>
                        <td style="display: table-cell;"><?php echo $zipcode;?></span></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('xin_country');?></th>
                        <td style="display: table-cell;"><?php foreach($all_countries as $country) {?>
                            <?php if($countryid == $country->country_id):?>
                            <?php echo $country->country_name;?>
                            <?php endif;?>
                            <?php } ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('xin_project_client_photo');?></th>
                        <td style="display: table-cell;">
                            <?php if($client_profile != '' || $client_profile != 'no-file') {?>
                            <div class="avatar box-48 mr-0-5"> <img
                                    src="<?php echo base_url();?>uploads/clients/<?php echo $client_profile;?>" alt=""
                                    class="user-image-hr46 ui-w-100 rounded-circle"></a> </div>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
            data-dismiss="modal"><?php echo $this->lang->line('xin_close');?></button>
    </div>
    <?php echo form_close(); ?>
    <?php }
?>