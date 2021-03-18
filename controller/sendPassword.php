<?php

include "./account.php";

$m = $_POST["mail"]; 

function traitement($mail){
	ob_start();
	if(($account = accountExist($mail))==FALSE)$account = createAccount($mail);
	header('Content-type: application/json');
    $retour = json_encode(sendMail($account["mail"],"votre mot de passe : ".$account["password"]));
	console_log($retour);
	ob_end_clean();
	echo $retour;
}

traitement($m);

?>