<?php
session_start();
$newProducts = $_SESSION['cart'];
var_dump($_SESSION["cart"]);



$newProducts = array(
    $_GET['productId'] => '5'
);

$_SESSION["cart"] = $newProducts;
