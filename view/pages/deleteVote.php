<?php
include dirname(__FILE__).'/../../controller/vote.php';
session_start();

if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
  echo "403 FORBIDDEN";
  }
else{
$vote = getVote($_POST['id']);
if($vote['owner'] != $_SESSION["mail"]) echo "403 FORBIDDEN";
else{
  deleteVote($_POST['id']);
echo "Vote supprimer";
}
}

?>

