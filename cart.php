<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";


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
<div class="container">
    <div class="row">
        <div class="col-12 cart">

            <?php
            if (isset($_SESSION["cart"])) {
            print '<table style="text-align: left"><tr>
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

            $query2 = "
                        SELECT ImagePath
                        FROM stockitemimages 
                        WHERE StockItemID = ?";

            $Statement = mysqli_prepare($Connection, $query2);
            mysqli_stmt_bind_param($Statement, "i", $productnummer);
            mysqli_stmt_execute($Statement);
            $R2 = mysqli_stmt_get_result($Statement);
            $R2 = mysqli_fetch_all($R2, MYSQLI_ASSOC);

            if ($R2) {
                $Images = $R2;
            }

            print'<td>';
            ?>
            <div id="ProductFrame"
            <div class="ListItem"
                 style="background-image: url('Public/StockItemIMG/<?php print $Images[0]['ImagePath']; ?>'); background-size: 230px; background-repeat: no-repeat; background-position: center;"></div>
        </div>
        <?php
        print'</td>';
        print'<td>';
        print ($R[0]["StockItemName"]);
        print '</td>';
        print '<td>';
        echo "<form method='post' >
                      <input type= 'number' id='quantity' name='aantal' value='" . $aantal . "' min='1'>
                      <input type= 'number' id='quantity' name='product' value='" . $productnummer ."' hidden>
                    <button type='submit' class='btn-info' value='aanpassen' name='productupdaten'></button>
                      </form>";

        print '</td>';
        print '<td>';
        print '€';
        print round(($R[0]["SellPrice"]), 2) * $aantal;
        print '</td>';
        print'<td>';
        print "<td style='text-align: left'>
            <form method='post' action='cart.php'>
            <button onclick='return confirm(`Weet je het zeker dat je dit product wilt verwijderen?`)' type='submit' name='productverwijderen' 
                class='btn btn-danger actionBtn'><i class='far fa-trash-alt'></i></button>
                <input type= 'number' id='quantity' name='product' value='" . $productnummer ."' hidden>
                      </form></td></tr>";
        print '</td>';

        $totaalPrijs = $totaalPrijs + (($R[0]["SellPrice"]) * $aantal);
        $subtotaal = $subtotaal + ($R[0]["RecommendedRetailPrice"] * $aantal);
        $btwWaarde = ($R[0]["TaxRate"]) / 100 * $subtotaal;
        }
        $subtotalen = '';

        $subtotalen .= "<tr><td></td><td></td><td></td><td><p class='subtotalen'>Subtotaal: €" . round(($subtotaal), 2) . "</p><br>";
        $subtotalen .= "<p class='subtotalen'>BTW: €" . round(($btwWaarde), 2) . "</p>";
        $subtotalen .= "<p class='subtotalen'>Totaalprijs: €" . round(($totaalPrijs), 2) . "</p></td></tr>";

        print $subtotalen;
        print'<td>';
        print 'De verzendkosten zijn al in de prijs opgenomen!';
        print '</td>';

        echo "<tr><td></td><td></td><td></td><td><a href='bestelpagina.php'><input type=button name='bestellen' value='Bestellen' class='btn btn-primary'></a></tr>";


        } else {
            print 'Er zit niks in de winkelmand!';
        }
        ?>
        </di
    </div>
</div>

