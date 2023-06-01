
  $(document).ready(function(){



    
            function jobCard()
            {
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

  });