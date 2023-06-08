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

    // daily presnt/absent/late report
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
      if(emp_status =='')
      {
        alert('Please select employee status');
        return ;
      }

     var emp_id = document.getElementsByName('select_emp_id[]');
     var sql = get_checked_value(emp_id);
     
     if(sql == ''){
      alert('Please select employee Id');
      return ;
     }


      // var queryString="month_year="+month_year+"&company="+company+"&employee_id="+employee_id;

      var data = "attendance_date="+attendance_date+"&status="+status+"&sql="+sql+"&late_status="+late_status;
      
      // console.log(data); return;
      url = base_url + "/daily_report";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
          a.document.write(resp);
        }
      }
    }

    // daily lunch In/Out/Late report
    function lunch_report(status,late_status=null)
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();

      attendance_date = document.getElementById('process_date').value;
      if(process_date =='')
      {
        alert('Please select date');
        return ;
      }

      emp_status = document.getElementById('status').value;
      if(emp_status =='')
      {
        alert('Please select employee status');
        return ;
      }

     var emp_id = document.getElementsByName('select_emp_id[]');
     var sql = get_checked_value(emp_id);
     
     if(sql == ''){
      alert('Please select employee Id');
      return ;
     }
    //  alert(late_status);return;

      // var queryString="month_year="+month_year+"&company="+company+"&employee_id="+employee_id;

      var data = "attendance_date="+attendance_date+"&status="+status+"&sql="+sql+"&late_status="+late_status;
      
      // console.log(data); return;
      url = base_url + "/lunch_report";

      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1100,height=800');
          a.document.write(resp);
        }
      }

    }

     // daily Early Out report  
    function early_out_report(status)
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();

      attendance_date = document.getElementById('process_date').value;
      if(process_date =='')
      {
        alert('Please select date');
        return ;
      }

      emp_status = document.getElementById('status').value;
      if(emp_status =='')
      {
        alert('Please select employee status');
        return ;
      }

     var emp_id = document.getElementsByName('select_emp_id[]');
     var sql = get_checked_value(emp_id);
     
     if(sql == ''){
      alert('Please select employee Id');
      return ;
     }


      // var queryString="month_year="+month_year+"&company="+company+"&employee_id="+employee_id;

      var data = "attendance_date="+attendance_date+"&status="+status+"&sql="+sql;
      
      // console.log(data); return;
      url = base_url + "/early_out_report";

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

    // Movement Report
    function movement_report(status)
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();

      attendance_date = document.getElementById('process_date').value;
      if(process_date =='')
      {
        alert('Please select date');
        return ;
      }

      emp_status = document.getElementById('status').value;
      if(emp_status =='')
      {
        alert('Please select employee status');
        return ;
      }

     var emp_id = document.getElementsByName('select_emp_id[]');
     var sql = get_checked_value(emp_id);
     
     if(sql == ''){
      alert('Please select employee Id');
      return ;
     }


      // var queryString="month_year="+month_year+"&company="+company+"&employee_id="+employee_id;

      var data = "attendance_date="+attendance_date+"&status="+status+"&sql="+sql;
      
      // console.log(data); return;
      url = base_url + "/movement_report";
    

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


    function jobCard()
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();

      first_date = document.getElementById('process_date').value;
      second_date = document.getElementById('second_date').value;
      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      if(sql =='')
      {
        alert('Please select employee Id');
        return ;
      }
      
      if(first_date =='')
      {
        alert('Please select first date');
        return ;
      }
      if(second_date =='')
      {
        alert('Please select second date');
        return ;
      }
      
      var data = "first_date="+first_date+'&second_date='+second_date+'&sql='+sql;

      url = base_url + "/job_card";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
       ajaxRequest.send(data);
        // alert(url); return;

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          // console.log(ajaxRequest.responseText); return;
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
          a.document.write(resp);
          // a.close();
        }
      }
  }

  function movReport(statusC){
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();

    first_date = document.getElementById('process_date').value;
    second_date = document.getElementById('second_date').value;
    // var checkboxes = document.getElementsByName('select_emp_id[]');
    // var sql = get_checked_value(checkboxes);
    // if(sql =='')
    // {
    //   alert('Please select employee Id');
    //   return ;
    // }
    
    if(first_date =='')
    {
      alert('Please select first date');
      return ;
    }
    if(second_date =='')
    {
      alert('Please select second date');
      return ;
    }
    
    
    var data = "first_date="+first_date+"&second_date="+second_date+"&statusC="+statusC;
    url = base_url + "/movment_status_report";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
     ajaxRequest.send(data);
      // alert(url); return;

    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest.responseText); return;
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
        a.document.write(resp);
        // a.close();
      }
    }
}

