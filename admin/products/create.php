<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include("../../config.php");
include('session.php');

if (isset($_POST['submit'])) {
    $created_time = date("Y-m-d H:i:s");
    $user_id = $_SESSION['id'];
    $nameProduct = @$_POST['name_product'];
    $description = @$_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $gambar = $_FILES['cover'];
    $ext = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
    $tipe = $gambar['type'];
    $size = $gambar['size'];
    $sql = "SELECT * FROM products WHERE name='$nameProduct'";
    $result = mysqli_query($mysqli, $sql);
    if ($result->num_rows > 0) {
        echo '<script type="text/javascript">alert("Article sudah ada");window.history.go(-1);</script>';
    } else {
        if (is_uploaded_file($gambar['tmp_name'])) { //cek apakah ada file yang di upload

            if (!in_array(($tipe), $ext)) { //cek ekstensi file
                echo '<script type="text/javascript">alert("Format gambar tidak diperbolehkan!");window.history.go(-1)</script>';
                return false;
            } else if ($size > 2097152) {
                echo '<script type="text/javascript">alert("Ukuran gambar terlalu besar!");window.history.go(-1);</script>';
                return false;
            } else {
                $extractFile = pathinfo($gambar['name']);
                $dir = "./img/";
                $newName = microtime() . '.' . $extractFile['extension'];

                //pindahkan file yang di upload ke directory tujuan bila berhasil jalankan perintah query untuk mennyimpan ke database
                if (move_uploaded_file($gambar['tmp_name'], $dir . $newName)) {
                    $result = mysqli_query($mysqli, "INSERT INTO products(name,createdAt,id_admin,id_category, description, cover, price, quantity)
                    VALUES('$nameProduct','$created_time','$user_id','$category','$description','$newName', '$price', '$quantity')");
                    header("Location:../dashboard.php?page=products");
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
}
// 
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
        <?php include('../template/navbar.php'); ?>
        <?php include('../template/sidebar.php'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php include('content-header.php'); ?>
            <!-- /.content-header -->
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">

                                <div class="card-header">
                                    <h3 class="card-title">Data Article
                                    </h3>

                                    <div class="card-tools">
                                        <!-- This will cause the card to maximize when clicked -->
                                        <a href="../dashboard.php?page=products" class="btn btn-info">Kembali</a>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <form action="../products/create.php?page=products" method="post"
                                    enctype="multipart/form-data">

                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="Name Of Product">Nama Barang</label>
                                            <input type="text" class="form-control" name="name_product" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Harga</label>
                                            <input type="number" class="form-control" name="price" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="Quantity">Stok</label>
                                            <input type="number" class="form-control" name="quantity" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Deskripsi</label>
                                            <textarea type="text" class="form-control" name="description"
                                                required></textarea>
                                        </div>
                                        <?php
                                        $kategori = mysqli_query($mysqli, "SELECT * FROM categories ORDER BY id DESC");
                                        ?>
                                        <div class="form-group">
                                            <label for="content_artikel">Kategori</label>
                                            <select class="form-control" name="category" required>
                                                <option value="">Pilih Kategori</option>
                                                <?php while ($data = mysqli_fetch_array($kategori)) { ?>
                                                    <option value="<?= $data['id'] ?>"><?= $data['name'] ?>
                                                    </option>
                                                <?php } ?>
                                                <select>
                                        </div>
                                        <div class="form-group">
                                            <label for="Cover">Gambar</label>
                                            <input type="file" class="form-control" name="cover" required
                                                accept="image/*">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-primary" type="submit" name="submit">Simpan</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->


        <?php include('../template/footer.php'); ?>

    </div>
</body>
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
        } else {
            //action cancelled
            alert('Data batal di hapus');
            return false;

        }
    }
</script>
</body>

</html>