<?php
include_once("../config.php");

// global $submit;
// global $search;
// $result = null;
// if (isset($submit)) {
//     $result = mysqli_query($mysqli, "SELECT * FROM tb_users where username = '$search' || nama_operator = '$search' ORDER BY id DESC");
// } else if ($result == null) {
//     $result = mysqli_query($mysqli, "SELECT * FROM tb_users ORDER BY id DESC");
// } else {
//     echo "<script>alert(data tidak ada);</script>";
// }
?>

<!-- Main content -->
<div class="row">
    <div class="col-md-9 col-sm-9">
    </div>
    <div class="card-tools d-flex justify-content-between align-items-center">
        <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control" placeholder="Search">
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- This will cause the card to maximize when clicked -->
        <a href='users/create.php?page=users' class="btn btn-info ml-2"><i class="fas fa-plus"></i>
            Tambah Users</a>
    </div>
    <div style="clear:both"></div>
    <hr />
    <div class="col-md-10 col-sm-12">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="text-align:center;">#</th>
                    <th style="text-align:center;">Username</th>
                    <th style="text-align:center">Nama Operator</th>
                    <th width="130px" style="text-align:center;">Foto</th>
                    <th width="200px" style="text-align:center;">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET['hlm'])) {
                    $hlm = $_GET['hlm'];
                    $no = (5 * $hlm) - 4;
                } else {
                    $hlm = 1;
                    $no = 1;
                }
                $start = ($hlm - 1) * 5;

                $sql = mysqli_query($mysqli, "SELECT * FROM tb_users LIMIT $start,5");

                if (mysqli_num_rows($sql) > 0) {
                    $i = 1;
                    while ($data = mysqli_fetch_array($sql)) {
                        ?>
                        <tr>
                            <td style="text-align:center;vertical-align:middle;">
                                <?php echo $no++; ?>
                            </td>
                            <td style="text-align:center;vertical-align:middle;">
                                <?php echo $data['username']; ?>
                            </td>
                            <td style="text-align:center;vertical-align:middle;">
                                <?php echo $data['nama_operator']; ?>
                            </td>
                            <td>
                                <div class="user-panel d-flex justify-content-center">
                                    <div class="image">
                                        <img src="../admin/users/img/<?= $data['foto']; ?>" alt="Gambar"
                                            class="img-square elevation-1" style="width: 60px; height: 50px;">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-success" href='berita/edit.php?id=<?= $data['id'] ?>&page=users'>Edit</a>
                                <a class="btn btn-danger" onclick='return confirmDelete()'
                                    href='berita/delete.php?id=<?= $data['id'] ?>&page=users'>Hapus</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr>
                              <td colspan='5' style='text-align:center;'><h4>Belum ada data</h4></td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        echo '<ul class="pagination">';
        if ($hlm > 1) {
            $hlmn = $hlm - 1;
            ?>
            <li class="paginate_button page-item previous">
                <a href="?page=users&hlm=<?php echo $hlmn; ?>" aria-label="Previous" class="page-link">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <?php
        }

        $hitung = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM tb_users"));
        $total = ceil($hitung / 5);
        for ($i = 1; $i <= $total; $i++) {
            ?>
            <li <?php if ($hlm == $i) {
                echo 'class="paginate_button page-item active"';
            } else {
                echo 'class="paginate_button page-item"';
            } ?>>
                <a href="?page=users&hlm=<?php echo $i; ?>" class="page-link">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php
        }

        if ($hlm < $total) {
            $next = $hlm + 1;
            ?>
            <li class="paginate_button page-item next">
                <a href="?page=users&hlm=<?php echo $next; ?>" aria-label="Next" class="page-link">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            <?php
        }

        echo '</ul>';
        ?>
    </div>
</div>