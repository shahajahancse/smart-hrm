
<style>
      .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            height: 80vh;
            overflow-y: scroll;
        }

        h4, h5, h6 {
            margin: 0;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        select:focus {
            outline: none;
            border-color: #5c7cfa;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .lid {
            background-color: #f2f2f2;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .lid:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .lid h5 {
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .lid h6 {
            color: #666;
            font-size: 14px;
        }

        .remove-btn {
            background-color: #ff5252;
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 12px;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .remove-btn:hover {
            background-color: #f44336;
        }
        .content{
            display: flex;
        }
    </style>
 
</style>
<div class="col-md-12">
        <div class="row row-gap">
            <div class="col-md-6 card whiteBox" data-who="using_List">
                <div class="col-md-12 form-group">
                    <h4>Employee Using Device</h4>
                    <label for="">Select Employee</label><br>
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option value="">Select Employee</option>
                        <?php
                      $employees = $this->db->where('user_role_id', 3)->where('is_active', 1)->get('xin_employees')->result();
                      foreach ($employees as $key => $value) { ?>
                        <option value="<?= $value->user_id ?>"><?= $value->first_name.' '.$value->last_name ?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="col-md-12">
                    <ul style="padding: 0;" id="device_using_List">
                    </ul>
                  
                </div>
            </div>
            <div class="col-md-6 card whiteBox" data-who="device_List">
                <h4>Stored Device</h4>
                <div class="col-md-12" style="margin-bottom: 10px;display: inline-table;">
                <label for="">Select Catagories</label>
                <select name="cat_id" id="cat_id" class="form-control">
                    <option value="">Select Catagories</option>
                    <?php
                      $categories = $this->db->where('status', 1)->get('product_accessory_categories')->result();
                      foreach ($categories as $key => $value) { ?>
                        <option value="<?= $value->id ?>"><?= $value->cat_name ?></option>
                    <?php } ?>
                </select>
                <input type="text" class="form-control" id="search_device_using" placeholder="Search device by name or number" aria-label="Search device by name or number" aria-describedby="basic-addon2" style="margin-top: 8px;">
                </div>
                <div class="col-md-12">
                    <ul style="padding: 0;" id="device_List">
                    </ul>
            </div>
        </div>
    </div>
    <script>
        
     function remove_device(product_id) {
        $.ajax({
            type: "POST",
            url: '<?= site_url("admin/accessories/remove_device_using") ?>',
            data: {product_id: product_id},
            success: function(data){
                $('#cat_id, #employee_id').trigger('change');
            }
        });
    }
    $(document).ready(function(){
    $('#employee_id, #cat_id').select2();
    name_search()

    $('#employee_id, #cat_id').on('change', function(){
        var isEmployee = $(this).attr('id') === 'employee_id';
        var requestData = isEmployee ? {employee_id: $(this).val()} : {cat_id: $(this).val()};
        var url = isEmployee ? '<?= site_url("admin/accessories/employee_using_device_list") ?>' : '<?= site_url("admin/accessories/employee_device_list_by_cat") ?>';
        var listToUpdate = isEmployee ? '#device_using_List' : '#device_List';

        $.ajax({
            type: "POST",
            url: url,
            data: requestData,
            success: function(data){
                data = JSON.parse(data);
                var lis = '';
                data.forEach(element => {
                    lis += `<li class="lid ${isEmployee ? '' : 'imgBox'}" data-id="${element.product_id}" ${isEmployee ? '' : 'draggable="true"'}>
                                <h5 class="col-md-12" style="padding: 0;display: flex;justify-content: space-between;">MHL-${element.cat_short_name}-${element.device_name_id}${isEmployee ? `<a style="color: white;background: red;padding: 4px 6px;font-size: 11px;border-radius: 5px;" onclick="remove_device(${element.product_id})">Remove</a>` : ''}</h5>
                                <h6>${element.cat_name}</h6>
                            </li>`;
                });
                $(listToUpdate).empty().append(lis);
                if (!isEmployee) startDrag();
                name_search()
            }
        });
    });

    function startDrag() {
        const imgBoxes = document.querySelectorAll('.imgBox');
        const whiteBoxes = document.querySelectorAll('.whiteBox');

        imgBoxes.forEach(imgBox => {
            imgBox.addEventListener('dragstart', (e) => {
                localStorage.setItem('id', e.target.dataset.id);
                e.target.classList.add('hold');
                setTimeout(() => {
                    e.target.classList.add('hide');
                }, 0);
            });

            imgBox.addEventListener('dragend', (e) => {
                e.target.classList.remove('hold', 'hide');
            });
        });

        whiteBoxes.forEach(whiteBox => {
            whiteBox.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.target.closest('.whiteBox').classList.add('dashed');
            });

            whiteBox.addEventListener('dragenter', (e) => {
                e.target.closest('.whiteBox').classList.add('dashed');
            });

            whiteBox.addEventListener('dragleave', (e) => {
                e.target.closest('.whiteBox').classList.remove('dashed');
            });

            whiteBox.addEventListener('drop', (e) => {
                e.preventDefault();
                e.target.closest('.whiteBox').classList.remove('dashed');
                if (e.target.closest('.whiteBox').dataset.who == 'using_List') {
                    $('#device_using_List').append(document.querySelector('.hold'));
                    callUpdateAjax();
                } else {
                    $('#device_List').append(document.querySelector('.hold'));
                    $('#cat_id, #employee_id').trigger('change');
                }
            });
        });
    }

    function callUpdateAjax() {
        var id = localStorage.getItem('id');
        var employeeId = $('#employee_id').val();

       

        if (id) {
            if (!employeeId) {
                localStorage.removeItem('id');
                alert('Please select Employee');
                $('#cat_id, #employee_id').trigger('change');
                return false;
            }
            $.ajax({
                type: "POST",
                url: '<?= site_url("admin/accessories/update_device_using") ?>',
                data: {
                    device_id: id,
                    employee_id: employeeId
                },
                success: function(data){
                    localStorage.removeItem('id');
                }
            });
        }
        setTimeout(() => {
            $('#cat_id, #employee_id').trigger('change');
        }, 500);
    }

  
});
 
</script>
<script>

    function name_search() {
        
        var search_device_using = document.getElementById('search_device_using');
        var device_using_List = document.getElementById('device_List');
        search_device_using.addEventListener('input', function(){
            var text = this.value.toLowerCase().trim();
            var li_list = device_using_List.getElementsByTagName('li');
            for (var i = 0; i < li_list.length; i++) {
                var element = li_list[i];
                if (element.innerText.toLowerCase().includes(text)) {
                    element.style.display = "list-item";
                } else {
                    element.style.display = "none";
                }
            }
        });
    }
</script>