<?php
session_start();


//tijdelijke test array!!!
$winkelwagen = array(
    "1" => "2",
    "10" => "1",
    "20" => "2",
    "55" => "4",
    "11" => "3"
);

$_SESSION["cart"] = $winkelwagen;