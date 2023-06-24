<?php
include_once("../../config.php");
include('session.php');

// Display selected user data based on id
// Getting id from url
$id = @$_GET['id'];
// Fetech user data based on id
$result = mysqli_query($mysqli, "SELECT * FROM admin WHERE id = $id");
while ($user_data = mysqli_fetch_array($result)) {
    $row_username = $user_data['username'];
    $row_nama_operator = $user_data['name'];
    $row_foto = $user_data['foto'];
}

// include config connection file
// Check if form is submitted for user update, then redirect to homepage after update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = @$_POST['username'];
    $password = md5(@$_POST['password']);
    $nama_operator = @$_POST['nama_operator'];
    $gambar = $_FILES['foto'];
    $f = $_POST['f'];
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
                // update user data
                if ($password) {
                    $result = mysqli_query($mysqli, "UPDATE admin SET username='$username', name='$nama_operator', password='$password', foto='$newName' WHERE id=$id");
                } else {
                    $result = mysqli_query($mysqli, "UPDATE admin SET username='$username', name='$nama_operator', foto='$newName' WHERE id=$id");
                }

                if ($result) {
                    echo "<script>
                        alert('Data user berhasil diubah');
                        </script>";
                        header('Location:../dashboard.php?page=admin');
                } else {
                    echo '<script type="text/javascript">alert("Terjadi kesalahan saat mengubah data pengguna");window.history.go(-1);</script>';
                }
            } else {
                echo '<script type="text/javascript">alert("Foto gagal diupload");window.history.go(-1);</script>';
                return false;
            }
        }
    } else {
        echo "<script>alert('Terjadi kesalahan');window.history.go(-1);</script>";
        return false;
    }
}
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.

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
                                    <h3 class="card-title">Data Admin</h3>
                                    <div class="card-tools">
                                        <!-- This will cause the card to maximize when clicked -->
                                        <a href="../dashboard.php?page=admin" class="btn btn-info">Kembali</a>
                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <div class="card-body">

                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <input type="hidden" name="f" value="<?= $row_foto; ?>" />
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" value="<?= $row_username ?>"
                                                name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_operator">Nama</label>
                                            <input type="text" class="form-control" value="<?= $row_nama_operator ?>"
                                                name="nama_operator" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_operator">Foto</label>
                                            <input type="file" class="form-control" name="foto" required
                                                accept="image/*">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password" required>
                                            
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