<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];

            switch ($page) {
                case 'article':
                    include "article/content-header.php";
                    break;
                case 'customers':
                    include "customers/content-header.php";
                    break;
                case 'admin':
                    include "admin/content-header.php";
                    break;
                case 'categories':
                    include "categories/content-header.php";
                    break;
                case 'orders':
                    include "orders/content-header.php";
                    break;
                case 'home':
                    include "home/content-header.php";
                    break;
                case 'products':
                    include "products/content-header.php";
                    break;
                case 'header':
                    include "header/content-header.php";
                    break;
                case 'about':
                    include "about/content-header.php";
                    break;
                case 'footer':
                    include "footer/content-header.php";
                    break;
                default:
                    echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                    break;
            }
        } else {
            include "/home.php";
        }

        ?>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->