<?php
// include config connection file
include_once("../../config.php");
include('session.php');

// Get id from URL to delete that user
$id = @$_GET['id'];

// Delete user row from table based on given id
$result = mysqli_query($mysqli, "DELETE FROM header WHERE id=$id");

// After delete redirect to Home, so that latest user list will be displayed.
header("Location:../dashboard.php?page=header");
