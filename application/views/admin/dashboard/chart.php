 <canvas id="myChart"></canvas>

 <script>
    // Get the canvas element
    var ctx = document.getElementById('myChart').getContext('2d');
  
    // Create the chart
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: monthNames,
        datasets: [{
          label: 'Salary',
          data: dataValues, // Add your data for each month here
          backgroundColor: 'rgba(75, 192, 192, 0.8)'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script> 
