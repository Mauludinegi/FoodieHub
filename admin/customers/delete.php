<?php
// include config connection file
include_once("../../config.php");
include('session.php');

// // Get id from URL to delete that user
// $id = @$_GET['id'];

// // Delete user row from table based on given id
// $result = mysqli_query($mysqli, "DELETE FROM admin WHERE id=$id");

// // After delete redirect to Home, so that latest user list will be displayed.
// header("Location:../dashboard.php?page=users");

//load koneksi database
//ambil id dari url
$id = $_GET['id'];
//hapus file gambar dari folder gambar
$query = mysqli_query($mysqli, "SELECT * FROM customers WHERE id
= '$id'");
$data = mysqli_fetch_array($query);
$nama_file = $data['foto'];
unlink('./img/' . $nama_file);
//
//hapus data dari database
$hapus = mysqli_query($mysqli, "DELETE FROM customers WHERE id =
'$id'");
//cek apakah proses hapus data berhasil
if ($hapus) {
    //jika berhasil tampilkan pesan berhasil hapus data
    echo "<script>
 alert('Data Berhasil Dihapus');
 </script>";
 header("Location:../dashboard.php?page=customers");
} else {
    //jika gagal tampilkan pesan gagal hapus data
    echo "<script>
 alert('Data Gagal Dihapus');
 </script>";
 header("Location:../dashboard.php?page=customers");
}

?>
