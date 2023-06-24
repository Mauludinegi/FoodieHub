<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once("../../config.php");
include('session.php');
define('SITE_ROOT', realpath(dirname(__FILE__)));
// Display selected user data based on id
// Getting id from url
$id = @$_GET['id'];

// Fetech user data based on id
$res_products = mysqli_query($mysqli, "SELECT * FROM products WHERE id=$id");

while ($products = mysqli_fetch_array($res_products)) {
    $row_name = $products['name'];
    $row_description = $products['description'];
    $row_categories = $products['id_category'];
    $row_price = $products['price'];
    $row_quantity = $products['quantity'];
    $row_cover = $products['cover'];
}
?>
<?php
// include config connection file
// Check if form is submitted for user update, then redirect to homepage after update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $created_time = date("Y-m-d H:i:s");
    $user_id = $_SESSION['id'];
    $nameProduct = @$_POST['name_product'];
    $description = @$_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $f = $_POST['f'];
    $gambar = $_FILES['cover'];
    $ext = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
    $tipe = $gambar['type'];
    $size = $gambar['size'];
    
    if (is_uploaded_file($gambar['tmp_name'])) {
        if (!in_array(($tipe), $ext)) {
            echo '<script type="text/javascript">alert("Format gambar tidak diperbolehkan!");window.history.go(-1)</script>';
            return false;
        } else if ($size > 2097152) {
            echo '<script type="text/javascript">alert("Ukuran gambar terlalu besar!");window.history.go(-1);</script>';
            return false;
        } else {
            $extractFile = pathinfo($gambar['name']);
            $dir = "./img/";
            $newName = microtime() . '.' . $extractFile['extension'];

            if (move_uploaded_file($gambar['tmp_name'], $dir . $newName)) {
                unlink('./img/'.$f);
                $result = mysqli_query($mysqli, "UPDATE products SET cover='$newName', name='$nameProduct', price='$price', quantity='$quantity',
                description='$description',id_category='$category',id_admin='$user_id',createdAt='$created_time'
                WHERE id=$id");
                header('location:../dashboard.php?page=products');
                return true;
            } else {
                echo '<script type="text/javascript">alert("Foto gagal diupload");window.history.go(-1);</script>';
                return false;
            }
        }
    } else {
        echo "<script>alert('terjadi kesalahan')</script>";
        return false;
    }
}
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../template/navbar.php'); ?>
        <?php include_once('../template/sidebar.php'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php include_once('content-header.php'); ?>
            <!-- /.content-header -->
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Users</h3>
                                    <div class="card-tools">
                                        <!-- This will cause the card to maximize when clicked -->
                                        <a href="../dashboard.php?page=products"  class="btn btn-info">Kembali</a>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>

                                <div class="card-body">

                                    <form method="post"
                                        enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <input type="hidden" name="f" value="<?= $row_cover; ?>" />
                                        <div class="form-group">
                                            <label for="Name of Product">Nama Barang</label>
                                            <input type="text" class="form-control" value="<?= $row_name ?>"
                                                name="name_product" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="Price">Harga</label>
                                            <input type="number" class="form-control" value="<?= $row_price ?>"
                                                name="price" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="Quantity">Stok</label>
                                            <input type="number" class="form-control" value="<?= $row_quantity ?>"
                                                name="quantity" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="Description">Deskripsi</label>
                                            <textarea type="text" class="form-control" name="description"
                                                required><?= $row_description ?></textarea>
                                        </div>
                                        <?php
                                        $data_kategori = mysqli_query($mysqli, "SELECT * FROM categories ORDER BY id DESC");
                                        ?>
                                        <div class="form-group">
                                            <label for="kategori">Kategori</label>
                                            <select class="form-control" name="category" required>
                                                <option value="">Pilih Kategori</option>
                                                <?php while ($d_kategori = mysqli_fetch_array($data_kategori)) { ?>
                                                    <option value="<?= $d_kategori['id'] ?>" <?php if ($d_kategori['id'] == $row_categories) { ?> <?= 'selected' ?> <?php } ?>>
                                                        <?= $d_kategori['name'] ?></option>
                                                <?php } ?>
                                            </select>

                                            <div class="form-group">
                                                <label for="Cover">Gambar</label>
                                                <input type="file" class="form-control" name="cover" required accept="image/*">
                                            </div>
                                        </div>
                                        <button class="btn btn-primary" type="submit" name="update">Simpan</button>

                                    </form>
                                </div>
                                <!-- /.content-wrapper -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../template/footer.php'); ?>

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <script>
        function confirmDelete() {
            if (confirm('Anda yakin menghapus data?')) {
                //action confirmed
                alert('Data berhasil dihapus');
            } else {
                //action cancelled
                alert('Data batal di hapus');
                return false;

            }
        }
    </script>
</body>

</html>