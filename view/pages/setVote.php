<?php
include  dirname(__FILE__).'/../../controller/vote.php';
include  dirname(__FILE__).'/../../controller/account.php';
ob_start();
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"])&& isLog($_SESSION["mail"],$_SESSION["mdp"]))) {
    ob_end_clean();
    echo json_encode("403 FORBIDDEN");
} else {
      if (!(isset($_POST["reponse"]))) {
          ob_end_clean();
          echo json_encode("403 FORBIDDEN");
      } else {
          $vote = getVote($_POST['vote']);
          $isVotant = $result2 = array_search(
              $_SESSION["mail"],
              array_column($vote["votants"], 'votant')
          );
          if ($isVotant === false) {
              ob_end_clean();
              echo json_encode("403 FORBIDDEN");
          } else {
              if ($vote["status"] == "going") {
                  $result = setVote($_POST['vote'], $_SESSION["mail"], $_POST["reponse"]);
                  ob_end_clean();
                  echo(json_encode(["result"=>$result,"id"=>$_POST["vote"]]));
              }
              else{
                ob_end_clean();
                echo json_encode("403 FORBIDDEN");
              }
          }
      }
  }