function Inv_Report(statusC){

        var ajaxRequest;  // The variable that makes Ajax possible!
        ajaxRequest = new XMLHttpRequest();

        first_date = document.getElementById('process_date').value;
        second_date = document.getElementById('second_date').value;
        // var checkboxes = document.getElementsByName('select_emp_id[]');
        // var sql = get_checked_value(checkboxes);
        // if(sql =='')
        // {
        //   alert('Please select employee Id');
        //   return ;
        // }
        
        if(first_date =='')
        {
          alert('Please select first date');
          return ;
        }
        if(second_date =='')
        {
          alert('Please select second date');
          return ;
        }
        
        
        var data = "first_date="+first_date+"&second_date="+second_date+"&statusC="+statusC;

        url = base_url + "/inventory_status_report";
        ajaxRequest.open("POST", url, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
        ajaxRequest.send(data);
          // alert(url); return;

        ajaxRequest.onreadystatechange = function(){
          if(ajaxRequest.readyState == 4){
            // console.log(ajaxRequest.responseText); return;
            var resp = ajaxRequest.responseText;
            a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
            a.document.write(resp);
            // a.close();
          }
        }
}

  

  function monthly_report() {


    
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();

    first_date = document.getElementById('process_date').value;
    // second_date = document.getElementById('second_date').value;
    var checkboxes = document.getElementsByName('select_emp_id[]');
    var sql = get_checked_value(checkboxes);
    if(sql =='')
    {
      alert('Please select employee Id');
      return ;
    }
    
    if(first_date =='')
    {
      alert('Please select first date');
      return ;
    }else{
      document.getElementById("loading").style.visibility = "visible";


    }
    var data = "first_date="+first_date+'&second_date='+second_date+'&sql='+sql;

    url = base_url + "/monthly_report";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    // alert(url); return;
   
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        // console.log(ajaxRequest.responseText); return;
        document.getElementById("loading").style.visibility = "hidden";

        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
        a.document.write(resp);
        // a.close();
      }
    }
   
  }

  function leavecal(type, stutus) {
    var ajaxRequest;  // The variable that makes Ajax possible!
    ajaxRequest = new XMLHttpRequest();
    var first_date;
    var second_date;
    

    if(type == 1){
    first_date = document.getElementById('process_date').value;
    second_date=first_date;
    // second_date = document.getElementById('second_date').value;
    }else if(type == 2){
      var f_date = document.getElementById('process_date').value;
      // Assuming your date is in the format 'YYYY-MM-DD'
      // Assuming your date is in the format 'YYYY-MM-DD'
      var currentDate = f_date;

      // Extract year and month from the current date
      var year = parseInt(currentDate.slice(0, 4));
      var month = parseInt(currentDate.slice(5, 7));
      var firstDate = new Date(year, month - 1, 2);
      var lastDate = new Date(year, month, 1);

      // Format the first and last dates as 'YYYY-MM-DD'
      var first_date = firstDate.toISOString().slice(0, 10);
      var second_date = lastDate.toISOString().slice(0, 10);
      }else if(type == 3){
        first_date = document.getElementById('process_date').value;
        second_date = document.getElementById('second_date').value;
      }
    


    var checkboxes = document.getElementsByName('select_emp_id[]');

    var sql = get_checked_value(checkboxes);
    if(sql =='')
    {
      alert('Please select employee Id');
      return ;
    }
    
    if(first_date =='')
    {
      alert('Please select first date');
      return ;
    }
    if(second_date =='')
    {
      alert('Please select second date');
      return ;
    }
    var data = "first_date="+first_date+'&second_date='+second_date+'&sql='+sql+'&stutus='+stutus+'&type='+type;

    url = base_url + "/leave_report";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(data);
    // alert(url); return;
   
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){
        var resp = ajaxRequest.responseText;
        a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
        a.document.write(resp);
        // a.close();
      }
    }
   
  }

  