
<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";




//print '
////<html>
////<meta name="viewport" content="width=device-width, initial-scale=1">
////<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3pro.css">
////<body>';

// Opzet winkelwagen word als volgt:
// Ilias maakt een array in de session met de volgende opzet:
// $winkelwagen = array(42 => 1, 33 => 2)
// De key is het productnummer en de value is het aantal.


//Variabelen:
$totaalPrijs = 0;
$teller = 0;

$subtotaal = 0;
$btwWaarde = 0;


//Updaten aantal winkelmandje

if (isset($_POST["productupdaten"])) {
    $product = $_POST["product"];
    $_SESSION["cart"][$product] = $_POST["aantal"];
}

//Verwijderen product

if (isset($_POST["productverwijderen"])) {
    $product = $_POST["product"];
    unset($_SESSION["cart"][$product]);
}
?>

<?php
//Nieuwe variabelen
$plaatje = '';
$productnaam = '';
?>


<!--    <div style="overflow-x:auto;" class="cart w3-mobile">-->

<div class="row">
    <div class="container cart-section-desktop">
<?php
if (isset($_SESSION["cart"])) {
    print '<table style="text-align: left" class="w3-table w3-blue "><tr class="w3-red">
           <th>Afbeelding</th>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           <th>Verwijderen</th>
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
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);


    //Hier beginnen de plaatjes query's
    //Nodige variabelen:
    $map = '';

    $query2 = "
                        SELECT ImagePath
                        FROM stockitemimages 
                        WHERE StockItemID = ?;";

    $Statement = mysqli_prepare($Connection, $query2);
    mysqli_stmt_bind_param($Statement, "i", $productnummer);
    mysqli_stmt_execute($Statement);
    $R2 = mysqli_stmt_get_result($Statement);
    $R2 = mysqli_fetch_all($R2, MYSQLI_ASSOC);



    if ($R2) {
        $Images = $R2;
        $map = 'StockItemIMG';

    }
    else{
        $query = "        SELECT SG.ImagePath, SG.StockGroupName
                        FROM stockgroups SG
                        JOIN stockitemstockgroups SISG ON SG.StockGroupID = SISG.StockGroupID
                        WHERE SISG.StockItemID = ?;";

        $Statement = mysqli_prepare($Connection, $query);
        mysqli_stmt_bind_param($Statement, "i", $productnummer);
        mysqli_stmt_execute($Statement);
        $R3 = mysqli_stmt_get_result($Statement);
        $R3 = mysqli_fetch_all($R3, MYSQLI_ASSOC);
        $Images = $R3;
        $map = 'StockGroupIMG';


    }

  /*  if(!isset($Images)){

    }*/

    print'<tr><td width = 20%>';
    ?>
    <div id="ProductFrame"
    <div class="ListItem"

         style="background-image: url('Public/<?php print $map ?>/<?php print $Images[0]['ImagePath']; ?>'); background-size: 100%; background-repeat: no-repeat; background-position: left;"></div>
</div>
    <?php
    print'</td>';
    print'<td width = 20%>';
    print ($R[0]["StockItemName"]);
    $productnaam = $R[0]["StockItemName"];
    print '</td>';
    print '<td width = 20%>';
    echo "<form method='post' >
                      <input type= 'number' id='quantity' name='aantal' value='" . $aantal . "' min='1'>
                      <input type= 'number' id='quantity' name='product' value='" . $productnummer . "' hidden>
                    <button type='submit' value='aanpassen' name='productupdaten'> <i class='fa fa-refresh'aria-hidden='true'></i> Aanpassen </button>
                      </form>";

    print '</td>';
    print '<td width = 20%>';
    print '€';
    print round(($R[0]["SellPrice"]), 2) * $aantal;
    print '</td>';

    print "<td style='text-align: left' width = 20%>
            <form method='post' action='cart.php' >
            <button onclick='return confirm(`Weet je het zeker dat je dit product wilt verwijderen?`)' type='submit' name='productverwijderen' 
                class='btn btn-danger actionBtn'><i class='far fa-trash-alt'></i></button>
                <input type= 'number' id='quantity' name='product' value='" . $productnummer . "' hidden>
                      </form></td></tr>";
    print '</tr>';

    $totaalPrijs = $totaalPrijs + (($R[0]["SellPrice"]) * $aantal);
    $subtotaal = $subtotaal + ($R[0]["RecommendedRetailPrice"] * $aantal);
    $btwWaarde = ($R[0]["TaxRate"]) / 100 * $subtotaal;
}
    $subtotalen = '';

    $subtotalen .= "<tr><td></td><td></td><td></td><td></td><td><p class='subtotalen'>Subtotaal: €" . round(($subtotaal), 2) . "</p><br>";
    $subtotalen .= "<p class='subtotalen'>BTW: €" . round(($btwWaarde), 2) . "</p>";
    $subtotalen .= "<p class='subtotalen'>Totaalprijs: €" . round(($totaalPrijs), 2) . "</p></td></tr>";

    print $subtotalen;
    print'<td>';
    print 'De verzendkosten zijn al in de prijs opgenomen!';
    print '</td>';

    echo "<tr><td></td><td></td><td></td><td></td><td><a href='bestelpagina.php'><input type=button name='bestellen' value='Bestellen' class='btn btn-warning btn-lg'></a></tr>";
?>
</div>
<?php
} else {
    print 'Er zit niks in de winkelmand!';
    print("<br>");
    print'<a href="categories.php">Klik hier om terug te gaan naar de webshop</a>';
}
?>




<!--Mobiele weergave, work in progress door Pascal
        -->
<!--        <?php
/*        foreach ($_SESSION["cart"] as $productnummer => $aantal) {
            print '<div class="w3-row">';
            print '<div class="w3-col s1">';
            print  '<img class="w3-circle" src="Public/StockItemIMG/';
            print ($plaatje);
            print '" style="width:100%">';
            print  '</div>';
            print '<div class="w3-col s9 w3-container">';
            print '<h3 class="w3-text-red">';
            print $productnaam;

            print '</h3>';
            print '<p>';

            print "<form method='post'>
                      <input type= 'number' id='quantity' name='aantal' value='" . $aantal . "' min='1'>
                      <input type= 'number' id='quantity' name='product' value='" . $productnummer . "' hidden>
                    <button type='submit' value='aanpassen' name='productupdaten'> <i class='fa fa-refresh'aria-hidden='true'></i> Aanpassen </button>
                      </form>";

            print '</p>';
            print '</div>';
            print '</div>';
        }
        */?>
        </div>
-->

<!--FOOTER-->
<!--<br><br><br><br><br><br>-->
<?php
//include __DIR__ . "/footer.php";
//?>





