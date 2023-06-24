<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include("../config.php");
include('session.php');
// $base_url = "localhost/article/admin";
$admin = mysqli_query($mysqli, 'SELECT count(*) jml FROM admin');
$row_admin = mysqli_fetch_assoc($admin);
$customers = mysqli_query($mysqli, 'SELECT count(*) jml FROM customers');
$row_customers = mysqli_fetch_assoc($customers);
$article = mysqli_query($mysqli, 'SELECT count(*) jml FROM article');
$row_article = mysqli_fetch_assoc($article);
$products = mysqli_query($mysqli, 'SELECT count(*) jml FROM products');
$row_products = mysqli_fetch_assoc($products);
$orders = mysqli_query($mysqli, 'SELECT count(*) jml FROM orders');
$row_orders = mysqli_fetch_assoc($orders);
$categories = mysqli_query($mysqli, 'SELECT count(*) jml FROM categories');
$row_categories = mysqli_fetch_assoc($categories);
$orders = mysqli_query($mysqli, 'SELECT categories.name AS category, SUM(orders.quantity) AS total_quantity
FROM orders
INNER JOIN categories ON orders.id_categories = categories.id
GROUP BY orders.id_categories');

$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($orders)) {
    $labels[] = $row['category'];
    $data[] = $row['total_quantity'];
}

$chartData = [
    'labels' => $labels,
    'datasets' => [
        [
            'label' => 'Count Sales',
            'data' => $data,
            'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
            'borderColor' => 'rgba(54, 162, 235, 1)',
            'borderWidth' => 1,
            'fill' => true
        ]
    ]
];
?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            <?= $row_customers['jml'] ?>
                        </h3>
                        <p>customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="../admin/dashboard.php?page=customers" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            <?= $row_article['jml'] ?><sup style="font-size: 20px"></sup>
                        </h3>
                        <p>article</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-pen"></i>
                    </div>
                    <a href="../admin/dashboard.php?page=article" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>
                            <?= $row_admin['jml'] ?>
                        </h3>
                        <p>admin</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <a href="../admin/dashboard.php?page=admin" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>
                            <?= $row_products['jml'] ?>
                        </h3>
                        <p>products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-th"></i>
                    </div>
                    <a href="../admin/dashboard.php?page=products" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>
                            <?= $row_orders['jml'] ?>
                        </h3>
                        <p>orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-th"></i>
                    </div>
                    <a href="../admin/dashboard.php?page=orders" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>
                            <?= $row_categories['jml'] ?>
                        </h3>
                        <p>categories</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-th"></i>
                    </div>
                    <a href="../admin/dashboard.php?page=categories" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        <i class="far fa-chart-bar"></i>
        Kategori Penjualan Paling Laku
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
    <canvas id="salesChart" style="width: 100%; height: 200px;"></canvas>
    </div>
    <!-- /.card-body-->
  </div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
        // Get data for the chart from your database or API
        // Replace the sample data below with your actual data
        var chartData = <?php echo json_encode($chartData); ?>;

        // Create the chart
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
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
</script>