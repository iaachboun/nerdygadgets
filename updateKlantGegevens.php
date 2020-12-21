<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

//slaat de nieuwe klant gegevens
$query = "UPDATE `webshop_customers` SET `firstname` = ?, `insertion` =?, `lastname`=?, `streetname`=?, `housenumber`=?, `addition`=?, `city`=?, `phone`=?, `postal_code`=?  WHERE email = ?;";
$Statement = mysqli_prepare($Connection, $query);
mysqli_stmt_bind_param($Statement, "ssssississ", $_POST["voornaam"], $_POST["tussenvoegsel"], $_POST["achternaam"], $_POST["straatnaam"], $_POST["huisnummer"], $_POST["toevoeging"], $_POST["woonplaats"], $_POST["telefoonnummer"], $_POST["postcode"], $_SESSION['email']);
mysqli_stmt_execute($Statement);
$html = '<p class="inlogStatus">Je account is aangepast! <a href="klantgegevens.php"><button class="btn btn-primary">Ga Terug</button></a></p>';
echo $html;
