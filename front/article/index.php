<?php
session_start();
include("../../config.php");
$user_check = $_SESSION['username'];
$sql = "SELECT username FROM customers WHERE username='$user_check'";
$result = mysqli_query($mysqli, $sql);
if ($result->num_rows == 0) {
  header("Location: ../../index.php");
}

$id = $_GET['id'];
$header = mysqli_query($mysqli, "select * from header");
$article = mysqli_query($mysqli, "SELECT article.*, 
                                  admin.username as name
                                  from article
                                  INNER JOIN admin ON article.id_admin = admin.id where article.id = $id
");
$media = mysqli_query($mysqli, "select * from media");
$info = mysqli_query($mysqli, "select * from footer order by id desc");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Article FoodieHub</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav>
    <div class="navbar">
      <div class="logo">
        <div class="group">
          <div class="layer-2">
            <div class="objects">
              <a href="#Home" style="text-decoration: none;">
                <div class="foodie-hub">FoodieHub</div>
                <img class="logo-icon" src="../home/img/logo.png" alt="Logo" width="46" height="47">
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-right">
        <div class="subnavbar-right">
          <?php while ($row = mysqli_fetch_assoc($header)) { ?>
            <a href="../home/index.php#<?= $row['name']; ?>" class="header"><?= $row['name']; ?></a>
          <?php } ?>
        </div>
        <div class="navbar-left-icon">
          <form method="post" action="#Menu">
            <div class="subnavbar-left-icon">
              <input type="search" class="search-input" placeholder="Search product...">
              <button type="submit" name="submit" style="all: unset;">
                <img src="../home/img/search.png" alt="Search Icon" class="search-icon" />
              </button>
              <button type="submit" name="reset" style="cursor: pointer; background: none; border: none;">
                <img src="../home/img/close.png" alt="reset">
              </button>
            </div>
          </form>
          <div class="cart">
            <a href="../keranjang/index.html"><img src="../home/img/keranjang.png" alt="Keranjang Icon"
                class="cart-icon" /></a>
          </div>
          <div class="cart">
            <a href="../../signout.php"><img src="../home/img/logout.png" alt="User Icon" class="cart-icon" /></a>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <?php while ($row = mysqli_fetch_assoc($article)) {
    $date = date("Y-m-d", strtotime($row['createdAt']));
    ?>
    <div class="wrap-article">
      <img src="../../admin/article/img/<?= $row['cover']; ?>" alt="" class="image">
      <div class="article-date">Date:
        <?= $date; ?> By:
        <?= $row['name']; ?>
      </div>
      <div class="article-title">
        <?= $row['judul']; ?>
      </div>
    </div>
    <article>
      <?= $row['content_article']; ?>
    </article>
    <!-- <a href="">Kembali</a> -->
  <?php } ?>
  <div class="footer">
    <div class="background-footer"></div>
    <div class="footer-heading">
      <div class="footer-heading-wrap">
        <div class="footer-heading-text">F O O D I E H U B</div>
        <div class="footer-list-sm">
          <?php while ($row = mysqli_fetch_assoc($media)) { ?>
            <a href="https://<?= $row['name']; ?>.com" target="_blank"><img
                src="../../admin/media/img/<?= $row['icon']; ?>" alt=""></a>
          <?php } ?>
        </div>
      </div>
      <div class="footer-list-support">
        <div class="footer-list">
          <div class="heading-list">Support</div>
          <div class="wrap-list">
            <?php while ($row = mysqli_fetch_assoc($info)) { ?>
              <div class="list">
                <?= $row['name']; ?>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="footer-list">
          <div class="heading-list">Info</div>
          <div class="wrap-list">
            <div class="list">Date</div>
            <div class="list">Parties</div>
            <div class="list">Birthdays</div>
            <div class="list">Menu</div>
          </div>
        </div>
        <div class="footer-list">
          <div class="heading-list">Contact</div>
          <div class="wrap-list">
            <div class="wrap-icon-list">
              <img src="img/location.png" alt="" srcset="">
              <div class="text-list">Jln. Angkrek</div>
            </div>
            <div class="wrap-icon-list">
              <img src="img/mail.png" alt="">
              <div class="text-list">foodiehub.co.id</div>
            </div>
            <div class="wrap-icon-list">
              <img src="img/call.png" alt="" srcset="">
              <div class="text-list">0221-5612-3335</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>