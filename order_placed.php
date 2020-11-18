<!DOCTYPE html>
<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

//bestelling is geplaatst

if(isset($_GET["order_placed"])) {

    $query = "INSERT INTO webshop_customers(firstname, insertion, lastname, streetname, housenumber, addition, city, phone, postal_code, email)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $Statement = mysqli_prepare($Connection, $query);
    mysqli_stmt_bind_param($Statement, "ssssississ", $_SESSION["voornaam"], $_SESSION["tussenvoegsel"], $_SESSION["achternaam"], $_SESSION["straatnaam"], $_SESSION["huisnummer"], $_SESSION["toevoeging"], $_SESSION["woonplaats"], $_SESSION["telefoonnummer"], $_SESSION["postcode"], $_SESSION["email"]);
    mysqli_stmt_execute($Statement);
    $customerID = mysqli_insert_id($Connection);


    $query2 = "INSERT INTO webshop_orders(customerID)
                            VALUES (?);";

    $Statement = mysqli_prepare($Connection, $query2);
    mysqli_stmt_bind_param($Statement, "i", $customerID);
    mysqli_stmt_execute($Statement);
    $orderID = mysqli_insert_id($Connection);


    foreach ($_SESSION["cart"] as $productnummer => $aantal) {
        $query3 = "INSERT INTO webshop_orderlines(orderID, StockItemID, quantity)
                                VALUES (?, ?, ?);";

        $Statement = mysqli_prepare($Connection, $query3);
        mysqli_stmt_bind_param($Statement, "iii", $orderID, $productnummer, $aantal);
        mysqli_stmt_execute($Statement);
    }

    print "Bedankt voor uw bestelling! Uw bestelnummer is: $orderID";
}
else {
    print 'Mislukt, probeer opnieuw.';
}
?>