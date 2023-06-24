<?php
include_once("../config.php");
?>
<!-- Main content -->
<div class="row">
    <div class="col-md-9 col-sm-9">
    </div>
    <div class="card-tools d-flex justify-content-between align-items-center">
        <div class="input-group input-group-sm" style="width: 150px;">
            <form class="form-inline" method="post">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search" name="search" autocomplete="off">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit" name="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- This will cause the card to maximize when clicked -->
        <a href='categories/create.php?page=categories' class="btn btn-info ml-2"><i class="fas fa-plus"></i>
            Tambah Kategori</a>
    </div>
    <div style="clear:both"></div>
    <hr />
    <div class="col-md-10 col-sm-12">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="text-align:center;">#</th>
                    <th style="text-align:center;">nama_kategori</th>
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

                // $result = mysqli_query($mysqli, "SELECT * FROM categories LIMIT $start,5");
                $result = null;
                if (isset($_POST['submit'])) {
                    $search = $_POST['search'];
                    $result = mysqli_query($mysqli, "SELECT * FROM categories where name = '$search' ORDER BY id DESC");
                } else if ($result == null) {
                    $result = mysqli_query($mysqli, "SELECT * FROM categories ORDER BY id DESC LIMIT $start, 5");
                } else {
                    echo "<script>alert(data tidak ada);</script>";
                }
                if (mysqli_num_rows($result) > 0) {
                    $i = 1;
                    while ($data = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td style="text-align:center;vertical-align:middle;">
                                <?php echo $no++; ?>
                            </td>
                            <td style="text-align:center;vertical-align:middle;">
                                <?php echo $data['name']; ?>
                            </td>
                            <td>
                                <a class="btn btn-success" href='categories/edit.php?id=<?= $data['id'] ?>&page=categories'>Edit</a>
                                <a class="btn btn-danger" onclick='return confirmDelete()'
                                    href='categories/delete.php?id=<?= $data['id'] ?>&page=categories'>Hapus</a>
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
                <a href="?page=categories&hlm=<?php echo $hlmn; ?>" aria-label="Previous" class="page-link">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <?php
        }

        $hitung = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM categories"));
        $total = ceil($hitung / 5);
        for ($i = 1; $i <= $total; $i++) {
            ?>
            <li <?php if ($hlm == $i) {
                echo 'class="paginate_button page-item active"';
            } else {
                echo 'class="paginate_button page-item"';
            } ?>>
                <a href="?page=categories&hlm=<?php echo $i; ?>" class="page-link">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php
        }

        if ($hlm < $total) {
            $next = $hlm + 1;
            ?>
            <li class="paginate_button page-item next">
                <a href="?page=categories&hlm=<?php echo $next; ?>" aria-label="Next" class="page-link">
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