<?php
session_start();
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en" style="background-color: rgb(35, 35, 47);">
<head>
    <script src="Public/JS/fontawesome.js" crossorigin="anonymous"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/Resizer.js"></script>
    <script src="Public/JS/jquery-3.4.1.js"></script>
    <style>
        @font-face {
            font-family: MmrText;
            src: url(/Public/fonts/mmrtext.ttf);
        }
    </style>
    <meta charset="ISO-8859-1">
    <title>NerdyGadgets</title>
    <script src="https://kit.fontawesome.com/77789b20d3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Public/CSS/Style.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="Public/CSS/styleNew.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/nha3fuq.css">
    <link rel="apple-touch-icon" sizes="57x57" href="Public/img/LOGONG.png">
    <link rel="apple-touch-icon" sizes="60x60" href="Public/img/LOGONG.png">
    <link rel="apple-touch-icon" sizes="72x72" href="Public/img/LOGONG.png">
    <link rel="apple-touch-icon" sizes="76x76" href="Public/img/LOGONG.png">
    <link rel="apple-touch-icon" sizes="114x114" href="Public/img/LOGONG.png">
    <link rel="apple-touch-icon" sizes="120x120" href="Public/img/LOGONG.png">
    <link rel="apple-touch-icon" sizes="144x144" href="Public/img/LOGONG.png">
    <link rel="apple-touch-icon" sizes="152x152" href="Public/img/LOGONG.png">
    <link rel="apple-touch-icon" sizes="180x180" href="Public/img/LOGONG.png">
    <link rel="icon" type="image/png" sizes="192x192" href="Public/img/LOGONG.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Public/img/LOGONG.png">
    <link rel="icon" type="image/png" sizes="96x96" href="Public/img/LOGONG.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Public/img/LOGONG.png">
    <link rel="manifest" href="Public/Favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="Public/Favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<div class="Background">

    <nav class="navbar navbar-expand-lg navbar-dark  header-nav">
        <a class="navbar-brand" href="index.php"> <img src="Public/Img/LOGONG.png"></a>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" style="color:#ffffff">Alle
                        categorieeen</a>

                    <?php
                    $Query = "
                                    SELECT StockGroupID, StockGroupName, ImagePath
                                    FROM stockgroups
                                    WHERE StockGroupID IN (
                                                            SELECT StockGroupID
                                                            FROM stockitemstockgroups
                                                            ) AND ImagePath IS NOT NULL
                                    ORDER BY StockGroupID ASC";
                    $Statement = mysqli_prepare($Connection, $Query);
                    mysqli_stmt_execute($Statement);
                    $HeaderStockGroups = mysqli_stmt_get_result($Statement);

                    foreach ($HeaderStockGroups as $HeaderStockGroup) {
                        ?>

                        <div class="dropdown-menu">
                            <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID'] = "1"; ?>"
                               class="dropdown-item"><?php print $HeaderStockGroup['StockGroupName'] = "Novelty Items"; ?></a>
                            <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID'] = "2"; ?>"
                               class="dropdown-item"><?php print $HeaderStockGroup['StockGroupName'] = "Clothing"; ?></a>
                            <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID'] = "3"; ?>"
                               class="dropdown-item"><?php print $HeaderStockGroup['StockGroupName'] = "Mugs"; ?></a>
                            <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID'] = "4"; ?>"
                               class="dropdown-item"><?php print $HeaderStockGroup['StockGroupName'] = "T-shirts"; ?></a>
                            <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID'] = "9"; ?>"
                               class="dropdown-item"><?php print $HeaderStockGroup['StockGroupName'] = "Toys"; ?></a>
                            <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID'] = "6"; ?>"
                               class="dropdown-item"><?php print $HeaderStockGroup['StockGroupName'] = "Computing Novelties"; ?></a>
                            <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID'] = "7"; ?>"
                               class="dropdown-item"><?php print $HeaderStockGroup['StockGroupName'] = "USB Novelties"; ?></a>
                        </>
                        <?php
                    }
                    ?>

                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item active">
                        <?php
                        if (isset($_SESSION['login'])) {
                            if ($_SESSION['login'] == FALSE) {
                                echo "<a href='login.php' style='color: white;'><i class='fas fa-user' style='color:#676EFF;'></i> Inloggen</a>";
                            } else {
                                echo "<a href='login.php?logout=TRUE' style='color: white;'><i class='fas fa-sign-out-alt' style='color:#676EFF;'></i>Uitloggen</a>";
                            }
                        } else {
                            echo "<a href='login.php' style='color: #ffffff;'><i class='fas fa-user' style='color:#676eff;'></i> Login</a>";
                        } ?>
                    </li>
                    <?php
                    if (isset($_SESSION['login'])) {
                        if ($_SESSION['login'] == FALSE) {
                        } else {
                            echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" style="color:#ffffff" href="#"> <i class="fas fa-angle-down" style="color:#676EFF;"></i>Klantomgeving</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="order_history.php">Bestelhistorie</a>
                            <a class="dropdown-item" href="#">Klantgegevens</a>
                        </div>
                    </li>';
                        }
                    } ?>
                    <li>
                        <a href="browse.php" class="HrefDecoration"><i class="fas fa-search"
                                                                       style="color:#676EFF;"> </i>
                            Zoeken</a>
                    </li>
                    &nbsp;
                    <li>
                        <a href="cart.php" class="HrefDecoration"><i class="fas fa-shopping-cart"
                                                                     style="color:#676EFF;"></i>
                            Winkelmand</a>
                    </li>
                </ul>
            </form>
        </div>
    </nav>
    <div class="row" id="Content">
        <div class="col-12">
            <div id="SubContent">


