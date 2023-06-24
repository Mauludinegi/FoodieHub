
  <div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        <i class="far fa-chart-bar"></i>
        Bar Chart
      </h3>
      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
      <div id="salesChart" style="height: 300px;"></div>
    </div>
    <!-- /.card-body-->
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    $(function () {
      // Get data for the chart from your database or API
      // Replace the sample data below with your actual data
      var chartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
          label: 'Sales',
          data: [10, 15, 7, 12, 9, 14],
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          fill: true
        }]
      };

      // Create the chart
      var ctx = document.getElementById('salesChart').getContext('2d');
      var salesChart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
  </script>
