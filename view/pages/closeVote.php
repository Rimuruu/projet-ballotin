<?php
include  dirname(__FILE__).'/../../controller/account.php';
include dirname(__FILE__).'/../../controller/vote.php';
ob_start();
session_start();

if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"])&& isLog($_SESSION["mail"],$_SESSION["mdp"]))) {
    echo "403 FORBIDDEN";
} else {
    $vote = getVote($_POST['id']);
    if ($vote['owner'] != $_SESSION["mail"]) {
        echo "403 FORBIDDEN";
    } else {
        closeVote($_POST['id']);
        ob_end_clean();
        echo json_encode($_POST['id']);
    }
}
