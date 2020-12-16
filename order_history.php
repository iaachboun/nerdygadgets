<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";
?>

    <html>
    <h1> Uw bestelhistorie</h1>
    </html>

<?php
//query voor ordernummer
 $query1 = "
                        SELECT DISTINCT WO.orderID
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?";

                    $Statement = mysqli_prepare($Connection, $query1);
                    mysqli_stmt_bind_param($Statement, "i", $_SESSION['email_login']);
                    mysqli_stmt_execute($Statement);
                    $R1 = mysqli_stmt_get_result($Statement);
                    $R1 = mysqli_fetch_all($R1, MYSQLI_ASSOC);

//query voor productnaam
$query2 = "
                        SELECT SI.StockItemName
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?";

$Statement = mysqli_prepare($Connection, $query2);
mysqli_stmt_bind_param($Statement, "s", $_SESSION['email_login']);
mysqli_stmt_execute($Statement);
$R2 = mysqli_stmt_get_result($Statement);
$R2 = mysqli_fetch_all($R2, MYSQLI_ASSOC);

//query voor aantal
$query3 = "
                        SELECT WOL.quantity
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?";

$Statement = mysqli_prepare($Connection, $query3);
mysqli_stmt_bind_param($Statement, "i", $_SESSION['email_login']);
mysqli_stmt_execute($Statement);
$R3 = mysqli_stmt_get_result($Statement);
$R3 = mysqli_fetch_all($R3, MYSQLI_ASSOC);

//query voor prijs
$query4 = "
                        SELECT (RecommendedRetailPrice*(1+(TaxRate/100))) * WOL.quantity
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?";

$Statement = mysqli_prepare($Connection, $query4);
mysqli_stmt_bind_param($Statement, "i", $_SESSION['email_login']);
mysqli_stmt_execute($Statement);
$R4 = mysqli_stmt_get_result($Statement);
$R4 = mysqli_fetch_all($R4, MYSQLI_ASSOC);

?>


<?php

?>

<html>
<head>
<style>
    table, th, td {
        border: 1px solid white;
    }
</style>
</head>
<body>
<table style="text-align: center">
    <tr>
        <th>Ordernummer</th>
        <th>Productnaam</th>
        <th>Aantal</th>
        <th>Prijs</th>
    </tr>
    <tr>
        <td>
        <?php
            foreach ($R1 AS $naam => $aantal) {
                foreach ($aantal as $naam1 => $prijs) {
                    print $prijs;
                        print '<br>';


                    $query1 = "
                                SELECT DISTINCT WO.orderID
                                FROM stockitems SI
                                JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                                JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                                JOIN webshop_customers WC ON WO.customerID = WC.customerID
                                WHERE WC.email = ?";

                    $Statement = mysqli_prepare($Connection, $query1);
                    mysqli_stmt_bind_param($Statement, "i", $_SESSION['email_login']);
                    mysqli_stmt_execute($Statement);
                    $R1 = mysqli_stmt_get_result($Statement);
                    $R1 = mysqli_fetch_all($R1, MYSQLI_ASSOC);
   }
}
            ?>
        </td>
        <td>
            <?php
            foreach ($R2 AS $naam => $aantal) {
                foreach ($aantal as $naam1 => $prijs) {
                    print $prijs;
                    print '<br>';


                    $query1 = "
                        SELECT SI.StockItemName
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?";

                    $Statement = mysqli_prepare($Connection, $query2);
                    mysqli_stmt_bind_param($Statement, "s", $_SESSION['email_log3in']);
                    mysqli_stmt_execute($Statement);
                    $R2 = mysqli_stmt_get_result($Statement);
                    $R2 = mysqli_fetch_all($R2, MYSQLI_ASSOC);
                }
            }
            ?>
        </td>
        <td>
            <?php
            foreach ($R3 AS $naam => $aantal) {
                foreach ($aantal as $naam1 => $prijs) {
                    print $prijs;
                    print '<br>';


                    $query3 = "
                        SELECT WOL.quantity
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?";

                    $Statement = mysqli_prepare($Connection, $query3);
                    mysqli_stmt_bind_param($Statement, "i", $_SESSION['email_login']);
                    mysqli_stmt_execute($Statement);
                    $R3 = mysqli_stmt_get_result($Statement);
                    $R3 = mysqli_fetch_all($R3, MYSQLI_ASSOC);
                }
            }
            ?>
        </td>
        <td>
            <?php
            foreach ($R4 AS $naam => $aantal) {
                foreach ($aantal as $naam1 => $prijs) {
                    print '€';
                    print round(($prijs),2);
                    print '<br>';


                    $query4 = "
                        SELECT (RecommendedRetailPrice*(1+(TaxRate/100))) * WOL.quantity
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?";

                    $Statement = mysqli_prepare($Connection, $query4);
                    mysqli_stmt_bind_param($Statement, "i", $_SESSION['email_login']);
                    mysqli_stmt_execute($Statement);
                    $R4 = mysqli_stmt_get_result($Statement);
                    $R4 = mysqli_fetch_all($R4, MYSQLI_ASSOC);
                }
            }
            ?>
        </td>
    </tr>
</html>
