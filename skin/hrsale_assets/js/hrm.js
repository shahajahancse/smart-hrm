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

    function daily_present_report(argument) {
      // body...
    }