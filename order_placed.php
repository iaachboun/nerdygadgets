<!DOCTYPE html>
<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

//bestelling is geplaatst

if(isset($_POST["order_placed"])) {
    $query2 = "INSERT INTO webshop_customers(customerID, firstname, insertion, lastname, streetname, housenumber, addition, city, phone, postal_code, email)
                            VALUES (customerID + 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    var_dump($query2);
    $Statement = mysqli_prepare($Connection, $query2);
    mysqli_stmt_bind_param($Statement, "ssssississ", $_SESSION["voornaam"], $_SESSION["tussenvoegsel"], $_SESSION["achternaam"], $_SESSION["straatnaam"], $_SESSION["huisnummer"], $_SESSION["toevoeging"], $_SESSION["woonplaats"], $_SESSION["telefoonnummer"], $_SESSION["postcode"], $_SESSION["email"]);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);




    $query3 = "SELECT StockItemName, TaxRate, RecommendedRetailPrice, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice
                     FROM StockItems
                     WHERE StockItemID = ?";

    $Statement = mysqli_prepare($Connection, $query3);
    mysqli_stmt_bind_param($Statement, "i", $productnummer);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);
}

?>