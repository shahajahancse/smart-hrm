
function perday(status) {
{
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();
  var checkboxes = document.getElementsByName('select_emp_id[]');

  var sql = get_checked_value(checkboxes);
  if(status == 1 || status == 5){
    first_date = document.getElementById('process_date').value;
    second_date=first_date;
    // second_date = document.getElementById('second_date').value;
    }else if(status == 2){
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
      }else if(status == 3){
        first_date = document.getElementById('process_date').value;
        second_date = document.getElementById('second_date').value;
      }else if(status == 4){
        first_date = document.getElementById('process_date').value;
        second_date = first_date ;
        sql=1111;
      }


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
  }else{
    document.getElementById("loading").style.visibility = "visible";
  }
  
  var data = "first_date="+first_date+'&second_date='+second_date+'&sql='+sql+'&status='+status;
  console.log(data);

  url = base_url + "/lunch_reports/";
  ajaxRequest.open("POST", url, true);
  ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(data);
    // alert(url); return;

  ajaxRequest.onreadystatechange = function(){
    if(ajaxRequest.readyState == 4){
      document.getElementById("loading").style.visibility = "hidden";

      // console.log(ajaxRequest.responseText); return;
      var resp = ajaxRequest.responseText;
      a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
      a.document.write(resp);
      // a.close();
    }
  }
}
}
function paymentreport(status,r=null) {
{
  
  var ajaxRequest;  // The variable that makes Ajax possible!
  ajaxRequest = new XMLHttpRequest();
  var data = '&status='+status;
  console.log(data);

  url = base_url + "/paymentreport/"+r;
  ajaxRequest.open("POST", url, true);
  ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
   ajaxRequest.send(data);
    // console.log(url); return;

  ajaxRequest.onreadystatechange = function(){
    if(ajaxRequest.readyState == 4){
      document.getElementById("loading").style.visibility = "hidden";

      // console.log(ajaxRequest.responseText); return;
      var resp = ajaxRequest.responseText;
      a = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
      a.document.write(resp);
      // a.close();
    }
  }
}
}
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