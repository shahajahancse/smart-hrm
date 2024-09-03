        // get check box select value
    function get_checked_value(checkboxes) {
      var vals = "";
      for (var i=0, n=checkboxes.length;i<n;i++) 
      {
          if (checkboxes[i].checked) 
          {
              vals += ","+checkboxes[i].value;
          }
      }
      if (vals) vals = vals.substring(1);
      return vals;
    }


    // salary process
    function salary_process()
    {
      // alert(csrf_token); return;
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();


      sal_month = document.getElementById('sal_month').value;
      if(sal_month =='')
      {
        alert('Please select process Month');
        return ;
      }

      sal_year = document.getElementById('sal_year').value;
      if(sal_year =='')
      {
        alert('Please select process Year');
        return ;
      }

      process_month = sal_year +'-'+ sal_month +'-'+ '01'

      status = document.getElementById('status').value;
      if(status =='')
      {
        alert('Please select status');
        return ;
      }

      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      if(sql =='')
      {
        alert('Please select employee Id');
        return ;
      }
 
      var okyes;
      okyes=confirm('Are you sure you want to start process?');
      if(okyes==false) return;

      $("#loader").show();
       var data = "process_month="+process_month+"&status="+status+'&sql='+sql;
  
      // console.log(data); return;
      url = base_url + "/salary_process";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          $("#loader").hide();
          alert(resp);
        }
      }
    }

    // salary process
    function salary_sheet_excel()
    {
      // alert(csrf_token); return;
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();


      sal_month = document.getElementById('sal_month').value;
      if(sal_month =='')
      {
        alert('Please select salary month');
        return ;
      }

      sal_year = document.getElementById('sal_year').value;
      if(sal_year =='')
      {
        alert('Please select alary year');
        return ;
      }

      salary_month = sal_year +'-'+ sal_month

      status = document.getElementById('status').value;
      if(status =='')
      {
        alert('Please select status');
        return ;
      }

      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      if(sql =='')
      {
        alert('Please select employee Id');
        return ;
      }
 
      /*var okyes;
      okyes=confirm('Are you sure you want to generate excel sheet?');
      if(okyes==false) return;*/

       var data = "salary_month="+salary_month+"&status="+status+'&sql='+sql+"&excel="+0;
  
      // console.log(data); return;
      url = base_url + "/salary_sheet_excel";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1200,height=800');
          a.document.write(resp);
        }
      }
    }

    // Actual_salary_sheet_excel

    function Actual_salary_sheet_excel()
    {
      // alert(csrf_token); return;
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();


      sal_month = document.getElementById('sal_month').value;
      if(sal_month =='')
      {
        alert('Please select salary month');
        return ;
      }

      sal_year = document.getElementById('sal_year').value;
      if(sal_year =='')
      {
        alert('Please select alary year');
        return ;
      }

      salary_month = sal_year +'-'+ sal_month

      status = document.getElementById('status').value;
      if(status =='')
      {
        alert('Please select status');
        return ;
      }

      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      if(sql =='')
      {
        alert('Please select employee Id');
        return ;
      }
      document.getElementById('loader').style.display = 'block';

 
      /*var okyes;
      okyes=confirm('Are you sure you want to generate excel sheet?');
      if(okyes==false) return;*/

       var data = "salary_month="+salary_month+"&status="+status+'&sql='+sql+"&excel="+0;
  
      // console.log(data); return;
      url = base_url + "/Actual_salary_sheet_excel";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        document.getElementById('loader').style.display = 'none'; 
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1200,height=800');
          a.document.write(resp);
        }
      }
    }
    function report_salary_sheet()
    {
      // alert(csrf_token); return;
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
      sal_month = document.getElementById('sal_month').value;
      if(sal_month =='')
      {
        alert('Please select salary month');
        return ;
      }
      sal_year = document.getElementById('sal_year').value;
      if(sal_year =='')
      {
        alert('Please select alary year');
        return ;
      }
      salary_month = sal_year +'-'+ sal_month
      status = document.getElementById('status').value;
      if(status =='')
      {
        alert('Please select status');
        return ;
      }
      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      if(sql =='')
      {
        alert('Please select employee Id');
        return ;
      }
      document.getElementById('loader').style.display = 'block';
      /*var okyes;
      okyes=confirm('Are you sure you want to generate excel sheet?');
      if(okyes==false) return;*/
       var data = "salary_month="+salary_month+"&status="+status+'&sql='+sql+"&excel="+0;
      // console.log(data); return;
      url = base_url + "/report_salary_sheet";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);
      ajaxRequest.onreadystatechange = function(){
        document.getElementById('loader').style.display = 'none'; 
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1200,height=800');
          a.document.write(resp);
        }
      }
    }
