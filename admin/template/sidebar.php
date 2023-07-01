<?php
$base_url = "http://localhost/foodiehub/admin";
$page = $_GET['page']; ?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="./artikel/admin/dashboard.php?page=beranda" class="brand-link">
    <span class="brand-text font-weight-light">Admin Panel</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= $base_url ?>/admin/img/<?= isset($_SESSION['foto']) ? $_SESSION['foto'] : 'foto'; ?>"
          class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">
          <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'GUEST'; ?>
        </a>
      </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=home"
            class="nav-link  <?php if ($page == 'home') { ?>active<?php } ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=admin"
            class="nav-link <?php if ($page == 'admin') { ?>active<?php } ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Admin
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=customers"
            class="nav-link  <?php if ($page == 'customers') { ?>active<?php } ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Customers
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=categories"
            class="nav-link  <?php if ($page == 'categories') { ?>active<?php } ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>
              Categories
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=products"
            class="nav-link  <?php if ($page == 'products') { ?>active<?php } ?>">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Products
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=article"
            class="nav-link  <?php if ($page == 'article') { ?>active<?php } ?>">
            <i class="nav-icon fas fa-newspaper"></i>
            <p>
              Article
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=orders"
            class="nav-link  <?php if ($page == 'orders') { ?>active<?php } ?>">
            <i class="fas fa-shopping-cart nav-icon"></i>
            <p>
              Order
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=header"
            class="nav-link  <?php if ($page == 'header') { ?>active<?php } ?>">
            <i class="nav-icon fas fa-heading"></i>
            <p>
              Header
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=media"
            class="nav-link  <?php if ($page == 'media') { ?>active<?php } ?>">
            <i class="nav-icon fab fa-youtube"></i>
            <p>
              Media
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=footer"
            class="nav-link  <?php if ($page == 'footer') { ?>active<?php } ?>">
            <i class="fas fa-info-circle nav-icon"></i>
            <p>
              Footer
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/dashboard.php?page=about"
            class="nav-link  <?php if ($page == 'about') { ?>active<?php } ?>">
            <i class="nav-icon fas fa-address-card"></i>
            <p>
              About
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= $base_url ?>/signout.php" class="nav-link">
            <i class="nav-icon fas fa-power-off"></i>
            <p>
              Keluar
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>