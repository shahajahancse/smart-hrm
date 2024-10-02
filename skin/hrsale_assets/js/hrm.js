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
    function date_between_attn_process()
    {
      // alert(csrf_token); return;
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();


      process_date = document.getElementById('process_date').value;
      second_date = document.getElementById('second_date').value;

      
      if(second_date =='')
      {
        alert('Please select second date');
        return ;
      }

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


      var process_date = new Date(document.getElementById('process_date').value);
      var second_date = new Date(document.getElementById('second_date').value);
      $("#loader").show();
      var html='<div id="date_show_on"></div>';
      $("#loader").append(html);
      start_proccess(process_date,status,sql,second_date)

    }


    function start_proccess(process_date,status,sql,second_date){

      var p_date=process_date.toISOString().split('T')[0]
      console.log(p_date);
      

      $.ajax({
        type: "POST",
        url: base_url + "/attendance_process",
        data: {
            process_date: p_date, 
            status: status,
            sql: sql
        },
        success: function (data) {
            
        },
        error: function (data) {
           
        },
        complete: function (data) {
          var h='<span> Process Complete of '+p_date+' </span> <br>';
          $("#date_show_on").append(h);
          process_date.setDate(process_date.getDate() + 1);
           if(process_date.toISOString().split('T')[0] > second_date.toISOString().split('T')[0]){
            $("#loader").hide();
            $("#date_show_on").remove();
            alert('Processing successfull');
           }else{
            start_proccess(process_date,status,sql,second_date)
           }
        }
    });
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
    // daily presnt/absent/late report
    function floor_movement()
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

      var data = "attendance_date="+attendance_date+"&sql="+sql;
      
      // console.log(data); return;
      url = base_url + "/movement_floor";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          console.log(ajaxRequest);
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1000,height=800');
          a.document.write(resp);
        }
      }
    }
    function latecomment(status,late_status=null)
    {
      $('#latecommentform').empty();
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
     document.getElementById('datein').value=attendance_date;
     document.getElementById('date').innerHTML=attendance_date;


      // var queryString="month_year="+month_year+"&company="+company+"&employee_id="+employee_id;

      var data = "attendance_date="+attendance_date+"&status="+status+"&sql="+sql+"&late_status="+late_status;
      
      // console.log(data); return;
      url = base_url + "/latecomment";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
      ajaxRequest.send(data);

      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
           
          const res = JSON.parse(ajaxRequest.response);
          console.log(res);
         if(res.error){
          alert(res.error)
         }else{
              $('#latecommentm').modal('show');
              const data = res['values'];
              let item = '';
              $.each(data, function(index, employee) {
              const row = ' <div class="row" style="margin: 4px;"> <div class="col-md-3"> <input type="text" readonly class="form-control" value="' + employee.first_name + ' ' + employee.last_name + '" disabled><input type="hidden" name="empi_id[]" class="form-control" value="' + employee.emp_id+ '"> </div> <div class="col-md-4"> <input type="text" readonly class="form-control" value="' + employee.designation_name + '" disabled> </div> <div class="col-md-2"> <input type="text" readonly class="form-control" value="' + employee.status + '" disabled> </div> <div class="col-md-3"> <input type="text"  class="form-control" name="comment[]" value="' + employee.comment + '" > </div> </div>';
              item += row;
            });

            // Add the HTML code for each row to an HTML element with ID 'empfrom'
            $('#latecommentform').append(item);
         }
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

    function extra_present()
    {
      
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
      first_date = document.getElementById('process_date').value;
      second_date = document.getElementById('second_date').value;
      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
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
      url = base_url + "/extra_present";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
       ajaxRequest.send(data);
      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
          a.document.write(resp);
        }
      }
    }
    function overall_performance()
    {
     
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
      first_date = document.getElementById('process_date').value;
      second_date = document.getElementById('second_date').value;
      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
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
      url = base_url + "/overall_performance";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
       ajaxRequest.send(data);
      ajaxRequest.onreadystatechange = function(){
        $('#loading').css({
          visibility: 'hidden'
      });
        if(ajaxRequest.readyState == 4){
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
          a.document.write(resp);
        }
      }
    }
    function overall_performance_yearly()
    {
     
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
      first_date = document.getElementById('process_date').value;
      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      if(first_date =='')
      {
        alert('Please select first date');
        return ;
      }

      $('#loading').css({
        visibility: 'visible'
    });
     
      var data = "first_date="+first_date+'&sql='+sql;
      url = base_url + "/overall_performance_yearly";
      ajaxRequest.open("POST", url, true);
      ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
       ajaxRequest.send(data);
      ajaxRequest.onreadystatechange = function(){
        $('#loading').css({
          visibility: 'hidden'
      });
        if(ajaxRequest.readyState == 4){
          var resp = ajaxRequest.responseText;
          a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
          a.document.write(resp);
        }
      }
    }

    function latecount(type)
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
      
      var data = "first_date="+first_date+'&second_date='+second_date+'&sql='+sql+'&type='+type;

      url = base_url + "/late_details";
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
  

    function absent() {
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

        url = base_url + "/absent_details";
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
    function overtime()
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
      var minute=prompt('Overtime Count After')
      if(minute =='')
      {
        alert('Please Give a minute');
        return ;
      }
      
      var data = "first_date="+first_date+'&second_date='+second_date+'&sql='+sql+'&minute='+minute;

      url = base_url + "/overtime_details";
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
    function nda_report()
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      if(sql =='')
      {
        alert('Please select employee Id');
        return ;
      }
      var data = '&sql='+sql;
      url = base_url + "/nda_report";
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

    function lunch_jobcard()
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

      url = base_url + "/lunch_jobcard";
      // alert(url); return ;
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
    function print_vendor_data(s)
    {
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
      first_date = document.getElementById('process_date').value;
      second_date = document.getElementById('second_date').value;
        if (s == 1) {
          second_date = first_date;
        }
      var checkboxes = document.getElementsByName('select_emp_id[]');
      var sql = get_checked_value(checkboxes);
      
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
      
      var data = "from_date="+first_date+'&to_date='+second_date;

      url = base_url + "/print_vendor_data";
      // alert(url); return ;
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
function Inv_Report(statusC){
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();

  first_date = document.getElementById('process_date').value;
  second_date = document.getElementById('second_date').value;
  
  if(second_date !='' && first_date =='' )
  {
    alert('Please select first date');
    return ;
  }
  if(second_date =='' && first_date !=='')
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


function Per1_Report(statusC){

  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();

  first_date = document.getElementById('process_date').value;
  second_date = document.getElementById('second_date').value;

  
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

  url = base_url + "/perches_status_report";
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
  //low inventory report js function
 
function LP_AlP_Report (statusC){
      var ajaxRequest;  // The variable that makes Ajax possible!
      ajaxRequest = new XMLHttpRequest();
      var data = "statusC="+statusC;

      url = base_url + "/low_inv_all_product_status_report";
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

function mobile_bill(status) { 
  console.table(status);
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();
  first_date = document.getElementById('process_date').value
  second_date = document.getElementById('second_date').value;
  // second_date = "";
  // sql = "";
  
  var data = "first_date="+first_date+'&second_date='+second_date;

  url = base_url + "/mobile_bill_report";

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