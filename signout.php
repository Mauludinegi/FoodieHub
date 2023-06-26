<?php
session_start();
if (session_destroy()) {
    header("Location: ./front/login & register/login.php");
}
