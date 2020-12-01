<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";
?>

    <html>
    <h1> Uw bestelhistorie</h1>
    </html>
<?php
$query1 = "
                        SELECT SI.StockItemName, WOL.quantity, SI.RecommendedRetailPrice
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

?>

    <?php
if (isset($_SESSION["login"])) {
    print '<table style="text-align: center"><tr>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           </tr>';

    foreach ($R1 AS $test => $beschrijving) {
        foreach ($beschrijving as $test => $beschrijving1) {
            print $beschrijving1;
            print '<br>';
        }
    }

    $query1 = "
                        SELECT SI.StockItemName, WOL.quantity, SI.RecommendedRetailPrice * WOL.quantity
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



/*    foreach ($R1 AS $test => $beschrijving) {
        foreach ($beschrijving as $test => $beschrijving1) {
            print $beschrijving1;
            print '<br>';
        }
    }*/


} ?>



<?php
/*if (isset($_SESSION["cart"])) {
    print '<table style="text-align: center"><tr>
           <th>Product</th>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           </tr>';

    foreach ($_SESSION["cart"] as $productnummer => $aantal) {
        $teller++;

        $query = "SELECT StockItemName, TaxRate, RecommendedRetailPrice, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice
                     FROM StockItems
                     WHERE StockItemID = ?";

        $Statement = mysqli_prepare($Connection, $query);
        mysqli_stmt_bind_param($Statement, "i", $productnummer);
        mysqli_stmt_execute($Statement);
        $R = mysqli_stmt_get_result($Statement);
        $R = mysqli_fetch_all($R, MYSQLI_ASSOC);*/
