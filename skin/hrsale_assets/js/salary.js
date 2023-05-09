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
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1200,height=800');
          a.document.write(resp);
        }
      }
    }




