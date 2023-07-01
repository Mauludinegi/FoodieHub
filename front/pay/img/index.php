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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodieHub</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#F7F7F7]">

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
            <a href="#<?= $row['name']; ?>" class="header"><?= $row['name']; ?></a>
          <?php } ?>
        </div>
        <div class="navbar-left-icon">
          <form method="post" action="#Menu">
            <div class="subnavbar-left-icon">
              <input type="search" class="search-input" placeholder="Search product..." id="search" autocomplete="off"
                name="search" value="<?= $search; ?>">
              <button type="submit" name="submit" style="border: none; background: none; cursor: pointer;">
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


  <!-- Payment -->
  <main>
    <div class="mx-36 pt-24">

      <div class="payment-method">
        <span class="payment-method-span">Payment</span>
        <span class="payment-method-span3">Method</span>
      </div>
      <div class="text-left flex justify-around space-x-8 pt-12">
        <div class="space-y-8 w-1/2">
          <p class="font-bold text-xl">Payment Method</p>
          <form class="bg-white flex rounded-md p-5 mt-4  justify-around">
            <div class="mr-4 space-y-2 w-full">
              <div class="">
                <label for="Card Number">
                  <p class="font-bold">Card Number</p>
                </label>
                <input type="text" id="Card Number" placeholder="Card Number" autocomplete="off"
                  class="p-2 rounded-md border border-gray w-full">
              </div>

              <div class="form-group form-group2">
                <label for="Street Address">
                  <p class="font-bold">Street Address</p>
                </label>
                <input type="text" id="Street Address" placeholder="Street Address" autocomplete="off"
                  class="p-2 rounded-md border border-gray w-full">
              </div>

              <div class="form-group form-group3">
                <label for="State">
                  <p class="font-bold">State</p>
                </label>
                <input type="text" id="State" placeholder="State" autocomplete="off"
                  class="p-2 rounded-md border border-gray w-full">
              </div>
            </div>

            <div class="space-y-2">
              <div class="form-group form-group4 w-full">
                <label for="Name">
                  <p class="font-bold">Name</p>
                </label>
                <input type="text" id="Name" placeholder="Name" autocomplete="off"
                  class="p-2 rounded-md border border-gray w-full">
              </div>

              <div class="form-group form-group5 w-full">
                <label for="Country">
                  <p class="font-bold">Country</p>
                </label>
                <input type="text" id="Country" placeholder="Country" autocomplete="off"
                  class="p-2 rounded-md border border-gray w-full">
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="font-bold">Zip</p>
                  <input type="text" id="Zip" placeholder="Zip" autocomplete="off"
                    class="w-full p-2 rounded-md border border-gray ">
                </div>

                <div>
                  <p class="font-bold">Code</p>
                  <input type="text" id="Code" placeholder="Code" autocomplete="off"
                    class="w-full p-2 rounded-md border border-gray">
                </div>
              </div>



            </div>
          </form>
          <div>
            <p class="font-bold text-xl">Available Payment Method</p>
            <div class="bg-white grid grid-cols-2 p-12 gap-5 mt-4">
              <button class="border border-gray rounded-md flex items-center p-3 gap-x-2 justify-center"><img
                  src="gopay.png" alt="Gopay">Gopay</button>
              <button class="border border-gray rounded-md flex items-center p-3 gap-x-2 justify-center"><img
                  src="shopee.png" alt="ShopeePay">ShopeePay</button>
              <button class="border border-gray rounded-md flex items-center p-3 gap-x-2 justify-center"><img
                  src="dana.png" alt="Dana">Dana</button>

            </div>
          </div>
        </div>

        <div class="bg-white p-6 rounded-xl w-1/2">
          <div class="space-y-6">
            <div class="frame-86 flex items-center justify-between">
              <div class="flex items-center gap-4">

                <img class="HP" src="HP.png" />
                <div class="">
                  <p class="font-bold">
                    Hot Pasta
                  </p>
                  <p class="rp-13-000">
                    Rp 13.000
                  </p>
                </div>
              </div>
              <div class="frame-87 flex bg-[#35b233] rounded-full p-4 space-x-4">
                <button>
                  <svg class="majesticons-minus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19" stroke="#323232" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </button>
                <p class="_1 font-bold">
                  1
                </p>
                <button>
                  <svg class="tabler-plus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="#323232" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </button>
              </div>
            </div>
            <div class="frame-86 flex items-center justify-between">
              <div class="flex items-center gap-4">

                <img class="HP" src="HP.png" />
                <div class="">
                  <p class="font-bold">
                    Hot Pasta
                  </p>
                  <p class="rp-13-000">
                    Rp 13.000
                  </p>
                </div>
              </div>
              <div class="frame-87 flex bg-[#35b233] rounded-full p-4 space-x-4">
                <button>
                  <svg class="majesticons-minus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19" stroke="#323232" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </button>
                <p class="_1 font-bold">
                  1
                </p>
                <button>
                  <svg class="tabler-plus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="#323232" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </button>
              </div>
            </div>
            <div class="frame-86 flex items-center justify-between">
              <div class="flex items-center gap-4">

                <img class="HP" src="HP.png" />
                <div class="">
                  <p class="font-bold">
                    Hot Pasta
                  </p>
                  <p class="rp-13-000">
                    Rp 13.000
                  </p>
                </div>
              </div>
              <div class="frame-87 flex bg-[#35b233] rounded-full p-4 space-x-4">
                <button>
                  <svg class="majesticons-minus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19" stroke="#323232" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </button>
                <p class="_1 font-bold">
                  1
                </p>
                <button>
                  <svg class="tabler-plus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 5V19M5 12H19" stroke="#323232" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <div class="mt-12 space-y-2">
            <hr>
            <div class="flex justify-between">
              <p>Sub Total</p>
              <p>Rp.39.000</p>
            </div>
            <div class="flex justify-between">
              <p>Shipping</p>
              <p>-</p>
            </div>
            <hr>
            <div class="flex justify-between">
              <p>Sub Total</p>
              <p>Rp.39.000</p>
            </div>
          </div>
          <div>
            <button class="bg-[#35b233] rounded-md w-full mt-8 p-4">
              <p class="text-white">Place Your Order</p>
            </button>
          </div>
        </div>
  </main>



  <footer>
    <div class="footer">
      <div class="background-footer"></div>
      <div class="footer-heading">
        <div class="footer-heading-wrap">
          <div class="footer-heading-text">F O O D I E H U B</div>
          <div class="footer-list-sm">
            <a href="https://facebook.com" target="_blank"><img src="img/facebook.png" alt=""></a>
            <a href="https://twitter.com" target="_blank"><img src="img/twitter.png" alt=""></a>
            <a href="https://instagram.com" target="_blank"><img src="img/instagram.png" alt=""></a>
            <a href="https://linkedln.com" target="_blank"><img src="img/linkedln.png" alt=""></a>
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
  </footer>
</body>