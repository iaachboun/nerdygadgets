<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";
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
<h1> Uw bestelhistorie</h1>


<?php

$queryOrders = "                     SELECT DISTINCT WO.orderID
                                FROM stockitems SI
                                JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                                JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                                JOIN webshop_customers WC ON WO.customerID = WC.customerID
                                WHERE WC.email = ?";

$Statement = mysqli_prepare($Connection, $queryOrders);
mysqli_stmt_bind_param($Statement, "i", $_SESSION['email_login']);
mysqli_stmt_execute($Statement);
$orders = mysqli_stmt_get_result($Statement);
$orders = mysqli_fetch_all($orders, MYSQLI_ASSOC);


foreach($orders as $order){
    $orderID = $order['orderID'];
    $queryOrder = "
                        SELECT SI.StockItemName,WOL.quantity, (RecommendedRetailPrice*(1+(TaxRate/100))) * WOL.quantity as price
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WOL.orderID = ?";

    $Statement = mysqli_prepare($Connection, $queryOrder);
    mysqli_stmt_bind_param($Statement, "i", $orderID);
    mysqli_stmt_execute($Statement);
    $order = mysqli_stmt_get_result($Statement);
    $order = mysqli_fetch_all($order, MYSQLI_ASSOC);

    print("Order $orderID <br>");
    print("<table style='text-align: center'>");
    print("<tr> <th>Productnaam</th> <th>Aantal</th>  <th>Prijs</th>  </tr>");

    foreach($order as $orderline){

        $siName =  $orderline['StockItemName'];
        $quantity =  $orderline['quantity'];
        $price =  round($orderline['price'],2);
        print("<tr>");
        print("<td> $siName </td>");
        print("<td> $quantity </td>");
        print("<td> € $price </td>");

        print("</tr>");

    }
    print("</table> <br>");

    ;}


?>

</body>
</html>