function Actual_salary_sheet_excel_bank(s,bank)
    {
      // alert(csrf_token); return;
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();


      sal_month = document.getElementById('sal_month').value;
      if(sal_month =='')
      {
        alert('Please select salary month');
        return 
      }

      sal_year = document.getElementById('sal_year').value;
      if(sal_year =='')
      {
        alert('Please select alary year');
        return ;
      }

      salary_month = sal_year +'-'+ sal_month

      status = document.getElementById('status').value;
      if(status =='')
      {
        alert('Please select status');
        return ;
      }

      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      if(sql =='')
      {
        alert('Please select employee Id');
        return ;
      }
 
      /*var okyes;
      okyes=confirm('Are you sure you want to generate excel sheet?');
      if(okyes==false) return;*/

       var data = "salary_month="+salary_month+"&status="+status+'&sql='+sql+"&excel="+s+"&bank="+bank;
  
      // console.log(data); return;
      url = base_url + "/Actual_salary_sheet_excel_bank";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1200,height=800');
          a.document.write(resp);
        }
      }
    }

    $(document).on('change', '.commonclass', function() {
      // Get the data attributes
      const mdayid = $(this).data('id'); // Retrieve 'data-id'
      const bsid = $(this).data('bsid'); // Retrieve 'data-bsid'
      const inputchangeid = $(this).attr('id'); // Retrieve 'id'
    
      // Get the values from input elements
      const inputchange = $(`#${inputchangeid}`).val(); // Retrieve value based on 'inputchangeid'
      const bs = $(`#${bsid}`).val(); // Retrieve value based on 'bsid'
      const date = $('#date').val(); // Retrieve value based on 'date'

      // Extract year and month from the date
      const [year, month] = date.split('-').map(Number);
    
      // Get the last day of the current month
      const nextMonth = new Date(year, month, 1);
      const lastDayOfMonth = new Date(nextMonth.getTime() - 1);
    
      // Get the total number of days in the current month
      const totalDays = lastDayOfMonth.getDate();
    
      // Calculate and log the value of l_inputdata
      const l_inputdata = parseInt(((bs / totalDays) * inputchange).toFixed(2));
      console.log(l_inputdata);
      
    
      // Set the value of the element with 'mdayid' to l_inputdata
      $(`#${mdayid}`).val(l_inputdata);
    });
    
    
    // Define a function named "modify_salary"
  function modify_salary() {
    // Retrieve the values of two HTML input elements with IDs 'sal_month' and 'sal_year'
    const sal_month = document.getElementById('sal_month').value;
    const sal_year = document.getElementById('sal_year').value;

    // Concatenate the retrieved values into a single string variable named "salary_month"
    const salary_month = sal_year + '-' + sal_month;

    // Send an AJAX request to a server-side script named "modify_salary"
    $.ajax({
      url: 'modify_salary',
      type: 'POST',
      data: {
        salary_month: salary_month,
      },
      // Handle the response from the server
      success: function(jsonArray){
        // Clear the contents of two HTML elements with IDs 'total' and 'empfrom'
        $('#total').empty();
        $('#empfrom').empty();

        // Parse the response from the server, which is expected to be a JSON array
        const response = JSON.parse(jsonArray);
      
      

        // Create an empty array named "sql" and a variable named "count"
        const sql = [];
        const count = response.length;

        // Extract the salary month from the first element of the JSON array
        if(count>0){
        const salary_month = response[0].salary_month;}

        // Create a variable named "item" that will hold the HTML code for each row in the employee table
        let item = '';

        // Loop through each element in the JSON array and create HTML code for each row in the employee table
     

        $.each(response, function(index, employee) {
          const row = '<div class="row" style="margin-top: 10px;"><div class="col-md-3"><input type="text" readonly class="form-control" value="' + employee.first_name + ' ' + employee.last_name + '" disabled><input type="hidden" name="modifydataid[]" class="form-control" value="' + employee.user_id+ '" ></div><div class="col-md-2"><input type="text" readonly class="form-control" value="' + employee.basic_salary + '" id="bs' + employee.user_id+ '" ></div><div class="col-md-1"><input type="number" readonly class="form-control" style="padding: 0;text-align-last: center;" value="' + employee.late_count + '"></div><div class="col-md-1"><input type="number"readonly class="form-control" style="padding: 0;text-align-last: center;" value="' + employee.d_day + '" id="deductday"></div><div class="col-md-2"><input type="text" readonly class="form-control" value="' + employee.late_deduct + '"></div><div class="col-md-1"><input type="number"  class="form-control commonclass" id="mid' + employee.user_id+ '" data-bsid="bs' + employee.user_id+ '" data-id="' + employee.user_id+ '" name="modifyday[]" value="' + employee.m_pay_day + '"  style="padding: 0;text-align-last: center;"></div><div class="col-md-2"><input type="number"  class="form-control" id="' + employee.user_id+ '" name="modifydata[]"   value="' + employee.modify_salary + '"></div></div>';
          item += row;
       
        });

        // Add the HTML code for each row to an HTML element with ID 'empfrom'
        $('#empfrom').append(item);

        // Concatenate the contents of the "sql" array into a single string variable named "sqld"
        const sqld = sql.join(',');

        // Add count after the last row in #empfrom
        var countCol = $('<div class="col-md-12 " style="display: inline-flex;"><p style="color:#004cff;font-size: 17px;margin-left: -26px;font-weight: bold;">Total Employee ' + count + '</p><input id="temp" type="hidden" readonly class="form-control" value="' + count + '" name="total_emp"><p style="color:#004cff;font-size: 17px;font-weight: bold;right: 0;position: absolute;margin-left:5px;">Date ' + salary_month + '</p><input id="date" type="hidden" readonly class="form-control" value="' + salary_month + '" name="date"><input id="sql" type="hidden" readonly class="form-control" value="'+ sqld +'"></div>');
        $('#total').append(countCol);
        $('#my_modal').modal('show');
      }
    });

  }
    




