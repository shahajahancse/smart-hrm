<style>
.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    padding: 20px;
    margin: 10px 0;
    text-align: center;
    transition: box-shadow 0.3s, transform 0.3s;
    background-color: #fff;
}

.card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
    cursor: pointer;
}

.product-list {
    list-style: none;
    padding: 0;
    margin: 0;
}



.product-list li.item {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    padding: 15px;
    margin: 15px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: box-shadow 0.3s, transform 0.3s;
    background-color: #fff;
}

.product-list li.item:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
}

.product-list li.item span {
    flex: 1;
    text-align: center;
}


.product-list li.header {
    box-shadow: 0 2px 7px 4px rgb(0 0 0 / 10%);
    padding: 15px;
    margin: 15px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: box-shadow 0.3s, transform 0.3s;
    background-color: #fff;
    font-size: large;
    font-weight: bold;
}

.product-list li.header span {
    flex: 1;
    text-align: center;
}

.btn-container {
    display: flex;
    justify-content: center;
}

.btn-container a {
    margin: 0 5px;
}

.btn {
    border-radius: 20px;
}

.buttoss {
    border-radius: 20px;
    border: 1px solid #ccc;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.buttoss:hover {
    border-radius: 20px;
    border: 1px solid #ccc;
    padding: 10px 20px;
    transition: all 0.3s ease;
}

.b-green {
    background-color: #0076b9;
    color: white;
}

.b-red {
    background-color: #dd4b39;
    color: white;
}

.b-warning {
    background-color: #f0ad4e;
    color: white;
}
</style>
<div class="">
    <div class="row">
        <div class="col-md-3">
            <div class="card"  onclick=get_data(1)>
                <h4>Pending</h4>
                <span>12</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card"  onclick=get_data(2)>
                <h4>Approved</h4>
                <span>11</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card"  onclick=get_data(3)>
                <h4>Order Received</h4>
                <span>15</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card"  onclick=get_data(4)>
                <h4>Rejected</h4>
                <span>1</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="display: flex;flex-direction: row;justify-content: space-between;">
                <h4>Purchase List</h4>
                <a class="buttoss b-green" onclick="add_purchase()">Add Purchase</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <ul id="appRowDiv" class="product-list">
                    <li class="header">
                        <span>Product Name</span>
                        <span>Quantity</span>
                        <span>Price</span>
                        <span>Total Price</span>
                        <span>Action</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function add_purchase() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/inventory/get_products') ?>",
            data: {},
            success: function(data) {
                swal.fire({
                title: 'Add Purchase',
                html:data,
                showCancelButton: true,
                
                showConfirmButton:true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Add',
                focusConfirm: false,
                preConfirm: async () => {
                    try {
                        console.log($('#select_item_par').val());
                        return await fetch('<?= base_url('admin/inventory/add_purchase') ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                'product_id': $('#select_item_par').val(),
                                'quantity': $('#par_qty').val(),
                                'unit_price': $('#par_price').val(),
                                'total_price': $('#par_total_price').val(),
                            }),
                        })
                    } catch (error) {
                    Swal.showValidationMessage(`
                        Request failed: ${error}
                    `);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Purchase Added Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                           get_data();
                        })
                    }
                })
            },
            error: function(data) {
                alert('There is an error. Please contact administrator.');
            },
            complete: function(data) {
                $('#select_item_par').select2();
            }
        })
    }


    function calt(){
        console.log($('#par_qty').val());
        $('#par_total_price').val($('#par_qty').val() * $('#par_price').val());
    }

    function get_data(status=null) {
        $('.item').remove();
        if (status === null) {
            status = 1;
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url('admin/inventory/get_purchase_data') ?>",
            data: {
                'status': status
            },
            success: function(data) {
                data= JSON.parse(data);
                var roll= data.roll;
                var row= data.row;
                for (var i = 0; i < row.length; i++) {
                    var html=''
                    html += '<li class="item">';
                    html += '<span>'+row[i].product_name+'</span>';
                    html += '<span>'+row[i].quantity+' '+ row[i].unit_name+'</span>';
                    html += '<span>'+row[i].approx_amount+'</span>';
                    html += '<span>'+row[i].approx_t_amount+'</span>';
                    html += '<span class="btn-container">';
                        html += '<a href="#" class="buttoss b-green">Approve</a>';
                        html += '<a href="#" class="buttoss b-red">Reject</a>';
                    html += '</span>';
                    html += '</li>';
                    $('#appRowDiv').append(html);
                    
                }





            },
            error: function(data) {
                alert('There is an error. Please contact administrator.');
            }
        })
    }

    
$(document).ready(function() {
    get_data();
});
</script>
