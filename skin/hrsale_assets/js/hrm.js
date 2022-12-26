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


    // attendance process
    function attn_process()
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();


      process_date = document.getElementById('process_date').value;
      
      if(process_date =='')
      {
        alert('Please select process date');
        return ;
      }

      status = document.getElementById('status').value;
      
      if(status =='')
      {
        alert('Please select status');
        return ;
      }
 
      var okyes;
      okyes=confirm('Are you sure you want to start process?');
      if(okyes==false) return;

      $("#loader").show();
      
      // alert(base_url); return;
      url = base_url + "/attendance_process/"+process_date+"/"+status;
      ajaxRequest.open("GET", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send();

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          $("#loader").hide();
          alert(resp);
        }
      }
    }



    function daily_report(status,late_status=null)
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();

      
      attendance_date = document.getElementById('process_date').value;
      if(process_date =='')
      {
        alert('Please select attendance date');
        return ;
      }

      emp_status = document.getElementById('status').value;
      if(emp_status =='Select one')
      {
        alert('Please select employee status');
        return ;
      }

     var emp_id = document.getElementsByName('select_emp_id[]');
     var emp_ids = get_checked_value(emp_id);
     
     if(emp_ids == ''){
      alert('Please select employee id');
      return ;
     }


      // var queryString="month_year="+month_year+"&company="+company+"&employee_id="+employee_id;



      url = base_url + "/daily_report/"+attendance_date+"/"+status+"/"+emp_ids+"/"+late_status;
      ajaxRequest.open("GET", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
       ajaxRequest.send();
        // alert(url); return;

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest.responseText); return;
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
          a.document.write(resp);
          // a.close();
        }
      }
    }


