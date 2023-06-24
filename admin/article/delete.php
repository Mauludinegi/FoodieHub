<?php
// include config connection file
include_once("../../config.php");
include('session.php');

//ambil id dari url
$id = $_GET['id'];
//hapus file gambar dari folder gambar
$query = mysqli_query($mysqli, "SELECT * FROM article WHERE id
= '$id'");
$data = mysqli_fetch_array($query);
$nama_file = $data['cover'];
unlink('./img/' . $nama_file);
//
//hapus data dari database
$hapus = mysqli_query($mysqli, "DELETE FROM article WHERE id =
'$id'");
//cek apakah proses hapus data berhasil
if ($hapus) {
    //jika berhasil tampilkan pesan berhasil hapus data
    echo "<script>
 alert('Data Berhasil Dihapus');
 </script>";
 header("Location:../dashboard.php?page=article");
} else {
    //jika gagal tampilkan pesan gagal hapus data
    echo "<script>
 alert('Data Gagal Dihapus');
 </script>";
 header("Location:../dashboard.php?page=article");
}

?>
