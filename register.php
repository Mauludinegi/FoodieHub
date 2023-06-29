<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (isset($_POST['submit'])) {
    include("config.php");
    $email = @$_POST['email'];
    $username = @$_POST['username'];
    $name = @$_POST['name'];
    $password = md5(@$_POST['pass']);
    $sql = mysqli_query($mysqli, "select * from customers where username = '$username' || email = '$email'");
    if($sql->num_rows > 0) {
        echo "<script>alert(email atau username sudah ada)</script>";
    } else {
        mysqli_query($mysqli, "insert into customers(email, username, name, password)
        values('$email', '$username', '$name', '$password')");
        header("Location: login.php");
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Form Design Neumorphism</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--=========================www.material design iconic font========================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<link rel="stylesheet" href="front\login & register\css\main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login">
			<div class="wrap-login">
				<form class="login-form validate-form" method="post">
					<span class="login-form-title">
						Sign Up
					</span>
					<div class="wrap-input validate-input" data-validate = "Valid email is: a@email.c">
						<input class="input" type="text" name="email" autocomplete="off">
						<span class="focus-input" data-placeholder="Email"></span>
					</div>
                    <div class="wrap-input validate-input">
						<input class="input" type="text" name="username" autocomplete="off">
						<span class="focus-input" data-placeholder="Username"></span>
					</div>
                    <div class="wrap-input validate-input">
						<input class="input" type="text" name="name" autocomplete="off">
						<span class="focus-input" data-placeholder="Your Name"></span>
					</div>
					<div class="wrap-input validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input" type="password" name="pass">
						<span class="focus-input" data-placeholder="Password"></span>
					</div>

					<div class="container-login-form-btn">
						<div class="wrap-login-form-btn">
							<button class="login-form-btn" type="submit" name="submit">
								Register
							</button>
						</div>
					</div>

					<div class="text-center">
						<span class="txt1">
							have an account?
						</span>

						<a class="txt2" href="login.php">
							Sign In
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

<script src="front/login & register/js/jquery-3.2.1.min.js"></script>

<script src="front/login & register/js/main.js"></script>



</body>
</html>