<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";

if (isset($_POST['submit'])) {
    //check bestaat email al
    $query0 = "SELECT password FROM webshop_customers WHERE email = ?";

    $Statement0 = mysqli_prepare($Connection, $query0);
    mysqli_stmt_bind_param($Statement0, "s", $_SESSION['email']);
    mysqli_stmt_execute($Statement0);
    $R0 = mysqli_stmt_get_result($Statement0);
    $R0 = mysqli_fetch_all($R0, MYSQLI_ASSOC);

    //check de 2 nieuwe wachtwoorden of ze  hetzelfde zijn
    if(password_verify($_POST['oldPassword'], $R0[0]['password'])) {
        if ($_POST['newPassword'] == $_POST['newPasswordConfirm']) {
            $hash = '';
            $password = $_POST["newPassword"];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            //slaat nieuwe wachtwoord gehashed op in de database
            $sql = "UPDATE webshop_customers SET password = ? WHERE email = ?";

            $Statement = mysqli_prepare($Connection, $sql);
            mysqli_stmt_bind_param($Statement, "ss", $hash, $_SESSION['email']);
            mysqli_stmt_execute($Statement);

            $html = '<p class="inlogStatus">Je wachtwoord is aangepast! <a href="inlogGegevens.php"><button class="btn btn-primary">Ga Terug</button></a></p>';
            echo $html;

        } else {
            $html = '<p class="inlogStatus">De nieuwe wachtwoorden komen niet met elkaar overeen! <a href="inlogGegevens.php"><button class="btn btn-primary">Ga Terug</button></a></p>';
            echo $html;
        }
    } else {
        $html = '<p class="inlogStatus">Het oude wachtwoord komt niet overeen! <a href="inlogGegevens.php"><button class="btn btn-primary">Ga Terug</button></a></p>';
        echo $html;

    }


}