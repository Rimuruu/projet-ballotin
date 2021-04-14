
<?php

include dirname(__FILE__).'/../../controller/account.php';
$result = "";
session_start();
ob_start();
if (isset($_POST["mail"]) && isset($_POST["mdp"])) {
    $result = isLog($_POST["mail"], $_POST["mdp"]);
    if ($result == true) {
        $_SESSION["mail"] = $_POST["mail"];
        $_SESSION["mdp"] = $_POST["mdp"];
        ob_end_clean();
        echo json_encode("connecté");
    } else {
        ob_end_clean();
        echo json_encode("Mauvais login/password");
    }
}
?>