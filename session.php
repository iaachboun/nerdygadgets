<?php
session_start();


//tijdelijke test array!!!
$winkelwagen = array(
    "220" => "2",
    "16" => "1",
    "20" => "2",
    "55" => "4",
    "11" => "3"
);

$_SESSION["cart"] = $winkelwagen;