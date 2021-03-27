<?php

include "./account.php";
include "./vote.php";


function traitement($mail){
	ob_start();
	if(($account = accountExist($mail))==FALSE)$account = createAccount($mail);
	header('Content-type: application/json');
    $retour = json_encode(sendMail($account["mail"],"votre mot de passe : ".$account["password"]));
	console_log($retour);
	ob_end_clean();
	echo $retour;
}

function traitement2($vote){
	$info = $vote;
	$reponses = array_map(function($v){return ["reponse"=>$v["reponse"],"votant"=>array()];} ,$info["reponses"]);
	$voteResult = createVote($info["owner"],$info["question"],$reponses,$info["votants"]);
	echo json_encode($voteResult);
}

if(isset($_POST["mail"]))traitement($_POST["mail"]);
if(isset($_POST["vote"]))traitement2($_POST["vote"]);

?>