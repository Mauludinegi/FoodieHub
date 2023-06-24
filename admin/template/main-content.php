<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'admin':
                    include "admin/index.php";
                    break;
                case 'customers':
                    include "customers/index.php";
                    break;
                case 'article':
                    include "article/index.php";
                    break;
                case 'categories':
                    include "categories/index.php";
                    break;
                case 'orders':
                    include "orders/index.php";
                    break;
                case 'home':
                    include "home/index.php";
                    break;
                case 'products':
                    include "products/index.php";
                    break;
                default:
                    echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                    break;
            }
        } else {
            include "/home/index.php";
        }
        ?>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->