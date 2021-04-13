<?php
require dirname(__FILE__)."/../../controller/account.php";
session_start();
if (isset($_SESSION["mail"]) && isset($_SESSION["mdp"])&& isLog($_SESSION["mail"],$_SESSION["mdp"])) {
    echo "Déja connecté";
} else {
    echo  '<div class=" container p-4">


<div class="form-group p-2">
<div class="text-center p-2"> <label >Adresse mail</label></div>
  <div class="row"><div class="col-sm-2"></div><div class="col input-group m-0"><input type="email" class="form-control input-round" id="mail" name=mail aria-describedby="emailHelp" placeholder="exemple@exemple.com"></div>
  <div class="col-sm-2"></div>
  </div>
</div>
<div class="form-group p-2">
  <div class="text-center p-2"> <label >Mot de passe</label></div>
  <div class="row">
  <div class="col-sm-2"></div>
  <div class="col input-group m-0">
    <input type="password" class="form-control input-left-round col" id="mdp" name=mdp placeholder="Mot de passe">
    <button type="button" class="col-sm-3 btn-left-round btn btn-secondary" onclick="send()">Envoi mot de passe</button>
  </div>
  <div class="col-sm-2"></div>
</div>
<div class="container text-center">
<button onClick="login()" class="input-round btn btn-primary m-2 row">Se connecter</button>
<div class="erreur row text-danger"></div>
</div>

</div>';
}
