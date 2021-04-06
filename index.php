<?php
require "./controller/account.php";
$result = "";
session_start();

if (isset($_POST["mail"]) && isset($_POST["mdp"])) {
  $result = login($_post["mail"], $_post["mdp"]);
  echo $result;
  if ($result == TRUE) {
    $_SESSION["mail"] = $_POST["mail"];
    $_SESSION["mdp"] = $_POST["mdp"];
  }
}
if (isset($_SESSION["mail"]) && isset($_SESSION["mdp"])) {
  header("Location: view/pages/home.php");
}




?>


<html lang="fr">

<head>
  <meta charset="utf-8">

  <title>Projet Ballotin</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
  <div class="h-100 container-fluid bg-dark">
    <div class="container bg-light">
      <div class=" container">
        <form method="POST" action="index.php">

          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="mail" name=mail aria-describedby="emailHelp" placeholder="Enter email">

          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <div class="row">
              <input type="password" class="form-control col" id="mdp" name=mdp placeholder="Password">
              <button type="button" class="col" onclick="send()">Envoie mot de passe</button>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
          <div class="erreur"></div>
        </form>
      </div>
    </div>



  </div>


</body>
<script>
  const regexmail = new RegExp('.?@.?\..*');
  let erreur = $(".erreur")[0];

  function send() {
    let mail = $("#mail")[0].value
    if (!mail) {
      erreur.innerText = "Pas de mail indiquer";
    } else if (!regexmail.test(mail)) {
      erreur.innerText = "Ce n'est pas un mail";
    } else {
      $.ajax({
        method: "POST",
        url: "controller/traitement.php",
        dataType: "json",
        data: {
          "mail": mail
        }
      }).done(function(e) {
        console.log("success")
        erreur.innerText = 'Mot de passe envoyé';

      }).fail(function(e) {
        console.log(e);
        $("body").append(e.responseText);
        error = e;
      });
    }


  }

  function login() {
    let mail = $("#mail")[0].value;
    let mdp = $("#mdp")[0].value
    if (!mail) {
      erreur.innerText = "Pas de mail indiquer";
    } else if (!regexmail.test(mail)) {
      erreur.innerText = "Ce n'est pas un mail";
    } else if (!mdp) {
      erreur.innerText = "Pas de mot de pass indiquer"
    }

  }
</script>

</html>