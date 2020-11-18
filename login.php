<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

if (isset($_POST['submit'])){
    $email = $_POST['email'];

    $query = "SELECT * FROM webshop_customers WHERE email = ? AND password = ?";

    $Statement = mysqli_prepare($Connection, $query);
    mysqli_stmt_bind_param($Statement, "ss", $_POST['email'], $_POST['password']);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    //Session variabelen uit de post van bestelpagina
    $_SESSION["voornaam"] = $R[0]["firstname"];
    if (isset($R[0]["insertion"])) {
        $_SESSION["tussenvoegsel"] = $R[0]["insertion"];
    }
    $_SESSION["achternaam"] = $R[0]["lastname"];
    $_SESSION["telefoonnummer"] = $R[0]["phone"];
    $_SESSION["postcode"] = $R[0]["postal_code"];
    $_SESSION["huisnummer"] = $R[0]["housenumber"];
    if (isset($R[0]["addition"])) {
        $_SESSION["toevoeging"] = $R[0]["addition"];
    }
    $_SESSION["woonplaats"] = $R[0]["city"];
    $_SESSION["straatnaam"] = $R[0]["streetname"];
    $_SESSION["email"] = $R[0]["email"];

    $_SESSION["login"] = TRUE;
} else {
    echo showLoginForm();
}

function showLoginForm()
{
    $html = '';
    $html .= '<div class="container">
                <div class="row">
                    <div class="col-3" style="margin: 0 auto; top: 150px">
                        <form method="post" action="login.php">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>';
    return $html;
}


include __DIR__ . "/footer.php"; ?>
