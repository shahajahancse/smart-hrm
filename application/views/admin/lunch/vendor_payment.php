<style>
  .addbox {
    min-height: 49px;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    line-height: 1.5;
  }

  .panels {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.6s ease-out;
  }

  .payment_box {
    opacity: 0;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    transition: max-height 0.2s ease-out, opacity 0.2s ease-out;
  }

  .p {
    margin: 0!important;
    padding: 0 !important;
  }

  .btn {
    float: right;
    padding: 5px;
    font-weight: bold;
  }

  .panels.open {
    max-height: 1000px;
    margin-top: 11px;
    margin-bottom: 13px;
    opacity: 1;
    transition: max-height .6s ease-out, opacity .6s ease-out;
  }
  .section_box{
    width: 100%;
    background: #fffcf9;
    height: fit-content;
    margin: 3px;
    padding: 13px;
    border-radius: 5px;
    box-shadow: inset -1px 3px 10px 2px rgb(0 0 0 / 10%);
    overflow: auto;
  }
  .section-heding{
    font-weight: bold;
    font-size: 19px;
  }
  .list_box{
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    background: #fffcf9;
    box-shadow: 3px 8px 9px 3px rgb(0 0 0 / 10%);
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
  }
  .levels{
    font-size: 13px;
    font-weight: bold;
  }
</style>

<div class="addbox">
  <p class="p" style="font-size: 25px; font-weight: bold; float: left;">Payment List</p>
  <a class="btn btn-primary accordion" onclick="togglePaymentBox()">Make Payment</a>
</div>

<div class="panels payment_box" id="paymentBox">
  <section class="section_box">
   
    <div class="col-md-12">
       
        <div class="form-group col-md-4">
           <p class="levels">Last Calculet Date</p>
            <input type="date" class="form-control" id="email" style="border-radius: 6px;" disabled>
        </div>
        <div class="form-group col-md-2">
            <p class="levels">Total Meal</p>
            <input type="number" class="form-control" id="email" style="border-radius: 6px;" disabled>
        </div>
        <div class="form-group col-md-2">
            <p class="levels">Total Amount</p>
            <input type="number" class="form-control" id="email" style="border-radius: 6px;" disabled>
        </div>
        <div class="form-group col-md-2">
            <p class="levels">Pay Amount</p>
            <input type="number" class="form-control" id="email" style="border-radius: 6px;" disabled>
        </div>
        <div class="form-group col-md-2">
            <p class="levels">Due</p>
            <input type="text" class="form-control" id="pre_due" style="border-radius: 6px;" value="0" >
        </div>

    </div>
   

    <div class="col-md-12">
            <div class="form-group col-md-3">
            <p class="levels"> From Date</p>
                <input type="date" class="form-control" id="from_date" style="border-radius: 6px;" >
            </div>
            <div class="form-group col-md-3">
              <p class="levels"> To Date</p>
              <input type="date" class="form-control" onchange=calmeal() id="to_date" style="border-radius: 6px;" >

            </div>
            <div class="form-group col-md-2">
                <p class="levels">Total Meal</p>
                <input type="text" class="form-control" id="total_meal" style="border-radius: 6px;"  disabled>
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Total Amount</p>
                <input type="text" class="form-control" id="total_amount" style="border-radius: 6px;" disabled>
            </div>
            <div class="form-group col-md-2">
                <p class="levels">Payable Amount</p>
                <input type="text" class="form-control" id="payable_amount" style="border-radius: 6px;" disabled>
            </div>

    </div>
       <div  style="float: right;">
            <div class="form-group"  >
                <p class="col-md-6" style="float: left;">Due Amount</p>
                <input class="col-md-6" type="number" class="form-control" id="due_amount" style="border-radius: 6px;" >
            </div><br>
            <div class="form-group">
                <p class="col-md-6" style="float: left;"> Pay Amount</p>
                <input class="col-md-6" type="number" class="form-control" onchange=caldue() id="pay_amount" style="border-radius: 6px;" >
            </div>
        </div>
    
      <div class="col-md-12">
         <a onclick=submit() class="btn btn-primary" style="float: right;margin-right: 19px;">Submit</a> 
      </div>

  </section>
 
</div>
<div class="list_box">

</div>

<script>
    function togglePaymentBox() {
        var paymentBox = document.getElementById('paymentBox');
        paymentBox.classList.toggle('open');
    }

    function calmeal() {
        var first_date = $('#from_date').val();
        var second_date = $('#to_date').val();

        // Prepare the data object
        var data = {
            first_date: first_date,
            second_date: second_date
        };
        url='<?= base_url('/admin/lunch/get_payment_data/')?>'

        // Send AJAX request
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                if (response==0){
                    alert('There is no payment data')
                }else{

                document.getElementById('total_meal').value = response;
                var total_amount=response*90
                document.getElementById('total_amount').value = total_amount;
                var pre_due=document.getElementById('pre_due').value;
                var payable_amount=parseInt(parseInt(total_amount)+parseInt(pre_due));
                document.getElementById('payable_amount').value = payable_amount;
                }
            
            },
            error: function(xhr, status, error) {
            // Handle errors
            console.log(xhr.responseText);
            }
        });
    }
    function caldue(){
        var pay_amount= document.getElementById('pay_amount').value
        var payable_amount= document.getElementById('payable_amount').value
        document.getElementById('due_amount').value= parseInt(payable_amount)-parseInt(pay_amount)
    }

</script>
<script>
    function submit() {
  var pre_due = document.getElementById('pre_due').value;
  var fromDate = document.getElementById('from_date').value;
  var toDate = document.getElementById('to_date').value;
  var totalMeal = document.getElementById('total_meal').value;
  var totalAmount = document.getElementById('total_amount').value;
  var payableAmount = document.getElementById('payable_amount').value;
  var dueAmount = document.getElementById('due_amount').value;
  var payAmount = document.getElementById('pay_amount').value;

  // Create an object with the input data
  var inputData = {
    pre_due: pre_due,
    fromDate: fromDate,
    toDate: toDate,
    totalMeal: totalMeal,
    totalAmount: totalAmount,
    payableAmount: payableAmount,
    dueAmount: dueAmount,
    payAmount: payAmount
  };
  url='<?= base_url('/admin/lunch/make_payment/')?>'

  // Make an AJAX request to send the input data
  // Replace the URL with your actual server endpoint
  $.ajax({
    url: url,
    type: 'POST',
    data: inputData,
    success: function(response) {
      // Handle the response from the server
      console.log('AJAX request successful');
      console.log(response);
    },
    error: function(xhr, status, error) {
      // Handle the error
      console.log('AJAX request error');
      console.log(xhr.responseText);
    }
  });
}

</script>
