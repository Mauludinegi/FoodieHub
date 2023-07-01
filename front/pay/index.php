<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include("../../config.php");

$id = $_GET['id'];
$idCustomer = null;
$user_check = $_SESSION['username'];
$sql = "SELECT * FROM customers WHERE username='$user_check'";
$result = mysqli_query($mysqli, $sql);

if ($result->num_rows == 0) {
    header("Location: ../../index.php");
    exit(); // Tambahkan exit() setelah mengarahkan ke halaman lain
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $idCustomer = $row['id'];
    }
}

$header = mysqli_query($mysqli, "SELECT * FROM header");
$menu = mysqli_query($mysqli, "SELECT * FROM products WHERE id=$id AND quantity > 0");
$name = null;
$cover = null;
$price = null;
$quantity = null;
$idCategory = null;
$idProduct = null;

if (mysqli_num_rows($menu) > 0) {
    while ($row = mysqli_fetch_assoc($menu)) {
        $idProduct = $row['id'];
        $name = $row['name'];
        $cover = $row['cover'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $idCategory = $row['id_category'];
    }
}

if (isset($_POST['order'])) {
    $orderedQuantity = $_POST['quantity'];
    $total = $_POST['total'];
    if ($orderedQuantity <= $quantity) { // Cek apakah jumlah yang dipesan tidak melebihi stok yang tersedia
        $newQuantity = $quantity - $orderedQuantity;

        $order = mysqli_query($mysqli, "INSERT INTO orders(id_product, id_categories, id_customer, price, quantity, total)
                                        VALUES ('$idProduct', '$idCategory', '$idCustomer', '$price', '$orderedQuantity', '$total')");

        $updateProduct = mysqli_query($mysqli, "UPDATE products SET quantity='$newQuantity' WHERE id='$idProduct'");

        if ($order && $updateProduct) {
            echo "<script>alert('Data berhasil ditambahkan ke tabel orders dan stok produk telah diperbarui.');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menambahkan data atau memperbarui stok produk.');</script>";
        }
    } else {
        echo "<script>alert('Jumlah yang dipesan melebihi stok yang tersedia.');</script>";
    }
}
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
                            <input type="search" class="search-input" placeholder="Search product..." id="search"
                                autocomplete="off" name="search">
                            <button type="submit" name="submit"
                                style="border: none; background: none; cursor: pointer;">
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
                        <a href="../../signout.php"><img src="../home/img/logout.png" alt="User Icon"
                                class="cart-icon" /></a>
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
            <form method="post">
                <div class="text-left flex justify-around space-x-8 pt-12">
                    <div class="space-y-8 w-1/2">
                        <p class="font-bold text-xl">Payment Method</p>
                        <div class="bg-white flex rounded-md p-5 mt-4  justify-around">
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
                                    <input type="text" id="Street Address" placeholder="Street Address"
                                        autocomplete="off" class="p-2 rounded-md border border-gray w-full">
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
                        </div>

                        <div>
                            <p class="font-bold text-xl">Available Payment Method</p>
                            <div class="bg-white grid grid-cols-2 p-12 gap-5 mt-4">
                                <label
                                    class="border border-gray rounded-md flex items-center p-3 gap-x-2 justify-center">
                                    <input type="radio" name="paymentMethod" value="gopay">
                                    <img src="img/gopay.png" alt="Gopay"> Gopay
                                </label>
                                <label
                                    class="border border-gray rounded-md flex items-center p-3 gap-x-2 justify-center">
                                    <input type="radio" name="paymentMethod" value="shopeepay">
                                    <img src="img/shopee.png" alt="ShopeePay"> ShopeePay
                                </label>
                                <label
                                    class="border border-gray rounded-md flex items-center p-3 gap-x-2 justify-center">
                                    <input type="radio" name="paymentMethod" value="dana">
                                    <img src="img/dana.png" alt="Dana"> Dana
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl w-1/2">
                        <div class="space-y-6">
                            <div class="frame-86 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <img class="HP" src="../../admin/products/img/<?= $cover; ?>"
                                        style="width: 62.59px; height: 62.59px;" />
                                    <div class="">
                                        <p class="font-bold">
                                            <?= $name ?>
                                        </p>
                                        <p class="rp-13-000">
                                            Rp.
                                            <?= $price; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="frame-87 flex bg-[#35b233] rounded-full p-4 space-x-4">
                                    <button id="decrementBtn" type="button">
                                        <svg class="majesticons-minus" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5 12H19" stroke="#323232" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                    <input type="number" id="countInput" class="_1 font-bold" value="1"
                                        data-price="<?= $price ?>" name="quantity"
                                        style="width: 23px; background: none; font-weight: 600; display: flex; text-align: center;"
                                        readonly>
                                    <button id="incrementBtn" type="button">
                                        <svg class="tabler-plus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 5V19M5 12H19" stroke="#323232" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-12 space-y-2">
                            <hr>
                            <div class="flex justify-between">
                                <p>Sub Total</p>
                                <p id="subTotal1"></p>
                            </div>
                            <div class="flex justify-between">
                                <p>Shipping</p>
                                <p>-</p>
                            </div>
                            <hr>
                            <div class="flex justify-between">
                                <p>Sub Total</p>
                                <p id="subTotal2"></p>
                            </div>
                            <input type="hidden" id="total" name="total" value="">
                        </div>
                        <div>
                            <button class="bg-[#35b233] rounded-md w-full mt-8 p-4" type="submit" name="order">
                                <p class="text-white">Place Your Order</p>
                            </button>
                        </div>
                    </div>
            </form>
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

    <script>
        // document.addEventListener('DOMContentLoaded', () => {
        //     const decrementBtn = document.getElementById('decrementBtn');
        //     const incrementBtn = document.getElementById('incrementBtn');
        //     const countInput = document.getElementById('countInput');
        //     const subtotalElement1 = document.getElementById('subTotal1');
        //     const subtotalElement2 = document.getElementById('subTotal2');
        //     const total = document.getElementsByName('total');

        //     decrementBtn.addEventListener('click', (event) => {
        //         event.preventDefault();
        //         if (countInput.value > 1) {
        //             countInput.value--;
        //             calculateSubtotal();
        //         }
        //     });

        //     incrementBtn.addEventListener('click', (event) => {
        //         event.preventDefault();
        //         countInput.value++;
        //         calculateSubtotal();
        //     });

        //     function updateSubTotal() {
        //         const quantity = parseInt(countInput.value);
        //         const price = parseInt(countInput.getAttribute('data-price'));
        //         total = quantity * price;
        //         subTotal2.textContent = 'Rp.' + total.toLocaleString();
        //         // Set nilai subTotal2 ke dalam input value
        //         subTotal2.value = total;
        //     }
        //     const price = parseFloat(countInput.dataset.price);

        //     function calculateSubtotal() {
        //         const count = parseInt(countInput.value);
        //         const subtotal = price * count;
        //         subtotalElement1.textContent = 'Rp.' + subtotal.toFixed(0);
        //         subtotalElement2.textContent = 'Rp.' + subtotal.toFixed(0);
        //         total = subtotal;
        //     }

        //     calculateSubtotal();
        //     updateSubTotal();
        // });

        document.addEventListener('DOMContentLoaded', () => {
    const decrementBtn = document.getElementById('decrementBtn');
    const incrementBtn = document.getElementById('incrementBtn');
    const countInput = document.getElementById('countInput');
    const subtotalElement1 = document.getElementById('subTotal1');
    const subtotalElement2 = document.getElementById('subTotal2');
    const totalElement = document.getElementById('total');

    decrementBtn.addEventListener('click', (event) => {
        event.preventDefault();
        if (countInput.value > 1) {
            countInput.value--;
            calculateSubtotal();
        }
    });

    incrementBtn.addEventListener('click', (event) => {
        event.preventDefault();
        countInput.value++;
        calculateSubtotal();
    });

    function calculateSubtotal() {
        const count = parseInt(countInput.value);
        const price = parseFloat(countInput.dataset.price);
        const subtotal = price * count;
        subtotalElement1.textContent = 'Rp.' + subtotal.toLocaleString();
        subtotalElement2.textContent = 'Rp.' + subtotal.toLocaleString();
        totalElement.value = subtotal;
    }

    calculateSubtotal();
});

    </script>
</body>

</html>