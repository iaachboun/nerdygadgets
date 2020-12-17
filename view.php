<?php
$Connection = mysqli_connect("localhost", "ilias", "12345", "nerdygadgets");
mysqli_set_charset($Connection, 'latin1');
include __DIR__ . "/header.php";
include "session.php";

$Query = " 
           SELECT SI.StockItemID, 
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";
if (isset($_GET["id"])) {
    $stockItemID = $_GET["id"];
} else {
    $stockItemID = 0;
}

$ShowStockLevel = 1000;
$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $stockItemID);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
    $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
} else {
    $Result = null;
}
//Get Images
$Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
mysqli_stmt_execute($Statement);
$R = mysqli_stmt_get_result($Statement);
$R = mysqli_fetch_all($R, MYSQLI_ASSOC);

if ($R) {
    $Images = $R;
}
?>
<div id="CenteredContent">
    <?php
    if ($Result != null) {
        ?>
        <?php
        if (isset($Result['Video'])) {
            ?>
            <div id="VideoFrame">
                <?php print $Result['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($Images)) {
                // print Single
                if (count($Images) == 1) {
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockItemIMG/<?php print $Images[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php
                } else if (count($Images) >= 2) { ?>
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                    <?php
                                } ?>
                            </ul>

                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <img src="Public/StockItemIMG/<?php print $Images[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockGroupIMG/<?php print $Result['BackupImagePath']; ?>'); background-size: cover;"></div>
                <?php
            }
            ?>


            <h1 class="StockItemID">Artikelnummer: <?php print $Result["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $Result['StockItemName']; ?>
            </h2>

            <div class="QuantityText"><?php print $Result['QuantityOnHand']; ?></div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $Result['SellPrice']); ?></b></p>
                        <h6> Inclusief BTW </h6>
                    </div>
                </div>
                <?php
                if (isset($_GET["id"])) {
                    $stockItemID = $_GET["id"];
                } else {
                    $stockItemID = 0;
                }
                ?>
                <form method="post">
                    <input type="submit" name="submit" class="btn btn-primary bestelKnop"
                           value="Voeg toe aan winkelmandje">
                </form>
                <?php
                if (isset($_SESSION["voornaam"])) {
                    echo '<a href="newReview.php?stockitemID=' . $Result['StockItemID'] . '"><button class="btn btn-secondary">Plaats een review</button></a>';
                } else {
                    echo "<a href='login.php'><button class='btn btn-secondary'>Login in om een review te plaatsen</button></a>";
                }
                ?>

                <?php
                if (isset($_POST["submit"])) {
                    $stockItemID = $Result['StockItemID'];
                    AddProductToCart($stockItemID);
                    echo '<div class="alert alert-secondary" role="alert">Product is toegevoegd aan het <a href="cart.php"">winkelmandje</a></div>';
                }
                ?>
            </div>
        </div>
        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $Result['SearchDetails']; ?></p>
        </div>
        <div id="StockItemSpecifications">
            <h3>Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($Result['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                <thead>
                <th>Naam</th>
                <th>Data</th>
                </thead>
                <?php
                foreach ($CustomFields as $SpecName => $SpecText) { ?>
                    <tr>
                        <td>
                            <?php print $SpecName; ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($SpecText)) {
                                foreach ($SpecText as $SubText) {
                                    print $SubText . " ";
                                }
                            } else {
                                print $SpecText;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </table><?php
            } else { ?>

                <p><?php print $Result['CustomFields']; ?>.</p>
                <?php
            }
            ?>
        </div>

        <?php
        $Query = "SELECT SI.IsChillerStock, CRT.Temperature
                FROM stockitems SI
                JOIN stockitemholdings SIH ON SI.StockItemID = SIH.StockItemID
                JOIN roomtemp_stockitemholdings RT_SIH ON SIH.BinLocation = RT_SIH.BinLocation
                JOIN coldroomtemperatures CRT ON RT_SIH.ColdRoomSensorNumber = CRT.ColdRoomSensorNumber
                WHERE SI.StockItemID = ?";

        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
        mysqli_stmt_execute($Statement);
        $R_IsChilled = mysqli_stmt_get_result($Statement);
        $R_IsChilled = mysqli_fetch_all($R_IsChilled, MYSQLI_ASSOC);

        if ($R_IsChilled[0]["IsChillerStock"] == 1) {
            $Temperature = $R_IsChilled[0]["Temperature"];

            print <<<TEMP
                <div id="Temperature">
                    <img id="temp" src="Public/Img/temp.png" alt="" width="128" height="128">
                    <h3>Dit product is momenteel </h3>
                    <h2 style="color:lightskyblue;">$Temperature °C</h2>
                </div>
TEMP;
        }
        ?>

        <?php
    } else {
        ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
    } ?>
</div>
<?php
//Get Reviews
$Query = "SELECT *
FROM webshop_review a
WHERE StockItemID = ?";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
mysqli_stmt_execute($Statement);
$R = mysqli_stmt_get_result($Statement);
$R = mysqli_fetch_all($R, MYSQLI_ASSOC);


if (isset($R[0])) {
    $html = '';
    $html .= '<div class="review-section">
                <div class="container">
                    <div class="row">
                    <div class="col-12 reviews">
                            <h2>Reviews</h2>';
    foreach ($R as $result) {
        //Get account data
        $Query = "SELECT *
                    FROM webshop_customers
                    WHERE customerID = ?";

        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_bind_param($Statement, "i", $result['customerID']);
        mysqli_stmt_execute($Statement);
        $customerData = mysqli_stmt_get_result($Statement);
        $customerData = mysqli_fetch_all($customerData, MYSQLI_ASSOC);


        if ($result['Aanbeveling'] == TRUE) {
            $html .= '<div class="customer-review" style="border: 2px solid rgba(9,255,0,0.62)">';
            $html .= "<p class='review-naam'> " . $customerData[0]['firstname'] . ' ' . $customerData[0]['lastname'];
            $html .= ' <i class="fas fa-thumbs-up thumbIcon" style="color: rgba(9,255,0,0.62)"></i></p>';
        } else {
            $html .= '<div class="customer-review" style="border: 2px solid red">';
            $html .= "<p class='review-naam'> " . $customerData[0]['firstname'] . ' ' . $customerData[0]['lastname'];
            $html .= ' <i class="fas fa-thumbs-down thumbIcon" style="color: red"></i></p>';
        }

        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $result['Stars']) {
                $html .= '<i class="fas fa-star starIcon" style="color: Yellow;"></i>';
            } else {
                $html .= '<i class="fas fa-star starIcon"></i>';
            }
        }
        $html .= "<p class='review-tekst'>" . $result['Reviewtext'] . "</p>";
        $html .= "<p class='review-datum'>" . $result['Datum'] . "</p>";
        $html .= "</div>";
    }

    $html .= "</div></div></div></div>";
    echo $html;

} ?>
<br><br>

