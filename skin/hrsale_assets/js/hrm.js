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
      // alert(csrf_token); return;
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
       var data = "process_date="+process_date+"&status="+status+'&sql='+sql;
      
      // console.log(data); return;
      url = base_url + "/attendance_process";
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

      // var queryString="month_year="+month_year+"&company="+company+"&employee_id="+employee_id;

      url = base_url + "/daily_report/"+attendance_date+"/"+status+"/"+late_status;
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


