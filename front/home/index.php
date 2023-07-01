<?php
session_start();
include("../../config.php");
$user_check = $_SESSION['username'];
$sql = "SELECT username FROM customers WHERE username='$user_check'";
$result = mysqli_query($mysqli, $sql);
if ($result->num_rows == 0) {
  header("Location: ../../index.php");
}
$header = mysqli_query($mysqli, "select * from header");
$popular = mysqli_query($mysqli, "select * from products where quantity > 0 order by id desc limit 4");
$menu = null;
$about = mysqli_query($mysqli, "select * from about");
$article = mysqli_query($mysqli, "SELECT article.*, 
                                  admin.username as name
                                  from article
                                  INNER JOIN admin ON article.id_admin = admin.id
");
$media = mysqli_query($mysqli, "select * from media");
$info = mysqli_query($mysqli, "select * from footer order by id desc");
$search = null;
if (isset($_POST['submit'])) {
  $search = $_POST['search'];
  $menu = mysqli_query($mysqli, "select id, name, description, price, quantity, cover, id_category from products where quantity > 0 and name='$search' order by id desc");
} else if (isset($_POST['reset'])) {
  $menu = mysqli_query($mysqli, "SELECT id, name, description, price, quantity, cover, id_category FROM products WHERE quantity > 0 ORDER BY id DESC");
} else {
  $menu = mysqli_query($mysqli, "select id, name, description, price, quantity, cover, id_category from products where quantity > 0 order by id desc");
}
$count = mysqli_num_rows($menu);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodieHub</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Menyembunyikan ikon "x" pada input tipe pencarian */
    input[type="search"]::-webkit-search-cancel-button,
    input[type="search"]::-webkit-search-decoration,
    input[type="search"]::-webkit-search-results-button,
    input[type="search"]::-webkit-search-results-decoration {
      display: none;
    }
  </style>
</head>

<body>
  <!-- Navbar Start -->
  <nav>
    <div class="navbar">
      <div class="logo">
        <div class="group">
          <div class="layer-2">
            <div class="objects">
              <a href="#Home" style="text-decoration: none;">
                <div class="foodie-hub">FoodieHub</div>
                <img class="logo-icon" src="img/logo.png" alt="Logo" width="46" height="47">
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-right">
        <div class="subnavbar-right">
          <?php while ($row = mysqli_fetch_assoc($header)) { ?>
            <a href="#<?= $row['name']; ?>" class="header"><?= $row['name']; ?></a>
          <?php } ?>
        </div>
        <div class="navbar-left-icon">
          <form method="post" action="#Menu">
            <div class="subnavbar-left-icon">
              <input type="search" class="search-input" placeholder="Search product..." id="search" autocomplete="off"
                name="search" value="<?= $search; ?>">
              <button type="submit" name="submit" style="border: none; background: none; cursor: pointer;">
                <img src="img/search.png" alt="Search Icon" class="search-icon" />
              </button>
              <button type="submit" name="reset" style="cursor: pointer; background: none; border: none;">
                <img src="img/close.png" alt="reset">
              </button>
            </div>
          </form>
          <div class="cart">
            <a href="../keranjang/index.html"><img src="img/keranjang.png" alt="Keranjang Icon" class="cart-icon" /></a>
          </div>
          <div class="cart">
            <a href="../../signout.php"><img src="img/logout.png" alt="User Icon" class="cart-icon" /></a>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- content landing -->
  <div class="landing" id="Home">
    <div class="frame-5">
      <div class="raih-kenikmatan-kuliner-dalam-satu-sentuhan">
        <span><span class="raih-kenikmatan-kuliner-dalam-satu-sentuhan-span">Raih Kenikmatan </span><span
            class="raih-kenikmatan-kuliner-dalam-satu-sentuhan-span2">Kuliner</span><span
            class="raih-kenikmatan-kuliner-dalam-satu-sentuhan-span3">
            dalam </span><span class="raih-kenikmatan-kuliner-dalam-satu-sentuhan-span4">Satu Sentuhan</span></span>
      </div>

      <div
        class="lorem-ipsum-dolor-sit-amet-consectetur-tellus-mauris-consequat-in-eget-id-amet-in-lacus-nunc-integer-dignissim-neque-turpis">
        Mari kita bersama-sama menjelajahi dunia rasa yang tak terbatas, merasakan setiap sentuhan cita rasa, dan memperkaya hidup kita dengan pengalaman kuliner yang tak terlupakan.
      </div>

      <a href="#Menu">
        <div class="frame-4">
          <div class="frame-3">
            <div class="order-now">Order now</div>
          </div>
        </div>
      </a>
    </div>

    <div class="food-main">
      <img src="img/Food Main.png" alt="" srcset="">
    </div>
  </div>
  <!-- Content Landing End -->


  <!-- popular now -->
  <div class="popular">
    <div class="popular-now">
      <span class="popular-now-span">Popular</span>
      <span class="popular-now-span3">Now</span>
    </div>

    <div class="sub-popular">
      <?php while ($row = mysqli_fetch_assoc($popular)): ?>
        <div class="menu-item">
          <img class="menu-image" src="../../admin/products/img/<?php echo $row['cover']; ?>" />
          <div class="menu-details">
            <div class="header-popular">
              <?php echo $row['name']; ?>
            </div>
            <div class="text-popular-menu">
              <?php echo $row['description']; ?>
            </div>
            <div class="menu-price">
              <div class="harga">Harga</div>
              <div class="currency">
                <?php echo "Rp " . $row['price']; ?>
              </div>
            </div>
            <a href="../pay/index.php?id=<?= $row['id'] ?>">
              <div class="order-now">Order Now</div>
            </a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
  <!-- Popular Now End -->

  <!-- Menu Popular -->
  <div class="popular" id="Menu">
    <div class="popular-now">
      <span class="popular-now-span">Our</span>
      <span class="popular-now-span3">Menu</span>
    </div>

    <div class="sub-popular">
      <div class="frame-18">
        <?php
        $count = 0;
        if (mysqli_num_rows($menu) > 0) {
          while ($row = mysqli_fetch_assoc($menu)) {
            if ($count % 3 == 0) {
              echo '<div class="frame-16">';
            }
            ?>

            <div class="frame-17">
              <img class="img-menu" src="../../admin/products/img/<?php echo $row['cover']; ?>" />
              <div class="frame-10">
                <div class="frame-8">
                  <div class="header-menu-product">
                    <?php echo $row['name']; ?>
                  </div>
                  <div class="description-product-menu">
                    <?php echo $row['description']; ?>
                  </div>
                  <div class="menu-price">
                    <div class="harga">Harga</div>
                    <div class="currency">
                      <?php echo "Rp " . $row['price']; ?>
                    </div>
                  </div>
                  <div class="menu-price">
                    <div class="harga">Stok</div>
                    <div class="currency">
                      <?php echo " " . $row['quantity']; ?>
                    </div>
                  </div>
                </div>
                <div class="frame-9">
                  <div class="frame-7">
                    <a href="../pay/index.php?id=<?= $row['id'] ?>" style="text-decoration: none;">
                      <div class="order-now-menu">Order Now</div>
                    </a>
                  </div>
                  <div class="frame-6">
                    <a href="../keranjang/index.php" style="text-decoration: none;">
                      <div class="add-to-cart">Add to Cart</div>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <?php
            $count++;
            if ($count % 3 == 0) {
              echo '</div>';
            }
          }

          if ($count % 3 != 0) {
            echo '</div>';
          }
        } else { ?>
          <h1 style="text-align: center;"> Menu tidak ditemukan</h1>
       <?php }
        ?>
      </div>
    </div>
  </div>

  <!-- Menu Popular End -->


  <!-- About -->
  <div class="popular" id="About Us">
    <div class="popular-now">
      <span class="popular-now-span" style="text-align: center;">About</span>
      <span class="popular-now-span3">Us</span>
    </div>

    <?php while ($row = mysqli_fetch_assoc($about)) {
      ?>
      <div class="frame-60">
        <img class="img-about" src="../../admin/about/img/<?= $row['cover']; ?>" />
        <div class="frame-59">
          <div class="frame-56">
            <p class="text-about">
              <?= $row['description']; ?>
            </p>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Article -->
  <div class="article-container" id="Article">
    <div>
      <span class="article-heading">Our</span>
      <span class="article-heading-green">Article</span>
    </div>
    <div class="article-list">
      <?php while ($row = mysqli_fetch_assoc($article)) {
        $date = date("Y-m-d", strtotime($row['createdAt']));
        ?>
        <div class="article-card">
          <img class="article-image" src="../../admin/article/img/<?= $row['cover']; ?>" />
          <div class="article-details">
            <div class="article-meta">
              <div class="article-date">Date:
                <?= $date ?> By:
                <?= $row['name']; ?>
              </div>
              <div class="article-title">New menu added our menu you can exchange your test</div>
            </div>
            <a href="../article/index.php?id=<?= $row['id']; ?>">
              <div class="article-actions">
                <div class="read-more-button">Read more</div>
              </div>
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- Customers Start -->
  <div class="customers">
    <div class="customers-heading">
      <span><span class="customers-heading-black">What Our </span><span class="customers-heading-green">Customer
          Says</span></span>
    </div>
    <div class="customers-list">
      <div class="customers-card">
        <div class="customers-wrap">
          <div class="customers-wrap-image">
            <div class="user">
              <img class="img-user" src="img/User (1).png" />
            </div>
            <div class="customers-wrap-name">
              <div class="customers-name">Annisha M</div>
              <img src="img/Frame 20.png" alt="">
            </div>
          </div>
          <div class="date">23/April/2023</div>
        </div>
        <div class="customers-text">
          Lorem ipsum dolor sit amet consectetur. Quisque nibh lacus odio amet
          tellus. Vestibu aliquet placerat scelerisque laoreet eget quisque
          consequat.
        </div>
      </div>
      <div class="customers-card">
        <div class="customers-wrap">
          <div class="customers-wrap-image">
            <div class="user">
              <img class="img-user" src="img/User (1).png" />
            </div>
            <div class="customers-wrap-name">
              <div class="customers-name">Annisha M</div>
              <img src="img/Frame 20.png" alt="">
            </div>
          </div>
          <div class="date">23/April/2023</div>
        </div>
        <div class="customers-text">
          Lorem ipsum dolor sit amet consectetur. Quisque nibh lacus odio amet
          tellus. Vestibu aliquet placerat scelerisque laoreet eget quisque
          consequat.
        </div>
      </div>
      <div class="customers-card">
        <div class="customers-wrap">
          <div class="customers-wrap-image">
            <div class="user">
              <img class="img-user" src="img/User (1).png" />
            </div>
            <div class="customers-wrap-name">
              <div class="customers-name">Annisha M</div>
              <img src="img/Frame 20.png" alt="">
            </div>
          </div>
          <div class="date">23/April/2023</div>
        </div>
        <div class="customers-text">
          Lorem ipsum dolor sit amet consectetur. Quisque nibh lacus odio amet
          tellus. Vestibu aliquet placerat scelerisque laoreet eget quisque
          consequat.
        </div>
      </div>
    </div>
  </div>

  <!-- footer -->
  <div class="footer">
    <div class="background-footer"></div>
    <div class="footer-heading">
      <div class="footer-heading-wrap">
        <div class="footer-heading-text">F O O D I E H U B</div>
        <div class="footer-list-sm">
          <?php while ($row = mysqli_fetch_assoc($media)) { ?>
          <a href="https://<?= $row['name']; ?>.com" target="_blank"><img src="../../admin/media/img/<?= $row['icon']; ?>" alt=""></a>
        <?php } ?>
        </div>
      </div>
      <div class="footer-list-support">
        <div class="footer-list">
          <div class="heading-list">Support</div>
          <div class="wrap-list">
            <div class="list">Faq</div>
            <div class="list">Shipping &amp; Returns</div>
            <div class="list">Contact Us</div>
            <div class="list">Our Partners</div>
          </div>
        </div>
        <div class="footer-list">
          <div class="heading-list">Info</div>
          <div class="wrap-list">
            <?php while ($row = mysqli_fetch_assoc($info)) { ?>
            <div class="list"><?= $row['name']; ?></div>
         <?php } ?>
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

  <script>
    var searchInput = document.getElementById('search');
    searchInput.addEventListener('keyup', function (event) {
      if (event.keyCode === 13) {
        document.getElementById('menu').scrollIntoView();
      }
    });
  </script>

</body>

</html>