<?php
require dirname(__FILE__)."/../../controller/account.php";
session_start();
if (isset($_SESSION["mail"]) && isset($_SESSION["mdp"])) {
  echo "Déja connecté";
}
else{

echo  '<div class=" container">


<div class="form-group">
  <label for="exampleInputEmail1">Email address</label>
  <div class="row"><input type="email" class="form-control col" id="mail" name=mail aria-describedby="emailHelp" placeholder="Enter email">
  <div class="col-sm-5"></div>
  </div>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">Password</label>
  <div class="row">
    <input type="password" class="form-control col" id="mdp" name=mdp placeholder="Password">
    <button type="button" class="col-sm-5 btn btn-secondary" onclick="send()">Envoie mot de passe</button>
  </div>
</div>
<div class="container text-center">
<button onClick="login()" class="btn btn-primary m-2 row">Submit</button>
<div class="erreur row text-danger"></div>
</div>

</div>';

}



?>