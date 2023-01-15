<?php 
session_start();
// unset($_SESSION['login_user']);
// session_destroy();
print_r($_SESSION['login_user']);
die;
header('location:../index.php');
?>