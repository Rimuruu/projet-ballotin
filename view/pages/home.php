<?php
include  dirname(__FILE__).'/../../controller/account.php';
session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"])&& isLog($_SESSION["mail"],$_SESSION["mdp"]))) {
    echo "403 FORBIDDEN";
} else {
    echo '
      
      <div class="jumbotron p-2 bg-grey">
        <h1 class="display-4">Projet Web 2020-21</h1>
        <p class="lead">
            <a href="https://github.com/Rimuruu/projet-ballotin">https://github.com/Rimuruu/projet-ballotin</a>
        </p>
        <hr class="my-4">
        <p>Antoine Renciot.</p>
        <p class="lead p-1">
  
        </p>
      </div>
  ';
}
