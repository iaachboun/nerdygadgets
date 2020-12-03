<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";
?>

    <html>
    <h1> Uw bestelhistorie</h1>
    </html>

<?php
$query1 = "
                        SELECT WO.orderID, SI.StockItemName, WOL.quantity, SI.RecommendedRetailPrice
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?
                        /*GROUP BY(WO.orderID)*/";



$Statement = mysqli_prepare($Connection, $query1);
mysqli_stmt_bind_param($Statement, "s", $_SESSION['email_login']);
mysqli_stmt_execute($Statement);
$R1 = mysqli_stmt_get_result($Statement);
$R1 = mysqli_fetch_all($R1, MYSQLI_ASSOC);

?>

<?php
/*$query2 =     "SELECT orderID
               FROM webshop_orders WO
               JOIN webshop_customers WC ON WO.customerID = WC.customerID
               WHERE WC.email = ?";

$Statement = mysqli_prepare($Connection, $query2);
mysqli_stmt_bind_param($Statement, "i", $_SESSION['email_login']);
mysqli_stmt_execute($Statement);
$R2 = mysqli_stmt_get_result($Statement);
$R2 = mysqli_fetch_all($R2, MYSQLI_ASSOC);
*/?>


<html>

<table style="text-align: center">
    <tr>
        <th>Productnaam</th>
        <th>Aantal</th>
        <th>Prijs</th>
    </tr>
    <tr>
        <td>
        <?php
    $naam = '';
    $aantal = '';
    $prijs = '';

foreach ($R1 AS $naam => $aantal) {
   foreach ($aantal as $naam1 => $prijs) {
     print $prijs;
       print '<br>';


            $query1 = "
                        SELECT SI.StockItemName, WOL.quantity, SI.RecommendedRetailPrice * WOL.quantity
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?";

            $Statement = mysqli_prepare($Connection, $query1);
            mysqli_stmt_bind_param($Statement, "s", $_SESSION['email_login']);
            mysqli_stmt_execute($Statement);
            $R1 = mysqli_stmt_get_result($Statement);
            $R1 = mysqli_fetch_all($R1, MYSQLI_ASSOC);
   }
}
            ?>


        </td>
    </tr>
</html>

<?php
// overbodig?? Ben er nog mee bezig
/*foreach ($R1 AS $naam => $aantal) {
   foreach ($aantal as $naam1 => $prijs) {
     print $prijs;
       print '<br>';


            $query1 = "
                        SELECT SI.StockItemName, WOL.quantity, SI.RecommendedRetailPrice * WOL.quantity
                        FROM stockitems SI
                        JOIN webshop_orderlines WOL ON SI.StockItemID = WOL.StockItemID
                        JOIN webshop_orders WO ON WOL.orderID = WO.orderID
                        JOIN webshop_customers WC ON WO.customerID = WC.customerID
                        WHERE WC.email = ?";

            $Statement = mysqli_prepare($Connection, $query1);
            mysqli_stmt_bind_param($Statement, "s", $_SESSION['email_login']);
            mysqli_stmt_execute($Statement);
            $R1 = mysqli_stmt_get_result($Statement);
            $R1 = mysqli_fetch_all($R1, MYSQLI_ASSOC);

        }
    }

*/?>
<?php
/*foreach ($R2 as $orderid => $order) {
    foreach($orderid as $orderid1 => $order1) {
        print $order1;
        print '<br>';



    $query2 = "SELECT orderID
               FROM webshop_orders WO
               JOIN webshop_customers WC ON WO.customerID = WC.customerID
               WHERE WC.email = ?";

        $Statement = mysqli_prepare($Connection, $query2);
        mysqli_stmt_bind_param($Statement, "i", $_SESSION['email_login']);
        mysqli_stmt_execute($Statement);
        $R2 = mysqli_stmt_get_result($Statement);
        $R2 = mysqli_fetch_all($R2, MYSQLI_ASSOC);

    }
}

*/?>