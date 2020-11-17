<?php
session_start();
$newProducts = $_SESSION['cart'];
var_dump($_SESSION["cart"]);


<<<<<<< HEAD

$newProducts = array(
    $_GET['productId'] => '5'
=======
//tijdelijke test array!!!
$winkelwagen = array(
    "1" => "2",
    "10" => "1",
    "20" => "2",
    "55" => "4",
    "11" => "3"
>>>>>>> 947e6538cef3f6b02f5c4dfa9363b5e4fc0a78b5
);

$_SESSION["cart"] = $newProducts;
