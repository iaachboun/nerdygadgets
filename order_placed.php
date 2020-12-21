<!DOCTYPE html>
<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

//bestelling is geplaatst
$queryFailed = false;

//checkt of klant ingelogd is om bestel forumulier automatisch in te vullen
if (isset($_GET["order_placed"])) {
    if (isset($_SESSION["customerID"])) {
        $customerID = $_SESSION["customerID"];
    } else {
        $emailCheckQuery = "SELECT email FROM webshop_customers WHERE email = ?";

        $Statement = mysqli_prepare($Connection, $emailCheckQuery);
        mysqli_stmt_bind_param($Statement, "s", $_SESSION["email"]);
        mysqli_stmt_execute($Statement);
        $em = mysqli_stmt_get_result($Statement);
        $em = mysqli_fetch_all($em, MYSQLI_ASSOC);

        mysqli_begin_transaction ($Connection);


        if (isset($em[0]['email'])) {
            echo 'email wordt al gebruikt!';
        } else {
            $query = "INSERT INTO webshop_customers(firstname, insertion, lastname, streetname, housenumber, addition, city, phone, postal_code, email)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $Statement = mysqli_prepare($Connection, $query);
            mysqli_stmt_bind_param($Statement, "ssssississ", $_SESSION["voornaam"], $_SESSION["tussenvoegsel"], $_SESSION["achternaam"], $_SESSION["straatnaam"], $_SESSION["huisnummer"], $_SESSION["toevoeging"], $_SESSION["woonplaats"], $_SESSION["telefoonnummer"], $_SESSION["postcode"], $_SESSION["email"]);
            $queryResult = mysqli_stmt_execute($Statement);
            $customerID = mysqli_insert_id($Connection);

        }
    }

    $query2 = "INSERT INTO webshop_orders(customerID)
                            VALUES (?);";

    $Statement = mysqli_prepare($Connection, $query2);
    mysqli_stmt_bind_param($Statement, "i", $customerID);
    $queryResult =  (mysqli_stmt_execute($Statement));
    if($queryResult == false){
        $queryFailed = true;
    }

    $orderID = mysqli_insert_id($Connection);


    foreach ($_SESSION["cart"] as $productnummer => $aantal) {
        $query3 = "INSERT INTO webshop_orderlines(orderID, StockItemID, quantity)
                                VALUES (?, ?, ?);";

        $Statement = mysqli_prepare($Connection, $query3);
        mysqli_stmt_bind_param($Statement, "iii", $orderID, $productnummer, $aantal);
        $queryResult = mysqli_stmt_execute($Statement);
        $query4 = "UPDATE stockitemholdings SET quantityonhand = quantityonhand - ? WHERE stockitemID = (?);";
        
    if($queryResult == false){
            $queryFailed = true;
        }
    }
        $Statement = mysqli_prepare($Connection, $query4);
        mysqli_stmt_bind_param($Statement, "ii", $aantal, $productnummer);
        $queryResult = mysqli_stmt_execute($Statement);
        if($queryResult == false){
            $queryFailed = true;
        }
    }

    if($queryFailed){
        mysqli_rollback($Connection);
        print("Mislukt, probeer opnieuw.");
    }else{
        mysqli_commit($Connection);
        print "Bedankt voor uw bestelling! Uw bestelnummer is: $orderID";
        unset($_SESSION["cart"]);
    }

    print '<h1><a href="index.php">Klik hier om terug te gaan naar home!</a></h1>';


