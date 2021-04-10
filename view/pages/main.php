<?php
include '../../controller/getPages.php';

session_start();
if (!(isset($_SESSION["mail"]) && isset($_SESSION["mdp"]))) {
  header("Location: ../../index.php");
}

?>

<html lang="fr">

<head>
  <meta charset="utf-8">

  <title>Projet Ballotin</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="./canvasJS/canvasjs.min.js"></script>
  <script src="./js/createVote.js"></script>
  <script src="./js/manage.js"></script>
  <script src="./js/vote.js"></script>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="../../css/styles.css">

</head>

<body class="bg-dark" onload="home()">
  <div class="h-100 container bg-light">
  <nav class="navbar p-2  navbar-light bg-light">
        <a class="navbar-brand" id="owner" href="#"><?php echo $_SESSION["mail"] ?> </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" onclick="home()">Home </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" onclick="voteList()">Voter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" onclick="manageList()">Gérer un vote</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" onclick="initCreate()">Créer un vote</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  onclick="disconnect()">Se deconnecter</a>
            </li>


        </div>
      </nav>
      <div class="container body bg-light">
      </div>



</body>

<script>
const regexmail = new RegExp('.?@.?\..*');
  let erreur = $(".erreur")[0];

function home(){
  $.ajax({
        method: "GET",
        url: "./home.php",
        data: {
          "home": true
        }
      }).done(function(e) {
        $(".body")[0].innerHTML = e;
    
      }).fail(function(e) {
        console.log(e);
        $("body").append(e.responseText);
        error = e;
      }); 
}
function disconnect(){
  $.ajax({
        method: "GET",
        url: "../../controller/getPages.php",
        data: {
          "disconnect": true
        }
      }).done(function(e) {
        window.location = window.location;
    
      }).fail(function(e) {
        console.log(e);
        $("body").append(e.responseText);
        error = e;
      });
  $.get('../../controller/disconnect.php', function() {
    
  });



}



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