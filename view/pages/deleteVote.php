<?php
include '../../controller/vote.php';
session_start();

if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
    header("Location: ../../index.php");
  }
$vote = getVote($_POST['id']);
if($vote['owner'] != $_SESSION["mail"]) header("Location: ../../index.php");
deleteVote($_POST['id']);
header("Location: ./home.php")
?>

